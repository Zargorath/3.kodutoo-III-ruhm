<?php

	require("../functions.php");
	
	require("../class/Post.class.php");
	$Post = new Post($mysqli);
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
		
	
	if(isset($_POST["update"])) {
		
		$Post->UpdatePost($Helper->CleanInput($_POST["id"]), $Helper->CleanInput($_POST["Post"]));
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
		exit();
		
	}
	
	$c = $Post->GetSinglePostData($_GET["id"]);
	//var_dump($c);
	
	if(isset($_GET["delete"])) {
		$Post->DeletePost($_GET["id"]);
		header("Location: data.php");
		exit();
		
	}

?>
<?php require("../header.php");?>

<br><br>
<a href="data.php">Back</a>

<h2>Change post description</h2>
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="hidden" name="id" value="<?=$_GET["id"];?>">
		<label for="Post">Post</label><br>
		<textarea id="Post" name="Post" rows="5" cols="40"><?php echo $c->Post;?></textarea><br><br>
		
		<input type="submit" name="update" value="Change">
	</form>
	
<br>
<br>

<a href="?id=<?=$_GET["id"];?>&delete=true">Delete</a>

<?php require("../footer.php");?>