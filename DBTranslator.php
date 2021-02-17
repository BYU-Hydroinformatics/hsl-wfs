<?php

require_once 'db_config.php';

function transQuery($inputquery, $sendTrans = 1, $returnTrans = 1) {

//Main Check required to see if main_config language is actually not english.
	global $lang;

	if (!isset($_SESSION)) {
		session_start();
	}

	if (isset($_SESSION['lang'])) {
		$lang = $_SESSION['lang'];
	}
	if ($lang == "en") {
		$sendTrans = 0;
		if ($returnTrans == 1) {
			$returnTrans = 0;
		}
	}

	if ($sendTrans == 1) {
		$translatedQuery = translateQuery($inputquery);
	} else {
		$translatedQuery = $inputquery;
	}

	$result = makeRequest($translatedQuery);

	$translatedResult = translateResult($result, $returnTrans);

	return $translatedResult;
}

function makeRequest($query) {

	global $connect;
	$finalResult = @mysql_query($query, $connect) or die(mysqli_error($connect));
	return $finalResult;

}

function translateQuery($inputquery) {
	global $connect;
//Split query into pieces

	preg_match_all("/[^']+(\w+)/", $inputquery, $keywords);
	$keywords = $keywords[0];

//Remove quotes
	$data   = array();
	$ignore = array("", "*");

	foreach ($keywords as &$key):
		$key = str_replace("'", "", $key);
		$key = str_replace("`", "", $key);

//Ignore Keywords/empty spaces/etc LATER

		if (in_array($key, $ignore)) {
			continue;
		}
		$key1    = utf8_encode($key);
		$sql2    = "SELECT EngText FROM  `spanish` WHERE  `SpanishText` =  '$key1' LIMIT 0 , 1";
		$result2 = @mysql_query($sql2, $connect) or die("Error" . mysqli_error($connect));
		if (mysqli_num_rows($result2) > 0):
			$row        = mysql_fetch_assoc($result2);
			$data[$key] = $row['EngText'];
//Do Replacement
			$inputquery = str_replace($key, $row['EngText'], $inputquery);
		endif;
	endforeach;

//Final Query to be sent.

	return $inputquery;

}

function translateResult($result, $returnTrans = 1) {

	global $connect;
//Translate the Response

	if ($returnTrans == -1) {
		return $result;
	}

	$outputData = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$row1 = array();
		foreach ($row as $key => $value):

			if ($returnTrans == 1) {
				$row1[$key] = translateWord($value);
			} else {

				$row1[$key] = $value;
			}
		endforeach;
		$outputData[] = $row1;

	}

	return $outputData;

}

function translateWord($value, $rev = 0) {

	if (!isset($_SESSION)) {
		session_start();
	}

	if (isset($_SESSION['lang'])) {
		$lang = $_SESSION['lang'];
	}
	if ($lang == "en") {
		return $value;
	}

	global $connect;
	$value = addslashes($value); //To escape the special characters that might come up during translation.
	if ($rev == 1) {
		$sql2 = "SELECT EngText FROM  `spanish` WHERE  `SpanishText` =  '$value' LIMIT 0 , 1";
	} else {
		$sql2 = "SELECT SpanishText FROM  `spanish` WHERE  `EngText` =  '$value' LIMIT 0 , 1";
	}

	$result2 = @mysql_query($sql2, $connect) or die(mysqli_error($connect));
	if (mysqli_num_rows($result2) > 0) {
		$row = mysql_fetch_assoc($result2);

		if ($rev == 1) {
			return utf8_decode($row['EngText']);
		} else {
			return utf8_decode($row['SpanishText']);
		}

	} else {
		return $value;
	}
}

?>
