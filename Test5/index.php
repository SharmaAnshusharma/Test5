<?php
include('config.php');
$url = "http://localhost/Test/getData.php";
$json_data = file_get_contents($url);
$response_data = json_decode($json_data);
$plan_data = $response_data;

/*echo "<pre>";
print_r($plan_data);
*/

$success_msg = "";
$error_msg = "";

?>



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
	
		<div class="container" >

			<h1 class="text-center">Registeration</h1>
			
			<form method="post">

				<div class="row">
					<div class="col-sm-5">
						First Name
						<input type="text" name="fname" class="form-control" required>
						Email
						<input type="email" name="email" class="form-control"  required>
						Plan
						<select name="plan" class="form-control" id="plan_name" required="">
							<option value="">Select Plan</option>
							<?php

								foreach($plan_data as $plan)
								{


								?>
								<option value="<?php echo $plan->ID; ?>"><?php echo $plan->plan;  ?></option>
							<?php


								}
							?>
						</select>


					</div>
					<div class="col-sm-5">
						Last Name
						<input type="text" name="lname" class="form-control"  required>
						Phone
						<input type="text" name="mobile" class="form-control" minlength="10" maxlength="10" required>
						Amount

						<div id="amount">
							<input type="text" id="amount" name="amount" class="form-control" readonly>
						</div>
					</div>				
				</div>
				<br>
				<div class="row" >
					<div class="col-sm-10" align="center">
					<input type="submit" value="Save" name="submit" class="btn btn-outline-primary" >
				</div>
			</form>
		</div>
<script>
	$(document).ready(function(){
		//alert('Hellow');
		$('#plan_name').change(function(){
			var plan_id = $('#plan_name').val();
			$.ajax({
				url:'search.php',
				type:'post',
				data:{plan_id:plan_id},
				success:function(response)
				{
					$('#amount').html(response);
				}
			}); 
		});


	});

</script>
</body>
</html>
<?php
if(isset($_POST['submit']))
{
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$username = $fname.$lname;

	
	$select = mysqli_query($con,"SELECT 1 FROM `user_table` WHERE `user_name` = '$username'" );
	$select1 = mysqli_query($con,"SELECT 1 FROM `user_table` WHERE `email` = '$email'" );
	if(mysqli_num_rows($select) > 0)
	{
		$error_msg = "User Name already Exists";

	}
	elseif(mysqli_num_rows($select1) > 0)
	{
		$error_msg = "Email already Exists";
		
	}
	else
	{
		$insert_query = mysqli_query($con,"INSERT INTO `user_table`(`user_name`, `first_name`, `last_name`, `email`, `phone`) VALUES ('$username','$fname','$lname','$email','$mobile')");

		$result = mysqli_query($con,"SELECT * FROM `user_table` ORDER BY `ID` DESC");
		$row = mysqli_fetch_array($result);
		$user_id = $row['ID'];
		$plan_amount = $plan->amount;
		$plan_id = $plan->ID;
		$order_insert = mysqli_query($con,"INSERT INTO `order_table`(`user_id`, `plan_id`, `amount`) VALUES ('$user_id','$plan_id','$plan_amount')");

		if($insert_query == true && $order_insert == true)
		{
			$success_msg =  "Data Inserted Success";
		}
		else
		{
			$error_msg = "Failed to Insert Data";
		}	
	}


}
echo "<br>";
			if(isset($success_msg) && $success_msg !='')
			{
				?>
				<p class="alert alert-success"><?php echo $success_msg; ?></p>
				<?php
			}
			if(isset($error_msg) && $error_msg !='')
			{
				?>
				<p class="alert alert-danger"><?php echo $error_msg; ?></p>
				<?php
			}

			?>
