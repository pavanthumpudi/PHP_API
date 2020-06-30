<?php
/**
 * Returns the list of employee.
 */
require 'database.php';
$skill_name = $_GET['skill'];
$employee = [];

$sql = "SELECT employee.id, employee.firstname, employee.lastname, employee.email, employee.gender, COUNT((emp_skill.id)) as skill_count, group_concat(skill.skill) as skills_list FROM `employee` 
left join emp_skill on employee.id = emp_skill.eid
left join skill on skill.id = emp_skill.sid
WHERE employee.firstname like '%{$skill_name}%'  group by employee.id
";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $employee[$i]['id']    		= $row['id'];
    $employee[$i]['firstName'] 	= $row['firstname'];
    $employee[$i]['lastName'] 	= $row['lastname'];
	$employee[$i]['emailId'] 	= $row['email'];
	$employee[$i]['skillCount'] = $row['skill_count'];
	$employee[$i]['skills'] 	= $row['skills_list'];
	$employee[$i]['gender'] 	= $row['gender'];
    $i++;
  }

  echo json_encode($employee);
}
else
{
  http_response_code(404);
}