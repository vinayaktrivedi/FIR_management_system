<?php
session_start();
if(isset($_SESSION["msg"])) {
	$msg = $_SESSION["msg"];
	session_unset($_SESSION["msg"]);
} else {
	$msg = "";
}
if(isset($_SESSION["error"])) {
	$error = $_SESSION["error"];
	session_unset($_SESSION["error"]);
} else {
	$error = "";
}

$return =<<<HTML
<!DOCTYPE html>
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
	<div class="message"><center>{$msg}</center></div><br />
	<div class="error"><center>{$error}</center></div><br />
	<div class="contact1">
	
		<div class="container-contact1">	
			
			<form class="contact1-form validate-form" action="home.php" method="post">

			<input type="hidden" name="stage" value="login_submit" >
				<span class="contact1-form-title">
					FIR Management System
				</span>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="station_id" placeholder="Station id">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="password" placeholder="Password">
					<span class="shadow-input1"></span>
				</div>
				
				<div class="container-contact1-form-btn">
					<button class="contact1-form-btn">
						<span>
							Log In
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
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

HTML;
	echo $return;
?>