<!DOCTYPE html>
<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css" type="text/css">
	<script type="text/JavaScript" src="<?php echo BASE_URL; ?>js/sha512.js"></script> 
    <script type="text/JavaScript" src="<?php echo BASE_URL; ?>js/forms.js"></script>
    
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/datepicker/jquery-ui.css">
	<script type="text/JavaScript" src="<?php echo BASE_URL; ?>js/external/jquery/jquery.js"></script>
	<script type="text/JavaScript" src="<?php echo BASE_URL; ?>js/jquery-ui.js"></script>
	<script type="text/JavaScript" src="<?php echo BASE_URL; ?>js/ticketform.js"></script> <!-- JS to popup reservation form -->

<script>
$(function() {
$( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
});
</script>
</head>
<body>
<header>
	<div id="nav">
		<a href="<?php echo BASE_URL; ?>">Home</a>
		<a href="<?php echo BASE_URL; ?>actors/">Actors</a>
		<a href="<?php echo BASE_URL; ?>workshops/">Workshops</a>
		<a href="<?php echo BASE_URL; ?>shows/">Shows</a>
		<a href="<?php echo BASE_URL; ?>courses/">Courses</a>
<?php sec_session_start(); 	if (login_check($db) == true) { ?>
		<a href="<?php echo BASE_URL; ?>formats/">Formats</a>
		<a href="<?php echo BASE_URL; ?>locations/">Locations</a>
		<a href="<?php echo BASE_URL; ?>inc/logout.php">[Logout]</a>
<?php	
	if ($_SESSION['iseditor'] == '1') {
		echo '[Editor]'; 
	 } else {
		echo '[Guest]';
	 }
?>
<?php } else { ?>
		<a href="<?php echo BASE_URL; ?>login/">Login</a>
<?php } ?>

	</div>
</header>
	<h2><?php echo $pageTitle; ?></h2>
