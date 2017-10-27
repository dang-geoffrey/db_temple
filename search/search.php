<!DOCTYPE HTML>
<?php 

include("../header.php"); 
include("../vertical_menu.php"); 

?>
<html>
<head>
<title>Search Members</title>
<style>
.ui-autocomplete-loading {
background: white url('/jquery/jquery-ui-1.9.2.custom/css/custom-theme/images/ui-anim.basic.16x16.gif') right center no-repeat;
}
</style>
<script>
$(function() {
$( "#contact_name" ).autocomplete({
  source: "contacts_source.php",
  minLength: 2
});

$( "#deceased_name" ).autocomplete({
  source: "deceased_source.php",
  minLength: 2
});

$( "#relative_name" ).autocomplete({
  source: "relatives_source.php",
  minLength: 2
});
});
</script>
</head>

<div id="wrapper">
	<div class='content'>
		<span class="headline">Search Members</span><br>
			<form action="contacts_search.php" method="post">
				<ul class="search">
					<li><span>Contact Name:</span> <input type="text" name='full_name' id="contact_name" />
					<input type="submit" value=" Search Contacts " id="contact_name"></li>
				</ul>
			</form><br>
			<form action="deceased_search.php" method="post">
				<ul class="search">
					<li><span>Deceased Name:</span> <input type="text" name="full_name" id="deceased_name" />
					<input type="submit" value=" Search Deaceased"></li>
				</ul>
			</form><br>
			<form action="relatives_search.php" method="post">
				<ul class="search">
					<li><span>Relative Name:</span> <input type="text" name='full_name' id="relative_name" />
					<input type="submit" value=" Search Relatives"></li>
				</ul>
			</form>
	</div>
</div>

<?php include("../footer.php"); ?>
</html>