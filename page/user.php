<?php

	require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/VGame.class.php");
	$VGame = new VGame($mysqli);
	
	if(!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
		
	}
	
	if(isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
		
	}
	
	$msg = "";
	if(isset($_SESSION["message"])) {
		
		$msg = $_SESSION["message"];
		unset($_SESSION["message"]);
		
	}
	
	if(isset($_POST["vgame"]) && !empty($_POST["vgame"])) {
		
		$VGame->SaveVGame($Helper->CleanInput($_POST["vgame"]));
		
	}
	
	if(isset($_POST["userVGame"]) && !empty($_POST["userVGame"])) {
		
		echo $_POST["userVGame"]."<br>";
		
		$VGame->SaveUserVGame($Helper->CleanInput($_POST["userVGame"]));
		
	}
	
	$Vgames = $VGame->GetAllVGames();	

?>

<h1><a href="data.php"> Back</a> User Page</h1>
<?=$msg;?>

<p>

	Welcome <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1"> Log Out</a>
	
</p>

<?php

	$listHtml = "<ul>";
	
		foreach($Vgames as $v) {
			
			$listHtml .="<li>".$v->v_game_name."</li>";
			
		}
		
	$listHtml .= "</ul>";
	
	echo $listHtml;

?>

<form method="POST">

	<label>Game</label><br>
	<input name="vgame" type="text">
	
	<input type="submit" value="Save">
	
</form>

<h2>User Games</h2>
<form method="POST">

	<label>Game</label><br>
	<select name="userVGame" type="text">
	<?php
	
		$listHtml = "";
		
			foreach($Vgames as $v) {
				
				$listHtml .= "<option value='".$v->id."'>".$v->v_game_name."</option>";;
				
			}
			
			echo $listHtml;
	
	?>
	</select>
	
		<input type="Submit" value="Add">
		
</form>
