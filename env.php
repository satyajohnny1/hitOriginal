<?php
// Loads KEY=VALUE pairs from .env into getenv()/$_ENV, without overwriting
// variables the host environment already provides.

if (!function_exists('load_env')) {
    function load_env(string $path): void {
        static $loaded = false;
        if ($loaded || !is_file($path)) {
            return;
        }
        $loaded = true;

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (!str_contains($line, '=')) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (strlen($value) >= 2 && (
                ($value[0] === '"' && $value[-1] === '"') ||
                ($value[0] === "'" && $value[-1] === "'")
            )) {
                $value = substr($value, 1, -1);
            }

            if (getenv($key) === false) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}

load_env(__DIR__ . '/.env');

if (!function_exists('env')) {
    function env(string $key, ?string $default = null): ?string {
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }
        return $_ENV[$key] ?? $default;
    }
}
