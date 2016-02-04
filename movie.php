<?php
include 'sessionCheck.php'; 
include 'db.php';
date_default_timezone_set("America/New_York");
error_reporting(E_ERROR);
session_start();  
$uid =  $_SESSION['s_uid'];
$rid =  $_GET ["rid"];

$rel_date = '';
$r1 = 0;
$r2 = 0;
$r3 = 0;
$pic = '';
$aid       = '';
$acid      = '';
$did       = '';
$wid       = '';
$mid       = '';
$eid       = '';
$cid       = '';
$budget    = '';
$collection= '';
$profit    = '';
$sofar     = '';
$grade     = '';
$status    = '';
$pic       = '';
$dt        = '';
$notes     = '';
$dname     = '';
$aname     = '';
$acname    = '';
$s         = '';
$progress  = '';
$rating    = '';
$hit    = '';

$max_days = 0;
$cinename = '';
 $ediname = ''; 
 $musname = ''; 
 $wriname='';



 $wk1_cent = '';
 $wk2_cent = '';
 $d25_cent = '';
 $d50_cent = '';
 $d75_cent = '';
 $d100_cent = '';
 $d150_cent = '';
 $d175_cent = '';
 
 
 $wk1_coll = '';
 $wk2_coll = '';
 $d25_coll = '';
 $d50_coll = '';
 $d75_coll = '';
 $d100_coll = '';
 $d150_coll = '';
 $d175_coll = '';
 
 
$sql = "SELECT * FROM tolly_release s WHERE  s.rid = ".$rid;
//echo $sql;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	// output data of each row
	if($row = mysqli_fetch_assoc($result)) {
		$rel_date = $row["rel_date"];
		$r1 = $row["r1"];
		$r2 = $row["r2"];
		$r3 = $row["r3"];
		$max_days = $row["max_days"];
		

		$wk1_cent = $row["1w_cen"];
		$wk2_cent = $row["2w_cen"];
		$d25_cent = $row["25d_cen"];
		$d50_cent = $row["50d_cen"];
		$d75_cent = $row["75d_cen"];
		$d100_cent = $row["100d_cen"];
		$d150_cent = $row["150d_cen"];
		$d175_cent = $row["175d_cen"];
		
		$wk1_coll = round($row["1w_coll"]/10000000,2);
		$wk2_coll = round($row["2w_coll"]/10000000,2);
		$d25_coll = round($row["25d_coll"]/10000000,2);
		$d50_coll = round($row["50d_coll"]/10000000,2);
		$d75_coll = round($row["75d_coll"]/10000000,2);
		$d100_coll = round($row["100d_coll"]/10000000,2);
		$d150_coll = round($row["150d_coll"]/10000000,2);
		$d175_coll = round($row["175d_coll"]/10000000,2);
	}
}




$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE  s.rid = ".$rid;
//echo $sql;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	// output data of each row
	
	
	if($row = mysqli_fetch_assoc($result)) {
		global  $aid , $acid, $did , $wid , $mid , $eid , $cid , $budget    , $collection, $profit    , $sofar     , $grade     , $status    , $pic , $dt  , $notes     , $dname     , $aname     , $acname    , $s   , $progress  , $rating    , $result    ;
		$aid       = 	$row["aid"];
		$acid      = 	$row["acid"];
		$did       = 	$row["did"];
		$wid       = 	$row["wid"];
		$mid       = 	$row["mid"];
		$eid       = 	$row["eid"];
		$cid       = 	$row["cid"];
		$budget    = 	$row["budget"];
		$collection= 	$row["collection"];
		$profit    = 	$row["profit"];
		$sofar     = 	$row["sofar"];
		$grade     = 	$row["grade"];
		$status    = 	$row["status"];
		$pic       = 	$row["pic"];
		$dt        = 	$row["dt"];
		$notes     = 	$row["notes"];
		
		$s         = 	$row["s"];
		$progress  = 	$row["progress"];
		$rating    = 	$row["rating"];
		$hit    	= 	$row["result"];		
		$dname     = 	$row["dname"];
		$aname     = 	$row["aname"];
		$acname    = 	$row["acname"];
		$cinename = $row["cinename"];
		 $ediname = $row["ediname"];
		  $musname = $row["musname"];
		   $wriname=$row["wriname"];;
		   $title = $row["title"];
		//echo $hit;

	}
}

$upp = strtoupper($title.$rid);

function clean($string) {
	$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}



