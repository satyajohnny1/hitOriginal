<?php
session_start();
require_once __DIR__ . '/../db.php';

$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

$valid_types = ['main','50','75','100','150','175'];
if ($rid <= 0 || !in_array($type, $valid_types)) {
	header("HTTP/1.0 400 Bad Request");
	exit("Missing or invalid parameters");
}

$sql = "SELECT s.title, s.dname, s.aname, s.acname, s.cinename, s.ediname, s.musname, s.wriname,
               s.a2_name, s.a3_name, s.ac2_name, s.ac3_name, s.d2_name, s.d3_name,
               s.m2_name, s.m3_name, s.w2_name, s.w3_name,
               r.`50d_cen`, r.`75d_cen`, r.`100d_cen`, r.`150d_cen`, r.`175d_cen`, r.`25d_cen`
        FROM tolly_ready_for_shoot s
        LEFT JOIN tolly_release r ON r.rid = s.rid
        WHERE s.rid = $rid LIMIT 1";
$result = @mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
	header("HTTP/1.0 404 Not Found");
	exit("Movie not found");
}
$row = mysqli_fetch_assoc($result);

$upp = strtoupper($row['title'] . $rid);

if ($type === 'main') {
	$filename = $upp . ".jpeg";
} else {
	$filename = $upp . "_" . $type . ".jpeg";
}

$file_path = __DIR__ . '/done/' . $filename;

if (!file_exists($file_path)) {
	$_GET['rid'] = $rid;
	$_GET['tit'] = $upp;
	$_GET['b']   = $_SESSION['s_banner'] ?? '';
	$_GET['p']   = $_SESSION['s_user'] ?? '';
	$_GET['d']   = $row['dname'];
	$_GET['a']   = $row['aname'];
	$_GET['ac']  = $row['acname'];
	$_GET['c']   = $row['cinename'];
	$_GET['e']   = $row['ediname'];
	$_GET['m']   = $row['musname'];
	$_GET['w']   = $row['wriname'];
	$_GET['fif'] = intval($row['50d_cen'] ?? 0);
	$_GET['hun'] = intval($row['100d_cen'] ?? 0);
	$_GET['fiv'] = intval($row['175d_cen'] ?? 0);
	$_GET['t5']  = intval($row['25d_cen'] ?? 0);
	$_GET['sev'] = intval($row['75d_cen'] ?? 0);
	$_GET['onf'] = intval($row['150d_cen'] ?? 0);
	$_GET['a2']  = $row['a2_name'] ?? '';
	$_GET['a3']  = $row['a3_name'] ?? '';
	$_GET['ac2'] = $row['ac2_name'] ?? '';
	$_GET['ac3'] = $row['ac3_name'] ?? '';
	$_GET['d2']  = $row['d2_name'] ?? '';
	$_GET['d3']  = $row['d3_name'] ?? '';
	$_GET['m2']  = $row['m2_name'] ?? '';
	$_GET['m3']  = $row['m3_name'] ?? '';
	$_GET['w2']  = $row['w2_name'] ?? '';
	$_GET['w3']  = $row['w3_name'] ?? '';

	ob_start();
	include __DIR__ . '/poster-v2.php';
	ob_end_clean();
}

if (!file_exists($file_path)) {
	header("HTTP/1.0 404 Not Found");
	exit("Poster not found");
}

header("Content-Type: image/jpeg");
header("Cache-Control: public, max-age=604800");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 604800) . " GMT");
readfile($file_path);
exit;
