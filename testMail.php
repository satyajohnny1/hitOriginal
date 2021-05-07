<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="description" content="Free Web tutorials">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Hege Refsnes">
  </head>
  <body>
<h1>http://hitandfut.hostreo.com/activate.php?link=www.hitandfut.com&to=hitandfut@gmail.com</h1>
<a href="testMail.php?link=www.hitandfut.com&to=hitandfut@gmail.com"> Mail Me : Mail Sent to smlcodes@gmail.com</a>

hitandfut.skim.us
<?php

	$link = $_GET["link"];
	$to = $_GET["to"];
   $subject = "HIT AND FLOP- Activate Your Account ";
   $header = "From: ActivateAccount@hitandfut.com \r\n";
			$header .= "Reply-To: ActivateAccount@hitandfut.com\r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = "<h1> Testing Mail </h1>";




  
    //$sentmail = mail("hitandfut@gmail.com",$subject,$message,$header);
	 $sentmail = mail($to,$subject,$message,$header);

   if($sentmail)
            {
   echo "DONE";
   }
   else
         {
    echo "Cannot send Confirmation link to your e-mail address";
   }
?>
   
  