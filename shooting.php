<?php
include 'sessionCheck.php'; 
include 'db.php';
error_reporting(E_ERROR);
session_start(); 

 
$s1_a_cost = 0;
$s1_b_cost = 0;
$s1_c_cost	= 0;
$s1_a_rate = 0;
$s1_b_rate = 0;
$s1_c_rate = 0;
$s1_status = '';


$s2_a_cost = 0;
$s2_b_cost = 0;
$s2_c_cost	= 0;
$s2_a_rate = 0;
$s2_b_rate = 0;
$s2_c_rate = 0;
$s2_status = '';

$s3_a_cost = 0;
$s3_b_cost = 0;
$s3_c_cost	= 0;
$s3_a_rate = 0;
$s3_b_rate = 0;
$s3_c_rate = 0;
$s3_status = '';

$s4_a_cost = 0;
$s4_b_cost = 0;
$s4_c_cost	= 0;
$s4_a_rate = 0;
$s4_b_rate = 0;
$s4_c_rate = 0;
$s4_status = '';

$s5_a_cost = 0;
$s5_b_cost = 0;
$s5_c_cost	= 0;
$s5_a_rate = 0;
$s5_b_rate = 0;
$s5_c_rate = 0;
$s5_status = '';



$title = '';
$budget = '';
$sofar = '';
$dname = '';
$aname = '';
$acname = '';
$s = '';
$sid = $_GET ["rid"];
$uid =  $_SESSION['s_uid'];
$s_bal =  $_SESSION['s_bal'];

$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.rid = ".$sid." and  s.status = 'ready'";
//echo $sql;
$result = mysqli_query($conn, $sql); 
if (mysqli_num_rows($result) > 0) {	
	$row = mysqli_fetch_assoc($result);
		$title = $row["title"];
		$budget = $row["budget"];
		$sofar = $row["sofar"];
		$dname = $row["dname"];
		$aname = $row["aname"];
		$s = $row["s"];
		//echo 'You are From : '. $s;
}

//*************getting s1 Rates and Reviews *************
$sql = "SELECT * FROM tolly_s1 s WHERE s.sid = ".$sid." and s.uid=".$uid;
//echo "====================". $sql;
$result = mysqli_query ( $conn, $sql );
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows ( $result ) > 0) {
$s1_a_cost      =    	$row["s1_a_cost"];
$s1_b_cost      =    	$row["s1_b_cost"];
$s1_c_cost      =    	$row["s1_c_cost"];
$s1_a_rate      =    	$row["s1_a_rate"];
$s1_b_rate      =    	$row["s1_b_rate"];
$s1_c_rate      =    	$row["s1_c_rate"];
$s1_status      =    	$row["s1_status"];
//echo $s1_b_rate;
}
//*************getting s1 Rates and Reviews *************

//*************getting s2 Rates and Reviews *************
$sql = "SELECT * FROM tolly_s2 s WHERE s.sid = ".$sid." and s.uid=".$uid;
//echo "====================". $sql;
$result = mysqli_query ( $conn, $sql );
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows ( $result ) > 0) {
	$s2_a_cost      =    	$row["s2_a_cost"];
	$s2_b_cost      =    	$row["s2_b_cost"];
	$s2_c_cost      =    	$row["s2_c_cost"];
	$s2_a_rate      =    	$row["s2_a_rate"];
	$s2_b_rate      =    	$row["s2_b_rate"];
	$s2_c_rate      =    	$row["s2_c_rate"];
	$s2_status      =    	$row["s2_status"];
	//echo $s2_b_rate;
	//*************getting s2 Rates and Reviews *************
}

//*************getting s3 Rates and Reviews *************
$sql = "SELECT * FROM tolly_s3 s WHERE s.sid = ".$sid." and s.uid=".$uid;
//echo "====================". $sql;
$result = mysqli_query ( $conn, $sql );
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows ( $result ) > 0) {
	$s3_a_cost      =    	$row["s3_a_cost"];
	$s3_b_cost      =    	$row["s3_b_cost"];
	$s3_c_cost      =    	$row["s3_c_cost"];
	$s3_a_rate      =    	$row["s3_a_rate"];
	$s3_b_rate      =    	$row["s3_b_rate"];
	$s3_c_rate      =    	$row["s3_c_rate"];
	$s3_status      =    	$row["s3_status"];
	//echo $s3_b_rate;
	//*************getting s3 Rates and Reviews *************
	//*************getting s4 Rates and Reviews *************
}

$sql = "SELECT * FROM tolly_s4 s WHERE s.sid = ".$sid." and s.uid=".$uid;
//echo "====================". $sql;
$result = mysqli_query ( $conn, $sql );
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows ( $result ) > 0) {
	$s4_a_cost      =    	$row["s4_a_cost"];
	$s4_b_cost      =    	$row["s4_b_cost"];
	$s4_c_cost      =    	$row["s4_c_cost"];
	$s4_a_rate      =    	$row["s4_a_rate"];
	$s4_b_rate      =    	$row["s4_b_rate"];
	$s4_c_rate      =    	$row["s4_c_rate"];
	$s4_status      =    	$row["s4_status"];
	//echo $s4_b_rate;
	//*************getting s4 Rates and Reviews *************
}

