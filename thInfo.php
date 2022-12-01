<?php
include "sessionCheck.php";
session_start();
?>
<!DOCTYPE html>
<html>

<head>
   <?php include "css.php"; ?>
   <style>
h1 {
  color: white;
  text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
  box-shadow: 1px 1px blue;
}

h2 {
  text-shadow: 2px 2px 5px red;
}



</style>
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
        <?php include "navbar.php"; ?>
       	<div class="page-sidebar sidebar">
                  <?php include "sidemenu.php"; ?>  
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



                                   <?php
                                   // Connect to database
                                   include "db.php";

                                   // Get all the categories from category table
                                   $sql = "SELECT * FROM `thearterslist`";
                                   $all_categories = mysqli_query($conn, $sql);


                                   ?>






                                   <form method="POST" action="">
		
		<label>Select a Theator</label>
		<select name="theater">
			<?php // use a while loop to fetch data
   // from the $all_categories variable
   // and individually display as an option
   while ($category = mysqli_fetch_array($all_categories, MYSQLI_ASSOC)): ?>
				<option value="<?php echo $category["id"];
       // The value we usually set is the primary key
       ?>">
					<?php echo $category["name"]."-".$category["city"]." - ".$category["id"];
       // To show the category name to the user
       ?>
				</option>
			<?php endwhile;
// While loop must be terminated
?>
		</select>
		<br>
		<input type="submit" value="submit" name="submit">
	</form>


    <?php
    if(isset($_POST["theater"])){
                                       // Store the Product name in a "name" variable
                                    
                                       $thId=$_POST["theater"];
                                       //echo "Theater Id is => ".$thId;

 


                                       // Creating an insert query using SQL syntax and
                                       // storing it in a variable.
                                       $sql = "SELECT * FROM `thearterslist` where `id` = ".$thId;
                                       //echo "sql => ".$sql;

                                       // The following code attempts to execute the SQL query
                                       // if the query executes with no errors
                                       // a javascript alert message is displayed
                                       // which says the data is inserted successfully

                                       $result = mysqli_query($conn, $sql);

                                        $row = mysqli_fetch_assoc($result);
                                       
                            
                                       
                                           // echo "<br> Theater ID : ".$row['id'];
                                           //capacity - 
                                           echo "Id: ".$row['id']."</br> <h2 style='text-align:center;'>".$row['city']."[".$row['capacity']."]</h2>";
                                            echo "<h1>".$row['name']."</h1>";
                                            

                                    $sql = "SELECT * FROM `centers`";
                                	$result = mysqli_query($conn, $sql);                                                      			

                                    $thStr = $thId.",";
                                    $array25 = array();
                                    $array50 = array();
                                    $array75 = array();
                                    $array100 = array();
                                    $array150 = array();
                                    $array175 = array();
                                    $array200 = array();
                                    $array250 = array();
                                    $array300 = array();
                                    $arraymax = array(); 
                


                                	if (mysqli_num_rows($result) > 0) {
                                		// output data of each row
                                		while($row = mysqli_fetch_assoc($result)) {
						        		$rid 	    = $row['rid'];
						        		$list25     = $row['25list'];
						        		$list50 	= $row['50list'];
						        		$list75 	= $row['75list'];
						        		$list100 	= $row['100list'];
						        		$list150 	= $row['150list'];
						        		$list175 	= $row['175list'];
						        		$list200 	= $row['200list'];
						        		$list250 	= $row['250list'];
						        		$list300 	= $row['300list'];
						        		$maxlist 	= $row['maxlist'];

                        
                                      //   echo "<br> rid => ".$$rid;
                                        // echo "<br> 25 => ".$list25;
                                         //echo "<br> 100 => ".$list100;
                                         //echo "<br> thStr => ".$thStr;




                                        
                                        if (strlen(stristr($list25,$thStr))>0){
                                            array_push($array25, $rid);
                                        }
                                        if (strlen(stristr($list50,$thStr))>0){
                                            array_push($array50, $rid);
                                        }
                                        if (strlen(stristr($list75,$thStr))>0){
                                            array_push($array75, $rid);
                                        }
                                        if (strlen(stristr($list100,$thStr))>0){
                                            array_push($array100, $rid);
                                        }
                                        if (strlen(stristr($list150,$thStr))>0){
                                            array_push($array150, $rid);
                                        }
                                        if (strlen(stristr($list175,$thStr))>0){
                                            array_push($array175, $rid);
                                        }
                                        if (strlen(stristr($list200,$thStr))>0){
                                            array_push($array200, $rid);
                                        }
                                        if (strlen(stristr($list250,$thStr))>0){
                                            array_push($array250, $rid);
                                        }
                                        if (strlen(stristr($list300,$thStr))>0){
                                            array_push($array300, $rid);
                                        }
                                        if (strlen(stristr($maxlist,$thStr))>0){
                                            array_push($arraymax, $rid);
                                        }
                                        
                                		}
                                	}


                                echo "<hr>";
                                echo "25 Days Movies List ************************** START";
                                sort($array25);

                                foreach ($array25 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $actId = $row['aid'];
                                    $actName =$row['aname'];

                                    $dirId = $row['did'];
                                    $dirName = $row['dname'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];

                                    echo $title.", ".$actId.", ".$actName.", ".$dirId.", ".$dirName.", ".$maxdays;


                                }




                                echo "25 Days Movies List ************************** END";




                                       
                                   }

                                   ?>

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

	<?php include "js.php"; ?>
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
<?php if ($conn != null) {
    mysqli_close($conn);
}
?>
