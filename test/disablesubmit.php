<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>

<form name="form" method="post" action="go.asp">

<select name="UserID onchange="this.form.submitbutton.disabled=this.options[this.selectedIndex].value=='">
  <option value="">Please Selectio</option>
  <option value="1">Tom</option>
  <option value="2">Dave</option>
  <option value="3">Pete</option>
</select>

...and a submit button....

<input name="submitbutton" type="submit" value="Go" disable="disabled">

</form>