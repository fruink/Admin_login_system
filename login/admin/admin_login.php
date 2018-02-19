<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	require_once("phpscripts/init.php");
	$ip = $_SERVER["REMOTE_ADDR"];
	//echo $ip;

	if(isset($_POST['submit'])){
		//echo "thanks for click";
		$username= trim($_POST['username']);
		$password= trim($_POST['password']);
		if($username != "" && $password != ""){
			$result= logIn($username, $password, $ip);
			$message = $result;
		}else{
			$message = "Please fill in the required fields.";
		}
	}

?>
<!doctype html>
</html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<h1 class="login">Admin Login</h1>
		<h3 id="sign">Please sign into your admin account.</h3>
		<?php if(!empty($message)) {echo $message;} ?>
		<div id="row" class="form">
		<form class="login" action="admin_login.php" method="post">
				<label>username:</label>
				<input type = "text" name="username" placeholder="username">
				<label>password:</label>
				<input type = "password" name="password" placeholder="password">
				<input class="btn" type="submit" name="submit" value="submit">
		</form>
	</div>
</body>
</html>
