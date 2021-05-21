<!DOCTYPE html>
<html>
<body>

<style>
h1 {
  color: white;
  text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
  box-shadow: 1px 1px blue;
}

h2 {
  text-shadow: 2px 2px 5px red;
}



</style>


<?php

include 'db.php';
 
 
$rid = $_GET ["rid"]; 
$days = $_GET ["days"]; 
 
//================ DISPLAY CENTERS
$sql = "SELECT * from centers WHERE rid=".$rid;

$d25_html="";
$result = mysqli_query($conn, $sql);
  	
     	if (mysqli_num_rows($result) > 0) {
     		// output data of each row
			
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$d25_str = $row["25list"];
     			$d50_str = $row["50list"];
				$d75_str = $row["75list"];
     			$d100_str = $row["100list"];
				$d150_str = $row["150list"];
     			$d175_str = $row["175list"];
				$d200_str = $row["200list"];
     			$d250_str = $row["250list"];
     			$d300_str = $row["300list"];
				$dMax = $row["maxlist"]; 		
     		}
     	}





//25 days centers
echo "<h1> 25days centers</h1>";
$sql = "SELECT * FROM `thearterslist` where id IN (". $d25_str. ") ORDER BY `city` ASC;";
 
$d25_html="";
$result = mysqli_query($conn, $sql);
  	
     	if (mysqli_num_rows($result) > 0) {
     		// output data of each row
			
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d25_html = $d25_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d25_html;



//50 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d50_str. ") ORDER BY `city` ASC;";
 
$d50_html="";
$result = mysqli_query($conn, $sql);
  	
     	if (mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 50 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d50_html = $d50_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d50_html;




//75 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d75_str. ") ORDER BY `city` ASC;";
 
$d75_html="";
$result = mysqli_query($conn, $sql);
  	
     	if (mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 75 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d75_html = $d75_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d75_html;



//100 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d100_str. ") ORDER BY `city` ASC;";
 
$d100_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 100 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d100_html = $d100_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d100_html;



//150 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d150_str. ") ORDER BY `city` ASC;";
 
$d150_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 150 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d150_html = $d150_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d150_html;



//175 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d175_str. ") ORDER BY `city` ASC;";
 
$d175_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 175 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d175_html = $d175_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d175_html;




//200 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d200_str. ") ORDER BY `city` ASC;";
 
$d200_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 200 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d200_html = $d200_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d200_html;




//250 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d250_str. ") ORDER BY `city` ASC;";
 
$d250_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 250 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d250_html = $d250_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d250_html;



//300 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $d300_str. ") ORDER BY `city` ASC;";
 
$d300_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			echo "<h1> 300 days centers</h1>";
			$count = 1;
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$d300_html = $d300_html."<p>" .$count++. "." .mb_strimwidth($city,0,10)."\t - <b>".$name. "</b> </p>" ;  		
     		}
     	}  
		
		echo "".$d300_html;




//300 days centers

$sql = "SELECT * FROM `thearterslist` where id IN (". $dMax. ") ORDER BY `city` ASC;";
 
$dMax_html="";
$result = mysqli_query($conn, $sql);
  	
     	if ($result!=null && mysqli_num_rows($result) > 0) {
     		// output data of each row
			
		 
     		while($row = mysqli_fetch_assoc($result)) {
     			$name = $row["name"];
     			$city = $row["city"];
				
     			$dMax_html = $name.", ".$city; 		
     		}
     	}  
		
		echo "<h1>Total ".$days." Days </h1>";
		echo "<b><h3 style=\"color:blue\"> ".$dMax_html."</h3>";



// Centers ================== Calculation ============== Start 


 
?>

</body>
</html>
