<?php

include ("../../classMySql.php");
include ("../config.php");


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
$sql = "INSERT INTO contact (fname, mname, lname, religious_name, address, city, state, zipcode, phone, email, note) VALUES(\"$fname\", \"$mname\", \"$lname\", \"$religious_name\", \"$address\", \"$city\", \"$state\", \"$zipcode\", \"$phone\", \"$email\", \"$note\")";
$db->query($sql);

header( 'Location: contact_view.php' );



?>