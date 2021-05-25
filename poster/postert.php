<?php
include('image_lib.php');
$tit=imagelib("सफलता उनको मिलती है जो Risk लेना जानते हैं ");
$tit=implode(" ",$txt);
$image_bg="bg.png";
$font="telugu/mangal.ttf";
$im=imagecreatefrompng($image_bg);
$color=imagecolorallocate($im,255,100,100);
imagefttext($im,50,3,200,800,$color,$font,$tit);
imagepng($im,"output/output.png");
?>
<img src="output/output.png" width="500px"/>