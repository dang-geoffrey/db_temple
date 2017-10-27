<?php 
 include ("../../classMySql.php");
 include ("../config.php");
 
 $contact_id = $_REQUEST['contact_id'];
  
 $db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
 $sql = "SELECT * FROM contact WHERE contact_id = $contact_id";
 $rs = $db->selectQuery($sql);
 
 for ($i=0; $i < mysql_numrows($rs); $i++)
 
 {
  	$fname			 	 = mysql_result($rs, $i,"fname");
 	$mname			 	 = mysql_result($rs, $i,"mname");
 	$lname			 	 = mysql_result($rs, $i,"lname");
 	$phone		 	 	 = mysql_result($rs, $i,"phone");
} 
?>
	
<!DOCTYPE HTML>
<html lang="en">
    <html>
        <title>Contact Details</title>        
        <head>
			<?php include ( "../header.php" ); ?>
            <script language="javascript">
                $(document).ready(function() {
                    // ajax tab menu       
                    $("#tabs").tabs({
                        beforeLoad: function(event, ui) {
                            ui.jqXHR.error(function() {
                                ui.panel.html(
                                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                                    "If this wouldn't be a demo.");
                            });
                        }
                    });
                });
            </script>
        </head>
        
        <body>
            <?php include ( "../vertical_menu.php" ); ?>
			<div id="wrapper">
            <div class="content" align="left">
				<?php echo "<span class='headline'>$fname $mname $lname - $phone</span>";?><br><br>
					<div id="tabs">
						<ul>
							<li><a href="contact_view_row.php?contact_id=<?php echo $contact_id; ?>">Contact Info</a>
							</li>
							<li><a href="/db_temple/deceased/deceased_view.php?contact_id=<?php echo $contact_id; ?>">Deceased</a>
							</li>
							<li><a href="/db_temple/relatives/relatives_view.php?contact_id=<?php echo $contact_id; ?>">Relatives</a>
							</li>
							<li><a href="/db_temple/service/service_view.php?contact_id=<?php echo $contact_id; ?>">Service</a>
							</li>
							<li><a href="/db_temple/donations/donations_view.php?contact_id=<?php echo $contact_id; ?>">Donations</a>
							</li>
						</ul>
					</div>
            </div>
            </div>
            <?php include ( "../footer.php" ); ?>
        </body>
    
    </html>
	