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
			<br >
			<form class="contact1-form validate-form" action="revokeFir.php" method="post">

			<input type="hidden" name="stage" value="revoke_submit" >
				<span class="contact1-form-title">
					Revoke FIR
				</span>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="reg_id" placeholder="REG ID">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="f_id" placeholder="FIR ID">
					<span class="shadow-input1"></span>
				</div>
				
				<div class="container-contact1-form-btn">
					<button class="contact1-form-btn">
						<span>
							Revoke
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
</html>
';
#showing form for registering FIR

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		echo $_SESSION["revokeMsg"];
		echo $template;
	}
}


elseif($_POST["stage"]=="revoke_form"){
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		echo $template;
	}
}


#backend for registering 
else if($_POST["stage"]=="revoke_submit"){
	$db = new SQLite3('fir.db');
	$reg_id = ($_POST["reg_id"]);
	$f_id = ($_POST["f_id"]);
	$result = $db->query("SELECT f_id FROM fir_details WHERE f_id = '$f_id' and reg_id = '$reg_id'");
	$row = $result->fetchArray();
	if ($row) {
		echo "Sucessfully Revoked $row[0]";
		// TODO exec query
		$_SESSION["revokeMsg"] = "Successful";
		header('Location: http://localhost:8080/home.php');
	}
	else {
		$_SESSION["revokeMsg"] = "Invalid Details";
		header('Location: http://localhost:8080/revokeFir.php');
	}
}
else if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
	}
	else{
		echo "<br>";
		header('Location: http://localhost:8080/revokeFir.php');
		exit(1);
	}
}
?>