<?php
	/*********************************
	Author: Corey Muniz
	Controller for the user profile
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");

	$fields = array("champion", "first_name", "username", "rank", "lane");
	
	session_start();
	$user = new User();
	$guy = new User();
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}

	if ($_GET){ 
		if (isset($_GET['user'])) {
			$guy = $guy->findUser($dbh, $_GET['user']);
			if ($guy) {
					require_once("views/header.php");
					require_once("views/sections/user.php");
					require_once("views/footer.php");
			}
			else {
				die();
			}

		}
	}
	else {
		die();
	}
?>
