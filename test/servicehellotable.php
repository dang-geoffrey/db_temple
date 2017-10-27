<div id="tb_relatives">
<?php

$html = "<font color='red'>*</font>Select Relatives:
<table id='relatives_table' class='tablesorter'>
<thead><tr>
		<th><input type='checkbox' id='checkAllRelatives' /></th>
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
	$relatives_id		 = mysql_result($rs, $i,"relatives_id");
	$fname				 = mysql_result($rs, $i,"fname");
	$mname				 = mysql_result($rs, $i,"mname");
	$lname				 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$birthdate_us	   	 = mysql_result($rs, $i,"birthdate_us");
	$age			   	 = mysql_result($rs, $i,"age");
	$relationship	   	 = mysql_result($rs, $i,"relationship");
	$gender				 = mysql_result($rs, $i,"gender");
	$note		 		 = mysql_result($rs, $i,"note");
	
	$html .= "<tr>
			<td><input type='checkbox' class='checkRelatives' name='relatives[]' value='$fname'></td>
			<td>$fname</td>
			<td>$mname</td>
			<td>$lname</td>
			<td>$religious_name</td>
			<td>$relationship</td>
			<td>$birthdate_us</td>
			<td>$gender</td>	
			<td>$age</td>	
			<td>$note</td></tr>";
}

$html .= "</tbody></table>";

print $html;
?>
</div>

