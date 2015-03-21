	<?php
		
		if (isEditor($db)) {
			echo '<a class="button" href="' . BASE_URL . 'shows/addrecord.php">Add</a>';
		}
		
		$query = "SELECT s.id AS show_id,
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
					LIMIT 4;";
		try {
			$rows = $db->prepare($query);
			$rows->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
		}
		$results = $rows->fetchAll();

	?>
	<table id='show_list'>
		<?php 

		foreach ($results as $result) {
			
			$date = date('Y-m-d' , strtotime($result['date']));
			$dateString = "'" . $date . "'"; 
			echo 
			'<tr class="show_date">
				<td colspan=2>' . date('d F, Y' , strtotime($result['date'])) . 
				
				' <a class="button" href="javascript:el_windowopenform(' . $dateString . ');">Reserve tickets!</a>';
				
				if (isEditor($db)) {
					echo 
					'<a class="button" href="' . BASE_URL . 'shows/editrecord.php?id='	. $result["show_id"] . '">EDIT</a>
					 <a class="button" href="' . BASE_URL . 'shows/deleterecord.php?id=' . $result["show_id"] .'">DELETE</a>';
					};
					echo '</td></tr>';
				if ($result['early_title'] !== NULL) { 
					echo '<tr>
							<td><img class="showicon" src="../formats/' . $result["early_icon"] . '"></td>
							<td> <h1>' . $result["early_title"] . '</h1>
							<span class="showinfo">
								<p>' . $result["early_short_desc"] . '</p>
								<p>' . $result["early_show_info"] . '</p>
							</span>
							</td>
						</tr>';
					}
			echo 
			'<tr>
				<td><img class="showicon" src="../formats/' . $result["late_icon"] . '"></td>
				<td> <h1>' . $result["late_title"] . '</h1>
				<span class="showinfo">
					<p>' . $result["late_short_desc"] . '</p>
					<p>' . $result["late_show_info"] . '</p>
				</span>
				</td>
			</tr>';
		} ?>
	</table>
