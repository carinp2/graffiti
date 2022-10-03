<?php
$conn = mysqli_connect($_SESSION['SessionGrafHost'], $_SESSION['SessionGrafUName'], $_SESSION['SessionGrafPass'], $_SESSION['SessionGrafDbName']);

if(mysqli_connect_errno()) {
	echo ("Could not connect to database: " . mysqli_connect_error());
	exit();
}

if(!$conn->set_charset("utf8mb4")) {
	$conn->error;
}
else {
	$conn->character_set_name();
}
?>
