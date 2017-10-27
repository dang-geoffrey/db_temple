<link type="text/css" href="/jquery/jquery-ui-1.9.2.custom/css/custom-theme/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
<script>

$(document).ready(function()
	{
	
	 $("#deceased_edit").click(function(e)
	 {
	       e.preventDefault();		   
			$.ajax(
			{
				url:'/db_temple/deceased/deceased_edit.php?deceased_id=<?php  $deceased_id = $_REQUEST["deceased_id"]; echo $deceased_id; ?>',
				success: function(html)
				{
					$(".ui-tabs-panel:visible").html(html);
				}
			});
		});
	   
	   $("#cancelButton").click(function (e){
        e.preventDefault();
        $.ajax({
            url:"/db_temple/deceased/deceased_view.php?contact_id=<?php echo $_REQUEST['contact_id'];?>",
            cache:false,
			success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });	
});
 </script>
 
 <?php 
 include ("../../classMySql.php");
 include ("../config.php");
  
 $db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
 $sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(`death_date_lunar`, '%b %d, %Y') eastDate_us, DATE_FORMAT(`death_date_solar`, '%b %d, %Y') westDate_us  FROM deceased WHERE deceased_id = $deceased_id";
 
 $rs = $db->selectQuery($sql);
 
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
	$westDate_us	 	 = mysql_result($rs, $i,"westDate_us");
	$gender				 = mysql_result($rs, $i,"gender");
	$photo_id			 = mysql_result($rs, $i,"photo_id");
	$note				 = mysql_result($rs, $i,"note");
 
} 
 
 echo "<table cellpadding='5em' id='details_header'>
			<tr><th width='190px'>Name:</th><td>$fname $mname $lname</td></tr>
			<tr><th>Religious Name:</th><td>$religious_name</td></tr>
			<tr><th>Birthdate:</th><td>$birthday_us</td</tr>
			<tr><th>Date of Death (West):</th><td>$westDate_us</td</tr>
			<tr><th>Date of Death (East):</th><td>$eastDate_us</td</tr>
			<tr><th>Gender:</th><td>$gender</td</tr>
			<tr><th>Photo ID:</th><td>$photo_id</td</tr>
			<tr><th valign='top'>Note:</th><td>$note</td</tr></table>"; ?> 
<br /><br />
	<td><input type="submit" value=" Back " id="cancelButton" /> <input type="submit" id="deceased_edit" value=" Edit Deceased ">