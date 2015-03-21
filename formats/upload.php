<?php
// create variables 
$target_dir = "img/";
$tmpFilename = $_FILES['icon']['tmp_name']; // generated tmp filename
$title = strtolower($_POST['title']); // get title from form
$fileroot = preg_replace('/\s/', '', $title); // remove whitespaces

$uploadOk = 1;
$target_file = $target_dir . basename($_FILES['icon']['name']);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$target_file = $target_dir . basename($fileroot) . "." . $imageFileType;

// check if image is a real image or a fake

if (isset($_POST["submit"])) {
	$check = getimagesize($tmpFilename);
	if ($check !== false) {
		$uploadOk = 1;
	} else {
		header('Location: ' . BASE_URL . 'formats/index.php?error=2');
		exit;
		$uploadOk = 0;
	}	
}

if ($_FILES['mugshot']['size'] > 500000) {
	header('Location: ' . BASE_URL . 'formats/index.php?error=3');
	exit;
	$uploadOk = 0;
}

if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
	header('Location: ' . BASE_URL . 'formats/index.php?error=4');
	exit;
	$uploadOk = 0;
}

if ($uploadOk == 0) {
	header('Location: ' . BASE_URL . 'formats/index.php?error=1');
	exit;
} else {
	if (move_uploaded_file($tmpFilename, $target_file)) {
		$message = "File Uploaded";
	} else {
		$message = $target_file . " couldn't be moved from " . $tmpFilename . "<br/>";
	}
}
