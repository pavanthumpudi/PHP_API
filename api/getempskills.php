<?php
/**
 * Returns the list of skill.
 */
require 'database.php';
$id    = $_GET['id'];
$skill = [];
$sql = "SELECT skill.id, skill.skill FROM `emp_skill` left join skill on skill.id = emp_skill.sid WHERE emp_skill.eid = {$id}";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $skill[$i]['id']    = $row['id'];
    $skill[$i]['skill'] = $row['skill'];
    $i++;
  }

  echo json_encode($skill);
}
else
{
  http_response_code(404);
}