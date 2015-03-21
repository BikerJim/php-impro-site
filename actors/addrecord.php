<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Actors";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php

/* This page is 'protected', meaning that it shouldn't be loaded for 
 * anyone who isn't a registered 'editor' in the Users database
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
	/*
	 * First we collect the POST variables and put them into our own
	 * variables.
	 */
		include_once(ROOT_PATH . 'actors/upload.php'); // This script does the uploading stuff and returns a $target_file variable which is the relative path to the uploaded img
		$first_name = htmlspecialchars($_POST["first_name"]);
		$last_name = htmlspecialchars($_POST["last_name"]);
		$description = htmlspecialchars($_POST["description"]);
		$mugshot = htmlspecialchars($target_file);
	
	/*
	 * Add some error checking. The first and last name fields cant be blank, 
	 * the description can't be blank or more than 750 characters.  
	 * The mugshot field's errors are handled by the upload script.
	 */
	 
	if ($first_name == "" || $last_name == "" || $description == "") {
		$error_message = "You must fill in all fields.";
	}
	
	if (strlen($description) > 750) {
		$error_message = "Description is a bit too long, we only need 750 characters.";
	}
	
	if (!isset($error_message)) {
		try {
			$dataIn = $db->prepare( "INSERT INTO actors (first_name, last_name, description, mugshot) VALUES (:fname, :lname, :desc, :mugshot);" );

			$dataIn->bindValue(':fname', $first_name);
			$dataIn->bindValue(':lname', $last_name);
			$dataIn->bindValue(':desc', $description);
			$dataIn->bindValue(':mugshot', $mugshot);		
			$dataIn->execute();

			header("Location: addrecord.php?status=added");
			exit;
			
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
	} else {
		echo $error_message;
	}
} 

/*
 * Check if the page has been appended with the ?status=added string
 * and if it has, redirect it to the actors/ list
 */

if (isset($_GET["status"]) && $_GET["status"] == "added") { ;
	header('Location: ' . BASE_URL . 'actors/');
	} else { 
/*
 * Otherwise, just load the form as normal
 */

	?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<th><label for="first_name">First name</label></th>
			<td><input type="text" name="first_name" id="first_name" value="<?php if (isset($first_name)) { echo htmlspecialchars($first_name); } ?>"></td>
		</tr>
		<tr>
			<th><label for="last_name">Last name</label></th>
			<td><input type="text" name="last_name" id="last_name" value="<?php if (isset($last_name)) { echo htmlspecialchars($last_name); } ?>"></td>
		</tr>
		<tr>
			<th><label for="description">Description</label></th>
			<td><textarea name="description" id="description" rows="5" cols="40"><?php if (isset($description)) { echo htmlspecialchars($description); } ?></textarea></td>
		</tr>
		<tr>
			<th><label for="mugshot">Mugshot</label></th>
			<td><input type="file" name="mugshot" id="mugshot"></td>
		</tr>
	</table>

	<input type="submit" value="Add actor" name="submit">
</form>
<h2>About the mugshots</h2>
<p>
	When uploading a new mugshot, you should make sure that you resize the image before uploading it. The CSS will make sure its resized, but its best for everyone if there's no extra bandwidth as far as possible. The image displays at 150(w) x 200(h) pixels, but to make sure they look awesome on reticular screens, which have double the pixel ratio, you should upload a 300x400 image, and the magic of CSS will do the rest.</p>
	<p>Quality wise, 'save for web' in photoshop is good, or 72dpi is what you're looking for.</p> 
<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
