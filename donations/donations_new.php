<!DOCTYPE HTML>
<html lang="en">
    <head>
<?php include ( "../header.php" ); ?>
	<script language="javascript">
				
	$(document).ready(function () {
        // Validation	
		$("#donations_save").validate({
			  rules: {
				  'donations_name[]': {
					  required: true,
					  minlength: 1
					  }
				  },
			  messages: {
				  'donations_name[]': 'Please select at least one service type.',
			  },
			  errorPlacement: function (error, element) {
				  if (element.attr("name") == "donations_name[]") error.appendTo(element.parent("label"));
				  else error.insertAfter(element);
			  
			  },
			  submitHandler: function (form) {
				  $.ajax({
					  url: "/db_temple/donations/donations_save.php?contact_id=<?php $contact_id = $_REQUEST['contact_id']; echo $contact_id?>",
					  type: 'post',
					  data: $("#donations_save").serialize(),
					  cache: false,
					  success: function (html) {
						  $('.ui-tabs-panel:visible').html(html)

					  }
				  });
			  }
	});
	    // cancel button
		$("#cancelButton").click(function (e) {
			e.preventDefault();
			  $.ajax({
				  url: "/db_temple/donations/donations_view.php?contact_id=<?php echo $contact_id; ?>",
				  cache: false,
				  success: function (html) {
					  $('.ui-tabs-panel:visible').html(html)
				  }
			  });
		  });
		  
		
	});
		// checkbox other input
		function checkbox(){
			if(document.getElementById('text').value!='') {
				document.getElementById('cb').checked=true; 
			} 
			
		}
</script>
    </head>
    
    <body>
	<span class="headline">Add New Donation</span><br />
		<form id="donations_save">
			
            <table cellpadding="5em">
                <tr>
                    <td align="right" valign="top"><font color="red">*</font>Service Type(s):</td>
                    <td>
                        <label><input type="checkbox" name="donations_name[]" value="<?php echo $SERVICE_TYPE_1?>"> <?php echo $SERVICE_TYPE_1?></label><br>
						<label><input type="checkbox" name="donations_name[]" value="<?php echo $SERVICE_TYPE_2?>"> <?php echo $SERVICE_TYPE_2?></label><br>
						<label><input type="checkbox" name="donations_name[]" value="<?php echo $SERVICE_TYPE_3?>"> <?php echo $SERVICE_TYPE_3?></label><br>
						<label><input type="checkbox" name="donations_name[]" value="<?php echo $SERVICE_TYPE_4?>"> <?php echo $SERVICE_TYPE_4?></label><br>
						<label><input type="checkbox" name="donations_name[]" value="<?php echo $SERVICE_TYPE_100?>" id="cb"> <?php echo $SERVICE_TYPE_100?> </label>&nbsp;&nbsp;<input id="text" type="text" name="other" onkeypress="checkbox()">
                    </td>
                </tr>
                <tr>
                    <td align="right">Payment Type:</td>
                    <td>
                        <input type="text" name="pay_method">
                    </td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>Amount (USD):</td>
                    <td>
                        <span class="dollar_sign">$</span><input type="text" name="amount" class="required dollar_amount" size="4" maxlength="12">
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
							<input id="cancelButton" type="submit" value=" Cancel " />&nbsp;
						<input type="submit" value=" Save " />
                    </td>
                </tr>
            </table>     			
        </form>
</body>

</html>