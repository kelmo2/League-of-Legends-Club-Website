<?php
	class User {
		public static $table_name = "usertable";
		public $id;
		public $username = "";
		public $password_hash;
		public $first_name;
		public $last_name;
		public $admin = 0;
		public $email;
		public $lane;
		public $rank = "8";
		public $major = "";
		public $hours = 0;
		public $hash;
		public $paid = 0;
		public $champion;
		public $active = 0; //Not implemented yet
		public $twitch = "";
		public $bio = "";
		public $fun_fact = "";

		public $errors = array("email"=>"", "first_name"=>"", "last_name"=>"",
			"password"=>"", "champion"=>"", "lane" =>"", "username"=>"", "twitch"=>"");
		
		public $required = array("email", "first_name", "last_name", "password", "password2", "champion", "lane");
		public $optional = array("username", "twitch", "college");
		public $messages = array("email"=>"Email field blank", "first_name"=>"Error with First Name Field", "last_name"=>"Error with Last Name Field",
			"password"=>"Password field blank", "password2"=>"Password field blank","twitch" =>"Doesn't exist", "champion"=>"Please select a champion", "lane" =>"Please select a lane", "username"=>"Username already taken/Doesn't exist");
		
		

		/*********************************
		*********************************/
		function updateUser($dbh, $user) {
			$string = "UPDATE ".User::$table_name." SET email = :email,
			username = :username,
			first_name = :first_name,
			admin = :admin,
			last_name = :last_name,
			password_hash = :phash,
			lane = :lane,
			rank = :rank,
			major = :major,
			hours = :hours,
			hash = :hash,
			champion = :champion,
			bio = :bio,
			fun_fact = :fun_fact,
			twitch = :twitch WHERE id = :id;";


			$stmt = $dbh->prepare($string);
			$stmt-> bindParam (":email", $user->email);
			$stmt-> bindParam (":admin", $user->admin);
			$stmt-> bindParam (":first_name", $user->first_name);
			$stmt-> bindParam (":last_name", $user->last_name);
			$stmt-> bindParam (":username", $user->username);
			$stmt-> bindParam (":phash", $user->password_hash);
			$stmt-> bindParam (":lane", $user->lane);
			$stmt-> bindParam (":rank", $user->rank);
			$stmt-> bindParam (":major", $user->major);
			$stmt-> bindParam (":hours", $user->hours);
			$stmt-> bindParam (":hash", $user->hash);
			$stmt-> bindParam (":champion", $user->champion);
			$stmt-> bindParam (":twitch", $user->twitch);
			$stmt-> bindParam (":id", $user->id);
			$stmt-> bindParam(":bio", $user->bio);
			$stmt-> bindParam (":fun_fact", $user->fun_fact);
			$stmt->execute();	
		}

		/*********************************
		*********************************/
		function newPassword($password) {
			$hasher = new PasswordHash(8, false);
			$password_hash = $hasher->HashPassword( $password );

			return $password_hash;		
		}


		//Check if the local password hash matches the hash in the database
		function login($pwd) {
			$hasher = new PasswordHash(8, false);
			return $hasher->CheckPassword( $pwd, $this->password_hash);
		}
		
		//Look up the user in the database
		function findByUsername($dbh, $user) {
			$stmt = $dbh->prepare("select * from ".User::$table_name." where username = :user");
			$stmt->bindParam(":user", $user);
			$stmt->execute();
			if ($grabbed = $stmt->fetch()) {
				$this->copyFromRow($grabbed);
				return true;
			}
			else {
				return false;
			}
		}


		/*********************************
		Takes a users id and returns the users information in an array
		*********************************/
		function findUser($dbh, $id) {
			$stmt = $dbh->prepare("select * from ".User::$table_name." where id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			if ($grabbed = $stmt->fetch()) {
				$this->copyFromRow($grabbed);
				return $this;
			}
			else {
				return false;
			}
		}

		/*********************************
		Checks to see if there's an account with the email passed
		to this function. The function 
		*********************************/
		function findByEmail($dbh, $email) {
			$stmt = $dbh->prepare("select * from ".User::$table_name." where email = :email");
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			if ($grabbed = $stmt->fetch()) {
				$this->copyFromRow($grabbed);
				return true;
			}
			else {
				return false;
			}
		}


		/*********************************
		Grabs all the users that exist and returns them (probably to be printed out).
		*********************************/
		function getUsers($dbh, $field, $upDown) {
			$stmt = $dbh->prepare("select * from ".User::$table_name." order by ".$field." ".$upDown.";");
			$stmt->execute();

			$result = array();
			while( $row = $stmt->fetch() ) 
			{
				$p = new User();
				$p->copyFromRow( $row );
				$result[] = $p;
			}
			return $result;
		}
		
		//Copy the info into the class object
		function copyFromRow($items) {
			$this->id = $items['id'];
			$this->username = $items['username'];
			$this->password_hash = $items['password_hash'];
			$this->first_name = $items['first_name'];
			$this->last_name = $items['last_name'];
			$this->admin = $items['admin'];
			$this->email = $items['email'];
			$this->lane = $items['lane'];
			$this->rank = $items['rank'];
			$this->major = $items['major'];
			$this->hours = $items['hours'];
			$this->hash = $items['hash'];
			$this->twitch = $items['twitch'];
			$this->champion = $items['champion'];
			$this->paid = $items['paid'];
			$this->fun_fact = $items['fun_fact'];
			$this->bio = $items['bio'];
		}
		
		
		//Save the user into the database with the password hash
		function saveWithPassword($dbh, $passwd) {
			$hasher = new PasswordHash(8, false);
			$this->password_hash = $hasher->HashPassword( $passwd );

			if( !$this->id ) {		
				$sql = "INSERT INTO ". User::$table_name. 
				" (email, username, first_name, last_name, password_hash, lane, rank, major, hours, hash, champion, bio, fun_fact, twitch) ".
				"VALUES(:email, :username, :first_name, :last_name, :phash,".
				":lane, :rank, :major, :hours, :hash, :champion, :bio, :fun_fact, :twitch)";

				$stmt = $dbh->prepare($sql);
				$stmt-> bindParam (":email", $this->email);
				$stmt-> bindParam (":first_name", $this->first_name);
				$stmt-> bindParam (":last_name", $this->last_name);
				$stmt-> bindParam (":username", $this->username);
				$stmt-> bindParam (":phash", $this->password_hash);
				$stmt-> bindParam (":lane", $this->lane);
				$stmt-> bindParam (":rank", $this->rank);
				$stmt-> bindParam (":major", $this->major);
				$stmt-> bindParam (":hours", $this->hours);
				$stmt-> bindParam (":hash", $this->hash);
				$stmt-> bindParam (":champion", $this->champion);
				$stmt-> bindParam (":bio", $this->bio);
				$stmt-> bindParam (":fun_fact", $this->fun_fact);	
				$stmt-> bindParam (":twitch", $this->twitch);
		
				$stmt->execute();				
				$this->id = $dbh->lastInsertId();
			}
		}
	
	}

	
	
	
?>
