<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Edit a show";
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
		$early_show = htmlspecialchars($_POST["earlyshow"]);
		$earlydesc = htmlspecialchars($_POST["earlydesc"]);
		$late_show = htmlspecialchars($_POST["lateshow"]);
		$latedesc = htmlspecialchars($_POST["latedesc"]);
		
		$id = $_POST["id"];
		
		$updateQuery = "UPDATE shows 
						SET date=:date,
						early_show=:early_show, early_show_info=:earlydesc,
						late_show=:late_show, late_show_info=:latedesc 
						WHERE id=:id;";
		
		$dataIn = $db->prepare( $updateQuery );

		$dataIn->bindParam(':id', $id);
		$dataIn->bindParam(':date', $date);
		$dataIn->bindParam(':early_show', $early_show);
		$dataIn->bindParam(':earlydesc', $earlydesc);
		$dataIn->bindParam(':late_show', $late_show);		
		$dataIn->bindParam(':latedesc', $latedesc);

		$dataIn->execute();

		header("Location: editrecord.php?status=updated");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "updated") { 
	header('Location:' . BASE_URL . 'shows/');
	exit;
	} 
	if (isset($_GET['id'])) {
			$show_id = intval($_GET['id']);
			$query = "SELECT s.id AS show_id,
						date,
						f1.id AS early_format_id,
						f1.title AS early_title,
						f1.short_desc AS early_short_desc,
						early_show_info,
						f1.icon AS early_icon,
						f2.id AS late_format_id,
						f2.title AS late_title,
						f2.short_desc AS late_short_desc,
						late_show_info,
						f2.icon AS late_icon
						FROM shows AS s
						LEFT JOIN formats AS f1
						ON f1.id = s.early_show 
						LEFT JOIN formats AS f2
						ON f2.id = s.late_show
						WHERE s.id = :show_id;";
			try {
				$dataOut = $db->prepare($query);
				$dataOut->bindParam(':show_id', $show_id); 
				$dataOut->execute();
				$result = $dataOut->fetch(PDO::FETCH_ASSOC);
;
				} catch(PDOException $e) {
					die($e->getMessage());
				}

			try {
				$formats_query = "SELECT id, title FROM formats ORDER BY title;";
				$formatsOut = $db->query($formats_query);
				$formatsOut->execute();
				$formats = $formatsOut->fetchAll(PDO::FETCH_ASSOC);

			} catch(PDOException $e) {
					die($e->getMessage());
			}
?>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<table>
			<tr>
				<th><label for="date">Date</label></th>
				<td><input type="text" name="date" id="datepicker" class="date demo" autocomplete="off" value="<?php echo $result['date']; ?>"/></td>
			</tr>
			<tr>
				<th><label for="earlyshow">8 o'clock show</label></th>
				<td>
					<select name="earlyshow" id="earlyshow">
						<option value="NULL">-- None --</option>
						<?php foreach ($formats as $format) { 
							?>
							<option
							<?php if ($format['id'] == $result['early_format_id']) {
								echo 'selected="selected"';
							} ?> value="<?php echo $format['id']; ?>"><?php echo $format['title']; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="earlydesc">Early Show description</label></th>
				<td>
					<textarea name="earlydesc" id="earlydesc"><?php echo $result['early_show_info']; ?></textarea>
				</td>
			</tr>
			<tr>
				<th><label for="lateshow">9 o'clock show</label></th>
				<td>
					<select name="lateshow" id="lateshow">
						<?php foreach ($formats as $format) { ?>
							<option
							<?php if ($format['id'] == $result['late_format_id']) {
								echo 'selected="selected"';
							}?> 
							value="<?php echo $format['id']; ?>"><?php echo $format['title']; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="latedesc">Late Show description</label></th>
				<td>
					<textarea name="latedesc" id="latedesc"><?php echo $result['late_show_info']; ?></textarea>
				</td>
			</tr>
		</table>
		<input type="hidden" value="<?php echo $show_id; ?>" name="id">
		<input type="submit" value="Update show details" name="submit">
	</form>
<?php 	} ?>
		
<?php include(ROOT_PATH . 'inc/footer.php') ?>
