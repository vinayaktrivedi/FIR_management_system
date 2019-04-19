<?php
session_start();
function upload_photo($string){
	$target_file = $target_dir . basename($_FILES[$string]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES[$string]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	
	if ($_FILES[$string]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	
	} else {
	    if (move_uploaded_file($_FILES[$string]["tmp_name"], $target_file)) {
	        echo "The file has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

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

			<form class="contact1-form validate-form" action="registerFir.php" method="post" enctype="multipart/form-data">

			<input type="hidden" name="stage" value="register_submit" >
				<span class="contact1-form-title">
					Register FIR
				</span>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="time" placeholder="Time of crime">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="reg_id" placeholder="Reporting person Id">
					<span class="shadow-input1"></span>
				</div> 
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="criminal_id" placeholder="Id of criminal">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
				or choose photo
				</div>
				<div class="wrap-input1 validate-input">
				<input type="file" name="criminal_photo" id="criminal_photo">
				<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="victim_id" placeholder="Id of victim">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
				or choose photo
				</div>
				<div class="wrap-input1 validate-input">
				<input type="file" name="victim_photo" id="victim_photo">
				<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="area_id" placeholder="Area Id of crime">
					<span class="shadow-input1"></span>
				</div>
				
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="id_proof_no" placeholder="ID Proof Number">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="id_proof_type" placeholder="ID Proof Type">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="location" placeholder="Location">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="crime_id" placeholder="Crime ID">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input" >
					<textarea class="input1" name="description" placeholder="Provide Description"></textarea>
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
else if($_POST["stage"]=="register_form"){
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		echo $template;
	}
}

else if($_POST["stage"]=="register_submit"){
	if (!isset($_SESSION["station_id"])){
		header('Location: http://localhost:8080');
		exit(1);
	}
	else{
		$db = new SQLite3('fir.db');
		$target_dir = "uploads/";
		$time = test_input($_POST["time"]);
	  	$reg_id = test_input($_POST["reg_id"]);
	  	$criminal_id = test_input($_POST["criminal_id"]);
	  	$victim_id = test_input($_POST["victim_id"]);
	  	$area_id = test_input($_POST["area_id"]);
	  	$id_proof_no = test_input($_POST["id_proof_no"]);
	  	$id_proof_type = test_input($_POST["id_proof_type"]);
	  	$location = test_input($_POST["location"]);
	  	$crime_id = test_input($_POST["crime_id"]);
	  	$description = test_input($_POST["description"]);
	  	$current_time = date("Y-m-d");
	  	if (empty($criminal_id)){
	  		echo '111';
	  		exit(1);
  			upload_photo('criminal_photo');
  		}
  		if (empty($victim_id)){
  			echo '121';
	  		exit(1);
  			upload_photo('victim_id');
  		}
  		$qstr = "insert into fir_details (time,description,crime_id,id_proof_type,id_proof_no,crimelocation,reg_id,criminal_id,victim_id,dt_time,area_id) values ('$current_time', '$description', '$crime_id', '$id_proof_type','id_proof_no','$location','$reg_id','$criminal_id','$victim_id','$time','$area_id')";

  		$insres = $db->query($qstr);
  		if ($insres){
  			
  		}else{
  			echo '221';
  			 echo $db->lastErrorMsg();
  			 exit(1);
  		}
	}
}
?>