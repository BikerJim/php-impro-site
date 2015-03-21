	<?php
		if (isEditor($db)) {
			echo '<a class="addbutton" href="' . BASE_URL . 'courses/addrecord.php">Add</a>';
		}
	
		$query = "	SELECT courses.id course_id, start_date, end_date, show_date,
					course_title, course_description,
					courses.price price, course_time time, weeks,
					loc.name course_location, loc.id loc_id,
					t1.first_name teacher1, t2.first_name teacher2 FROM courses
					LEFT JOIN actors AS t1
					ON t1.id = teacher1
					LEFT JOIN actors AS t2
					ON t2.id = teacher2
					LEFT JOIN locations AS loc
					ON loc.id = course_location
					";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
		}
		$results = $rows->fetchAll(PDO::FETCH_ASSOC);
	?>
	<ul id='courses_list'>
		<?php 
		foreach ($results as $result) {
			echo '<li>';
			if (isEditor($db)) {
					echo 
					'<a class="button" href="' . BASE_URL . 'courses/editrecord.php?id=' . $result['course_id'] . '"> EDIT </a> 
					<a class="button" href="' . BASE_URL . 'courses/deleterecord.php?id=' . $result['course_id'] .'">  DELETE </a>';
				}
			echo	
			 '<span class="revealer">' 
			 . $result['course_title'] . ' ( Starts ' . date('l, jS F ', strtotime($result['start_date'])) 
			 . ') <em> more info >></em></span>' 
			 . '<div class="course_detail"><p>' . $result['course_description'] . '</p>'
			 . '<ul class="course_data"><li>Price &euro;' . $result['price'] . '</li>'
			 . '<li>Every ' . date('l', strtotime($result['start_date'])) . ', ' . $result['time'] . '</li>'
			 . '<li>First lesson: ' . date('jS F', strtotime($result['start_date'])) . '</li>'
			 . '<li>Last lesson: ' . date('jS F', strtotime($result['end_date'])) . '</li>'
			 . '<li>' . $result['weeks'] . ' lessons</li>'
			 . '<li>Show date: ' . date('l jS F', strtotime($result['show_date'])) . '</li>'
			 . '</ul>'
			 . '<p>with ' . $result['teacher1'] ;
			if ($result['teacher2'] != "") {
				echo ' and ' . $result['teacher2'];
			}
			echo ' at the <a href="' . BASE_URL . 'locations/location.php?id=' . $result['loc_id'] . '">' . $result['course_location'] . '</a></p></div>';
			echo '</li>';
		} ?>
	</ul>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo BASE_URL ?>js/course_reveal.js" type="text/javascript" charset="utf-8"></script>
