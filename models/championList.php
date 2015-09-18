<?php
	//Incase Rito's servers break
	ini_set('max_execution_time', 15);
	class championList {
		
		//Riot API Key goes here - Kill Elmo2's Key
		public $key = "Riot API Key Goes here";
		//Current url for the api
		public $apiUrl = "https://global.api.pvp.net";
		//Urls for the static and dynamic calls
		public $staticUrl = "/api/lol/static-data/na/v1.2/champion?champData=allytips,blurb,enemytips,info,lore,skins,tags&api_key=";
		public $dynamicUrl = "/api/lol/na/v1.2/champion?api_key=";
		public $userUrl = "/api/lol/na/v1.4/summoner/by-name/";
		public $userUrl2 = "?api_key=";
		public $rankedUrl = "/api/lol/na/v2.5/league/by-summoner/";
		public $rankedUrl2 = "/entry?api_key=";
		public $busted = false;
		public $freeChampionList = array();		//Stores the free champions
		public $championList = array();			//Stores all the champions


		/*****************************
		This function takes a url that returns json and returns json
		NULL, or false depending on connection timeouts or failures.
		******************************/	
		function getJson($url){
			//echo urlencode($url)."</br>";
			$code = http_response_code();
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
				echo "erra bae";
			} elseif (connection_status() == CONNECTION_TIMEOUT) {
				echo "<h1>Error caught, stopped from crashing</h1>";
			} 
			else {
				  $this->busted = false;//  any normal completion actions
			}
			// Closing
			curl_close($ch);
			return (json_decode($result, true));
		}

		/*****************************
		This function grabs every champion in league of legends and all the relevant 
		static data about that champion. The data is all saved into an array with each 
		array being mapped by the champions id for easy look-up. These 
		are all stored in the array $championList[]

		List can be addressed as such:
			$championlist['id']['key'];
				keys:
					name: Returns the champion's full name
					tags: Returns the champions in game roles
					blurb: Returns a blurb for the champions lore
					lore: Returns the champions full lore
					enemytips: Returns the tips to counter that champion
					title: Returns the title for the champion
					allytips: Returns tips for playing the champion
					skins: Returns detailed info on the skins available for that champion
					info: Returns stats for the champion in terms of difficulty ad and ap
		******************************/
		function generateChampionList() {
			//Retrieve the static champion list from Riot
			$staticList = $this->getJson($this->apiUrl.$this->staticUrl.$this->key);

			if ($staticList != NULL && $staticList != false) {
				//For each champion in the list
				foreach($staticList['data'] as $champion) {
					//Save the champion info mapped by it's id
					$this->championList[$champion['id']] = array("key" => $champion['key'],
					 "name" => $champion['name'], 
					 "tags" => $champion['tags'],
					 "blurb" => $champion['blurb'],
					 "lore" => $champion['lore'],
					 "enemytips" => $champion['enemytips'],
					 "title" => $champion['title'],
					 "allytips" => $champion['allytips'],
					 "skins" => $champion['skins'],
					 "info" => $champion['info']);
				}
			}
			else {
				$this->busted = true;
			}
		}

		/*****************************
		This function grabs every champion in league of legends and 
		their current status in the game. This gives us the champions that 
		are free at the current moment along with other status about the 
		champion such as if the champion is active or not. All the free week 
		champions are saved in the array $freeChampionList[]

			List can be addressed as such:
			$freeChampionlist[index]['key'];
				keys:
					id: Returns the champion's id
					active: Returns a boolean showing if the champion is enabled or disabled for play
		******************************/
		function generateFreeChampionList() {
			//Retrieve the dynamic champion list from Riot
			$dynamicList = $this->getJson($this->apiUrl.$this->dynamicUrl.$this->key);

			if ($dynamicList != NULL && $dynamicList != false) {

				//For each champion in the list
				foreach ($dynamicList['champions'] as $freeChampion) {
					//If the champion is free this week, save it in the array
					if ($freeChampion['freeToPlay']) {
						$this->freeChampionList[] = (array(
							"id" => $freeChampion['id'],
							"active" => $freeChampion['active'],
							));
					}
				}
			}
			else {
				$this->busted = true;
			}
		}

		//Looks to see if a summoner exists, returns the summoner or false
		function findSummoner($name) {
			$user = $this->getJson($this->apiUrl.$this->userUrl.$name.$this->userUrl2.$this->key);
			return $user;
		}

		//Check if the summoner is ranked, returns their rank or false
		function getRank($id) {
			$rank = $this->getJson($this->apiUrl.$this->rankedUrl.$id.$this->rankedUrl2.$this->key);
			$flag = false;
			//Player isn't ranked at all, return false
			if (!$rank) {
				return false;
			}
			//Otherwise it pulled some form of ranked data
			else {
				//For each ranked queue (we only want soloQ)
				foreach ($rank[$id] as $rankedQueue) {
					//If it finds soloQ, get their rank and save it
					if ($rankedQueue['queue'] == "RANKED_SOLO_5x5") {
						$flag = true;
						$rank = $rankedQueue['tier']." ".$rankedQueue['entries'][0]['division'];
					}
				}
			}
			//If they aren't ranked in soloQ, return nothing
			if ($flag) {
				return $rank;
			}
			//Otherwise return false
			else { 
				return false;
			}
		}

	}


	/*****************************
	Function to sort a given list using usort. Granted bubble sort is slow,
	it's fast to write. Writing a faster sorting algorithm could 
	decrease the load on the server a bit, however make sure it's done in
	a closed testing environment (you can just clone my repo).

	This code was taken from this source: 
	http://stackoverflow.com/questions/96759/how-do-i-sort-a-multidimensional-array-in-php
	******************************/
	function make_comparer() {
		// Normalize criteria up front so that the comparer finds everything tidy
		$criteria = func_get_args();
		foreach ($criteria as $index => $criterion) {
			$criteria[$index] = is_array($criterion)
				? array_pad($criterion, 3, null)
				: array($criterion, SORT_ASC, null);
		}

		return function($first, $second) use (&$criteria) {
			foreach ($criteria as $criterion) {
				// How will we compare this round?
				list($column, $sortOrder, $projection) = $criterion;
				$sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

				// If a projection was defined project the values now
				if ($projection) {
					$lhs = call_user_func($projection, $first[$column]);
					$rhs = call_user_func($projection, $second[$column]);
				}
				else {
					$lhs = $first[$column];
					$rhs = $second[$column];
				}

				// Do the actual comparison; do not return if equal
				if ($lhs < $rhs) {
					return -1 * $sortOrder;
				}
				else if ($lhs > $rhs) {
					return 1 * $sortOrder;
				}
			}

			return 0; // tiebreakers exhausted, so $first == $second
		};


	}
?>
