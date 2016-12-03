<?php

class Post {
	
	private $connection;
	
		function __construct($mysqli) {
			
			$this->connection = $mysqli;
			
		}
		
		
		function GetAllPosts($q, $sort, $order) {
		
			$allowedSort = ["id", "Post"];
			
			if(!in_array($sort, $allowedSort)) {
			
				$sort = "id";
			
		}
		
			$orderBy = "ASC";
		
			if($order == "DESC") {
			
				$orderBy = "DESC";
			
		}
		
		echo " Sorting by ".$sort." ".$orderBy." ";
		
		if($q != "") {
			
			echo "Searching: ".$q;
			
			$stmt = $this->connection->prepare("SELECT id, Post FROM Forum_Posts WHERE deleted IS NULL AND (Post LIKE ?) ORDER BY $sort $orderBy");
			$searchWord = "%".$q."%";
			$stmt->bind_param("s", $searchWord);
			
			
		} else {
			
			$stmt = $this->connection->prepare("SELECT id, Post FROM Forum_Posts WHERE deleted IS NULL ORDER BY $sort $orderBy");
			
		}

        $stmt->bind_result($id, $Post);
        $stmt->execute();

        $result = array();

        while($stmt->fetch()) {

            $object = new StdClass();
            $object->id = $id;
            $object->Post = $Post;

            array_push($result, $object);

        }

        return $result;

    }

    function SavePost($Post) {

        $stmt = $this->connection->prepare("INSERT INTO Forum_Posts (Post) VALUES (?)");
        echo $this->connection->error;

        $stmt->bind_param("s", $Post);
        if ($stmt->execute()) {

            echo "Saving successful";

        } else {

            echo "Error".$stmt->error;

        }

    }
	
	function DeletePost($id) {
		
		$stmt = $this->connection->prepare("UPDATE Forum_Posts SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);
		
		if($stmt->execute()) {
			
			echo "Success";
			
		}
		
		$stmt->close();
		
	}
	
	function UpdatePost($id, $Post) {
		
		$stmt = $this->connection->prepare("UPDATE Forum_Posts SET Post=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("si", $Post, $id);
		
		if($stmt->execute()) {
			
			echo "Success";
			
		}
		
		$stmt->close();
		
	}
	
	function GetSinglePostData ($edit_id) {
		
		//echo "The id of this post is ".$edit_id;
		
		$stmt = $this->connection->prepare("SELECT Post FROM Forum_Posts WHERE id=? AND deleted IS NULL");
		
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($Post);
		$stmt->execute();
		
		$P = new StdClass();
		
		if($stmt->fetch()) {
			
			$P->Post = $Post;
			
		} else {
			
			header("Location: data.php");
			exit();
			
		}
		
		$stmt->close();
		
		return $P;
		
	}



	
}

?>