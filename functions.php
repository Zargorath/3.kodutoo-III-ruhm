<?php

    require("/home/krisliiv/config.php");

    session_start();

    $database = "if16_kliiva";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

?>