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

$service_type_id	 = $_POST["service_type"];
$title 				 = $_POST['title'];

// start/end date function into sql format yyyy-mm-dd
$sd					 = $_POST["start_date"];
$start_date 		 = dateFormatMysql($sd);
function dateFormatMysql($date)
{
	$timestamp = strtotime($date); 
	$mysqlDate = date('Y-m-d', $timestamp);

	return $mysqlDate;

}
$ed				 	 = $_POST["end_date"];
$end_date		 	 = dateFormatMysql($ed);

$title				 = $_POST["title"];
$note 		 		 = $_POST["note"];

$sql = "INSERT INTO service (contact_id, service_type_id, start_date, end_date, title, note) VALUES (\"$contact_id\", \"$service_type_id\", \"$start_date\", \"$end_date\", \"$title\", \"$note\")";
$service_id=$db->insertRowSql($sql);

	if($service_type_id=="1"){
		// rel
		$relative_id		= $_POST['relative'];
		$relative = "INSERT into service_relative (service_id, relative_id) VALUES ";
		for($i=0; $i<count($relative_id); $i++)
		{
			$relative .= "($service_id, $relative_id[$i]),";
		}
		$rel=rtrim($relative,",");  // trims off last comma of last entry

		$db->query($rel);
		}
	else if($service_type_id=="2"){ 
		//deceased
		$deceased_id		= $_POST['deceased'];
		$deceased = "INSERT into service_deceased (service_id, deceased_id) VALUES ";
		for($i=0; $i<count($deceased_id); $i++)
		{
			$deceased .= "($service_id, $deceased_id[$i]),";
		}
		$dec=rtrim($deceased,",");  // trims off last comma of last entry

		$db->query($dec);
		}
	else if($service_type_id=="3"){
		// rel
		$relative_id		= $_POST['relative'];
		$relative = "INSERT into service_relative (service_id, relative_id) VALUES ";
		for($i=0; $i<count($relative_id); $i++)
		{
			$relative .= "($service_id, $relative_id[$i]),";
		}
		$rel=rtrim($relative,",");  // trims off last comma of last entry

		$db->query($rel);
		//deceased
		$deceased_id		= $_POST['deceased'];
		$deceased = "INSERT into service_deceased (service_id, deceased_id) VALUES ";
		for($i=0; $i<count($deceased_id); $i++)
		{
			$deceased .= "($service_id, $deceased_id[$i]),";
		}
		$dec=rtrim($deceased,",");  // trims off last comma of last entry

		$db->query($dec);

		}
	else if($service_type_id=="4"){
		// rel
		$relative_id		= $_POST['relative'];
		$relative = "INSERT into service_relative (service_id, relative_id) VALUES ";
		for($i=0; $i<count($relative_id); $i++)
		{
			$relative .= "($service_id, $relative_id[$i]),";
		}
		$rel=rtrim($relative,",");  // trims off last comma of last entry

		$db->query($rel);
		//deceased
		$deceased_id		= $_POST['deceased'];
		$deceased = "INSERT into service_deceased (service_id, deceased_id) VALUES ";
		for($i=0; $i<count($deceased_id); $i++)
		{
			$deceased .= "($service_id, $deceased_id[$i]),";
		}
		$dec=rtrim($deceased,",");  // trims off last comma of last entry

		$db->query($dec);
		}	
	else if($service_type_id=="100"){
		// other
		
		// rel
		$relative_id		= $_POST['relative'];
		$relative = "INSERT into service_relative (service_id, relative_id) VALUES ";
		for($i=0; $i<count($relative_id); $i++)
		{
			$relative .= "($service_id, $relative_id[$i]),";
		}
		$rel=rtrim($relative,",");  // trims off last comma of last entry

		$db->query($rel);
		//deceased
		$deceased_id		= $_POST['deceased'];
		$deceased = "INSERT into service_deceased (service_id, deceased_id) VALUES ";
		for($i=0; $i<count($deceased_id); $i++)
		{
			$deceased .= "($service_id, $deceased_id[$i]),";
		}
		$dec=rtrim($deceased,",");  // trims off last comma of last entry

		$db->query($dec);
		}	

header( "Location: service_view.php?contact_id=".$contact_id );
?>