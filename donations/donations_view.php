<?php include ( "../header.php" ); ?>

<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id = $_REQUEST['contact_id'];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$sql = "SELECT * FROM donation WHERE contact_id=$contact_id ORDER BY donation_id DESC";
		
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
	
$html = "<table id='donations_table' class='tablesorter'>
<thead><tr>
		<th>Name</th>
		<th>Payment Type</th>
		<th>Amount</th>
		<th>Note</th>
		<th>Delete</th>
</tr></thead><tbody>";

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$donation_id		 = mysql_result($rs, $i,"donation_id");
	$name				 = mysql_result($rs, $i,"name");
	$amount				 = mysql_result($rs, $i,"amount");
	$pay_method 		 = mysql_result($rs, $i,"pay_method");
	$note			 	 = mysql_result($rs, $i,"note");
	
	$note = shorten_string($note, $NOTE_LENGTH);
	$html .= "<tr>
			<td>$name</td>
			<td>$pay_method</td>
			<td>$$amount</td>
			<td>$note</td>
			<td><a href='/db_temple/donations/donations_delete.php?contact_id=$contact_id&donation_id=$donation_id' class='donations_delete'><center><img src='../images/icons/cross.png' title='Delete'></img></center></a></td></tr>";		
}

$html .= "</tbody></table>";

print $html;
?>
<script>
$(document).ready(function () { 
		
	 // tablesorter
    $("#donations_table").tablesorter({
        widgets: ['zebra'],
        headers: {
            4: { sorter: false }
		
        }
    });
	// ajax new/details/delete
   $("#donations_new").click(function(e) 
	{
		e.preventDefault();
        $.ajax({
            url: "/db_temple/donations/donations_new.php?contact_id=<?php echo $contact_id;?>",
            type: "POST",
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });

	$(".donations_delete").click(function(e)
		{
			e.preventDefault();
			var donations_delete = $(this).attr('href');
			if (confirm('Are you sure you want to delete this donation?')) {
			$.ajax({
					url: donations_delete,
					type: "post",
					success: function (html) {
						$('.ui-tabs-panel:visible').html(html)
					}
			   }); 
			};		
		});
});
   
</script>

<input type="submit" id="donations_new" value=" Add New Donation ">