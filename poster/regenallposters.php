<?php
include 'sessionCheck.php';
include 'db.php';
 
session_start(); 
error_reporting(E_ERROR); 
$uid =  $_SESSION['s_uid'];
date_default_timezone_set("America/New_York");

$rel_date = '';
$rid  = '';
$r1 = 0;
$r2 = 0;
$r3 = 0;
$pic = '';
$aid       = '';
$acid      = '';
$did       = '';
$wid       = '';
$mid       = '';
$eid       = '';
$cid       = '';
$budget    = '';
$collection= '';
$profit    = '';
$sofar     = '';
$grade     = '';
$status    = '';
$pic       = '';
$dt        = '';
$notes     = '';
$dname     = '';
$aname     = '';
$acname    = '';
$s         = '';
$progress  = '';
$rating    = '';
$hit    = '';

$max_days = 0;
$cinename = '';
 $ediname = ''; 
 $musname = ''; 
 $wriname='';
 $poster='';

 $title = '';
 $fif = '';
 $hun = '';
 $five = '';
 $t5 = '';

 $_a2 = '';
 $_a3 = '';
 $_ac2 = '';
 $_ac3 = '';
 $_w2 = '';
 $_w3 = '';
 $_m2 = '';
 $_m3 = '';
 $_d2 = '';
 $_d3 = '';
 
 
 $_a2_name = '';
 $_a3_name = '';
 $_ac2_name = '';
 $_ac3_name = '';
 $_w2_name = '';
 $_w3_name = '';
 $_m2_name = '';
 $_m3_name = '';
 $_d2_name = '';
 $_d3_name = '';
$sql = "SELECT * FROM tolly_release LIMIT 5";
//echo $sql;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$rel_date = $row["rel_date"];
        $rid = $row["rid"];
		$r1 = $row["r1"];
		$r2 = $row["r2"];
		$r3 = $row["r3"];
		$poster = $row["poster"];
		$max_days = $row["max_days"];
		
		
		
		$fif = $row["50d_cen"];
		$sev = $row["75d_cen"];		
		$hun = $row["100d_cen"];
		$onf = $row["150d_cen"];
		$five = $row["175d_cen"];
		$t5 = $row["25d_cen"];


        
// ========== QUERY 2 START ============

$sql2 = "SELECT * FROM tolly_ready_for_shoot s WHERE s.rid = ".$rid;
//echo $sql;
$result2 = mysqli_query($conn, $sql2);

if (mysqli_num_rows($result2) > 0) {
	// output data of each row
	
	
    if($row2= mysqli_fetch_assoc($result2)) {
		global  $aid , $acid, $did , $wid , $mid , $eid , $cid , $budget    , $collection, $profit    , $sofar     , $grade     , $status    , $pic , $dt  , $notes     , $dname     , $aname     , $acname    , $s   , $progress  , $rating    , $result    ;
		$aid       = 	$row2["aid"];
		$acid      = 	$row2["acid"];
		$did       = 	$row2["did"];
		$wid       = 	$row2["wid"];
		$mid       = 	$row2["mid"];
		$eid       = 	$row2["eid"];
		$cid       = 	$row2["cid"];
		
		$budget    = 	$row2["budget"];
		$budget    = 	ceil($budget);
		
		$collection= 	$row2["collection"];
		$collection    = 	ceil($collection);
		
		$profit    = 	$row2["profit"];
		$profit    = 	ceil($profit);
		
		$sofar     = 	$row2["sofar"];
		$sofar    = 	ceil($sofar);
		
		
		
		$grade     = 	$row2["grade"];
		$status    = 	$row2["status"];
		$pic       = 	$row2["pic"];
		$dt        = 	$row2["dt"];
		$notes     = 	$row2["notes"];
		
		$s         = 	$row2["s"];
		$progress  = 	$row2["progress"];
		$rating    = 	$row2["rating"];
		$hit    	= 	$row2["result"];
		
		$dname     = 	$row2["dname"];
		$aname     = 	$row2["aname"];
		$acname    = 	$row2["acname"];
		$cinename = $row2["cinename"];
		 $ediname = $row2["ediname"];
		  $musname = $row2["musname"];
		   $wriname=$row2["wriname"];
		   $title = $row2["title"];
		
		//echo $hit;
		   $_a2 = $row2["a2"];
		   $_a3 = $row2["a3"];
		   $_ac2 = $row2["ac2"];
		   $_ac3 = $row2["ac3"];
		   $_w2 = $row2["w2"];
		   $_w3 = $row2["w3"];
		   $_m2 = $row2["m2"];
		   $_m3 = $row2["m3"];
		   $_d2 = $row2["d2"];
		   $_d3 = $row2["d3"];
		   
		   
		   $_a2_name = $row2["a2_name"];
		   $_a3_name = $row2["a3_name"];
		   $_ac2_name = $row2["ac2_name"];
		   $_ac3_name = $row2["ac3_name"];
		   $_w2_name = $row2["w2_name"];
		   $_w3_name = $row2["w3_name"];
		   $_m2_name = $row2["m2_name"];
		   $_m3_name = $row2["m3_name"];
		   $_d2_name = $row2["d2_name"];
		   $_d3_name = $row2["d3_name"];

          

	}
}
// ========== QUERY 2 END ============
	
