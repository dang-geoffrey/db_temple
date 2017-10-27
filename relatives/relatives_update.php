<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id			  = $_POST["contact_id"];
$relative_id		  = $_POST["relative_id"];
$fname 				  = $_POST["fname"];
$mname			 	  = $_POST["mname"];
$lname			 	  = $_POST["lname"];
$religious_name		  = $_POST["religious_name"];
$relationship		  = $_POST["relationship"];
$gender 			  = $_POST["gender"];
$note				  = $_POST["note"];

$bd					 = $_POST["birthday"];
$birthday	 = dateFormatMysql($bd);
function dateFormatMysql($date)
{
	$timestamp = strtotime($date); 
	$mysqlDate = date('Y-m-d', $timestamp);

	return $mysqlDate;

}

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "UPDATE relative SET 	fname = \"$fname\",
				mname = \"$mname\",
				lname = \"$lname\",
				religious_name = \"$religious_name\",
				relationship = \"$relationship\",
				birthday = \"$birthday\",
				gender = \"$gender\",
				note = \"$note\"
		WHERE relative_id=$relative_id LIMIT 1";
$db->query($sql);


header( "Location: relatives_view.php?contact_id=".$contact_id );

?>

