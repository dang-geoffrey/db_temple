<?php

$term = $_REQUEST['term'];
$term = trim($term);

include("../../classMySql.php");
include("../config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = " 
	SELECT
	CONCAT_WS(' ', fname, mname, lname) as name
	FROM
	deceased
	WHERE
	LOWER(CONCAT_WS(' ', fname, mname, lname)) LIKE '%$term%'
	ORDER BY name

";

$rs = $db->selectQuery($sql);	

$data = array();
for ($i=0; $i < mysql_numrows($rs); $i++)
{
	$name = mysql_result($rs, $i,"name");

	$data[] = array(
	'value' => $name,
	'label' => $name);
}

print json_encode($data);
?>