<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id			 = $_POST["contact_id"];
$fname				 = $_POST["fname"];
$mname				 = $_POST["mname"];
$lname				 = $_POST["lname"];
$religious_name		 = $_POST["religious_name"];
$address		 	 = $_POST["address"];
$city			 	 = $_POST["city"];
$state			 	 = $_POST["state"];
$zipcode		 	 = $_POST["zipcode"];
$phone		 	 	 = $_POST["phone"];
$email			 	 = $_POST["email"];
$note		 = $_POST["note"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "UPDATE contact SET 	fname = \"$fname\",
				mname = \"$mname\",
				lname = \"$lname\",
				religious_name = \"$religious_name\",
				address = \"$address\",
				city = \"$city\",
				state = \"$state\",
				zipcode = \"$zipcode\",
				phone = \"$phone\",
				email = \"$email\",
				note = \"$note\",
				date_update = NOW()
		WHERE contact_id=$contact_id LIMIT 1";
$db->query($sql);


header( "Location: contact_view_row.php?contact_id=".$contact_id );

?>

