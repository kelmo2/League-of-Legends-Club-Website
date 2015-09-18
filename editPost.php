<?php
	/*********************************
	Author: Corey Muniz
	Controller for the Editing posts
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	include_once("models/post.php");

	session_start();
	$user = new User();
	$temp = new User();
	
	//Make sure the user is logged in
	if (isset ($_SESSION['user']))
	{	
		$user = $_SESSION['user'];
	}

	//If they aren't logged in, send them to the login screen
	else {
		header( "Location: loginCheckCtrl" );
		die();
	}

	//If they are logged in but not an admin kill the page
	if ($user->admin != 2) {
			die();
	}


	//Create the flags and class object
	$post = new post();
	$error = true;
	$sent = false;

	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$postToEdit = $post->findPost($dbh, $id);

		//If that post doesn't exist, just kill the page
		if (!$postToEdit) {
			die();
		}
	}
	//If theres not even a get request just die
	else {
		die();
	}

	//Otherwise let them edit the post. 
	if ($_POST) {
		if (isset($_POST['title'])) {
			if (empty($_POST['title'])) {
				$error = false;
			}
		}
		else {
			$error = false;
		}

		if (isset($_POST['post'])) {
			if (empty($_POST['post'])) {
				$error = false;
			}
		}
		else {
			$error = false;
		}

		if (isset($_POST['img'])) {
			if (empty($_POST['img'])) {
				$error = false;
			}
		}
		else {
			$error = false;
		}
		
		

		if ($error) {
			$postToEdit->title = $_POST['title'];
			$textarea = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $_POST['post']);
			$postToEdit->post = $textarea;
			$postToEdit->img = $_POST['img'];
			$sent = true;
			$postToEdit->updatePost($dbh, $postToEdit);
		}
	}


	require_once("views/header.php");
	require_once("views/sections/editPost.php");
	require_once("views/footer.php");
?>
