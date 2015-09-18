<?php
	/*********************************
	Author: Corey Muniz
	Controller for deleting comments
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
	else {
		die();
	}
	
	//If a query string exists
	if ($_GET) {
		//If both of the required fields exist check for the comment to delete
		if (isset($_GET['commentid']) && isset($_GET['postid'])) {
			$comment = new comments();

			$deleteComment = $comment->findComment($dbh, $_GET['commentid']);
			//If the comment doesn't exist then die
			if (!$deleteComment) {
				die();
			}
			//Otherwise a comment was found
			else {
				//If the comment belongs to the user on this controller or an admin is on this controller delete it
				if ($deleteComment->userid == $user->id || $user->admin == 2) {
					$deleteComment->deleteComment($dbh, $_GET['commentid']);
					header( "Location: post?id=".$_GET['postid'] );
					die();
				}
			}
		}
		//Otherwise kill the page
		else {
			die();
		}
	}
	//Otherwise kill the page
	else {
		die();
	}


?>
