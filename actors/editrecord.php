<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Actors";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php
if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$first_name = htmlspecialchars($_POST["first_name"]);
	$last_name = htmlspecialchars($_POST["last_name"]);
	$description = htmlspecialchars($_POST["description"]);
	
	if ($_FILES['mugshot']['name'] != "") {
		include_once(ROOT_PATH . 'actors/upload.php');
		$mugshot = htmlspecialchars($target_file);
	} else {
		$mugshot = $_POST['oldmugshot'];
	}
	
	if (isset($_POST["display"])) {
		$display = 1;
	} else {
		$display = 0;
	}
	$id = $_POST["id"];
	
	// error checking
	if ($first_name == "" || $last_name == "" || $description == "") {
		$error_message = "No fields can be left blank.";
	}
	
	if (strlen($description) > 750) {
		$error_message = "Description is a bit too long, we only need 750 characters.";
	}

	if (!isset($error_message)) {
		try {
				$dataIn = $db->prepare( "	UPDATE actors  SET first_name = :first_name, last_name=:last_name, description=:description, mugshot=:mugshot, display=:display
											WHERE id=:id;" );

				$dataIn->bindValue(':first_name', $first_name);
				$dataIn->bindValue(':last_name', $last_name);
				$dataIn->bindValue(':description', $description);
				$dataIn->bindValue(':mugshot', $mugshot);
				$dataIn->bindValue(':display', $display);			
				$dataIn->bindValue(':id', $id);

				$dataIn->execute();

				header("Location: editrecord.php?status=updated");
				exit;
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
	} else {
		header('Location:' . BASE_URL . 'actors/editrecord.php?id=' . $id);
		exit;
	} 
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "updated") { 
	header('Location:' . BASE_URL . 'actors/');
	exit;
	} else { ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<?php 
	$id = $_GET["id"];
	try {
		$actor = $db->prepare('SELECT * FROM actors WHERE id = :id');
		$actor->bindValue(':id', $id);
		$actor->execute();
		$result=$actor->fetch(PDO::FETCH_ASSOC);		
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	
	if (isset($error_message)) {
		echo $error_message;
	}
	
	?>
	
	<table>
		<tr>
			<th><label for="first_name">First name</label></th>
			<td><input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($result["first_name"]); ?>"></td>
		</tr>
		<tr>
			<th><label for="last_name">Last name</label></th>
			<td><input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($result["last_name"]); ?>"></td>
		</tr>
		<tr>
			<th><label for="description">Description</label></th>
			<td><textarea name="description" id="description" rows="6" cols="80"><?php echo $result["description"]; ?></textarea></td>
		</tr>
		<tr>
			<th><label for="mugshot">Mugshot</label></th>
			<td><img src="<?php echo $result['mugshot']; ?>" alt="mugshot">
				<input type="file" name="mugshot" id="mugshot">
			</td>
		</tr>
		<tr>
			<th><label for="display">Show in Actors list?</label></th>
			<td><input type="checkbox" name="display" id="display" 
			<?php if ($result["display"] == 1) {
					echo "checked='checked'";
				} ?>>
			</td>
		</tr>

	</table>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="hidden" name="oldmugshot" value="<?php echo $result['mugshot']; ?>">
	<input type="submit" value="Update details" name="submit">
</form>
<h2>About the mugshots</h2>
	<p>
		For security reasons, it's not possible to pre-load the existing image into the 'Browse' button, so before you update the profile, right-click and save the image to your local machine and then re-upload it with the edits, otherwise the existing image will be 'unlinked' (the image will exist on the server, but the url will be blank in the database).
	</p>
	<p>
		When uploading a new mugshot, you should make sure that you resize the image before uploading it. The CSS will make sure its resized, but its best for everyone if there's no extra bandwidth as far as possible. The image displays at 150(w) x 200(h) pixels, but to make sure they look awesome on reticular screens, which have double the pixel ratio, you should upload a 300x400 image, and the magic of CSS will do the rest.
	</p>
	<p>
		Quality wise, 'save for web' in photoshop is good, or 72dpi is what you're looking for.
	</p>

<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
