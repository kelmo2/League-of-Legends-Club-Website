<?php
	/*********************************
	Author: Corey Muniz
	Controller for the list of live streams
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

	require_once("views/header.php");
	require_once("views/sections/liveStreams.php");
	require_once("js/twitch.js.php");
	require_once("views/footer.php");

?>
