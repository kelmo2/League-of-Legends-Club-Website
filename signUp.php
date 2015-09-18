<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
	/*********************************
	Author: Corey Muniz
	Controller for the sign up controller
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	include_once("models/championList.php");
	include_once("models/twitchModel.php");
	$twitch = new twitch();


	$champObj = new championList();
	$champObj->generateChampionList();

	session_start();

	// attempt to signup
	$user = new User();
	$login_user = new User();
	$signup_user = new User();

	//Already logged in
	if (isset ($_SESSION['user']))
	{
		$user = $_SESSION['user'];

		header( "Location: /" );
		die();

	}
	
	/*********************************
	If the user posted, they are trying to make an account. 
	We make sure the required fields weren't left blank. If
	the fields were left blank then we post an error telling them which field 
	they forgot to fill in. We also check other things like making sure
	passwords match, the email and summoner names aren't taken. We also have
	password strength requirement. 
	*********************************/
	if ($_POST) {
		$flag = false;
		//Required fields left blank
		foreach ($signup_user->required as $field) {
			if (empty($_POST[$field])) {
				$flag = true;
				$signup_user->errors[$field] = $signup_user->messages[$field];
			}
		}
		//If that email is in use, throw an error 
		if ($signup_user->findByEmail($dbh, $_POST['email'])) {
			$flag = true;
			$signup_user->errors['email'] = "Email already in use";
		}
		if (isset($_POST['password']) && isset($_POST['password2'])) {
			//If the passwords don't match give an error
			if ($_POST['password'] != $_POST['password2']) {
				$flag = true;
				$signup_user->errors['password'] = "Passwords don't match";
			}
			//Otherwise their password's match and we check the strength
			else {
				if( !preg_match("#[A-Z]+#", $_POST['password']) ) {
					$flag = true; 
					$signup_user->errors['password'] .= " Password must include at least one capital letter ";
				}
				if( !preg_match("#[a-z]+#", $_POST['password']) ) {
					$flag = true; 
					$signup_user->errors['password'] .= " Password must include at least one letter ";
				}
				if( strlen($_POST['password']) < 8 ) {
					$flag = true; 
					$signup_user->errors['password'] .= " Password too short ";
				}
			}
		}

		//Checks to see if the first name entered has any invalid characters
		if (isset($_POST['first_name'])) {
			if (preg_match('/[^a-zA-Z]+/', $_POST['first_name'], $matches)) {
				$signup_user->errors['first_name'] .= "Incorrect characters for first name";
			}
		}

		//Checks to see if thje last name entered has any invalid characters
		if (isset($_POST['last_name'])) {
			if (preg_match('/[^a-zA-Z]+/', $_POST['last_name'], $matches)) {
				$signup_user->errors['last_name'] .= "Incorrect characters for last name";
			}
		}

		//Check to see if their summoner name is real via ritos DB
		if (!empty($_POST['username']) && isset($_POST['username'])) {
			$summonerName = $_POST['username'];
			//Call the function to check riots database
			$result = $champObj->findSummoner(rawurlencode($summonerName));
			//If the result is true, we found them and we store it in our db and fetch their rank to save that as well. 
			if ($result) {
				$signup_user->username = ucfirst(strtolower($_POST['username']));	//All lowercase except first letter
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
					$signup_user->rank = $sort.$rank;
				}
			}
			//Otherwise they entered a name that doesn't exist and we throw an error
			else {
				$flag = true;
				$signup_user->errors['username'] = "Summoner not found";
			}
		}
		//Check to see if the twitch entry has something in it, otherwise we ignore it. No check to see if it's real just yet
		if (!empty($_POST['twitch'])) {

			if (!$twitch->getUser($_POST['twitch'])) {
				$flag = true;
				$signup_user->errors['twitch'] = "Twitch user doesn't exist";
			}
			else {
				$signup_user->twitch = strtolower($_POST['twitch']);
			}

		}
		//Check to see if they entered in the college they are attending, if it's empty that's fine because it's optional
		if (isset($_POST['major'])) {
			$signup_user->major = $_POST['major'];
		}


	}
	//If no errors, they have permission to sign up. 
	if (isset($flag)) {
		if (!$flag) {
			$signup_user->email = $_POST['email'];
			$signup_user->first_name = ucfirst(strtolower($_POST['first_name']));	//All lowercase except first letter
			$signup_user->last_name = ucfirst(strtolower($_POST['last_name']));		//All lowercase except first letter
			$signup_user->champion = $_POST['champion'];
			$signup_user->lane = $_POST['lane'];
			$signup_user->hash = md5( rand(0,1000) );
			$signup_user->saveWithPassword($dbh, $_POST['password']);
			$_SESSION['user'] = $signup_user;
			header( "Location: /" );
			die();
		}
	}


	/*****************************
	This sorts the list of champions for the drop down list. 
	Keep in mind that the index values are the champion ID's and 
	when you swap items in an array, you are just moving objects
	to a different index. This means that the champions will not link to their
	corresponding ID when you sort this way; however in this particular instance 
	it doesn't matter because we are using a for-each and only need the name and key. 
	*****************************/
	usort($champObj->championList, make_comparer('name'));

	include_once("views/header.php");
	include_once("views/sections/register.php");
	include_once("views/footer.php");
?>
