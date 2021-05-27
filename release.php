<?php
include 'sessionCheck.php'; 
session_start(); 
error_reporting(E_ERROR);

 
include 'db.php';
$rid =  $_GET ["rid"];
$title ='';
$budget =0;
$sofar =0;
$dname ='';
$aname ='';
$acname ='';
$finalsofar = 0;
$rel_cen =0;
$news='';

$uid = $_SESSION['s_uid'];
$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.rid = ".$rid;
echo $sql;
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	if($row = mysqli_fetch_assoc($result)) {
		$rid = $row["rid"];
		$title = $row["title"];
		$budget = $row["result"];
		$sofar = $row["sofar"];
		$dname = $row["dname"];
		$aname = $row["aname"];
		$acname = $row["acname"];
	
	}
}


$sql = "SELECT * FROM tolly_release s WHERE s.uid = ".$uid." and s.rid = ".$rid;
echo $sql;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	// output data of each row
	if($row = mysqli_fetch_assoc($result)) {
		$rel_cen = $row["rel_cen"];		 
	}
}

$news = "<a href=\'running.php?rid=$rid\'>".$title."! Staring with $aname and $acname directed by $dname is Releasing in $rel_cen Centers"


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

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h3 class="panel-title">Fade effect</h3>

                            </div>


                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <div class="panel info-box panel-white">
                                            <div class="panel-body">
                                                <div class="info-box-stats">
                                                    <p class="counter">
                                                        <?php echo $title?>
                                                    </p>
                                                    <span class="info-box-title"><?php echo $aname.','.$acname.' , '.$dname?></span>
                                                    <b>Budget(So far) : <i  id="b1"><?php echo $sofar?></i></b>
                                                </div>
                                                <div class="info-box-icon">
                                                    <i class="icon-users"></i>
                                                </div>
                                                <div class="info-box-progress">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab5" role="tab" data-toggle="tab" aria-expanded="true">Own Release</a></li>
                                        <li role="presentation" class=""><a href="#tab6" role="tab" data-toggle="tab" aria-expanded="false">Distribute</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">



                                        <div role="tabpanel" class="tab-pane fade active in" id="tab5">

                                            <div class="panel panel-purple">

                                                <div class="panel-body">
                                                    <h2 class="white">Releasing in <?php echo $rel_cen?> Centers <a type="button" href="released.php?news=<?php echo  $news?>&rid=<?php echo  $rid?>" class="btn btn-default">Direct Release</a></h2>

                                                </div>
                                            </div>

<! --
                                            <div class="panel panel-info">
                                                <div class="panel-body">
                                                    <h3>Want to Release in More centers ? (1 center = 1x5,00,000)</h3>
                                                    
                                                      <form class="form-inline" method="get" action="addcenters.php">
                                        
                                        <div class="form-group">
                                            <label  for="addcent">Add Centers</label>
                                            <input type="number" min="1" max="500" class="form-control" name="addcent" id="addcent" >
                                        </div>
                                        <div class="form-group">
                                       X  &nbsp; &nbsp;5,00,000 &nbsp; =                                
                                        </div>	 
										
									 
                                         <div class="form-group">                                             
                                            <input type="text"  class="form-control" name="addsofar" id="addsofar" style="display: none;">
                                             <input type="text"  class="form-control" name="iaddsofar" id="iaddsofar" >
                                        </div>
                                        -->	
										
										 <!--	
                                        <div class="form-group">                                             
                                            <input type="text"  class="form-control" value="<?php echo $sofar?>" name="nwbudget" id="nwbudget" style="display: none;">
                                            <input type="text"  class="form-control" value="<?php echo $sofar?>" name="inwbudget" id="inwbudget" >
                                        </div>   
                                        
                                         <input type="text"  id="cent" name="cent" value="<?php echo $rel_cen?>" style="display: none;">
                                    	 <input type="text"  id="rid" name="rid" value="<?php echo  $rid?>" style="display: none;">   
                                        <button type="submit"  class="btn btn-default btn-lg">Add Centers & Release</button>
                                    </form>
                                             </div>
                                            </div>
										-->
										

                                        </div>
                                        <!-- **************** OWN RELEASE ********************* -->



                                        <div role="tabpanel" class="tab-pane fade" id="tab6">
                                            <h2>Distribute</h2>
                                            <p>We Dont Have Enough Distributers to Release the Movie, So go with Own Release</p>
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


                $('#addcent').on('input', function() {
                    // do something
                    var cent = $('#addcent').val();
                    var bud = $('#b1').text();
                    var addso = cent*500000;
                    var nwbud = parseFloat(bud)+parseFloat(addso);
                    $('#addsofar').val(addso);
                    $('#nwbudget').val(nwbud);
                    $('#iaddsofar').val(addso);
                    $('#inwbudget').val(nwbud);
                   // alert('Hello');
                });
                
            </script>

    </body>

    </html>
 
<?php 
if($conn!=null){
mysqli_close($conn);
}
?>