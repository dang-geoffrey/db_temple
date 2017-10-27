<?php include ( "header.php" ); ?>
<?php include ("vertical_menu.php"); ?>
<title>List All Services</title>
<script>
$(document).ready(function () { 
		
	 // tablesorter
    $("#table").tablesorter({
        widgets: ['zebra'],
        
    });
});
</script>
<div class="content">
<span class="headline">List All Services</span>
<?php
include ("../classMySql.php");
include ("config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = "SELECT 
service.service_id,
service_type, 
title, service.service_type_id,
CAST(service.note AS CHAR) service_note,
DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us,
CAST(service.note AS CHAR) service_note,
GROUP_CONCAT(DISTINCT CONCAT('-', deceased.fname, ' ', deceased.mname, ' ', deceased.lname)  SEPARATOR '<br> ') nameDeceased,
GROUP_CONCAT(DISTINCT CONCAT('-', relative.fname, ' ', relative.mname, ' ', relative.lname)  SEPARATOR '<br> ') nameRelative

FROM service 

LEFT JOIN service_type  	ON (service.service_type_id = service_type.service_type_id)	

LEFT JOIN service_deceased 	ON (service.service_id = service_deceased.service_id)
LEFT JOIN deceased			ON (deceased.deceased_id = service_deceased.deceased_id)

LEFT JOIN service_relative 	ON (service.service_id = service_relative.service_id)
LEFT JOIN relative			ON (relative.relative_id = service_relative.relative_id)

GROUP BY 

service.service_id

ORDER BY service.service_id DESC";
		
$rs = $db->selectQuery($sql);	
	
$html = "<table id='table' class='tablesorter'>
<thead><tr>
		<th>ID</th>
		<th>Service Type</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Deceased</th>
		<th>Relative(s)</th>
		<th>Note</th>
</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$service_id			 = mysql_result($rs, $i,"service_id");
	$title				 = mysql_result($rs, $i,"title");
	$service_type		 = mysql_result($rs, $i,"service_type");
	$start_date			 = mysql_result($rs, $i,"startDate_us"); /* see DATE_FORMAT above */
	$end_date			 = mysql_result($rs, $i,"endDate_us");
	$deceased_name		 = mysql_result($rs, $i,"nameDeceased");
	$relative_name		 = mysql_result($rs, $i,"nameRelative");
	$service_note 		 = mysql_result($rs, $i,"service_note");
	$service_type_id	 = mysql_result($rs, $i,"service_type_id");
	
	if($service_type=="Other"){
		$service_type=$title;
		}
	
	$html .= "<tr>
			<td>$service_id</td>
			<td>$service_type</td>
			<td>$start_date</td>
			<td>$end_date</td>
			<td>$deceased_name</td>
			<td>$relative_name</td>
			<td><div class='ellipsis'>$service_note</div></td>
		</tr>";
}

$html .= "</tbody></table>";

print $html;


?>
</div>
<?php include ("footer.php"); ?>