<?php
include_once('config.php');
include_once('database.php');
 
$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt = $db->prepare($prep_stmt);
	
   // check existing email  
    if ($stmt) {
        $stmt->bindParam(1, $email);
        $stmt->execute();
 
        if ($stmt->rowCount() == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
            $stmt = null;
        }
        $stmt = null;
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
        $stmt = null;
    }

    // check existing username
    $prep_stmt = "SELECT id FROM users WHERE username = ? LIMIT 1";
    $stmt = $db->prepare($prep_stmt);
	    
    if ($stmt) {
        $stmt->bindParam(1, $username);
        $stmt->execute();
                if ($stmt->rowCount() == 1) {
                        // A user with this username already exists
                        $error_msg .= '<p class="error">A user with this username already exists</p>';
                        $stmt->close();
                }
                $stmt = null;
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt = null;
        }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 
    if (empty($error_msg)) {
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
        if ($insert_stmt = $db->prepare("INSERT INTO users (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
            $insert_stmt->bindParam(1, $username);
            $insert_stmt->bindParam(2, $email);
            $insert_stmt->bindParam(3, $password);
            $insert_stmt->bindParam(4, $random_salt);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../login/error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ../login/register_success.php');
    }
}
