<!DOCTYPE HTML>
<?php 

include ( "header.php" ); 
include ("vertical_menu.php"); 

$day = $_REQUEST['service']; // which link is clicked on

if ($day == 'sunday'){
	echo "<title>Sunday's Services</title>";
	$selection = "Sunday's";
}
else if ($day == 'today'){
	echo "<title>Today's Services</title>";
	$selection = "Today's";
}
else if ($day == 'listall'){
	echo "<title>List All Services</title>";
	$selection = 'List All';
}

echo "<div id='wrapper'>
<div class='container'>
<span class='headline'>" . $selection . " Services</span><img src='images/dotGray.jpg' width=100% height='1px' ><br>";
 
include ("../classMySql.php");
include ("config.php");

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

date_default_timezone_set('America/Los_Angeles');
$day_week = date("D"); // today's day of the week
$str_NextSundayDate = date('Y-m-d', strtotime('next Sunday'));

if($day == 'listall'){
		$where ="";
}
else if ($day == 'today') { 
	
		$where = "WHERE now() BETWEEN start_date and end_date";
}
else if ($day == 'sunday'){  
	if($day_week == 'Sun') { 

		$where = "WHERE now() BETWEEN start_date and end_date";
	}
	else if ($day_week !== 'Sun') {
			
		$where = "WHERE '$str_NextSundayDate' BETWEEN start_date and end_date";
			
	}
}
	$sql = "SELECT 
			contact.fname cfname, contact.mname cmname, contact.lname clname, phone,
			service.*, service_type.*,
			relative.fname rfname, relative.mname rmname, relative.lname rlname, relative.gender rgender, DATE_FORMAT(relative.birthday, '%b %d, %Y') rbirthday, DATE_FORMAT(from_days(DATEDIFF(now(), relative.birthday)),'%Y')+0 as rage,
			deceased.fname dfname, deceased.mname dmname, deceased.lname dlname, DATE_FORMAT(deceased.birthday, '%b %d, %Y') dbirthday, DATE_FORMAT(death_date_solar, '%b %d, %Y') dd_west, deceased.gender dgender, DATE_FORMAT(from_days(DATEDIFF(death_date_solar, deceased.birthday)),'%Y')+0 as dage,


			relative.religious_name relrname, deceased.religious_name reldname, contact.religious_name relcname,
			DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us


			FROM service 

			LEFT JOIN service_type  	ON (service.service_type_id = service_type.service_type_id)	

			LEFT JOIN service_deceased 	ON (service.service_id = service_deceased.service_id)
			LEFT JOIN deceased			ON (deceased.deceased_id = service_deceased.deceased_id)

			LEFT JOIN service_relative 	ON (service.service_id = service_relative.service_id)
			LEFT JOIN relative			ON (relative.relative_id = service_relative.relative_id)

			LEFT JOIN contact		ON (service.contact_id = contact.contact_id)

			" . $where . "
			ORDER BY service.service_id DESC";
