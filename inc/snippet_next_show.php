	<?php
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'shows/addrecord.php">Add</a>';
		}
		
		$query = "
			SELECT s.id AS show_id,
					date,
					f1.title AS early_title,
					f1.short_desc AS early_short_desc,
					early_show_info,
					f1.icon AS early_icon,
					f2.title AS late_title,
					f2.short_desc AS late_short_desc,
					late_show_info,
					f2.icon AS late_icon
					FROM shows AS s
					LEFT JOIN formats AS f1
					ON f1.id = s.early_show 
					LEFT JOIN formats AS f2
					ON f2.id = s.late_show
					WHERE date >= CURDATE()
					ORDER BY date
					;";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			$result = $rows->fetch(PDO::FETCH_ASSOC);
			} catch(PDOException $e) {
				die($e->getMessage());
		}

	?>
	<table id='show_list'>
		<?php 
			echo 
			'<tr>
				<td colspan=2> <h3>' . date('d F, Y' , strtotime($result['date'])) . '</h3>';
				
				if (isEditor($db)) {
					echo 
					'<a class="button" href="' . BASE_URL . 'shows/editrecord.php?id='	. $result["show_id"] . '">EDIT</a>
					 <a class="button" href="' . BASE_URL . 'shows/deleterecord.php?id=' . $result["show_id"] .'">DELETE</a>';
					};
			echo '</td>
			</tr>';
			if ($result["early_title"] != null) {
			echo 
			'<tr>
				<td><img class="showicon" src="formats/' . $result["early_icon"] . '"></td>
				<td> <h3>' . $result["early_title"] . '</h3>
				<span class="showinfo">
					<p>' . $result["early_short_desc"] . '</p>
					<p>' . $result["early_show_info"] . '</p>
				</span>
				</td>
			</tr>';
			}
			echo 
			'<tr>
				<td><img class="showicon" src="formats/' . $result["late_icon"] . '"></td>
				<td> <h3>' . $result["late_title"] . '</h3>
				<span class="showinfo">' . $result["late_short_desc"] . '</p>
					<p>' . $result["late_show_info"] . '</p></span>
				</td>
			</tr>';
	 ?>
	</table>
