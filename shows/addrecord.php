<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Shows";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php
if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
} ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	try {
		$date = htmlspecialchars($_POST["date"]);
		$earlyshow = htmlspecialchars($_POST["earlyshow"]);
		$lateshow = htmlspecialchars($_POST["lateshow"]);
		$earlydesc = htmlspecialchars($_POST["earlydesc"]);
		$latedesc = htmlspecialchars($_POST["latedesc"]);
		
		if ($earlyshow != "NULL") {
			$dataIn = $db->prepare( "INSERT INTO shows (date, early_show, late_show, early_show_info, late_show_info) VALUES (:date, :early, :late, :earlyinfo, :lateinfo);" );

			$dataIn->bindValue(':early', $earlyshow);
			$dataIn->bindValue(':earlyinfo', $earlydesc);
			
		} else {
			$dataIn = $db->prepare( "INSERT INTO shows (date, late_show, late_show_info) VALUES (:date, :late, :lateinfo);" );
		}	

		$dataIn->bindValue(':date', $date);
		$dataIn->bindValue(':late', $lateshow);
		$dataIn->bindValue(':lateinfo', $latedesc);
				
		$dataIn->execute();

		header("Location: addrecord.php?status=added");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php
	if (isset($_GET["status"]) && $_GET["status"] == "added") {
		header('Location: ' . BASE_URL . 'shows/');
	} else { 
		try { // get formats for the drop down
			$formatquery = $db->query('SELECT id, title FROM formats;');
			$formatquery->execute();
			$formats = $formatquery->fetchAll(PDO::FETCH_ASSOC);	
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
			<th><label for="earlyshow">8 o'clock show</label></th>
			<td>
				<select name="earlyshow" id="earlyshow">
					<option value="NULL">-- None --</option>
					<?php foreach ($formats as $format) { ?>
						<option value="<?php echo $format['id']; ?>"><?php echo $format['title']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="earlydesc">Early Show description</label></th>
			<td>
				<textarea name="earlydesc" id="earlydesc"></textarea>
			</td>
		</tr>
		<tr>
			<th><label for="lateshow">9 o'clock show</label></th>
			<td>
				<select name="lateshow" id="lateshow">
					<?php foreach ($formats as $format) { ?>
						<option value="<?php echo $format['id']; ?>"><?php echo $format['title']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="latedesc">Late Show description</label></th>
			<td>
				<textarea name="latedesc" id="latedesc"></textarea>
			</td>
		</tr>
	</table>

	<input type="submit" value="Add show" name="submit">
</form>
<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
