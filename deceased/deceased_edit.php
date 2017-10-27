<?php

include ("../../classMySql.php");
include ("../config.php");

$deceased_id = $_REQUEST["deceased_id"];

$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "SELECT *, DATE_FORMAT(birthday, '%b %d, %Y') birthday_us,  DATE_FORMAT(`death_date_lunar`, '%b %d, %Y') eastDate_us, DATE_FORMAT(`death_date_solar`, '%b %d, %Y') westDate_us FROM deceased WHERE deceased_id = $deceased_id";
$rs = $db->selectQuery($sql);

for ($i=0; $i < mysql_numrows($rs); $i++)
{
	$contact_id 		 = mysql_result($rs, $i,"contact_id");
	$deceased_id		 = mysql_result($rs, $i,"deceased_id");	
	$fname			 	 = mysql_result($rs, $i,"fname");
	$mname			 	 = mysql_result($rs, $i,"mname");
	$lname			 	 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$birthday_us	   	 = mysql_result($rs, $i,"birthday_us");
	$eastDate_us		 = mysql_result($rs, $i,"eastDate_us");
	$westDate_us	 	 = mysql_result($rs, $i,"westDate_us");
	$gender				 = mysql_result($rs, $i,"gender");
	$photo_id			 = mysql_result($rs, $i,"photo_id");
	$note				 = mysql_result($rs, $i,"note");
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
	$("#deceased_form").validate({

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
		error.insertAfter(element.next());

		},
		submitHandler: function(form) 
		{
				  $.ajax({
					url: "/db_temple/deceased/deceased_update.php?deceased_id=<?php echo $deceased_id; ?>",
					type: 'post',
					data: $("#deceased_form").serialize(),
					success: function (html) {
						$('.ui-tabs-panel:visible').html(html)

					}
				});
			}
		 });    
   
      
 	 $("#cancelButton_deceased_edit").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/db_temple/deceased/deceased_view.php?contact_id=<?php echo $contact_id;?>",
                success: function (html) {
                $('.ui-tabs-panel:visible').html(html)
            }
        });
    });

    // datepickers
   $('#birthday').datepicker({ changeMonth: true, changeYear: true, maxDate:"0", yearRange:"-120:+0",
		buttonImage: '../images/icons/calendar.png', buttonImageOnly:true, showOn:'both',
		buttonText: "Birthdate", onClose: function() { $(this).valid(); }, onSelect: function (dateText, inst) {
		  $('#datepickerLunar').datepicker("option", 'minDate', new Date(dateText));
		  $('#datepickerSolar').datepicker("option", 'minDate', new Date(dateText));
        },
    });
  
	$('#datepickerLunar').datepicker({ maxDate: "0", showOn: 'both', yearRange:"-120:+0",
		  buttonImage: '../images/icons/calendar.png', changeYear:true, changeMonth:true,
		  buttonImageOnly: true, buttonText: "Lunar", onSelect: function () { }, onClose: function() { $(this).valid(); },
    });	
	
	$('#datepickerSolar').datepicker({ maxDate: "0", showOn: 'both', yearRange:"-120:+0",
		buttonImage: '../images/icons/calendar.png', changeYear:true, changeMonth:true,
		buttonText: "Solar", buttonImageOnly: true, onSelect: function () { }, onClose: function() { $(this).valid(); },
    });

});
			
            </script>
        </head>
        
	<body>   
		<span class="headline">Edit Deceased</span><br/>
					<form id="deceased_form">
					<input type="hidden" name="deceased_id" value="<?php echo $deceased_id;?>">
					<input type="hidden" name="contact_id" value="<?php echo $contact_id;?>">
					<table border="0" cellpadding="5">
						<tr>
							<td align="right">
								<nobr><font color=red>*</font>Name of Deceased:</nobr>
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
							<td align='right'><font color=red>*</font>Birthdate:</td>
							<td>
								<input type="text" class="required" id="birthday" name="birthday" value="<?php echo $birthday_us;?>"> 
							</td>
						</tr>
						<tr>
							<td align="right" valign="top"><font color=red>*</font>Date of Passing:</td>
							<td>
								<input type="text" class="required" id="datepickerSolar" name="death_date_solar"
								value="<?php echo $westDate_us;?>"> <br>
							<input type="text" name="death_date_lunar" value="<?php echo $eastDate_us;?>" id="datepickerLunar"> (East)
							</td>
						</tr>
						<tr>
							<td align='right'><font color="red">*</font>Gender:</td>
							<td>
								<label>
									<input type="radio" name="gender" class="required" value="Male" <?php echo $checkedMale;?> >Male</label>
								</label>&nbsp;&nbsp;&nbsp;&nbsp;
								<label>
									<input type="radio" name="gender" class="required" value="Female" <?php echo $checkedFemale;?>>Female</label>
								</label><span class="genderFemale"></span>
							</td>
						</tr>
						<tr>
							<td align='right'>Photo ID:</td>
							<td>
								<input type="text" id="photo_id" name="photo_id" value="<?php echo $photo_id;?>">
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
								<input type="submit" value=" Cancel " id="cancelButton_deceased_edit" />&nbsp;
								<input type="submit" value=" Update " id="submitButton_deceased_edit" />
							</td>
						</tr>
				</table>
			</form>
 </body>

</html>