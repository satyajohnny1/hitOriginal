<?php
// Minimal Cloudinary client built on cURL (no external dependencies).
// Credentials come from CLOUDINARY_URL=cloudinary://<api_key>:<api_secret>@<cloud_name>.

require_once __DIR__ . '/../env.php';

if (!function_exists('cloudinary_config')) {
    function cloudinary_config() {
        static $cfg = null;
        static $resolved = false;
        if ($resolved) return $cfg;
        $resolved = true;

        $url = trim((string) env('CLOUDINARY_URL', ''));
        if ($url === '') return null;

        $u = @parse_url($url);
        if (!$u || empty($u['host'])) return null;

        $key    = urldecode($u['user'] ?? '');
        $secret = urldecode($u['pass'] ?? '');
        if ($u['host'] === '' || $key === '' || $secret === '') return null;

        $cfg = [
            'cloud_name' => $u['host'],
            'api_key'    => $key,
            'api_secret' => $secret,
        ];
        return $cfg;
    }
}

if (!function_exists('cloudinary_clean_public_id')) {
    function cloudinary_clean_public_id(string $name) {
        return preg_replace('/\.jpe?g$/i', '', $name);
    }
}

if (!function_exists('cloudinary_upload')) {
    function cloudinary_upload(string $publicId, string $bytes) {
        $cfg = cloudinary_config();
        if (!$cfg || $bytes === '') return false;

        $tmp = tempnam(sys_get_temp_dir(), 'cld');
        if ($tmp === false) return false;
        file_put_contents($tmp, $bytes);

        $post = [
            'file'          => new CURLFile($tmp, 'image/jpeg', 'poster.jpg'),
            'public_id'     => $publicId,
            'overwrite'     => 'true',
            'resource_type' => 'image',
        ];

        $ch = curl_init('https://api.cloudinary.com/v1_1/' . $cfg['cloud_name'] . '/image/upload');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $cfg['api_key'] . ':' . $cfg['api_secret']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $resp = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);
        @unlink($tmp);

        if ($code < 200 || $code >= 300) {
            error_log("CLOUDINARY[upload]: HTTP $code curl=$err resp=" . substr((string) $resp, 0, 300));
            return false;
        }

        $json = json_decode((string) $resp, true);
        if (empty($json['secure_url'])) {
            error_log("CLOUDINARY[upload]: missing secure_url for $publicId");
            return false;
        }

        return [
            'public_id'  => $json['public_id'] ?? $publicId,
            'version'    => (string) ($json['version'] ?? ''),
            'secure_url' => $json['secure_url'],
        ];
    }
}

if (!function_exists('cloudinary_exists')) {
    function cloudinary_exists(string $publicId) {
        $cfg = cloudinary_config();
        if (!$cfg) return false;

        $publicId = cloudinary_clean_public_id($publicId);
        $url = 'https://api.cloudinary.com/v1_1/' . $cfg['cloud_name']
             . '/resources/image/upload/' . rawurlencode($publicId);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $cfg['api_key'] . ':' . $cfg['api_secret']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code === 200;
    }
}

if (!function_exists('cloudinary_versions')) {
    function cloudinary_versions() {
        $path = __DIR__ . '/.cloudinary_versions.json';
        if (!is_file($path)) return [];
        $raw = @file_get_contents($path);
        $arr = $raw ? json_decode($raw, true) : null;
        return is_array($arr) ? $arr : [];
    }
}

if (!function_exists('cloudinary_store_version')) {
    function cloudinary_store_version(string $publicId, string $version) {
        if ($version === '') return;
        $arr = cloudinary_versions();
        $arr[$publicId] = $version;
        @file_put_contents(__DIR__ . '/.cloudinary_versions.json', json_encode($arr), LOCK_EX);
    }
}

if (!function_exists('cloudinary_public_url')) {
    function cloudinary_public_url(string $filename) {
        $cfg = cloudinary_config();
        if (!$cfg) return '';

        $publicId = cloudinary_clean_public_id($filename);
        $version  = (string) (cloudinary_versions()[$publicId] ?? '');

        $url = 'https://res.cloudinary.com/' . $cfg['cloud_name'] . '/image/upload';
        if ($version !== '') $url .= '/v' . $version;
        return $url . '/' . rawurlencode($publicId) . '.jpg';
    }
}
