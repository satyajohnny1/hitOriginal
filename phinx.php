<?php
declare(strict_types=1);

if (!defined('PHINX_CONFIG_LOADED')) {
    define('PHINX_CONFIG_LOADED', true);
}

include __DIR__ . '/db.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'schema_version',
        'default_environment' => 'production',
        'production' => [
            'adapter' => 'mysql',
            'host' => $servername,
            'name' => $dbname,
            'user' => $username,
            'pass' => $password,
            'port' => $dbport,
            'charset' => 'utf8mb4'
        ]
    ],
    'version_order' => 'creation'
];
