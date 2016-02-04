<?php
 
include 'sessionCheck.php'; 
include 'db.php';
date_default_timezone_set("America/New_York");
error_reporting(E_ERROR);
session_start();  
$uid =  $_SESSION['s_uid'];


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

 $rid =  '';


$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE s.uid = ".$uid;
//echo $sql;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	// output data of each row
	
	
	if($row = mysqli_fetch_assoc($result)) {
		global  $aid , $acid, $did , $wid , $mid , $eid , $cid , $budget    , $collection, $profit    , $sofar     , $grade     , $status    , $pic , $dt  , $notes     , $dname     , $aname     , $acname    , $s   , $progress  , $rating    , $result    ;
		$aid       = 	$row["aid"];
		$rid       = 	$row["rid"];
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
$path = 'poster/done/'.$title.$rid.".jpeg";
$path_50 = 'poster/done/'.$title.$rid."_50.jpeg";
$path_100 = 'poster/done/'.$title.$rid."_100.jpeg";
$path_175 = 'poster/done/'.$title.$rid."_175.jpeg";


$sql = "SELECT * FROM tolly_release s WHERE s.uid = ".$uid." and s.rid = ".$rid;
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
	}
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
                         <!-- Row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <h2>Share and Earn money ! Earn Upto <a>10CRORES</a> On each Share</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        <!-- Row -->
                        <div class="row">
                   
                            <div class="col-md-8">                               
                               <div class="panel panel-white">
                                    <div class="panel-body">
                                   

                                        <div class="row">
                                            <div class="col-md-12" style="position:relative;">
                                                <img src="<?php echo $path?>" style="width: 100%">
                                                <br><br>
                                                 <span class="share"><?php include 'share.php';?></span>
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative;"><br><br>
                                                <img src="<?php echo $path_50?>" style="width: 100%"><br><br>
                                                 <span class="share"><?php include 'share.php';?></span>
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative;"><br><br>
                                                <img src="<?php echo $path_100?>" style="width: 100%"><br><br>
                                                 <span class="share"><?php include 'share.php';?></span>
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
                //alert('Ready');
                $(".share").click(function(){
                	ajaxCall();
               	
                	});
               

            	function ajaxCall(){
                	//alert('in ajax');
            	    $.ajax({
           		     type: "POST",
           		      url: "earnAjax.php",           		    
           	          success: function( data ) {	
               	          //alert('DATA '+data);
           	        	  
                            var obj = jQuery.parseJSON(data);
                            var m = obj.a;
           	        	  
           	        	  
               	       setTimeout(function(){
               	    	 toastr.error("You Got "+m+"Ruppess, Please Reload the Page");
               	    	}, 25000);
           	              
           	           } 
           		    })

                	}
            
            </script>

    </body>

    </html> <?php mysql_close($conn);?>