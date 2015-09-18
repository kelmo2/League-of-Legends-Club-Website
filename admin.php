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
	$temp = new User();

	//Check and see if they are logged in
	if (isset ($_SESSION['user']))
	{	
		$user = $_SESSION['user'];
	}
	//If they aren't even logged in, kick them out
	else {
		header( "Location: loginCheckCtrl" );
		die();
	}

	//If they are logged in but not an admin, kick them out
	if ($user->admin != 2) {
			die();
	}

	//Get all the users from the DB
	$list = $temp->getUsers($dbh, "first_name", "DESC");


	//If the user has posted to the page, they want to make a change 
	if ($_POST) {

		//Set some error flags for printing messages in html
		$sent = false;
		$twitchErr = false;
		$summonerErr = false;
		$passwordErr = false;

		//If the id is set, they selected a user, if they didn't select a user we can't make any changes
		if (isset($_POST['id'])) {
			//Grab that user from the database
			$guy = $temp->findUser($dbh, $_POST['id']);

			//If they set the email field, change his email
			if (isset($_POST['email'])) {
				if (!empty($_POST['email'])) {
					$guy->email = $_POST['email'];
				}
			}

			//If they set the first name field, change his first name
			if (isset($_POST['first_name'])) {
				if (!empty($_POST['first_name'])) {
					$guy->first_name = $_POST['first_name'];
				}
			}

			//If they set the bio field, change his bio
			if (isset($_POST['bio'])) {
				if (!empty($_POST['bio'])) {
                    $guy->bio = $_POST['bio'];
                }
            }
			

            //If they set the last name field, change his last name
			if (isset($_POST['last_name'])) {
				if (!empty($_POST['last_name'])) {
					$guy->last_name = $_POST['last_name'];
				}
			}

			//If they set the password fields and they match, change his password
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

			//If they set the champion field, change his champion
			if (isset($_POST['champion'])) {
				if (!empty($_POST['champion'])) {
					$guy->champion = $_POST['champion'];
				}
			}

			//If they set the lane field, change his lane
			if (isset($_POST['lane'])) {
				if (!empty($_POST['lane'])) {
					$guy->lane = $_POST['lane'];
				}
			}

			//If they set the summoner name field, change his summoner name
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
								//Needs to be updated with grease monkey code from registration page
								$guy->rank = $rank;
							}
							else {
								$guy->rank = "8";
							}
						}
						//Otherwise they entered a name that doesn't exist and we throw an error
						else {
							$summonerErr = true;
						}
					}
				}
			}

			//If they set the twitch field and that twitch username exists, change his twitch name
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


			//If they set the major field, change his major
			if (isset($_POST['major'])) {
				if (!empty($_POST['major'])) {
					$guy->major = $_POST['major'];
				}
			}


			//If they set the admin field, change their status
			if (isset($_POST['admin'])) {
				if (!empty($_POST['admin'])) {
					$guy->admin = $_POST['admin'];
				}
			}

			//If they set the hours field, change the hours
			if (isset($_POST['hours'])) {
				if (!empty($_POST['hours'])) {
					$guy->hours = $_POST['hours'];
				}
			}

			//Update the user with any changed values
			$guy->updateUser($dbh, $guy);
			$sent = true;
		}
	}

	//Then render the views
	require_once("views/header.php");
	require_once("views/sections/admin.php");
	require_once("views/footer.php");
?>
