<?php
//This is required to get the international text strings dictionary
require_once 'internationalize.php';

//All queries go through a translator. 
require_once 'DBTranslator.php';

$varid=$_GET['varid'];

$select = "SELECT * FROM sites WHERE SiteID='$varid'";

$result = transQuery($select,0,1) ;
$data="";

foreach ($result as $row) {
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = ",";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . ",";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{ 
	$data = "\n(0) " + $RecordsFound  + "\n";                      
}

echo($data);
?>