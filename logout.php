<?php
	/*********************************
	Author: Corey Muniz
	Controller to log out
	*********************************/


	require_once( "models/User.php" );

	//Kill the session, the user wants to log out
	session_start();
	    session_start();
	    session_unset();
	    session_destroy();
	    session_write_close();
	    setcookie(session_name(),'',0,'/');
	    session_regenerate_id(true);
	//Then redirect them to the index
	header( "Location: /" );
	die();
?>
