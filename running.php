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

 $_a2 = '';
 $_a3 = '';
 $_ac2 = '';
 $_ac3 = '';
 $_w2 = '';
 $_w3 = '';
 $_m2 = '';
 $_m3 = '';
 $_d2 = '';
 $_d3 = '';
 
 
 $_a2_name = '';
 $_a3_name = '';
 $_ac2_name = '';
 $_ac3_name = '';
 $_w2_name = '';
 $_w3_name = '';
 $_m2_name = '';
 $_m3_name = '';
 $_d2_name = '';
 $_d3_name = '';
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
		   $_a2 = $row["a2"];
		   $_a3 = $row["a3"];
		   $_ac2 = $row["ac2"];
		   $_ac3 = $row["ac3"];
		   $_w2 = $row["w2"];
		   $_w3 = $row["w3"];
		   $_m2 = $row["m2"];
		   $_m3 = $row["m3"];
		   $_d2 = $row["d2"];
		   $_d3 = $row["d3"];
		   
		   
		   $_a2_name = $row["a2_name"];
		   $_a3_name = $row["a3_name"];
		   $_ac2_name = $row["ac2_name"];
		   $_ac3_name = $row["ac3_name"];
		   $_w2_name = $row["w2_name"];
		   $_w3_name = $row["w3_name"];
		   $_m2_name = $row["m2_name"];
		   $_m3_name = $row["m3_name"];
		   $_d2_name = $row["d2_name"];
		   $_d3_name = $row["d3_name"];

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
                                       
                                       	<?php
                                       	echo "<a href=\"actor.php?name=".$aname."&id=".$aid."\" class=\"btn btn-info btn-rounded\">". $aname."</a>";
                                        
                                       		if($_a2>0)
                                       		{
                                       			echo "<a href=\"actor.php?name=".$_a2_name."&id=".$_a2."\" class=\"btn btn-primary btn-rounded\">". $_a2_name."</a>";
                                       		}
                                       		
                                       		if($_a3>0)
                                       		{
                                       			echo "<a href=\"actor.php?name=".$_a3_name."&id==".$_a3."\" class=\"btn btn-warning  btn-rounded\">". $_a3_name."</a>";
                                       		}
                                     
                                       		echo "<a href=\"director.php?name=".$dname."&id=".$did."\" class=\"btn btn-warning btn-rounded\">". $dname."</a>";
                                        
                                       		if($_d2>0)
                                       		{
                                       			echo "<a href=\"director.php?name=".$_d2_name."&id=".$_d2."\" class=\"btn btn-primary btn-rounded\">". $_d2_name."</a>";
                                       		}
                                       		
                                       		if($_d3>0)
                                       		{
                                       			echo "<a href=\"director.php?name=".$_d3_name."&id==".$_d3."\" class=\"btn btn-danger  btn-rounded\">". $_d3_name."</a>";
                                       		}
                                       	?>
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
											<strong><a href="#" id="posterRegen">Poster rgn</strong> 
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->

                        <div class="row" >
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body" style="text-align: center;">
                                    
                                    	<?php
                                       		echo "<a href=\"actress.php?name=".$acname."&id=".$acid."\" class=\"btn btn-info btn-rounded\">". $acname."</a>";
                                        
                                       		if($_ac2>0)
                                       		{
                                       			echo "<a href=\"actress.php?name=".$_ac2_name."&id=".$_ac2."\" class=\"btn btn-primary btn-rounded\">". $_ac2_name."</a>";
                                       		}
                                       		
                                       		if($_ac3>0)
                                       		{
                                       			echo "<a href=\"actress.php?name=".$_ac3_name."&id==".$_ac3."\" class=\"btn btn-warning  btn-rounded\">". $_ac3_name."</a>";
                                       		}
                                    

                                       		if($_m2>0)
                                       		{
                                       			echo "<a href=\"music.php?name=".$_m2_name."&id=".$_m2."\" class=\"btn btn-danger btn-rounded\">". $_m2_name."</a>";
                                       		}
                                       		 
                                       		if($_m3>0)
                                       		{
                                       			echo "<a href=\"music.php?name=".$_m3_name."&id=".$_m3."\" class=\"btn btn-warning btn-rounded\">". $_m3_name."</a>";
                                       		}
                                       		 
                                       		if($_w2>0)
                                       		{
                                       			echo "<a href=\"writer.php?name=".$_w2_name."&id=".$_w2."\" class=\"btn btn-primary btn-rounded\">". $_w2_name."</a>";
                                       		}
                                       		
                                       		if($_w3>0)
                                       		{
                                       			echo "<a href=\"writer.php?name=".$_w3_name."&id=".$_w3."\" class=\"btn btn btn-warning btn-rounded\">". $_w3_name."</a>";
                                       		}
                                       		
                                       		
                                       
                                       	   
                                         echo "<a href=\"music.php?name=".$musname."&id=".$mid."\" class=\"btn btn btn-primary btn-rounded\">". $musname."</a>";
                                         echo "<a href=\"writer.php?name=".$wriname."&id=".$wid."\" class=\"btn btn btn-danger btn-rounded\">". $wriname."</a>";
                                         ?>
                                        <a href="editor.php?id=<?php echo $eid?>" class="btn btn-warning btn-rounded"><?php echo $ediname?></a>                                       
                                         <a href="writer.php?id=<?php echo $wid?>" class="btn btn-danger btn-rounded"><?php echo $wriname?></a>
                                          <a href="cine.php?id=<?php echo $cid?>" class="btn btn-primary btn-rounded"><?php echo $cinename?></a>
										  <a href="forceout.php?id=<?php echo $rid?>" class="btn btn-warning btn-rounded">ForceOut</a>  
                                       <p id="ps" style="display: none;">Link</p>
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
			//poster = 'no';
           
         //alert(poster);

       // 
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

    			var a2 = 		'<?php echo $_a2_name?>';
    			var a3 = 		'<?php echo $_a3_name?>';
    			var ac2 = 		'<?php echo $_ac2_name?>';
    			var ac3 = 		'<?php echo $_ac3_name?>';
    			var d2 = 		'<?php echo $_d2_name?>';
    			var d3 = 		'<?php echo $_d3_name?>';
    			var m2 = 		'<?php echo $_m2_name?>';
    			var m3 = 		'<?php echo $_m3_name?>';
    			var w2 = 		'<?php echo $_w2_name?>';
    			var w3 = 		'<?php echo $_w3_name?>';

    			var a2Chk = '<?php echo $_a2?>';
    			var a3Chk = '<?php echo $_a3?>';

				var url = window.location.href;
				var arr = url.split("/"); 
				var hostname = arr[0] + "//" + arr[2];
				
				if(hostname.includes("localhost")){
					hostname = hostname+"/hit";
					//alert(hostname);
				}
					
    			 var plink = hostname+'/poster/poster1.php?rid='+rid+'&b='+b+'&p='+p+'&d='+d+'&a='+a+'&ac='+ac+'&c='+c+'&e='+e+'&m='+m+'&w='+w+'&tit='+tit+'&fif='+fif+'&hun='+hun+'&fiv='+fiv+'&t5='+t5+'&sev='+sev+'&onf='+onf
   			  +'&a2='+a2+'&a3='+a3+'&ac2='+ac2+'&ac3='+ac3+'&d2='+d2+'&d3='+d3+'&w2='+w2+'&w3='+w3+'&m2='+m2+'&m3='+m3;
   			 
    		
				
			
    			if(a2Chk>0)
    			{
    				 plink = hostname+'/poster/poster2.php?rid='+rid+'&b='+b+'&p='+p+'&d='+d+'&a='+a+'&ac='+ac+'&c='+c+'&e='+e+'&m='+m+'&w='+w+'&tit='+tit+'&fif='+fif+'&hun='+hun+'&fiv='+fiv+'&t5='+t5+'&sev='+sev+'&onf='+onf
       			  +'&a2='+a2+'&a3='+a3+'&ac2='+ac2+'&ac3='+ac3+'&d2='+d2+'&d3='+d3+'&w2='+w2+'&w3='+w3+'&m2='+m2+'&m3='+m3;
       			 
            	}

    			
    			if(a3Chk>0)
    			{
    				 plink = hostname+'/poster/poster3.php?rid='+rid+'&b='+b+'&p='+p+'&d='+d+'&a='+a+'&ac='+ac+'&c='+c+'&e='+e+'&m='+m+'&w='+w+'&tit='+tit+'&fif='+fif+'&hun='+hun+'&fiv='+fiv+'&t5='+t5+'&sev='+sev+'&onf='+onf
       			  +'&a2='+a2+'&a3='+a3+'&ac2='+ac2+'&ac3='+ac3+'&d2='+d2+'&d3='+d3+'&w2='+w2+'&w3='+w3+'&m2='+m2+'&m3='+m3;
       			 
            	}
				console.log("hostname : "+hostname);
    			console.log("plink ::"+plink);
				document.cookie = 'plink='+plink;
    			 
    			   
    			   $("#ps").text(plink);             
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
    			            setTimeout("location.reload(true);", 15000);  
    			              
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
				
				
				function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
				
				var plinkvalue = readCookie('plink');
				
				console.log("Get Cookie : plinkvalue: "+plinkvalue);
				document.getElementById("posterRegen").href = plinkvalue;
				
            </script>

    </body>

    </html> <?php mysqli_close($conn);?>