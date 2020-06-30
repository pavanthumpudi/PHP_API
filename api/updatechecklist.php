<?php

require 'database.php';
/** 
 * Get header Authorization
 * */
// Get the posted data.
//$postdata = file_get_contents("php://input");

//Print("hello");
// php -S 127.0.0.1:8080 -t ./angular7-php-app/backend
/*if(isset($_POST['cold']) && !empty($_POST['cold']))
{*/
		/** 
 * Get header Authorization
 * */
function getAuthorizationHeader(){
	$headers = null;
	if (isset($_SERVER['Authorization'])) {
		$headers = trim($_SERVER["Authorization"]);
	}
	else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
		$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	} elseif (function_exists('apache_request_headers')) {
		$requestHeaders = apache_request_headers();
		// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
		$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
		//print_r($requestHeaders);
		if (isset($requestHeaders['Authorization'])) {
			$headers = trim($requestHeaders['Authorization']);
		}
	}
	return $headers;
}
/**
 * get access token from header
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function validateToken() {
	try {
		$token = getBearerToken();
		//print ($token);
		$payload = JWT::decode($token, "secret", ['HS256']);
		//print_r ($payload);
		return $payload->userId;
	} catch (Exception $e) {
		http_response_code(200);
	}
}

	$eid = validateToken();
	$date = date_create()->format('Y-m-d');
  
	if($eid!=0)
	{
		$sql = "select * FROM `healthchecklist` WHERE `eid` ='{$eid}' and `date`='{$date}'LIMIT 1";
		if($result = mysqli_query($con,$sql))
		{
		  $rowcount=mysqli_num_rows($result);
			if($rowcount==0)
			{
				// Sanitize.
				  //$eid = 1;//mysqli_real_escape_string($con, trim($_POST['eid']));
				  $cold = mysqli_real_escape_string($con, (int)trim($_POST['cold']));
				  $cough = mysqli_real_escape_string($con, (int)trim($_POST['cough']));
				  $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
				  $dib = mysqli_real_escape_string($con, (int)trim($_POST['dib']));
				  $fever = mysqli_real_escape_string($con, (int)trim($_POST['fever']));
				  $los = mysqli_real_escape_string($con, (int)trim($_POST['los']));
				  //$other = mysqli_real_escape_string($con, (int)trim($_POST['other']));
				  $time = "";
				  // Create.
				  $sql = "INSERT INTO `healthchecklist`(`eid`,`cold`,`cough`,`comment`,`difficultyinbreath`,`fever`,`lossofsenses`,`date`) VALUES ('{$eid}','{$cold}', '{$cough}', '{$comment}', '{$dib}', '{$fever}', '{$los}','{$date}')";

				  if(mysqli_query($con,$sql))
				  {
					http_response_code(201);
					$user = [
					  'id'    => mysqli_insert_id($con)
					];
					echo json_encode($user);
				  }
				  else
				  {
					echo("Error description: " . mysqli_error($con));
					http_response_code(422);
				  }
	
			} else {
				$data = array('message' => "You have Already submitted your health status");
				echo json_encode($data);
				http_response_code(400);
			}	
		}
		
		
  }
/*} else {
	echo "hello";
	http_response_code(422);
}*/
?>