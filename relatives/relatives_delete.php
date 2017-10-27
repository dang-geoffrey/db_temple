<?php

include ("../../classMySql.php");
include ("../config.php");

$relative_id		 = $_REQUEST["relative_id"];
$contact_id			 = $_REQUEST["contact_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "DELETE FROM relative WHERE relative_id=$relative_id LIMIT 1";
$db->query($sql);

header( "Location: relatives_view.php?contact_id=".$contact_id);

?>