$path = 'poster/done/'.$upp.".jpeg";
$path_50 = 'poster/done/'.$upp."_50.jpeg";
$path_100 = 'poster/done/'.$upp."_100.jpeg";
$path_175 = 'poster/done/'.$upp."_175.jpeg";


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
                    <div id="main-wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body" style="text-align: center;">
                                       
                                       	<a href="actor.php?id=<?php echo $aid?>" class="btn btn-success btn-rounded"><?php echo $aname?></a>                                        
                                        <a href="actress.php?id=<?php echo $acid?>" class="btn btn-primary btn-rounded"><?php echo $acname?></a>
                                        <a href="director.php?id=<?php echo $did?>" class="btn btn-default btn-rounded"><?php echo $dname?></a>
                                        <a href="music.php?id=<?php echo $mid?>" class="btn btn-info btn-rounded"><?php echo $musname?></a>
                                        <a href="editor.php?id=<?php echo $eid?>" class="btn btn-warning btn-rounded"><?php echo $ediname?></a>
                                        <a href="cine.php?id=<?php echo $cid?>" class="btn btn-danger btn-rounded"><?php echo $cinename?></a>
                                         <a href="writer.php?id=<?php echo $wid?>" class="btn btn-danger btn-rounded"><?php echo $wriname?></a>
                                         <span><b>Profit/Loss</b></span>
                                  <span id="odometer" class="odometer" style="text-align: right;"><?php echo $profit ?></span>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Reviews</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-md-7">
                                                <img src="own/r1.png" style="width: 100%">
                                            </div>

                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-warning">
                                                    <h2 class="no-m m-t-xs"><b><?php echo $r1?>/5</b></h2></button>
                                            </div>

                                        </div>
                                        <hr/>

                                        <div class="row">

                                            <div class="col-md-7">
                                                <img src="own/r2.png" style="width: 100%;">
                                            </div>

                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-danger">
                                                    <h2 class="no-m m-t-xs"><b><?php echo $r2?>/5</b></h2></button>
                                            </div>

                                        </div>

                                        <hr/>
                                        <div class="row">

                                            <div class="col-md-7">
                                                <img src="own/r3.png" style="width: 100%">
                                            </div>

                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-primary">
                                                    <h2 class="no-m m-t-xs"><b><?php echo $r3?>/5</b></h2></button>
                                            </div>

                                        </div>
                                        
                                        <hr/>
 									<div class="row">

                                            <div class="col-md-12">
                                               <button type="button" class="btn btn-info btn-rounded" style="width: 100%"><h2 style="width: 100%;font-size: 25px;"><b><?php echo $hit?></b></h2></button>
                                            </div>
 
                                        </div>

                                        

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                   

                                        <div class="row">
                                           <div class="col-md-12" style="position:relative;display: none;" id="pos_0">
                                                <img src="<?php echo $path?>" style="width: 100%">
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative; display: none;"   id="pos_50">
                                                <img src="<?php echo $path_50?>" style="width: 100%">
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative; display: none;"   id="pos_100">
                                                <img src="<?php echo $path_100?>" style="width: 100%">
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative; display: none;"   id="pos_175">
                                                <img src="<?php echo $path_175?>" style="width: 100%">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-white">

                                    <div class="panel-body">
                                    
                                    
                                    
                                        <div class="row">
                                            <div class="col-md-12">                                               
                                                <div class="clearfix">
                                                    <div class="counter-wrapper">
                                                        <ul class="flip-counter default" id="days" style="width: 100%;text-align: center;"></ul>
                                                    </div>
                                                                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                               <div  style="width: 100%;text-align: center;color: red;"><h2><b> DAYS (max. Run)</b></h2></div>
                                            </div>
                                        </div>
									
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="alert alert-info" role="alert">
                                        <strong>Budget</strong> 
                                    </div>
                                                 <div id="odometer" class="odometer" style="width: 100%;text-align: center;"><?php echo $sofar ?></div>
                                            </div>
                                        </div>
                                         <hr style="width: 70%" size="1"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="alert alert-info" role="alert">
                                        <strong>Collections</strong> 
                                    </div>
                                                 <div id="odometer" class="odometer" style="width: 100%;text-align: center;"><?php echo $collection ?></div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->

                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                             <div class="table-responsive">
                                    <table  class="display table" style="width: 100%; cellspacing: 0;">
                                       <thead>
                                                                <tr>
                                                                    <th>Days</th>
                                                                    <th>Centers</th>
                                                                    <th>Collection</th>                                                                                                                                  
                                                                    
                                                                </tr>
                                                            </thead>
													<!-- actor serach code -->
                                                        
                                                            <tbody>
                                                             <?php 

                                                             echo  "<tr>";
                                                             echo "<td><b> 1st week</b>";
                                                             echo "<td><b>".$wk1_cent." CENTERS</b>";
                                                             echo "<td><b>".$wk1_coll." CRORES</b>";
                                                             echo  "</tr>";
                                                             
                                                             
                                                             
                                                             	echo  "<tr>";
                                                    				echo "<td><b> 2nd week</b>";
                                                    				echo "<td><b>".$wk2_cent." CENTERS</b>";
                                                    				echo "<td><b>".$wk2_coll." CRORES</b>";
                                                    			echo  "</tr>"; 
                                                    					 
                                                    				

                                                    			echo  "<tr>";
                                                    			echo "<td><b> 25 days</b>";
                                                    			echo "<td><b>".$d25_cent." CENTERS</b>";
                                                    			echo "<td><b>".$d25_coll." CRORES</b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			

                                                    			echo  "<tr>";
                                                    			echo "<td><b> 50 days</b>";
                                                    			echo "<td><b>".$d50_cent." CENTERS</b>";
                                                    			echo "<td><b>".$d50_coll." CRORES</b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			

                                                    			echo  "<tr>";
                                                    			echo "<td><b> 75 days</b>";
                                                    			echo "<td><b>".$d75_cent." CENTERS</b>";
                                                    			echo "<td><b>".$d75_coll." CRORES</b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			

                                                    			echo  "<tr>";
                                                    			echo "<td><b> 100 days</b>";
                                                    			echo "<td><b>".$d100_cent." CENTERS</b>";
                                                    			echo "<td><b>".$d100_coll." CRORES</b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			

                                                    			echo  "<tr>";
                                                    			echo "<td><b> 150 days</b>";
                                                    			echo "<td><b>".$d150_cent." CENTERS</b>";
                                                    			echo "<td><b>".$d150_coll." CRORES</b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			

                                                    			echo  "<tr>";
                                                    			echo "<td><b> 175 days</b>";
                                                    			echo "<td><b>".$d175_cent." CENTERS</b>";
                                                    			echo "<td><b>".$d175_coll." CRORES</b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			

                                                    			echo  "<tr>";
                                                    			echo "<td><b> <h2>TOTAL(".$max_days." Days)</h2></b>";
                                                    			echo "<td><b>Budget<h2>".round(($sofar/10000000),2)." CR</h2></b>";
                                                    			echo "<td><b>Collections<h2>".round(($collection/10000000),2)." CR</h2></b>";
                                                    			echo  "</tr>";
                                                    			
                                                    			
                                                    			
                                                    				
                                                                ?>
                                                            </tbody>                                          
                                           
                                        </tbody>
                                       </table>  
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->


                    </div>
                    <!-- Main Wrapper -->

      
       			 <?php include 'share.php';?>

     </div>
                <!-- Page Inner -->
        </main>
        <!-- Page Content -->

        <div class="cd-overlay"></div>

        <?php include 'js.php';?>
            
            <script type="text/javascript">
                toastr.options = {
                		 "closeButton": true,
                		  "debug": false,
                		  "newestOnTop": true,
                		  "progressBar": true,
                		  "positionClass": "toast-top-full-width",
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

                var date1 = new Date("<?php echo $rel_date?>");
                var date2 = new Date();
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffSeconds = Math.ceil(timeDiff / 1000);

                var clock;

                $(document).ready(function() {

                    //Running Time
                    clock = $('.clock').FlipClock({
                        clockFace: 'MinuteCounter'
                    });

                    clock.setTime(diffSeconds);


                    //Counting collections
                    ajaxCall();
                });




                function ajaxCall() {     
                            var days = new flipCounter('days', {
                                value: <?php echo $max_days?>,
                                auto: false
                            });

                            odometer.innerHTML = 1111111111;
							$("#cents").text(cent);

							
                }

                var xday = parseInt("<?php echo $max_days?>");

			//	alert(xday);

				
				
                
				if(xday<50)
                {
                	$("#pos_0").show();
      				$("#pos_50").hide();
              		$("#pos_100").hide();
              		$("#pos_175").hide();
                 }
					 else if(xday>50 && xday<100)
                 {
                 	$("#pos_50").show();
       				$("#pos_0").hide();
               		$("#pos_100").hide();
               		$("#pos_175").hide();
                  }
					 else if(xday>100 && xday<175)
                 {
                 	$("#pos_100").show();
       				$("#pos_0").hide();
               		$("#pos_50").hide();
               		$("#pos_175").hide();
                  }
					 else if(xday>174)
                 {
                 	$("#pos_175").show();
       				$("#pos_0").hide();
               		$("#pos_100").hide();
               		$("#pos_50").hide();
                  }else{
                	  $("#pos_0").show();
        				$("#pos_50").hide();
                		$("#pos_100").hide();
                		$("#pos_175").hide();
                      }
                 

            
            </script>

    </body>

    </html><?php mysql_close($conn);?>