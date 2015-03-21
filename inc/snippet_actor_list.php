	<?php
		
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'actors/addrecord.php">Add</a>';
		}
		
		$query = "SELECT * FROM actors ORDER BY first_name";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
		}
		$results = $rows->fetchAll();
	?>
	<table id='actor_list'>
	<?php 
		foreach ($results as $result) {
		if (isEditor($db)) {
				echo 
				'<tr>
					<td rowspan=2><img class="actorsmugshot" src="' . $result["mugshot"] . '"></td>
					<td colspan=2> <h1>' . $result["first_name"] . ' ' . $result["last_name"] . '</h1>
					<span class="actordescription">' . htmlspecialchars_decode($result["description"]) . '</span>
					</td>
				</tr>';
				echo 
				'<tr>
					<td><a class="button" href="' . BASE_URL . 'actors/editrecord.php?id='	. $result["id"] . '">EDIT</a></td>
					<td><a class="button" href="' . BASE_URL . 'actors/deleterecord.php?id=' . $result["id"] .'">DELETE</a></td>
				</tr>';
		} elseif ($result['display']) {
				echo 
					'<tr>
						<td rowspan=2><img class="actorsmugshot" src="' . $result["mugshot"] . '"></td>
						<td colspan=2> <h1>' . $result["first_name"] . ' ' . $result["last_name"] . '</h1>
						<span class="actordescription">' . htmlspecialchars_decode($result["description"]) . '</span>
						</td>
					</tr>';
				echo 
				'<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>';
				}			
			}
	?>
	</table>
