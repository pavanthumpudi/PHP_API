<?php
/**
 * Returns the list of employee.
 */
require 'database.php';

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

	$user_id = validateToken();
	if ($user_id) {
		$employee = [];
		$sql = "SELECT employee.*, COUNT((emp_skill.id)) as skill_count, group_concat(skill.skill) as skills_list FROM `employee` left join emp_skill on emp_skill.eid = employee.id left join skill on emp_skill.sid = skill.id where employee.id != '{$user_id}' group by employee.id order by employee.firstname";

		if($result = mysqli_query($con,$sql))
		{
		  $i = 0;
		  while($row = mysqli_fetch_assoc($result))
		  {
			$employee[$i]['id']    = $row['id'];
			$employee[$i]['firstName'] = $row['firstname'];
			$employee[$i]['lastName'] = $row['lastname'];
			$employee[$i]['emailId'] = $row['email'];
			$employee[$i]['skillCount'] = $row['skill_count'];
			$employee[$i]['skills'] = $row['skills_list'];
			$employee[$i]['gender'] = $row['gender'];
			$i++;
		  }
		  //http_response_code(200);
		  echo json_encode($employee);
		} else {
		  http_response_code(404);
		}
	}
	
