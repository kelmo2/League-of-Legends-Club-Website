<?php
	/*********************************
	Author: Corey Muniz
	Controller for the events pages
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	session_start();

	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}

	//Load the header
	require_once("views/header.php");


	/**************
	Load the content and use the query string to load different views. You will 
	also need to change the header to link to this query string (eg events?id=idhere)
	**************/
	if ($_GET) {
		if (isset($_GET['id'])) {
			//Spring tournament example
			if ($_GET['id'] == 1) {
				require_once("views/sections/springTournament2015.php");
			}
			//Lan party example
			if ($_GET['id'] == 2) {
				require_once("views/sections/lan.php");
			}
			//Haven't made the page yet
			if ($_GET['id'] == 3) {
				//require_once("views/sections/social.php");
			}
		}
	}
	//They messed something up, just kill the page
	else {
		die();
	}


	
	//Load the footer
	require_once("views/footer.php");
?>
