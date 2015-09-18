<?php
	/*********************************
	Author: Corey Muniz
	File for the proxy json fetches
	Might need to change this if it gets abused externally (in plain view of javascript)
	*********************************/
	include_once("models/twitchModel.php");
	include_once("models/User.php");
	header('Content-type: application/json');
	$twitch = new twitch();
	session_start();
	//Check if data is being requested
	if ($_GET) {
		//If top is in the query string, give them the top 5 strings
		if (isset($_GET['top'])) {
			$topJson = $twitch->getTopStreams();
			echo json_encode($topJson);
		}
		//If the club is requested, return the streams the club is following
		else if (isset($_GET['club'])) {
			require_once("config.php");
			$clubJson = $twitch->getUserStreams($config['twitchChannel']);
			echo json_encode($clubJson);
		}
		//If a channel is requested, give them said channel
		else if (isset($_GET['channel'])) {
			$channelJson = $twitch->getChannel($_GET['channel']);
			echo json_encode($channelJson);
		}
		//If the user is requested, give them the streams of the user logged in
		else if (isset($_GET['user'])) {
			//Make sure they are actually logged in
			if (isset ($_SESSION['user']))
			{
				$user = new User();
				$user = $_SESSION['user'];
				if ($user->twitch == "") {
					return false;
				}
				else {
					$userJson = $twitch->getUserStreams($user->twitch);
					echo json_encode($userJson);
				}
			}
			//Otherwise they can go away because there's nothing here for them
			else {
				return false;
			}
		}
	}
?>
