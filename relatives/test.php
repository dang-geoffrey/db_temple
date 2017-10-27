<?php

include ("../../classMySql.php");
include ('../config.php');

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "INSERT INTO tb_relatives (contact_id, fname) VALUES (\"9\", \"khoi\")";
$

$relative_id=$db->insertRowSql($sql);

echo $relative_id;
?>