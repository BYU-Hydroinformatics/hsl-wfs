<?php
//check authority to be here
require_once 'authorization_check.php';

$MetaID = $_GET['MetadataID2'];
$md_tc = $_GET['TopicCategory2'];
$md_title = $_GET['Title2'];
$md_ab = $_GET['Abstract2'];
$md_pv = $_GET['ProfileVersion2'];
$md_link = $_GET['MetadataLink2'];

//All queries go through a translator. 
require_once 'DBTranslator.php';

//Update the fields for the MetadataID # provided
if ($md_link==''){
	
	$sql_updater ="UPDATE isometadata SET TopicCategory='$md_tc',Title='$md_title',Abstract='$md_ab',ProfileVersion='$md_pv',MetadataLink=NULL WHERE MetadataID='$MetaID'";
	
}else{
	
	$sql_updater ="UPDATE isometadata SET TopicCategory='$md_tc',Title='$md_title',Abstract='$md_ab',ProfileVersion='$md_pv',MetadataLink='$md_link' WHERE MetadataID='$MetaID'";
};

$result_updater = transQuery($sql_updater,1,-1);

echo ($result_updater);

?>