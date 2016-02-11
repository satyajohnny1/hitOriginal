<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title>HitandFut | Login - Sign up</title>
        
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
    <body class="page-register">
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
                                <p class="text-center m-t-md">Create a HitandFut's account</p>
                                <form class="m-t-md" method="POST" id="regform" action="registerAjax.php">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username"  name="username" placeholder="Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="banner"  name="banner" placeholder="Your Banner Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control"  id="password"  name="password" placeholder="Password" required>
                                    </div>
                                    <label>
                                        <input type="checkbox" id="terms">Click Submit to Agree the terms and policy
                                    </label>
                                    <button type="button" class="btn btn-success btn-block m-t-xs" id="regButton">Submit</button>
                                    <p class="text-center m-t-xs text-sm">Already have an account?</p>
                                    <a href="login.php" class="btn btn-default btn-block m-t-xs">Login</a>
                                </form>
                                
                                <p class="text-center m-t-xs text-sm"><h3 id="status"></h3></p>
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
	 
		  $("#regButton").click(function() {
	
			 var m = $("#email").val();
			 var u = $("#username").val();
			var p = $("#password").val();
			var b = $("#banner").val();
			
			
			var link = "http://hitandfut.hostreo.com/activate.php?link=http://www.hitandfut.com/activation.php?email="+m+"&to="+m;
			var xlink = "http://hitandfut.com/activateMail.php?link=http://www.hitandfut.com/activation.php?email="+m+"&to="+m;
			
			   if(u.length<1)
			 { toastr.error( "Please Enter Name" );	   
			 }
			   else  if(b.length<1)
				 { toastr.error( "Please Enter Banner/ Production House Name" );	   
				 }
				
			   //else if(m.length<1 || m.indexOf('@')<1)
			  //else if(m.length<5)
			  else if(m.length<1 || m.indexOf('@')<1)
			 { toastr.error( "Please Enter Valid Email ID" );	   
			 }
			 
			 else  if(p.length<1)
			 { toastr.error( "Please Enter Password" );	   
			 }
			
			 else{
							  //************************* AJAX START ***************************
			  $("#status").text("Loading...............");			  
			  var str = $("#regform").serialize();			    
		    $.ajax({
		     type: "POST",
		      url: "registerAjax.php",
		      data: str,
	          success: function( data ) {	
	        	  //toastr.info(data," Notification "); 
	        	  var obj = jQuery.parseJSON(data);
                  var msg = obj.msg;                
                  var status = obj.status;
                 
		                       
	              toastr.info(msg," Notification "); 

					if(status>10)
					{
						//toastr.success("---------"+link);


							    
						  $.ajax({
							     type: "GET",
							      url: xlink,
							      data: str,
						          success: function( data ) {
 
											toastr.success(data+'<h1>Email sent, Check SPAM Folder Also....</h1>');
										 
						           },	          
						           error: function( xhr, status, errorThrown ) {
						        	   //toastr.error( "Check SPAM Folder Also...." );	              
						           }
							    })
							    
							    

						  $.ajax({
							     type: "GET",
							      url: link,
							      data: str,
						          success: function( data ) {
 
											//toastr.success(data+'<h1>Email sent, Check SPAM Folder Also....</h1>');
										 
						           },	          
						           error: function( xhr, status, errorThrown ) {
						        	   //toastr.error( "Check SPAM Folder Also...." );	              
						           }
							    })

					}
	              
	               
	           },	          
	           error: function( xhr, status, errorThrown ) {
	        	   toastr.error( "Sorry, there was a problem!" );	              
	           }
		    })
		    $("#status").text("");
			 }

		    
		  })
		  //************************* AJAX END ***************************
		 
		
		</script>
        
    </body>
</html> <?php mysql_close($conn);?>
