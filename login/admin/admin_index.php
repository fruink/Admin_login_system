<?php
	require_once('phpscripts/init.php');
	//confirm_logged_in();
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin pannel</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<h1>Welcome Admin</h1>
	<div id="loginBox">
		<!--states good morning, afternoon, evening to user when loggedIn, and welcomes them to their account with salutation and taking their username from db_login when user logs in-->
		<h2>Good <?php echo $_SESSION['salutation']; echo $_SESSION['user_name']; ?> welcome to your account!</h2><!--Displays user name and time of day message-->
		<br>
		<?php echo $_SESSION['last_login'];?><!--Displays last login time using session-->
		<br>
		<!--trying to display message when user fails login 3 times and gets lockout-->
		<?php //echo $_GET['user_attempts']; ?> <!--lockout based on user attempts to login on fail-->
		<br>
		<a href="phpscripts/caller.php?caller_id=logout" id="logOut">Log Out</a>
	</div>
</body>
</html>
