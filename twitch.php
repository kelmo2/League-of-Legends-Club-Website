<?php
	/*********************************
	Author: Corey Muniz
	Controller for the twitch player and chat
	*********************************/
	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	session_start();

	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}

	include_once("models/twitchModel.php");
	if ($_GET) {
		if (isset($_GET['channel'])) {
			$stream = $_GET['channel'];
		}
	}



	require_once("views/header.php");
	require_once("views/sections/twitch.php");
	require_once("views/footer.php");
?>
