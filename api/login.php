
<?php
/*
https://www.youtube.com/watch?v=UrfhqE7I-3o&list=PLC3y8-rFHvwg2RBz6UplKTGIXREj9dV0G&index=25
*/
include_once("database.php");

$postdata = $_POST['emailId'];
if(isset($postdata) && !empty($postdata))
{
	$pwd = mysqli_real_escape_string($con, trim($_POST['password']));
	$email = mysqli_real_escape_string($con, trim($_POST['emailId']));
	$sql = "SELECT * FROM employee where email='{$email}'";
	if ($email != "" ) {
		
		if($result = mysqli_query($con,$sql)) {
			//print(md5($pwd));
			$count = mysqli_num_rows($result);
			if ($count != 0) {
				$rows = mysqli_fetch_assoc($result);
				if ($rows['id'] != "" && $rows['password'] == md5($pwd)) {	
					$paylod = [
						'iat' => time(),
						'iss' => '127.0.0.1:8080',
						//'exp' => time() + (15*60),
						'userId' => $rows['id']
					];

					$token = JWT::encode($paylod, "secret");
					
					$data = array('token' => $token, 'id' => $rows['id']);
					echo json_encode($data);
				} else {
					//$response = [];
					$data = array('message' => "Incorrect password");
					echo json_encode($data);
					http_response_code(400);
				}
			} else {
				$data = array('message' => "User with the given email does not exist");
				echo json_encode($data);
				http_response_code(400);
			}
			
		} else {
			$data = array('message' => "Failed to connect database");
			echo json_encode($data);
			http_response_code(400);
		}
	} else {
		$data = array('message' => "User with the given email does not exist");
		echo json_encode($data);
		http_response_code(400);
	}
}
?>