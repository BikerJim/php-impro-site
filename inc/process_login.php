<?php
include_once('config.php');
include_once('database.php');
include_once('functions.php');

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
    if (isset($_POST['referrer'])) {
		$referrer = $_POST['referrer'];		
	} else {
		$referrer = BASE_URL;
	}

	
    if (login($email, $password, $db) == true) {
        // Login success  
        header('Location: ' . $referrer);
        exit;
    } else {
        // Login failed 
        header('Location: ../login/index.php?error=1');
        exit;
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
