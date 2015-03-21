	<?php
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'locations/addrecord.php">Add</a>';
		}
		
		$query = "SELECT * FROM locations";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
		}
		$results = $rows->fetchAll();
	?>
	<ul id='location_list'>
		<?php 
		foreach ($results as $result) {
			echo 
			'<li><a href="' . BASE_URL . 'locations/location.php?id=' . $result['id'] . '">' . $result['name'] . '</a>';
			if (isEditor($db)) {
				echo 
				'<a class="button" href="' . BASE_URL . 'locations/editrecord.php?id='	. $result["id"] . '">EDIT</a> &nbsp;
				 <a class="button" href="' . BASE_URL . 'locations/deleterecord.php?id=' . $result["id"] .'">DELETE</a>
				</li>';
			} 
		} ?>
	</ul>
