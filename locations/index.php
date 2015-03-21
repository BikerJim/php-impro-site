<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Locations";
require_once(ROOT_PATH . 'inc/header.php');
?>

<p>
	The locations we use.
</p>

<?php include(ROOT_PATH . 'inc/snippet_location_list.php'); ?>

<?php
	include(ROOT_PATH . 'inc/footer.php');
 ?>
