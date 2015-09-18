<?php
	class chat {
		public static $table_name = "chat";
		public $id;
		public $userid;
		public $date;
		public $post;
		public $champion;
		public $name;
		public $status;


		/*********************************
		*********************************/
		function updateChat($dbh, $post) {
			$string = "UPDATE ".comments::$table_name." SET post = :post WHERE id = :id;";

			$stmt = $dbh->prepare($string);
			$stmt-> bindParam (":post", $post->post);
			$stmt-> bindParam (":id", $post->id);
			$stmt->execute();	
		}


		/*********************************
		*********************************/
		function findChat($dbh, $id) {
			$stmt = $dbh->prepare("select * from ".chat::$table_name." where id = :id");
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
		*********************************/
		function getNChats($dbh, $n) {
			$stmt = $dbh->prepare("select * from ".chat::$table_name." WHERE id > :id ORDER BY id desc;");
			$stmt->bindParam(":id", $n);
			$stmt->execute();
			$result = array();
			while( $row = $stmt->fetch() ) 
			{
				$p = new chat();
				$p->copyFromRow( $row );
				$result[] = $p;
			}
			return $result;
		}


		/*********************************
		*********************************/
		function getChats($dbh) {
			$stmt = $dbh->prepare("select * from ".chat::$table_name." ORDER BY id desc limit 100");
			$stmt->execute();

			$result = array();
			while( $row = $stmt->fetch() ) 
			{
				$p = new chat();
				$p->copyFromRow( $row );
				$result[] = $p;
			}
			return $result;
		}

		function copyFromRow($items) {
			$this->id = $items['id'];
			$this->userid = $items['userid'];
			$this->date = $items['date'];
			$this->post = $items['post'];
			$this->champion = $items['champion'];
			$this->name = $items['name'];
			$this->status = $items['status'];
		}
		

		function saveChat($dbh) {
			if( !$this->id ) {		
				$sql = "INSERT INTO ".chat::$table_name. 
				" (userid, date, post, champion, name, status) ".
				"VALUES(:userid, :date, :post, :champion, :name, :status)";

				$stmt = $dbh->prepare($sql);
				$stmt-> bindParam (":userid", $this->userid);
				$stmt-> bindParam (":date", $this->date);
				$stmt-> bindParam (":post", $this->post);
				$stmt-> bindParam (":champion", $this->champion);
				$stmt-> bindParam (":name", $this->name);
				$stmt-> bindParam (":status", $this->status);
				$stmt->execute();				
				$this->id = $dbh->lastInsertId();
			}
		}

		function deleteChat($dbh, $id) {
			$sql = "DELETE FROM ".comments::$table_name." WHERE id = :id;";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
		}
	
	}

	
	
	
?>
