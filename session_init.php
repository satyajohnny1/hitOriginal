<?php
if (session_status() === PHP_SESSION_ACTIVE) return;

require_once __DIR__ . '/env.php';

$cookie_lifetime = 72 * 60 * 60;
ini_set('session.gc_maxlifetime', $cookie_lifetime);
ini_set('session.save_handler', 'user');

session_set_cookie_params([
    'lifetime' => $cookie_lifetime,
    'path'     => '/',
    'domain'   => '',
    'secure'   => false,
    'httponly'  => false,
    'samesite' => 'Lax',
]);

function _sess_conn() {
    static $c = null;
    if ($c === null || !$c) {
        $host = env('DB_HOST');
        $db   = env('DB_NAME');
        $user = env('DB_USER');
        $pass = env('DB_PASS');
        $port = (int) env('DB_PORT', '3306');
        $c = @mysqli_connect($host, $user, $pass, $db, $port);
    }
    return $c;
}

$sc = _sess_conn();
if ($sc) {
    @mysqli_query($sc, "CREATE TABLE IF NOT EXISTS db_sessions (
        sess_id VARCHAR(128) NOT NULL PRIMARY KEY,
        sess_data MEDIUMBLOB NOT NULL,
        sess_time INT(10) UNSIGNED NOT NULL,
        sess_lifetime INT(10) UNSIGNED NOT NULL,
        INDEX idx_time (sess_time)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function db_session_open($savePath, $sessionName) { return true; }
function db_session_close() { return true; }

function db_session_read($id) {
    $c = _sess_conn();
    if (!$c) return '';
    $id = mysqli_real_escape_string($c, $id);
    $result = mysqli_query($c, "SELECT sess_data, sess_lifetime, sess_time FROM db_sessions WHERE sess_id = '$id' LIMIT 1");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        if (time() - $row['sess_time'] < $row['sess_lifetime']) {
            return $row['sess_data'];
        }
        mysqli_query($c, "DELETE FROM db_sessions WHERE sess_id = '$id'");
    }
    return '';
}

function db_session_write($id, $data) {
    $c = _sess_conn();
    if (!$c) return false;
    $id = mysqli_real_escape_string($c, $id);
    $data = mysqli_real_escape_string($c, $data);
    $time = time();
    $lifetime = 72 * 60 * 60;
    $exists = @mysqli_query($c, "SELECT 1 FROM db_sessions WHERE sess_id = '$id' LIMIT 1");
    if ($exists && mysqli_num_rows($exists) > 0) {
        mysqli_query($c, "UPDATE db_sessions SET sess_data='$data', sess_time=$time, sess_lifetime=$lifetime WHERE sess_id='$id'");
    } else {
        mysqli_query($c, "INSERT INTO db_sessions (sess_id, sess_data, sess_time, sess_lifetime) VALUES ('$id', '$data', $time, $lifetime)");
    }
    return true;
}

function db_session_destroy($id) {
    $c = _sess_conn();
    if (!$c) return false;
    $id = mysqli_real_escape_string($c, $id);
    mysqli_query($c, "DELETE FROM db_sessions WHERE sess_id = '$id'");
    return true;
}

function db_session_gc($maxLifetime) {
    $c = _sess_conn();
    if (!$c) return false;
    $boundary = time() - $maxLifetime;
    mysqli_query($c, "DELETE FROM db_sessions WHERE sess_time < $boundary");
    return true;
}

session_set_save_handler('db_session_open', 'db_session_close', 'db_session_read', 'db_session_write', 'db_session_destroy', 'db_session_gc');
register_shutdown_function('session_write_close');
session_start();
