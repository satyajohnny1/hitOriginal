<?php
include "sessionCheck.php";
session_start();
?>
<!DOCTYPE html>
<html>

<head>

   <?php include "css.php"; ?>

   <!-- Select2 CSS --> 


   <style>
h1 {
  color: white;
  text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
  box-shadow: 1px 1px blue;
}

h2 {
  text-shadow: 2px 2px 5px green;
}

h3 {
  color: white;
  text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
  box-shadow: 1px 1px blue;
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
		<select name="theater" id='selUser' style='width: 400px;'>
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
	
		<button type="submit" class="btn btn-success"><i class="fa fa-eye"></i> View </button>
	</form>


<br/>
<div id='result'></div>

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
                                           echo "<h3 style='text-align:center;'>Id: ".$row['id'].", ".$row['city']."[Seats : ".$row['capacity']."]</h3>";
                                            echo "<h1>".$row['name']."</h1>";
                                            

                                    $sql = "SELECT * FROM `centers`";
                                	$result = mysqli_query($conn, $sql);                                                      			

                                   
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



                                        $thStr = ",".$thId.",";
                                      //  $thFir = substr($list25, 0, strpos($list25, ','));
                                       // echo "thId:".$thId.", thFir:".$thFir;

                                        if ( (strlen(stristr($list25,$thStr))>0) ||  (substr($list25, 0, strpos($list25, ',')) == $thId) ){
                                            array_push($array25, $rid);
                                        }
                    
                                        if ( (strlen(stristr($list50,$thStr))>0) ||  (substr($list50, 0, strpos($list50, ',')) == $thId)  ||  ($list50 == $thId) ){
                                            array_push($array50, $rid);
                                        } 
                                        if ( (strlen(stristr($list75,$thStr))>0) ||  (substr($list75, 0, strpos($list75, ',')) == $thId) ||  ($list75 == $thId) ){
                                            array_push($array75, $rid);
                                        }
                                        if ( (strlen(stristr($list100,$thStr))>0) ||  (substr($list100, 0, strpos($list100, ',')) == $thId) ||  ($list100 == $thId) ){
                                            array_push($array100, $rid);
                                        }
                                         if ( (strlen(stristr($list150,$thStr))>0) ||  (substr($list150, 0, strpos($list150, ',')) == $thId) ||  ($list150 == $thId) ){
                                            array_push($array150, $rid);
                                        }
                                        if ( (strlen(stristr($list175,$thStr))>0) ||  (substr($list175, 0, strpos($list175, ',')) == $thId)  ||  ($list175 == $thId) ){
                                            array_push($array175, $rid);
                                        }
                                         if ( (strlen(stristr($list200,$thStr))>0) ||  (substr($list200, 0, strpos($list200, ',')) == $thId) ||  ($list200 == $thId) ){
                                            array_push($array200, $rid);
                                        }
                                        if ( (strlen(stristr($list250,$thStr))>0) ||  (substr($list250, 0, strpos($list250, ',')) == $thId) ||  ($list250 == $thId) ){
                                            array_push($array250, $rid);
                                        }
                                       if ( (strlen(stristr($list300,$thStr))>0) ||  (substr($list300, 0, strpos($list300, ',')) == $thId)  ||  ($list300 == $thId) ){
                                            array_push($array300, $rid);
                                        }
                                        if ($maxlist==$thId){
                                            array_push($arraymax, $rid);
                                        }
                                        
                                		}
                                	}


                                //Remove Duplicates From Arrays

                                //1.Remove 50days Cents from 25Centrs
                                $array25 = array_diff($array25,$array50);
                                $array50 = array_diff($array50,$array75);
                                $array75 = array_diff($array75,$array100);
                                $array100 = array_diff($array100,$array150);
                                $array150 = array_diff($array150,$array175);
                                $array175 = array_diff($array175,$array200);
                                $array200 = array_diff($array200,$array250);
                                $array250 = array_diff($array250,$array275);
                                




                                echo "<hr>";
                                echo "<h2>Max Days Movies List</h2>";
                                sort($arraymax);
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($arraymax as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                   
                                    echo "<tr><td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo "<td><code> <b>".$maxdays." Days </b></code> </td> </tr> ";
                                    
                
                                   
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';




            
                                echo "<hr>";
                                echo "<h2>25 Days Movies List</h2>";
                                sort($array25);
                              //  echo '<pre>'; print_r($array50); echo '</pre>';
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($array25 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                if($maxdays<50){
                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                }
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';
            


                                echo "<hr>";
                                echo "<h2>50 Days Movies List</h2>";
                                sort($array50);
                              //  echo '<pre>'; print_r($array50); echo '</pre>';
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($array50 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';




                                echo "<hr>";
                                echo "<h2>75 Days Movies List</h2>";
                                sort($array75);
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($array75 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';




                                echo "<hr>";
                                echo "<h2>100 Days Movies List</h2>";
                                sort($array100);
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($array100 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';


                            



                                echo "<hr>";
                                echo "<h2>150 Days Movies List</h2>";
                                sort($array150);
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($array150 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';





                                echo "<hr>";
                                echo "<h2>175 Days Movies List</h2>";
                                sort($array175);
                                $rowCount = 0;
                                 echo "<table class=\"table\">";
                                foreach ($array175 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';

                                       
                                echo "<hr>";
                                echo "<h2>200 Days Movies List</h2>";
                                sort($array200);
                                $rowCount = 0;
                                foreach ($array200 as $rid) {
                                    $sql = "SELECT * FROM `tolly_ready_for_shoot` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                   

                                    $title = $row['title'];

                                    $aid = $row['aid'];
                                    $aname =$row['aname'];

                                    $did = $row['did'];
                                    $dname = $row['dname'];
                                    $rating = $row['result'];


                                    $sql = "SELECT * FROM `tolly_release` where rid = ".$rid;
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $maxdays = $row['max_days'];
                                    $rowCount++;

                                    echo "<tr>";
                                    echo "<td>".$rowCount."</td>";
                                    echo "<td><code><b><a href=\"movie.php?rid=".$rid."\" target=\"_blank\">". $title."</a></b></code></td>";
                                   	echo "<td><a href=\"actor.php?name=".$aname."&id=".$aid."\" >". $aname."</a></td>";
                                    echo "<td><a href=\"director.php?name=".$dname."&id=".$did."\" >". $dname."</a></td>";
                                    echo "<td><code> <b>".$rating." </b></code> </td>  ";
                                    echo '</tr>';
                                    // echo $title.", ".$aid.", ".$aname.", ".$did.", ".$dname.", ".$maxdays;
                                }
                                 echo '</table>';


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
 
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

$(document).ready(function(){
 
    // Initialize select2
    $("#selUser").select2();
});



	</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 
<!-- Select2 JS --> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

</body>

</html> 
<?php if ($conn != null) {
    mysqli_close($conn);
}
?>
