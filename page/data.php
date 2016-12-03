<?php

    require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/Post.class.php");
	$Post = new Post($mysqli);

    if(!isset ($_SESSION["userId"])) {

        header("Location: login.php");
        exit();

    }

    if (isset($_GET["logout"])) {

        session_destroy();

        header("Location: login.php");
        exit();

    }

    if (isset($_POST["Post"]) && !empty($_POST["Post"])) {

       $Post->SavePost($Helper->CleanInput($_POST["Post"]));

    } else {
		
		$SavePostError = "Please enter a description for your post";
		
	}
	
	$q = "";
	
	if(isset($_GET["q"])) {
		
		$q = $Helper->CleanInput($_GET["q"]);
		
	}
	
	$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])) {
		
		$sort = $_GET["sort"];
		$order = $_GET["order"];
		
	}

    $Posts = $Post->GetAllPosts($q, $sort, $order);
?>
<?php require("../header.php");?>

<h1>Data</h1>
<p>
    Welcome <a href="user.php"> <?=$_SESSION["userEmail"];?>!
    <a href="?logout=1">Log Out</a>

</p>



<h2>Posts</h2>
<form method="post">
	
	<div class="form-group">
    <label>Post</label><br>
    <textarea class="form-conrol" name="Post" rows="5" cols="40"></textarea>
	</div>

    <br>

    <input type="submit" value="Submit">
	
	<br><br>

</form>

<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Search">
</form>


<h2 style="clear:both">Table of Posts</h2>
<?php

    $html = "<table class='table table-bordered'>";

        $html .="<tr>";
		
			$orderId = "ASC";
			
			if(isset($_GET["order"]) && $_GET["order"] == "ASC" && $_GET["sort"] == "id") {
				
				$orderId = "DESC";
				
			}
		
				$html .="<th>
				
						<a href='?q=".$q."&sort=id&order=".$orderId."'>
						id
			
						</th>";
						
			$orderPost = "ASC";
			
			if(isset($_GET["order"]) && $_GET["order"] == "ASC" && $_GET["sort"] == "Post") {
				
				$orderPost = "DESC";
				
			}
			
            $html .="<th>
			
					<a href='?q=".$q."&sort=Post&order=".$orderPost."'>
					Post
										
					</th>";
			
        $html .="</tr>";

    foreach($Posts as $Post) {

        $html .="<tr>";
            $html .="<td>".$Post->id."</td>";
            $html .="<td>".$Post->Post."</td>";
			$html .="<td><a href='edit.php?id=".$Post->id."'><span class='glyphicon-pencil'><span> Change</a></td>";
        $html .="</tr>";

    }

    $html .="</tabel>";

    echo $html;



?>



<?php

	require("../footer.php");

?>