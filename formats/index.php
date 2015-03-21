<?php 
require_once('../inc/config.php'); // Sets up CONSTANTS 
require_once(ROOT_PATH . 'inc/database.php'); // Sets up the connection to the Database
require_once(ROOT_PATH . 'inc/functions.php'); // Preloads the functions (mostly to do with AAI)
$pageTitle = "Formats"; // Set the page title, also reflected in the header.php <h3> at top of page
require_once(ROOT_PATH . 'inc/header.php'); // Display the header
?>

<?php 
// error messages handler
$errors = array (
    1 => "Very, very wrong",
    2 => "It appears that the file you tried to upload is not an image",
    3 => "It appears the file you tried to upload is too large. It should be less than 500kb. Try reducing the size and/or the resolution a bit. The show icons are 300px wide and 400px tall.",
    4 => "It appears that the file you tried to upload wasn't a jpg, jpeg or png. Gifs are old school and shouldn't be used any more."
);

$error_id = isset($_GET['error']) ? (int)$_GET['error'] : 0;
if ($error_id != 0 && array_key_exists($error_id, $errors)) {
    echo "Oh dear, something went wrong. " . $errors[$error_id];
}
?>

<?php include(ROOT_PATH . 'inc/snippet_format_list.php') ; ?>

<?php
// Display the footer
	include(ROOT_PATH . 'inc/footer.php');
 ?>
