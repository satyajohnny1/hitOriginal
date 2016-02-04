<?php


$b  = strtoupper($_GET["b"]);
$p  = strtoupper($_GET["p"]);
$d = strtoupper($_GET["d"]);
$a  = $_GET["a"];
$ac = strtoupper($_GET["ac"]);
$c  = strtoupper($_GET["c"]);
$e = strtoupper($_GET["e"]);
$m = strtoupper($_GET["m"]);
$w = strtoupper($_GET["w"]);
$tit  = strtoupper($_GET["tit"]);
$fif = $_GET["fif"];
$hun = $_GET["hun"];
$fiv = $_GET["fiv"];
$rid  = $_GET["rid"]; 
$t5  = $_GET["t5"];
$sev = $_GET["sev"];
$onf = $_GET["onf"];

/*

$b  = "AITHE ARTS";
$p  = "SATYA KAVETI";
$d = "K. RAGAVENDRA RAO B.A";
$a  = "BALAKRISHNA";
$ac = "SAMANTHA";
$c  = "CHOTA K NAIDU";
$e = "KOTAGIRI";
$m = "MANI SHARMA";
$w = "VASU UPPALA";
$tit  = "SIMHAM-VETA";
$fif = "66";
$hun = "18";
$fiv = "7";
$rid  = "123";
*/

