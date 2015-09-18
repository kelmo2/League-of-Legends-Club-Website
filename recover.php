<?php
        /*********************************
        Author: Corey Muniz
        Controller for the password recovery
        *********************************/

        require_once("models/User.php");
        require_once("models/db.php");
        require_once( "models/PasswordHash.php");


        session_start();
        $guy = new User();

        if ($_GET){
                if (isset($_GET['hash']) && isset($_GET['id'])) {
                        $guy = $guy->findUser($dbh, $_GET['id']);
                       //It's them, let them recover their password
			if ($guy->id == isset($_GET['id']) && $guy->hash == isset($_GET['hash'])) {
                                        
					require_once("views/header.php");
                                        require_once("views/sections/recovery.php");
                                        require_once("views/footer.php");
                        }
                        else {
                                die();
                        }

                }
        }
        else {
                die();
        }
?>