//*************getting s5 Rates and Reviews *************
$sql = "SELECT * FROM tolly_s5 s WHERE s.sid = ".$sid." and s.uid=".$uid;
//echo "====================". $sql;
$result = mysqli_query ( $conn, $sql );
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows ( $result ) > 0) {
	$s5_a_cost      =    	$row["s5_a_cost"];
	$s5_b_cost      =    	$row["s5_b_cost"];
	$s5_c_cost      =    	$row["s5_c_cost"];
	$s5_a_rate      =    	$row["s5_a_rate"];
	$s5_b_rate      =    	$row["s5_b_rate"];
	$s5_c_rate      =    	$row["s5_c_rate"];
	$s5_status      =    	$row["s5_status"];
	//echo $s5_b_rate;
	//*************getting s5 Rates and Reviews *************
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
                        <div class="page-title">

                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="panel info-box panel-white">
                                        <div class="panel-body">
                                            <div class="info-box-stats">
                                                <p class="counter" id="s_sofar"><?php echo $sofar;?></p>
                                                <span class="info-box-title"><h3>So Far</h3></span>
                                            </div>
                                            <div class="info-box-icon">
                                                <i class="icon-users"></i>
                                            </div>
                                            <div class="info-box-progress">
                                                <div class="progress progress-xs progress-squared bs-n">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="panel info-box panel-white">
                                        <div class="panel-body">
                                            <div class="info-box-stats">
                                                <p class="counter" id="s_budget"><?php echo $budget?></p>
                                                <span class="info-box-title"><h3>Movie Budget</h3></span>
                                            </div>
                                            <div class="info-box-icon">
                                                <i class="icon-eye"></i>
                                            </div>
                                            <div class="info-box-progress">
                                                <div class="progress progress-xs progress-squared bs-n">
                                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="panel info-box panel-white">
                                        <div class="panel-body">
                                            <div class="info-box-stats">
                                                <p>$<span class="counter" id="s_bal"><?php echo $s_bal ?></span></p>
                                                <span class="info-box-title"><h3>Balance</h3></span>
                                            </div>
                                            <div class="info-box-icon">
                                                <i class="icon-basket"></i>
                                            </div>
                                            <div class="info-box-progress">
                                                <div class="progress progress-xs progress-squared bs-n">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Row -->
                        </div>





                        <!--  ****************************  BIG DIVS //////// S1 ///////////***************************** -->

                        <div class="row" id="s1">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                               
                                    <div class="panel-body">
                                        <!-- SECENE 1 START -->
                                        <div class="row">
                                            <div class="col-md-4">

                                                <section class="panel">
                                                    <div class="value" id= "s1_a_cost" style="display: none;">
                                                        <h1 class="count" >
                                  								 <?php echo $s1_a_cost?>
                              							</h1>
                                                        <span class="label label-info">Intro Scenes <b id="s1_a_rat" ><?php echo $s1_a_rate?></b></span>
                                                    </div>

                                                     <div class="value" id= "s1_b_cost" style="display: none;">
                                                        <h1 class="count" >
                                								  <?php echo $s1_b_cost?>
                             							 </h1>
                                                        <span class="label label-info">Re-Shoot Cost <b id="s1_b_rat"><?php echo $s1_b_rate?></b></span>
                                                    </div>

                                                    
                                                       <div class="value" id= "s1_comp" style="display: none;">
                                                        <h1 class="count">
							                                 Completed
							                             </h1>
                                                       
                                                    </div>
                                                </section>

                                            </div>
                                            <div class="col-md-4" style="border: 1px solid;">
                                             <div class="panel-body"  style="margin: 0 auto; text-align: center;">
                                             <h2><button type="button" id ="s1_a_btn" style="display: none;" class="btn btn-default btn-rounded">Shoot - Intro Scenes</button></h2>
                                             <button type="button"   style="display: none;" id ="s1_b_btn" class="btn btn-default btn-rounded">Re-Shoot</button> 
                                             
                                              <h2 style="display: none;" id="s1N"><b>Go To Next Short</b></h2>                                                 
                                             </div>
                                             
                                               
                                             
                                              
                                             


                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="cd-pricing-container">
                                                    <header class="cd-pricing-header">
                                                        <h2>Scene-1 Quality </h2>
                                                        <div class="cd-price">
                                                            <span class="cd-value" id="s1_rateid"></span>
                                                            <span class="cd-duration">10</span>
                                                        </div>
                                                        <span class="label label-info"><?php echo $s1_a_rate?> , <?php echo $s1_b_rate?> , <?php echo $s1_c_rate?></span>
                                                    </header>
                                                </div>
                                            </div>
                                             <ul class="pager wizard">
                                                    <li class="previous" id="s1_prv_s1" style="display: none;"><a href="#" class="btn btn-default">Previous</a></li>
                                                    <li class="next" id="s1_nxt_s2" style="display: none;"><a href="#" class="btn btn-default">Next</a></li>
                                                </ul>
                                        </div>
                                        
                                        <!-- SECENE 1 END -->
                                    </div>
                                </div>
                                 
                            </div>                           
                           
                        </div>
                        <!--***************** Row SCENE DIV END -1 ******************* -->
                        
                        
                        
                        
                        <!--  ****************************  BIG DIVS //////// s2 ///////////***************************** -->

                        <div class="row" id="s2" style="display: none;">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                               
                                    <div class="panel-body">
                                        <!-- SECENE 1 START -->
                                        <div class="row">
                                            <div class="col-md-4">

                                                <section class="panel">
                                                    <div class="value" id= "s2_a_cost" style="display: none;">
                                                        <h1 class="count" >
                                  								 <?php echo $s2_a_cost?>
                              							</h1>
                                                        <span class="label label-info">Shoot - Fisst Half Scenes Cost <b id="s2_a_rat" ><?php echo $s2_a_rate?></b></span>
                                                    </div>

                                                     <div class="value" id= "s2_b_cost" style="display: none;">
                                                        <h1 class="count" >
                                								  <?php echo $s2_b_cost?>
                             							 </h1>
                                                        <span class="label label-info">Re-Shoot Cost <b id="s2_b_rat"><?php echo $s2_b_rate?></b></span>
                                                    </div>
                                                       <div class="value" id= "s2_comp" style="display: none;">
                                                        <h1 class="count">
							                                 Completed
							                             </h1>
                                                       
                                                    </div>
                                                </section>

                                            </div>
                                            <div class="col-md-4" style="border: 1px solid;">
                                             <div class="panel-body"  style="margin: 0 auto; text-align: center;">
                                             <h2><button type="button" id ="s2_a_btn" style="display: none;" class="btn btn-default btn-rounded">First Half Scenes</button></h2>
                                             <button type="button"   style="display: none;" id ="s2_b_btn" class="btn btn-default btn-rounded">Re-Shoot</button> 
                                              
                                              <h2 style="display: none;" id="s2N"><b>Go To Next Short</b></h2>                                                 
                                             </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div class="cd-pricing-container">
                                                    <header class="cd-pricing-header">
                                                        <h2>Scene -2 Quality </h2>
                                                        <div class="cd-price">
                                                            <span class="cd-value" id="s2_rateid"></span>
                                                            <span class="cd-duration">10</span>
                                                        </div>
                                                        <span class="label label-info"><?php echo $s2_a_rate?> , <?php echo $s2_b_rate?> , <?php echo $s2_c_rate?></span>
                                                    </header>
                                                </div>
                                            </div>
                                             <ul class="pager wizard">
                                                    <li class="previous" id="s2_prv_s1" style="display: none;"><a href="#" class="btn btn-default">Previous</a></li>
                                                    <li class="next" id="s2_nxt_s3" style="display: none;"><a href="#" class="btn btn-default">Next</a></li>
                                                </ul>
                                        </div>
                                        
                                        <!-- SECENE 1 END -->
                                    </div>
                                </div>
                                 
                            </div>                           
                           
                        </div>
                           <!--  ****************************  BIG DIVS //////// s2 /END//***************************** -->
                        
                        
                           
                        <!--  ****************************  BIG DIVS //////// s3 ///////////***************************** -->

                        <div class="row" id="s3" style="display: none;">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                               
                                    <div class="panel-body">
                                        <!-- SECENE 1 START -->
                                        <div class="row">
                                            <div class="col-md-4">

                                                <section class="panel">
                                                    <div class="value" id= "s3_a_cost" style="display: none;">
                                                        <h1 class="count" >
                                  								 <?php echo $s3_a_cost?>
                              							</h1>
                                                        <span class="label label-info">1st Shot Cost <b id="s3_a_rat" ><?php echo $s3_a_rate?></b></span>
                                                    </div>

                                                     <div class="value" id= "s3_b_cost" style="display: none;">
                                                        <h1 class="count" >
                                								  <?php echo $s3_b_cost?>
                             							 </h1>
                                                        <span class="label label-info">Re-Shoot Cost <b id="s3_b_rat"><?php echo $s3_b_rate?></b></span>
                                                    </div>
                                                    
                                                       <div class="value" id= "s3_comp" style="display: none;">
                                                        <h1 class="count">
							                                 Completed
							                             </h1>
                                                       
                                                    </div>
                                                </section>

                                            </div>
                                            <div class="col-md-4" style="border: 1px solid;">
                                             <div class="panel-body"  style="margin: 0 auto; text-align: center;">
                                             <h2><button type="button" id ="s3_a_btn" style="display: none;" class="btn btn-default btn-rounded">INTERVAL Scenes</button></h2>
                                             <button type="button"   style="display: none;" id ="s3_b_btn" class="btn btn-default btn-rounded">Re-Shoot</button> 
                                             
                                              <h2 style="display: none;" id="s3N"><b>Go To Next Short</b></h2>                                              
                                             </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div class="cd-pricing-container">
                                                    <header class="cd-pricing-header">
                                                        <h2>Scene -3  Quality </h2>
                                                        <div class="cd-price">
                                                            <span class="cd-value" id="s3_rateid"></span>
                                                            <span class="cd-duration">10</span>
                                                        </div>
                                                        <span class="label label-info"><?php echo $s3_a_rate?> , <?php echo $s3_b_rate?> , <?php echo $s3_c_rate?></span>
                                                    </header>
                                                </div>
                                            </div>
                                             <ul class="pager wizard">
                                                    <li class="previous" id="s3_prv_s2" style="display: none;"><a href="#" class="btn btn-default">Previous</a></li>
                                                    <li class="next" id="s3_nxt_s4" style="display: none;"><a href="#" class="btn btn-default">Next</a></li>
                                                </ul>
                                        </div>
                                        
                                        <!-- SECENE 1 END -->
                                    </div>
                                </div>
                                 
                            </div>                           
                           
                        </div>
                           <!--  ****************************  BIG DIVS //////// s3 /END//***************************** -->
						   
						      
                        <!--  ****************************  BIG DIVS //////// s4 ///////////***************************** -->

                        <div class="row" id="s4" style="display: none;">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                               
                                    <div class="panel-body">
                                        <!-- SECENE 1 START -->
                                        <div class="row">
                                            <div class="col-md-4">

                                                <section class="panel">
                                                    <div class="value" id= "s4_a_cost" style="display: none;">
                                                        <h1 class="count" >
                                  								 <?php echo $s4_a_cost?>
                              							</h1>
                                                        <span class="label label-info">1st Shot Cost <b id="s4_a_rat" ><?php echo $s4_a_rate?></b></span>
                                                    </div>

                                                     <div class="value" id= "s4_b_cost" style="display: none;">
                                                        <h1 class="count" >
                                								  <?php echo $s4_b_cost?>
                             							 </h1>
                                                        <span class="label label-info">Re-Shoot Cost <b id="s4_b_rat"><?php echo $s4_b_rate?></b></span>
                                                    </div>
                                                    
                                                       <div class="value" id= "s4_comp" style="display: none;">
                                                        <h1 class="count">
							                                 Completed
							                             </h1>
                                                       
                                                    </div>
                                                </section>

                                            </div>
                                            <div class="col-md-4" style="border: 1px solid;">
                                             <div class="panel-body"  style="margin: 0 auto; text-align: center;">
                                             <h2><button type="button" id ="s4_a_btn" style="display: none;" class="btn btn-default btn-rounded">2nd Half Scenes</button></h2>
                                             <button type="button"   style="display: none;" id ="s4_b_btn" class="btn btn-default btn-rounded">Re-Shoot</button> 
                                             
                                              <h2 style="display: none;" id="s4N"><b>Go To Next Short</b></h2>                                                 
                                             </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div class="cd-pricing-container">
                                                    <header class="cd-pricing-header">
                                                        <h2>Scene -4 Quality </h2>
                                                        <div class="cd-price">
                                                            <span class="cd-value" id="s4_rateid"></span>
                                                            <span class="cd-duration">10</span>
                                                        </div>
                                                        <span class="label label-info"><?php echo $s4_a_rate?> , <?php echo $s4_b_rate?> , <?php echo $s4_c_rate?></span>
                                                    </header>
                                                </div>
                                            </div>
                                             <ul class="pager wizard">
                                                    <li class="previous" id="s4_prv_s3" style="display: none;"><a href="#" class="btn btn-default">Previous</a></li>
                                                    <li class="next" id="s4_nxt_s5" style="display: none;"><a href="#" class="btn btn-default">Next</a></li>
                                                </ul>
                                        </div>
                                        
                                        <!-- SECENE 1 END -->
                                    </div>
                                </div>
                                 
                            </div>                           
                           
                        </div>
                           <!--  ****************************  BIG DIVS //////// s4 /END//***************************** -->
						   
						   
						   
                        
                        
                        
                        
                           
                        <!--  ****************************  BIG DIVS //////// s5 ///////////***************************** -->

                        <div class="row" id="s5" style="display: none;">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                               
                                    <div class="panel-body">
                                        <!-- SECENE 1 START -->
                                        <div class="row">
                                            <div class="col-md-4">

                                                <section class="panel">
                                                    <div class="value" id= "s5_a_cost" style="display: none;">
                                                        <h1 class="count" >
                                  								 <?php echo $s5_a_cost?>
                              							</h1>
                                                        <span class="label label-info">1st Shot Cost <b id="s5_a_rat" ><?php echo $s5_a_rate?></b></span>
                                                    </div>

                                                     <div class="value" id= "s5_b_cost" style="display: none;">
                                                        <h1 class="count" >
                                								  <?php echo $s5_b_cost?>
                             							 </h1>
                                                        <span class="label label-info">Re-Shoot Cost <b id="s5_b_rat"><?php echo $s5_b_rate?></b></span>
                                                    </div>
                                                    
                                                       <div class="value" id= "s5_comp" style="display: none;">
                                                        <h1 class="count">
							                                 Completed
							                             </h1>
                                                       
                                                    </div>
                                                </section>

                                            </div>
                                            <div class="col-md-4" style="border: 1px solid;">
                                             <div class="panel-body"  style="margin: 0 auto; text-align: center;">
                                             <h2><button type="button" id ="s5_a_btn" style="display: none;" class="btn btn-default btn-rounded">CLYMAX Scenes</button></h2>
                                             <button type="button"   style="display: none;" id ="s5_b_btn" class="btn btn-default btn-rounded">Re-Shoot</button> 
                                             <h2 style="display: none;" id="shootCompleted"><b>Shooting Completed</b></h2>      
                                                                                             
                                             </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div class="cd-pricing-container">
                                                    <header class="cd-pricing-header">
                                                        <h2>Scene-5 Quality </h2>
                                                        <div class="cd-price">
                                                            <span class="cd-value" id="s5_rateid"></span>
                                                            <span class="cd-duration">10</span>
                                                        </div>
                                                        <span class="label label-info"><?php echo $s5_a_rate?> , <?php echo $s5_b_rate?> , <?php echo $s5_c_rate?></span>
                                                    </header>
                                                </div>
                                            </div>
                                             <ul class="pager wizard">
                                                    <li class="previous" id="s5_prv_s4" style="display: none;"><a href="#" class="btn btn-default">Previous</a></li>
                                                    <li class="next" style="display: none;" id="lastnext" ><a href="<?php echo 'shootout.php?rid='.$sid.'&uid='.$uid?>" class="btn btn-default">Shooting Completed</a></li>
                                                </ul>
                                        </div>
                                        
                                        <!-- SECENE 1 END -->
                                    </div>
                                </div>
                                 
                            </div>                           
                           
                        </div>
                           <!--  ****************************  BIG DIVS //////// s5 /END//***************************** -->
						   
						   


 							<div class="progress" style="display: none;">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                    70% <b id="curr"><?php echo $s1_a_rate?></b>
                                </div>
                            </div>

                        

                    </div>
                    <!-- Main Wrapper -->
                    <!-- Main Wrapper -->


                    <div class="page-footer">
                        <p class="no-s">2015 &copy; HitandFut.com</p>
                    </div>
                </div>
                <!-- Page Inner -->
        </main>
        <!-- Page Content -->

        <!-- Page Content -->

        <div class="cd-overlay"></div>

        <?php include 'js.php';?>
            <script type="text/javascript">
            ////alert('YEH');
			  
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

 
                var sj_a=0;
                var sj_b=0; 
                var sj_c=0;  
 // ************************  COMMON DATA  ************************
                var rid = <?php echo $sid?>; 
                var sofar = <?php echo $sofar?>;   
              	var s =  '<?php echo '#'.$s.'_btn'?>';
              	var c =  '<?php echo '#'.$s.'_btn'?>';

              	////alert('Mian i think : '+s);
              	$(s).show();
              	

              	var sub = s.substring(4, 5);

            //	////alert(sub);

      
 // ************************  COMMON DATA  ************************
              
                
//******************************************************************************************
// ************************  NEXT and PREVIOUS LOGICS AREA ************************
//******************************************************************************************

                  $(".next").click(function() {
                	  hideAll();
    				var s =  $(this).attr('id');  
    			//	////alert(s);              
                	var cur = '#'+s.substring(0, 2);
                	var nxt = '#'+s.substring(7, 10);

                	var snxt = s.substring(7, 10);
                	var nowb = parseInt(s.substring(1, 2))+1;
                	var nxtb = nowb+1;
                	var prvb = nowb-1;

                	 var prvbtn ='#s'+nowb+'_prv_s'+prvb;						
                     var nxtbtn ='#s'+nowb+'_nxt_s'+nxtb; 
                	

                	//showing the DIVS
                	$(cur).hide();
                	$(nxt).show();



					sjlink = "shootingAjax.php?rid="+rid+"&s="+snxt;
					 $("#curr").text(sjlink);
                    $.ajax({
                        type: "GET",
                         url: sjlink,                         
                            success: function( data ) {
                           var obj = jQuery.parseJSON(data);
                          var _a = obj.a;
                          var _b = obj.b;           
                          var _c = obj.c;

						if(_a==0)
						{
							fun_a();
						}else if(_b==0){
							fun_b();
							}else if(_c==0)
							{
								fun_c();
							}else{
					//alert('in ELSE AREA');
					fun_non();
								}		
                          
                        //toastr.error("NEXT --> a:"+_a+", b:"+_b+" c : "+_c);                      
                             },         
                             error: function( xhr, status, errorThrown ) {
                           
                              toastr.error( "In error" );             
                             }
                       })


                	 

                   function fun_a()
                	{
                    	//alert('a next');
                		$(nxt+'_a_cost').show();
                		$(nxt+'_a_btn').show();  
                		$(nxt+'_b_cost').hide();
                		$(nxt+'_b_btn').hide();
                		$(nxt+'_c_cost').hide();
                		$(nxt+'_c_btn').hide();
                		$(prvbtn).show();
                		$(nxtbtn).hide();     				 
						        				 

                    }
                    function fun_b()
                    {
                    	//alert('b next');
                    	$(nxt+'_a_cost').hide();
                		$(nxt+'_a_btn').hide();
                    	$(nxt+'_b_cost').show();
                		$(nxt+'_b_btn').show(); 
                		$(nxt+'_c_cost').hide();
                		$(nxt+'_c_btn').hide(); 
  
                		$(prvbtn).show();
                		$(nxtbtn).show();     				 
						          			   				 
						        				 
						
                    }
  
                    function fun_non()
                    {
                    	$(nxt+'_comp').show();
                    	$(prvbtn).show();
                		$(nxtbtn).show();
                		//alert('in else');
                        }
                	
                	
                	
                	
                })
                
                //******************************************************************************************//******************************************************************************************
                //******************************************************************************************//******************************************************************************************
                //******************************************************************************************//******************************************************************************************
                
    			
                  $(".previous").click(function() {
                	  hideAll();
    				var s =  $(this).attr('id');                
                	var cur = '#'+s.substring(0, 2);
                	var prv = '#'+s.substring(7, 10);
                	var sprv = s.substring(7, 10);

                	////alert('In CURRENT FULL : '+s);


                	var nowb = parseInt(s.substring(1, 2))-1;
                	var nxtb = nowb+1;
                	var prvb = nowb;

                	 var prvbtn ='#s'+nowb+'_prv_s'+(prvb-1);						
                     var nxtbtn ='#s'+nowb+'_nxt_s'+nxtb; 

                   // ////alert('PRE Button : '+prvbtn);
                    //////alert(' NEXT Button : '+nxtbtn);
                	
                	//////alert('CURREBT '+cur);
                	$(cur).hide();
                	$(prv).show();


                	

					sjlink = "shootingAjax.php?rid="+rid+"&s="+sprv;
                	 $("#curr").text(sjlink);
                    $.ajax({
                        type: "GET",
                         url: sjlink,                         
                            success: function( data ) {
                            	 var obj = jQuery.parseJSON(data);
                                 var _a = obj.a;
                                 var _b = obj.b;           
                                 var _c = obj.c;

       						if(_a==0)
       						{
       							fun_a();
       						}else if(_b==0){
       							fun_b();
       							}else if(_c==0)
       							{
       								fun_c();
       							}else{
       					//alert('in ELSE AREA');
       					fun_non();
       								}		
                                 
                               //toastr.error("NEXT --> a:"+_a+", b:"+_b+" c : "+_c);                  
                            },         
                            error: function( xhr, status, errorThrown ) {
                          
                             toastr.error( "In error" );             
                            }
                      })


               	//alert(_a+' : '+_b+' : '+_c);
                           

                    function fun_a()
                	{//alert('a prv');
                		$(prv+'_a_cost').show();
                		$(prv+'_a_btn').show();  
                		$(prv+'_b_cost').hide();
                		$(prv+'_b_btn').hide();
                		$(prv+'_c_cost').hide();
                		$(prv+'_c_btn').hide();
                		$(prvbtn).show();
                		$(nxtbtn).hide();     				 
						        				 

                    }

                    function fun_b()
                    {//alert('b prv');
                    	$(prv+'_a_cost').hide();
                		$(prv+'_a_btn').hide();
                    	$(prv+'_b_cost').show();
                		$(prv+'_b_btn').show(); 
                		$(prv+'_c_cost').hide();
                		$(prv+'_c_btn').hide(); 
                		$(prvbtn).show();
                		$(nxtbtn).show();     				 
						        				 
						
                    }

                    
                    function fun_non()
                    {
                        ////alert(' Previous ' + prvbtn + "\n Next  : "+nxtbtn);
                    	$(prv+'_comp').show();
                    	$(prvbtn).show();
                		$(nxtbtn).show();     				 
						
                        }
                	
                	
                	
                	
                })
    			
// ************************  NEXT and PREVIOUS LOGICS AREA ************************
//******************************************************************************************//******************************************************************************************//******************************************************************************************//******************************************************************************************
//******************************************************************************************//******************************************************************************************//******************************************************************************************//******************************************************************************************
//******************************************************************************************//******************************************************************************************//******************************************************************************************//******************************************************************************************
				
              	
         
 
 function hideAll(){
                	//  ////alert('Hide Strat');
                	  $("#s1").hide();
                	  $("#s2").hide();    
                	  $("#s3").hide();    
                	  $("#s4").hide();    
                	  $("#s5").hide();    
                	  $("#s6").hide();    
                	  $("#s7").hide();    
                	  $("#s8").hide();    
                	  $("#s9").hide();    
                	


                	  $("#s1_a_cost").hide();
                	  $("#s1_b_cost").hide();
                	  $("#s1_c_cost").hide();
                	  $("#s1_comp").hide();
                	  $("#s1_a_btn").hide();
                	  $("#s1_b_btn").hide();
                	  $("#s1_c_btn").hide();
                	   
                	  $("#s2_a_cost").hide();
                	  $("#s2_b_cost").hide();
                	  $("#s2_c_cost").hide();
                	  $("#s2_comp").hide();
                	  $("#s2_a_btn").hide();
                	  $("#s2_b_btn").hide();
                	  $("#s2_c_btn").hide();


                	  $("#s3_a_cost").hide();
                	  $("#s3_b_cost").hide();
                	  $("#s3_c_cost").hide();
                	  $("#s3_comp").hide();
                	  $("#s3_a_btn").hide();
                	  $("#s3_b_btn").hide();
                	  $("#s3_c_btn").hide();


                	  $("#s4_a_cost").hide();
                	  $("#s4_b_cost").hide();
                	  $("#s4_c_cost").hide();
                	  $("#s4_comp").hide();
                	  $("#s4_a_btn").hide();
                	  $("#s4_b_btn").hide();
                	  $("#s4_c_btn").hide();


                	  $("#s5_a_cost").hide();
                	  $("#s5_b_cost").hide();
                	  $("#s5_c_cost").hide();
                	  $("#s5_comp").hide();
                	  $("#s5_a_btn").hide();
                	  $("#s5_b_btn").hide();
                	  $("#s5_c_btn").hide();



// ////alert('hideend');
           }   


                  /////----------START UP METHOD ----------
 function startUp(){	
                          //  ////alert('Startup');
                            var sub1 = s.substring(0, 3); //s1,s2....
                            var num = parseInt(s.substring(2, 3)); //1,2,3
                            var prv =  num-1;
                            var nxt =  num+1;
						
                            var prvbtn ='#s'+num+'_prv_s'+prv;						
                            var nxtbtn ='#s'+num+'_nxt_s'+nxt; 

							
                            
                            ////alert(num+'Previous value  :  '+prv+'   Next value : '+nxt);
              	if(sub=='a')
              	{
                  	
              		
              		var id1 = sub1+'_a_cost';
              		var id2 = sub1+'_a_btn';
              		
              		$(id1).show();
              		$(id2).show();
              		$(sub1).show();
              		$(prvbtn).show();
              		
              	}else if(sub=='b'){
              		 if(num==9){
                      	$("#lastnext").show();
                      	
                          }
              	 
              		var id1 = sub1+'_b_cost';
              		var id2 = sub1+'_b_btn';
              		$(id1).show();
              		$(id2).show();
              		$(sub1).show();
              		$(nxtbtn).show();
              		$(prvbtn).show();
              		

                  	}else if(sub=='c'){
                  		 if(num==9){
                          	$("#lastnext").show();
                          	
                              }
                  		var id1 = sub1+'_c_cost';
                  		var id2 = sub1+'_c_btn';
                  		$(id1).show();
                  		$(id2).show();
                  		$(sub1).show();
                  		$(nxtbtn).show();
                  		$(prvbtn).show();

                      	}else{

                          	}
                 	
            }


                       

                  hideAll();
                  startUp();

                //============================================================== AJAX CALLS ==========================================
                  
                  
                  //******************** s1 DEV AJAX CALLS  START ************************************
                  
                      $("#s1_a_btn").click(function() {
                          var s1_a_cost = <?php echo  $s1_a_cost?>        
                          var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s1_a&s1_a_cost='+s1_a_cost;
                          $("#curr").text(link);

                             
                      	$.ajax({
                 		     type: "POST",
                 		      url: link,            		    
                 	          success: function( data ) {	             
                 	              
                 	               	var obj = jQuery.parseJSON(data);
                 	       			var rate1 = obj.rate;
                 	       			var sofar1 = obj.sofar;
                 	       			var bal1 = obj.bal;
                 	     			var status1 = obj.status;
                 	     			toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
                 	     			$("#s_sofar").text(sofar1);
                 	     			$("#bal_id").text(bal1);
                 	     			$("#s_bal").text(bal1);
                 	     			$("#s1_rateid").text(rate1);           	     		


                 	     			$("#s1_a_cost").hide();
                    				$("#s1_a_btn").hide();
                    		
                 	     			
                        			$("#s1_b_cost").show();
                        			$("#s1_b_btn").show();
                        			$("#s1_nxt_s2").show();
                                	$("#s1_prv_s1").show();
                 	           },	          
                 	           error: function( xhr, status, errorThrown ) {
                 	        	   toastr.error( "Sorry, there was a problem!" );	              
                 	           }
                 		    })
                      	})
                      	
                      	//=================================================================================
                      	  $("#s1_b_btn").click(function() {
                    var s1_b_cost = <?php echo  $s1_b_cost?> 
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s1_b&s1_b_cost='+s1_b_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status1 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s1_rateid").text(rate1);           	     		


           	     		$("#s1_a_cost").hide();
          				$("#s1_a_btn").hide();
          		
          				$("#s1_b_cost").hide();
          				$("#s1_b_btn").hide();
          		
       	     			
                  			$("#s1_c_cost").show();
                  			$("#s1_c_btn").show();
                  			
                  			$("#s1_nxt_s2").show();
                          	$("#s1_prv_s1").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                
                	
                	//=================================================================================
                	 $("#s1_c_btn").click(function() {
                    var s1_c_cost = <?php echo  $s1_c_cost?>  


                   
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s1_c&s1_c_cost='+s1_c_cost;
                    $("#curr").text(link);
                    $("#curr").text(link);
                    

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status1 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s1_rateid").text(rate1);           	     		


           	     		$("#s1_a_cost").hide();
          				$("#s1_a_btn").hide();
          		
          				$("#s1_b_cost").hide();
          				$("#s1_b_btn").hide();
          		
       	     			
                  			$("#s1_c_cost").hide();
                  			$("#s1_c_btn").hide();

                  			$("#s1_comp").hide();

                  			$("#s1_nxt_s2").show();
                          	$("#s1_prv_s1").show();

                          	
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	  //******************** s1 DEV AJAX CALLS  END ************************************
                	
                	
                	  //******************** s2 DEV AJAX CALLS  START ************************************
            
                $("#s2_a_btn").click(function() {
                    var s2_a_cost = <?php echo  $s2_a_cost?>        
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s2_a&s2_a_cost='+s2_a_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status2 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s2_rateid").text(rate1);           	     		


           	     			$("#s2_a_cost").hide();
              				$("#s2_a_btn").hide();
              		
           	     			
                  			$("#s2_b_cost").show();
                  			$("#s2_b_btn").show();
                  			
                  			$("#s2_nxt_s3").show();
                          	$("#s2_prv_s1").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	
                	//=================================================================================
                	
                	  $("#s2_b_btn").click(function() {
                    var s2_b_cost = <?php echo  $s2_b_cost?>        
      
                    var link =   'ratingAjax.php?&rid='+rid+'&sofar='+sofar+'&now=s2_b&s2_b_cost='+s2_b_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	           
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status2 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s2_rateid").text(rate1);           	     		


           	     		$("#s2_a_cost").hide();
          				$("#s2_a_btn").hide();
          		
          				$("#s2_b_cost").hide();
          				$("#s2_b_btn").hide();
          		
       	     			
                  			$("#s2_c_cost").show();
                  			$("#s2_c_btn").show();
                  			

                  			$("#s2_nxt_s3").show();
                          	$("#s2_prv_s1").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                
                	
                	//=================================================================================
                	
                	  $("#s2_c_btn").click(function() {
                    var s2_c_cost = <?php echo  $s2_c_cost?>        
       
                    var link =   'ratingAjax.php?&rid='+rid+'&sofar='+sofar+'&now=s2_c&s2_c_cost='+s2_c_cost;
                    $("#curr").text(link);
                    $("#curr").text(link);
                    

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status2 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s2_rateid").text(rate1);           	     		


           	     		$("#s2_a_cost").hide();
          				$("#s2_a_btn").hide();
          		
          				$("#s2_b_cost").hide();
          				$("#s2_b_btn").hide();
          		
       	     			
                  			$("#s2_c_cost").hide();
                  			$("#s2_c_btn").hide();


                  			$("#s2_nxt_s3").show();
                          	$("#s2_prv_s1").show();
                        	$("#s2_comp").hide();

                        	$("#s2N").show();
                          	
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	  //******************** s2 DEV AJAX CALLS  END ************************************
                	 //******************** s3 DEV AJAX CALLS  START ************************************
            
                $("#s3_a_btn").click(function() {
                    var s3_a_cost = <?php echo  $s3_a_cost?>        
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s3_a&s3_a_cost='+s3_a_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status3 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s3_rateid").text(rate1);           	     		


           	     			$("#s3_a_cost").hide();
              				$("#s3_a_btn").hide();
              		
           	     			
                  			$("#s3_b_cost").show();
                  			$("#s3_b_btn").show();

                  			$("#s3_nxt_s4").show();
                          	$("#s3_prv_s2").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	
                	//=================================================================================
                	
                	  $("#s3_b_btn").click(function() {
                    var s3_b_cost = <?php echo  $s3_b_cost?>        

                      
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s3_b&s3_b_cost='+s3_b_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status3 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s3_rateid").text(rate1);           	     		


           	     		$("#s3_a_cost").hide();
          				$("#s3_a_btn").hide();
          		
          				$("#s3_b_cost").hide();
          				$("#s3_b_btn").hide();
          		
       	     			
                  			$("#s3_c_cost").show();
                  			$("#s3_c_btn").show();


                  			$("#s3_nxt_s4").show();
                          	$("#s3_prv_s2").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                
                	
                	//=================================================================================
                	
                	  $("#s3_c_btn").click(function() {
                    var s3_c_cost = <?php echo  $s3_c_cost?>        
      
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s3_c&s3_c_cost='+s3_c_cost;
                    $("#curr").text(link);
                    $("#curr").text(link);
                    

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status3 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s3_rateid").text(rate1);           	     		


           	     		$("#s3_a_cost").hide();
          				$("#s3_a_btn").hide();
          		
          				$("#s3_b_cost").hide();
          				$("#s3_b_btn").hide();
          		
       	     			
                  			$("#s3_c_cost").hide();
                  			$("#s3_c_btn").hide();

                  			$("#s3N").show();
                  			$("#s3_nxt_s4").show();
                          	$("#s3_prv_s2").show();
                        	$("#s3_comp").hide();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	  //******************** s3 DEV AJAX CALLS  END ************************************
                	
                	  //******************** s4 DEV AJAX CALLS  START ************************************
            
                $("#s4_a_btn").click(function() {
                    var s4_a_cost = <?php echo  $s4_a_cost?>        
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s4_a&s4_a_cost='+s4_a_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status4 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s4_rateid").text(rate1);           	     		


           	     			$("#s4_a_cost").hide();
              				$("#s4_a_btn").hide();
              		
           	     			
                  			$("#s4_b_cost").show();
                  			$("#s4_b_btn").show();
                  			
                  			$("#s4_nxt_s5").show();
                          	$("#s4_prv_s3").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	
                	//=================================================================================
                	
                	  $("#s4_b_btn").click(function() {
                    var s4_b_cost = <?php echo  $s4_b_cost?>        
     
                    var link =   'ratingAjax.php?&rid='+rid+'&sofar='+sofar+'&now=s4_b&s4_b_cost='+s4_b_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status4 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s4_rateid").text(rate1);           	     		


           	     		$("#s4_a_cost").hide();
          				$("#s4_a_btn").hide();
          		
          				$("#s4_b_cost").hide();
          				$("#s4_b_btn").hide();
          		
       	     			
                  			$("#s4_c_cost").show();
                  			$("#s4_c_btn").show();
                  			
                  			
                  			$("#s4_nxt_s5").show();
                          	$("#s4_prv_s3").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                
                	
                	//=================================================================================
                	
                	  $("#s4_c_btn").click(function() {
                    var s4_c_cost = <?php echo  $s4_c_cost?>        
    
                    var link =   'ratingAjax.php?&rid='+rid+'&sofar='+sofar+'&now=s4_c&s4_c_cost='+s4_c_cost;
                    $("#curr").text(link);
                    $("#curr").text(link);
                    

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status4 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s4_rateid").text(rate1);           	     		
           	     		$("#s4N").show();

           	     		$("#s4_a_cost").hide();
          				$("#s4_a_btn").hide();
          		
          				$("#s4_b_cost").hide();
          				$("#s4_b_btn").hide();
          		
       	     			
                  			$("#s4_c_cost").hide();
                  			$("#s4_c_btn").hide();

                  			
                  			$("#s4_nxt_s5").show();
                          	$("#s4_prv_s3").show();
                        	$("#s4_comp").hide();
                          	
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	  //******************** s4 DEV AJAX CALLS  END ************************************
                	  //******************** s5 DEV AJAX CALLS  START ************************************
            
                $("#s5_a_btn").click(function() {
                    var s5_a_cost = <?php echo  $s5_a_cost?>        
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s5_a&s5_a_cost='+s5_a_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status5 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s5_rateid").text(rate1);           	     		


           	     			$("#s5_a_cost").hide();
              				$("#s5_a_btn").hide();
              		
           	     			
                  			$("#s5_b_cost").show();
                  			$("#s5_b_btn").show();

                  			
                  			$("#s5_nxt_s6").show();
                          	$("#s5_prv_s4").show();
							
													
							$("#shootCompleted").show();													
							$("#lastnext").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                	
                	//=================================================================================
                	
                	  $("#s5_b_btn").click(function() {
                    var s5_b_cost = <?php echo  $s5_b_cost?>        

                         
                    var link =   'ratingAjax.php?rid='+rid+'&sofar='+sofar+'&now=s5_b&s5_b_cost='+s5_b_cost;
                    $("#curr").text(link);

                       
                	$.ajax({
           		     type: "POST",
           		      url: link,            		    
           	          success: function( data ) {	             
           	              
           	               	var obj = jQuery.parseJSON(data);
           	       			var rate1 = obj.rate;
           	       			var sofar1 = obj.sofar;
           	       			var bal1 = obj.bal;
           	     			var status5 = obj.status;
           	     		toastr.info("<h2>"+rate1+"</h2>","Scene Rating "); 
           	     			$("#s_sofar").text(sofar1);
           	     			$("#bal_id").text(bal1);
           	     			$("#s_bal").text(bal1);
           	     			$("#s5_rateid").text(rate1);           	     		


           	     		$("#s5_a_cost").hide();
          				$("#s5_a_btn").hide();
          		
          				$("#s5_b_cost").hide();
          				$("#s5_b_btn").hide();
          		

							
							$("#shootCompleted").show();													
							$("#lastnext").show();
           	           },	          
           	           error: function( xhr, status, errorThrown ) {
           	        	   toastr.error( "Sorry, there was a problem!" );	              
           	           }
           		    })
                	})
                             	
                	
                	  //******************** s5 DEV AJAX CALLS  END ************************************

                	
            </script>

    </body>

    </html> <?php mysqli_close($conn);?>