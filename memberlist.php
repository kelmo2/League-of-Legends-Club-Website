<?php
	/*********************************
	Author: Corey Muniz
	Controller for the Admin Panel
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");

	$fields = array("champion", "first_name", "username", "rank", "lane", "hours");
	
	session_start();
	$user = new User();
	$guy = new User();
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}



	$direction = "down";
	$sort = "DESC";
	$option = "admin"; //Default sorted option
	//If there's a query string
	if ($_GET) {
		if (isset($_GET['sort']) && isset($_GET['way'])) {

			if ($_GET['way'] == "up") {
				$sort = "";
				$direction = "down";
			}
			else {
				$sort = "DESC";
				$direction = "up";
			}

			foreach ($fields as $sortBy) {

				if ($_GET['sort'] == $sortBy) {
					$option = $_GET['sort'];
				}
			}
			
		}
	}

	$list = $guy->getUsers($dbh, $option, $sort);


	require_once("views/header.php");
	require_once("views/sections/memberlist.php");
	require_once("views/footer.php");
?>
