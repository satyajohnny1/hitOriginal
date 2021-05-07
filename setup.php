<!DOCTYPE html>
<html>

<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="acbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="acloseRight"><i class="fa fa-times"></i></a></h3>

    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="acbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="acloseRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>
    <div class="menu-wrap">

        <button class="close-button" id="aclose-button">Close Menu</button>
    </div>
    <form class="search-form" action="actorupload.php" method="GET">
        <div class="input-group">
            <input type="text" name="asearch" class="form-control search-input" placeholder="Search...">
            <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
        </div>
        <!-- Input Group -->
    </form>
    <!-- Search Form -->
    <main class="page-content content-wrap">
        
       	<div class="page-sidebar sidebar">
                  <?php include('adminsidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">            
            <div id="amain-wrapper" >
  <div class="row">

  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Setup Save</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="setupsave.php" method="POST" enctype="multipart/form-data">
                                    
                                      
                                       
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">HostPath Complete</label>
                                            <input type="text" class="form-control" value="http://javabo.ml" id="hostpath" name="hostpath"  placeholder="http://localhost:8080/hit">
                                        </div>
                                         
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
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