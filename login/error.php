<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'Oops! An unknown error happened.';
}
?>
<?php 
require_once('../inc/config.php');
$pageTitle = "Registration Succeeded";
include(ROOT_PATH . 'inc/header.php'); 
?>

        <h1>There was a problem</h1>
        <p class="error"><?php echo $error; ?></p>  


<?php
	include(ROOT_PATH . 'inc/footer.php')
?>
