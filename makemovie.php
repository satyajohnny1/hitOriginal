<?php
include 'sessionCheck.php';
session_start(); 
error_reporting(E_ERROR);
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
                <h3>Make A Movie - In 3 Steps!!!</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Casting</a></li>
                        <li><a href="#">Shooting</a></li>
                        <li><a href="#">Release</a></li>
                         
                    </ol>
                </div>
            </div>
            <div id="main-wrapper" >
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
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputName">TITLE</label>
                                                                <input type="text" class="form-control"  name="s_title" id="s_title" placeholder="Title"  required="required">
                                                            </div>
                                                            <div class="form-group  col-md-2">
                                                                <label for="exampleInputName2">Budget In Cr's</label>
                                                                <input type="number" class="form-control col-md-6" min="1" max="<?php echo round(($_SESSION['s_bal']/10000000),2)?>" name="inC" id="inC" placeholder="for 0.01 is one lack" required="required">
                                                            </div>
                                                            
                                                            <div class="form-group  col-md-4">
                                                                <label for="exampleInputName2">Budget in Rs</label>
                                                                <input type="text" class="form-control col-md-6" min="7" name="s_budget" id="s_budget" placeholder="In Ruppes" required="required" disabled="disabled">
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
                                                               
                                                                <input type="text" class="form-control"  name="s_dir" id="s_dir" placeholder="Choose Director" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_dir_id" id="s_dir_id" placeholder="Choose Director" required="required" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_dir_rem" value="0" id="s_dir_rem" placeholder="Choose Director" required="required" style="display: none;">
                                                            </div>
                                                 </div>
                                                   <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id="dpic" style="width: 100%;height: 300px;" >
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
                                                                    <th style="display: none;">pic</th>
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
                                                    					$dir_pic = $row["director_pic"];
                                                    					
                                                    					$dir_cr = round(($dir_rate/10000000),2);
                                                    					
                                                    					$dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate.'^'.$dir_pic;
                                                    					
                                                    					echo "<tr>";
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' width='4em' height='4em' class='r_dir' name='r_dir' value='".$dir_id."' /><b>".$dir_name."</b></label></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["director_grade"]."</td>";                                                    					
                                                    					echo  "<td style='display: none;'>".$dir_pic."</td>";
                                                    					
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
                                                              
                                                                <input type="text" class="form-control"  name="s_act" id="s_act" placeholder="Choose Actor" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_act_id" id="s_act_id" placeholder="Choose Actor" required="required" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_act_rem" id="s_act_rem" value="0" placeholder="Choose Actor" required="required" >
                                                            </div>
                                                 </div>
                                                 
                                                      <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id="apic" style="width: 100%;height: 300px;" >
                                            </div> 
                                            </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example3" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Actor</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                   
                                                                </tr>
                                                            </thead>
													<!-- Actor serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_actor";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$act_id = $row["actor_id"];
                                                    					$act_name = $row["actor_name"];
                                                    					$act_rate = $row["actor_rate"];
                                                    					$a_pic = $row["actor_pic"];
                                                    					$act_id = $act_id.'#'.$act_name.'$'.$act_rate.'^'.$a_pic;
                                                    					
                                                    					$dir_cr = round(($act_rate/10000000),2);
                                                    					
                                                    					echo "<tr>";                                                    					
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_act' name='r_act' value='".$act_id."' />".$act_name."</b></label></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["actor_grade"]."</td>";
                                                    					 
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
                                                              
                                                                <input type="text" class="form-control"  name="s_actress" id="s_actress" placeholder="Choose actress" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_actress_id" id="s_actress_id" placeholder="Choose actress" required="required" style="display: none;">
                                                                 <input type="text" class="form-control"  name="s_actress_rem" id="s_actress_rem"  value="0" placeholder="Choose actress" required="required" >
                                                           </div>
                                                 </div>
                                                 
                                                      <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id="acpic" style="width: 100%;height: 300px;" >
                                            </div> 
                                            </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example-editable" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>actress</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                     
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
                                                    					$ac_pic = $row["actress_pic"];
                                                    					
                                                    					$dir_cr = round(($dir_rate/10000000),2);
                                                    					 
                                                    					
                                                    					$dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate.'^'.$ac_pic;
                                                    					
                                                    					echo "<tr>";                                                    					
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_actress' name='r_actress' value='".$dir_id."' />".$dir_name."</b></label></td>";
                                                    					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["actress_grade"]."</td>";
                                                    				 
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
                                                                <input type="text" class="form-control"  name="s_writer" id="s_writer" placeholder="Choose writer" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_writer_id" id="s_writer_id" placeholder="Choose writer" required="required" style="display: none;">
                                                                 <input type="text" class="form-control" value="0"  name="s_writer_rem"  id="s_writer_rem" placeholder="Choose writer" required="required" >
                                                            </div>
                                                 </div>
                                                 
                                                      <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id="wpic" style="width: 100%;height: 300px;" >
                                            </div> 
                                            </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example2" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%">writer</th>
                                                                    <th style="width: 20%">Rem</th>
                                                                   
                                                                     
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
                                                    					$ac_pic = $row["writer_pic"];
                                                    					  
                                                    					$dir_cr = round(($dir_rate/10000000),2);
                                                    					 
                                                    					$dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate.'^'.$ac_pic;
                                                    					
                                                    					echo "<tr>";
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_writer' name='r_writer' value='".$dir_id."' /><b>".$dir_name."</b></label></td>";
                                                    					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td></td>";
                                                    				
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
                                              
                                                <div class="col-md-12">
                                                       <div class="panel-body">
                                    <form id="make1form" action="makemovie2.php" method="post">
                                    <div style="display: none">
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="title_id" name="title_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Budget</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="budget_id" name="budget_id">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Director</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="dir_name" name="dir_name">
                                                <input type="text" class="form-control" id="dir_id" name="dir_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Actors</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="act_name" name="act_name">
                                                <input type="text" class="form-control" id="act_id" name="act_id">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Actress</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="actress_name" name="actress_name">
                                                <input type="text" class="form-control" id="actress_id" name="actress_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Witer</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="writer_name" name="writer_name">
                                                <input type="text" class="form-control" id="writer_id" name="writer_id">
                                            </div>
                                        </div>
                                        
                                         </div>
                                        
                                          <div class="form-group">                                           
                                            <div class="col-sm-6 col-md-offset-4">
                                                 <button type="button" class="btn btn-primary" id="sub_btn" style="width: 100%"><h2>Proceed to Next Step</h2></button>
                                                 <button type="submit" class="btn btn-primary" id="nxt_btn" style="display: none;">Next</button>
                                            </div>
                                        </div>
                                       
                                       
                                    </form>
                                </div> 
                                               
                                                </div>
                                               <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default">Go Back I need Some Changes</a></li>
                                                
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
                                            <p><h4>so far <i class="fa fa-inr"></i><b id="sofarlabel">0</b></h4></p> 
                                    </div>
                                </div>
                            </div>
                   
                             <div >
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">                                      
                                            <p><h4>Budget <i class="fa fa-inr"></i><b id="budgetlabel">0</b></h4></p> 
                                    </div>
                                </div>
                            </div> 
                            
                             <div style="display: none;">
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">                                      
                                            <p><h4>Balance <i class="fa fa-inr"></i><b  id="balancelabel">0</b></h4></p> 
                                    </div>
                                </div>
                            </div>
                   
                
               			 </div>
                
                    
                    
                    
                    
                </div>
                <!-- Row -->
          
            </div>
            <!-- Main Wrapper -->

   			<div class="row" id="showform" style="display: none;">
                        <div class="col-md-10">
                            <div class="login-box">
                                
                                <div class="alert alert-success" role="alert">
                                       <h3>Now Choose Music Director, Editors....<h1>Are You Ready ?</h1></h3>
                                    </div>
                                
                                
                                
                                
                                <form class="m-t-md" method="get" id="regform" action="makemovie2.php">
                                   
                                      <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="_title_id" name="_title_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Budget</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="_budget_id" name="_budget_id">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Director</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="_dir_name" name="_dir_name">
                                                <input type="text" class="form-control" id="_dir_id" name="_dir_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Actors</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_act_name" name="_act_name">
                                                <input type="text" class="form-control" id="_act_id" name="_act_id">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Actress</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="_actress_name" name="_actress_name">
                                                <input type="text" class="form-control" id="_actress_id" name="_actress_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Witer</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_writer_name" name="_writer_name">
                                                <input type="text" class="form-control" id="_writer_id" name="_writer_id">
                                            </div>
                                        </div>
                                        
                                        
                                               
                                        <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">So _ far</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_sofar" name="_sofar">                                                 
                                            </div>
                                        </div>
                                        
                                        
                                        
                                          <div class="form-group"  style="display: none;">                                           
                                            <div class="col-sm-6 col-md-offset-4">
                                                 <button type="button" class="btn btn-primary" id="_sub_btn">Submit</button>
                                                 <button type="submit" class="btn btn-primary" id="_nxt_btn" style="display: none;">Next</button>
                                            </div>
                                        </div>
                                        
                                  
                                    <button type="submit" class="btn btn-success btn-block m-t-xs" id="regButton"><h1>Continue...</h1></button>
                                     
                                </form>
                                
                            </div>
                        </div>
                    </div><!-- Row -->	
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

	$("#inC").on("input", function(){
		  var cr = $('#inC').val();                    
          var rs = parseFloat(cr)*10000000;
          $('#s_budget').val(rs);
	});
	         
        
	 

	var s_bal =parseFloat($("#bal_id").text());
	//alert(s_bal);
	
	// ******************** DIRECTOR RATIO ACTIONS START ***********************
	$('.r_dir').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.indexOf("^")-2);
		    	var dpic = a.substr(a.indexOf("^")+1, a.length); 

		    	$('#dpic').attr('src', dpic);

		    	//alert(dpic);
		    	 
		    	$("#s_dir").val(dname);
		    	$("#s_dir_id").val(did);
		    	$("#s_dir_rem").val(drate);
		    	$("#dir_name").val(dname);
		    	
		    	$("#dir_id").val(did);
		    	$("#dir_next").show();
		    	
		    	$("#s_dir_rem").hide();
		    	sofar();
		     
		    }
		);	
	// ******************** DIRECTOR RATIO ACTIONS END  ***********************

	
	// ******************** ACTOR RATIO ACTIONS START ***********************
	$('.r_act').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.indexOf("^")-2);
		    	var dpic = a.substr(a.indexOf("^")+1, a.length); 
		    	
				 dpic = dpic.toLowerCase();
		    	$('#apic').attr('src', dpic);

		    	
		    	$("#s_act").val(dname);
		    	$("#s_act_id").val(did);
		    	$("#s_act_rem").val(drate);
		    	$("#act_name").val(dname);
		    	
		    	$("#act_id").val(did);
		    	$("#act_next").show();

		    	$("#s_act_rem").hide();
		    	sofar();
		    }
		);	
	// ******************** ACTOR RATIO ACTIONS END  ***********************
	
	// ******************** Aactres RATIO ACTIONS START ***********************
	$('.r_actress').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.indexOf("^")-2);
		    	var dpic = a.substr(a.indexOf("^")+1, a.length); 
		    	$('#acpic').attr('src', dpic);
		    	$("#s_actress").val(dname);
		    	$("#s_actress_id").val(did);
		    	$("#s_actress_rem").val(drate);
		    	$("#actress_name").val(dname);
		    	$("#actress_id").val(did);
		    	$("#actress_next").show();
		    	$("#s_actress_rem").hide();
		    	 
		    	sofar();
		    }
		);	
	// ******************** Aactres RATIO ACTIONS END  ***********************

	
	// ******************** WRITER RATIO ACTIONS START ***********************
	$('.r_writer').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.indexOf("^")-2);
		    	var dpic = a.substr(a.indexOf("^")+1, a.length); 
		    	
		    	$('#wpic').attr('src', dpic);
		    	$("#s_writer").val(dname);
		    	$("#s_writer_id").val(did);
		    	$("#s_writer_rem").val(drate);
		    	$("#writer_name").val(dname);
		    	$("#writer_id").val(did);
		    	$("#writer_next").show();
		    	$("#s_writer_rem").hide();
		    	sofar();
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************

	
	
	// ******************** Mian Next Click ***********************
	$('#main_next').click(
		    function(){
			   
		    	var t = 	$("#s_title").val();
		    	var b = 	$("#s_budget").val();		    
		    	$("#title_id").val(t);
		    	$("#budget_id").val(b);
		    	if(s_bal<b)
		    	{
		    		toastr.error(" <h3>You Dont Have Enough Money To Make This Film</h3> ");
		    		toastr.info(" But Here You can Nvaigate for checking Remurations ");
				
				}
		    	sofar();
				
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************

	
		
	// ******************** Submit button  Next Click ***********************
	$('#sub_btn').click(
		    function(){
			    
		    	var tit = $("#title_id").val(); 		    	
		    	 var bud = $("#budget_id").val(); 
		    	var did= $("#dir_name").val(); 
		    	var dv= $("#dir_id").val();
		    	var aid= $("#act_name").val();
		    	var av= $("#act_id").val();
		    	var acid= $("#actress_name").val();
		    	var acv= $("#actress_id").val();
		    	var wid= $("#writer_name").val();
		    	var wv= $("#writer_id").val(); 
		    	var sf =parseFloat($("#sofarlabel").text());		
		    	if(s_bal<bud || s_bal< sf)
		    	{
		    		toastr.error(" <h3>You Dont Have Enough Money To Make This Film</h3> ");
		    		toastr.info(" Go Back For Reduce Remunarations / Earn Money");
				
				}
		    	 
		    	else if(sf>bud){
		    		toastr.info("Please Allocate Sufficient Budget To make Film ");
		    					}
				 
		    	else if(tit.length<1){
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
		     
		    	else if(wid.length<1 || wv.length<1){
		    		toastr.info("Enter WRITER  : Go To WRITER  Tab ");
		    					}  	
		    	else{
		    				    		 
		    		toastr.info("Click on Next to Select MUSIC,EDITOR... ");
		    		  $("#_title_id").val(tit); 		
		    		   $("#_budget_id").val(bud); 
		    		 $("#_dir_name").val(did); 
		    		$("#_dir_id").val(dv);
		    		 $("#_act_name").val(aid);
		    		$("#_act_id").val(av);
		    		 $("#_writer_name").val(wid);
			    		$("#_writer_id").val(wv);
		    		 $("#_actress_name").val(acid);
		    		 $("#_actress_id").val(acv);
		    		 $("#_sofar").val(sf);
		    		 
		    		
		    			    		
		    		$("#main-wrapper").hide();
		    		$("#showform").show();
		  		 
			    	} 
		    		     
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************
	 function sofar(){
			var d =parseFloat($("#s_dir_rem").val());
			 var a =parseFloat($("#s_act_rem").val());
			 var ac =parseFloat($("#s_actress_rem").val());
			 var w =parseFloat($("#s_writer_rem").val());
			 var b =parseFloat($("#s_budget").val());		

		 var sfar = (d+a+ac+w);
		 $("#sofarlabel").text(sfar);
		 $("#budgetlabel").text(b);
		 
		 }



	
	</script>

</body>

</html> <?php mysql_close($conn);?>