<?php

require 'fetchMainConfig.php';

$connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD)
or die("<p>Error connecting to database: " .
	mysqli_connect_error() . "</p>");
mysqli_set_charset($connect, "utf8");
$bool = mysqli_select_db($connect, DATABASE_NAME)
or die("<p>Error selecting the database " . DATABASE_NAME .
	mysqli_error($connect) . "</p>");

?>
