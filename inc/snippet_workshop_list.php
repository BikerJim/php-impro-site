	<?php
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'workshops/addrecord.php">Add</a>';
		}
		
		$query = "
			SELECT l1.id AS loc_id, workshops.id AS ws_id, date, title, a1.first_name AS actor1, a2.first_name AS actor2, title, l1.name AS location
			FROM workshops
			LEFT JOIN actors AS a1
			ON a1.id = actor_id
			LEFT JOIN actors AS a2
			ON a2.id = actor2_id
			LEFT JOIN locations AS l1
			ON l1.id = location_id
			WHERE date > now()
			ORDER BY date ASC
			LIMIT 4";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
		}
		$results = $rows->fetchAll(PDO::FETCH_ASSOC);
	?>
	<ul id='workshop_list'>
		<?php 
		foreach ($results as $result) {
			echo '<li><h3>' . date('d F, Y' , strtotime($result['date'])) . '</h3> ' . $result['title'] . '<br/> with ' . $result['actor1'] ;
			if ($result['actor2'] != "") {
				echo ' and ' . $result['actor2'];
			}
			echo ' at the <a href="' . BASE_URL . 'locations/location.php?id=' . $result['loc_id'] . '">' . $result['location'] . '</a>';
				if (isEditor($db)) {
					echo 
					'&nbsp;<a class="button" href="' . BASE_URL . 'workshops/editrecord.php?id='	. $result['ws_id'] . '"> EDIT </a> &nbsp;
					 <a class="button" href="' . BASE_URL . 'workshops/deleterecord.php?id=' . $result['ws_id'] .'"> DELETE </a>';
				}
			echo '</li>';
		} ?>
	</ul>
