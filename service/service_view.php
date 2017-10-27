<?php include ( "../header.php" ); ?>

<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id = $_REQUEST['contact_id'];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$dec = "SELECT 
service.service_id,
service_type, 
title, service.service_type_id,
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

WHERE
service.contact_id = $contact_id

GROUP BY 

service.service_id

ORDER BY service.service_id DESC";
		
$rs = $db->selectQuery($dec);	
// SHORTEN STRING
	function shorten_string($string, $amount)
	{
	 if(strlen($string) > $amount)
	{
		$string = trim(substr($string, 0, $amount))."...";
	}
	return $string;
	}	

$html = "<table id='service_table' class='tablesorter'>
<thead><tr>
		<th>ID</th>
		<th>Service Type</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Deceased</th>
		<th>Relative(s)</th>
		<th>Note</th>
		<th>Details</th>
		<th>Delete</th>
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
	
	$service_note = shorten_string($service_note, $NOTE_LENGTH);
	$html .= "<tr>
			<td>$service_id</td>
			<td>$service_type</td>
			<td>$start_date</td>
			<td>$end_date</td>
			<td>$deceased_name</td>
			<td>$relative_name</td>
			<td>$service_note</td>
			<td><a href='/db_temple/service/service_details.php?service_id=$service_id&contact_id=$contact_id&service_type_id=$service_type_id' class='service_details'><img class='service' src='../images/icons/pencil.png' title='Details'></a></td>
			<td><a href='/db_temple/service/service_delete.php?contact_id=$contact_id&service_id=$service_id' class='service_delete'><img class='service' src='../images/icons/cross.png' title='Delete'></img></a></td></tr>";		
}

$html .= "</tbody></table>";

print $html;
?>
<script>
$(document).ready(function () { 
		
	 // tablesorter
    $("#service_table").tablesorter({
        widgets: ['zebra'],
        headers: {
            6: { sorter: false }, 7: { sorter: false },  
		
        }
    });
	// ajax new/details/delete
   $("#service_new").click(function(e) 
	{
		e.preventDefault();
        $.ajax({
            url: "/db_temple/service/service_new.php?contact_id=<?php echo $contact_id;?>",
            type: "POST",
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });

    $(".service_details").click(function(e)
	{
		e.preventDefault(); 
		var service_details = $(this).attr('href');
		$.ajax({
			url: service_details,
			success: function(html) { 
				$('.ui-tabs-panel:visible').html(html)
			}	
		});
   });
	
	$(".service_delete").click(function(e)
		{
			e.preventDefault();
			var service_delete = $(this).attr('href');
			if (confirm('Are you sure you want to delete this service?')) {
			$.ajax({
					url: service_delete,
					type: "post",
					success: function (html) {
						$('.ui-tabs-panel:visible').html(html)
					}
			   }); 
			};		
		});
});
   
</script>

<input type="submit" id="service_new" value=" Add New Service ">