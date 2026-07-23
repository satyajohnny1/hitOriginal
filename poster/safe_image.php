<?php
// Guards against missing/corrupt source images (e.g. an actor photo that was
// never uploaded to this environment) so poster generation degrades to a
// blank placeholder instead of a fatal TypeError from imagesavealpha()/
// imagealphablending() receiving `false` from a failed imagecreatefrompng().

if (!function_exists('safe_imagecreatefrompng')) {
    function safe_imagecreatefrompng(string $path, int $width = 400, int $height = 400): \GdImage {
        if (is_file($path)) {
            $img = @imagecreatefrompng($path);
            if ($img !== false) {
                return $img;
            }
        }
        error_log("safe_imagecreatefrompng: missing/unreadable PNG '$path', using blank placeholder");
        $placeholder = imagecreatetruecolor($width, $height);
        imagesavealpha($placeholder, true);
        $transparent = imagecolorallocatealpha($placeholder, 0, 0, 0, 127);
        imagefill($placeholder, 0, 0, $transparent);
        return $placeholder;
    }
}

if (!function_exists('safe_imagecreatefromjpeg')) {
    function safe_imagecreatefromjpeg(string $path, int $width = 1000, int $height = 1500): \GdImage {
        if (is_file($path)) {
            $img = @imagecreatefromjpeg($path);
            if ($img !== false) {
                return $img;
            }
        }
        error_log("safe_imagecreatefromjpeg: missing/unreadable JPEG '$path', using blank placeholder");
        $placeholder = imagecreatetruecolor($width, $height);
        $gray = imagecolorallocate($placeholder, 40, 40, 40);
        imagefill($placeholder, 0, 0, $gray);
        return $placeholder;
    }
}
