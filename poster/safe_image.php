<?php
// Guards against missing/corrupt source images so poster generation degrades to a
// blank placeholder instead of a fatal TypeError.

if (!function_exists('safe_imagecreatefrompng')) {
    function safe_imagecreatefrompng(string $path, int $width = 400, int $height = 400): \GdImage {
        error_log("SAFE_PNG: trying path=$path");
        if (is_file($path)) {
            error_log("SAFE_PNG: file exists, attempting imagecreatefrompng");
            $img = @imagecreatefrompng($path);
            if ($img !== false) {
                error_log("SAFE_PNG: success path=$path");
                return $img;
            }
            error_log("SAFE_PNG: imagecreatefrompng returned false for $path");
        } else {
            error_log("SAFE_PNG: file NOT found: $path");
        }
        error_log("SAFE_PNG: using blank placeholder for $path");
        $placeholder = imagecreatetruecolor($width, $height);
        imagesavealpha($placeholder, true);
        $transparent = imagecolorallocatealpha($placeholder, 0, 0, 0, 127);
        imagefill($placeholder, 0, 0, $transparent);
        return $placeholder;
    }
}

if (!function_exists('safe_imagecreatefromjpeg')) {
    function safe_imagecreatefromjpeg(string $path, int $width = 1000, int $height = 1500): \GdImage {
        error_log("SAFE_JPG: trying path=$path");
        if (is_file($path)) {
            error_log("SAFE_JPG: file exists, attempting imagecreatefromjpeg");
            $img = @imagecreatefromjpeg($path);
            if ($img !== false) {
                error_log("SAFE_JPG: success path=$path");
                return $img;
            }
            error_log("SAFE_JPG: imagecreatefromjpeg returned false for $path");
        } else {
            error_log("SAFE_JPG: file NOT found: $path");
        }
        error_log("SAFE_JPG: using blank placeholder for $path");
        $placeholder = imagecreatetruecolor($width, $height);
        $gray = imagecolorallocate($placeholder, 40, 40, 40);
        imagefill($placeholder, 0, 0, $gray);
        return $placeholder;
    }
}
