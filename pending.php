<?php
include 'sessionCheck.php'; 
session_start(); 
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
                <h3>Actors List</h3>                
            </div>
            
          
            
            <div id="main-wrapper" >
  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    
                                </div>
                                <div class="panel-body">
                                   <div class="table-responsive">
                                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                       <thead>
                                                                <tr>
                                                                <th></th>
                                                                    <th>actor</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>PL</th>                                                                    
                                                                    
                                                                </tr>
                                                            </thead>
													<!-- actor serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 

                                                                

                                                            $sql = "SELECT MAX(rid) AS max_page FROM tolly_ready_for_shoot";
                                                                echo '<h2>'.$sql.'</h2>';
                                                                $result = mysqli_query ( $conn, $sql );	 
                                                                if (mysqli_num_rows ( $result ) > 0) {
                                                                $row = mysqli_fetch_assoc($result);
                                                                
                                                            
                                                                $oriid = $row["max_page"];

                                                                
                                                                $minid = floor($oriid/100)*100;
                                                                $maxid = ceil($oriid/100)*100; 
                                                                echo "<h1> Check me : $minid, $maxid , $oriid</h1> ";
                                                                }    

                                                    			$sql = "SELECT * FROM `tolly_actor` WHERE 
`actor_id` NOT IN (SELECT `aid` FROM tolly_ready_for_shoot where rid BETWEEN $minid AND $maxid) AND 
`actor_id` NOT IN (SELECT `a2` FROM tolly_ready_for_shoot where rid BETWEEN $minid AND $maxid) AND 
`actor_id` NOT IN (SELECT `a3` FROM tolly_ready_for_shoot where rid BETWEEN $minid AND $maxid) ";

                                                                 echo '<h2>'.$sql.'</h2>';
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["actor_id"];
                                                    					$dir_name = $row["actor_name"];
                                                    					$dir_rate = $row["actor_rate"];
                                                    					$dir_pic = $row["actor_pic"];                                                    					
                                                    					$dir_cr = round(($dir_rate/10000000),2);   
                                                    					echo "<tr>";
                                                    					echo  "<td><img class=\"img-circle avatar\" src=\"$dir_pic\" width=\"40\" height=\"40\"><a href='actor.php?id=$dir_id' class='btn'></a></td>";
                                                    					echo "<td><a href='actor.php?id=$dir_id' class='btn'>$dir_name</a></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["actor_rating"]."</td>";
																		echo "<td>".$row["pl"]."</td>"; 
                                                    					
                                                    					                                                    					
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>                                          
                                           
                                        </tbody>
                                       </table>  
                                    </div>
                                </div>
                            </div></div></div>
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                   
                                </div>
                                <div class="panel-body">
                                   <div class="table-responsive">
                                    <table id="example3" class="display table" style="width: 100%; cellspacing: 0;">
                                       <thead>
                                                                <tr>
                                                                
                                                                    <th>director</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>PL</th>                                                    
                                                                    
                                                                </tr>
                                                            </thead>
													<!-- director serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_director WHERE `director_id` NOT IN (SELECT `did` FROM tolly_ready_for_shoot where rid BETWEEN $minid AND $maxid) AND `director_id` NOT IN (SELECT `d2` FROM tolly_ready_for_shoot where rid BETWEEN $minid AND $maxid) AND `director_id` NOT IN (SELECT `d3` FROM tolly_ready_for_shoot where rid BETWEEN $minid AND $maxid)";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["director_id"];
                                                    					$dir_name = $row["director_name"];
                                                    					$dir_rate = $row["director_rate"];
                                                    					                                               					
                                                    					$dir_cr = round(($dir_rate/10000000),2);   
                                                    					echo "<tr>";
                                                    					
                                                    					echo "<td><a href='director.php?id=$dir_id' class='btn'>$dir_name</a></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["director_rating"]."</td>";   
																		echo "<td>".$row["pl"]."</td>";                                                  					
                                                    					                                                    					
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>                                          
                                           
                                        </tbody>
                                       </table>  
                                    </div>
                                </div>
                            </div></div></div>
          
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
