<?php
/**
 * Returns the list of skill.
 */
require 'database.php';

$skill = [];
$sql = "SELECT * FROM skill";
//print($_GET['name']);
if (isset($_GET['name']) == true && $_GET['name'] != "") {
	$skill_name = $_GET['name'];
	$sql .=" where skill like '%{$skill_name}%'";
}
//print($sql);
if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $skill[$i]['id']    = $row['id'];
    $skill[$i]['skill'] = $row['skill'];
    $i++;
  }

  echo json_encode($skill);
}
else
{
  http_response_code(404);
}