    <?php





    // your string, preferably read from a source elsewhere
    $utf8str = "पुलिसवाला आमिर खान";

    // buffer output in case there are errors
    ob_start();

    // create blank image
    $im = imagecreatetruecolor(400,40);
    $white = imagecolorallocate($im,255,255,255);
    imagefilledrectangle($im,0,0,imagesx($im),imagesy($im),$white);

    // write the text to image
    $font = "hindi.ttf";
    $color = imagecolorallocatealpha($im, 50, 50, 50, 0); // dark gray
    $size = 120;
    $angle = 0;
    $x = 5;
    $y = imagesy($im) - 5;
    imagettftext($im, $size, $angle, $x, $y , $color, $font, $utf8str);

    // display the image, if no errors
    $err = ob_get_clean();
    if( !$err ) {
        header("Content-type: image/png");
        imagepng($im);
    } else {
        header("Content-type: text/html;charset=utf-8");
        echo $err;
    }

    ?>
	
	http://localhost:8066/hit/poster/poster1.php?rid=858&b=%E0%A4%B8%E0%A4%A4%E0%A5%8D%E0%A4%AF%E0%A4%BE&p=satya&d=A.%20kodanda%20rami%20reddy&a=%20Arjanrajesh&ac=%20Anushka%20&c=Anumolu%20Srikar&e=Bindra&m=Kedra&w=Lola&tit=SHOLEY&fif=0&hun=0&fiv=0&t5=1&sev=0&onf=0&a2=&a3=&ac2=&ac3=&d2=&d3=&w2=&w3=&m2=Thaman&m3=Achu