$rs = $db->selectQuery($sql);	
$html = "";
for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$con_fname				 = mysql_result($rs, $i,"cfname");
	$con_mname				 = mysql_result($rs, $i,"cmname");
	$con_lname				 = mysql_result($rs, $i,"clname");
	$con_rname				 = mysql_result($rs, $i,"relcname");
	$phone					 = mysql_result($rs, $i,"phone");
	$service_type			 = mysql_result($rs, $i,"service_type");
	$start_date				 = mysql_result($rs, $i,"startDate_us");
	$end_date				 = mysql_result($rs, $i,"endDate_us");
	$serv_other				 = mysql_result($rs, $i,"title");
	
	$dec_fname				 = mysql_result($rs, $i,"dfname");
	$dec_mname				 = mysql_result($rs, $i,"dmname");
	$dec_lname				 = mysql_result($rs, $i,"dlname");	
	$dec_rname				 = mysql_result($rs, $i,"reldname");
	$dbirthday				 = mysql_result($rs, $i,"dbirthday");	
	$dd_west 				 = mysql_result($rs, $i,"dd_west");	
	$dage					 = mysql_result($rs, $i,"dage");	
	$dgender				 = mysql_result($rs, $i,"dgender");	
	
	$rel_fname				 = mysql_result($rs, $i,"rfname");
	$rel_mname				 = mysql_result($rs, $i,"rmname");
	$rel_lname				 = mysql_result($rs, $i,"rlname");	
	$rel_rname				 = mysql_result($rs, $i,"relrname");
	$rgender				 = mysql_result($rs, $i,"rgender");
	$rage 					 = mysql_result($rs, $i,"rage");
	$rbirthday				 = mysql_result($rs, $i,"rbirthday");
		
		$id					 = mysql_result($rs, $i,"service_id");
	
	if($serv_other != ""){
		$serv_other = ": $serv_other";
	}
	else $ser_other = "";
	
	$short = "<div class='menu-block'>
				 <div class='display-menu-con display-header-con'>
					<ul class='today'><li><span>Name:</span>$con_fname $con_mname $con_lname</li>
					<li><span>Religious Name:</span>$con_rname</li>
							<li><span>Phone Number:</span>$phone</li></ul></div>
			     <div class='display-menu-ser display-header-ser'>
					 $service_type" . $serv_other . "<br>
						From $start_date to $end_date</div>
				 <div class='todayContainer'>	
				 <div class='display-menu-dec display-header-dec'>
					<table class='header'>
						<tr>
							<td>Name:</td>
							<td>$dec_fname $dec_mname $dec_lname</td>
						</tr>
						<tr>
							<td>Religious Name:</td>
							<td>$dec_rname</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>$dgender</td>
						</tr>
						<tr>
							<td>Born:</td>
							<td>$dbirthday</td>
						</tr>
						<tr>
							<td>Died:</td>
							<td>$dd_west (aged $dage)</td>
						</tr>
					</table></div>
				 <div class='display-menu-rel display-header-rel'>
					<table class='header'>
						<tr>
							<td>Name:</td>
							<td>$rel_fname $rel_mname $rel_lname</td>
						</tr>
						<tr>
							<td>Religious Name:</td>
							<td>$rel_rname</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>$rgender</td>
						</tr>
						<tr>
							<td>Born:</td>
							<td>$rbirthday (age $rage)</td>
						</tr>
					
				    </table></div>
				</div>
				</div>";
	if ($service_type=="$SERVICE_TYPE_3"){
	$html .= "$short";
	}
	else if($service_type=="$SERVICE_TYPE_1"){
	$html .= "<div class='menu-block'>
				 <div class='display-menu-con display-header-con'>
					<ul class='today'><li><span>Name:</span>$con_fname $con_mname $con_lname</li>
					<li><span>Religious Name:</span>$con_rname</li>
							<li><span>Phone Number:</span>$phone</li></ul></div>
			     <div class='display-menu-ser display-header-ser'>
					 $service_type<br>
						From $start_date to $end_date</div>
				 <div class='todayContainer'>		
				 <div class='display-menu-rel display-header-rel'>
					<table class='header'>
						<tr>
							<td>Name:</td>
							<td>$rel_fname $rel_mname $rel_lname</td>
						</tr>
						<tr>
							<td>Religious Name:</td>
							<td>$rel_rname</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>$rgender</td>
						</tr>
						<tr>
							<td>Born:</td>
							<td>$rbirthday (age $rage)</td>
						</tr>
					
				    </table></div>
					</div>
			  </div>";
	}
	else if($service_type=="$SERVICE_TYPE_2"){
	$html .= "<div class='menu-block'>
				 <div class='display-menu-con display-header-con'>
					<ul class='today'><li><span>Name:</span>$con_fname $con_mname $con_lname</li>
					<li><span>Religious Name:</span>$con_rname</li>
							<li><span>Phone Number:</span>$phone</li></ul></div>
			     <div class='display-menu-ser display-header-ser'>
					 $service_type<br>
						From $start_date to $end_date</div>
				 <div class='todayContainer'>		
				  <div class='display-menu-dec display-header-dec'>
					<table class='header'>
						<tr>
							<td>Name:</td>
							<td>$dec_fname $dec_mname $dec_lname</td>
						</tr>
						<tr>
							<td>Religious Name:</td>
							<td>$dec_rname</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>$dgender</td>
						</tr>
						<tr>
							<td>Born:</td>
							<td>$dbirthday</td>
						</tr>
						<tr>
							<td>Died:</td>
							<td>$dd_west (aged $dage)</td>
						</tr>
					</table></div>
					</div>
			  </div>";
	}
	
	else if ($service_type=="$SERVICE_TYPE_4"){
	$html .= "$short";
	}
	
	else if ($service_type=="$SERVICE_TYPE_100"){
	$html .= "$short";
	}
} 

echo "$html                                                     

</div>
</div>";
include ("footer.php"); 

?>