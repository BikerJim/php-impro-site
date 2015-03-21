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
	try {
		$name = htmlspecialchars($_POST["name"]);
		$add_1 = htmlspecialchars($_POST["add_1"]);
		$add_2 = htmlspecialchars($_POST["add_2"]);
		$postcode = htmlspecialchars($_POST["postcode"]);
		$map = htmlspecialchars($_POST["map"]);
		$special_info = htmlspecialchars($_POST["special_info"]);
		$access_pt = htmlspecialchars($_POST["access_pt"]);
		$access_car = htmlspecialchars($_POST["access_car"]);
		
		$dataIn = $db->prepare( "INSERT INTO locations (name, add_1, add_2, postcode, map, special_info, access_public_transport, access_car) VALUES (:name, :add_1, :add_2, :postcode, :map, :special_info, :access_pt, :access_car);" );

		$dataIn->bindValue(':name', $name);
		$dataIn->bindValue(':add_1', $add_1);
		$dataIn->bindValue(':add_2', $add_2);
		$dataIn->bindValue(':postcode', $postcode);
		$dataIn->bindValue(':map', $map);
		$dataIn->bindValue(':special_info', $special_info);
		$dataIn->bindValue(':access_pt', $access_pt);
		$dataIn->bindValue(':access_car', $access_car);
		
		$dataIn->execute();

		header("Location: addrecord.php?status=added");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "added") { ;
	header('Location: ' . BASE_URL . 'locations/');
	} else { ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<th><label for="name">Location name</label></th>
			<td><input type="text" name="name" id="name"></td>
		</tr>
		<tr>
			<th><label for="add_1">Adress line 1:</label></th>
			<td><input type="text" name="add_1" id="add_1"></td>
		</tr>
		<tr>
			<th><label for="add_2">Adress line 2:</label></th>
			<td><input type="text" name="add_2" id="add_2"></td>
		</tr>
		<tr>
			<th><label for="postcode">Postcode</label></th>
			<td><input type="text" name="postcode" id="postcode"></td>
		</tr>
		<tr>
			<th><label for="map">Google map embed code</label></th>
			<td><textarea name="map" id="map" rows="5" cols="40"></textarea></td>
		</tr>
		<tr>
			<th><label for="special_info">Special info</label></th>
			<td><textarea name="special_info" id="special_info" rows="5" cols="40"></textarea></td>
		</tr>
		<tr>
			<th><label for="access_pt">Access by public transport</label></th>
			<td><textarea name="access_pt" id="access_pt" rows="5" cols="40"></textarea></td>
		</tr>
		<tr>
			<th><label for="access_car">Access by car</label></th>
			<td><textarea name="access_car" id="access_car" rows="5" cols="40"></textarea></td>
		</tr>
	</table>

	<input type="submit" value="Add location" name="submit">
</form>

<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php'); ?>
