<?php
	class post {
		public static $table_name = "posts";
		public $id;
		public $userid;
		public $date;
		public $title;
		public $img = "img/splash/trollTeemo.jpg"; //Default image 
		public $post;


		/*********************************
		*********************************/
		function updatePost($dbh, $post) {
			$string = "UPDATE ".post::$table_name." SET title = :title,
			img = :img,
			post = :post WHERE id = :id;";

			$stmt = $dbh->prepare($string);
			$stmt-> bindParam (":post", $post->post);
			$stmt-> bindParam (":title", $post->title);
			$stmt-> bindParam (":img", $post->img);
			$stmt-> bindParam (":id", $post->id);
			$stmt->execute();	
		}


		/*********************************
		*********************************/
		function findPost($dbh, $id) {
			$stmt = $dbh->prepare("select * from ".post::$table_name." where id = :id");
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
		function getPosts($dbh) {
			$stmt = $dbh->prepare("select * from ".post::$table_name." ORDER BY id DESC;");
			$stmt->execute();

			$result = array();
			while( $row = $stmt->fetch() ) 
			{
				$p = new post();
				$p->copyFromRow( $row );
				$result[] = $p;
			}
			return $result;
		}

		function copyFromRow($items) {
			$this->id = $items['id'];
			$this->userid = $items['userid'];
			$this->date = $items['date'];
			$this->title = $items['title'];
			$this->img = $items['img'];
			$this->post = $items['post'];
		}
		

		function savePost($dbh) {
			if( !$this->id ) {		
				$sql = "INSERT INTO ".post::$table_name. 
				" (userid, date, title, post, img) ".
				"VALUES(:userid, :date, :title, :post, :img)";

				$stmt = $dbh->prepare($sql);
				$stmt-> bindParam (":userid", $this->userid);
				$stmt-> bindParam (":date", $this->date);
				$stmt-> bindParam (":title", $this->title);
				$stmt-> bindParam (":img", $this->img);
				$stmt-> bindParam (":post", $this->post);
				$stmt->execute();				
				$this->id = $dbh->lastInsertId();
			}
		}

		function deletePost($dbh, $id) {
			$sql = "DELETE FROM ".post::$table_name." WHERE id = :id;";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
		}
	
	}

	
	
	
?>
