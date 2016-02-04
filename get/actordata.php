<!DOCTYPE html>
<html>

<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="closeRight"><i class="fa fa-times"></i></a></h3>

    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="closeRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>
    <div class="menu-wrap">

        <button class="close-button" id="close-button">Close Menu</button>
    </div>
    <form class="search-form" action="actorupload.php" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control search-input" placeholder="Search...">
            <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
        </div>
        <!-- Input Group -->
    </form>
    <!-- Search Form -->
    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
       	<div class="page-sidebar sidebar">
                  <?php include('sidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">            
            <div id="main-wrapper" >
  <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Actor Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ACtor name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Profile Image Path</label>
                                            <input type="text" class="form-control" id="pic" value="/pic/u1.jpeg" name="pic" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor rate</label>
                                            <input type="number" class="form-control" value="10000000" id="rate" name="rate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor Grade</label>
                                            <input type="text" class="form-control" value="B" id="grade" name="grade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor status</label>
                                            <input type="text" class="form-control" value="available" id="status" name="status"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor rating</label>
                                            <input type="number" class="form-control"id="rating" value="8" name="rating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
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
                <p class="no-s">2015 &copy; Modern by Steelcoders.</p>
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