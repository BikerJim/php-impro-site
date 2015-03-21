<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Workshops";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php

if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	try {
		$date = htmlspecialchars($_POST["date"]);
		$actor1 = htmlspecialchars($_POST["actor1"]);
		$actor2 = htmlspecialchars($_POST["actor2"]);
		$title = htmlspecialchars($_POST["title"]);
		$location = htmlspecialchars($_POST["location"]);
		
		if ($actor2 != "NULL") {
			$dataIn = $db->prepare( "INSERT INTO workshops (date, actor_id, actor2_id, title, location_id ) VALUES (:date, :actor1, :actor2, :title, :location);" );

			$dataIn->bindValue(':actor2', $actor2);
			
		} else {
			$dataIn = $db->prepare( "INSERT INTO workshops (date, actor_id, title, location_id ) VALUES (:date, :actor1, :title, :location);" );
		}	

		$dataIn->bindValue(':date', $date);
		$dataIn->bindValue(':actor1', $actor1);
		$dataIn->bindValue(':title', $title);
		$dataIn->bindValue(':location', $location);
				
		$dataIn->execute();

		header("Location: addrecord.php?status=added");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "added") { ;
	header('Location: ' . BASE_URL . 'workshops/');
	} else { 
		try { // get actors for the drop down
			$actorquery = $db->query('SELECT id, first_name, last_name FROM actors;');
			$actorquery->execute();
			$actors = $actorquery->fetchAll(PDO::FETCH_ASSOC);
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		try { // get locations for the dropdown
			$locquery = $db->query('SELECT id, name FROM locations;');
			$locquery->execute();
			$locations = $locquery->fetchAll(PDO::FETCH_ASSOC);
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		
		?>


		
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<table>
		<tr>
			<th><label for="date">Date</label></th>
			<td><input type="text" name="date" id="datepicker" class="date demo" autocomplete="off"/></td>
		</tr>
		<tr>
			<th><label for="title">Title</label></th>
			<td><input type="text" name="title" id="title"/></td>
		</tr>
		<tr>
			<th><label for="location">Location</label></th>
			<td>
				<select name="location" id="location">
					<?php foreach ($locations as $location) { ?>
						
					<option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="actor1">Actor 1</label></th>
			<td>
				<select name="actor1" id="actor1">
					<?php foreach ($actors as $actor) { ?>
						
					<option value="<?php echo $actor['id']; ?>"><?php echo $actor['first_name'] . " " . $actor['last_name']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="actor2">Actor 2 (Optional)</label></th>
			<td>
				<select name="actor2" id="actor2">
					<option value="NULL">-- None --</option>
					<?php foreach ($actors as $actor) { ?>
						
					<option value="<?php echo $actor['id']; ?>"><?php echo $actor['first_name'] . " " . $actor['last_name']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
	</table>

	<input type="submit" value="Add workshop" name="submit">
</form>
<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>

