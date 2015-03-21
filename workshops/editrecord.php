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
	if (isset($_POST['id'])) {
		
		$id = intval($_POST['id']);
		
		try {
			$date = htmlspecialchars($_POST["date"]);
			$title = htmlspecialchars($_POST["title"]);
			$actor1 = htmlspecialchars($_POST["actor1"]);
			$actor2 = htmlspecialchars($_POST["actor2"]);
			if ($actor2 == "NULL") {
				$actor2 = null;
			}
				$query = "UPDATE workshops SET date=:date, title=:title, actor_id=:actor1, actor2_id=:actor2
										WHERE id=:ws_id;";
			
				$dataIn = $db->prepare($query);
			
				$dataIn->bindParam(':date', $date);
				$dataIn->bindParam(':title', $title);
				$dataIn->bindParam(':actor1', $actor1);
				$dataIn->bindParam(':actor2', $actor2);
				$dataIn->bindParam(':ws_id', $id);
 			
			$dataIn->execute();

			header('Location: ' . BASE_URL . 'workshops/editrecord.php?status=updated');
			exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "updated") {
		header('Location: ' . BASE_URL . 'workshops/');
	} else { 
		try {
			$actorquery = $db->query('SELECT id, first_name, last_name FROM actors;');
			$actorquery->execute();
			$actors = $actorquery->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<?php 
	$id = $_GET["id"];
	
	$workshop = $db->prepare('SELECT * FROM workshops WHERE id = :ws_id');
	$workshop->bindValue(':ws_id', $id);
	$workshop->execute();
	$result=$workshop->fetch(PDO::FETCH_ASSOC);
	?>
	<table>
		<tr>
			<th><label for="date">Date</label></th>
			<td><input type="text" name="date" id="datepicker" value="<?php echo htmlspecialchars($result["date"]); ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<th><label for="title">Title</label></th>
			<td><input type="text" name="title" id="title" value="<?php echo htmlspecialchars($result["title"]); ?>"></td>
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
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="submit" value="Update details" name="submit">
</form>

<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
