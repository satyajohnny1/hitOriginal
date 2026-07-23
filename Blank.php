<?php
session_start(); 
?>
<!DOCTYPE html>
<html>

<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
     <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="closeRight"><i class="fa fa-times"></i></a></h3>

    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="closeRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>
    <!-- Search Form -->
    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
       	<div class="page-sidebar sidebar">
                  <?php include('sidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">
            <div class="page-title">
                <h3>Form Wizard</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="userdashboard.php">Home</a></li>
                        <li><a href="#">Forms</a></li>
                        <li class="active">Form Wizard</li>
                    </ol>
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div id="main-wrapper" >
 
          
            </div>
            <!-- Main Wrapper -->

   		 
            <div class="page-footer">
                <p class="no-s">2015 &copy; HitandFut.com</p>
            </div>
        </div>
        <!-- Page Inner -->
    </main>
    <!-- Page Content -->
  
    <div class="cd-overlay"></div>

	<?php include 'js.php';?>
	<script type="text/javascript">
	toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "300",
			  "hideDuration": "1000",
			  "timeOut": "5000",
			  "extendedTimeOut": "1000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}

	 
	
	</script>

</body>

</html>  
<?php 
if($conn!=null){
mysqli_close($conn);
}
?>