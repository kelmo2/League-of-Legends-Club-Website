<?php
    /*********************************
    Author: Corey Muniz
    Controller for the contact form
    *********************************/
    require_once("config.php");
    require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';
    require_once("models/User.php");
    require_once("models/db.php");
    require_once( "models/PasswordHash.php");

    //Change this to select the email getting the mail
    $to = $config['emailTo'];

    /*****************************
    If the session for user is there, they are logged
    ******************************/
    session_start();
    if (isset ($_SESSION['user']))
    {
      $user = $_SESSION['user'];
    }


    /*****************************
    We set an array for the errors and the required field to reference
    what we need the user to enter in order to email us. If they miss one 
    of these fields, we set the flag to true and don't send the email.
    If they entered stuff into all the fields and passed the anti spam 
    question, we email their message to the club's email.
    ******************************/
    $errors = array("email"=>"", "name"=>"", "message"=>"","antispam"=>"");
    $required = array("name", "email", "message", "antispam");
    $flag = false;

    /*****************************
    If the user posts, they are trying to send an email to the club. 
    First we need to check each of the fields so we loop over
    the fields and check to see if they were set. If they were 
    left blank we set the error field for that message to let
    them know what went wrong. If nothing went wrong, we 
    assume good will and let them email us. If this 
    gets abused, I will implement some form of defense. 
    ******************************/
    if ($_POST) {
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $flag = true;
                $errors[$field] = "Please enter your ".$field;
            }
        }
        if (isset($_POST['antispam'])) {
            if ($_POST['antispam'] != 7)
                $flag = true;
        }
        //If no errors happened, we send the email.
        if (!$flag) {
            $from = "From: ".$_POST['name'];	//The name field entered
            $subject = $_POST['message'];		//The message to be send from the user
            $email = $_POST['email'];		//The email address to reply to

    	//We concatenate a string to send as the message to the club's email.
            $body = "From: ".$_POST['name']."\nEmail: ".$_POST['email']."\nMessage: \n".$_POST['message'];

            // Create the Mailer using your created Transport
            $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername($config['emailFromU'])
            ->setPassword($config['emailFromP']);

            $mailer = Swift_Mailer::newInstance($transporter);
            $message = Swift_Message::newInstance('Sent From Website')
              ->setFrom(array($config['emailFromU'] => 'Sent From Website'))
              ->setTo(array($to => $from))
              ->setBody($body);

    	//And then we send it
    	$result = $mailer->send($message);
        }
    } 
    require_once("views/header.php");
    require_once("views/sections/contact.php");
    require_once("views/footer.php");


?>
