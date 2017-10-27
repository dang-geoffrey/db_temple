<script src="http://code.jquery.com/jquery-1.8.3.js"></script>

<script>
function decision(message, url)
{
    if(confirm('Delete ' + '\"' + message + '\"' + "\n\nAre you sure?"))
        location.href = url;
};

$(document).ready(function() 
{
$(".editLink").click(function(e)
{
	e.preventDefault(); 
	//get id value
	var deceased_delete = $(this).attr('href');
	$.ajax({
            url: deceased_delete
            
        });

});

});
</script>

<?php


for($i=1; $i < 10; $i++)
{
print "<br>$i <a href='javascript:decision($i, edit.php?id1=$i)' class=editLink>Edit</a>";
}
?>
