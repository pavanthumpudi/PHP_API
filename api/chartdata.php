<?php
/**
 * Returns the list of employee.
 */
require 'database.php';
$employee = [];

$sql = "SELECT skill.skill, count(emp_skill.id) as skill_count FROM `employee` 
left join emp_skill on employee.id = emp_skill.eid
left join skill on skill.id = emp_skill.sid
WHERE skill.skill != '' group by skill.skill order by skill.skill
";

if($result = mysqli_query($con,$sql))
{
$i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	$employee[$i]['skillCount'] = $row['skill_count'];
	$employee[$i]['skill']	= $row['skill'];
	$i ++;
  }

  echo json_encode($employee);
}
else
{
  http_response_code(404);
}