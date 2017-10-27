<link type="text/css" rel="stylesheet" href="../css.css" />
<script language="javascript">
$(document).ready(function()
	{
	
	 $("#relatives_edit").click(function(e){
	       e.preventDefault();		   
			$.ajax({
				url:'/db_temple/relatives/relatives_edit.php?relative_id=<?php $relative_id = $_REQUEST["relative_id"]; echo $relative_id; ?>',
				cache:false,
				success: function(html){
					$(".ui-tabs-panel:visible").html(html);
				}
			});
		});
	$("#cancelButton").click(function (e) {
      e.preventDefault();
      $.ajax({
          url: "/db_temple/relatives/relatives_view.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
          cache: false,
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
 $sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us FROM relative WHERE relative_id = $relative_id";
 $rs = $db->selectQuery($sql);
 
 for ($i=0; $i < mysql_numrows($rs); $i++)
 
 {
	$relative_id		 = mysql_result($rs, $i,"relative_id");
	$fname				 = mysql_result($rs, $i,"fname");
	$mname				 = mysql_result($rs, $i,"mname");
	$lname				 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$birthday_us	   	 = mysql_result($rs, $i,"birthday_us");
	$relationship	   	 = mysql_result($rs, $i,"relationship");
	$gender				 = mysql_result($rs, $i,"gender");
	$note		 		 = mysql_result($rs, $i,"note");
 
} 
 
 echo "<table cellpadding='5em' id='details_header'>
			<tr><th width='145px'>Name:</td><td>$fname $mname $lname</td></tr>
			<tr><th>Religious Name:</td><td>$religious_name</td></tr>
			<tr><th>Birthdate:</td><td>$birthday_us</td></tr>
			<tr><th>Relationship:</td><td>$relationship</td></tr>
			<tr><th>Gender:</td><td>$gender</td></tr>
			<tr><th valign='top'>Note:</td><td>$note</td></tr></table>"; ?> 
<br /><br />
	<input type="submit" value=" Back " id="cancelButton" /> <input type="submit" value=" Edit Relative " id="relatives_edit">