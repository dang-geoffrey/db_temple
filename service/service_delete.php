<?php

include ("../../classMySql.php");
include ("../config.php");

$service_id	= $_REQUEST["service_id"];
$contact_id = $_REQUEST["contact_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$rd = "DELETE service_relative, service_deceased FROM service

LEFT JOIN service_relative ON (service.service_id = service_relative.service_id)
LEFT JOIN service_deceased ON (service.service_id = service_deceased.service_id)

WHERE service.service_id=$service_id;";

$service = "DELETE FROM service where service_id=$service_id;";

$db->query($rd);
$db->query($service);

header( "Location: service_view.php?contact_id=".$contact_id);

?>
