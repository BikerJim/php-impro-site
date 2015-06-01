	<?php
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'workshops/addrecord.php">Add</a>';
		}
		
		$query = "
			SELECT workshops.id AS ws_id, date, title, a1.first_name AS actor1, a2.first_name AS actor2, title, l1.name AS location
			FROM workshops
			LEFT JOIN actors AS a1
			ON a1.id = actor_id
			LEFT JOIN actors AS a2
			ON a2.id = actor2_id
			LEFT JOIN locations AS l1
			ON l1.id = location_id
			WHERE date >= CURDATE()
			ORDER BY date";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			$result = $rows->fetch(PDO::FETCH_ASSOC);
			} catch(PDOException $e) {
				die($e->getMessage());
		}
//		echo var_dump($result);
//		exit;

	?>
	<ul id='next_workshop'>
<?php 
if ($result != NULL) {

			echo '<li><h3>' . date('d F, Y' , strtotime($result['date'])) . '</h3> ' . $result['title'] . '<br/> with ' . $result['actor1'] ;
			if ($result['actor2'] != "") {
				echo ' and ' . $result['actor2'];
			}
			echo ' at the ' . $result['location'];
				if (isEditor($db)) {
					echo 
					'&nbsp;<a class="button" href="' . BASE_URL . 'workshops/editrecord.php?id='	. $result["ws_id"] . '"> EDIT </a> &nbsp; 
					 <a class="button" href="' . BASE_URL . 'workshops/deleterecord.php?id=' . $result["ws_id"] .'"> DELETE </a>';
				}
			echo '</li>';
			} else {
				echo '<li>There are no workshops planned for a while, check back soon!</li>';			
			}
?>
	</ul>
