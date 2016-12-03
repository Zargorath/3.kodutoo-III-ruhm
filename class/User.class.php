<?php

class User {
	
	private $connection;
	function __construct($mysqli) {
		
		$this->connection = $mysqli;
		
	}
	
	function signup($signupEmail, $password, $signupTelephone, $signupUsername, $signupGender) {

        $stmt = $this->connection->prepare("INSERT INTO Forum_Users (Email, Password, Telephone, Username, Gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $signupEmail, $password, $signupTelephone, $signupUsername, $signupGender);
        if ($stmt->execute() ) {

            echo "Success";

        } else {

            echo "Error".$stmt->error;

        }

    }

    function login($email, $password) {

        $notice = "";

        $stmt = $this->connection->prepare("SELECT id, Email, Password, Created FROM Forum_Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id, $EmailFromDB, $PasswordFromDB, $Created);

        $stmt->execute();

        if ($stmt->fetch()) {

            $hash = hash("sha512", $password);
            if ($hash == $PasswordFromDB) {

                echo "User ".$id." logged in";

                $_SESSION["userId"] = $id;
                $_SESSION["userEmail"] = $EmailFromDB;

                header("Location: data.php");
                exit();

            } else {

                $notice = "Invalid password";

            }

        } else {

            $notice = "Invalid email";

        }

        return $notice;

    }
	
}


?>