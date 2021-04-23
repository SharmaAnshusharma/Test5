<?php
include('config.php');
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,POST');

$query = mysqli_query($con,"SELECT * FROM `plan`");
while($row = mysqli_fetch_array($query))
{
	$output[] = array(
		"ID"=>$row['ID'],
		"plan"=>$row['plan'],
		"amount"=>$row['amount']
	);

}
echo json_encode($output);
?>