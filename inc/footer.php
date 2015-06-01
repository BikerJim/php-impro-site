<div id="footer">
	<p>Jims all new database thing</p>
	<p>&copy; 2015</p>
	<?php sec_session_start(); 	if (login_check($db) == true) { ?>
		<a href="<?php echo BASE_URL; ?>inc/logout.php">[Logout]</a>
	<?php } else { ?>
		<a href="<?php echo BASE_URL; ?>login/">Login</a>
	<?php } ?>
</div>

</body>
</html>
