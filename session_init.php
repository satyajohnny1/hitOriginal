<?php
if (session_status() === PHP_SESSION_ACTIVE) return;

require_once __DIR__ . '/db.php';

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

$createSQL = "CREATE TABLE IF NOT EXISTS db_sessions (
    sess_id VARCHAR(128) NOT NULL PRIMARY KEY,
    sess_data MEDIUMBLOB NOT NULL,
    sess_time INT(10) UNSIGNED NOT NULL,
    sess_lifetime INT(10) UNSIGNED NOT NULL,
    INDEX idx_time (sess_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
@mysqli_query($conn, $createSQL);

function db_session_open($savePath, $sessionName) { return true; }

function db_session_close() { return true; }

function db_session_read($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $result = mysqli_query($conn, "SELECT sess_data, sess_lifetime FROM db_sessions WHERE sess_id = '$id' LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        if (time() - $row['sess_time'] < $row['sess_lifetime']) {
            return $row['sess_data'];
        }
        mysqli_query($conn, "DELETE FROM db_sessions WHERE sess_id = '$id'");
    }
    return '';
}

function db_session_write($id, $data) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $data = mysqli_real_escape_string($conn, $data);
    $time = time();
    $lifetime = 72 * 60 * 60;
    $exists = mysqli_query($conn, "SELECT 1 FROM db_sessions WHERE sess_id = '$id' LIMIT 1");
    if ($exists && mysqli_num_rows($exists) > 0) {
        mysqli_query($conn, "UPDATE db_sessions SET sess_data='$data', sess_time=$time, sess_lifetime=$lifetime WHERE sess_id='$id'");
    } else {
        mysqli_query($conn, "INSERT INTO db_sessions (sess_id, sess_data, sess_time, sess_lifetime) VALUES ('$id', '$data', $time, $lifetime)");
    }
    return true;
}

function db_session_destroy($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    mysqli_query($conn, "DELETE FROM db_sessions WHERE sess_id = '$id'");
    return true;
}

function db_session_gc($maxLifetime) {
    global $conn;
    $boundary = time() - $maxLifetime;
    mysqli_query($conn, "DELETE FROM db_sessions WHERE sess_time < $boundary");
    return true;
}

session_set_save_handler('db_session_open', 'db_session_close', 'db_session_read', 'db_session_write', 'db_session_destroy', 'db_session_gc');
register_shutdown_function('session_write_close');
session_start();
