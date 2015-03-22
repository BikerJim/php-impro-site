<?php 
require_once('inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Practice Home Page";
require_once(ROOT_PATH . 'inc/header.php');
?>

<h2>Next Show</h2>
<?php include(ROOT_PATH . 'inc/snippet_next_show.php'); ?>

<h2>Next Workshop</h2>
<?php include(ROOT_PATH . 'inc/snippet_next_workshop.php'); ?>


<?php include(ROOT_PATH . 'inc/footer.php'); ?>
