<?php

if (!function_exists('clean')) {
	function clean($string) {
		$string = str_replace(' ', '', $string);
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
}

if (!function_exists('safeGET')) {
	function safeGET($key) {
		return isset($_GET[$key]) ? $_GET[$key] : '';
	}
}

if (!function_exists('drawHero')) {
	function drawHero($jpg_image, $heroimg, $x) {
		error_log("POSTER[7a]: drawHero heroimg=$heroimg x=$x");
		$img = safe_imagecreatefrompng($heroimg, 400, 400);
		imagesavealpha($img, true);
		imagealphablending($img, true);
		imagecopy($jpg_image, $img, $x, 0, 0, 0, 400, 400);
		imagedestroy($img);
		error_log("POSTER[7b]: drawHero done x=$x");
	}
}

if (!function_exists('poster_base_canvas')) {
	// Force an exact 1200x800 canvas so every poster is consistent, regardless
	// of the source background's native dimensions.
	function poster_base_canvas($bgPath) {
		$src = safe_imagecreatefromjpeg($bgPath, 1200, 800);
		$canvas = imagecreatetruecolor(1200, 800);
		imagecopyresampled($canvas, $src, 0, 0, 0, 0, 1200, 800, imagesx($src), imagesy($src));
		imagedestroy($src);
		return $canvas;
	}
}

error_log("POSTER[1]: start");

require_once __DIR__ . '/safe_image.php';
require_once __DIR__ . '/storage.php';

@mkdir(__DIR__ . '/done', 0755, true);

$base = __DIR__;

$b   = strtoupper(safeGET("b"));
$p   = strtoupper(safeGET("p"));
$d   = strtoupper(safeGET("d"));
$a   = safeGET("a");
$ac  = strtoupper(safeGET("ac"));
$c   = strtoupper(safeGET("c"));
$e   = strtoupper(safeGET("e"));
$m   = strtoupper(safeGET("m"));
$w   = strtoupper(safeGET("w"));
$tit = strtoupper(safeGET("tit"));
$rid = safeGET("rid");
$disp_title = safeGET("raw_title");
if (empty($disp_title)) $disp_title = $tit;
if ($rid !== '' && substr($tit, -strlen($rid)) !== $rid) {
	$tit .= $rid;
}
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

error_log("POSTER[3]: GET parsed rid=$rid tit=$tit a=$a a2=$a2 a3=$a3");

$hero_count = 1;
if (strlen($a3) > 1) $hero_count = 3;
elseif (strlen($a2) > 1) $hero_count = 2;
error_log("POSTER[4]: hero_count=$hero_count");

$bg   = $base . "/bg/bg" . rand(1, 35) . ".jpg";
$fnt  = $base . "/fonts/" . rand(1, 30) . ".ttf";
$tfnt = $base . "/fonts/" . rand(14, 122) . ".ttf";

$file_main     = $tit . ".jpeg";
$file_50       = $tit . "_50.jpeg";
$file_75       = $tit . "_75.jpeg";
$file_100      = $tit . "_100.jpeg";
$file_150      = $tit . "_150.jpeg";
$file_175      = $tit . "_175.jpeg";

$path     = $base . '/done/' . $file_main;
$path_50  = $base . '/done/' . $file_50;
$path_75  = $base . '/done/' . $file_75;
$path_100 = $base . '/done/' . $file_100;
$path_150 = $base . '/done/' . $file_150;
$path_175 = $base . '/done/' . $file_175;
$ori      = $path;

error_log("POSTER[5]: paths set bg=$bg fnt=$fnt");

$jpg_image = poster_base_canvas($bg);
error_log("POSTER[6]: base image created type=" . gettype($jpg_image));

$num = rand(1, 50);
$bclr = imagecolorallocate($jpg_image, 255, 255, 255);
$tclr = imagecolorallocate($jpg_image, 255, 255, 255);
$cclr = imagecolorallocate($jpg_image, 255, 255, 255);

if ($num >= 1 && $num < 10) {
	$bclr = imagecolorallocate($jpg_image, 255, 255, 255);
	$tclr = imagecolorallocate($jpg_image, 252, 232, 3);
	$cclr = imagecolorallocate($jpg_image, 255, 255, 255);
} elseif ($num >= 10 && $num < 20) {
	$bclr = imagecolorallocate($jpg_image, 255, 255, 255);
	$tclr = imagecolorallocate($jpg_image, 206, 255, 71);
	$cclr = imagecolorallocate($jpg_image, 255, 255, 255);
} elseif ($num >= 20 && $num < 30) {
	$bclr = imagecolorallocate($jpg_image, 255, 255, 255);
	$tclr = imagecolorallocate($jpg_image, 80, 255, 71);
	$cclr = imagecolorallocate($jpg_image, 255, 255, 255);
} elseif ($num >= 30 && $num < 40) {
	$bclr = imagecolorallocate($jpg_image, 255, 255, 255);
	$tclr = imagecolorallocate($jpg_image, 245, 15, 15);
	$cclr = imagecolorallocate($jpg_image, 252, 252, 109);
} elseif ($num >= 40 && $num < 50) {
	$bclr = imagecolorallocate($jpg_image, 252, 252, 109);
	$tclr = imagecolorallocate($jpg_image, 71, 169, 255);
	$cclr = imagecolorallocate($jpg_image, 255, 255, 255);
}

error_log("POSTER[7]: colors set num=$num");

if ($hero_count === 1) {
	drawHero($jpg_image, $base . "/actors/" . clean(strtolower($a)) . ".png", 400);
} elseif ($hero_count === 2) {
	drawHero($jpg_image, $base . "/actors/" . clean(strtolower($a)) . ".png", 575);
	drawHero($jpg_image, $base . "/actors/" . clean(strtolower($a2)) . ".png", 225);
} else {
	drawHero($jpg_image, $base . "/actors/" . clean(strtolower($a)) . ".png", 390);
	drawHero($jpg_image, $base . "/actors/" . clean(strtolower($a2)) . ".png", 160);
	drawHero($jpg_image, $base . "/actors/" . clean(strtolower($a3)) . ".png", 640);
}
error_log("POSTER[8]: heroes drawn");

$hit_img = safe_imagecreatefrompng($base . "/actors/hit.png", 190, 190);
imagesavealpha($hit_img, true);
imagealphablending($hit_img, true);
imagecopy($jpg_image, $hit_img, 0, 60, 0, 0, 190, 190);
imagedestroy($hit_img);
error_log("POSTER[9]: hit logo done");

@imagettftext($jpg_image, 22, 0, 10, 55, $bclr, $fnt, $b);
error_log("POSTER[10]: banner text");

$actor_text = $a;
if ($hero_count === 2) $actor_text = $a . ' - ' . $a2;
if ($hero_count === 3) $actor_text = $a . ' - ' . $a2 . ' - ' . $a3;
if (!empty($ac)) $actor_text .= ' - ' . $ac;
$actor_box = @imagettfbbox(17, 0, $fnt, $actor_text);
$actor_w = abs($actor_box[4] - $actor_box[0]);
$actor_x = intval((1200 - $actor_w) / 2);
@imagettftext($jpg_image, 17, 0, $actor_x, 390, $cclr, $fnt, $actor_text);
error_log("POSTER[11]: actor text");

$ul_box = @imagettfbbox(35, 0, $fnt, "______________________________________");
$ul_w = abs($ul_box[4] - $ul_box[0]);
$ul_x = intval((1200 - $ul_w) / 2);
@imagettftext($jpg_image, 35, 0, $ul_x, 395, $tclr, $fnt, "______________________________________");

$title_max_w = 760;
$title_fonsiz = 80;
$title_box = @imagettfbbox($title_fonsiz, 0, $tfnt, $disp_title);
$title_w = abs($title_box[4] - $title_box[0]);
while ($title_w > $title_max_w && $title_fonsiz > 30) {
	$title_fonsiz -= 2;
	$title_box = @imagettfbbox($title_fonsiz, 0, $tfnt, $disp_title);
	$title_w = abs($title_box[4] - $title_box[0]);
}
$title_x = intval((1200 - $title_w) / 2);
@imagettftext($jpg_image, $title_fonsiz, 0, $title_x, 490, $tclr, $tfnt, $disp_title);
error_log("POSTER[12]: title text size=$title_fonsiz width=$title_w");

$ul2_box = @imagettfbbox(35, 0, $fnt, "______________________________________");
$ul2_w = abs($ul2_box[4] - $ul2_box[0]);
$ul2_x = intval((1200 - $ul2_w) / 2);
@imagettftext($jpg_image, 35, 0, $ul2_x, 500, $tclr, $fnt, "______________________________________");

$fonsiz = 35;
$dir_text = trim($d . '  ' . $d2 . '  ' . $d3);
if (strlen($d2) > 2) $fonsiz = 30;
if (strlen($d3) > 2) $fonsiz = 25;
$dir_box = @imagettfbbox($fonsiz, 0, $fnt, $dir_text);
$dir_w = abs($dir_box[4] - $dir_box[0]);
$dir_max_w = 960;
while ($dir_w > $dir_max_w && $fonsiz > 14) {
	$fonsiz -= 2;
	$dir_box = @imagettfbbox($fonsiz, 0, $fnt, $dir_text);
	$dir_w = abs($dir_box[4] - $dir_box[0]);
}
$dir_x = intval((1200 - $dir_w) / 2);
@imagettftext($jpg_image, $fonsiz, 0, $dir_x, 550, $cclr, $fnt, $dir_text);

$prod_box = @imagettfbbox(28, 0, $fnt, $p);
$prod_w = abs($prod_box[4] - $prod_box[0]);
$prod_x = intval((1200 - $prod_w) / 2);
@imagettftext($jpg_image, 28, 0, $prod_x, 600, $cclr, $fnt, $p);

$crew_text = $m . ' ' . $m2 . ' ' . $m3 . '-' . $w . ' ' . $w2 . ' ' . $w3 . ' - ' . $e . ' - ' . $c;
$crew_box = @imagettfbbox(13, 0, $fnt, $crew_text);
$crew_w = abs($crew_box[4] - $crew_box[0]);
$crew_fonsiz = 13;
while ($crew_w > 860 && $crew_fonsiz > 8) {
	$crew_fonsiz--;
	$crew_box = @imagettfbbox($crew_fonsiz, 0, $fnt, $crew_text);
	$crew_w = abs($crew_box[4] - $crew_box[0]);
}
$crew_x = intval((1200 - $crew_w) / 2);
@imagettftext($jpg_image, $crew_fonsiz, 0, $crew_x, 630, $cclr, $fnt, $crew_text);

$notes_raw = trim(safeGET("notes"));

if (!empty($notes_raw) && $notes_raw !== '-- NOTES--') {
	$codir_text = 'Screenplay, CoDirection - ' . $notes_raw;
	$codir_fonsiz = intval($crew_fonsiz * 1.25);
	if ($codir_fonsiz < 9) $codir_fonsiz = 9;
	$codir_box = @imagettfbbox($codir_fonsiz, 0, $fnt, $codir_text);
	$codir_w = abs($codir_box[4] - $codir_box[0]);
	while ($codir_w > 860 && $codir_fonsiz > 7) {
		$codir_fonsiz--;
		$codir_box = @imagettfbbox($codir_fonsiz, 0, $fnt, $codir_text);
		$codir_w = abs($codir_box[4] - $codir_box[0]);
	}
	$codir_x = intval((1200 - $codir_w) / 2);
	$bright_colors = [
		[255,255,0], [255,0,255], [0,255,255], [255,128,0],
		[128,0,255], [0,255,128], [255,0,128], [128,255,0],
		[0,128,255], [255,200,0], [0,255,200], [200,0,255],
	];
	$bright = $bright_colors[array_rand($bright_colors)];
	$ncr = imagecolorallocate($jpg_image, $bright[0], $bright[1], $bright[2]);
	$codir_y = 630 + $crew_fonsiz + $codir_fonsiz + 4;
	@imagettftext($jpg_image, $codir_fonsiz, 0, $codir_x, $codir_y, $ncr, $fnt, $codir_text);
	error_log("POSTER[13a]: codirection text size=$codir_fonsiz text=$codir_text");
}
error_log("POSTER[13]: all text done title_size=$title_fonsiz dir_size=$fonsiz crew_size=$crew_fonsiz");

error_log("POSTER[14]: saving main to $file_main backend=" . poster_storage_backend());
ob_start();
$jpeg_ok = @imagejpeg($jpg_image, null, 90);
$main_bytes = ob_get_clean();
$main_saved = poster_storage_save($file_main, $main_bytes);
error_log("POSTER[15]: imagejpeg result=" . ($jpeg_ok ? 'OK' : 'FAIL') . " storage=" . ($main_saved ? 'OK' : 'FAIL') . " bytes=" . strlen($main_bytes));

if ($hero_count === 3) {
	$m_day_x = 580;  $m_day_y = 800;
	$m_days_x = 800; $m_days_y = 800; $m_days_sz = 25;
	$m_cen_x = 400;  $m_cen_y = 700;  $m_cen_sz = 30;
	$m_ang = 0;
} else {
	$m_day_x = 780;  $m_day_y = 275;
	$m_days_x = 920; $m_days_y = 320; $m_days_sz = 34;
	$m_cen_x = 850;  $m_cen_y = 55;   $m_cen_sz = 32;
	$m_ang = 0;
}

$milestones = [
	['val' => $fif, 'label' => '50', 'file' => $file_50],
	['val' => $sev, 'label' => '75', 'file' => $file_75],
	['val' => $hun, 'label' => '100', 'file' => $file_100],
	['val' => $onf, 'label' => '150', 'file' => $file_150],
	['val' => $fiv, 'label' => '175', 'file' => $file_175],
];

$ms_count = 0;
foreach ($milestones as $ms) {
	$use_val = $ms['val'];
	$use_label = $ms['label'];

	if ($use_val > 0) {
		$ms_count++;
		error_log("POSTER[16]: milestone $use_label saving to " . $ms['file']);
		$ms_img = imagecreatetruecolor(1200, 800);
		imagecopy($ms_img, $jpg_image, 0, 0, 0, 0, 1200, 800);

		$day_angle = $m_ang;
		if ($hero_count === 3 && in_array($use_label, ['75', '150', '175'])) {
			$day_angle = 20;
			$day_x = 780; $day_y = 500;
			$days_x = 1000; $days_y = 320; $days_sz = 34;
			$cen_x = 890; $cen_y = 490; $cen_sz = 30;
		} else {
			$day_angle = 0;
			$day_x = $m_day_x; $day_y = $m_day_y;
			$days_x = $m_days_x; $days_y = $m_days_y; $days_sz = $m_days_sz;
			$cen_x = $m_cen_x; $cen_y = $m_cen_y; $cen_sz = $m_cen_sz;
		}

		@imagettftext($ms_img, 180, $day_angle, $day_x, $day_y, $tclr, $fnt, $use_label);
		@imagettftext($ms_img, $days_sz, 0, $days_x, $days_y, $tclr, $fnt, "DAYS");
		@imagettftext($ms_img, $cen_sz, 0, $cen_x, $cen_y, $tclr, $fnt, $use_val . " CENTERS");

		ob_start();
		$jpeg_ok = @imagejpeg($ms_img, null, 90);
		$ms_bytes = ob_get_clean();
		$ms_saved = poster_storage_save($ms['file'], $ms_bytes);
		error_log("POSTER[17]: milestone $use_label result=" . ($jpeg_ok ? 'OK' : 'FAIL') . " storage=" . ($ms_saved ? 'OK' : 'FAIL'));
		imagedestroy($ms_img);
	}
}
error_log("POSTER[18]: $ms_count milestones done");

imagedestroy($jpg_image);
error_log("POSTER[19]: COMPLETE");

// Mark the poster as generated only after the main image actually saved.
// This keeps tolly_release.poster='no' when generation fails or the request
// is killed mid-way, so the next page load retries automatically instead of
// leaving a placeholder that requires a manual regenerate.
if ($rid !== '' && $main_saved) {
	require_once __DIR__ . '/../db.php';
	if (!empty($conn)) {
		$rid_i = intval($rid);
		@mysqli_query($conn, "UPDATE tolly_release SET poster='yes' WHERE rid=$rid_i");
		@mysqli_close($conn);
		error_log("POSTER[20]: DB poster=yes rid=$rid_i");
	}
}
