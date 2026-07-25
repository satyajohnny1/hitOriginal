<?php
include __DIR__ . "/../session_init.php";
require_once __DIR__ . '/../db.php';

$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';
error_log("SERVE[1]: start rid=$rid type=$type");

$valid_types = ['main','50','75','100','150','175'];
if ($rid <= 0 || !in_array($type, $valid_types)) {
	error_log("SERVE[ERR]: bad params rid=$rid type=$type");
	header("HTTP/1.0 400 Bad Request");
	exit("Missing or invalid parameters");
}
error_log("SERVE[2]: params OK rid=$rid type=$type");

$sql = "SELECT s.title, s.dname, s.aname, s.acname, s.cinename, s.ediname, s.musname, s.wriname,
               s.a2_name, s.a3_name, s.ac2_name, s.ac3_name, s.d2_name, s.d3_name,
               s.m2_name, s.m3_name, s.w2_name, s.w3_name, s.notes,
               r.`50d_cen`, r.`75d_cen`, r.`100d_cen`, r.`150d_cen`, r.`175d_cen`, r.`25d_cen`
        FROM tolly_ready_for_shoot s
        LEFT JOIN tolly_release r ON r.rid = s.rid
        WHERE s.rid = $rid LIMIT 1";
$result = @mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
	error_log("SERVE[ERR]: movie not found rid=$rid");
	header("HTTP/1.0 404 Not Found");
	exit("Movie not found");
}
$row = mysqli_fetch_assoc($result);
error_log("SERVE[3]: DB OK title=" . ($row['title'] ?? 'NULL'));

$upp = strtoupper($row['title'] . $rid);

if ($type === 'main') {
	$filename = $upp . ".jpeg";
} else {
	$filename = $upp . "_" . $type . ".jpeg";
}

$file_path = __DIR__ . '/done/' . $filename;
error_log("SERVE[4]: file_path=$file_path exists=" . (file_exists($file_path) ? 'YES' : 'NO'));

if (!file_exists($file_path)) {
	error_log("SERVE[4b]: file missing, serving placeholder rid=$rid type=$type");
	header("Content-Type: image/png");
	header("Cache-Control: no-cache, must-revalidate");
	$ph = imagecreatetruecolor(200, 300);
	$bg = imagecolorallocate($ph, 220, 220, 220);
	imagefill($ph, 0, 0, $bg);
	imagepng($ph);
	imagedestroy($ph);
	exit;
}

error_log("SERVE[7]: serving $file_path size=" . filesize($file_path));
header("Content-Type: image/jpeg");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
readfile($file_path);
error_log("SERVE[8]: done");
exit;
