<!DOCTYPE HTML > 
<html>
<head>
	<title>Search Contact Members</title>
<?php include("../header.php"); ?>

<script language="javascript">
// table config
$(document).ready(function() { 
    $("table").tablesorter({ 
        widgets: ['zebra'], sortList: [[2,0],[0,0]], headers: { 
            10: { sorter: false }
        } 
    }); 
});
   		
</script>    
</head>

<body>
<?php include("../vertical_menu.php"); ?>
<div id="wrapper">
	<div class="content">
		<span class="headline">Search Contact Members</span><br>
<?php

include("../../classMySql.php");
include("../config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$full_name = $_POST['full_name'];

$sql = "SELECT * FROM contact
		WHERE CONCAT_WS(' ',fname,mname,lname) = '$full_name'";
$rs = $db->selectQuery($sql);

	// SHORTEN STRING
	function shorten_string($string, $amount)
	{
	 if(strlen($string) > $amount)
	{
		$string = trim(substr($string, 0, $amount))."...";
	}
	return $string;
	}
	
$html = "<table class='tablesorter'>
			<thead><tr>
				<th>First Name</th>
				<th>Middle Name</th>
				<th>Last Name</th>
				<th>Religious Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State/Zip Code</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Note</th>	
				<th>Details</th>
		</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{
	$contact_id			 = mysql_result($rs, $i,"contact_id");	
	$fname				 = mysql_result($rs, $i,"fname");
	$mname				 = mysql_result($rs, $i,"mname");
	$lname				 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$address		     = mysql_result($rs, $i,"address");
	$city			     = mysql_result($rs, $i,"city");
	$state			     = mysql_result($rs, $i,"state");
	$zipcode		     = mysql_result($rs, $i,"zipcode");
	$phone		 	     = mysql_result($rs, $i,"phone");
	$email			     = mysql_result($rs, $i,"email");
	$note	    		 = mysql_result($rs, $i,"note");
	
	$note = shorten_string($note, $NOTE_LENGTH);

	$html .= "<tr>
			<td>$fname</td>
			<td>$mname</td>
			<td>$lname</td>
			<td>$religious_name</td>
			<td>$address</td>
			<td>$city</td>
			<td>$state $zipcode</td>
			<td>$phone</td>
			<td>$email</td>
			<td>$note</td>				
			<td><a href='contact_details.php?contact_id=$contact_id'><center><img border='0' src='../images/icons/pencil.png' title='Details'></center></a></td></tr>";		
}

$html .= "</tbody></table>";

print $html;
?>

	</div>
</div>
<?php include("../footer.php"); ?>
</body>
</html>