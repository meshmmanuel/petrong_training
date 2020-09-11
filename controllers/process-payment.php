<?php
	function processPayment($connect){
		$fullname = $phone = $email = $package = $amount = $ref = "";

		if(empty($_POST['name'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'><div class='alert alert-danger' role='alert'>Full Name field is empty.</div>";
			echo $errorMsg;
			return false;
		}else if(empty($_POST['phone'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Phone field is empty.</div>";
			echo $errorMsg;
			return false;
		}else if(empty($_POST['email'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Email field is empty.</div>";
			echo $errorMsg;
			return false;
		}else if(($_POST['package']) == "Select A Package"){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Please, Select A Package.</div>";
			echo $errorMsg;
			return false;
		}else if(empty($_POST['amount'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Amount field is empty.</div>";
			echo $errorMsg;
			return false;
		}else if(!preg_match("/^[a-zA-Z ]*$/",$_POST['name'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Only letters are allowed in the fullname field!</div>";
			echo $errorMsg;
			return false;
		}else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Fill Email field correctly.</div>";
			echo $errorMsg;
			return false;
		}else if(!preg_match("/^[0-9 ]*$/",$_POST['phone'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Only numbers are allowed in the phone field!</div>";
			echo $errorMsg;
			return false;
		}else if(!preg_match("/^[0-9 ]*$/",$_POST['amount'])){
			$errorMsg = "<div class='alert alert-danger' role='alert'>Only numbers are allowed in the amount field!</div>";
			echo $errorMsg;
			return false;
		}else{
            $name = mysqli_real_escape_string($connect, $_POST['name']);
            $phone = mysqli_real_escape_string($connect, $_POST['phone']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $amount = mysqli_real_escape_string($connect, $_POST['amount']);
			$package = $_POST['package'];
			$date = Date('d-m-y');
			$ref = "";

			$values = "{$name}', '{$email}', '{$phone}', '{$amount}', '{$package}', '{$ref}', '{$date}";
			$savePayment = mysqli_query($connect, "INSERT INTO payment_tbl(fullname, email, phone, package, amount, ref, date_created) VALUES('{$values}')");
			if(!$savePayment){
				die("Could not submit details: " . mysqli_error($connect));
			}else{
				echo "<div class='alert alert-success text-center pt-4' role='alert'>
				<p>Details submitted successfully!</p>
			  </div>";
			}
		}
	}
	if(isset($_POST['payBtn'])){
		processPayment($connect);
	}
?>