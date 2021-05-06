<!DOCTYPE html>
<html>

<head>
<?php
include 'sessionCheck.php'; 
include 'db.php';
session_start();
error_reporting(E_ERROR);
$uid = $_SESSION['s_uid'];
$srs = $_SESSION['s_rs']; 
?>
<?php include('css.php');  ?> 
       
    </head>
<body class="page-header-fixed">
	<div class="overlay"></div>



	<!-- Search Form -->
	<main class="page-content content-wrap">        
       		<?php include('navbar.php');  ?> 
           <div class="page-sidebar sidebar">
              <?php include('sidemenu.php');  ?> 
                <!-- Page Sidebar Inner -->
	</div>
	<!-- Page Sidebar -->

	<div class="page-inner">
		<div class="page-title">
			<h3>Dashboard</h3>
			<div class="page-breadcrumb">
				<ol class="breadcrumb">
					<li><a href="userdashboard.php">Home</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</div>
		</div>
		<div id="main-wrapper">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div id="mymovieschart" style="width: 100%; height: 300px;"></div>
				</div>
				<div class="col-lg-3 col-md-6 panel">
					<div id="successratechart" style="width: 100%; height: 300px;"></div>
				</div>
				<div class="col-lg-5 col-md-6">
					<div id="last5" style="width: 100%; height: 300px;"></div>
				</div>

			</div>
		</div>
		<!-- Row -->
		<div class="row">
		
			<div class="col-lg-4 col-md-6">
				<div class="panel panel-white" style="height: 100%;">				 
					<button   class="btn btn-success" style="width: 100%;text-align: center;" data-toggle="modal" data-target="#myModal"><span style="font-size: 18px;">Shooting In Progress</span></button>						
					 
					<div class="panel-body">						 
						  <table class="table">
                                        <thead>
                                            <tr>                                               
                                                <th>Movie</th>
                                                <th>Crew</th>
                                                <th>Director</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                         		 <?php 
                                                     	         $sql = "select s.rid,s.title,s.aname, s.dname from tolly_ready_for_shoot s WHERE s.uid =  ".$uid."  and s.`status` = 'ready' ORDER BY s.dt LIMIT 5 ";
                                                     	         //echo '<h2>'.$sql.'</h2>';
                                                     	         $result = mysqli_query ( $conn, $sql );
                                                     	         if (mysqli_num_rows($result) > 0) {
                                                     	           	while($row = mysqli_fetch_assoc($result)) {           		
                                                     	           		$rid = $row["rid"];
                                                     	           		$title = $row["title"]; 
                                                     	           		$aname = $row["aname"];
                                                     	           		$dname = $row["dname"];
                                                     	           		echo " <tr>
                                                								<th scope='row'><a class='btn btn-success' href='readyforshoot.php' style='width: 100%;text-align: center;' ><b>$title</b></a></th>
                                                								<td>$aname</td>
                                                								<td>$dname</td>                                                
                                            								</tr>";
                                                     	           	}
                                                     	           } 
                                                     	         ?> 
                                           
                                            
                                        </tbody>
                                    </table>
					</div>
				</div>
			</div>
			
					<div class="col-lg-4 col-md-6">
				<div class="panel panel-white" style="height: 100%;">				 
					<button   class="btn btn-primary" style="width: 100%;text-align: center;" data-toggle="modal" data-target="#myModal"><span style="font-size: 18px;">Ready For Release</span></button>						
					 
					<div class="panel-body">						 
						  <table class="table">
                                        <thead>
                                            <tr>                                               
                                                <th>Moview</th>
                                                <th>Crew</th>
                                                <th>Director</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                     	         $sql = "select s.rid,s.title,s.aname, s.dname from tolly_ready_for_shoot s WHERE s.uid =  ".$uid."  and s.`status` = 'shootout' ORDER BY s.dt LIMIT 5 ";
                                                     	         //echo '<h2>'.$sql.'</h2>';
                                                     	         $result = mysqli_query ( $conn, $sql );
                                                     	         if (mysqli_num_rows($result) > 0) {
                                                     	           	while($row = mysqli_fetch_assoc($result)) {           		
                                                     	           		$rid = $row["rid"];
                                                     	           		$title = $row["title"]; 
                                                     	           		$aname = $row["aname"];
                                                     	           		$dname = $row["dname"];
                                                     	           		echo " <tr>
                                                								<th scope='row'><a class='btn btn-primary' href='readyforrelease.php' style='width: 100%;text-align: center;' ><b>$title</b></a></th>
                                                								<td>$aname</td>
                                                								<td>$dname</td>                                                
                                            								</tr>";
                                                     	           	}
                                                     	           } 
                                                     	         ?> 
                                           
                                           
                                            
                                        </tbody>
                                    </table>
					</div>
				</div>
			</div>
			
			 	<div class="col-lg-4 col-md-6">
				<div class="panel panel-white" style="height: 100%;">				 
					<button   class="btn btn-info" style="width: 100%;text-align: center;" data-toggle="modal" data-target="#myModal"><span style="font-size: 18px;">Now Running</span></button>						
					 
					<div class="panel-body">						 
						  <table class="table">
                                        <thead>
                                            <tr>                                               
                                                <th>Moview</th>
                                                <th>Crew</th>
                                                <th>Director</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                     	         $sql = "select s.rid,s.title,s.aname, s.dname from tolly_ready_for_shoot s WHERE s.uid =  ".$uid."  and s.`status` = 'running' ORDER BY s.dt LIMIT 5 ";
                                                     	         //echo '<h2>'.$sql.'</h2>';
                                                     	         $result = mysqli_query ( $conn, $sql );
                                                     	         if (mysqli_num_rows($result) > 0) {
                                                     	           	while($row = mysqli_fetch_assoc($result)) {           		
                                                     	           		$rid = $row["rid"];
                                                     	           		$title = $row["title"]; 
                                                     	           		$aname = $row["aname"];
                                                     	           		$dname = $row["dname"];
                                                     	           		echo " <tr>
                                                								<th scope='row'><a class='btn btn-info' href='readyforrun.php' style='width: 100%;text-align: center;' ><b>$title</b></a></th>
                                                								<td>$aname</td>
                                                								<td>$dname</td>                                                
                                            								</tr>";
                                                     	           	}
                                                     	           } 
                                                     	         ?> 
                                            
                                        </tbody>
                                    </table>
					</div>
				</div>
			</div>
			
			
			<div class="col-lg-12 col-md-12">
				<div class="panel panel-white">
					 <button   class="btn" style="width: 100%;text-align: center;" data-toggle="modal" data-target="#myModal"><span style="font-size: 18px;">News</span></button>
					<div class="panel-body">
						     <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title">Links in alerts</h3>
                                </div>
                                <div class="panel-body">
                                
                                   
                                         <?php 
                                        include 'db.php';
                                        
                             			$sql = "SELECT * FROM tolly_news t ORDER BY t.nid DESC limit 10";
                                             			//echo $sql;
                                                    			$result = mysqli_query($conn, $sql);                                                      			
                                                    				
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$i++;
                                                    					
                                                    					$heading = $row["heading"];
                                                    					$news = $row["news"];
                                                    					$pic     = 	$row["pic"];                                        
                                           echo "<div class=\"alert alert-info\" role=\"alert\">                                                                                           
                                                <strong>$news</strong>
                                              
                                            </div>";
                                          
                                                    				}
                                                    			
                                                    			} ?>
                                                                
                                </div>
                            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Main Wrapper -->
	
	</div>
	<!-- Page Inner --> <!-- Page Inner --> </main>
	<!-- Page Content -->

	<div class="cd-overlay"></div>

 <?php include('js.php');  ?> 
 <script type="text/javascript"
		src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['gauge']}]}"></script>

	<script type="text/javascript">

       
      google.load("visualization", "1", {packages:["corechart"]});
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

    	  //********************MyMovies Chart*****************************
          
        var mymovieschartdata = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],

          			<?php 
        	         $sql = "select count(*) as cnt, s.result from tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.`status` = 'out' GROUP BY s.result";
        	         //echo '<h2>'.$sql.'</h2>';
        	         $result = mysqli_query ( $conn, $sql );
        	         if (mysqli_num_rows($result) > 0) {
        	           	while($row = mysqli_fetch_assoc($result)) {           		
        	           		$cnt = $row["cnt"];
        	           		$fut = $row["result"];           
        	           		echo "['".$fut."', ".$cnt."],";
        	           	}
        	           } 
        	         ?> 
         
          ['Sleep',    0]
        ]);

        var mymovieschartoptions = {
          title: 'Your Hits&Futs %',
          titleTextStyle:{color: 'black', fontName: 'Century Gothic', fontSize: 14},
          is3D: true,
          legend :{position: 'bottom', textStyle: {color: 'blue', fontSize: 12}}
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('mymovieschart'));
        chart1.draw(mymovieschartdata, mymovieschartoptions);


       
        //********************MyMovies Chart*****************************
        
        
        
           

      //********************* Suceess Rate ********************** 
 		var successratedata = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
      	<?php 
   	         $sql = "SELECT x.tot, y.hit FROM 
