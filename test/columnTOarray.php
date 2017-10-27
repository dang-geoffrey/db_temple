<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id = 10;

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$dec = "SELECT *, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us
		FROM tb_service
		LEFT JOIN tb_service_deceased
		ON tb_service.service_id = tb_service_deceased.service_id
		LEFT JOIN deceased
		ON deceased.deceased_id = tb_service_deceased.deceased_id
		WHERE tb_service.contact_id=$contact_id";
		
$rel = mysql_query("SELECT *, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us
		FROM tb_service
		LEFT JOIN tb_service_relative
		ON tb_service.service_id = tb_service_relative.service_id
		LEFT JOIN tb_relatives
		ON tb_relatives.relatives_id = tb_service_relative.relative_id
		WHERE tb_service.contact_id=$contact_id");

		
$rs = $db->selectQuery($dec);


$storeArray = Array();
while ($fname = mysql_fetch_array($rel, MYSQL_ASSOC)) {
    $storeArray[] =  $fname['fname'];  
}
echo implode(", ",$storeArray);	
?>
