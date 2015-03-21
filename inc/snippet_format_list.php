	<?php
		
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'formats/addrecord.php">Add</a>';
		}
		
		$query = "SELECT * FROM formats ORDER BY title";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
		}
		$results = $rows->fetchAll();
	?>
	<table id='format_list'>
		<?php 
		foreach ($results as $result) {
			echo 
			'<tr>
				<td rowspan=2><img class="actorsmugshot" src="' . $result["icon"] . '"></td>
				<td colspan=2> <h1>' . $result["title"] . '</h1>
				<span class="formatdescription">' . $result["short_desc"] . '</span>
				</td>
			</tr>';
			if (isEditor($db)) {
			echo 
			'<tr>
				<td><a class="button" href="' . BASE_URL . 'formats/editrecord.php?id='	. $result["id"] . '">EDIT</a></td>
				<td><a class="button" href="' . BASE_URL . 'formats/deleterecord.php?id=' . $result["id"] .'">DELETE</a></td>
			</tr>';} else {
			echo 
			'<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
			}
		} ?>
	</table>
