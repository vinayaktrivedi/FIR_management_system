<?php
session_start();


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

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
  
function get_image_victim($myphoto,$id,$db){
	$obj = new compareImages();
	$dir = new DirectoryIterator('unidentified/victims/');
	foreach ($dir as $fileinfo) {
		if (!$fileinfo->isDot()) {
			$filename = $fileinfo->getFilename();
			$result = $obj->compare($myphoto,'unidentified/victims/'.$filename);
			if ($result >= 0 && $result<5){
				$arr = explode('.', $filename);
				$fid = (int)$arr[0];
				$flag = 1;
				$query = "update fir_details set victim_id='$id' where F_id='$fid' ";
				$insres = $db->query($query);
				unlink('unidentified/victims/'.$filename);
			}
		}
	}
	return $flag;
}

function get_image_criminal($myphoto,$id,$db){
	$obj = new compareImages();
	$dir = new DirectoryIterator('unidentified/criminals/');
	$flag = 0;
	foreach ($dir as $fileinfo) {
		if (!$fileinfo->isDot()) {
			$filename = $fileinfo->getFilename();
			$result = $obj->compare($myphoto,'unidentified/criminals/'.$filename);
			if ($result >= 0 && $result<5){
				$arr = explode('.', $filename);
				$fid = (int)$arr[0];
				$flag = 1;
				$query = "update fir_details set criminal_id='$id' where F_id='$fid' ";
				$insres = $db->query($query);
				unlink('unidentified/criminals/'.$filename);
			}
		}
	}
	return $flag;
}
  


function upload_photo($string,$userid){
	$target_dir = "users/";
	$target_file = $target_dir . basename($_FILES[$string]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES[$string]["tmp_name"]);
	echo "adsf ".$string."  ".$userid;
	if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // if (file_exists($target_file)) {
	//     echo "Sorry, file already exists.";
	//     $uploadOk = 0;
	// }
	
	if ($_FILES[$string]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
		$uploadOk = 0;
		return False;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
		return False;
	}
	
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		return False;
	
	} else {
	    if (move_uploaded_file($_FILES[$string]["tmp_name"], $target_dir.$userid.".".$imageFileType)) {
			echo "The file has been uploaded.";
			return True;
	    } else {
			echo "Sorry, there was an error uploading your file.";
			return False;
	    }
	}
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

			<form class="contact1-form validate-form" action="registerUser.php" method="post" enctype="multipart/form-data">

			<input type="hidden" name="stage" value="register_user_submit" >
				<span class="contact1-form-title">
					Register FIR
				</span>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="name" placeholder="Name">
					<span class="shadow-input1"></span>
				</div>
				<div class="wrap-input1 validate-input">
				Provide photo
				</div>
				<div class="wrap-input1 validate-input">
				<input type="file" name="user_photo" id="user_photo">
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
		$ok = upload_photo('user_photo',$row[0]);

		$myphoto = 'users/'.strval($row[0]).".jpg";
		if ($ok){				
			$yes_criminal = get_image_criminal($myphoto,$row[0],$db);
			$yes_victim = get_image_victim($myphoto,$row[0],$db);
			if ($yes_criminal){
				$_SESSION["registerUsermsg"] .= "User just added was a criminal!!\n";
			}
			if ($yes_victim){
				$_SESSION["registerUsermsg"] .= "User just added was a victim!!\n";	
			}

		}
		header('Location: http://localhost:8080/home.php');
		exit(1);
		  
	}
}
?>