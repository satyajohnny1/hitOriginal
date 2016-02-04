<?php
include 'sessionCheck.php';
include 'db.php';
 
session_start(); 
error_reporting(E_ERROR); 
$uid =  $_SESSION['s_uid'];
$rid =  $_GET ["rid"];
date_default_timezone_set("America/New_York");

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
 $poster='';

 $title = '';
 $fif = '';
 $hun = '';
 $five = '';
 $t5 = '';


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
		$poster = $row["poster"];
		$max_days = $row["max_days"];
		
		
		
		$fif = $row["50d_cen"];
		$sev = $row["75d_cen"];		
		$hun = $row["100d_cen"];
		$onf = $row["150d_cen"];
		$five = $row["175d_cen"];
		$t5 = $row["25d_cen"];
	
		
		
	}
}




$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.rid = ".$rid;
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
		   $wriname=$row["wriname"];
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

$path_150 = 'poster/done/'.$upp."_150.jpeg";
$path_75 = 'poster/done/'.$upp."_75.jpeg";



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
                                         <span><b>Budget</b></span>
                                  <span id="asa" class="n" style="text-align: right;"><b style="font-size:160%;color: red"><?php echo round($sofar/10000000,2) ?> CR</b></span>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Reviews </h3>
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
                                            
                                             <hr/>
                                             <hr style="width: 70%" size="3"/>
 									<div class="row">

                                            <div class="col-md-12">
                                               <button type="button" class="btn btn-info btn-rounded" style="width: 100%"><h2 style="width: 100%;font-size: 25px;"><b><?php echo $hit?></b></h2></button>
                                            </div>
 
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
                                                <img alt='REFRESH Page'  src="<?php echo $path?>" style="width: 100%">
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative; display: none;"   id="pos_150">
                                                <img alt='REFRESH Page'  src="<?php echo $path_150?>" style="width: 100%">
                                            </div>
                                            
                                             <div class="col-md-12" style="position:relative; display: none;"   id="pos_75">
                                                <img alt='REFRESH Page'  src="<?php echo $path_75?>" style="width: 100%">
                                            </div>
                                            
                                            
                                             <div class="col-md-12" style="position:relative; display: none;"   id="pos_50">
                                                <img alt='REFRESH Page'  src="<?php echo $path_50?>" style="width: 100%">
                                            </div>
                                            
                                            <div class="col-md-12" style="position:relative; display: none;"   id="pos_100">
                                                <img alt='REFRESH Page'  src="<?php echo $path_100?>" style="width: 100%">
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-12" style="position:relative; display: none;"   id="pos_175">
                                                <img alt='REFRESH Page'  src="<?php echo $path_175?>" style="width: 100%">
                                            </div>
                                        </div>
                                        
                                                 <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="clock" style="margin:2em;text-align: center;width: 100%"></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                    </div>


                                                </div>



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
                                            <button type="button"  class="btn btn-primary btn-rounded" style="width: 100%;text-align: center;"><h3 class="no-m m-t-xs"><b id="cents" style="font-size: 25px;"></b> <b> Centers</b></h3></button>
                                               
                                            </div>
                                        </div>
									<hr style="width: 70%" size="3"/>
                                    
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
                                               <div  style="width: 100%;text-align: center;color: red;"><h2><b>&nbsp; &nbsp; &nbsp; DAYS</b></h2></div>
                                            </div>
                                        </div>
									<hr style="width: 70%" size="3"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="alert alert-info" role="alert">
                                        <strong>Collections</strong> 
                                    </div>
                                                 <div id="odometer" class="odometer" style="width: 100%;text-align: center;">1000000</div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->

                        <div class="row" >
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <p class="no-s" id="ps">Analaysis</p>
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
                		  "hideDuration": "300",
                		  "timeOut": "2000",
                		  "extendedTimeOut": "1000",
                		  "showEasing": "swing",
                		  "hideEasing": "linear",
                		  "showMethod": "fadeIn",
                		  "hideMethod": "fadeOut"
                }


                toastr.info("<h2> 10 Seconds EQUALS  1 Day</h2>");
                var date1 = new Date("<?php echo $rel_date?>");
                var date2 = new Date("<?php echo date("Y-m-d h:i:s")?>");
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffSeconds = Math.ceil(timeDiff / 1000);

                ////alert('DB DATE ==>   '+date1+'            today DATE ==>   '+date2+'    Time DIFF DATE ==>   '+diffSeconds);
                
                
                // alert('    Time DIFF DATE ==>   '+diffSeconds);

                 

                var clock;

                $(document).ready(function() {

                    //Running Time
                    clock = $('.clock').FlipClock({
                        clockFace: 'Counter',
                        	autoStart: true
                    });

                    clock.setTime(diffSeconds);


                    //Counting collections
                    ajaxCall();
                });



			var poster = '<?php echo $poster?>';
			
           
         // ////alert(poster);

        if(poster=='no')
        {
            	var b 	= 		'<?php echo $_SESSION['s_banner']; ?>';
    			var p 	= 		'<?php echo $_SESSION['s_user']; ?>';
    			var d	=		'<?php echo $dname; ?>' ;   
    			var a 	=		'<?php echo $aname; ?>' ;   
    			var ac	=		'<?php echo $acname; ?>' ;  
    			var c 	=		'<?php echo $cinename; ?>' ;
    			var e	=		'<?php echo $ediname; ?>' ; 
    			var m	=		'<?php echo $musname; ?>' ; 
    			var w	=		'<?php echo $wriname; ?>' ;
    			var tit =		'<?php echo $title; ?>' ;
    			var fif	=		'<?php echo $fif; ?>' ; 
    			var hun	=		'<?php echo $hun; ?>' ; 
    			var fiv	=		'<?php echo $five; ?>' ; 
    			var rid = 		'<?php echo $rid?>';
    			var t5 = 		'<?php echo $t5?>';
    			var sev = 		'<?php echo $sev?>';
    			var onf = 		'<?php echo $onf?>';

    			  var plink = 'poster/poster1.php?rid='+rid+'&b='+b+'&p='+p+'&d='+d+'&a='+a+'&ac='+ac+'&c='+c+'&e='+e+'&m='+m+'&w='+w+'&tit='+tit+'&fif='+fif+'&hun='+hun+'&fiv='+fiv+'&t5='+t5+'&sev='+sev+'&onf='+onf;
    			 //  alert(plink);
    			   
    			   $("#ps").text('http://localhost/hits/'+plink);             
    			            $.ajax({
    			                type: "POST",
    			                url: plink,
    			                success: function(data) {
    			                    toastr.success("<h2>Poster done </h2>");
    			                    <?php 
    	    			                    $sql = "UPDATE `tolly_release` SET `poster`='yes' WHERE  `rid`=".$rid;
    	    			                    mysqli_query($conn, $sql);

    										?>
    			                },
    			                error: function(xhr, status, errorThrown) {
    			                    toastr.error(errorThrown+"Sorry!"+xhr+" --- "+status);
    			                }
    			            })

    			    
        }






			
                
                function ajaxCall() {

                	////alert('Ajax Call');

                    var t1 = clock.getTime();
                    var t2 = (t1 / 10);
                    var day = Math.floor(t2);
                    

                    //$("#t1").text(day+" : Days")
                    
                    //alert('Days --> '+day)
   					 if(day<50)
                    {
                    	$("#pos_0").show();
                    	$("#pos_150").hide();
                  		$("#pos_75").hide();
          				$("#pos_50").hide();
                  		$("#pos_100").hide();
                  		$("#pos_175").hide();
                     }
   					 else if(day>50 && day<75)
                     {$("#pos_150").hide();
               		$("#pos_75").hide();
                     	$("#pos_50").show();
           				$("#pos_0").hide();
                   		$("#pos_100").hide();
                   		$("#pos_175").hide();
                      }
   					else if(day>75 && day<100)
                    {$("#pos_150").hide();
              		$("#pos_50").hide();
                    	$("#pos_75").show();
          				$("#pos_0").hide();
                  		$("#pos_100").hide();
                  		$("#pos_175").hide();
                     }
   					 else if(day>100 && day<150)
                     {
   						$("#pos_150").hide();
                  		$("#pos_75").hide();
                     	$("#pos_100").show();
           				$("#pos_0").hide();
                   		$("#pos_50").hide();
                   		$("#pos_175").hide();
                      }
   					 else if(day>150 && day<175)
                     {
   						$("#pos_100").hide();
                  		$("#pos_75").hide();
                     	$("#pos_150").show();
           				$("#pos_0").hide();
                   		$("#pos_50").hide();
                   		$("#pos_175").hide();
                      }
   					 else if(day>174)
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
                     
                      
                    
                                   

                    var link = 'runningAjax.php?rid='+<?php echo $rid?>+'&day=' + day;

                  //var link =   'runningAjax.php?rid=1&day=5';
                   // //alert(link+'   :  '+day);
                    $.ajax({
                        type: "POST",
                        url: link,
                        success: function(data) {
                           
                            var obj = jQuery.parseJSON(data);
                            var coll = obj.coll;
                            var cent = obj.cent;
                            var status = obj.status;

                           
                           // ////alert("Status ----> "+status);
                            if(status<0)
                            {
                            	 toastr.error("<h1>Movie is Out Of Theators</h1>");
                            	 window.setTimeout(function(){

                            	        // Move to a new location or you can do something else
                            	        window.location.href = "movie.php?rid="+<?php echo $rid?>;

                            	    }, 1000);
                                }else{
                                	 toastr.error("<h1>"+day+" Days in  "+cent+" Centers </h1>");

                                    }

                            
                            var days = new flipCounter('days', {
                                value: day,
                                auto: false
                            });

                            odometer.innerHTML = coll;
							$("#cents").text(cent);
                            
							

                            

                        },
                        error: function(xhr, status, errorThrown) {
                            toastr.error(errorThrown+"Sorry!"+xhr+" --- "+status);
                        }
                    })

                }


                //calling method for every 10 seconds
                window.setInterval(function() {
                    ajaxCall();
                }, 6000);
            </script>

    </body>

    </html> <?php mysql_close($conn);?>