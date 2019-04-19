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
		<form action="registerFir.php" method="post" >
	 			<input type="hidden" name="stage" value="register_form" >	
 				<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Register FIR" >
			 </form>
			 <br >
			 <form action="revokeFir.php" method="post">
			 	<input type="hidden" name="stage" value="revoke_form" >	
			 	<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Revoke FIR" >
			</form>
			<br>
			<form action="registerUser.php" method="post">
			 	<input type="hidden" name="stage" value="register_user" >	
			 	<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Register User" >
			</form>
            <br>
            <form action="stats.php" method="post">
			 	<input type="hidden" name="stage" value="show_stats" >	
			 	<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Show Stats" >
            </form>
            <br>
            <form action="home.php" method="post">
			 	<input type="hidden" name="stage" value="logout" >	
			 	<input class="contact1-form-btn" type="submit" name="allreg" style="float:right;" value="Log out" >
			</form>
			<br>
			
			<form class="contact1-form validate-form" action="query.php" method="post">


				<span class="contact1-form-title">
					Query
				</span>
				<div class="wrap-input1 validate-input" data-validate = "Message is required">
				<input type="radio" name="query_type" value="select">  Select
				<input type="radio" name="query_type" value="exec">  Exec
				
				<span class="shadow-input1"></span>

				</div>

				<div class="wrap-input1 validate-input" data-validate = "Message is required">
					<textarea class="input1" name="query" placeholder="Query"></textarea>
					<span class="shadow-input1"></span>
				</div>

				<div class="container-contact1-form-btn">
					<button class="contact1-form-btn">
						<span>
							Query
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
	}
	else{
        echo $_SESSION["registerUsermsg"];
        echo "<br>";
		echo $template;
	}
}

else if($_POST["stage"]=="login_submit" ){
	
    $db = new SQLite3('fir.db');
    $station_id= $_POST["station_id"];
    $pass = $_POST["password"];
    $result = $db->query("SELECT * FROM police_login WHERE station_id = '$station_id' and password= '$pass'");
    $count=0;
    while($row = $result->fetchArray()) {
        $count++;
    }
    if($count <= 0){
        header('Location: http://localhost:8080');
        exit(1);
    }
    if(!isset($_SESSION["station_id"])){
        $_SESSION["station_id"]=$station_id;
    }
	echo $template;
}
else if($_POST["stage"]=="logout"){
    unset($_SESSION["station_id"]);
    session_destroy();
    header('Location: http://localhost:8080');
    exit(1);
    exit;
}
else if($_POST["stage"]=="backtohome"){
	// header('Location: home.php');
	echo $template;
    // exit;
}

?>