<!DOCTYPE html>
<html>

<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="acbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="acloseRight"><i class="fa fa-times"></i></a></h3>

    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="acbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="acloseRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>
    <div class="menu-wrap">

        <button class="close-button" id="aclose-button">Close Menu</button>
    </div>
    <form class="search-form" action="actorupload.php" method="GET">
        <div class="input-group">
            <input type="text" name="asearch" class="form-control search-input" placeholder="Search...">
            <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
        </div>
        <!-- Input Group -->
    </form>
    <!-- Search Form -->
    <main class="page-content content-wrap">
        
       	<div class="page-sidebar sidebar">
                  <?php include('adminsidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">            
            <div id="amain-wrapper" >
  <div class="row">
  
  
  
  
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Actor Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="actor" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ACtor name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Actor rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
  
  
  
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">ACTRESS Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="actress" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ACTRESS name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">ACTRESS rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">ACTRESS Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">ACTRESS status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">ACTRESS rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
  
  
  
  
  
                        
                        
                        
  
  
  
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">DIRECTOR Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="director" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">DIRECTOR name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">DIRECTOR rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">DIRECTOR Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">DIRECTOR status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">DIRECTOR rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
  
  
  
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">MUSIC Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="music" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">MUSIC name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">MUSIC rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">MUSIC Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">MUSIC status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">MUSIC rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
  
  
  
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">CINE Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="cine" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">CINE name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">CINE rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">CINE Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">CINE status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">CINE rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
  
  
  
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">EDITOR Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="editor" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">EDITOR name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">EDITOR rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">EDITOR Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">EDITOR status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">EDITOR rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
  
  
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">WRITER Data</h4>
                                </div>
                                <div class="panel-body">
                                    <form action="actorupload.php" method="POST" enctype="multipart/form-data">
                                    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">TABLE</label>
                                            <input type="text" class="form-control" id="table"  value="writer" name="table" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">WRITER name</label>
                                            <input type="text" class="form-control"  id="aname" name="aname" placeholder="Name">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">WRITER rate</label>
                                            <input type="number" class="form-control" value="10000000" id="arate" name="arate" placeholder="Remuranation">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">WRITER Grade</label>
                                            <input type="text" class="form-control" value="B" id="agrade" name="agrade"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">WRITER status</label>
                                            <input type="text" class="form-control" value="available" id="astatus" name="astatus"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">WRITER rating</label>
                                            <input type="number" class="form-control"id="arating" value="8" name="arating"  placeholder="Remuranation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Posters</label>
                                            <input type="file" name="files[]" multiple="multiple" accept="image/*">
                                            
                                        </div>
                                       
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
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

</html> <?php mysql_close($conn);?>