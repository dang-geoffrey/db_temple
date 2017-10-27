<link type="text/css" href="/jquery/jquery-ui-1.9.2.custom/css/custom-theme/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
<script>

$(document).ready(function()
	{
	
	 $("#contact_edit").click(function(e)
	 {
	       e.preventDefault();		   
			$.ajax(
			{
				url:"contact_edit.php?contact_id=<?php  $contact_id = $_REQUEST["contact_id"]; echo $contact_id; ?>",
				success: function(html)
				{
					$(".ui-tabs-panel:visible").html(html);
				}
			});
		});
		
});
 </script>
 
 <?php 
 include ("../../classMySql.php");
 include ("../config.php");
  
 $db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
 $sql = "SELECT * FROM contact WHERE contact_id = $contact_id";
 $rs = $db->selectQuery($sql);
 
 for ($i=0; $i < mysql_numrows($rs); $i++)
 
 {
 	$contact_id		 	 = mysql_result($rs, $i,"contact_id");	
 	$fname			 	 = mysql_result($rs, $i,"fname");
 	$mname			 	 = mysql_result($rs, $i,"mname");
 	$lname			 	 = mysql_result($rs, $i,"lname");
 	$religious_name		 = mysql_result($rs, $i,"religious_name");
 	$address		 	 = mysql_result($rs, $i,"address");
 	$city			 	 = mysql_result($rs, $i,"city");
 	$state			 	 = mysql_result($rs, $i,"state");
 	$zipcode		 	 = mysql_result($rs, $i,"zipcode");
 	$phone		 	 	 = mysql_result($rs, $i,"phone");
 	$email			 	 = mysql_result($rs, $i,"email");
 	$note	 			 = mysql_result($rs, $i,"note");
 
} 
 
 echo "<table cellpadding='5em' id='details_header'>
				  <tr><th>Name:</th><td>$fname $mname $lname</td></tr>
				  <tr><th>Religious Name:</th><td>$religious_name</td></tr>
				  <tr><th>Address:</th><td>$address</td></tr>
				  <tr><th>City:</th><td>$city</td></tr>
				  <tr><th>State:</th><td>$state</td></tr>
				  <tr><th>Zip Code:</th><td>$zipcode</td></tr>
				  <tr><th>Phone:</th><td>$phone</td></tr>
				  <tr><th>E-mail:</th><td>$email</td></tr>
	  <tr><th valign='top'>Note:</th><td>$note</td></tr></table>"; ?> 
<br /><br />
	<input type="submit" id="contact_edit" value=" Edit Contact ">