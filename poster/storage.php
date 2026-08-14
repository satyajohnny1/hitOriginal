<?php
// Unified poster storage layer. Backend is chosen by the POSTER_STORAGE
// config value: "cloudinary" -> Cloudinary CDN, anything else / empty /
// missing -> local filesystem (poster/done).

require_once __DIR__ . '/../env.php';
require_once __DIR__ . '/cloudinary_client.php';

if (!function_exists('poster_storage_config')) {
    function poster_storage_config() {
        static $mode = null;
        static $resolved = false;
        if ($resolved) return $mode;
        $resolved = true;

        $val = env('POSTER_STORAGE');
        if ($val === null || $val === '') $val = env('poster-storage');
        if ($val === null || $val === '') $val = env('poster_storage');

        $mode = strtolower(trim((string) $val));
        if ($mode !== 'cloudinary' && $mode !== 'cld') $mode = 'filesystem';
        return $mode;
    }
}

if (!function_exists('poster_storage_backend')) {
    function poster_storage_backend() {
        return poster_storage_config();
    }
}

if (!function_exists('poster_storage_done_dir')) {
    function poster_storage_done_dir() {
        return __DIR__ . '/done';
    }
}

if (!function_exists('poster_storage_save')) {
    function poster_storage_save(string $filename, string $bytes) {
        if (poster_storage_config() === 'cloudinary') {
            $publicId = cloudinary_clean_public_id($filename);
            $res = cloudinary_upload($publicId, $bytes);
            if ($res) {
                cloudinary_store_version($publicId, (string) ($res['version'] ?? ''));
                return true;
            }
            error_log("POSTER_STORAGE: cloudinary upload failed for $filename, falling back to filesystem");
        }

        $dir = poster_storage_done_dir();
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        return @file_put_contents($dir . '/' . $filename, $bytes) !== false;
    }
}

if (!function_exists('poster_storage_exists')) {
    function poster_storage_exists(string $filename) {
        if (poster_storage_config() === 'cloudinary') {
            return cloudinary_exists(cloudinary_clean_public_id($filename));
        }
        return is_file(poster_storage_done_dir() . '/' . $filename);
    }
}

if (!function_exists('poster_storage_url')) {
    function poster_storage_url(string $filename) {
        if (poster_storage_config() === 'cloudinary') {
            return cloudinary_public_url($filename);
        }
        return poster_storage_done_dir() . '/' . $filename;
    }
}

// Browser-usable URL for a generated poster. Cloudinary -> versioned CDN URL,
// filesystem -> web-relative path so <img> tags can load it directly.
if (!function_exists('poster_storage_web_url')) {
    function poster_storage_web_url(string $filename) {
        if (poster_storage_config() === 'cloudinary') {
            return cloudinary_public_url($filename);
        }
        return 'poster/done/' . rawurlencode($filename);
    }
}

// Canonical poster filename for a movie: MAIN -> "TITLE<rid>.jpeg", others ->
// "TITLE<rid>_<type>.jpeg" (type in 50,75,100,150,175). Matches poster-v2.php.
if (!function_exists('poster_filename_for')) {
    function poster_filename_for(string $title, $rid, string $type): string {
        $base = strtoupper(trim($title) . (string) $rid);
        if ($type === 'main') {
            return $base . '.jpeg';
        }
        return $base . '_' . $type . '.jpeg';
    }
}
