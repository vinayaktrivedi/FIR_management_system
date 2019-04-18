<?php

	$return = <<<HTML
	<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
	.register_form { 
		margin: 0 auto; 
		width:280px;
	}
	.message {
		color:green;
	}
	.error {
		color:red;
	}

</style>
</head>


<body>
	<!-- error and message-->
	<div class="message"><center>{$msg}</center></div><br />
	<div class="error"><center>{$error}</center></div><br />
	
	<!-- register FIr-->
	<form action="registerFir.php" method="post">
	<input type="hidden" name="stage" value="register_form" >	
	<input type="submit" name="allreg" style="float:right;" value="Register FIR" >
	</form>

	<!-- revoke Fir-->
	<form action="revokeFir.php" method="post">
	<input type="hidden" name="stage" value="revoke_form" >	
	<input type="submit" name="allreg" style="float:right;" value="Revoke FIR" >
	</form>

	<!-- Stats-->

</body>
</html>
HTML;
	echo $return;
?>