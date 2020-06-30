<?php

require 'database.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "select * FROM `employee` WHERE `id` ='{$id}' LIMIT 1";
//$result = mysqli_query($con, $sql)
if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $employee['id']    			= $row['id'];
    $employee['firstName'] 		= $row['firstname'];
    $employee['lastName'] 		= $row['lastname'];
	$employee['emailId'] 		= $row['email'];
	$employee['gender'] 		= $row['gender'];
	$employee['role'] 			= $row['role'];
	$employee['designation'] 	= $row['designation'];
	$employee['qualification'] 	= $row['qualification'];
	$employee['address'] 		= $row['address'];
	$employee['about'] 			= $row['about'];
    $i++;
  }

  echo json_encode($employee);
}
else
{
  return http_response_code(422);
}