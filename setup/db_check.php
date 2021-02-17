<?php

$connect = mysqli_connect($_POST['databasehost'], $_POST['databaseusername'], $_POST['databasepassword'])
or die("Error connecting to database: " .
	mysqli_error($connect) . "");

// Make my_db the current database
$db_selected = mysqli_select_db($connect, $_POST['databasename']);

if (!$db_selected) {
	// If we couldn't, then it either doesn't exist, or we can't see it.
	$sql = 'CREATE DATABASE ' . $_POST['databasename'];

	if (mysqli_query($connect, $sql)) {
	} else {
		echo 'Error creating database: ' . mysqli_error($connect) . "\n";
	}
}

$bool = mysqli_select_db($connect, $_POST['databasename' )
or die("Error selecting the database " . $_POST['databasename'] .
	mysqli_error($connect) . "");

echo (1);

?>