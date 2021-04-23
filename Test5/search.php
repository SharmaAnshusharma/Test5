<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include('config.php');
$plan_id = $_POST['plan_id'];
if(isset($plan_id) && $plan_id != '')
{
	$query = mysqli_query($con,"SELECT `amount` FROM `plan` WHERE `ID` = '$plan_id' ");
	$row = mysqli_fetch_array($query);
	?>
		<input type="text" name="amount" class="form-control" value="<?php echo $row['amount']; ?>" readonly>
	<?php
}
else
{
		?>
		<input type="text" name="amount" class="form-control" value="Please Select any Plan" readonly>
	<?php
}

?>

</body>
</html>