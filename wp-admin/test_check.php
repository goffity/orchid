<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
// Count the number of times a substring is in a string.
String.prototype.substrCount =
function(s) {
return this.length && s ? (this.split(s)).length - 1 : 0;
};

// Return a new string without leading and trailing whitespace
// Double spaces whithin the string are removed as well
String.prototype.trimAll =
function() {
return this.replace(/^\s+|(\s+(?!\S))/mg,"");
};

//event handler
function loadContentResult(username) {
if(username.substrCount(' ') > 0)
{
$("#actionresult").hide();
$("#actionresult").load("user.php?msg=whitespace", '', callbackResult);
}
else
{
$("#actionresult").hide();
$("#actionresult").load("user.php?username="+username.trimAll()+"", '', callbackResult);
}
}

//callback
function callbackResult() {
$("#actionresult").show();
}

//ajax spinner
$(function(){
$("#spinner").ajaxStart(function(){
$(this).html('<img src="image/wait.gif" />');
});
$("#spinner").ajaxSuccess(function(){
$(this).html('');
});
$("#spinner").ajaxError(function(url){
alert('Error: server was not respond, communication interrupt. Please try again in a few moment.');
});
});
</script>


</head>

<body>
<form id="form1" name="form1" method="post" action="">
<fieldset>
<legend>Check Username Availability</legend>
<label>Username <span class="require">(* requiered: alphanumeric, without white space, and minimum 4 char</span></label>

<input type="text" name="username" id="username" size="15" maxlength="15" onchange="loadContentResult(this.value)" />
<div id="spinner"></div>
<div id="actionresult"></div>
<div class="clear"></div>
<label>Email:</label>

<input type="text" name="email" id="email" size="30" maxlength="255" />
<div class="clear"></div>
<input type="submit" name="submit" id="submit" value="Register" />
</fieldset>
</form>

</body>
</html>
