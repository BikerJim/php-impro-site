<?php 
// create variables 
$target_dir = "img/";
$tmpFilename = $_FILES['mugshot']['tmp_name']; // generated tmp filename
$fname = strtolower($_POST['first_name']); // get first name and
$lname = strtolower($_POST['last_name']); // surname from form
$fileroot = preg_replace('/\s/', '', $fname . $lname); // stick em together & remove whitespaces

$uploadOk = 1;
$target_file = $target_dir . basename($_FILES['mugshot']['name']);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$target_file = $target_dir . basename($fileroot) . "." . $imageFileType;

// check if image is a real image or a fake

if (isset($_POST["submit"])) {
	$check = getimagesize($tmpFilename);
	if ($check !== false) {
		$uploadOk = 1;
	} else {
		$error_message = "It appears that the file you tried to upload is not an image";
		$uploadOk = 0;
	}	
}

if ($_FILES['mugshot']['size'] > 500000) {
	$error_message = "It appears the file you tried to upload is too large. It should be less than 500kb. Try reducing tje size and/or the resolution a bit. The mugshots are 150px wide and 200px tall.";
	$uploadOk = 0;
}

if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
	$error_message = "It appears that the file you tried to upload wasn't a jpg, jpeg or png. Gifs are old school and shouldn't be used any more.";
	$uploadOk = 0;
}

if ($uploadOk == 0) {
	$error_message = "Oh dear. Something went wrong with the image. Did you forget to select one?";
} else {
	if (move_uploaded_file($tmpFilename, $target_file)) {
		$message = "File Uploaded";
	} else {
		$error_message = $target_file . " couldn't be moved from " . $tmpFilename . "<br/>";
	}
}
