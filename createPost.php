<?php
	/*********************************
	Author: Corey Muniz
	Controller for the Admin Panel
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	require_once( "models/post.php");

	$post = new post();
	$newPost = new post();

	session_start();
	$user = new User();
	$temp = new User();
	if (isset ($_SESSION['user']))
	{	
		$user = $_SESSION['user'];
	}
	else {
		header( "Location: loginCheckCtrl" );
		die();
	}

	if ($user->admin != 2) {
			die();
	}

	$error = true;
	//Get all the users from the DB
	$posts = $post->getPosts($dbh);
	$sent = false;
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
			$my_date = date("m-d-Y h:i A");
			$newPost->userid = $user->id;
			$newPost->title = $_POST['title'];
			$textarea = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $_POST['post']);
			$newPost->post = $textarea;
			$newPost->date = $my_date;
			$newPost->img = $_POST['img'];
			$sent = true;
			$newPost->savePost($dbh);
		}
	}


	require_once("views/header.php");
	require_once("views/sections/createPost.php");
	require_once("views/footer.php");
?>
