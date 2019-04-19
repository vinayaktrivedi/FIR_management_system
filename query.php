<?php

$template_header = '<!DOCTYPE html>
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
			</form>';
	

$template_footer = '			
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


$db = new SQLite3('fir.db');
if($_POST['query_type'] == 'select'){
	$results = $db->query($_POST["query"]);
	$num=$_POST["column"];

	$return =<<<HTML
		<br><br><div class="wrap-input1 validate-input"><center><table border="1">
HTML;

	while($row = $results->fetchArray()){
		$return .= <<<HTML
		<tr>
HTML;

		for($i=0;$i<$num;$i++){
			$return .= <<<HTML
		<td>{$row[$i]}</td>
HTML;
		}
		$return .= <<<HTML
		</tr>
HTML;
	}
	$return.= <<<HTML
	</table></center></div>
HTML;

	echo $template_header.$return.$template_footer;
}
else if($_POST['query_type'] == 'exec'){
	$db->exec($_POST["query"]);
	header('Location: http://localhost:8080/home.php');
	exit(1);
}

?>