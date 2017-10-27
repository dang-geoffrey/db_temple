<!DOCTYPE HTML>
<title>Search Deceased Members</title>
<?php

include("../header.php"); 
include("../vertical_menu.php"); 

$full_name = $_POST['full_name'];

echo "<div id='wrapper'>
		<div class='content'>
			<span class='headline'>Search Deceased Members</span><br>";

include("../../classMySql.php");
include("../config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(`death_date_lunar`, '%b %d, %Y') eastDate_us, DATE_FORMAT(`death_date_solar`, '%b %d, %Y') westDate_us, DATE_FORMAT(`death_date_lunar`, '%Y') - DATE_FORMAT(`birthday`, '%Y') age_east, DATE_FORMAT(from_days(DATEDIFF(death_date_solar,birthday)),'%Y')+0 as age_west
		FROM deceased
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

$html = "<table id='deceased_table' class='tablesorter'>
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
				<th rowspan='2'>Details</th>
			</tr>
		<tr>
			<th><font color='maroon'>West</font></th>
			<th><font color='#8a4117'>East</font></th>
		</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{
	$deceased_id		 = mysql_result($rs, $i,"deceased_id");	
	$contact_id			 = mysql_result($rs, $i,"contact_id");	
	$fname				 = mysql_result($rs, $i,"fname");
	$mname				 = mysql_result($rs, $i,"mname");
	$lname				 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$birthday_us	   	 = mysql_result($rs, $i,"birthday_us");
	$eastDate_us		 = mysql_result($rs, $i,"eastDate_us");
	$westDate_us		 = mysql_result($rs, $i,"westDate_us");
	$gender				 = mysql_result($rs, $i,"gender");
	$age_east			 = mysql_result($rs, $i,"age_east");
	$age_west			 = mysql_result($rs, $i,"age_west");
	$photo_id			 = mysql_result($rs, $i,"photo_id");
	$note				 = mysql_result($rs, $i,"note");

	$note = shorten_string($note, $NOTE_LENGTH);

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
			<td>$note</td>
			<td><a class='deceased_details' href='/../deceased/deceased_details.php?deceased_id=$deceased_id&contact_id=$contact_id' ><center><img border='0' src='../images/icons/pencil.png' title='Details'></center></a></td></tr>";		
}

$html .= "</tbody></table>";

print "$html
</div>
</div>";
include("../footer.php");

?>

<script>
	
	 $(document).ready(function () { 
		
		 // tablesorter
    $("#deceased_table").tablesorter({
        // pass the headers argument and passing an object 
        widgets: ['zebra'],
		dateFormat : "mmddyyyy",
        headers: {
			5: { sorter: "shortDate" },	12: { sorter: false},
			13: { sorter: false }, 14: { sorter: false },
			15: { sorter: false }, 6: { sorter: false },
			10: { sorter: false }, 11: { sorter: false }, 
        }
    });
    });
</script>