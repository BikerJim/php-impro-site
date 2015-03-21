<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "Courses";
require_once(ROOT_PATH . 'inc/header.php');
?>
<?php

if (!isEditor($db)) {
	header('Location: ' . BASE_URL . 'login/');
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//	echo var_dump($_POST);
//	exit;	
	try {
		$course_id = intval($_POST["course_id"]);
		$start_date = htmlspecialchars($_POST["start_date"]);
		$end_date = htmlspecialchars($_POST["end_date"]);
		$show = htmlspecialchars($_POST["show"]);
		$weeks = htmlspecialchars($_POST["weeks"]);
		$course_time = htmlspecialchars($_POST["course_time"]);
		$title = htmlspecialchars($_POST["title"]);
		$price = htmlspecialchars($_POST["price"]);
		$course_desc = htmlspecialchars($_POST["course_desc"]);
		$location = htmlspecialchars($_POST["location"]);
		$teacher1 = htmlspecialchars($_POST["teacher1"]);
		$teacher2 = htmlspecialchars($_POST["teacher2"]);
		$display = htmlspecialchars($_POST["display"]);
		$max_places = htmlspecialchars($_POST["max_places"]);		
		
		$query = "UPDATE courses SET
					course_title = :title, start_date = :start_date,
					end_date = :end_date, show_date = :show, weeks = :weeks, course_location = :location, 
					course_description = :course_desc, course_time = :course_time,
					price = :price, max_places = :max_places,
					teacher1 = :teacher1, display = :display, teacher2 = :teacher2
					WHERE id = :course_id;";
		
		
		$dataIn = $db->prepare( $query );

		$dataIn->bindValue(':start_date', $start_date);
		$dataIn->bindValue(':end_date', $end_date);
		$dataIn->bindValue(':show', $show);
		$dataIn->bindValue(':weeks', $weeks);
		$dataIn->bindValue(':course_time', $course_time);
		$dataIn->bindValue(':title', $title);
		$dataIn->bindValue(':price', $price);
		$dataIn->bindValue(':course_desc', $course_desc);
		$dataIn->bindValue(':location', $location);
		$dataIn->bindValue(':teacher1', $teacher1);
		$dataIn->bindValue(':teacher2', $teacher2);
		$dataIn->bindValue(':display', $display);
		$dataIn->bindValue(':max_places', $max_places);
		$dataIn->bindValue(':course_id', $course_id);				
		$dataIn->execute();

		header("Location: editrecord.php?status=updated");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "updated") { ;
	header('Location: ' . BASE_URL . 'courses/');
	exit;
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
		
		try { // get courses info for pre-filling the form
			if (isset($_GET['id'])) {
				$course_id = intval($_GET['id']);
				} else {
					header('Location: ' . BASE_URL . 'courses/');
					exit;
				}
				
			$courseQuery = $db->prepare('SELECT * FROM courses WHERE id = :id');
			$courseQuery->bindValue(':id', $course_id);
			$courseQuery->execute();
			$course = $courseQuery->fetch(PDO::FETCH_ASSOC);
						
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
?>


		
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<table id="courses_form">
		<!-- Start end dates and time -->
		<tr>
			<th><label for="start_date">Start Date</label></th>
			<td><input type="text" name="start_date" id="start_date" class="date demo" autocomplete="off"
			value="<?php echo $course['start_date']; ?>"/></td>
		</tr>
		<tr>
			<th><label for="end_date">End Date</label></th>
			<td><input type="text" name="end_date" id="end_date" class="date demo" autocomplete="off"
			value="<?php echo $course['end_date']; ?>"/></td>
		</tr>
		<tr>
			<th><label for="show">Show Date</label></th>
			<td><input type="text" name="show" id="show" class="date demo" autocomplete="off"
			value="<?php echo $course['show']; ?>"/></td>
		</tr>
		<tr>
			<th><label for="weeks">Number of lessons</label></th>
			<td><input type="text" name="weeks" id="weeks"
			value="<?php echo $course['weeks']; ?>"/></td>
		</tr>
		<tr>
			<th><label for="course_time">Time</label></th>
			<td><input type="text" name="course_time" id="course_time" value="<?php echo $course['course_time']; ?>"/></td>
		</tr>
		<!-- Course title, price and description -->
		<tr>
			<th><label for="title">Title</label></th>
			<td><input type="text" name="title" id="title" value="<?php echo $course['course_title']; ?>"/></td>
		</tr>
		<tr>
			<th><label for="price">Price</label></th>
			<td><input type="text" name="price" id="price" value="<?php echo $course['price']; ?>" /></td>
		</tr>
		<tr>
			<th><label for="course_desc">Course Description</label></th>
			<td><textarea name="course_desc" id="course_desc" rows="5" cols="40"><?php echo $course['course_description']; ?></textarea></td>
		</tr>
		<!-- location selector -->
		<tr>
			<th><label for="location">Location</label></th>
			<td>
				<select name="location" id="location">
					<?php foreach ($locations as $location) { ?>
						
					<option <?php if ($location['id'] == $course['course_location']) { echo 'selected="selected"'; } ?> value="<?php echo $location['id'];  ?>"><?php echo $location['name']; ?>
					
					</option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<!-- teacher selectors -->
		<tr>
			<th><label for="teacher1">Teacher</label></th>
			<td>
				<select name="teacher1" id="teacher1">
					<?php foreach ($actors as $actor) { ?>
						
					<option <?php if ($actor['id'] == $course['teacher1']) { echo 'selected="selected"'; } ?> value="<?php echo $actor['id']; ?>"><?php echo $actor['first_name'] . " " . $actor['last_name']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="teacher2">Second teacher (Optional)</label></th>
			<td>
				<select name="teacher2" id="teacher2">
					<option value="NULL">-- None --</option>
					<?php foreach ($actors as $actor) { ?>
						
					<option <?php if ($actor['id'] == $course['teacher2']) { echo 'selected="selected"'; } ?> value="<?php echo $actor['id']; ?>"><?php echo $actor['first_name'] . " " . $actor['last_name']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<!-- Display or not and max places -->
		<tr>
			<th><label for="display">Display on courses page?</label></th>
			<td>
				<ul>
				<li><input type="radio" name="display" id="display" value="1">Yes</li>
				<li><input type="radio" name="display" id="display" value="0">No</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th><label for="max_places">Max Students</label></th>
			<td><input type="text" name="max_places" id="max_places" value="<?php echo $course['max_places']; ?>" /></td>
		</tr>
	</table>
	<input type="hidden" value="<?php echo $course_id ?>" name="course_id">
	<input type="submit" value="Update course" name="submit">
</form>
<script>
$(function() {
$( "#start_date").datepicker({dateFormat: "yy-mm-dd"});
$( "#end_date").datepicker({dateFormat: "yy-mm-dd"});
$( "#show").datepicker({dateFormat: "yy-mm-dd"});
});
</script>
<?php } ?>
<?php include(ROOT_PATH . 'inc/footer.php') ?>
