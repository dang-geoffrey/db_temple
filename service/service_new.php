<!DOCTYPE HTML>
<html lang="en">
    <head>
       <?php include ( "../header.php" ); ?>
<script language="javascript">
$(document).ready(function () {
   // tablesorter
    $("#relative_table").tablesorter({
        widgets: ['zebra'],
		headers: { 6: { sorter: "shortDate" }, 0: { sorter: false }  
			}
    });
	$("#deceased_table").tablesorter({
        widgets: ['zebra'],
		headers: { 6: { sorter: "shortDate" }, 0: { sorter: false},
				   7: { sorter: false}, 8: { sorter: false},  		
				   9: { sorter: false}, 10: { sorter: false},  		
				   11: { sorter: false}, 12: { sorter: false},  		
			}
    });
	
    // cancel button
  $("#cancelButton_service_new").click(function (e) {
      e.preventDefault();
      $.ajax({
          url: "/db_temple/service/service_view.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
          cache: false,
          success: function (html) {
              $('.ui-tabs-panel:visible').html(html)
          }
      });
  });

  // Validation	
  $("#service_save").validate({
      rules: {
          'relative[]': {
              required: true,
              minlength: 1
          },
              'deceased[]': {
              required: true,
              minlength: 1
          }
      },
      messages: {
          'relative[]': 'Please select at least one relative member.',
              'deceased[]': 'Please select at least one deceased member.',
      },
      errorPlacement: function (error, element) {
          if (element.attr("name") == "relative[]") error.insertAfter(".errorValidationRelative");
          else if (element.attr("name") == "deceased[]") error.insertAfter(".errorValidationDeceased");
          else error.insertAfter(element.next());

      },
      submitHandler: function (form) {
          $.ajax({
              url: "/db_temple/service/service_save.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
              type: 'post',
              data: $("#service_save").serialize(),
              cache: false,
              success: function (html) {
                  $('.ui-tabs-panel:visible').html(html)

              }
          });
      }
  });

  // toggle all checkbox
  $("#checkAllRelatives").change(function () {

      $(".checkRelative").prop("checked", $("#checkAllRelatives").prop("checked"));
	  if($(this).is(":checked")){
		$("span.errorValidationRelative").next('label').remove();
		}
  });
  $("#checkAllDeceased").click(function () {

      $(".checkDeceased").prop("checked", $("#checkAllDeceased").prop("checked"));
	  if($(this).is(":checked")){
		$("span.errorValidationDeceased").next('label').remove();
		}
  });

  // select option
  $('#select_type').change(function () {
      if ($(this).val() == "1") {
          $("#relative").show();
          $("#deceased").hide();
          $(".other_input").hide();
          $("input").filter('.rel_disabled').prop("disabled", false);
          $("input").filter('.dec_disabled').prop("disabled", true);
          $("input").filter('.other_input').prop("disabled", true);


      } else if ($(this).val() == "2") {
          $("#relative").hide();
          $("#deceased").show();
          $(".other_input").hide();
          $("input").filter('.rel_disabled').prop("disabled", true);
          $("input").filter('.dec_disabled').prop("disabled", false);
          $("input").filter('.other_input').prop("disabled", true);

      } else if ($(this).val() == "3") {
          $("#relative").show();
          $("#deceased").show();
          $(".other_input").hide();
          $("input").filter('.rel_disabled').prop("disabled", false);
          $("input").filter('.dec_disabled').prop("disabled", false)
          $("input").filter('.other_input').prop("disabled", true);

      } else if ($(this).val() == "4") {
          $("#relative").show();
          $("#deceased").show();
          $(".other_input").hide();
          $("input").filter('.rel_disabled').prop("disabled", false);
          $("input").filter('.dec_disabled').prop("disabled", false)
          $("input").filter('.other_input').prop("disabled", true);

      } else if ($(this).val() == "100") {
          $(".other_input").show();
          $("#title").focus();
          $("#relative").show();
          $("#deceased").show();
      } else {
          $("#relative").hide();
          $("#deceased").hide();
          $(".other_input").hide();
          $("input").filter('.rel_disabled').prop("disabled", true);
          $("input").filter('.dec_disabled').prop("disabled", true);
          $("input").filter('.other_input').prop("disabled", true);
      }

  });
  // first time load, hide all
  $("#relative").hide();
  $("#deceased").hide();
  $(".other_input").hide();

  // datepickers

  $('#datepicker_start').datepicker({
      minDate: "0",
      showOn: 'both',
      buttonImage: '../images/icons/calendar.png',
      numberOfMonths: 3,
      buttonImageOnly: true,
      buttonText: "Start Date",
	  onSelect: function (dateText, inst) {
          $('#datepicker_end').datepicker("option", 'minDate', new Date(dateText));
      }, onClose: function() { $(this).valid(); }
  });

  $('#datepicker_end').datepicker({
      minDate: "0",
      showOn: 'both',
      buttonImage: '../images/icons/calendar.png',
      numberOfMonths: 3,
      buttonImageOnly: true,
      onSelect: function () {}, onClose: function() { $(this).valid(); },
      buttonText: "End Date"
  });

  // disable submit until dropdown selected
  $('.select_type').change(function (e) {
      if ($(this).prop("selectedIndex") === 0) {
          $('.disableSubmit').prop('disabled', true);
      } else {
          $('.disableSubmit').prop('disabled', false);
      }
  });

});

    </script>
    </head>

    <body> 
		<span class="headline">Add New Service</span>
        <br />
        <form id="service_save">
            <table border="0" cellpadding="5">
                <tr>
                    <td align="right" width="100px"><font color="red">*</font>Start Date:</td>
                    <td>
                        <input type="text" class="required" name="start_date" id="datepicker_start">
                    </td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>End Date:</td>
                    <td>
                        <input type="text" class="required" name="end_date" id="datepicker_end">
                    </td>
                </tr>
				<tr>
                    <td align='right'><font color="red">*</font>Service Type:</td>
                    <td>
                        <select id="select_type" class="select_type" name="service_type">
							<option></option>
							<option value="1"><?php echo $SERVICE_TYPE_1?></option>
							<option value="2"><?php echo $SERVICE_TYPE_2?></option>
							<option value="3"><?php echo $SERVICE_TYPE_3?></option>
							<option value="4"><?php echo $SERVICE_TYPE_4?></option>
							<option value="100"><?php echo $SERVICE_TYPE_100?></option>
						</select>&nbsp;&nbsp;<span class="other_input"><input type="text" name="title" id="title"></span>
                    </td>
					
                </tr>
				<tr>
					<td align='right' valign='top'>Note:</td>
					<td>
						<textarea rows="3" cols="1" name="note"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php include ( "tb_relatives_deceased.php"); ?></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input id="cancelButton_service_new" type="submit" value=" Cancel " />&nbsp;
						<input type="submit" value=" Save " class="disableSubmit" disabled/>
					</td>
				</tr>
            </table>
        </form>
    </body>
</html>