<?php
	class comments {
		public static $table_name = "comments";
		public $id;
		public $userid;
		public $postid;
		public $date;
		public $post;


		/*********************************
		*********************************/
		function updateComment($dbh, $post) {
			$string = "UPDATE ".comments::$table_name." SET post = :post WHERE id = :id;";

			$stmt = $dbh->prepare($string);
			$stmt-> bindParam (":post", $post->post);
			$stmt-> bindParam (":id", $post->id);
			$stmt->execute();	
		}


		/*********************************
		*********************************/
		function findComment($dbh, $id) {
			$stmt = $dbh->prepare("select * from ".comments::$table_name." where id = :id");
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
		function getComments($dbh) {
			$stmt = $dbh->prepare("select * from ".comments::$table_name." ORDER BY id");
			$stmt->execute();

			$result = array();
			while( $row = $stmt->fetch() ) 
			{
				$p = new comments();
				$p->copyFromRow( $row );
				$result[] = $p;
			}
			return $result;
		}


		/*********************************
		*********************************/
		function getPostComments($dbh, $id) {
			$stmt = $dbh->prepare("select * from ".comments::$table_name." WHERE postid = :postid ORDER BY id;");
			$stmt-> bindParam (":postid", $id);
			$stmt->execute();	

			$result = array();
			while( $row = $stmt->fetch() ) 
			{
				$p = new comments();
				$p->copyFromRow( $row );
				$result[] = $p;
			}
			return $result;
		}

		function copyFromRow($items) {
			$this->id = $items['id'];
			$this->userid = $items['userid'];
			$this->postid = $items['postid'];
			$this->date = $items['date'];
			$this->post = $items['post'];
		}
		

		function saveComment($dbh) {
			if( !$this->id ) {		
				$sql = "INSERT INTO ".comments::$table_name. 
				" (userid, postid, date, post) ".
				"VALUES(:userid, :postid, :date, :post)";

				$stmt = $dbh->prepare($sql);
				$stmt-> bindParam (":userid", $this->userid);
				$stmt-> bindParam (":postid", $this->postid);
				$stmt-> bindParam (":date", $this->date);
				$stmt-> bindParam (":post", $this->post);
				$stmt->execute();				
				$this->id = $dbh->lastInsertId();
			}
		}

		function deleteComment($dbh, $id) {
			$sql = "DELETE FROM ".comments::$table_name." WHERE id = :id;";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
		}
	
	}

	
	
	
?>
