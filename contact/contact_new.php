<!DOCTYPE HTML>
<html lang="en">
    <title>Add New Contact</title>
    <head>
		<link type="text/css" href="/jquery/jquery-ui-1.9.2.custom/css/custom-theme/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
	    <link type="text/css" rel="stylesheet" href="/db_temple/css.css" />
        <script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="/jquery/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="/db_temple/validate/jquery.validate.js"></script>
        <script type="text/javascript" src="/db_temple/validate/jquery.maskedinput.min.js"></script>
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
			// submit button design
			$('input[type="submit"]').each(function () {
				$(this).hide().after('<button>').next().button({
					icons: {
						primary: 'ui-icon-plusthick',
					},
					label: $(this).val()
				}).click(function (event) {
					event.preventDefault();
					$(this).prev().click();
				});
			});
			// validation
			$("#contact_save").validate({

        groups: {
            name: "fname lname"
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "fname" || element.attr("name") == "lname") error.insertAfter("#lname");
	            else error.insertAfter(element);

        },
            });
        
		
		});

        </script>
    </head>
    
    <body>
    
    <?php include ("../vertical_menu.php"); ?>
       
    <div class="content">
<span class="headline">Add New Contact</span>
<img src="/db_temple/images/dotGray.jpg" width=100% height='1px' ><br>
        <form action="contact_save.php" method="post" id="contact_save">
            <table cellpadding="5em">
                <tr>
                    <td align="right"><font color="red">*</font>Name of Contact:</td>
                    <td>
                        <input class="required" placeholder="First" type="text" name="fname" />
                        <input placeholder="Middle" type="text" name="mname" />
                        <input placeholder="Last" type="text" name="lname" class="required" id="lname"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">Religious Name:</td>
                    <td>
                        <input type="text" name="religious_name">
                    </td>
                </tr>
                <tr>
                    <td align="right">Address:</td>
                    <td>
                        <input type="text" size="44" name="address">
                    </td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>City:</td>
                    <td>
                        <input type="text" name="city" class="required">
                    </td>
                </tr>
                <tr>
                    <td align="right">State/Zip Code:</td>
                    <td>
                        <input type="text" value="CA" size="3" name="state" maxlength="2">
                        <input type="text" name="zipcode" id="zip_code" placeholder="Zip Code" size="8" >
                    </td>
                </tr>
                <tr>
                    <td align="right">Phone:</td>
                    <td>
                        <input type="text" size="44" id="phone" name="phone">
                    </td>
                </tr>
                <tr>
                    <td align="right">E-mail:</td>
                    <td>
                        <input type="text" size="44" name="email">
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">Note:</td>
                    <td>
                        <textarea rows="3" name="note"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
						<input type="submit" value=" Save " />
                    </td>
                </tr>
            </table>     			
        </form>
		
        </div>
   
   <?php include ("../footer.php"); ?>
   
</body>

</html>