<?php

include ("../../classMySql.php");
include ('../config.php');

$contact_id			 = $_REQUEST["contact_id"];
$pay_method 		 = $_POST["pay_method"];
$amount			 	 = $_POST["amount"];
$note 				 = $_POST["note"];
$other				 = $_POST['other'];
$d_name				 = $_POST['donations_name'];
$name				 = rtrim(implode(", ", $d_name), ",");

if (in_array("Other", $d_name)){
	$name .= ": $other";
}
$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$don = "INSERT into donation (contact_id, name, amount, pay_method, note) VALUES (\"$contact_id\", \"$name\", \"$amount\", \"$pay_method\", \"$note\")"; 
$db->query($don);

header( "Location: donations_view.php?contact_id=".$contact_id );


?>