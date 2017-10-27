<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/temple/__jquery.tablesorter/jquery.tablesorter.min.js"></script> 
<script type="text/javascript" src="/temple/validate/jquery.validate.js"></script>
<link type="text/css" rel="stylesheet" href="/temple/css.css" />

<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id = '9';
$cb_results = 'khoi,jane,john';

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = "SELECT *, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us FROM tb_service WHERE contact_id=$contact_id";
$rs = $db->selectQuery($sql);

$html = "<table id='service_table' class='tablesorter'>
<thead><tr>
		<th>Title</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Deceased</th>
		<th>Relatives</th>
		<th>Note</th>
		<th>Details</th>
		<th>Delete</th>
</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$contact_id = '9'


	
	$html .= "<tr>
			<td>$contact_id</td>
			<td>$start_date</td>
			<td>$end_date</td>
			<td>$deceased</td>
			<td>$cb_results/td>
			<td><div class='ellipsis'>$note</div></td>
			<td><a href='/temple/service/service_details.php?service_id=$service_id' class='service_details'><center><img border='0' src='../images/icons/pencil.png' title='Details'></center></a></td>
			<td><a href='/temple/service/service_delete.php?contact_id=$contact_id&service_id=$service_id' class='service_delete'><center><img border='0' src='../images/icons/cross.png' title='Delete'></center></img></a></td></tr>";		
}

$html .= "</tbody></table>";

print $html;
?>

<a href="#" id="service_new">Add New Service</a>