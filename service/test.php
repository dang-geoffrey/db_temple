 <script>
 $(".validate").validate(
{

groups:
{
giaChuName: "lname fname"
},
errorPlacement: function(error, element)
{
if(element.attr("name") == "fname" || element.attr("name") == "lname")
error.insertAfter("#fname");
else if (element.attr("type") == "radio")
error.insertAfter(".genderNu");
else
error.insertAfter(element);

},
submitHandler: function(form) 
{
        $.ajax({
            url: "/db_temple/deceased/deceased_save.php?contact_id=<?php echo $_REQUEST['contact_id']; ?>",
		
            type: 'post',
            data: $("#deceased_save").serialize(),
            success: function (html) {
                $('.ui-tabs-panel:visible').html(html)

            }
        });
    }; 
 });    

</script>
