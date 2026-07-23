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
                           
            </div>
            
          
            
            <div id="main-wrapper" >
  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Basic example</h4>
                                </div>
                                <div class="panel-body">
                                   <div class="table-responsive">
                                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                       <thead>
                                                                <tr>
                                                                <th></th>
                                                                    <th>cine</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>PL</th>                                                                     
                                                                    
                                                                </tr>
                                                            </thead>
													<!-- cine serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_cine";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["cine_id"];
                                                    					$dir_name = $row["cine_name"];
                                                    					$dir_rate = $row["cine_rate"];
                                                    					$dir_pic = $row["cine_pic"];                                                    					
                                                    					$dir_cr = round(($dir_rate/10000000),2);   
                                                    					echo "<tr>";
                                                    					echo  "<td><img class=\"img-circle avatar\" src=\"$dir_pic\" width=\"40\" height=\"40\"><a href='cine.php?id=$dir_id' class='btn'></a></td>";
                                                    					echo "<td><a href='cine.php?id=$dir_id' class='btn'>$dir_name</a></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["cine_rating"]."</td>"; 
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
            <!-- Main Wrapper   -->

   		 
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