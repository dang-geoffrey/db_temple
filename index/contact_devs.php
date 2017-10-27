<!DOCTYPE HTML>
<?php 

include("../header.php"); 
include("../vertical_menu.php"); 

?>

<head>
<title>Contact Developers</title>
</head>
<div id="wrapper">
	<div class='content'>
		<span class="headline">Contact Developers</span>
			<p id="feedback">Use the form below to send us your comments or report any problems you experienced finding 
			information on our website. We read all feedback carefully, but please note that we cannot respond 
			to the comments you submit.</p>
			<form action="" method="post">
				<ul class="search">
					<li><span>Name:</span> <input type="text" name='name' /></li>
					<li><span>Comments:</span> <textarea maxlength='800' rows="5" name="comments"></textarea></li>
					<li><input type="submit" value=" Submit Feedback "></li>

				</ul>
			</form>
	</div>
</div>

<?php include("../footer.php"); ?>