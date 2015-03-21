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
	// echo var_dump($_POST);
	// exit;
	try {
		$start_date = htmlspecialchars($_POST["start_date"]);
		$end_date = htmlspecialchars($_POST["end_date"]);
		$weeks = htmlspecialchars($_POST["weeks"]);
		$show = htmlspecialchars($_POST["show"]);
		$course_time = htmlspecialchars($_POST["course_time"]);
		$title = htmlspecialchars($_POST["title"]);
		$price = htmlspecialchars($_POST["price"]);
		$course_desc = htmlspecialchars($_POST["course_desc"]);
		$location = htmlspecialchars($_POST["location"]);
		$teacher1 = htmlspecialchars($_POST["teacher1"]);
		$teacher2 = htmlspecialchars($_POST["teacher2"]);
		$display = htmlspecialchars($_POST["display"]);
		$max_places = htmlspecialchars($_POST["max_places"]);
		
		//echo $start_date;
		//exit;	
		
		$query1 = "INSERT INTO courses (
					course_title, start_date, end_date, weeks, show_date, course_location, 
					course_description, course_time, price, max_places, teacher1, display, teacher2
					) VALUES (
					 :title, :start_date, :end_date, :weeks, :show, :location, :course_desc,
					 :course_time, :price, :max_places,
					 :teacher1, :display, :teacher2 
					 );";
		$query2 = "INSERT INTO courses (
					course_title, start_date, end_date, weeks, show_date, course_location, 
					course_description, course_time, price, max_places, teacher1, display
					) VALUES (
					 :title, :start_date, :end_date, :weeks, :show, :location, :course_desc,
					 :course_time, :price, :max_places,
					 :teacher1, :display 
					 );";
		
		if ($teacher2 != "NULL") {
			$dataIn = $db->prepare( $query1 );

			$dataIn->bindValue(':teacher2', $teacher2);
			
		} else {
			$dataIn = $db->prepare( $query2 );
		}	

		$dataIn->bindValue(':start_date', $start_date);
		$dataIn->bindValue(':end_date', $end_date);
		$dataIn->bindValue(':weeks', $weeks);
		$dataIn->bindValue(':show', $show);
		$dataIn->bindValue(':course_time', $course_time);
		$dataIn->bindValue(':title', $title);
		$dataIn->bindValue(':price', $price);
		$dataIn->bindValue(':course_desc', $course_desc);
		$dataIn->bindValue(':location', $location);
		$dataIn->bindValue(':teacher1', $teacher1);
		$dataIn->bindValue(':display', $display);
		$dataIn->bindValue(':max_places', $max_places);
				
		$dataIn->execute();

		header("Location: addrecord.php?status=added");
		exit;
		
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
} ?>

<?php if (isset($_GET["status"]) && $_GET["status"] == "added") { ;
	header('Location: ' . BASE_URL . 'courses/');
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
	<table id="courses_form">
		<!-- Start end dates and time-->
		<tr>
			<th><label for="start_date">Start Date</label></th>
			<td><input type="text" name="start_date" id="start_date" class="date demo" autocomplete="off"/></td>
		</tr>
		<tr>
			<th><label for="end_date">End Date</label></th>
			<td><input type="text" name="end_date" id="end_date" class="date demo" autocomplete="off"/></td>
		</tr>
		<tr>
			<th><label for="show">Show Date</label></th>
			<td><input type="text" name="show" id="show" class="date demo" autocomplete="off"/></td>
		</tr>
		<tr>
			<th><label for="weeks">Number of lessons</label></th>
			<td><input type="text" name="weeks" id="weeks"/></td>
		</tr>
		<tr>
			<th><label for="course_time">Time</label></th>
			<td><input type="text" name="course_time" id="course_time"/></td>
		</tr>
		<!-- Course title, price and description -->
		<tr>
			<th><label for="title">Title</label></th>
			<td><input type="text" name="title" id="title"/></td>
		</tr>
		<tr>
			<th><label for="price">Price</label></th>
			<td><input type="text" name="price" id="price"/></td>
		</tr>
		<tr>
			<th><label for="course_desc">Course Description</label></th>
			<td><textarea name="course_desc" id="course_desc" rows="5" cols="40"></textarea></td>
		</tr>
		<!-- location selector -->
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
		<!-- teacher selectors -->
		<tr>
			<th><label for="teacher1">Teacher</label></th>
			<td>
				<select name="teacher1" id="teacher1">
					<?php foreach ($actors as $actor) { ?>
						
					<option value="<?php echo $actor['id']; ?>"><?php echo $actor['first_name'] . " " . $actor['last_name']; ?></option>
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
						
					<option value="<?php echo $actor['id']; ?>"><?php echo $actor['first_name'] . " " . $actor['last_name']; ?></option>
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
			<td><input type="text" name="max_places" id="max_places"/></td>
		</tr>
	</table>

	<input type="submit" value="Add course" name="submit">
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
