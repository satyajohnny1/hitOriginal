<?php
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
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-10">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div id="rootwizard">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" ><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Music Director</a></li>
                                        <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Cinematographer</a></li>
										 <li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Editor</a></li>
                                        <li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Ready</a></li>
                                        
                                    </ul>


                                    <div class="progress progress-sm m-t-sm">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        </div>
                                    </div>
                                    <form id="wizardForm">
                                        <div class="tab-content">
										  		
										  		
										  		
										  		 <div class="tab-pane fade" id="tab1">
                                                 <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                               
                                                                <input type="text" class="form-control"  name="s_mus" id="s_mus" placeholder="Choose music" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_mus_id" id="s_mus_id" placeholder="Choose music" required="required"  style="display: none;">
                                                                 <input type="text" class="form-control"  name="s_mus_rem" id="s_mus_rem" value="0" required="required" style="display: none;">
                                                             </div>
                                                 </div>
                                                 
                                                      <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id=mpic" style="width: 100%;height: 300px;" >
                                            </div> 
                                            </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example2" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>music</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>PL</th>
                                                                    
                                                                </tr>
                                                            </thead>
													<!-- music serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_music";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["music_id"];
                                                    					$dir_name = $row["music_name"];
                                                    					$dir_rate = $row["music_rate"];
                                                    					$dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					$dir_cr = round(($dir_rate/10000000),2);
                                                    					echo "<tr>";
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='checkbox' class='r_mus' name='r_mus' value='".$dir_id."' />".$dir_name."</b></label></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b></td>";
                                                    					echo "<td>".$row["music_grade"]."</td>";
                                                    					 echo "<td>".$row["pl"]."</td>";
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
                                                <li class="next" style="display: none;" id="mus_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
											
											
											
						  <div class="tab-pane fade" id="tab2">
                                                 <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                               
                                                                <input type="text" class="form-control"  name="s_cine" id="s_cine" placeholder="Choose cine" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_cine_id" id="s_cine_id" placeholder="Choose cine" required="required"  style="display: none;">
                                                                 <input type="text" class="form-control"  name="s_cine_rem" id="s_cine_rem" value="0"  placeholder="Choose cine" required="required" style="display: none;">
                                                           </div>
                                                 </div>
                                                 
                                                      <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id=mpic" style="width: 100%;height: 300px;" >
                                            </div> 
                                            </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example-editable" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
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
                                                    					$dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					$dir_cr = round(($dir_rate/10000000),2);
                                                    					echo "<tr>";
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_cine' name='r_cine' value='".$dir_id."' />".$dir_name."</b></label></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b></td>";
                                                    					echo "<td>".$row["cine_grade"]."</td>";
                                                    					 echo "<td>".$row["pl"]."</td>";
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
                                                <li class="next" style="display: none;" id="cine_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
											
						 <div class="tab-pane fade" id="tab3">
                                                 <div class="col-md-3">
                                                   <div class="row">
                                                            <div class="form-group">
                                                                
                                                                <input type="text" class="form-control"  name="s_edi" id="s_edi" placeholder="Choose editor" required="required" disabled="disabled" style="display: none;">
                                                                <input type="text" class="form-control"  name="s_edi_id" id="s_edi_id" placeholder="Choose editor" required="required"  style="display: none;">
                                                                <input type="text" class="form-control"  name="s_edi_rem" id="s_edi_rem"  value="0" placeholder="Choose editor" required="required" style="display: none;">
                                                            </div>
                                                 </div>
                                                 
                                                      <div class="row">
                                                     <div class="col-md-12" style="position:relative;">
                                                <img src="pic/u1.jpg" id=mpic" style="width: 100%;height: 300px;" >
                                            </div> 
                                            </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>editor</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>PL</th>
                                                                  
                                                                </tr>
                                                            </thead>
													<!-- editor serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_editor";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["editor_id"];
                                                    					$dir_name = $row["editor_name"];
                                                    					$dir_rate = $row["editor_rate"];
                                                    					$dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate;
                                                    					$dir_cr = round(($dir_rate/10000000),2);
                                                    					echo "<tr>";
                                                    					echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_edi' name='r_edi' value='".$dir_id."' />".$dir_name."</b></label></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b></td>";
                                                    					echo "<td>".$row["editor_grade"]."</td>";
																		echo "<td>".$row["pl"]."</td>";
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
                                                <li class="next" style="display: none;" id="edi_next"><a href="#" class="btn btn-default">Next</a></li>
                                            </ul>
                                            </div>
											
														  <div class="tab-pane fade" id="tab4">
                                              
                                                <div class="col-md-12">
                                                       <div class="panel-body">
                                    <form>
                                    <div style="display: none;">
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Title </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="title_id" name="title_id" value="<?php echo $_GET ['_title_id'];?>">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Budget</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="budget_id" name="budget_id" value="<?php echo $_GET ['_budget_id'];?>">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Director</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="dir_name" name="dir_name" value="<?php echo $_GET ['_dir_name'];?>">
                                                <input type="text" class="form-control" id="dir_id" name="dir_id" value="<?php echo $_GET ['_dir_id'];?>">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Actors</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="act_name" name="act_name" value="<?php echo $_GET ['_act_name'];?>">
                                                <input type="text" class="form-control" id="act_id" name="act_id" value="<?php echo $_GET ['_act_id'];?>">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Actress</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="actress_name" name="actress_name" value="<?php echo $_GET ['_actress_name'];?>">
                                                <input type="text" class="form-control" id="actress_id" name="actress_id" value="<?php echo $_GET ['_actress_id'];?>">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Witer</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="writer_name" name="writer_name" value="<?php echo $_GET ['_writer_name'];?>">
                                                <input type="text" class="form-control" id="writer_id" name="writer_id" value="<?php echo $_GET ['_writer_id'];?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">Multi-Starrer</label>
                                            <div class="col-sm-10">
                                                 	<input type="text" class="form-control" id="a2" name="a2"  value="<?php echo $_GET ['_a2'];?>">
                                                	<input type="text" class="form-control" id="a2_name" name="a2_name" value="<?php echo $_GET ['_a2_name'];?>">                                                	
                                                	
                                                 	<input type="text" class="form-control" id="a3" name="a3" value="<?php echo $_GET ['_a3'];?>">
                                                	<input type="text" class="form-control" id="a3_name" name="a3_name" value="<?php echo $_GET ['_a3_name'];?>">
                                                	
                                                	
                                                	
                                                	
                                                 	<input type="text" class="form-control" id="ac2" name="ac2" value="<?php echo $_GET ['_ac2'];?>">
                                                	<input type="text" class="form-control" id="ac2_name" name="ac2_name" value="<?php echo $_GET ['_ac2_name'];?>">
                                                 	
                                                 	<input type="text" class="form-control" id="ac3" name="ac3" value="<?php echo $_GET ['_ac3'];?>">
                                                 	<input type="text" class="form-control" id="ac3_name" name="ac3_name" value="<?php echo $_GET ['_ac3_name'];?>">
                                                 	
                                                 	
                                                 
                                                 
                                                 	<input type="text" class="form-control" id="d2" name="d2" value="<?php echo $_GET ['_d2'];?>">
                                                	<input type="text" class="form-control" id="d2_name" name="d2_name" value="<?php echo $_GET ['_d2_name'];?>">                                               	
                                                	
                                                 	<input type="text" class="form-control" id="d3" name="d3" value="<?php echo $_GET ['_d3'];?>">
                                                	<input type="text" class="form-control" id="d3_name" name="d3_name" value="<?php echo $_GET ['_d3_name'];?>">
                                                	
                                                	
                                                	
                                                
                                                 
                                                 	<input type="text" class="form-control" id="w2" name="w2" value="<?php echo $_GET ['_w2'];?>">
                                                	<input type="text" class="form-control" id="w2_name" name="w2_name" value="<?php echo $_GET ['_w2_name'];?>">                                             	
                                                	
                                                 	<input type="text" class="form-control" id="w3" name="w3" value="<?php echo $_GET ['_w3'];?>">
                                                	<input type="text" class="form-control" id="w3_name" name="w3_name"value="<?php echo $_GET ['_w3_name'];?>">                                             	
                                                	
                                                	
                                                	
                                                	
                                                	
                                                 	
                                                 	
                                                 	
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">cine</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="cine_name" name="cine_name" >
                                                <input type="text" class="form-control" id="cine_id" name="cine_id" >
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">music</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="mus_name" name="mus_name" >
                                                <input type="text" class="form-control" id="mus_id" name="mus_id">
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label for="input-Default" class="col-sm-2 control-label">editor</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="edi_name" name="edi_name" >
                                                <input type="text" class="form-control" id="edi_id" name="edi_id" >
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
                                            <p style="display: none;"><input type="text" value="<?php echo $_GET ['_sofar'];?>" id="old_sofar"></b></h4></p>
                                    </div>
                                </div>
                            </div>
                   
                             <div >
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">                                      
                                            <p><h4>Budget <i class="fa fa-inr"></i><b id="budgetlabel"><?php echo $_GET ['_budget_id'];?></b></h4></p> 
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
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="#" class="logo-name text-lg text-center">Casting Completed</a>
                                 <div class="alert alert-success" role="alert">
                                       <h3>Go and Shoot the Movie <h1>Are You Ready ?</h1></h3>
                                    </div>
                                
                                
                                <form class="m-t-md" method="get" id="regform" action="makemovieAjax.php" >
                                   
                                      <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="_title_id" name="_title_id">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group" style="display: none;" >
                                            <label for="input-Default" class="col-sm-2 control-label">Budget</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="_budget_id" name="_budget_id">
                                            </div>
                                        </div>
                                        
                                          <div class="form-group" style="display: none;">
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
                                  <div class="form-group" style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">Multi-Starrer</label>
                                            <div class="col-sm-10">
                                                 	<input type="text" class="form-control" id="_a2" name="_a2">
                                                	<input type="text" class="form-control" id="_a2_name" name="_a2_name">                                                	
                                                	
                                                 	<input type="text" class="form-control" id="_a3" name="_a3">
                                                	<input type="text" class="form-control" id="_a3_name" name="_a3_name">
                                                	
                                                	
                                                	
                                                	
                                                 	<input type="text" class="form-control" id="_ac2" name="_ac2">
                                                	<input type="text" class="form-control" id="_ac2_name" name="_ac2_name">
                                                 	
                                                 	<input type="text" class="form-control" id="_ac3" name="_ac3">
                                                 	<input type="text" class="form-control" id="_ac3_name" name="_ac3_name">
                                                 	
                                                 	
                                                 
                                                 
                                                 	<input type="text" class="form-control" id="_d2" name="_d2">
                                                	<input type="text" class="form-control" id="_d2_name" name="_d2_name">                                                	
                                                	
                                                 	<input type="text" class="form-control" id="_d3" name="_d3">
                                                	<input type="text" class="form-control" id="_d3_name" name="_d3_name">
                                                	
                                                	
                                                	
                                                
                                                 
                                                 	<input type="text" class="form-control" id="_w2" name="_w2">
                                                	<input type="text" class="form-control" id="_w2_name" name="_w2_name">                                                	
                                                	
                                                 	<input type="text" class="form-control" id="_w3" name="_w3">
                                                	<input type="text" class="form-control" id="_w3_name" name="_w3_name">
                                                	
                                                	
                                                	
                                                	
                                                 	
                                                 	<input type="text" class="form-control" id="_m2" name="_m2">
                                                	<input type="text" class="form-control" id="_m2_name" name="_m2_name">                                                	
                                                	
                                                 	<input type="text" class="form-control" id="_m3" name="_m3">
                                                	<input type="text" class="form-control" id="_m3_name" name="_m3_name">
                                                	
                                                	
                                                	
                                                	
                                                 	
                                                 	
                                                 	
                                            </div>
                                        </div>
                                        
                                        
                                      
                                         <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">cine</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_cine_name" name="_cine_name" >
                                                <input type="text" class="form-control" id="_cine_id" name="_cine_id" >
                                            </div>
                                        </div>
                                        
                                         <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">music</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_mus_name" name="_mus_name" >
                                                <input type="text" class="form-control" id="_mus_id" name="_mus_id">
                                            </div>
                                        </div>
                                        
                                         <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">editor</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_edi_name" name="_edi_name" >
                                                <input type="text" class="form-control" id="_edi_id" name="_edi_id" >
                                            </div>
                                        </div>
                                          
                                         <div class="form-group"  style="display: none;">
                                            <label for="input-Default" class="col-sm-2 control-label">SO-FAR</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="_sofar" name="_sofar" >
                                                 
                                            </div>
                                        </div>
                                        
                                          <div class="form-group"  style="display: none;">                                           
                                            <div class="col-sm-6 col-md-offset-4">
                                                 <button type="button" class="btn btn-primary" id="_sub_btn">Submit</button>
                                                 <button type="submit" class="btn btn-primary" id="_nxt_btn" style="display: none;">Next</button>
                                            </div>
                                        </div>
                                        
                                  
                                    <button type="submit" class="btn btn-success btn-block m-t-xs" id="regButton"><h2>Continue ...</h2></button>
                                     
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
	var s_bal =parseFloat($("#bal_id").text());
	//alert(s_bal);

	// ******************** MUSIC RATIO ACTIONS START ***********************
	$('.r_mus').change(
		    function(){
		    	var did='' ;
		    	var dname='';
		    	var drate=0;
		    	var dpic=''; 		    

		    	$('input[name="r_mus"]:checked').each(function() {
		    		var a= this.value;
		    		//alert(a);
		    		var a= this.value;
		    		var chk = parseInt(a.substr(0,a.indexOf("#")));
		    		did = a.substr(0,a.indexOf("#"))+"!"+did;
		    		
					if(chk<10)
					{
			    	dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2)+"!"+dname;
					}else if(100>chk && chk>9){
					dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-3)+"!"+dname;
					}else{
					dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-4)+"!"+dname;
					}
			    	drate = drate+parseInt( a.substr(a.indexOf("$")+1, a.length));
			    	//alert(drate);
			    	dpic = a.substr(a.indexOf("^")+1, a.length);
		    		});
		    	
		    	$("#s_mus").val(dname);
		    	$("#s_mus_id").val(did);
		    	$("#s_mus_rem").val(drate);
		    	$("#mus_name").val(dname);
		    	
		    	$("#mus_id").val(did);
		    	if($("input[name=r_mus]:checked").length >= 1 ){
		    	$("#mus_next").show();
		    	}else{
		    		$("#mus_next").hide();
			    	}		    	
		    	$("#s_mus_rem").hide();
		    	sofar();
		    	
		    }
		);	
	// ******************** MUSIC ACTIONS END  ***********************
	
	
	
	// ******************** EDITOR RATIO ACTIONS START ***********************
	$('.r_edi').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.length);  
		    	$("#s_edi").val(dname);
		    	$("#s_edi_id").val(did);
		    	
		    	$("#s_edi_rem").val(drate);

		    	
		    	$("#edi_name").val(dname);
		    	$("#edi_id").val(did);
		    	$("#edi_next").show();

		    	$("#s_edi_rem").hide();
		    	sofar();
		     
		    }
		);	
	// ******************** EDITOR RATIO ACTIONS END  ***********************
	
	
	// ******************** cinematographer RATIO ACTIONS START ***********************
	$('.r_cine').change(
		    function(){
		    	var a = 	$(this).val();
		    	var did = a.substr(0,a.indexOf("#"));
		    	var dname = a.substr(a.indexOf("#")+1, a.indexOf("$")-2);
		    	var drate = a.substr(a.indexOf("$")+1, a.length);  
		    	$("#s_cine").val(dname);
		    	$("#s_cine_id").val(did);
		    	$("#s_cine_rem").val(drate);
		    	$("#cine_name").val(dname);
		    	$("#cine_id").val(did);
		    	$("#cine_next").show();
		    	$("#s_cine_rem").hide();
		    	
		    	sofar();
		     
		    }
		);	
	// ******************** cinematographer RATIO ACTIONS END  ***********************
		
		$('#regButton').click(
		    function(){
		    	$("#regButton").hide();
		    });
			  
	// ******************** Submit button  Next Click ***********************
	$('#sub_btn').click(
		    function(){
		    	//$("#regButton").hide();
			    
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

		    

				var mid= $("#mus_id").val(); 
		    	var mid_arry =  mid.split("!");
		    	    mid = mid_arry[0];
		    	var m2  = mid_arry[1];
		    	var m3  = mid_arry[2];

		    	
		    	var mv= $("#mus_name").val();
		    	var mv_arry =  mv.split("!");
	    	   		 mv   = mv_arry[0];
	    		var m2_v  = mv_arry[1];
	    		var m3_v  = mv_arry[2];
 

		    	var cid= $("#cine_name").val();
		    	var cv= $("#cine_id").val(); 
 
		    	var eid= $("#edi_name").val();
		    	var ev= $("#edi_id").val(); 



		    	var a2 = $("#a2").val();
				var a3 = $("#a3").val();
		    	var ac2 = $("#ac2").val();
				var ac3 = $("#ac3").val();
		    	var d2 = $("#d2").val();
				var d3 = $("#d3").val();
				var w2 = $("#w2").val();
				var w3 = $("#w3").val();

				if (!a2)
					a2=0;
				
				if (!a3)
					a3=0;
				
				if (!ac2)
					ac2=0;
				
				if (!ac3)
					ac3=0;
				
				if (!w2)
					w2=0;
				
				if (!w3)
					w3=0;

				if (!d2)
					d2=0;		
				

				if (!d3)
					d3=0;
				
				if (!m2)
					m2=0;		
				

				if (!m3)
					m3=0;
				
				

				var a2_v = $("#a2_name").val();
				var a3_v = $("#a3_name").val();
		    	var ac2_v = $("#ac2_name").val();
				var ac3_v = $("#ac3_name").val();
		    	var d2_v = $("#d2_name").val();
				var d3_v = $("#d3_name").val();
				var w2_v = $("#w2_name").val();
				var w3_v = $("#w3_name").val();
				
		
				
		    	var sf =parseFloat($("#sofarlabel").text());
		    	if(s_bal<bud || s_bal< sf)
		    	{
		    		toastr.error(" <h3>You Dont Have Enough Money To Make This Film</h3> ");
		    		toastr.info(" Go Back For Reduce Remunarations / Earn Money");
				
				}
		    	 
		    	else if(sf>bud){
		    		toastr.info(sf+"Please Allocate Sufficient Budget To make Film "+bud);
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
				
				else if(eid.length<1 || ev.length<1){
		    		toastr.info("Enter EDITOR  : Go To EDITOR  Tab ");
		    					}  		
				
						else if(mid.length<1 || mv.length<1){
		    		toastr.info("Enter MUSIC  : Go To MUSIC  Tab ");
		    					}  	
							
    					else if(cid.length<1 || cv.length<1){
		    		toastr.info("Enter CINEMATOGRAPTHER  : Go To CINIMATOGRAPHER  Tab ");
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
		    		 

		    		 
		    		   $("#_mus_name").val(mv);
		    		   $("#_mus_id").val(mid); 

		    		    $("#_cine_name").val(cid);
		    		   $("#_cine_id").val(cv); 

		    		    $("#_edi_name").val(eid);
		    		   $("#_edi_id").val(ev); 

		    		   $("#_d2").val(d2);
			    		 $("#_d3").val(d3);
			    		 $("#_d2_name").val(d2_v);
			    		 $("#_d3_name").val(d3_v);

			    		 
			    		 $("#_a2").val(a2);
			    		 $("#_a3").val(a3);
			    		 $("#_a2_name").val(a2_v);
			    		 $("#_a3_name").val(a3_v);

			    		 
			    		 $("#_ac2").val(ac2);
			    		 $("#_ac3").val(ac3);
			    		 $("#_ac2_name").val(ac2_v);
			    		 $("#_ac3_name").val(ac3_v);

			    		 
			    		 $("#_w2").val(w2);
			    		 $("#_w3").val(w3);			    		
			    		 $("#_w2_name").val(w2_v);
			    		 $("#_w3_name").val(w3_v);

			    		 $("#_m2").val(m2);
			    		 $("#_m3").val(m3);			    		
			    		 $("#_m2_name").val(m2_v);
			    		 $("#_m3_name").val(m3_v);
						    		


			    		 $("#_cine_name").val(cid);
			    		   $("#_cine_id").val(cv); 

			    		    $("#_edi_name").val(eid);
			    		   $("#_edi_id").val(ev); 

			    	
				    		 
		    		   $("#_sofar").val(parseFloat(sf)); 
		    		 		    		 
		    		
		    			    		
		    		$("#main-wrapper").hide();
		    		$("#showform").show();
			    	}
		    		     
		    }
		);	
	// ******************** WRITER RATIO ACTIONS END  ***********************
	 function sofar(){

		// alert('in sofar');
		 var m =parseFloat($("#s_mus_rem").val());
		 var c =parseFloat($("#s_cine_rem").val());
			var e =parseFloat($("#s_edi_rem").val());
			 var o =parseFloat($("#old_sofar").val());
			 var b = 	$("#budget_id").val();

			 //alert(m);
			 
			var sfar = o+(e+c+m);
		 $("#sofarlabel").text(sfar);
		 $("#budgetlabel").text(b);
		 
		 }
	
	
		
	 $("input[name=r_mus]").change(function(){
		    var max= 3;
		    if($("input[name=r_mus]:checked").length >= max ){
		    	toastr.info("<h3>Maximum 3 Musicians Only</h3>");			   
		        $("input[name=r_mus]").attr('disabled', 'disabled');
		        $("input[name=r_mus]:checked").removeAttr('disabled');
		    }else{
		         $("input[name=r_mus]").removeAttr('disabled');
		    }
		});


	
	
	</script>

</body>

</html> 
 
<?php 
if($conn!=null){
mysqli_close($conn);
}
?>