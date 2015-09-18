<?php
	/*********************************
	Author: Corey Muniz
	Controller for the Admin Panel
	*********************************/
	header('Content-type: application/json');
	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	require_once( "models/chat.php");

	session_start();

	//Create some class objects to handle the data
	$user = new User();
	$temp = new User();
	$chat = new chat();

	//Check to see if they are logged in
	if (isset ($_SESSION['user']))
	{	
		$user = $_SESSION['user'];
	}


	if ($_GET) {
		//If they requested to enter a message and the message isn't blank, enter it into the db
		if (isset($_GET['msg']) && $_GET['msg'] != "") {

			//If they aren't logged on, don't let them make a new message
			if (!isset($user)) {
				die();
			}
			
			$msg = $_GET['msg'];					//Grab the message
			$chat->userid = $user->id;				//Get the user id
			$chat->post = htmlspecialchars($msg);	//Make sure the message is safe on our webpage
			$chat->date = date("m-d-y H:i");		//Save the date
			$chat->name = $user->first_name;		//Get the user's first name
			$chat->champion = $user->champion;		//Get their champion
			$chat->status = $user->admin;			//Check their user status
			$chat->saveChat($dbh);					//Save the message
		}

		//If the page is called to fetch new messages
		else if (isset($_GET['fetch']) && $_GET['fetch'] != "") {
			$n = $_GET['fetch']; 
			$chats = $chat->getNChats($dbh, $n);
			echo json_encode($chats);
		}
	}
	//The chatbox isn't requesting this page so kill it
	else {
		die();
	}
?>