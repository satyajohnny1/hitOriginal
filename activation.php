<?php
// Start the session
 error_reporting(E_ERROR);
session_start();
include 'db.php';
$email = $_GET ["email"];

$sql = "select * from tolly_user a where a.email = '$email'";
//echo $sql;
$result = mysqli_query ( $conn, $sql );
if (mysqli_num_rows ( $result ) > 0) {


$sql = "UPDATE tolly_user SET status='active' WHERE  email = '$email'";
//echo $sql;
$r = mysqli_query ( $conn, $sql );
$al='';

if($r)
{
	$al = 'active';
	
	//echo "<h1> ".$email.", Account Activated, Please Login</h1>";
}


}
else{
	$al = 'inactive';
	//echo "<h1> ".$email.", Account Not Found!!! Please Register</h1>";
}

?>

<?php
if(isset($_SESSION['login_user'])){
header("location: userdashboard.php");
//echo "In Header";
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
        <meta name="keywords" content="hutandfut,tollywood,game,boxoffice,centers" />
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
    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="userdashboard.php" class="logo-name text-lg text-center">HitandFut</a>
                                <p class="text-center m-t-md">Please login into your account.</p>
                                <form class="m-t-md" action="" method="post" name="loginform" id="loginform">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password"  name="password"  id="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <input type="button" name="login" id="login"  value="Login" class="btn btn-success btn-block" onclick="loginAjax();">
                                    <a href="forgot.php" class="display-block text-center m-t-md text-sm">Forgot Password?</a>
                                    <p class="text-center m-t-xs text-sm">Do not have an account?</p>
                                    <a href="register.php" class="btn btn-default btn-block m-t-md">Create an account</a>
                                    <span id="error"><?php echo $error; ?></span>
                                </form>
                                <p class="text-center m-t-xs text-sm">2015 &copy; HitandFut.com;.</p>
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
	//toastr.error("Select Section", "Error Info");
	//toastr.success("SOk"," Ok "); 
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


	 function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,8}|[0-9]{1,9})(\]?)$/;
        return expr.test(email);
    };

  
       
 
	 
	function loginAjax(){
		
	
		 if (!ValidateEmail($("#email").val())||$("#password").val().length<1) {
			toastr.error("<h3><b>Please Enter Valid Email and Password</b></h3>");
	        }
	        else {

	       	 var str = $("#loginform").serialize();	
	    	 //alert('---');
	    	 $.ajax({
	   		     type: "POST",
	   		      url: "loginAjax.php",
	   		      data: str,
	   	          success: function( data ) {
	   	        	var obj = jQuery.parseJSON(data);
	       			var st = obj.st;
	       			var e = obj.e;	  
	       			var sl = obj.sql;
	       			
	       			toastr.error("<h3><b>"+e+"</b></h3>");
	       			//toastr.error("<h3><b>"+e+"</b></h3>"+sl);
	       			
					if(st=='active')
					{
						window.location.assign("userdashboard.php")

					}
	       			

	       		 //toastr.error(data+"Success" );	            
	   					 
	   	           },	          
	   	           error: function( xhr, status, errorThrown ) {
	   	        	 
	   	        	   toastr.error( "In error" );	              
	   	           }
	   		    })

 
	        }
		 
		}

//----------------------------------------------------

var str = '<?php echo $_GET["sess"]; ?>';
var n = str.length;

if(n>20)
{
	toastr.error("You not Loggedin / Session Expired", "Please Login");
}

var al = '<?php echo $al; ?>'; 

if(al=='active')
{
	toastr.error("<h1> Account Activated, Please Login</h1>", "Please Login");
}else{

	toastr.error("<h1> Account Not Found!!! Please Register </h1>", "Please Login");
}
 

	 
    </script>	
        
    </body>
</html> <?php mysql_close($conn);?></html> <?php mysql_close($conn);?>