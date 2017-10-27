<?php include ( "../header.php" ); ?>

<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id = $_REQUEST['contact_id'];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us, DATE_FORMAT(from_days(DATEDIFF(now(),birthday)),'%Y')+0 as age FROM relative WHERE contact_id=$contact_id";
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
		<th>Delete</th>
</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
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
			<td><a class='relatives_details' href='/db_temple/relatives/relatives_details.php?relative_id=$relative_id&contact_id=$contact_id' ><center><img border='0' src='../images/icons/pencil.png' title='Details'></center></a></td>
			<td><a class='relatives_delete' delete_name='$fname $mname $lname' href='/db_temple/relatives/relatives_delete.php?contact_id=$contact_id&relative_id=$relative_id' ><center><img border='0' src='../images/icons/cross.png' title='Delete'></center></img></a></td></tr>";		
}

$html .= "</tbody></table>";

print $html;
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
		// ajax new	
   $("#relatives_new").click(function(e) 
	{
		e.preventDefault();
        $.ajax({
            url: "/db_temple/relatives/relatives_new.php?contact_id=<?php echo $contact_id;?>",
            type: "POST", cahe:false,
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });
		// ajax details
    $(".relatives_details").click(function(e)
	{
		e.preventDefault(); 
		var relatives_details = $(this).attr('href');
		$.ajax({
			url: relatives_details, cache:false,
			success: function(html) { 
				$('.ui-tabs-panel:visible').html(html)
			}	
		});
   });

   
	
	$(".relatives_delete").click(function(e)
		{
			e.preventDefault();
			var delete_name  = $(this).attr('delete_name'),
			relatives_delete = $(this).attr('href');
			if (confirm('Delete ' + delete_name + ':' + '\n\nAre you sure you want to delete this?')) {
			$.ajax({
					url: relatives_delete,
					type: "post", cache:false,
					success: function (html) {
						$('.ui-tabs-panel:visible').html(html)
					}
			   }); 
			};		
		});
});
   
</script>


<input type="submit" id="relatives_new" value=" Add New Relative ">