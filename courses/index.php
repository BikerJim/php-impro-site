<?php 
require_once('../inc/config.php'); // Sets up CONSTANTS 
require_once(ROOT_PATH . 'inc/database.php'); // Sets up the connection to the Database
require_once(ROOT_PATH . 'inc/functions.php'); // Preloads the functions (mostly to do with AAI)
$pageTitle = "Courses"; // Set the page title, also reflected in the header.php <h3> at top of page
require_once(ROOT_PATH . 'inc/header.php'); // Display the header
?>

<?php include(ROOT_PATH . 'inc/snippet_courses_list.php'); ?>


<?php
// Display the footer
	include(ROOT_PATH . 'inc/footer.php');
?>
