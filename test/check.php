<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
<script>
$(document).ready(function(){

$("#checkAll").click(function(){
		
	$(".checkBox").prop("checked",$("#checkAll").prop("checked"))
	
});
});
</script>


<input type="checkbox" id="checkAll"> All
    <br>
<input type="checkbox" class='checkBox'> 
<input type="checkbox" class='checkBox'> 
<input type="checkbox" class='checkBox'> 



