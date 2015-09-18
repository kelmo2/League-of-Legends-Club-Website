<?php
	/*********************************
	Author: Corey Muniz
	Controller for the Fantasy LCS Controller
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	session_start();

	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}
	require_once("views/header.php");
	require_once("views/sections/fantasy.php");
	require_once("views/footer.php");
?>
