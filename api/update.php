<?php
require 'database.php';

// Get the posted data.
//$postdata = file_GET_contents("php://input");

if(isset($_POST['firstName']) && !empty($_POST['firstName']))
{
  
  if ((int)$_GET['id'] < 1 || trim($_POST['firstName']) == '' ) {
    return http_response_code(400);
  }

  // Sanitize.
  $id    		= $_GET['id'];
  $firstName 	= mysqli_real_escape_string($con, trim($_POST['firstName']));
  $lastName 	= mysqli_real_escape_string($con, trim($_POST['lastName']));
  $email 		= mysqli_real_escape_string($con, trim($_POST['emailId']));
  $address 		= mysqli_real_escape_string($con, trim($_POST['address']));
  $about 		= mysqli_real_escape_string($con, trim($_POST['about']));
  $quali 		= mysqli_real_escape_string($con, trim($_POST['qualification']));

  // Update.
  $sql = "UPDATE `employee` SET  `firstname`='$firstName',`lastname`='$lastName' ,`email`='$email', `address`='$address',`about`='$about' ,`qualification`='$quali' WHERE `id` = '{$id}' LIMIT 1";
	

  if(mysqli_query($con, $sql))
  {
	//$id    		= $_GET['id'];
	$dsql = "DELETE FROM `emp_skill` WHERE `eid` ='{$id}'";
	mysqli_query($con, $dsql);
	$skills = json_decode($_POST['skills']);
	//print_r($skills);
	foreach($skills as $k => $v) {
		$sql= "INSERT INTO `emp_skill` (`id`, `eid`, `sid`) VALUES (NULL, '{$id}', '{$v}');";
		$status = mysqli_query($con, $sql);
		//echo mysqli_insert_id($con);
	}
	http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}