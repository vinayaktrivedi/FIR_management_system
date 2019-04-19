<?php
session_start();
$err = "";
class compareImages
{
	public function mimeType($i)
	{
		/*returns array with mime type and if its jpg or png. Returns false if it isn't jpg or png*/
		$mime = getimagesize($i);
		$return = array($mime[0],$mime[1]);
      
		switch ($mime['mime'])
		{
			case 'image/jpeg':
				$return[] = 'jpg';
				return $return;
			case 'image/png':
				$return[] = 'png';
				return $return;
			default:
				return false;
		}
	}  
    
	public function createImage($i)
	{
		/*retuns image resource or false if its not jpg or png*/
		$mime = $this->mimeType($i);
      
		if($mime[2] == 'jpg')
		{
			return imagecreatefromjpeg ($i);
		} 
		else if ($mime[2] == 'png') 
		{
			return imagecreatefrompng ($i);
		} 
		else 
		{
			return false; 
		} 
	}
    
	public function resizeImage($i,$source)
	{
		/*resizes the image to a 8x8 squere and returns as image resource*/
		$mime = $this->mimeType($source);
      
		$t = imagecreatetruecolor(8, 8);
		
		$source = $this->createImage($source);
		
		imagecopyresized($t, $source, 0, 0, 0, 0, 8, 8, $mime[0], $mime[1]);
		
		return $t;
	}
    
    	public function colorMeanValue($i)
	{
		/*returns the mean value of the colors and the list of all pixel's colors*/
		$colorList = array();
		$colorSum = 0;
		for($a = 0;$a<8;$a++)
		{
		
			for($b = 0;$b<8;$b++)
			{
			
				$rgb = imagecolorat($i, $a, $b);
				$colorList[] = $rgb & 0xFF;
				$colorSum += $rgb & 0xFF;
				
			}
			
		}
		
		return array($colorSum/64,$colorList);
	}
    
    	public function bits($colorMean)
	{
		/*returns an array with 1 and zeros. If a color is bigger than the mean value of colors it is 1*/
		$bits = array();
		 
		foreach($colorMean[1] as $color){$bits[]= ($color>=$colorMean[0])?1:0;}
		return $bits;
	}
	
    	public function compare($a,$b)
	{
		/*main function. returns the hammering distance of two images' bit value*/
		$i1 = $this->createImage($a);
		$i2 = $this->createImage($b);
		
		if(!$i1 || !$i2){return false;}
		
		$i1 = $this->resizeImage($i1,$a);
		$i2 = $this->resizeImage($i2,$b);
		
		imagefilter($i1, IMG_FILTER_GRAYSCALE);
		imagefilter($i2, IMG_FILTER_GRAYSCALE);
		
		$colorMean1 = $this->colorMeanValue($i1);
		$colorMean2 = $this->colorMeanValue($i2);
		
		$bits1 = $this->bits($colorMean1);
		$bits2 = $this->bits($colorMean2);
		
		$hammeringDistance = 0;
		
		for($a = 0;$a<64;$a++)
		{
		
			if($bits1[$a] != $bits2[$a])
			{
				$hammeringDistance++;
			}
			
		}
		  
		return $hammeringDistance;
	}
}

function upload_photo($string,$target_dir,$id){
	$target_file = $target_dir .strval($id).".jpg";
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES[$string]["tmp_name"]);
    if($check !== false) {
        $err = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $err =  "File is not an image.";
        $uploadOk = 0;
        echo $err;
  				exit(1);
        return false;
    }
    if (file_exists($target_file)) {
	    $err =  "Sorry, file already exists.";
	    
	    $uploadOk = 0;
	    echo $err;
  				exit(1);
	    return false;
	}
	
	if ($_FILES[$string]["size"] > 500000) {
	    $err =  "Sorry, your file is too large.";
	    $uploadOk = 0;
	    echo $err;
  				exit(1);
	    return false;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    $err =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	    echo $err;
  				exit(1);
	    return false;
	}
	
	if ($uploadOk == 0) {

	    $err =  "Sorry, your file was not uploaded.";
	    echo $err;
  				exit(1);
	    return false;
	
	} else {
	    if (move_uploaded_file($_FILES[$string]["tmp_name"], $target_file)) {
	        return true;
	    } else {
	        $err = "Sorry, there was an error uploading your file.";
	        echo $err;
  				exit(1);
	        return false;
	    }
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function get_score($myphoto){
	$obj = new compareImages();
	$dir = new DirectoryIterator('users');
	foreach ($dir as $fileinfo) {
	    if (!$fileinfo->isDot()) {
	        $filename = $fileinfo->getFilename();
	        $result = $obj->compare($myphoto,'users/'.$filename);
	        if ($result == 0){
	        	$arr = explode('.', $filename);
	        	return (int)$arr[0];
	        }
	    }
	}
	return -1;
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
	  	$qstr = "insert into fir_details (time,description,status,crime_id,id_proof_type,id_proof_no,crimelocation,reg_id,criminal_id,victim_id,dt_time,area_id) values ('$current_time', '$description','1','$crime_id', '$id_proof_type','id_proof_no','$location','$reg_id','$criminal_id','$victim_id','$time','$area_id')";

  		$insres = $db->query($qstr);
  		$last_id = $db->lastInsertRowID();
  		if ($insres){
  			$_SESSION["registerUsermsg"] = "FIR Successfully registered! with id as ".$last_id."\n";
			
  		}else{
  			$_SESSION["registerUsermsg"] = "FIR not registered with error as ".$db->lastErrorMsg()."\n";
  			header('Location: http://localhost:8080/home.php');			
  		}
	  	if (empty($criminal_id)){
	  		$target_dir = "firs/criminals/";
  			$ok = upload_photo('criminal_photo',$target_dir,$last_id);
  			$myphoto = 'firs/criminals/'.strval($last_id).".jpg";
  			if ($ok){				
  				$criminal_id = get_score($myphoto);
  			}
  			else{
  				echo $err;
  				exit(1);
  			}
  			if ($criminal_id>=0){
  				$query = "update fir_details set criminal_id='$criminal_id' where F_id='$last_id' ";
				$insres = $db->query($qstr);
  				$_SESSION["registerUsermsg"] .= "\nFound the criminal with User id as ".$criminal_id;
  			}
  		}
  		if (empty($victim_id)){
  			$target_dir = 'firs/victims/';
  			$ok = upload_photo('victim_photo',$target_dir,$last_id);
  			$myphoto = 'firs/victims/'.strval($last_id).".jpg";
  			if ($ok){
  				$victim_id = get_score($myphoto);
  			}
  			else{
  				echo $err;
  				exit(1);
  			}
  			if ($victim_id>=0){
  				$query = "update fir_details set victim_id='$victim_id' where F_id='$last_id' ";
				$insres = $db->query($qstr);
  				$_SESSION["registerUsermsg"] .= "\nFound the victim with User id as ".$victim_id;
  			}
  		}

  		
  		header('Location: http://localhost:8080/home.php');
  		
	}
}
?>