$upp = strtoupper($title.$rid);
$path = 'poster/done/'.$upp.".jpeg";
$path_50 = 'poster/done/'.$upp."_50.jpeg";
$path_100 = 'poster/done/'.$upp."_100.jpeg";
$path_175 = 'poster/done/'.$upp."_175.jpeg";

$path_150 = 'poster/done/'.$upp."_150.jpeg";
$path_75 = 'poster/done/'.$upp."_75.jpeg";

$bg = "bg/bg".rand(1,35).".jpg";
$heroimg = clean(strtolower($a)).'.png';
$heroimg = "actors/".$heroimg;
$jpg_image = imagecreatefromjpeg($bg);
$fnt = "fonts/".rand(1,25).".ttf";
$tfnt = "fonts/".rand(14,122).".ttf";
$path = 'done/'.$tit.$rid.".jpeg";
$path_50 = 'done/'.$tit.$rid."_50.jpeg";
$path_75 = 'done/'.$tit.$rid."_75.jpeg";
$path_150 = 'done/'.$tit.$rid."_150.jpeg";


$path_100 = 'done/'.$tit.$rid."_100.jpeg";
$path_175 = 'done/'.$tit.$rid."_175.jpeg";

$ori = 'done/'.$tit.$rid.".jpeg";

 


