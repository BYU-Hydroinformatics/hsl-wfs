<?php

//This is required to get the international text strings dictionary
require_once 'internationalize.php';

//All queries go through a translator.
require_once 'DBTranslator.php';

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius     = $_GET["radius"];

// Start XML file, create parent node
$dom     = new DOMDocument("1.0");
$node    = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Search the rows in the markers table
$query = sprintf("SELECT SiteID, SiteCode,SiteName, Latitude, Longitude, SiteType, ( 3959 * acos( cos( radians('%s') ) * cos( radians( Latitude ) ) * cos( radians( Longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( Latitude ) ) ) ) AS distance FROM sites HAVING distance < '%s' ORDER BY distance",
	mysqli_real_escape_string($connect, $center_lat),
	mysqli_real_escape_string($connect, $center_lng),
	mysqli_real_escape_string($connect, $center_lat),
	mysqli_real_escape_string($connect, $radius));

$result = transQuery($query, 0, 0);

if (!$result) {
	die("Invalid query: " . mysqli_error($connect));
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
foreach ($result as $row) {

	$query1  = "SELECT * FROM seriescatalog WHERE SiteID=" . $row['SiteID'] . " and VariableID IS NULL";
	$result1 = transQuery($query1, 0, 0);
	$rows    = count($result1);

	$query2  = "SELECT * FROM seriescatalog WHERE SiteID=" . $row['SiteID'];
	$result2 = transQuery($query2, 0, 0);
	$rows2   = count($result2);

	if ((($rows == 1) && ($rows == $rows2)) || ($rows2 == 0)) {

	} else {

		$node    = $dom->createElement("marker");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("name", $row['SiteName']);
		$newnode->setAttribute("siteid", $row['SiteID']);
		$newnode->setAttribute("sitecode", $row['SiteCode']);
		$newnode->setAttribute("lat", $row['Latitude']);
		$newnode->setAttribute("lng", $row['Longitude']);
		$newnode->setAttribute("distance", $row['distance']);
		$newnode->setAttribute("sitetype", translateWord($row['SiteType']));

	}

}

//Output the XML DATA to be fed into the google maps api

echo $dom->saveXML();
mysqli_close($connect);
?>