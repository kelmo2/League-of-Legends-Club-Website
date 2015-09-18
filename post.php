<?php
	/*********************************
	Author: Corey Muniz
	Controller for the post page
	*********************************/
	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	require_once( "models/post.php");
	require_once( "models/comments.php");
	session_start();
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}
	$post = new post();


	if (isset($_GET['id'])) {
		$page = $post->findPost($dbh, $_GET['id']);

		
		if (!$page) {
			die();
		}


		else {
				//If a comment was submitted and they are logged in
				if ($_POST && isset($user)) {
					//If the comment box isn't empty and they submitted let them make a comment
					if (isset($_POST['newPost']) && !empty($_POST['newPost'])) {
						$newComment = new comments();
						$newComment->userid = $user->id;
						$newComment->postid = $_GET['id'];
						$newComment->date = date("m-d-Y h:i A");
						$newComment->post = $_POST['newPost'];
						$newComment->saveComment($dbh);
						$sent = true;
					}
					else {
						$error = true;
					}
				}


			$body = $page->post;
			$guy = new User();
			$officer = $guy->findUser($dbh, $page->userid);
			$postTitle = $page->title;
			$postDescription = substr($page->post, 0, 90)."...";
			$postLink = "http://45.55.62.156/post?id=".$page->id;
			$postImg = $page->img;



			$comment = new comments();
			$comments = $comment->getPostComments($dbh, $page->id);

			$officer = $guy->findUser($dbh, $page->userid);
			/*****************************
			Need to cache the images for improved performance, can't completely
			rely on Riot's server for everything
			*****************************/

			//The path needed for the champion's image (locally)
			$path = "img/icons/".$officer->champion.".png";
				
			//The path needed for the free week champion's image (remotely)
			$url = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$officer->champion.".png";
			//If the file isn't on our server, download it
			if (!file_exists($path)) {
				file_put_contents($path, file_get_contents($url));
			}
		}
	}
	else {
		die();
	}



	require_once("views/header.php");
	require_once("views/sections/post.php");
	require_once("views/footer.php");
?>
