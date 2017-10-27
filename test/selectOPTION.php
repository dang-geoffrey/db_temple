 
 <!DOCTYPE HTML>
 <script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<?php $a='2';?>
 <script>
 $(document).ready(function()
	{
 $('#select_type').change(function() {
		if(<?php echo $a;?> == "1")
		{
			alert('blessing');
		}
		else if(<?php echo $a;?> == "2")
		{
			alert('prayer');
		}
		else if(<?php echo $a;?> == "3")
		{
		alert('blessing');
		}
		else if(<?php echo $a;?> == "4")
		{
			alert('blessing');
		}
		else if(<?php echo $a;?> == "100")
		{
			alert('blessing');
		}
		else
		{
			alert('blessing');
		}
		
  });
  });
function myFunction()
{
var x="";
var time=new Date().getHours();
if (time<20)
  {
  alert("Good day");
  }
document.getElementById("demo").innerHTML=x;
}
 </script>
 
 
 
 
 
 
 
 <select id="select_type" class="select_type" name="service_type" disabled>
							<option></option>
							<option value="1">Blessing</option>
							<option value="2">Prayer</option>
							<option value="3">Funeral</option>
							<option value="4">Invocation</option>
							<option value="100">Other</option></select>
							
							