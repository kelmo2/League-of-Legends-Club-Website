<?php
	/*********************************
	Author: Corey Muniz
	Controller for the Admin Panel
	*********************************/

	require_once("models/User.php");
	require_once("models/db.php");
	require_once( "models/PasswordHash.php");
	include_once("models/championList.php");
	include_once("models/twitchModel.php");
	$twitch = new twitch();
	$champObj = new championList();
	$champObj->generateChampionList();
	usort($champObj->championList, make_comparer('name'));
	session_start();
	$user = new User();
	if (isset ($_SESSION['user']))
	{	
		$user = $_SESSION['user'];
	}
	else {
		header( "Location: loginCheckCtrl" );
		die();
	}

	$guy = $user;

	if ($_POST) {

		$sent = false;
		$twitchErr = false;
		$summonerErr = false;
		$passwordErr = false;
		if (isset($guy->id)) {
			if (isset($_POST['password']) && isset($_POST['password2'])) {
				if (!empty($_POST['password'])  && !empty($_POST['password2'])) {
					if ($_POST['password'] == $_POST['password2']) {
						$guy->password_hash = $guy->newPassword($_POST['password']);
					}
					else {
						$passwordErr = true;
					}
				}
			}
			if (isset($_POST['champion'])) {
				if (!empty($_POST['champion'])) {
					$guy->champion = $_POST['champion'];
				}
			}
			if (isset($_POST['bio'])){
				if (!empty($_POST['bio'])) {
					$guy->bio = $_POST['bio'];
				}
			}
			if (isset($_POST['lane'])) {
				if (!empty($_POST['lane'])) {
					$guy->lane = $_POST['lane'];
				}
			}
			if (isset($_POST['username'])) {
				if (!empty($_POST['username'])) {

					//Check to see if their summoner name is real via ritos DB
					if (!empty($_POST['username']) && isset($_POST['username'])) {
						$summonerName = $_POST['username'];
						//Call the function to check riots database
						$result = $champObj->findSummoner(rawurlencode($summonerName));
						//If the result is true, we found them and we store it in our db and fetch their rank to save that as well. 
						if ($result) {
							$guy->username = ucfirst(strtolower($_POST['username']));	//All lowercase except first letter
							$summonerName = str_replace(' ', '', $summonerName);
							$summonerName = strtolower($summonerName);
							$summonerId = $result[$summonerName]['id'];
							$rank = $champObj->getRank($summonerId);;
							if ($rank) {
								$guy->rank = $rank;
							}
							else {
								$guy->rank = "";
							}
						}
						//Otherwise they entered a name that doesn't exist and we throw an error
						else {
							$summonerErr = true;
						}
					}
				}
			}


			if (isset($_POST['twitch'])) {
				if (!empty($_POST['twitch'])) {
					if (!$twitch->getUser($_POST['twitch'])) {
						$twitchErr = true;
					}
					else {
						$guy->twitch = strtolower($_POST['twitch']);
					}
				}
			}

			if (isset($_POST['major'])) {
				if (!empty($_POST['major'])) {
					$guy->major = $_POST['major'];
				}
			}

			//Update the user with any changed values
			$user->updateUser($dbh, $guy);
			$sent = true;
		}
	}

	require_once("views/header.php");
	require_once("views/sections/dashboard.php");
	require_once("views/footer.php");
?>
