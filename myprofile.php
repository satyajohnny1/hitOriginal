<?php
include 'sessionCheck.php';
include 'db.php';
session_start();
$uid = $_SESSION['s_uid'];
$uname = '';
$password = '';
$email = '';
$banner = '';
$pic = '';
$balnc = 0.0;

$sql = "SELECT * FROM tolly_user s WHERE  s.uid = ".$uid;
//echo $sql;
$result = mysqli_query ( $conn, $sql );
if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$uname = $row["username"];
		$password = $row["password"];
		$email = $row["email"];
		$banner = $row["banner"];
		$pic = $row["pic"];	
		$balnc =  $row["bal"];

		$_SESSION["s_user"] = $row["username"];
		$_SESSION['s_banner'] = $row["banner"];
	}
	

 
?>
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
        <form class="search-form" action="#" method="GET">
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
                    <div id="main-wrapper">
                        <div class="row">
                            <div class="col-md-3">
                             <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title">Banner Logo</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-12" style="position:relative;">
                                        <img src="<?php echo $pic?>" id="mpic" style="width: 100%;height: 300px;">
                                    </div>
                                </div>
                                
                                
                                  <form action="myuploadAjax.php" name="pic_form" id="pic_form"  method="POST" enctype="multipart/form-data">
                                    
                                      <div class="form-group"  style="display: none;">
                                          <label for="input-Default" class="col-sm-2 control-label">Name</label>
                                                 <div class="col-sm-5">
                                                     <input type="text" class="form-control"  name="uname" id="uname"   value="<?php echo $uname?>">
                                                  </div>
                                         </div>
                                         <div class="form-group" style="display: none;">                                           
                                            <input type="text" class="form-control" id="itype" value="pic" name="itype"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">                                           
                                            <input type="file" class="btn" name="files[]" multiple="multiple" accept="image/*">                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary" id="picbtn">Uplaod</button>
                                    </form>
                            </div>
</div>



                            <div class="col-md-9">

                                <div class="panel panel-white">
                                    <div class="panel-heading clearfix">
                                        <h3 class="panel-title">Profile</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tabs-left" role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#tab9" role="tab" data-toggle="tab">Profile</a></li>
                                                <li role="presentation"><a href="#tab10" role="tab" data-toggle="tab">Change Password</a></li>

                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active fade in" id="tab9">
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>

                                                    <form class="form-horizontal" name="prof_form" id="prof_form" method="post" >
                                                        <div class="form-group">
                                                            <label for="input-Default" class="col-sm-2 control-label">Email</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $email?>">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="input-Default" class="col-sm-2 control-label">Name</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control"  name="uname" id="uname"   value="<?php echo $uname?>">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="input-Default" class="col-sm-2 control-label">Banner Name</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control"  name="banner" id="banner"   value="<?php echo $banner?>">
                                                            </div>
                                                        </div>
							    
							  <div class="form-group">
                                                            <label for="input-Default" class="col-sm-2 control-label">Balance</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control"  name="bal" id="bal"   value="<?php echo $balnc?>">
                                                            </div>
                                                        </div>   
                                                        
                                                        

                                                        <div class="form-group"  style="display: none;">
                                                            <label for="input-Default" class="col-sm-2 control-label">Type</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control"  name="itype" id="itype"  value="pro">
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="button" class="btn btn-success" id="probtn">Update Changes</button>
                                                            </div>
                                                        </div>

                                                    </form>


                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab10">
                                                    <div class="col-md-6">
                                                        <div class="panel panel-white">
                                                            <div class="panel-heading clearfix">
                                                                <h4 class="panel-title">Change Password</h4>
                                                            </div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" name="pwd_form" id="pwd_form">
                                                                    <div class="form-group">

                                                                        <div class="col-sm-10">
                                                                            <input type="password" class="form-control"  name="password" id="password"  placeholder="Enter New password" value="   value="<?php echo $password?>">
                                                                        </div>
                                                                    </div>
  													<div class="form-group" >
                                                            <label for="input-Default" class="col-sm-2 control-label">Type</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control"  name="itype" id="itype"  style="display: none;"  value="pwd">
                                                            </div>
                                                        </div>
                                                        
                                                                    <div class="form-group">
                                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                            <button type="button" class="btn btn-success" id="pwdbtn">Change Password</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
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

//alert('loaded');

                $("#probtn").click(function() {                   
              	  var str = $("#prof_form").serialize();			    
              	
        		    $.ajax({
        		     type: "POST",
        		      url: "myprofileAjax.php",
        		      data: str,
        	          success: function( data ) {	
            	          //alert('DATA '+data);
        	        	  //toastr.info(data," Notification "); 
        	        	  var obj = jQuery.parseJSON(data);
                          var msg = obj.msg;                
                          var status = obj.status;                    
        	              toastr.info(msg," Notification ");  
        	           } 
        		    })
                	  });
                

                $("#pwdbtn").click(function() {                   
              	  var str = $("#pwd_form").serialize();			    
              	  //alert('CHANGE PWD '+str);
        		    $.ajax({
        		     type: "POST",
        		      url: "myprofileAjax.php",
        		      data: str,
        	          success: function( data ) {	
            	          //alert('DATA '+data);
        	        	  //toastr.info(data," Notification "); 
        	        	  var obj = jQuery.parseJSON(data);
                          var msg = obj.msg;                
                          var status = obj.status;                    
        	              toastr.info(msg," Notification ");  
        	           } 
        		    })
                	  });


                
            </script>

    </body>

    </html> 
 
<?php 
if($conn!=null){
mysqli_close($conn);
}
?>
