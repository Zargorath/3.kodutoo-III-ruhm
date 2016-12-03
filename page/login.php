<?php

    require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/User.class.php");
	$User = new User($mysqli);

    $signupEmail = "";
    $signupPassword = "";
    $signupTelephone = "";
    $signupGender = "";
    $signupUsername = "";
    $signupEmailError = "";
    $signupPasswordError = "";
    $signupTelephoneError = "";
    $signupGenderError = "";
    $signupUsernameError = "";
    $loginEmailError = "";
    $loginEmail = "";
    $loginPasswordError = "";
    $loginPassword = "";
	
	if(isset($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
		
	}


    if (isset ($_POST["signupEmail"])) {

        if(empty ($_POST ["signupEmail"])) {

            $signupEmailError = "Please enter a valid email";

        } else {

            $signupEmail = $_POST["signupEmail"];

        }

}


    if (isset ($_POST["signupPassword"])) {

        if(empty ($_POST["signupPassword"])) {

            $signupPasswordError = "This field is required";

        } else {

            if (strlen ($_POST["signupPassword"]) < 8) {

                $signupPasswordError = "Passwords must be at least 8 characters long";

            } else {

                $signupPassword = $Helper->CleanInput($_POST["signupPassword"]);

            }

        }

    }


    if (isset ($_POST["signupUsername"])) {

        if(empty ($_POST["signupUsername"])) {

            $signupUsernameError = "This field is required";

        } else {

            $signupUsername = $Helper->CleanInput($_POST["signupUsername"]);

        }

    }


    if (isset($_POST["signupTelephone"])) {

        if(empty($_POST["signupTelephone"])) {

            $signupTelephoneError = "This field is required";

        } else {

            $signupTelephone = $_POST["signupTelephone"];

        }

    }


    if(isset($_POST["signupGender"])) {

        if(empty($_POST["signupGender"])) {

            $signupGenderError = "Please select a gender";

        } else {

            $signupGender = $_POST["signupGender"];

        }

    }

    if (isset($_POST["loginEmail"])) {

        if(empty($_POST["loginEmail"])) {

            $loginEmailError = "Please enter your email";

        } else {

            $loginEmail = $_POST["loginEmail"];

        }

    }


    if (isset($_POST["loginPassword"])) {

        if (empty($_POST["loginPassword"])) {

            $loginPasswordError = "Please enter your password";

        }

    }

    if ( isset($_POST["signupEmail"]) &&
         isset($_POST["signupUsername"]) &&
         isset($_POST["signupTelephone"]) &&
         isset($_POST["signupPassword"]) &&
         isset($_POST["signupGender"]) &&
         empty($signupEmailError) &&
         empty($signupGenderError) &&
         empty($signupTelephoneError) &&
         empty($signupPasswordError) &&
         empty($signupUsernameError)
    ) {

        echo "Saving.....<br>";
        echo "Email".$signupEmail."<br>";
        echo "Password".$_POST["signupPassword"]."<br>";

        $password = hash("sha512", $_POST["signupPassword"]);

        echo "Hash ".$password."<br>";

        $User->signup($signupEmail, $password, $signupTelephone, $signupUsername, $signupGender);

    }

    $notice = "";

    if( isset($_POST["loginEmail"]) &&
        isset($_POST["loginPassword"]) &&
        !empty($_POST["loginEmail"]) &&
        !empty($_POST["loginPassword"])
    ) {

        $notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		if(isset($notice->success)) {
			
			header("Location: login.php");
			exit();
			
		} else {
			
			//$notice = $notice->error;
			//var_dump($notice->error);
			
		}

    }
?>
<?php require("../header.php");?>


<div class="container">
	<div class="row">
	
		<div class="col-md-8 col-sm-16">

        <h1>Log in</h1>
        <p style="color:red;"><?php echo $notice; ?></p>
        <form method="POST">
		
			<br>

            <label>Email</label><br>
			<div class="form-group">
				<input class="form-control" name="loginEmail" type="email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>
			</div>
			

            <label>Password</label><br>
			<div class="form-group">
				<input class="form-control" name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
			</div>
			
            <br>

            <input class="btn btn-success" type="submit" value="Log in">

        </form>
	</div>
	<div class="col-md-8 col-sm-16">

        <h1>Create An Account</h1>

        <form method="POST">

            <label>Username</label><br>
			<div class="form-group">
				<input class="form-control" name="signupUsername" type="text"> <?php echo $signupUsernameError; ?>
			</div>

            <label>Email</label><br>
			<div class="form-group">
				<input class="form-control" name="signupEmail" type="email"> <?php echo $signupEmailError; ?>
			</div>

            <label>Password</label><br>
			<div class="form-group">
				<input class="form-control" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			</div>

            <label>Telephone</label><br>
			<div class="form-group">
				<input class="form-control" name="signupTelephone" type="tel"> <?php echo $signupTelephoneError; ?>
			</div>
			
			
            <?php if ($signupGender == "male") { ?>
                <input type="radio" name="signupGender" value="male" checked > Male<br>
            <?php } else { ?>
                <input type="radio" name="signupGender" value="male"> Male<br>
            <?php } ?>

            <?php if ($signupGender == "female") { ?>
                <input type="radio" name="signupGender" value="female" checked > Female<br>
            <?php } else { ?>
                <input type="radio" name="signupGender" value="female"> Female<br>
            <?php } ?>

            <?php if ($signupGender == "other") { ?>
                <input type="radio" name="signupGender" value="other" checked > Other<br>
            <?php } else { ?>
                <input type="radio" name="signupGender" value="other"> Other<br>
            <?php } ?>

            <br>

            <input class="btn btn-success" type="submit" value="Create">

        </form>
    </body>
</html>