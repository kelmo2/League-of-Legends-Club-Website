<?php
	/*********************************
	Author: Corey Muniz
	Controller for deleting posts
	*********************************/
	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	require_once( "models/post.php");
	session_start();

	//Make sure the user is logged in
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}
	//If they arent logged in they aren't allowed here
	else {
		die();
	}
	//If they aren't an admin they aren't allowed here either
	if ($user->admin != 2) {
			die();
	}

	//If they are authorized to be here, make a class object to handle the post
	$post = new post();

	//If the id is set in the query string, do the following
	if (isset($_GET['id'])) {
		//First find the post in the database
		$page = $post->findPost($dbh, $_GET['id']);

		//If it doesn't exist, kill the page
		if (!$page) {
			die();
		}

		//Otherwise go ahead and delete the post
		else {
			//And then send them back to the main page
			$post->deletePost($dbh, $page->id);
			header( "Location: /" );
			die();
		}
	}
	//If there was no query string, they shouldn't be here so kill the page
	else {
		die();
	}
?>