if($_a3 > 0 && $_a2 > 0 && $_a1 > 0){

    //******************** POSTER 3 === START  */
    $num = rand(1,30);  
      $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //blue
      $tclr = imagecolorallocate($jpg_image,  255, 255, 255); //red
     $cclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
      
    if($num<15){
          $bclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
          $tclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
          $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //red  	
          
      }
    
    
      //=================== HERO-I CODE ================================
      $width = 400;
      $height = 400;
      $top_image = imagecreatefrompng($heroimg1);
      imagesavealpha($top_image, true);
      imagealphablending($top_image, true);
      imagecopy($jpg_image, $top_image, 300, 0, 0, 0, $width, $height);
      //=================== HERO-I CODE ================================
      
      
    
    
      //=================== HERO-II CODE ================================
      $width = 400;
      $height = 400;
      $top_image = imagecreatefrompng($heroimg2);
      imagesavealpha($top_image, true);
      imagealphablending($top_image, true);
      imagecopy($jpg_image, $top_image, 70, 0, 0, 0, $width, $height);
      //=================== HERO-II CODE ================================
      
      
    
      //=================== HERO-III CODE ================================
      $width = 400;
      $height = 400;
      $top_image = imagecreatefrompng($heroimg3);
      imagesavealpha($top_image, true);
      imagealphablending($top_image, true);
      imagecopy($jpg_image, $top_image, 550, 0, 0, 0, $width, $height);
      //=================== HERO-III CODE ================================
      
      
      
      
      
      //Merging imGE CODE--------------
      //( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
      
    
      //Merging imGE CODE-------------- 
      
    
    //Banner Data 
        $font_path = $fnt;   
      $text = $b;
      imagettftext($jpg_image, 22, 0, 10, 55, $bclr, $font_path, $text);
      //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
    
     // Hero Data 
       $font_path = $fnt;    
      $text = $a.'-'.$a2.'-'.$a3;
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
     
      $fonsiz="35";
      $area = "300";
      
     if(strlen($d2)>2)
     {
         $fonsiz="30";
         $area = "200";
     }
      
    
     if(strlen($d3)>2)
     {
         $fonsiz="25";
         $area = "70";
     }
     
     //Director Data 
        $font_path = $fnt;   
      $text =$d.'  '.$d2.'  '.$d3;
      imagettftext($jpg_image, $fonsiz, 0, $area, 550,$cclr, $font_path, $text);
       
      //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
      
      
      //Producer Data
        $font_path = $fnt;  
      $text = $p;
     imagettftext($jpg_image, 28, 0, 340, 600,$cclr, $font_path, $text);
      
      
    
      //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
    
     //Music Data
     $font_path = $fnt;
     $text = $m.' '.$m2.' '.$m3.'-'.$w.' '.$w2.' '.$w3.' - '.$e.' - '.$c;
     imagettftext($jpg_image, 13, 0, 120, 630,$cclr, $font_path, $text);
     
    
      // Normal Poster
     imagejpeg($jpg_image);
    imagejpeg($jpg_image, $path);
      // Clear Memory
     
      if($fif>0)
      {
          //Days Data
          $font_path = $fnt;
          $text = "50";
          imagettftext($jpg_image, 180, 0, 480, 800, $tclr, $font_path, $text);
           
           
           
          //Days text
          $font_path = $fnt;
          $text = "DAYS";
          imagettftext($jpg_image, 25, 0, 700, 800, $tclr, $font_path, $text);
           
           
          //Centers Data
          $font_path = $fnt;
          $text = $fif." CENTERS";
          imagettftext($jpg_image, 30, 0, 300, 700, $tclr, $font_path, $text);
      
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
          //Days Data
          $font_path = $fnt;
          $text = "75";
          imagettftext($jpg_image, 180, 20, 680, 500, $tclr, $font_path, $text);
           
           
           
          //Days text
          $font_path = $fnt;
          $text = "DAYS";
          imagettftext($jpg_image, 34, 0, 900, 320, $tclr, $font_path, $text);
           
           
          //Centers Data
          $font_path = $fnt;
          $text = $sev." CENTERS";
          imagettftext($jpg_image, 30, 0, 790, 490, $tclr, $font_path, $text);
      
          imagejpeg($jpg_image);
          imagejpeg($jpg_image, $path_75);
          // Clear Memory
      
      
      
      }
      
      
      if($hun>0)
      {
          $jpg_image = imagecreatefromjpeg($ori);
          
      
               
          $font_path = $fnt;
          $text = "100";
          imagettftext($jpg_image, 180, 0, 480, 800, $tclr, $font_path, $text);
           
           
           
          //Days text
          $font_path = $fnt;
          $text = "DAYS";
          imagettftext($jpg_image, 25, 0, 700, 800, $tclr, $font_path, $text);
           
           
          //Centers Data
          $font_path = $fnt;
          $text = $hun." CENTERS";
          imagettftext($jpg_image, 30, 0, 300, 700, $tclr, $font_path, $text);
      
          imagejpeg($jpg_image);
          imagejpeg($jpg_image, $path_100);
          // Clear Memory
      
           
      
      }
      
      
    
      if($onf>0)
      {
          $jpg_image = imagecreatefromjpeg($ori);
          
      
          $font_path = $fnt;
          $text = "150";
          imagettftext($jpg_image, 180, 20, 680, 500, $tclr, $font_path, $text);
           
           
           
          //Days text
          $font_path = $fnt;
          $text = "DAYS";
          imagettftext($jpg_image, 34, 0, 900, 320, $tclr, $font_path, $text);
           
           
          //Centers Data
          $font_path = $fnt;
          $text = $onf." CENTERS";
          imagettftext($jpg_image, 30, 0, 790, 490, $tclr, $font_path, $text);
      
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
          imagettftext($jpg_image, 180, 20, 680, 500, $tclr, $font_path, $text);
           
           
           
          //Days text
          $font_path = $fnt;
          $text = "DAYS";
          imagettftext($jpg_image, 34, 0, 900, 320, $tclr, $font_path, $text);
           
           
          //Centers Data
          $font_path = $fnt;
          $text = $fiv." CENTERS";
          imagettftext($jpg_image, 30, 0, 790, 490, $tclr, $font_path, $text);
          imagejpeg($jpg_image);
          imagejpeg($jpg_image, $path_175);
          // Clear Memory
          
      }
      imagedestroy($jpg_image);
    //******************** POSTER 3 === END  */
    
    } elseif($_a2 > 0 && $_a1 > 0 ){
    
    // ========= POSTER 2 - START =====================
        $num = rand(1,30);  
        $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //blue
        $tclr = imagecolorallocate($jpg_image,  255, 255, 255); //red
       $cclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
        
      if($num<15){
            $bclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
            $tclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
            $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //red  	
            
        }
        
      
      
        //=================== HERO-I CODE ================================
        $width = 400;
        $height = 400;
        $top_image = imagecreatefrompng($heroimg1);
        imagesavealpha($top_image, true);
        imagealphablending($top_image, true);
        imagecopy($jpg_image, $top_image, 450, 0, 0, 0, $width, $height);
        //=================== HERO-I CODE ================================
        
        
      
      
        //=================== HERO-II CODE ================================
        $width = 400;
        $height = 400;
        $top_image = imagecreatefrompng($heroimg2);
        imagesavealpha($top_image, true);
        imagealphablending($top_image, true);
        imagecopy($jpg_image, $top_image, 100, 0, 0, 0, $width, $height);
        //=================== HERO-II CODE ================================
        
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
          $font_path = $fnt;   
        $text = $b;
        imagettftext($jpg_image, 22, 0, 10, 55, $bclr, $font_path, $text);
        //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
      
      // Hero Data 
         $font_path = $fnt;    
        $text = $a.'-'.$a2;
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
         
        $fonsiz="35";
        $area = "300";
        
        if(strlen($d2)>2)
        {
            $fonsiz="30";
            $area = "200";
        }
        
        
        if(strlen($d3)>2)
        {
            $fonsiz="25";
            $area = "70";
        }
        
        //Director Data
        $font_path = $fnt;
        $text =$d.'  '.$d2.'  '.$d3;
        imagettftext($jpg_image, $fonsiz, 0, $area, 550,$cclr, $font_path, $text);
         
        //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
        
        
        //Producer Data
        $font_path = $fnt;
        $text = $p;
        imagettftext($jpg_image, 28, 0, 340, 600,$cclr, $font_path, $text);
        
        
        
        //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
        
        //Music Data
        $font_path = $fnt;
        $text = $m.' '.$m2.' '.$m3.'-'.$w.' '.$w2.' '.$w3.' - '.$e.' - '.$c;
        imagettftext($jpg_image, 13, 0, 120, 630,$cclr, $font_path, $text);
        
        
         
      
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
    
    // ========= POSTER 2 - START =====================
    
    
    
    } else {
    
    
    
    
    // ========= POSTER 1 - START =====================
    
    $num = rand(1,50);  
      $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
      $tclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
      $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
      
    if(0<$num &&  $num< 10){
        //Title RED & Remaining White
          $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
          $tclr = imagecolorallocate($jpg_image,  252, 232, 3); //YELLO
          $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //white  	
      }
     if(10<$num &&  $num< 20){
        //Title RED & Remaining White
          $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
          $tclr = imagecolorallocate($jpg_image,  206, 255, 71); //Chialapacha
          $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //white  	
      } 
      
     if(20<$num &&  $num< 30){
        //Title RED & Remaining White
          $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
          $tclr = imagecolorallocate($jpg_image,  80, 255, 71); //GREEN
          $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //white  	
      } 
      
     if(30<$num &&  $num< 40){
        //Title RED & Remaining White
          $bclr = imagecolorallocate($jpg_image,  255, 255, 255); //white
          $tclr = imagecolorallocate($jpg_image,  245, 15, 15); //red
          $cclr = imagecolorallocate($jpg_image,  252, 252, 109); //white  	
      } 
      
      
     if(40<$num &&  $num< 50){
        //Title RED & Remaining White
          $bclr = imagecolorallocate($jpg_image,  252, 252, 109); //white
          $tclr = imagecolorallocate($jpg_image,  71, 169, 255); //Blue
          $cclr = imagecolorallocate($jpg_image,  255, 255, 255); //white  	
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
      $top_image = imagecreatefrompng("actors/hit.png");
      imagesavealpha($top_image, true);
      imagealphablending($top_image, true);
      imagecopy($jpg_image, $top_image, 0, 60, 0, 0, $width, $height);
      
      //Merging imGE CODE-------------- 
      
    
    //Banner Data 
        $font_path = $fnt;   
      $text = $b;
      imagettftext($jpg_image, 22, 0, 10, 55, $bclr, $font_path, $text);
      //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
    
     // Hero Data 
       $font_path = $fnt;    
      $text = $a.' - '.$ac;
      imagettftext($jpg_image, 17, 0, 300, 390, $cclr, $font_path, $text);
      
      //top line Data 
     $font_path =  $fnt; 
      $text = "______________________________________";
      imagettftext($jpg_image, 35, 0, 100, 395,$tclr, $font_path, $text);
       
      //TITLE Data 
        $font_path = $tfnt;   
      $text = $tit;
      imagettftext($jpg_image, 80,0, 200, 490, $tclr, $font_path, $text);
       
       //bottom line Data 
      $font_path = $fnt;
    $text = "______________________________________";
      imagettftext($jpg_image, 35, 0, 100, 500,$tclr, $font_path, $text);
       
      $fonsiz="35";
      $area = "300";
      
      if(strlen($d2)>2)
      {
          $fonsiz="30";
          $area = "200";
      }
      
      
      if(strlen($d3)>2)
      {
          $fonsiz="25";
          $area = "70";
      }
      
      //Director Data
      $font_path = $fnt;
      $text =$d.'  '.$d2.'  '.$d3;
      imagettftext($jpg_image, $fonsiz, 0, $area, 550,$cclr, $font_path, $text);
       
      //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
      
      
      //Producer Data
      $font_path = $fnt;
      $text = $p;
      imagettftext($jpg_image, 28, 0, 340, 600,$cclr, $font_path, $text);
      
      
      
      //[FONTSIZE,CURVE,STARTWIDTH,STARTHEIGHT]
      
      //Music Data
      $font_path = $fnt;
      $text = $m.' '.$m2.' '.$m3.'-'.$w.' '.$w2.' '.$w3.' - '.$e.' - '.$c;
      imagettftext($jpg_image, 13, 0, 120, 630,$cclr, $font_path, $text);
      
      
    
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
      // ========= POSTER 1 - END =====================
    }
 

		echo ' \n ==== > POSTER GENERATION COMPLETED FOR ID: '.$rid.', TITLE :'.$title;
		
	}
    //While Loop End
}



function clean($string) {
	$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
  
?>
