<!DOCTYPE HTML>
<html lang="en">

    <head>
 <?php include ( "../header.php" ); ?>
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
    // cancel button
    $("#cancelButton_deceased_new").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/db_temple/deceased/deceased_view.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",

            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)

            }
        });
    });
	// save button
	$("#deceased_save").validate({

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
            url: "/db_temple/deceased/deceased_save.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
			cache: false, type: 'post', data: $("#deceased_save").serialize(),
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)

            }
        });
    }
 });    
	
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
		buttonImageOnly: true, buttonText: "Solar", onSelect: function () { }, onClose: function() { $(this).valid(); },
    });
  	
});
        </script>
    </head>
    
    <body> <span class="headline">Add New Deceased</span>
        <br />
        <form id="deceased_save">
            <table border="0" cellpadding="5">
                <tr>
                    <td align="right">
                        <nobr>
                            <font color="red">*</font>Name of Deceased:
                    </td>
                    <td>
                        <input class="required" placeholder="First" type="text" name="fname" id="fname"/>
                        <input placeholder="Middle" type="text" name="mname" />
                        <input class="required" placeholder="Last" type="text" name="lname" id="lname"/>
                        </nobr>
                    </td>
                </tr>
                <tr>
                    <td align="right">Religious Name:</td>
                    <td>
                        <input type="text" name="religious_name">
                    </td>
                </tr>
                <tr>
                    <td align='right'><font color="red">*</font>Birthdate:</td>
                    <td>
                        <input type="text" class="required" name="birthday" id="birthday"> 
                    </td>
                </tr>
                
                    <tr>
                        <td align="right" valign="top"><font color="red">*</font>Date of Passing:</td>
                        <td>
                            <input type="text" class="required" name="death_date_solar" id="datepickerSolar"> 
							<br><input type="text" name="death_date_lunar" id="datepickerLunar"> (East) 
						</td>
                    </tr>
                    <tr>
                        <td align='right'><font color="red">*</font>Gender:</td>
                        <td>
                            <label>
                                <input type="radio" name="gender" class="required" value="Male">Male</label>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="gender" class="required" value="Female">Female</label>
                            </label><span class="genderFemale"></span>
                        </td>
                    </tr>
                    <tr>
                        <td align='right'>Photo ID:</td>
                        <td>
                            <input type="text" id="photo_id" name="photo_id">
                        </td>
                    </tr>
					 <tr>
                        <td align='right' valign="top">Note:</td>
                        <td>
                            <textarea wrap="hard" rows="3" cols="1" name="note"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input id="cancelButton_deceased_new" type="submit" value=" Cancel " />
                            <input type="submit" value=" Save "
                            />
                        </td>
                    </tr>
            </table>
        </form>
    </body>

</html>