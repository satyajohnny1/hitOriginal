<!DOCTYPE html>
<html>
<body>

<?php
 
 $numbers = range(1, 1340);
$cent25 = 30;
$cent50 = 15;
$cent75 = 7;
$cent100 = 4;
$cent150 = 2;
$cent175 = 1;
$centMax = 0;
shuffle($numbers);
shuffle($numbers);

 
$cent25  =  array_slice($numbers, 0, $cent25);
$cent25_str  = implode(',', $cent25);
shuffle($cent25);

 
$cent50  = array_slice($cent25,0,$cent50);
$cent50_str  = implode(',', $cent50);
shuffle($cent50);
 

 
$cent75  = array_slice($cent50,0,$cent75);
$cent75_str  = implode(',', $cent75);
shuffle($cent75);

 
$cent100  = array_slice($cent75,0,$cent100);
$cent100_str  = implode(',', $cent100);
shuffle($cent100);


$cent150  = array_slice($cent100,0,$cent150);
$cent150_str  = implode(',', $cent150);
shuffle($cent150);
 

$cent175  = array_slice($cent150,0,$cent175);
$cent175_str  = implode(',', $cent175);
shuffle($cent175);


$centMax  = $numbers[0];

if($cent25!=null){
	$centMax  = $cent25[0];
}
if($cent50!=null){
	$centMax  = $cent50[0];
}
if($cent75!=null){
	$centMax  = $cent75[0];
}

if($cent100!=null){
	$centMax  = $cent100[0];
}

if($cent150!=null){
	$centMax  = $cent150[0];
}

if($cent175!=null){
	$centMax  = $cent175[0];
}




echo "<p>25 Days :".$cent25_str;

echo "</p> <p> 50 Days :".$cent50_str;

echo "</p> <p> 75 Days :".$cent75_str;

echo "</p> <p> 100 Days :".$cent100_str;

echo "</p> <p> 150 Days :".$cent150_str;

echo "</p> <p> 175 Days :".$cent175_str;

echo "</p> <p> Max Days :".$centMax;

 
?>

</body>
</html>
