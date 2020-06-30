<?php

require 'database.php';

// Get the posted data.
//$postdata = file_get_contents("php://input");

//Print("hello");
// php -S 127.0.0.1:8080 -t ./angular7-php-app/backend
if(isset($_POST['email']) && !empty($_POST['email'])) {
 
  // Sanitize.
  $firstName = mysqli_real_escape_string($con, trim($_POST['firstName']));
  $lastName = mysqli_real_escape_string($con, trim($_POST['lastName']));
  $email = mysqli_real_escape_string($con, trim($_POST['emailId']));
  $password = md5(mysqli_real_escape_string($con, trim($_POST['password'])));

	$sql = "select * FROM `employee` WHERE `email` ='{$email}' LIMIT 1";
	if($result = mysqli_query($con,$sql)) {
		$rowcount=mysqli_num_rows($result);
		if($rowcount==0) {
			// Create.
			$sql = "INSERT INTO `employee`(`firstname`,`lastname`,`email`, `password`) VALUES ('{$firstName}','{$lastName}', '{$email}', '{$password}')";

			if(mysqli_query($con,$sql)) {
				http_response_code(201);
				$user = [
				  'firstName' => $firstName,
				  'lastName' => $lastName,
				  'emailId' => $email,
				  'id'    => mysqli_insert_id($con)
				];
				$paylod = [
					'iat' => time(),
					'iss' => '127.0.0.1:8080',
					//'exp' => time() + (15*60),
					'userId' => $user['id']
				];

				$token = JWT::encode($paylod, "secret");

				$data = array('token' => $token, 'id' => $user['id']);
				echo json_encode($data);
			} else {
				echo("Error description: " . mysqli_error($con));
			}
		} else {
			$data = array('message' => "User already exists with the given email");
			echo json_encode($data);
			http_response_code(400);
		}
	}
  
} else {
	$data = array('message' => "Provide email");
	echo json_encode($data);
	http_response_code(400);
}