<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Formats";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php

/* This page is 'protected', meaning that it shouldn't be loaded for 
 * anyone who isn't a registered 'editor' in the Users database
 * isEditor is in functions.php
 */ 
if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
}
/*
 * If the form is being posted do the whole database thing, escaping 
 * entered data before it's written to the $db.
 * This one has the added excitement of a picture upload.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include_once(ROOT_PATH . 'formats/upload.php');	
	try {
		$title = htmlspecialchars($_POST["title"]);
		$short_desc = htmlspecialchars($_POST["short_desc"]);
		$icon = htmlspecialchars($target_file);
		
		$dataIn = $db->prepare( "INSERT INTO formats (title, short_desc, icon) VALUES (:title, :short_desc, :icon);" );

		$dataIn->bindValue(':title', $title);
		$dataIn->bindValue(':short_desc', $short_desc);
		$dataIn->bindValue(':icon', $icon);		
		$dataIn->execute();

		header("Location: addrecord.php?status=added");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} 

/*
 * Check if the page has been appended with the ?status=added string
 * and if it has, redirect it to the actors/ list
 */

if (isset($_GET["status"]) && $_GET["status"] == "added") { ;
	header('Location: ' . BASE_URL . 'formats/');
	} else { 
/*
 * Otherwise, just load the form as normal
 */
		?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<th><label for="title">Title</label></th>
			<td><input type="text" name="title" id="title"></td>
		</tr>
		<tr>
			<th><label for="short_desc">Description</label></th>
			<td><textarea name="short_desc" id="short_desc" rows="5" cols="40"></textarea></td>
		</tr>
		<tr>
			<th><label for="icon">Show Icon</label></th>
			<td><input type="file" name="icon" id="icon"></td>
		</tr>
	</table>

	<input type="submit" value="Add format" name="submit">
</form>
<h2>About the Show Icons</h2>
<p>
	When uploading a new show icon, you should make sure that you resize the image before uploading it. The CSS will make sure its resized, but its best for everyone if there's no extra bandwidth as far as possible. The image displays at 150(w) x 200(h) pixels, but to make sure they look awesome on reticular screens, which have double the pixel ratio, you should upload a 300x400 image, and the magic of CSS will do the rest.</p>
	<p>Quality wise, 'save for web' in photoshop is good, or 72dpi is what you're looking for.</p> 
<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
