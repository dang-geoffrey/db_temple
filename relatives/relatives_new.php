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

    // cancel/update button
    $("#cancelButton_relatives_new").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/db_temple/relatives/relatives_view.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)

            }
        });
    });
    // validation
    $("#relatives_save").validate({

        groups: {
            name: "fname lname"
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "fname" || element.attr("name") == "lname") error.insertAfter("#lname");
            else if (element.attr("type") == "radio") error.insertAfter(".genderFemale");
            else error.insertAfter(element);

        },
        submitHandler: function (form) {
            $.ajax({
                url: "/db_temple/relatives/relatives_save.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
                type: 'post',
                data: $("#relatives_save").serialize(),
                success: function (html) {
                    $('.ui-tabs-panel:visible').html(html)

                }
            });
        }
    });

    // datepickers
    $("#birthday").datepicker({
        changeMonth: true,
        changeYear: true,
        buttonText: "Birthdate",
        yearRange: "-120:+0",
        maxDate: "0",
        showOn: "both", onClose: function() { $(this).valid(); },
        buttonImage: "/db_temple/images/icons/calendar.png",
        buttonImageOnly: true

    });
});
    </script>
    </head>
    
    <body> <span class="headline">Add New Relative</span>
        <br />
        <form id="relatives_save">
            <table border="0" cellpadding="5">
                <tr>
                    <td align="right">
                        <font color="red">*</font>Name of Relative:
                    </td>
                    <td>
                        <input class="required" placeholder="First" type="text" name="fname" id="fname" />
                        <input placeholder="Middle" type="text" name="mname" />
                        <input class="required" placeholder="Last" type="text" name="lname" id="lname" />
                    </td>
                </tr>
                <tr>
                    <td align="right">Religious Name:</td>
                    <td>
                        <input type="text" name="religious_name">
                    </td>
                </tr>
				<tr>
                    <td align='right'>Relationship:</td>
                    <td>
                        <input type="text" name="relationship">
                    </td>
                </tr>
                <tr>
                    <td align='right'>Birthdate:</td>
                    <td>
                        <input type="text" name="birthday" id="birthday">
                    </td>
                </tr>
				<tr>
                        <td align='right'><font color="red">*</font>Gender:</td>
                        <td>
                            <label>
                                <input type="radio" name="gender" value="Male" class="required">Male</label>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="gender" value="Female" class="required">Female</label>
                            </label><span class="genderFemale"></span>
                        </td>
                    </tr>
					<tr>
                        <td align='right' valign="top">Note:</td>
                        <td>
                            <textarea rows="3" cols="1" name="note"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input id="cancelButton_relatives_new" type="submit" value=" Cancel " />
                            <input id="saveButton_relatives_new" type="submit" value=" Save " />
                        </td>
                    </tr>
            </table>
        </form>
    </body>

</html>