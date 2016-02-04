<?php
error_reporting(E_ERROR);
include 'db.php';

 
$email = $_POST ["email"];
$pwd='';
$status=0;
$link = "";
 


if ( ! empty ( $_POST ["email"] )) {
	
	// Regisred Checking
	
	$sql = "select * from tolly_user a where a.email = '$email'";	
	$result = mysqli_query ( $conn, $sql );
	
	if (mysqli_num_rows ( $result ) > 0) {
		
		$row = mysqli_fetch_assoc($result);
		$pwd = $row["password"];
		
		//echo "<h1>$pwd</h1>";
		//echo 'Im in AALreday Exixt';
	}
	
	
	else{
		
		echo "<h1>You are not registed with us </h1>";
		
	}
}
	
	?>

<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title>HitandFut | Login - Sign in</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="HitandFut - The Ultimate Movie Simulation Game " />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="HitandFut.com" />
        
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
          <link href="assets/plugins/toastr/toastr.min.css" rel="stylesheet"/>
        
        <!-- Theme Styles -->
        <link href="assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/themes/white.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
        <script src="assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="page-forgot">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="http://www.hitandfut.com/" class="logo-text"><span><img src="pic/logo.png" alt="HitandFut" height="70px"></span></a>
                                <hr style="height:1px;border:none;color:#333;background-color:#333;" >
                            <h4 class="text-center m-t-md">The Ultimate Movie Simulation Game</h4>
                 <hr style="height:1px;border:none;color:#333;background-color:#333;" >
                                <p class="text-center m-t-md">Enter your e-mail address below to reset your password</p>
                                <form class="m-t-md" action="forgot.php" method="post" name="pwdform">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email"  name="email" id="email" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    <a href="login.php" class="btn btn-default btn-block m-t-md">Back</a>
                                </form>
                                
                                <p id="pass" style="display: none;"><?php echo $email;?></p>
                                <p class="text-center m-t-xs text-sm">2015 &copy; HitandFut.com</p>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
	

       
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.1.3.min.js"></script>
        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/plugins/pace-master/pace.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>
        <script src="assets/plugins/uniform/jquery.uniform.min.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/classie.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/main.js"></script>
        <script src="assets/plugins/waves/waves.min.js"></script>
        <script src="assets/plugins/3d-bold-navigation/js/main.js"></script>
        <script src="assets/js/modern.min.js"></script>
        <script src="assets/js/pages/notifications.js"></script>
           <script src="assets/plugins/toastr/toastr.min.js"></script>
           
           
           
           <script>	
	
	toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-full-width",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "1",
  "hideDuration": "5000",
  "timeOut": "10000",
  "extendedTimeOut": "5000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
	//toastr.success('<h1>Email sent, Check SPAM Folder Also....</h1>');
//alert('before');

	var link1 = "http://hitandfut.hostreo.com/forgot.php?to=<?php echo $email;?>&pwd=<?php echo $pwd;?>";
	var xlink1 = "http://hitandfut.com/forgotMail.php?to=<?php echo $email;?>&pwd=<?php echo $pwd;?>";
	
	//alert('after');
	//alert(link1);
	var pw = $("#pass").text().length;
	//alert(pw);
	
	if(pw>4)
	{
		
		//alert('AJAX CALLING'+link1);
		 var str = $("#pwdform").serialize();	

		    
	      $.ajax({
	     type: "GET",
	      url: xlink1,
	      data: str,
         success: function( data ) {
       	 // alert("Password Sent!!");
					toastr.success(data+'<h1>An Email with Password sent, Check SPAM Folder Also....</h1>');
				 
          },	          
          error: function( xhr, status, errorThrown ) {
       	  
       	   toastr.error( "<h1>You are not registed with us </h1>" );	              
          }
	    })
	    
	    
	  $.ajax({
		     type: "GET",
		      url: link1,
		      data: str,
	          success: function( data ) {
	        	 // alert("Password Sent!!");
						toastr.success(data+'<h1>An Email with Password sent, Check SPAM Folder Also....</h1>');
					 
	           },	          
	           error: function( xhr, status, errorThrown ) {
	        	  
	        	   toastr.error( "<h1>You are not registed with us </h1>" );	              
	           }
		    })
		    
	
		    document.getElementById("#pwdform").reset();
	}
	</script>
        
        
    </body>
</html> <?php mysql_close($conn);?>