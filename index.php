<?php
	/*********************************
	Author: Corey Muniz
	Controller for the main page
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	require_once( "models/post.php");
	require_once( "models/chat.php");
	require_once( "models/comments.php");
	session_start();
	$guy = new User();
	$comment = new comments();
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}

	$post = new post();
	$posts = $post->getPosts($dbh);

	$chat = new chat();
	$chats = $chat->getChats($dbh);
	$chats = array_reverse($chats);

	include_once("models/championList.php");
	$champObj = new championList();
	$champObj->generateChampionList();
	$champObj->generateFreeChampionList();
	require_once("views/header.php");
	require_once("views/sections/championSlider.php");
	require_once("views/sections/front.php");
	require_once("views/sections/chat.php");
	require_once("views/sections/posts.php");
	require_once("views/footer.php");
?>
