<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Registration Succeeded";
require_once(ROOT_PATH . 'inc/header.php');
?>

       <p>You can now go back to the <a href="<?php echo BASE_URL . 'login/'; ?>">login page</a> and log in</p>

<?php
	include(ROOT_PATH . 'inc/footer.php')
 ?>