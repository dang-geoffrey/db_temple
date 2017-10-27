<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id			  = $_POST["contact_id"];
$deceased_id		  = $_POST["deceased_id"];
$fname 				  = $_POST["fname"];
$mname			 	  = $_POST["mname"];
$lname			 	  = $_POST["lname"];
$religious_name		  = $_POST["religious_name"];
$gender 			  = $_POST["gender"];
$photo_id 			  = $_POST["photo_id"];
$note		  		  = $_POST["note"];
// date function into sql format yyyy-mm-dd
$bd					 = $_POST["birthday"];
$birthday			 = dateFormatMysql($bd);
$lunar				 = $_POST["death_date_lunar"];
$death_date_lunar	 = dateFormatMysql($lunar);
$solar				 = $_POST["death_date_solar"];
$death_date_solar 	 = dateFormatMysql($solar);
function dateFormatMysql($date)
{
	$timestamp = strtotime($date); 
	$mysqlDate = date('Y-m-d', $timestamp);

	return $mysqlDate;

}

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "UPDATE deceased SET 	fname = \"$fname\",
				mname = \"$mname\",
				lname = \"$lname\",
				religious_name = \"$religious_name\",
				birthday = \"$birthday\",
				death_date_lunar = \"$death_date_lunar\",
				death_date_solar = \"$death_date_solar\",
				gender = \"$gender\",
				photo_id = \"$photo_id\",
				note = \"$note\"
			
		WHERE deceased_id=$deceased_id LIMIT 1";
$db->query($sql);


header( "Location: deceased_view.php?contact_id=".$contact_id );

?>