(SELECT count(*) as tot from tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.`status` = 'out') as x,
(SELECT count(*) as hit FROM tolly_ready_for_shoot sa WHERE sa.uid = ".$uid." and sa.`status` = 'out' and sa.rating>3) as y 
 ";
   	         //echo '<h2>'.$sql.'</h2>';
   	         $result = mysqli_query ( $conn, $sql );
   	         if (mysqli_num_rows($result) > 0) {
   	           	if($row = mysqli_fetch_assoc($result)) {           		
   	           		$tot = $row["tot"];
   	           		$hit = $row["hit"]; 
   	           		$rat = round(($hit/$tot)*100);
   	           		echo "['Success Rate', ".$rat."]";
   	           	}
   	           } 
   	         ?>        
          ]);

        var successrateoptions = {
        		 animation :{duration: 1000 ,easing: 'inAndOut' },
          width: '100%', height: '200px',
          redFrom: 0, redTo: 35,
          yellowFrom:36, yellowTo: 67,   
          greenFrom:68, greenTo: 100,       
          minorTicks: 5
        };
       
        var chart2 = new google.visualization.Gauge(document.getElementById('successratechart'));
       
        chart2.draw(successratedata, successrateoptions);

      //********************* Suceess Rate ********************** 
         
      
   
      
       //********************* Last 5 ********************** 
        //alert('My movie chart Strat');
        var last5data = google.visualization.arrayToDataTable([
                                                          ['Movie', 'Rating'],

                                                          <?php 
                                                     	         $sql = "select s.title,  s.rating from tolly_ready_for_shoot s WHERE s.uid =  ".$uid." and s.`status` = 'out' ORDER BY s.dt LIMIT 5";
                                                     	         //echo '<h2>'.$sql.'</h2>';
                                                     	         $result = mysqli_query ( $conn, $sql );
                                                     	         if (mysqli_num_rows($result) > 0) {
                                                     	           	while($row = mysqli_fetch_assoc($result)) {           		
                                                     	           		$title = $row["title"];
                                                     	           		$rating = $row["rating"];           
                                                     	           		echo "['".$title."', ".$rating."],";
                                                     	           	}
                                                     	           } 
                                                     	         ?> 

                                                        ]);

                                                        var last5options = {
                                                          chart: {
                                                            title: 'Last 5 Movies',
                                                            titleTextStyle:{color: 'black', fontName: 'Century Gothic', fontSize: 14}
                                                          }
                                                        };
                                                       // alert('My movie chart End');
                                                        var last5chart = new google.charts.Bar(document.getElementById('last5'));

                                                        last5chart.draw(last5data, last5options);
                                                  

//********************* Last 5 ********************** 


        
      }
    </script>

</body>

</html> <?php mysqli_close($conn);?>
