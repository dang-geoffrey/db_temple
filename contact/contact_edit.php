<?php

include ("../../classMySql.php");
include ("../config.php");

$contact_id = $_REQUEST["contact_id"];


$db = new classMySql($dbName, $hostName, $dbUsername, $dbPassword);
$sql = "SELECT * FROM contact WHERE contact_id = $contact_id";
$rs = $db->selectQuery($sql);

for ($i=0; $i < mysql_numrows($rs); $i++)

{
	$contact_id		 	 = mysql_result($rs, $i,"contact_id");	
	$fname			 	 = mysql_result($rs, $i,"fname");
	$mname			 	 = mysql_result($rs, $i,"mname");
	$lname			 	 = mysql_result($rs, $i,"lname");
	$religious_name		 = mysql_result($rs, $i,"religious_name");
	$address		 	 = mysql_result($rs, $i,"address");
	$city			 	 = mysql_result($rs, $i,"city");
	$state			 	 = mysql_result($rs, $i,"state");
	$zipcode		 	 = mysql_result($rs, $i,"zipcode");
	$phone		 	 	 = mysql_result($rs, $i,"phone");
	$email			 	 = mysql_result($rs, $i,"email");
	$note	 			 = mysql_result($rs, $i,"note");

}

?>
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

     // cancel button ajax
     $("#cancelButton").click(function (e) {
         e.preventDefault();
         $.ajax({
             url: "contact_view_row.php?contact_id=<?php echo $contact_id ;?>",
             success: function (html) {
                 $('.ui-tabs-panel:visible').html(html);
             }
         });
     });

     // validation
     $("#contact_update").validate({

         groups: {
             name: "fname lname"
         },
         errorPlacement: function (error, element) {
             if (element.attr("name") == "fname" || element.attr("name") == "lname") error.insertAfter("#lname");
             else error.insertAfter(element);

         },
         submitHandler: function (form) {
             $.ajax({
                 url: "contact_update.php",
                 data: $("#contact_update").serialize(),
                 type: "POST",
                 success: function (html) {
                     $(".ui-tabs-panel:visible").html(html);
                 }
             });
         }
     });

 });



 </script>
</head>
<body>
    <div id="content">
		<span class="headline">Edit Contact</span><br/>
        <form id="contact_update">
            <input type="hidden" name="contact_id" value="<?php echo $contact_id;?>">
            <table border="0" cellpadding="5">
                <tr>
                    <td align="right"><font color="red">*</font>Name:</td>
                    <td>
                            <input class="required" placeholder="First" type="text" name="fname" value="<?php echo $fname;?>" />
                            <input placeholder="Middle" type="text" name="mname" value="<?php echo $mname;?>" />
                            <input class="required" placeholder="Last" type="text" name="lname" value="<?php echo $lname;?>" id="lname" />
							</td>
                </tr>
                <tr>
                    <td align="right">Religious Name:</td>
                    <td>
                        <input type="text" name="religious_name" value="<?php echo $religious_name;?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Address:</td>
                    <td>
                        <input type="text" size="44" name="address" value="<?php echo $address;?>">
                    </td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>City:</td>
                    <td>
                        <input type="text" name="city" value="<?php echo $city;?>" class="required">
                    </td>
                </tr>
                <tr>
                    <td align="right">State/Zip Code:</td>
                    <td>
                        <input type="text" value="CA" size="3" name="state" maxlength="2" value="<?php echo $state;?>">
                        <input type="text" id="zipcode" name="zipcode" size="8" placeholder="Zip Code" maxlength="5" value="<?php echo $zipcode;?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Phone:</td>
                    <td>
                        <input type="text" id="phone" size="44" name="phone" value="<?php echo $phone;?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Email:</td>
                    <td>
                        <input type="text" size="44" name="email" value="<?php echo $email;?>">
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">Note:</td>
                    <td>
                        <textarea rows="3" name="note"><?php echo $note;?></textarea>                   
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input id="cancelButton" type="submit" value=" Cancel " />
                        <input id="updateButton" type="submit" value=" Save " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>