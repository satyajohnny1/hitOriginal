<?php
require_once __DIR__ . '/safe_image.php';

function clean($string) {
	$string = str_replace(' ', '', $string);
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function safeGET($key) {
	return isset($_GET[$key]) ? $_GET[$key] : '';
}

$tit = strtoupper(safeGET("tit"));
$rid = safeGET("rid");
$type = safeGET("type");

$valid_types = ['main','50','75','100','150','175'];
if (empty($tit) || empty($rid) || !in_array($type, $valid_types)) {
	header("HTTP/1.0 400 Bad Request");
	exit("Missing or invalid parameters");
}

if ($type === 'main') {
	$filename = $tit . $rid . ".jpeg";
} else {
	$filename = $tit . $rid . "_" . $type . ".jpeg";
}

$file_path = __DIR__ . '/done/' . $filename;

if (!file_exists($file_path)) {
	$b   = strtoupper(safeGET("b"));
	$p   = strtoupper(safeGET("p"));
	$d   = strtoupper(safeGET("d"));
	$a   = safeGET("a");
	$ac  = strtoupper(safeGET("ac"));
	$c   = strtoupper(safeGET("c"));
	$e   = strtoupper(safeGET("e"));
	$m   = strtoupper(safeGET("m"));
	$w   = strtoupper(safeGET("w"));
	$fif = intval(safeGET("fif"));
	$hun = intval(safeGET("hun"));
	$fiv = intval(safeGET("fiv"));
	$t5  = intval(safeGET("t5"));
	$sev = intval(safeGET("sev"));
	$onf = intval(safeGET("onf"));
	$a2  = strtoupper(safeGET("a2"));
	$a3  = strtoupper(safeGET("a3"));
	$ac2 = strtoupper(safeGET("ac2"));
	$ac3 = strtoupper(safeGET("ac3"));
	$w2  = strtoupper(safeGET("w2"));
	$w3  = strtoupper(safeGET("w3"));
	$d2  = strtoupper(safeGET("d2"));
	$d3  = strtoupper(safeGET("d3"));
	$m2  = strtoupper(safeGET("m2"));
	$m3  = strtoupper(safeGET("m3"));

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
