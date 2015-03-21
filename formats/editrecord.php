<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Edit a Format";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php
if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include_once(ROOT_PATH . 'formats/upload.php');
	try {
		$title = htmlspecialchars($_POST["title"]);
		$short_desc = htmlspecialchars($_POST["short_desc"]);
		$icon = htmlspecialchars($target_file);
		$id = $_POST["id"];
		
		$dataIn = $db->prepare( "	UPDATE formats  SET title = :title, short_desc=:short_desc, icon=:icon
									WHERE id=:id;" );

		$dataIn->bindValue(':title', $title);
		$dataIn->bindValue(':short_desc', $short_desc);
		$dataIn->bindValue(':icon', $icon);		
		$dataIn->bindValue(':id', $id);

		$dataIn->execute();

		header("Location: editrecord.php?status=updated");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "updated") { 
	header('Location:' . BASE_URL . 'formats/');
	exit;
	} else { ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<?php 
	$id = intval($_GET["id"]);
	try {
		$format = $db->prepare('SELECT * FROM formats WHERE id = :id');
		$format->bindValue(':id', $id);
		$format->execute();
		$result=$format->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	

	?>
	<table>
		<tr>
			<th><label for="title">Format title</label></th>
			<td><input type="text" name="title" id="title" value="<?php echo htmlspecialchars($result["title"]); ?>"></td>
		</tr>
		<tr>
			<th><label for="short_desc">Description</label></th>
			<td><textarea name="short_desc" id="short_desc" rows="5" cols="40"><?php echo htmlspecialchars($result["short_desc"]); ?></textarea></td>
		</tr>
		<tr>
			<th><label for="icon">Show Icon (Please re-upload!)</label></th>
			<td><img src="<?php echo htmlspecialchars($result["icon"]); ?>" alt="Show Icon">
				<input type="file" name="icon" id="icon" value="<?php echo htmlspecialchars($result["icon"]); ?>">
			</td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="submit" value="Update details" name="submit">
</form>
<h2>About the Show Icons</h2>
	<p>
		For security reasons, it's not possible to pre-load the existing image into the 'Browse' button, so before you update the profile, right-click and save the image to your local machine and then re-upload it with the edits, otherwise the existing image will be 'unlinked' (the image will exist on the server, but the url will be blank in the database).
	</p>
	<p>
		When uploading a new Show Icon, you should make sure that you resize the image before uploading it. The CSS will make sure its resized, but its best for everyone if there's no extra bandwidth as far as possible. The image displays at 150(w) x 200(h) pixels, but to make sure they look awesome on reticular screens, which have double the pixel ratio, you should upload a 300x400 image, and the magic of CSS will do the rest.
	</p>
	<p>
		Quality wise, 'save for web' in photoshop is good, or 72dpi is what you're looking for.
	</p>

<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
