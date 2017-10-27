<?php

include ("../../classMySql.php");
include ("../config.php");

$relative_id = $_REQUEST["relative_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us FROM relative WHERE relative_id = $relative_id";
$rs = $db->selectQuery($sql);

for ($i=0; $i < mysql_numrows($rs); $i++)
{
	$contact_id 		 = mysql_result($rs, $i,"contact_id");
	$relative_id		 = mysql_result($rs, $i,"relative_id");	
	$fname			 	 = mysql_result($rs, $i,"fname");
	$mname			 	 = mysql_result($rs, $i,"mname");
	$lname			 	 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$relationship		 = mysql_result($rs, $i,"relationship");
	$birthday_us	   	 = mysql_result($rs, $i,"birthday_us");
	$gender				 = mysql_result($rs, $i,"gender");
	$note		 		 = mysql_result($rs, $i,"note");
}

$checkedMale = "";
$checkedFemale = "";

if($gender == 'Male')
 $checkedMale = "checked";
 else
 $checkedFemale = "checked"; 

?>

<!DOCTYPE HTML>
    <html lang="en">
        
        <head>
            <link type="text/css" href="/jquery/jquery-ui-1.9.2.custom/css/custom-theme/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
            <link type="text/css" rel="stylesheet" href="../css.css" />
            <script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
            <script type="text/javascript" src="/jquery/jquery-ui-1.9.2.custom.min.js"></script>
            <script type="text/javascript" src="../validate/jquery.validate.js"></script>
            <script type="text/javascript" src="../validate/jquery.maskedinput.min.js"></script>
            <script language="javascript">
$(document).ready(function () {
    // placeholder text for ie
    placeholderSupport = ("placeholder" in document.createElement("input"));

    if (!placeholderSupport) {
        $('[placeholder]').focus(function () {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function () {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur().parents('form').submit(function () {
            $(this).find('[placeholder]').each(function () {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    }
    // ajax update/cancel
	$("#relatives_form").validate({

groups:
{
name: "fname lname"
},
errorPlacement: function(error, element)
{
if(element.attr("name") == "fname" || element.attr("name") == "lname")
error.insertAfter("#lname");
else if (element.attr("type") == "radio")
error.insertAfter(".genderFemale");
else
error.insertAfter(element);

},
submitHandler: function(form) 
{
         $.ajax({
            url: "/db_temple/relatives/relatives_update.php?relative_id=<?php echo $relative_id; ?>",
            type: 'post',
            data: $("#relatives_form").serialize(),
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)

            }
         });
		} 
     }); 
   
        $("#cancelButton_relatives_edit").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/db_temple/relatives/relatives_view.php?contact_id=<?php echo $contact_id;?>",
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });

    // datepickers

    $("#birthday").datepicker({
        changeMonth: true, changeYear: true, buttonText: "Birthdate",
        yearRange: "-120:+0", buttonImageOnly: true, maxDate:"0", onClose: function() { $(this).valid(); },
		showOn: "both", buttonImage: "/db_temple/images/icons/calendar.png", 
		
    });

});
			
            </script>
        </head>
        
        <body>   
					<span class="headline">Edit Relative</span><br/>
                        <form id="relatives_form">
                        <input type="hidden" name="relative_id" value="<?php echo $relative_id;?>" id="fname">
                        <input type="hidden" name="contact_id" value="<?php echo $contact_id;?>">
                        <table border="0" cellpadding="5" >
                            <tr>
                                <td align="right">
                                   <font color="red">*</font>Name of Relative:
                                </td>
                                <td>
                                    <input class="required" placeholder="First" type="text" name="fname" value="<?php echo $fname;?>" id="fname"/>
                                    <input  placeholder="Middle" type="text" name="mname" value="<?php echo $mname;?>" />
                                    <input class="required" placeholder="Last" type="text" name="lname" value="<?php echo $lname;?>" id="lname"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Religious Name:</td>
                                <td>
                                    <input type="text" name="religious_name" value="<?php echo $religious_name;?>">
                                </td>
                            </tr>
							<tr>
								<td align='right'>Relationship:</td>
								<td>
									<input type="text" name="relationship" id="relationship" value="<?php echo $relationship;?>">
								</td>
							</tr>
                            <tr>
                                <td align='right'>Birthdate:</td>
                                <td>
                                    <input type="text" class="required" id="birthday" name="birthday" value="<?php echo $birthday_us;?>">
                                </td>
                            </tr>
                            <tr>
								<td align='right'><font color="red">*</font>Gender:</td>
								<td>
									<label>
										<input type="radio" name="gender" value="Male" <?php echo $checkedMale;?> class="required">Male</label>
									</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label>
										<input type="radio" name="gender" value="Female" <?php echo $checkedFemale;?> class="required">Female</label>
									</label><span class="genderFemale"></span>
								</td>
							</tr>
							 <tr>
								<td align="right" valign="top">Note:</td>
								<td>
									<textarea name="note"><?php echo $note;?></textarea>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="submit" value=" Cancel " id="cancelButton_relatives_edit" />
									<input type="submit" value=" Update " id="submitButton_relatives_edit" />
								</td>
							</tr>
					</table>
				</form>
		
					  
	 </body>

</html>