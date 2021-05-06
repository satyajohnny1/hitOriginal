<?php
include 'sessionCheck.php';
session_start(); 
error_reporting(E_ERROR);
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
            <div id="main-wrapper" >
 
          			 		 <div class="cd-pricing-container">                                    
                                        <ul class="cd-pricing-list cd-bounce-invert">
                                            
                                            <!-- ************* REPEATE THIS ***************** -->
                                          <?php 
                                                    			include 'db.php'; 
                                                    			$uid = $_SESSION['s_uid'];
                                                    			$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.status = 'shootout'";
                                                    			//echo $sql;
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {  
                                                    					$rid = $row["rid"];
                                                    					$title = $row["title"];
                                                    					$budget = $row["result"];
                                                    					$sofar = $row["sofar"];
                                                    					$dname = $row["dname"];
                                                    					$aname = $row["aname"];
                                                    					$acname = $row["acname"];
                                                    					
                                           // echo $rid;        					
                                         	echo "<li class='cd-popular'>";
											echo "<ul class='cd-pricing-wrapper'>";
											echo "<li data-type='monthly' class='is-visible'>";
											echo "<header class='cd-pricing-header'>";
											echo "<h1>".$title."</h1>";
											echo "<h5>".$dname." & ".$aname."</h5>";
											echo "</header>";
											echo "<div class='cd-pricing-body'>";
											echo "<ul class='cd-pricing-features'>";
											echo "<li><em>Cast :</em>  ".$aname." & ".$acname." </li>";
											echo "<li><em>Director :</em> ".$dname."</li>";										
											echo "<li><em>Sofar :</em>  ".$sofar."</li>";											
											echo "</ul>";
											echo "</div>";
											echo "<footer class='cd-pricing-footer'>";																				
											echo "<a class='cd-select' href='release.php?rid=".$rid."'>Release :)</a>";
											echo "</footer>";
											echo "</li>                                             ";
											echo "</ul>";
											echo "</li>";
                                            
                                            
                                            
                                                    					}
                                                    			}  else{
                                                    				echo " <div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                                        <h2>You Don't have Any Movies for Release!! Go To <a href=\"readyforshoot.php\">Shoot</a></h2>
                                    </div> ";
                                                    			}
                                                    			  
                                                                ?>
                                             <!-- ************* REPEATE THIS ***************** -->   
                                            
                                                                           
                                            
                                        </ul> <!-- Mian UL END -->
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

</html> <?php mysqli_close($conn);?>