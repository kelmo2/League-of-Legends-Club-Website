<?php
	/*********************************
	Author: Corey Muniz
	Controller for logging in
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	include_once("models/championList.php");

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





	/*****************************
	We create the variables that the other forms expect. 
	We also start the session to check for existing 
	sessions or to make one. 
	******************************/
	session_start();
	$user = new User();
	$signup_user = new User();
	$login_user = new User();
	$bool = "false";

	/*****************************
	If the session for user is there, they are logged
	in already and shouldn't be on this page. We need
	to send them back to the index. 
	******************************/
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];

		//So die and redirect to the index
		if ($user->id)
		{
			header( "Location: /" );
			die();
		}
	}

	/*****************************
	If the username and password fields weren't 
	left blank, let the user attempt to sign in via 
	function call. If the function returns true, it was 
	the correct username and password
	******************************/
	if (isset($_POST['email']) && isset($_POST['pw'])){
		//If the username doesn't exist and their password matches the hashed password
		if ($login_user->findByEmail($dbh, $_POST['email']) != NULL && $login_user->login($_POST['pw']) )
		{
			$bool = "true";
		}
	}

	//If true, then they meet the requirements to log in
	if ($bool == "true")
	{
		$summonerName = $login_user->username;
		//Call the function to check riots database
		$result = $champObj->findSummoner(rawurlencode($summonerName));
		//If the result is true, we found them and we store it in our db and fetch their rank to save that as well. 
		if ($result) {
			$guy->username = ucfirst(strtolower($summonerName));	//All lowercase except first letter
			$summonerName = str_replace(' ', '', $summonerName);
			$summonerName = strtolower($summonerName);
			$summonerId = $result[$summonerName]['id'];
			$rank = $champObj->getRank($summonerId);;
			if ($rank) {
                                        if ($rank[0] == 'B')
                                                $sort = 7;
                                        if ($rank[0] == 'S')
                                                $sort = 6;
                                        if ($rank[0] == 'G')
                                                $sort = 5;
                                        if ($rank[0] == 'P')
                                                $sort = 4;
                                        if ($rank[0] == 'D')
                                                $sort = 3;
                                        if ($rank[0] == 'M')
                                                $sort = 2;
                                        if ($rank[0] == 'C')
                                                $sort = 1;
				$login_user->rank = $sort.$rank;
			}
			else {
				$login_user->rank = "8";
			}
		}

		$login_user->updateUser($dbh, $login_user);

		//If they are banned, get their current ip and append it to the htaccess
		if ($login_user->admin == 3) {
			//	
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}
			
			$current = "echo '#".$login_user->first_name." ".$login_user->last_name." ".$login_user->email."' >> .htaccess";
			$output = shell_exec($current);
			$current = "echo 'deny from ".$ip."#' >> .htaccess";
			$output = shell_exec($current);
			
		}

		$_SESSION['user'] = $login_user;
		header( "Location: /" );
		die();
	}
	//Otherwise an error message needs to be set
	else{
		$login_user->errors['email']="Email or Password";
	}

	include_once("views/header.php");
	include_once("views/sections/login.php");
	include_once("views/footer.php");
?>
