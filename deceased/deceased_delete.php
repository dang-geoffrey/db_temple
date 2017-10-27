<?php

include ("../../classMySql.php");
include ("../config.php");

$deceased_id		 = $_REQUEST["deceased_id"];
$contact_id			 = $_REQUEST["contact_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "DELETE FROM deceased WHERE deceased_id=$deceased_id LIMIT 1";
$db->query($sql);

header( "Location: deceased_view.php?contact_id=".$contact_id);

?>

