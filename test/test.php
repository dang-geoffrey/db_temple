<script>
$(document).ready(function()
{

	$("#updateButton").click(function(e)
	{
		e.preventDefault();
		var myFirstName=$("#fname").val();
	 
		$.ajax(
		{
			url:'deceasedtest.php?fname='+myFirstName,
			type: 'POST'
		});
	
	});

});

</script>



<form name="deceased" id="deceased_form">
	<input type="text" name="fname" id="fname">
	<input type="submit" id="updateButton">
	</form>