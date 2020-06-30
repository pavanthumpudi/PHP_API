<?php

require 'database.php';

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
			$payload = JWT::decode($token, "secret", ['HS256']);
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
		  $data = array('count' => $rowcount, 'message' => "You have Already submitted your health status");
		  echo json_encode($data);

		}		
	}
?>