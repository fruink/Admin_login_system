<?php

	function logIn($username, $password, $ip){
		require_once('connect.php'); //connect to db
		$username = mysqli_real_escape_string($link, $username);
		$password = mysqli_real_escape_string($link, $password);//cleans string
		$loginString = "SELECT * FROM tbl_user WHERE user_name='{$username}' AND user_pass='{$password}'"; //selecting user's name and password from db
		//echo $loginString;
		$user_set = mysqli_query($link, $loginString);
		if(mysqli_num_rows($user_set)){
			$found_user = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
			$id = $found_user['user_id'];
			$dateTime = $found_user['user_lastlogin']; //last successful login using dateTime in db_movies
			$attempts = $found_user['user_attempts']; //user's attempts to login after failure
			//session variable = temparary variable
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name'] = $found_user['user_name'];
			$_SESSION['last_login'] = ""; //last login time of user
			date_default_timezone_set("EST"); //timezone
			if($attempts>3){ //lock out user after 3 failed attempts, user only gets 3 tries and after 3, user see's msg saying they are lockout of their account
				$message = "user has been locked out, please contact your system administrator for assistance.";
				return $message;
			}else{ //if user succesfully login's then user gets msg saying their login was successful
				if($found_user['user_lastlogin'] != "new_user"){
					$_SESSION['last_login'] = 'Your last successful login was '.$dateTime; //displays last successful login using dateTime from user_lastlogin
				}
				$time = date("H"); //depending on time of day, user will see welcome msg when logged in to their account
				if ($time<12){ //before 12 user will see welcome morning msg
					$welcome="morning, enjoy your day! ";
				}else if ($time>11 and $time<18){ //after they will see welcome afternoon msg
					$welcome="afternoon, enjoy your day! ";
				}else{
					$welcome="evening, enjoy your day! "; //later after 6pm, user will see welcome evening msg
				}
				$_SESSION['salutation'] = $welcome; //user will see 3 msg's after login using salutation function to determine the time of day the user logs into their account
				$dateTime = date("g:i a M d Y"); //date/time of day, using timestamp in db
				$updateTime= "UPDATE tbl_user SET user_lastlogin = '{$dateTime}' WHERE user_id={$id}"; //user's last login using dateTime from db and user's id to determine last successful login
				$updateQuery = mysqli_query($link, $updateTime); //updates time of last login

				if(mysqli_query($link, $loginString)){ //login of user
					$updateString = "UPDATE tbl_user SET user_ip = '{$ip}' WHERE user_id={$id}"; //updates user's login using their ip and id info from db
					$updateQuery = mysqli_query($link, $updateString);
				}
				$attempts = 0;
				$updateAttempts= "UPDATE tbl_user SET user_attempts = '{$attempts}' WHERE user_id={$id}"; //user's attempts to login using info from user_attempts and user_id from db
				$updateQuery = mysqli_query($link, $updateAttempts);
				redirect_to("admin_index.php"); //re-directs user to the admin homepage
			}
		}else{
			$usernameString = "SELECT * FROM tbl_user WHERE user_name='{$username}'";
			$user_set = mysqli_query($link, $usernameString);
			$found_user = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
			$id = $found_user['user_id'];
			$attempts = $found_user['user_attempts'];
			$attempts = $attempts+1;
			$updateAttempts= "UPDATE tbl_user SET user_attempts = '{$attempts}' WHERE user_id={$id}"; //fetches user's attempts and id info from db
			$updateQuery = mysqli_query($link, $updateAttempts);

			$message = "username/password are incorrect. <br> Please make sure your caps lock key is turned off.";
			return $message;
		}
		mysqli_close($link);
	}
?>
