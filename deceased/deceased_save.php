<?php

include ("../../classMySql.php");
include ('../config.php');

$contact_id			 = $_REQUEST["contact_id"];
$fname 				 = $_POST["fname"];
$mname			 	 = $_POST["mname"];
$lname			 	 = $_POST["lname"];
$religious_name		 = $_POST["religious_name"];
$gender 			 = $_POST["gender"];
$photo_id 			 = $_POST["photo_id"];$note 				 = $_POST["note"];

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
$sql = "INSERT INTO deceased (contact_id, fname, mname, lname, religious_name, birthday, death_date_lunar, death_date_solar, gender, photo_id, note) VALUES (\"$contact_id\", \"$fname\", \"$mname\", \"$lname\", \"$religious_name\", \"$birthday\", \"$death_date_lunar\", \"$death_date_solar\", \"$gender\", \"$photo_id\", \"$note\")";

$db->query($sql);

header( "Location: deceased_view.php?contact_id=".$contact_id );


?>