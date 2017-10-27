<?php

include ("../../classMySql.php");
include ("../config.php");

$donation_id		 = $_REQUEST["donation_id"];
$contact_id			 = $_REQUEST["contact_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "DELETE FROM donation WHERE donation_id=$donation_id LIMIT 1";
$db->query($sql);

header( "Location: donations_view.php?contact_id=".$contact_id);

?>

