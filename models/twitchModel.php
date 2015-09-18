<?php
class twitch{
	public $apiUrl = "https://api.twitch.tv";
	public $streamUrl = "/kraken/streams";
	public $userUrl = "/kraken/users/";
	public $liveUrl = "/?channel=";
	public $followedUrl = "/follows/channels";
	public $findUrl = "/kraken/channels/";
	public $clubChannels = array();
	public $topStreams = array();	

	function getJson($url){
		//  Initiate curl
		$ch = curl_init();


		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);

	  	if (connection_aborted()) {
			$errorFlag = true;
		} elseif (connection_status() == CONNECTION_TIMEOUT) {
			echo "<h1>Twitch error caught, please contact webmaster if problem persists</h1>";
		} 
		// Closing
		curl_close($ch);

		return (json_decode($result, true));
	}
	//api.twitch.tv/kraken/streams
	//Gets the top 5 overall streams
	function getTopStreams() {
		$streams = $this->getJson($this->apiUrl.$this->streamUrl);

		//If the json was legit, save the top 5 streams
		if ($streams != NULL && $streams != false) {
			for ($i = 0; $i < 5; $i++) {
				$this->topStreams[] = $streams['streams'][$i];
			}
			return $this->topStreams;
		}
		else {
			die();
		}
	}
	//api.twitch.tv/kraken/users/kelmo2/follows/channels
	//Gets the status of the club streams
	function getUserStreams($user) {

		$streams = $this->getJson($this->apiUrl.$this->userUrl.$user.$this->followedUrl);

		if ($streams != NULL && $streams != false) {
			foreach ($streams['follows'] as $stream) {
				$this->clubChannels[] = $stream['channel']['name'];
			}
		}
		//api.twitch.tv/kraken/streams/?channel=
		$liveClubStreams = array();
		foreach ($this->clubChannels as $stream) {
			$streams = $this->getJson($this->apiUrl.$this->streamUrl.$this->liveUrl);
			if ($streams['streams']) {
				$liveClubStreams[] = $stream;
			}
			else {
				//pass
			}
		}
		return $liveClubStreams;
	}
	
	//api.twitch.tv/kraken/streams/$channel
	function getChannel($channel) {
		$stream = $this->getJson($this->apiUrl.$this->streamUrl."/".$channel);

		//If the json was legit, save it
		if ($stream != NULL && $stream != false) {
			return $stream;
		}
		else {
			//error
		}
	}

	//Function to see if the user exists for account registration / changing twitch username
	function getUser($user) {
		$exists = $this->getJson($this->apiUrl.$this->findUrl.$user);

		
		if ($exists['status'] == 404) {
			return false;
		}
		else {
			return true;
		}
	}


}




?>
