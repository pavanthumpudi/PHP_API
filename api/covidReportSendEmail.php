<?php
    use PHPMailer\PHPMailer\PHPMailer;

	require 'database.php';
    //if (isset($_POST['name']) && isset($_POST['email'])) {
	$name 		= "Employee Healt Status";
	$email 		= "altranpavan@gmail.com";
	$subject 	= "Employee health report";
	//$body = $_POST['body'];
	//print ($body);
	require_once "PHPMailer/PHPMailer.php";
	require_once "PHPMailer/SMTP.php";
	require_once "PHPMailer/Exception.php";

	$mail = new PHPMailer();

	//SMTP Settings
	$mail->isSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPAuth = true;
	$mail->Username = "altranpavan@gmail.com";
	$mail->Password = 'Try@119.';
	$mail->Port = 465; //587
	$mail->SMTPSecure = "ssl"; //tls

	//Email Settings
	$mail->isHTML(true);
	$mail->setFrom($email, $name);
	$mail->addAddress("pavanthumpudi@gmail.com");
	$mail->Subject = $subject;
        
   
	//echo "Hi";
	$date = date_create()->format('Y-m-d');
	$datetime = date_create()->format('Y-m-d H:i:s');
	$sql = "SELECT employee.firstname, employee.email, healthchecklist.* 
	FROM `healthchecklist` 
	left join employee on employee.id=healthchecklist.eid
	where healthchecklist.date='{$date}'";

	if($result = mysqli_query($con,$sql))
	{
	$table_body = " <tbody>";
	  while($row = mysqli_fetch_assoc($result)) {
		//print_r($row);
		$firstname = $row['firstname'];
		$email = $row['email'];
		$symptions = "";
		if ($row['cold'] ==1) {
			$symptions .= "Cold";
		}
		if ($row['cough'] ==1) {
			$symptions .= ", Cough";
		}
		if ($row['fever'] ==1) {
			$symptions .= ", Fever";
		}
		if ($row['difficultyinbreath'] ==1) {
			$symptions .= ", Difficulty In Breathing";
		}
		if ($row['lossofsenses'] ==1) {
			$symptions .= ", Loss Of Senses For Smell And Taste";
		}
		
		$employeeunhealty	= ((
		$row['cold']+
		$row['cough']+ 
		$row['fever'] + 
		$row['difficultyinbreath']+ 
		$row['lossofsenses'])/5 )*100;
		$table_body .=" <tr style='border: 1px solid black;'><td style='border: 1px solid black;'>$firstname";
		$table_body .=" </td><td style='border: 1px solid black;'>$email"; 
		$table_body .=" </td><td style='border: 1px solid black;'>$symptions" ;
		$table_body .=" </td><td style='border: 1px solid black;'>$employeeunhealty %";
		$table_body .=" </td></tr>";
	}
	$text_message = "<p>Hello,</p><br><br><p>Please find the table of employee Health report for the day <strong>{$date}</strong></p><br><br>";
	$table_start = "<table style='border: 1px solid black;border-collapse: collapse; width: 90%;'> <thead> <tr style='border: 1px solid black;'> <th style='border: 1px solid black;'>Firstname</th> <th style='border: 1px solid black;'>Email</th> <th style='border: 1px solid black;'>Symptoms</th> <th style='border: 1px solid black;'>Health Issue</th> </tr> </thead>";
	$table_end = "</tbody></table>";
	$table = $text_message .' '. $table_start ." ". $table_body ." ". $table_end;
	//print($table);
	$mail->Body = $table;

        if ($mail->send()) {
            $status = "success";
            $response = "Email has been sent !";
        } else {
            $status = "failed";
            $response = "Something is wrong: <br><br>" . $mail->ErrorInfo;
        }

        echo json_encode(array("status" => $status, "response" => $response));
    }
//}
?>
