<?php include ( "../header.php" ); ?>
<script language="javascript">
	$(document).ready(function()
	{
	
	// ajax
	$("#service_edit").click(function(e){
	       e.preventDefault();		   
			$.ajax({
				url:'/db_temple/service/service_edit.php?service_id=<?php $service_id = $_REQUEST["service_id"]; echo $service_id; ?>&contact_id=<?php $contact_id = $_REQUEST['contact_id']; echo $contact_id;?>',
				cache:false,
				success: function(html){
					$(".ui-tabs-panel:visible").html(html);
				}
			});
		});
		
    $("#cancelButton_service_details").click(function (e){
        e.preventDefault();
        $.ajax({
            url:"/db_temple/service/service_view.php?contact_id=<?php echo $contact_id;?>",
            cache:false,
			success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });
	
	
		// select option
	<?php
		$service_type_id = $_REQUEST['service_type_id'];
				
		if($service_type_id=="1"){
			$rel="show";
			$dec="hide";
			$oth="hide";
		} 
		else if ($service_type_id=="2"){
			$rel="hide";
			$dec="show";
			$oth="hide";
		}
		else if ($service_type_id=="3"){
			$rel="show";
			$dec="show";
			$oth="hide";
		}
		else if ($service_type_id=="4"){
			$rel="show";
			$dec="show";
			$oth="hide";
		}
		else if ($service_type_id=="100"){
			$rel="show";
			$dec="show";
			$oth="show";
		}
		?>	
			$("#relative").<?php echo $rel?>();
			$("#deceased").<?php echo $dec?>();
			$(".other_input").<?php echo $oth?>();
  
  // tablesorter
    $("#relatives_table").tablesorter({
        widgets: ['zebra'],
		headers: { 5: { sorter: "shortDate" }
			}
    });
		$("#deceased_table").tablesorter({
        widgets: ['zebra'],
		headers: { 5: { sorter: "shortDate" }, 
				   6: { sorter: false}, 		
				   10: { sorter: false}, 11: { sorter: false},  		
				 		
			}
    });
});

</script>
</head>
<?php 
include ("../../classMySql.php");
include ("../config.php");
 
$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$dec = "SELECT *, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us
		FROM service
		LEFT JOIN service_deceased
		ON service.service_id = service_deceased.service_id
		LEFT JOIN deceased
		ON deceased.deceased_id = service_deceased.deceased_id
		LEFT JOIN service_type
		ON service.service_type_id = service_type.service_type_id
		WHERE service.service_id=$service_id";
		
$rs = $db->selectQuery($dec);	
 
for ($i=0; $i < mysql_numrows($rs); $i++)
 
 {
	$service_id			 = mysql_result($rs, $i,"service_id");
	$title				 = mysql_result($rs, $i,"title");
	$service_type		 = mysql_result($rs, $i,"service_type");
	$service_type_id	 = mysql_result($rs, $i,"service_type_id");
	$start_date			 = mysql_result($rs, $i,"startDate_us"); /* see DATE_FORMAT above */
	$end_date			 = mysql_result($rs, $i,"endDate_us");
	$dec_fname			 = mysql_result($rs, $i,"fname");
	$dec_lname			 = mysql_result($rs, $i,"lname");
	$note		 		 = mysql_result($rs, $i,"note");
 
 	$rel = mysql_query("SELECT *, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us
		FROM service
		LEFT JOIN service_relative
		ON service.service_id = service_relative.service_id
		LEFT JOIN relative
		ON relative.relative_id = service_relative.relative_id
		WHERE service.service_id=$service_id");

	// to display first names relative	
	$storeArray = Array();
	while ($fname = mysql_fetch_array($rel, MYSQL_ASSOC)) {
    $storeArray[] =  $fname['fname'];  
	}
	$relative = implode(", ",$storeArray);	
	// other title
	if($service_type_id=='100'){
		$service_type=$title;
	}
} 
  $ble="";$pra="";$fun="";$inv="";$oth="";
	if($service_type_id=="1"){
		$ble="selected";
	} 
	else if ($service_type_id=="2"){
		$pra="selected";
	}
	else if ($service_type_id=="3"){
		$fun="selected";
	}
	else if ($service_type_id=="4"){
		$inv="selected";
	}
	else if ($service_type_id=="100"){
	$oth="selected";
}
 echo "<table cellpadding='5em' id='details_header'>
			<tr><th width='130px'>Service Type:</th><td><select id='select_type' class='select_type' name='service_type' disabled>
							<option value='1' $ble>$SERVICE_TYPE_1</option>
							<option value='2' $pra>$SERVICE_TYPE_2</option>
							<option value='3' $fun>$SERVICE_TYPE_3</option>
							<option value='4' $inv>$SERVICE_TYPE_4</option>
							<option value='100' $oth>$SERVICE_TYPE_100</option>
						</select></td></tr>
			<tr><th>Start Date:</th><td>$start_date</td></tr>
			<tr><th>End Date:</th><td>$end_date</td</tr>
			<tr><th valign='top'>Note:</th><td>$note</td></tr></tbody></table><br>"; 
?>  
<div id="relative">
<?php

$sql = "SELECT relative.*, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us,DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(from_days(DATEDIFF(now(),birthday)),'%Y')+0 as age
		FROM service
		LEFT JOIN service_relative
		ON service.service_id = service_relative.service_id
		LEFT JOIN relative
		ON relative.relative_id = service_relative.relative_id
		WHERE service.service_id=$service_id";
$rs  = $db->selectQuery($sql);

$html = "Family member(s):
<table id='relatives_table' class='tablesorter'>
<thead><tr>
		<th>First Name</th>
		<th>Middle Name</th>
		<th>Last Name</th>
		<th>Religious Name</th>
		<th>Relationship</th>
		<th>Birth Date</th>
		<th>Gender</th>
		<th>Age</th>
		<th>Note</th>
</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$relative_id		 = mysql_result($rs, $i,"relative_id");
	$fname				 = mysql_result($rs, $i,"fname");
	$mname				 = mysql_result($rs, $i,"mname");
	$lname				 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$birthday_us	   	 = mysql_result($rs, $i,"birthday_us");
	$age			   	 = mysql_result($rs, $i,"age");
	$relationship	   	 = mysql_result($rs, $i,"relationship");
	$gender				 = mysql_result($rs, $i,"gender");
	$note		 		 = mysql_result($rs, $i,"note");
	
	$html .= "<tr>
			<td>$fname</td>
			<td>$mname</td>
			<td>$lname</td>
			<td>$religious_name</td>
			<td>$relationship</td>
			<td>$birthday_us</td>
			<td>$gender</td>	
			<td>$age</td>	
			<td>$note</td></tr>";
}

$html .= "</tbody></table>";

print $html;
?>
</div>
<div id="deceased">
<?php

$deceased = "SELECT deceased.*, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(`death_date_lunar`, '%b %d, %Y') eastDate_us, DATE_FORMAT(`death_date_solar`, '%b %d, %Y') westDate_us, DATE_FORMAT(from_days(DATEDIFF(death_date_solar,birthday)),'%Y')+0 as age_west
			FROM service
			LEFT JOIN service_deceased
			ON service.service_id = service_deceased.service_id
			LEFT JOIN deceased
			ON deceased.deceased_id = service_deceased.deceased_id
			LEFT JOIN service_type
			ON service.service_type_id = service_type.service_type_id
			WHERE service.service_id=$service_id";
			
$result = $db->selectQuery($deceased);

$html = "In remembrance of:
<table id='deceased_table' class='tablesorter'>
<thead><tr>
		<th rowspan='2'>First Name</th>
		<th rowspan='2'>Middle Name</th>
		<th rowspan='2'>Last Name</th>
		<th rowspan='2'>Religious Name</th>
		<th rowspan='2'>Gender</th>
		<th rowspan='2'>Birth Date</th>
		<th colspan='2'>Date of Death</th>
		<th rowspan='2'>Age</th>
		<th rowspan='2'>Photo ID</th>
		<th rowspan='2'>Note</th>
</tr>
<tr>
		<th><font color='maroon'>West</font></th>
		<th><font color='#8a4117'>East</font></th>

		</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($result); $i++)
{
	$deceased_id		 = mysql_result($result, $i,"deceased_id");	
	$contact_id			 = mysql_result($result, $i,"contact_id");	
	$fname				 = mysql_result($result, $i,"fname");
	$mname				 = mysql_result($result, $i,"mname");
	$lname				 = mysql_result($result, $i,"lname");
	$religious_name		 = mysql_result($result, $i,"religious_name");
	$birthday_us	   	 = mysql_result($result, $i,"birthday_us");
	$eastDate_us		 = mysql_result($result, $i,"eastDate_us");
	$westDate_us		 = mysql_result($result, $i,"westDate_us");
	$gender				 = mysql_result($result, $i,"gender");
	$age_west			 = mysql_result($result, $i,"age_west");
	$photo_id			 = mysql_result($result, $i,"photo_id");
	$note				 = mysql_result($result, $i,"note");
		
		
	$html .= "<tr>
			<td>$fname</td>
			<td>$mname</td>
			<td>$lname</td>
			<td>$religious_name</td>
			<td>$gender</td>
			<td>$birthday_us</td>
			<td><font color='maroon'>$westDate_us</font></td>
			<td><font color='#8a4117'>$eastDate_us</font></td>
			<td>$age_west</td>
			<td>$photo_id</td>
			<td>$note</td></tr>";
}

$html .= "</tbody></table>";

print $html;
?>
</div>
<br>
<input type="submit" value=" Back " id="cancelButton_service_details"> <input type="submit" value=" Edit Service" id="service_edit">
