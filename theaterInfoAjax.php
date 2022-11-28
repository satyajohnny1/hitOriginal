<?php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

if(isset($_POST["type"]))
{
 if($_POST["type"] == "category_data")
 {
  $query = "
  SELECT * FROM tbl_industry 
  ORDER BY industry_name ASC
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["industry_id"],
    'name'  => $row["industry_name"]
   );
  }
  echo json_encode($output);
 }
 else
 {
  $query = "
  SELECT * FROM tbl_sub_industry 
  WHERE industry_id = '".$_POST["category_id"]."' 
  ORDER BY sub_industry_name ASC
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["sub_industry_id"],
    'name'  => $row["sub_industry_name"]
   );
  }
  echo json_encode($output);
 }
}

?>
