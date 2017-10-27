<!DOCTYPE HTML>
<title>Filter Date</title>
<?php
include ("../header.php"); 
include ("../vertical_menu.php"); 

echo 
"<div class='content'>
		<span class='headline'>View Date of Deceased</span><br>
			<form id='search_deceased' action='filter_view.php' method='post'>
				<input type='text' name='date_death' id='date_death' READONLY> 
				<label><input type='radio' name='calendar' value='west' checked>West</label> 
				<label><input type='radio' name='calendar' value='east'>East</label>
				<br><br><input type='submit' value=' Search '>
			</form>
</div>";			
include ("../footer.php"); 
?>
<script>
$(document).ready(function() 
{
// calendar popup
	$( "#date_death" ).datepicker(
	{
		changeMonth: true,
		dateFormat: "MM d" 
	});
});
</script>