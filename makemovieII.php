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
            <div class="page-title">
                <h3>Form Wizard</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="userdashboard.php">Home</a></li>
                        <li><a href="#">Forms</a></li>
                        <li class="active">Form Wizard</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-10">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div id="rootwizard">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Movie Details</a></li>
                                        <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Director</a></li>
										 <li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Actors</a></li>
                                        <li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Actress</a></li>
                                        <li role="presentation"><a href="#tab5" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Writer</a></li>
										  <li role="presentation"><a href="#tab6" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Make Sure</a></li>
                                       
                                    </ul>


                                    <div class="progress progress-sm m-t-sm">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        </div>
                                    </div>
                                    <form id="wizardForm">
                                        <div class="tab-content">
                                            <div class="tab-pane active fade in" id="tab1">
                                                <div class="row m_b_lg">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputName">TITLE</label>
                                                                <input type="text" class="form-control" value="Jayam" name="s_title" id="s_title" placeholder="Title">
                                                            </div>
                                                            <div class="form-group  col-md-6">
                                                                <label for="exampleInputName2">Budget</label>
                                                                <input type="text" class="form-control col-md-6" value="1CRORE" name="s_budget" id="s_budget" placeholder="Last Name">
                                                            </div>
   														  
                                                        </div>
                                                    </div>

                                                </div>
                                             <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                <li class="next" id="main_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
                                          

										  <div class="tab-pane fade" id="tab2">
                                                <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                                <label for="exampleInputName">Your DIRECTOR</label>
                                                                <input type="text" class="form-control"  name="s_dir" id="s_dir" placeholder="Choose Director" required="required" disabled="disabled">
                                                                <input type="text" class="form-control"  name="s_dir_id" id="s_dir_id" placeholder="Choose Director" required="required" >
                                                            </div>
                                                 </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Director</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
													<!-- Director serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_director";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["director_id"];
                                                    					$dir_name = $row["director_name"];
                                                    					$dir_rate = $row["director_rate"];
                                                    					$dir_val = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					
                                                    					echo "<tr>";
                                                    					echo "<td><button type='button' class='btn btn-success m_b_sm' data-toggle='modal'  data-target='#myModal'><input type='radio' class='r_dir' name='r_dir' value='".$dir_val."' />".$dir_name."</button></td>";
                                                     					echo "<td>".$dir_rate."</td>";
                                                    					echo "<td>".$row["director_grade"]."</td>";
                                                    					echo  "<td>".$row["director_status"]."</td>";
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                 <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                <li class="next" style="display: none;" id="dir_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
											
											
											  <div class="tab-pane fade" id="tab3">
                                                 <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                                <label for="exampleInputName">Your ACTOR</label>
                                                                <input type="text" class="form-control"  name="s_act" id="s_act" placeholder="Choose actor" required="required" disabled="disabled">
                                                                <input type="text" class="form-control"  name="s_act_id" id="s_act_id" placeholder="Choose actor" required="required" >
                                                            </div>
                                                 </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>actor</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
													<!-- actor serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_actor";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["actor_id"];
                                                    					$dir_name = $row["actor_name"];
                                                    					$dir_rate = $row["actor_rate"];
                                                    					$dir_val = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					
                                                    					echo "<tr>";
                                                    					echo "<td><button type='button' class='btn btn-success m_b_sm' data-toggle='modal'  data-target='#myModal'><input type='radio' class='r_act' name='r_act' value='".$dir_val."' />".$dir_name."</button></td>";
                                                     					echo "<td>".$dir_rate."</td>";
                                                    					echo "<td>".$row["actor_grade"]."</td>";
                                                    					echo  "<td>".$row["actor_status"]."</td>";
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                 <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                <li class="next" style="display: none;" id="act_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
											
											
										  <div class="tab-pane fade" id="tab4">
                                              <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                                <label for="exampleInputName">Your ACTOR</label>
                                                                <input type="text" class="form-control"  name="s_actress" id="s_actress" placeholder="Choose actress" required="required" disabled="disabled">
                                                                <input type="text" class="form-control"  name="s_actress_id" id="s_actress_id" placeholder="Choose actress" required="required" >
                                                            </div>
                                                 </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>actress</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
													<!-- actress serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_actress";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["actress_id"];
                                                    					$dir_name = $row["actress_name"];
                                                    					$dir_rate = $row["actress_rate"];
                                                    					$dir_val = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					
                                                    					echo "<tr>";
                                                    					echo "<td><button type='button' class='btn btn-success m_b_sm' data-toggle='modal'  data-target='#myModal'><input type='radio' class='r_actress' name='r_actress' value='".$dir_val."' />".$dir_name."</button></td>";
                                                     					echo "<td>".$dir_rate."</td>";
                                                    					echo "<td>".$row["actress_grade"]."</td>";
                                                    					echo  "<td>".$row["actress_status"]."</td>";
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                 <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                <li class="next" style="display: none;" id="actress_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                              <div class="tab-pane fade" id="tab5">
                                                  <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                                <label for="exampleInputName">Your WRITER</label>
                                                                <input type="text" class="form-control"  name="s_writer" id="s_writer" placeholder="Choose writer" required="required" disabled="disabled">
                                                                <input type="text" class="form-control"  name="s_writer_id" id="s_writer_id" placeholder="Choose writer" required="required" >
                                                            </div>
                                                 </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>writer</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
													<!-- writer serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_writer";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["writer_id"];
                                                    					$dir_name = $row["writer_name"];
                                                    					$dir_rate = $row["writer_rate"];
                                                    					$dir_val = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					
                                                    					echo "<tr>";
                                                    					echo "<td><button type='button' class='btn btn-success m_b_sm' data-toggle='modal'  data-target='#myModal'><input type='radio' class='r_writer' name='r_writer' value='".$dir_val."' />".$dir_name."</button></td>";
                                                     					echo "<td>".$dir_rate."</td>";
                                                    					echo "<td>".$row["writer_grade"]."</td>";
                                                    					echo  "<td>".$row["writer_status"]."</td>";
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                 <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                <li class="next" style="display: none;" id="writer_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
									
											
									  <div class="tab-pane fade" id="tab6">
                                                <div class="col-md-6">
                                                    <img src="assets/images/envato-logo.png" width="250" alt="">
                                                    <div class="m-t-md">
                                                        <address> 
														SUMMARY
                                                        <address>
                                                                    
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                       <div class="panel-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="title_val" name="title_val">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Budget</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="budget_val" name="budget_val">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Director</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="dirid_val" name="dirid_val">
                                                <input type="text" class="form-control" id="dir_val" name="dir_val">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Actors</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="actid_val" name="actid_val">
                                                <input type="text" class="form-control" id="act_val" name="act_val">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Actress</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="actressid_val" name="actressid_val">
                                                <input type="text" class="form-control" id="actress_val" name="actress_val">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Witer</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="writerid_val" name="writerid_val">
                                                <input type="text" class="form-control" id="writer_val" name="writer_val">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                          <div class="form-group">                                           
                                            <div class="col-sm-6 col-md-offset-4">
                                                 <button type="button" class="btn btn-primary" id="sub_btn">Submit</button>
                                            </div>
                                        </div>
                                        
                                       
                                    </form>
                                </div> 
                                               
                                                </div>
                                               <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                
                                            </ul>
                                            </div>
											
									
									
										
                                            </div>
											 
                                           
                                        </div>
                                    </form>
                                </div>
                          
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                          <div class="col-md-2">
                      
                            <div >
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">                                      
                                            <p><h4>so far :<b>107,200</b></h4></p> 
                                    </div>
                                </div>
                            </div>
                   
                             <div >
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">                                      
                                            <p><h4>Budget :<b>107,200</b></h4></p> 
                                    </div>
                                </div>
                            </div> 
                            
                             <div >
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">                                      
                                            <p><h4>Balance :<b>107,200</b></h4></p> 
                                    </div>
                                </div>
                            </div>
                   
                
               			 </div>
                
                    
                    
                    
                    
                </div>
                <!-- Row -->
          
            </div>
            <!-- Main Wrapper -->


            <div class="page-footer">
                <p class="no-s">2015 &copy; HitandFut.com</p>
            </div>
        </div>
        <!-- Page Inner -->
    </main>
    <!-- Page Content -->
    <nav class="cd-nav-container" id="cd-nav">
        <header>
            <h3>Navigation</h3>
            <a href="#0" class="cd-close-nav">Close</a>
        </header>
        <ul class="cd-nav list-unstyled">
            <li class="cd-selected" data-menu="index">
                <a href="javsacript:void(0);">
                    <span>
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                    <p>Dashboard</p>
                </a>
            </li>
            <li data-menu="profile">
                <a href="javsacript:void(0);">
                    <span>
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                    <p>Profile</p>
                </a>
            </li>
            <li data-menu="inbox">
                <a href="javsacript:void(0);">
                    <span>
                            <i class="glyphicon glyphicon-envelope"></i>
                        </span>
                    <p>Mailbox</p>
                </a>
            </li>
            <li data-menu="#">
                <a href="javsacript:void(0);">
                    <span>
                            <i class="glyphicon glyphicon-tasks"></i>
                        </span>
                    <p>Tasks</p>
                </a>
            </li>
            <li data-menu="#">
                <a href="javsacript:void(0);">
                    <span>
                            <i class="glyphicon glyphicon-cog"></i>
                        </span>
                    <p>Settings</p>
                </a>
            </li>
            <li data-menu="calendar">
                <a href="javsacript:void(0);">
                    <span>
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    <p>Calendar</p>
                </a>
            </li>
        </ul>
    </nav>
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

	
	// ******************** DIRECTOR RATIO ACTIONS START ***********************
	$('.r_dir').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.length);  
		    	$("#s_dir").val(dname);
		    	$("#s_dir_id").val(did);
		    	$("#dirid_val").val(dname);
		    	$("#dir_val").val(did);
		    	$("#dir_next").show();
		     
		    }
		);	
	// ******************** DIRECTOR RATIO ACTIONS END  ***********************

	
	// ******************** ACTOR RATIO ACTIONS START ***********************
	$('.r_act').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.length);  
		    	$("#s_act").val(dname);
		    	$("#s_act_id").val(did);
		    	$("#actid_val").val(dname);
		    	$("#act_val").val(did);
		    	$("#act_next").show();
		     
		    }
		);	
	// ******************** ACTOR RATIO ACTIONS END  ***********************
	
	// ******************** Aactres RATIO ACTIONS START ***********************
	$('.r_actress').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.length);  
		    	$("#s_actress").val(dname);
		    	$("#s_actress_id").val(did);
		    	$("#actressid_val").val(dname);
		    	$("#actress_val").val(did);
		    	$("#actress_next").show();
		     
		    }
		);	
	// ******************** Aactres RATIO ACTIONS END  ***********************

	
	// ******************** WRITER RATIO ACTIONS START ***********************
	$('.r_writer').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.length);  
		    	$("#s_writer").val(dname);
		    	$("#s_writer_id").val(did);
		    	$("#writerid_val").val(dname);
		    	$("#writer_val").val(did);
		    	$("#writer_next").show();
		     
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************

	
	
	// ******************** Mian Next Click ***********************
	$('#main_next').click(
		    function(){
			   
		    	var t = 	$("#s_title").val();
		    	var b = 	$("#s_budget").val();		    
		    	$("#title_val").val(t);
		    	$("#budget_val").val(b);
		    	
		     
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************

	
		
	// ******************** Submit button  Next Click ***********************
	$('#sub_btn').click(
		    function(){
			    
		    	var tit = $("#title_val").val(); 		    	
		    	 var bud = $("#budget_val").val(); 
		    	var did= $("#dirid_val").val(); 
		    	var dv= $("#dir_val").val();
		    	var aid= $("#actid_val").val();
		    	var av= $("#act_val").val();
		    	var acid= $("#actressid_val").val();
		    	var acv= $("#actress_val").val();
		    	var wid= $("#writerid_val").val();
		    	var wv= $("#writer_val").val(); 
 
		    	if(tit.length<1){
		    		toastr.info("Enter Title ");
		    					}
		    	else if(bud.length<1){
		    		toastr.info("Enter Budget : Go To Main Tab ");
		    					}
		    		    	
		    	else if(did.length<1 || dv.length<1){
		    		toastr.info("Enter DIRECTOR : Go To DIRECTOR  Tab ");
		    					}
		     
		    		    	
		    	else if(aid.length<1 || av.length<1){
		    		toastr.info("Enter ACTOR : Go To ACTOR  Tab ");
		    					}
		    		    	
		    	else if(acid.length<1 || acv.length<1){
		    		toastr.info("Enter ACTRESS : Go To ACTRESS  Tab ");
		    					}
		     
		    	else if(wid.length<1 || w.length<1){
		    		toastr.info("Enter WRITER  : Go To WRITER  Tab ");
		    					}  	
		    	else{
		    		toastr.info("Good ");
			    	}
		    		     
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************
	
	
	
	</script>

</body>

</html> <?php mysqli_close($conn);?>