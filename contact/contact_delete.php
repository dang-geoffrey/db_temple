<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id		 = $_REQUEST["contact_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "DELETE FROM contact WHERE contact_id=$contact_id LIMIT 1";
$db->query($sql);


header( 'Location: contact_view.php' );

?>

