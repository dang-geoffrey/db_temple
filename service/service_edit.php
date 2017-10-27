<?php include ( "../header.php" ); ?>
<?php 
 include ("../../classMySql.php");
 include ("../config.php");
 
$service_id = $_REQUEST['service_id']; 
$contact_id = $_REQUEST['contact_id']; 
$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);

$rel = "SELECT service.*, relative.*, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us
		FROM service
		LEFT JOIN service_relative
		ON service.service_id = service_relative.service_id
		LEFT JOIN relative
		ON relative.relative_id = service_relative.relative_id
		WHERE service.service_id=$service_id";

$result = $db->selectQuery($rel);
$service_type_id ="";

for ($i=0; $i < mysql_numrows($result); $i++)
{	
	$service_id			 = mysql_result($result, $i,"service_id");
	$title				 = mysql_result($result, $i,"title");
	$service_type_id	 = mysql_result($result, $i,"service_type_id");
	$start_date			 = mysql_result($result, $i,"startDate_us"); /* see DATE_FORMAT above */
	$end_date			 = mysql_result($result, $i,"endDate_us");
	$rel_fname			 = mysql_result($result, $i,"fname");
	$rel_lname			 = mysql_result($result, $i,"lname");
	$note		 		 = mysql_result($result, $i,"note");
	
}

	// "selected" option doesn't trigger hide/show table
	$ble="";$pra="";$fun="";$inv="";$oth="";
		if($service_type_id=="1"){
			$ble="selected";
		} 
		else if ($service_type_id=="2"){
			$pra="selected";
		}
		else if ($service_type_id=="3"){
			$fun="selected";
		}
		else if ($service_type_id=="4"){
			$inv="selected";
		}
		else if ($service_type_id=="100"){
			$oth=="selected";
	}
		
$dec = "SELECT *, DATE_FORMAT(start_date, '%b %d, %Y') startDate_us, DATE_FORMAT(end_date, '%b %d, %Y') endDate_us
			FROM service
			LEFT JOIN service_deceased
			ON service.service_id = service_deceased.service_id
			LEFT JOIN deceased
			ON deceased.deceased_id = service_deceased.deceased_id
			LEFT JOIN service_type
			ON service.service_type_id = service_type.service_type_id
			WHERE service.contact_id=$contact_id";
		
$rs = $db->selectQuery($dec);	

for ($i=0; $i < mysql_numrows($rs); $i++)
{	
	$service_id			 = mysql_result($rs, $i,"service_id");
	$title				 = mysql_result($rs, $i,"title");
	$service_type		 = mysql_result($rs, $i,"service_type");
	$start_date			 = mysql_result($rs, $i,"startDate_us"); /* see DATE_FORMAT above */
	$end_date			 = mysql_result($rs, $i,"endDate_us");
	$dec_fname			 = mysql_result($rs, $i,"fname");
	$dec_lname			 = mysql_result($rs, $i,"lname");
	$note		 		 = mysql_result($rs, $i,"note");
	
}
		if($service_type_id=="1"){
			$rel="show";
			$dec="hide";
			$oth="hide";
		} 
		else if ($service_type_id=="2"){
			$rel="hide";
			$dec="show";
			$oth="hide";
		}
		else if ($service_type_id=="3"){
			$rel="show";
			$dec="show";
			$oth="hide";
		}
		else if ($service_type_id=="4"){
			$rel="show";
			$dec="show";
			$oth="hide";
		}
		else if ($service_type_id=="100"){
			$rel="show";
			$dec="show";
			$oth="show";
		}
?> 

<script language="javascript">

   $(document).ready(function () {
	// tablesorter
    $("#relatives_table").tablesorter({
        widgets: ['zebra'],
		dateFormat : "mmddyyyy",
        headers: {
            6: { sorter: "shortDate" }, 0: { sorter: false }, 
		}
    });
	$("#deceased_table").tablesorter({
        widgets: ['zebra'],
		dateFormat : "mmddyyyy",
        headers: {
			11: { sorter: false }, 12: { sorter: false},
			6: { sorter: "shortDate" }, 
			8: { sorter: false }, 0: { sorter: false },
        }
    });
	
    // cancel/update button
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

 //Validation	
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
         else error.insertAfter(element);

     },
     submitHandler: function (form) {
         $.ajax({
             url: "/db_temple/service/service_update.php?service_id=<?php echo $_REQUEST['service_id']; ?>&contact_id=<?php echo $_REQUEST['contact_id'];?>",
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
 $("#checkAllrelative").click(function () {

    $(".checkrelative").prop("checked", $("#checkAllrelative").prop("checked"))
	 if($(this).is(":checked")){
		$("span.errorValidationRelative").next('label').remove();
		}
 });
 $("#checkAllDeceased").click(function () {

    $(".checkDeceased").prop("checked", $("#checkAllDeceased").prop("checked"))
	 if($(this).is(":checked")){
		$("span.errorValidationDeceased").next('label').remove();
		}
 });

 // select option
 $("#relative"). <?php echo $rel ?> ();
 $("#deceased"). <?php echo $dec ?> ();
 $(".other_input"). <?php echo $oth ?> ();

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
 // datepickers
 $('#datepicker_start').datepicker({
     minDate: "0",
     showOn: 'both', onClose: function() { $(this).valid(); },
     buttonImage: '../images/icons/calendar.png',
     buttonText: "Start Date",
     buttonImageOnly: true,
     onSelect: function (dateText, inst) {
         $('#datepicker_end').datepicker("option", 'minDate', new Date(dateText));
     },
 });

 $('#datepicker_end').datepicker({
     minDate: "0",
     showOn: 'both', onClose: function() { $(this).valid(); },
     buttonImage: '../images/icons/calendar.png',
     buttonText: "End Date",
     buttonImageOnly: true,
     onSelect: function () {},
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
		<span class="headline">Edit Service</span><br />
        <form id="service_save">
            <table border="0" cellpadding="5">
                <tr>
                    <td align="right" width="100px"><font color="red">*</font>Start Date:</td>
                    <td>
                        <input type="text" class="required" name="start_date" id="datepicker_start" value="<?php echo $start_date ?>">
                    </td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>End Date:</td>
                    <td>
                        <input type="text" class="required" name="end_date" id="datepicker_end" value="<?php echo $end_date ?>">
                    </td>
                </tr>
				<tr>
                    <td align='right'><font color="red">*</font>Service Type:</td>
                    <td>
                        <select id="select_type" class="select_type" name="service_type">
							<option></option>
							<option value="1" <?php echo $ble?>><?php echo $SERVICE_TYPE_1?></option>
							<option value="2" <?php echo $pra?>><?php echo $SERVICE_TYPE_2?></option>
							<option value="3" <?php echo $fun?>><?php echo $SERVICE_TYPE_3?></option>
							<option value="4" <?php echo $inv?>><?php echo $SERVICE_TYPE_4?></option>
							<option value="100" <?php echo $oth?>><?php echo $SERVICE_TYPE_100?></option>
						</select>&nbsp;&nbsp;<span class="other_input"><input type="text" name="title" id="title" value="<?php echo $title?>"></span>
                    </td>
					
                </tr>
				<tr>
					<td align='right' valign="top">Note:</td>
					<td>
						<textarea valign="top" rows="3" cols="1" name="note" value="<?php echo $note ?>"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php include ( "tb_reldec_edit.php"); ?></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input id="cancelButton_service_new" type="submit" value=" Cancel " />&nbsp;
						<input id="saveButton_service_new" type="submit" value=" Save " class="disableSubmit" />
					</td>
				</tr>
            </table>
        </form>
    </body>
</html>