<?php
	/*********************************
	Author: Corey Muniz
	Controller for logging in
	*********************************/
	require_once("models/User.php");
	require_once("models/db.php");
	include_once("models/championList.php");
	/*****************************
	We create the variables that the other forms expect. 
	We also start the session to check for existing 
	sessions or to make one. 
	******************************/
	session_start();	
	$user = new User();
	$login_user = new User();
	$signup_user = new User();


	/*****************************
	If the session for user is there, they are logged
	in already and shouldn't be on this page. We need
	to send them back to the index. 
	******************************/
	if (isset ($_SESSION['user'])) {
		$user = $_SESSION['user'];

		//So kill the page and send them back to the index
		if ($user->id) {
			header( "Location: /" );
			die();
		}
	}

	/*****************************
	If they aren't logged in, we select a random champion
	from the array we stored from the api. We check our 
	local server for the file. If we have it, great! Otherwise
	we need to download it for backup purposes. 
	******************************/
	$champObj = new championList();
	$champObj->generateChampionList();

	//Get a random champion for the picture
	$randomIndex = array_rand($champObj->championList);
	$val = $champObj->championList[$randomIndex];

	//Get a random skin
	$randomIndex2 = array_rand($champObj->championList[$randomIndex]['skins']);
	//The path needed for the free week champion's image (locally)
	$path = "img/load/".$val['key']."_".$randomIndex2.".jpg";
	//The path needed for the free week champion's image (remotely)
	$url = "http://ddragon.leagueoflegends.com/cdn/img/champion/loading/".$val['key']."_".$randomIndex2.".jpg";
	//If the file isn't on our server, download it
	if (!file_exists($path)) {
		file_put_contents($path, file_get_contents($url));
	}



	//Include the views after we do all the work
	include_once("views/header.php");
	include_once("views/sections/login.php");
	include_once("views/footer.php");
?>
