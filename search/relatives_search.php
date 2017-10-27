<!DOCTYPE HTML>
<title>Search Relative Members</title>
<?php

include("../header.php");
include("../vertical_menu.php"); 

echo "<div id='wrapper'>
		<div class='content'>
			<span class='headline'>Search Relative Members</span><br>";

include("../../classMySql.php");
include("../config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$full_name = $_POST['full_name'];

$sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us, DATE_FORMAT(from_days(DATEDIFF(now(),birthday)),'%Y')+0 as age 
FROM relative
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

$html = "<table id='relatives_table' class='tablesorter'>
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
				<th>Details</th>
		</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$contact_id			 = mysql_result($rs, $i,"contact_id");
	$relative_id		 = mysql_result($rs, $i,"relative_id");
	$fname				 = mysql_result($rs, $i,"fname");
	$mname				 = mysql_result($rs, $i,"mname");
	$lname				 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$birthday_us	   	 = mysql_result($rs, $i,"birthday_us");
	$age 				 = mysql_result($rs, $i,"age");
	$relationship	   	 = mysql_result($rs, $i,"relationship");
	$gender				 = mysql_result($rs, $i,"gender");
	$note		 		 = mysql_result($rs, $i,"note");

	$note = shorten_string($note, 50);

	$html .= "<tr>
			<td>$fname</td>
			<td>$mname</td>
			<td>$lname</td>
			<td>$religious_name</td>
			<td>$relationship</td>
			<td>$birthday_us</td>
			<td>$gender</td>	
			<td>$age</td>	
			<td>$note</td>
			<td><a class='relatives_details' href='/../relatives/relatives_details.php?relative_id=$relative_id&contact_id=$contact_id' ><center><img border='0' src='../images/icons/pencil.png' title='Details'></center></a></td></tr>";		
}

$html .= "</tbody></table>";

print "$html</div></div>";
include("../footer.php");

?>
<script>
	
	 $(document).ready(function () { 
		
		 // tablesorter
    $("#relatives_table").tablesorter({
        // pass the headers argument and passing an object 
        widgets: ['zebra'],
        headers: {
            5: { sorter: "shortDate" }, 9: { sorter: false }, 
			10: { sorter: false },		

        }
    });
});
   
</script>