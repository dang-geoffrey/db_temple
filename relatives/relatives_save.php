<?php

include ("../../classMySql.php");
include ('../config.php');

$contact_id			 = $_REQUEST["contact_id"];
$fname 				 = $_POST["fname"];
$mname			 	 = $_POST["mname"];
$lname			 	 = $_POST["lname"];
$religious_name		 = $_POST["religious_name"];
$relationship		 = $_POST["relationship"];
$gender 			 = $_POST["gender"];
$note 		 		 = $_POST["note"];

$bd					 = $_POST["birthday"];
$birthday	 = dateFormatMysql($bd);
function dateFormatMysql($date)
{
	$timestamp = strtotime($date); 
	$mysqlDate = date('Y-m-d', $timestamp);

	return $mysqlDate;

}

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "INSERT INTO relative (contact_id, fname, mname, lname, religious_name, relationship, birthday, gender, note) VALUES (\"$contact_id\", \"$fname\", \"$mname\", \"$lname\", \"$religious_name\", \"$relationship\", \"$birthday\", \"$gender\", \"$note\")";

$db->query($sql);

header( "Location: relatives_view.php?contact_id=".$contact_id );


?>