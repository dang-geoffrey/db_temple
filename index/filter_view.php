<!DOCTYPE HTML>
<title>Filter View</title>
<?php 

include ("../header.php"); 
include ("../vertical_menu.php"); 

include ("../../classMySql.php");
include ("../config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$date_death	  = $_REQUEST['date_death'];
$calendar 	  = $_REQUEST['calendar'];

echo "<div class='content'>
		<span class='headline'>View Date of Deceased</span><br>";

if ($calendar == 'west'){

	$type = "DATE_FORMAT(deceased.death_date_solar, '%M %e')";
	$date = "$date_death";
}
else if ($calendar == 'east'){

	$type = "DATE_FORMAT(deceased.death_date_lunar, '%M %e')";
	$date = "$date_death";
}

$sql = "SELECT 
contact.fname cfname, contact.mname cmname, contact.lname clname, contact.email, contact.phone,
deceased.fname dfname, deceased.mname dmname, deceased.lname dlname, DATE_FORMAT(deceased.death_date_lunar, '%M %e, %Y') dd_east, DATE_FORMAT(deceased.death_date_solar,'%M %e, %Y') dd_west
FROM
contact
LEFT JOIN deceased ON (contact.contact_id = deceased.contact_id)
WHERE ". $type . " = '" . $date . "'";

$rs = $db->selectQuery($sql);	

if (mysql_numrows($rs) == 0){
	print "No record found.";
}
else{

$html = "";
for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$con_fname				 = mysql_result($rs, $i,"cfname");
	$con_mname				 = mysql_result($rs, $i,"cmname");
	$con_lname				 = mysql_result($rs, $i,"clname");
	$phone					 = mysql_result($rs, $i,"phone");
	$email					 = mysql_result($rs, $i,"email");
	
	$dec_fname				 = mysql_result($rs, $i,"dfname");
	$dec_mname				 = mysql_result($rs, $i,"dmname");
	$dec_lname				 = mysql_result($rs, $i,"dlname");	
	$dd_west 				 = mysql_result($rs, $i,"dd_west");	
	$dd_east 				 = mysql_result($rs, $i,"dd_east");	

	if($calendar =='west'){
		$dd_type = $dd_west;
	}
	else if($calendar =='east'){
		$dd_type = $dd_east;
	}
	
$html .= "<div class='menu-block'>
			<div class='display-menu-con display-header-con'>
				<ul class='today'><li><span>Name:</span>$con_fname $con_mname $con_lname</li>
						<li><span>Phone Number:</span>$phone</li>
						<li><span>Email:</span>$email</li>
				</ul>
			</div>
				<div class='display-menu-dec display-header-dec'>
					<table class='header'>
						<tr>
							<td>Name:</td>
							<td>$dec_fname $dec_mname $dec_lname</td>
						</tr>
						<tr>
							<td>Died:</td>
							<td>$dd_type</td>
						</tr>
					</table>
				</div>
		 </div>";
}

echo $html;
}
echo "</div>";
include ("../footer.php"); 
?>