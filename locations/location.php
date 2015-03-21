<?php 
require_once('../inc/config.php'); 
require_once(ROOT_PATH . 'inc/database.php');
require_once(ROOT_PATH . 'inc/functions.php');
$pageTitle = "";
require_once(ROOT_PATH . 'inc/header.php');
?>

<?php
	
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);	
		
		try {
			$query = "SELECT * FROM locations WHERE id = :location_id;";
			 
			$dataOut = $db->prepare($query);
			$dataOut->bindParam(':location_id', $id );
			$dataOut->execute();
			$result = $dataOut->fetch(PDO::FETCH_ASSOC);

		} catch (Exception $e) {
			echo "Could not connect to the database";
			exit;
		} ?>

<h3><?php echo $pageTitle = $result['name']; ?></h3>
<p>
<?php echo $result['special_info'] ; ?>
</p>
<address>
<?php echo $result['add_1'] . '<br/>'; ?>
<?php echo $result['add_2'] . '<br/>'; ?>	
<?php echo $result['postcode'] . '<br/>'; ?>
</address>		
<?php echo html_entity_decode($result['map']) ; ?>
<h3>Access by Public Transport</h3>
<p>
<?php echo $result['access_public_transport']; ?>
</p>
<h3>Access by Public Transport</h3>
<p>
<?php echo $result['access_car']; ?>
</p>

<?php		
	} else {
		header('Location: ' . BASE_URL . 'locations/');
		exit;
	}
?>

<?php include(ROOT_PATH . 'inc/footer.php'); ?>
