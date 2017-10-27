<!DOCTYPE HTML>
<html lang="en">

    
   
        <form id="service_save" action='servicehello.php' method=post>
            <table border="0" cellpadding="5">
                <tr>
                    <td align="right" width="100px"><font color="red">*</font>Start Date:</td>
                    <td>
                        <input type="text" class="required" name="start_date" id="datepicker_start">
                    </td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>End Date:</td>
                    <td>
                        <input type="text" class="required" name="end_date" id="datepicker_end">
                    </td>
                </tr>
				<tr>
                    <td align='right'><font color="red">*</font>Service Type:</td>
                    <td>
                        <select id="select_type" class="select_type" name="title">
							<option>Please Select</option>
							<option>Blessing</option>
							<option>Prayer</option>
							<option>Funeral</option>
							<option>Invocation</option>
							<option>Other</option>
						</select>&nbsp;&nbsp;<span class="other_input"><input type="text"></span>
                    </td>
					
                </tr>
				<tr>
					<td align='right'>Note:</td>
					<td>
						<textarea valign="top" rows="3" cols="1" name="note"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><div id="tb_relatives">
<?php
require_once ("../../classMySql.php");
require_once ("../config.php");

$contact_id = '9';

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = "SELECT *, DATE_FORMAT(birthdate, '%b %d, %Y') birthdate_us, DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(birthdate,'%Y') age FROM tb_relatives WHERE contact_id=$contact_id";
$rs  = $db->selectQuery($sql);

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
</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input id="cancelButton_service_new" type="submit" value=" Cancel " />&nbsp;
						<input id="saveButton_service_new" type="submit" value=" Save " class="disableSubmit" />
					</td>
				</tr>
            </table>
        </form>
    </body>
</html>