<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Actors";
require_once(ROOT_PATH . 'inc/header.php');
?>

<?php
	include(ROOT_PATH . 'inc/snippet_actor_list.php');
	include(ROOT_PATH . 'inc/footer.php')
 ?>
