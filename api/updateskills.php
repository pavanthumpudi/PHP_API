<?php
require 'database.php';

	if ((int)$_GET['id'] < 1 ) {
		return http_response_code(400);
	}

	$id    		= $_GET['id'];
	$dsql = "DELETE FROM `emp_skill` WHERE `eid` ='{$id}'";
	mysqli_query($con, $dsql);
	$skills = json_decode($_POST['skills']);
	print_r($skills);
	foreach($skills as $k => $v) {
		echo $v;
		$sql= "INSERT INTO `emp_skill` (`id`, `eid`, `sid`) VALUES (NULL, '{$id}', '{$v}');";
		$status = mysqli_query($con, $sql);
		echo mysqli_insert_id($con);
	}
	  
