<?php


$contact_id			 = '9';
$start_date			 = $_POST["start_date"];
$end_date		 	 = $_POST["end_date"];
$title			 	 = $_POST["title"];
$note 		 		 = $_POST["note"];

$relatives = $_POST['relatives'];
	
    if(isset($relatives))
    {
    foreach($relatives as $value){
    $cb_results .= $value.",\n";
	
	/*$insert=mysql_query("INSERT INTO relatives('relatives') VALUES ('$value')");*/
    }
    }


header( "Location: servicehelloview.php?contact_id=9&cb_results=khoi,jane,john" );


?>