function clean($string) {
	$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$bg = "bg2.jpg";
$heroimg = clean($a).'.png';
$jpg_image = imagecreatefromjpeg($bg);
$fnt = rand(1,13).".ttf";
$tfnt = rand(1,13).".ttf";
$path = 'done/'.$tit.$rid.".jpeg";
$path_50 = 'done/'.$tit.$rid."_50.jpeg";
$path_75 = 'done/'.$tit.$rid."_75.jpeg";
$path_150 = 'done/'.$tit.$rid."_150.jpeg";


$path_100 = 'done/'.$tit.$rid."_100.jpeg";
$path_175 = 'done/'.$tit.$rid."_175.jpeg";

$ori = 'done/'.$tit.$rid.".jpeg";

//$fnt =$tfnt;
echo $path;

  //Set the Content Type
/* $bclr = imagecolorallocate($jpg_image,  7, 185, 205); //blue
$tclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
$cclr = imagecolorallocate($jpg_image, 255, 77, 5);//ornge 
*/
//header('Content-type: text/html');

$num = rand(1,30);  
  $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //blue
  $tclr = imagecolorallocate($jpg_image,  255, 255, 255); //red
 $cclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
  
if($num<15){
  	$bclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
  	$tclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
  	$cclr = imagecolorallocate($jpg_image,  255, 255, 255); //red  	
  	
  }
  

  //Merging  HERO imGE CODE--------------
  $width = 400;
  $height = 400;
 
  $top_image = imagecreatefrompng($heroimg);
  imagesavealpha($top_image, true);
  imagealphablending($top_image, true);
  imagecopy($jpg_image, $top_image, 300, 0, 0, 0, $width, $height);
  
  //Merging imGE CODE--------------
  //( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
  
   //Merging  HITFUT imGE CODE--------------
  $width = 190;
  $height = 190;
  $top_image = imagecreatefrompng("hit.png");
  imagesavealpha($top_image, true);
  imagealphablending($top_image, true);
  imagecopy($jpg_image, $top_image, 0, 60, 0, 0, $width, $height);
  
  //Merging imGE CODE-------------- 
  

//Banner Data 
    $font_path = $tfnt;   
  $text = $b;
  imagettftext($jpg_image, 22, 0, 10, 55, $bclr, $font_path, $text);
  //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]

 // Hero Data 
   $font_path = $tfnt;    
  $text = $a.' - '.$ac;
  imagettftext($jpg_image, 17, 0, 300, 390, $cclr, $font_path, $text);
  
  //top line Data 
 $font_path = '3.ttf'; 
  $text = "______________________________________";
  imagettftext($jpg_image, 35, 0, 100, 395,$tclr, $font_path, $text);
   
  //TITLE Data 
    $font_path = $tfnt;   
  $text = $tit;
  imagettftext($jpg_image, 80,0, 200, 490, $tclr, $font_path, $text);
   
   //bottom line Data 
  $font_path = '3.ttf'; 
$text = "______________________________________";
  imagettftext($jpg_image, 35, 0, 100, 500,$tclr, $font_path, $text);
   
 
 //Director Data 
    $font_path = $tfnt;   
  $text =$d;
  imagettftext($jpg_image, 33, 0, 300, 550,$cclr, $font_path, $text);
   
  //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
  
  
  //Producer Data
    $font_path = $tfnt;  
  $text = $p;
 imagettftext($jpg_image, 28, 0, 340, 600,$cclr, $font_path, $text);
  
  

  //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
  
   //Music Data 
  $font_path = $tfnt;  
  $text = $m.' - '.$c.' -  '.$w.' - '.$e;
  imagettftext($jpg_image, 18, 0, 220, 630,$cclr, $font_path, $text);
  
   

  // Normal Poster
 imagejpeg($jpg_image);
imagejpeg($jpg_image, $path);
  // Clear Memory



  if($fif>0)
  {
  	//Days Data
  	$font_path = $fnt;
  	$text = "50";
  	imagettftext($jpg_image, 180, 0, 680, 275, $tclr, $font_path, $text);
  	 
  	 
  	 
  	//Days text
  	$font_path = $fnt;
  	$text = "DAYS";
  	imagettftext($jpg_image, 34, 0, 820, 320, $tclr, $font_path, $text);
  	 
  	 
  	//Centers Data
  	$font_path = $fnt;
  	$text = $fif." CENTERS";
  	imagettftext($jpg_image, 32, 0, 750, 55, $tclr, $font_path, $text);
  
  	imagejpeg($jpg_image);
  	imagejpeg($jpg_image, $path_50);
  	// Clear Memory
  
  	 
  }else{
  	
  	$font_path = $fnt;
  	$text = "25";
  	imagettftext($jpg_image, 180, 0, 680, 275, $tclr, $font_path, $text);
  	
  	
  	
  	//Days text
  	$font_path = $fnt;
  	$text = "DAYS";
  	imagettftext($jpg_image, 34, 0, 820, 320, $tclr, $font_path, $text);
  	
  	
  	//Centers Data
  	$font_path = $fnt;
  	$text = $t5." CENTERS";
  	imagettftext($jpg_image, 32, 0, 750, 55, $tclr, $font_path, $text);
  	
  	imagejpeg($jpg_image);
  	imagejpeg($jpg_image, $path_50);
  	// Clear Memory
  }
  
  


  if($sev>0)
  {
  	$jpg_image = imagecreatefromjpeg($ori);
  	echo 'TEMP --- '.$temp;
  
  	$font_path = $fnt;
  	$text = "75";
  	imagettftext($jpg_image, 180, 0, 680, 275, $tclr, $font_path, $text);
  
  
  
  	//Days text
  	$font_path = $fnt;
  	$text = "DAYS";
  	imagettftext($jpg_image, 34, 0, 820, 320, $tclr, $font_path, $text);
  
  
  	//Centers Data
  	$font_path = $fnt;
  	$text = $sev." CENTERS";
  	imagettftext($jpg_image, 34, 0, 750, 55, $tclr, $font_path, $text);
  
  	imagejpeg($jpg_image);
  	imagejpeg($jpg_image, $path_75);
  	// Clear Memory
  
  
  
  }
  
  
  if($hun>0)
  {
  	$jpg_image = imagecreatefromjpeg($ori);
  	echo 'TEMP --- '.$temp;
  
  		$font_path = $fnt;
  	$text = "100";
  	imagettftext($jpg_image, 180, 0, 680, 275, $tclr, $font_path, $text);
  	 
  	 
  	 
  	//Days text
  	$font_path = $fnt;
  	$text = "DAYS";
  	imagettftext($jpg_image, 34, 0, 820, 320, $tclr, $font_path, $text);
  	 
  	 
  	//Centers Data
  	$font_path = $fnt;
  	$text = $hun." CENTERS";
  	imagettftext($jpg_image, 34, 0, 750, 55, $tclr, $font_path, $text);
  
  	imagejpeg($jpg_image);
  	imagejpeg($jpg_image, $path_100);
  	// Clear Memory
  
  	 
  
  }
  
  

  if($onf>0)
  {
  	$jpg_image = imagecreatefromjpeg($ori);
  	echo 'TEMP --- '.$temp;
  
  	$font_path = $fnt;
  	$text = "150";
  	imagettftext($jpg_image, 180, 0, 680, 275, $tclr, $font_path, $text);
  
  
  
  	//Days text
  	$font_path = $fnt;
  	$text = "DAYS";
  	imagettftext($jpg_image, 34, 0, 820, 320, $tclr, $font_path, $text);
  
  
  	//Centers Data
  	$font_path = $fnt;
  	$text = $onf." CENTERS";
  	imagettftext($jpg_image, 34, 0, 750, 55, $tclr, $font_path, $text);
  
  	imagejpeg($jpg_image);
  	imagejpeg($jpg_image, $path_150);
  	// Clear Memory
  
  
  
  }
  

  if($fiv>0)
  {
  	$jpg_image = imagecreatefromjpeg($ori);
  	//Days Data
  	$font_path = $fnt;
  	$text = "175";
  	imagettftext($jpg_image, 180, 0, 680, 275, $tclr, $font_path, $text);
  
  
  
  	//Days text
  	$font_path = $fnt;
  	$text = "DAYS";
  	imagettftext($jpg_image, 34, 0, 820, 320, $tclr, $font_path, $text);
  
  
  	//Centers Data
  	$font_path = $fnt;
  	$text = $fiv." CENTERS";
  	imagettftext($jpg_image, 32, 0, 750, 55, $tclr, $font_path, $text);
  
  	imagejpeg($jpg_image);
  	imagejpeg($jpg_image, $path_175);
  	// Clear Memory
  	
  }
  imagedestroy($jpg_image);
  
  
  
  
  
?>

