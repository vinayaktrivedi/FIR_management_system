<?php
session_start();
$template = '<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="contact1">
	
		<div class="container-contact1">	
			<form action="home.php" method="post">
			 	<input type="hidden" name="stage" value="backtohome" >	
			 	<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Home" >
			</form>
			<br>
			<form action="home.php" method="post">
			 	<input type="hidden" name="stage" value="logout" >	
			 	<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Log out" >
			</form>

			<form class="contact1-form validate-form" action="registerUser.php" method="post">

			<input type="hidden" name="stage" value="register_user_submit" >
				<span class="contact1-form-title">
					Register FIR
				</span>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="name" placeholder="Name">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="email" placeholder="Email">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="gender" placeholder="Gender">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="city_id" placeholder="City Id">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="area_id" placeholder="Area ID">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="address" placeholder="Address">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="contact" placeholder="Contact No.">
					<span class="shadow-input1"></span>
				</div>
				<div class="container-contact1-form-btn">
					<button class="contact1-form-btn">
						<span>
							Register
							<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</form>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$(".js-tilt").tilt({
			scale: 1.1
		})
	</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "UA-23581568-13");
</script>

<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		echo $template;
	}
}
#showing form for registering FIR
else if($_POST["stage"]=="register_user"){
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		echo $template;
	}
}

else if($_POST["stage"]=="register_user_submit"){
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		$db = new SQLite3('fir.db');
		$name = ($_POST["name"]);
	  	$email = ($_POST["email"]);
	  	$city_id = ($_POST["city_id"]);
	  	$area_id = ($_POST["area_id"]);
		$gender = ($_POST["gender"]);
		$contact = $_POST["contact"];
		$address = $_POST["address"];

		$result = $db->query("SELECT id FROM profile WHERE emailid = '$email'");
		$count=0;
		while($row = $result->fetchArray()) {
			$count++;
		}
		if($count > 0){
			$result = $db->query("SELECT id FROM profile WHERE emailid = '$email'");
			$row = $result->fetchArray();
			$_SESSION["registerUsermsg"] = "User already registered with id ".$row[0];
			header('Location: http://localhost:8080/home.php');
			exit(1);
		}
	
  		$qstr = "insert into profile (name,gender,address,contact_no, emailid,city_id, area_id)  values ('$name', '$gender', '$address', '$contact', '$email', '$city_id', '$area_id')";
		$db->exec($qstr);
		$result = $db->query("SELECT id FROM profile WHERE emailid = '$email'");
		$row = $result->fetchArray();
		$_SESSION["registerUsermsg"] = "User registered with id ".$row[0];
		header('Location: http://localhost:8080/home.php');
		exit(1);
		  
	}
}
?>