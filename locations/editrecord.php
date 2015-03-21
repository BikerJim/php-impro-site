<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Location";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php

if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	try {
		$id = htmlspecialchars($_POST["id"]);
		$name = htmlspecialchars($_POST["name"]);
		$add_1 = htmlspecialchars($_POST["add_1"]);
		$add_2 = htmlspecialchars($_POST["add_2"]);
		$postcode = htmlspecialchars($_POST["postcode"]);
		$map = htmlspecialchars($_POST["map"]);
		$special_info = htmlspecialchars($_POST["special_info"]);
		$access_pt = htmlspecialchars($_POST["access_pt"]);
		$access_car = htmlspecialchars($_POST["access_car"]);
		
		$query = "UPDATE locations SET name=:name, add_1=:add_1, add_2=:add_2, postcode=:postcode, map=:map, special_info=:special_info, access_public_transport=:access_pt, access_car=:access_car WHERE id=:location_id;";
		
		$dataIn = $db->prepare( $query );

		$dataIn->bindValue(':name', $name);
		$dataIn->bindValue(':add_1', $add_1);
		$dataIn->bindValue(':add_2', $add_2);
		$dataIn->bindValue(':postcode', $postcode);
		$dataIn->bindValue(':map', $map);
		$dataIn->bindValue(':special_info', $special_info);
		$dataIn->bindValue(':access_pt', $access_pt);
		$dataIn->bindValue(':access_car', $access_car);
		$dataIn->bindValue(':location_id', $id);
		
		$dataIn->execute();

		header("Location: editrecord.php?status=updated");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>


<?php

 if (isset($_GET["status"]) && $_GET["status"] == "updated") { ;
	header('Location: ' . BASE_URL . 'locations/');
	} else { 
		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);
			$query = "SELECT * FROM locations WHERE id=:location_id;";
			
			$dataOut = $db->prepare($query);
			
			$dataOut->bindValue(':location_id', $id);
			$dataOut->execute();
			$result = $dataOut->fetch(PDO::FETCH_ASSOC);
		}

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<table>
		<tr>
			<th><label for="name">Location name</label></th>
			<td><input type="text" name="name" id="name" value="<?php echo $result['name'] ?>"></td>
		</tr>
		<tr>
			<th><label for="add_1">Adress line 1:</label></th>
			<td><input type="text" name="add_1" id="add_1" value="<?php echo $result['add_1'] ?>"></td>
		</tr>
		<tr>
			<th><label for="add_2">Adress line 2:</label></th>
			<td><input type="text" name="add_2" id="add_2" value="<?php echo $result['add_2'] ?>"></td>
		</tr>
		<tr>
			<th><label for="postcode">Postcode</label></th>
			<td><input type="text" name="postcode" id="postcode" value="<?php echo $result['postcode'] ?>"></td>
		</tr>
		<tr>
			<th><label for="map">Google map embed code</label></th>
			<td><textarea name="map" id="map" rows="5" cols="40"><?php echo $result['map'] ?></textarea></td>
		</tr>
		<tr>
			<th><label for="special_info">Special info</label></th>
			<td><textarea name="special_info" id="special_info" rows="5" cols="40"><?php echo $result['special_info'] ?></textarea></td>
		</tr>
		<tr>
			<th><label for="access_pt">Access by public transport</label></th>
			<td><textarea name="access_pt" id="access_pt" rows="5" cols="40"><?php echo $result['access_public_transport'] ?></textarea></td>
		</tr>
		<tr>
			<th><label for="access_car">Access by car</label></th>
			<td><textarea name="access_car" id="access_car" rows="5" cols="40"><?php echo $result['access_car'] ?></textarea></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $id ?>">
	<input type="submit" value="Update location" name="submit">
</form>

<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php'); ?>
