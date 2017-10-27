<div id="relative">
<?php

$service_id = $_REQUEST['service_id'];

$sql = "SELECT relative.*, service_relative.service_relative_id checked,
DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(from_days(DATEDIFF(now(),birthday)),'%Y')+0 as age
FROM
relative 
LEFT JOIN service_relative ON (relative.relative_id = service_relative.relative_id AND service_id = $service_id)
WHERE 
contact_id = $contact_id
ORDER BY
relative.fname;";
$rs  = $db->selectQuery($sql);

	// SHORTEN STRING
	function shorten_string($string, $amount)
	{
	 if(strlen($string) > $amount)
	{
		$string = trim(substr($string, 0, $amount))."...";
	}
	return $string;
	}

$html = "<font color='red'>*</font>Select relative: <span class='errorValidationRelative'></span>
<table id='relatives_table' class='tablesorter'>
<thead><tr>
		<th><input type='checkbox' id='checkAllrelative'></th>
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
	$checked		 	 = mysql_result($rs, $i,"checked");
	
	// checkbox checked?!
		for($v=0; $v < mysql_numrows($rs); $v++)
		{
			if($checked != '')
			$checked = "checked";
			else
			$checked = '';	
		}
		
	$html .= "<tr>
			<td><center><input type='checkbox' class='checkrelative' name='relative[]' value='$relative_id' $checked></center></td>
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

$deceased = "SELECT deceased.*, service_deceased.service_deceased_id checked,
DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(`death_date_lunar`, '%b %d, %Y') eastDate_us, DATE_FORMAT(`death_date_solar`, '%b %d, %Y') westDate_us, DATE_FORMAT(from_days(DATEDIFF(death_date_solar,birthday)),'%Y')+0 as age_west
FROM
deceased 
LEFT JOIN service_deceased ON (deceased.deceased_id = service_deceased.deceased_id AND service_id = $service_id)
WHERE 
contact_id = $contact_id
ORDER BY
deceased.fname";
			
$result = $db->selectQuery($deceased);

$html = "<font color='red'>*</font>Select Deceased: <span class='errorValidationDeceased'></span>
<table id='deceased_table' class='tablesorter'>
<thead><tr>
		<th rowspan='2'><input type='checkbox' id='checkAllDeceased' /></th>
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
	$checked		 	 = mysql_result($result, $i,"checked");
		
		// checkbox checked?!
		
			if($checked != '')
			$checked = "checked";
			else
			$checked = '';	
		
	$html .= "<tr>
			<td><input type='checkbox' class='checkDeceased' name='deceased[]' value='$deceased_id' $checked></td>
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
