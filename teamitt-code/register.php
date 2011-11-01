<?php
$errro = 0;
if(isset($_GET["error"]))
{
$error= $_GET["error"];
}
?>

<!DOCTYPE html>
<html lang="en" id="teamitt">
<head>

<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=noscript.html" /> </noscript>
<meta name="description" content=" Teamitt "/>
<meta name="description" content="Teamitt is a real-time, on-the-job leadership and communication training tool that teams at corporations, teams at educational institutions can use to lead and work well in teams resulting in more successful and happy teams."/>
<meta name="keywords" content="Teamitt, job leadership, team communication, work well"/>

<title>Register at Teamitt</title>
<link type="text/css" rel="stylesheet" href="static/css/style.css" />
<link type="text/css" rel="stylesheet" href="static/css/default.css" />
<link href="/static/css/form.css" rel="stylesheet" type="text/css" />
<link href="/static/css/button_new.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-min.js"></script>

<script type="text/javascript">
var VALIDMAIL=0;
function isValidEmail(){
	var email=$("#email").val();
	var flag=0;
	VALIDMAIL=0;
	$(".busy").addClass("loading");
	$.post("includes/checkEmail.php",{email:email},function(data){
	$(".busy").removeClass("loading");
			if(data==1){
				$("#e-mail").html("Email address is not valid").fadeIn();
			}
			else if(data==2){
				$("#e-mail").html("Please use any private email address.").fadeIn();
			}
			else if(data==3){
				$("#e-mail").html("Email already registered, <a href='forgot.php'>Forgot Password ?</a>").fadeIn();
			}
			else if(data==4){
				$("#e-mail").fadeOut();
				VALIDMAIL=1;
			}
			});
}

function isValidPassword(){
	var password=$("#password").val();
	if(password.length < 6){
		$("#e-pass").html("Password should be minimum of 6 characters").fadeIn();
		return false;
	}
	return true;
}

function isMatchingPassword(){
	var password=$("#password").val();
	var cpassword=$("#cpassword").val();
	if(password.length <6 || password == cpassword){
	return true;
	}
else { 
		$("#e-cpass").html("Passwords are not matching.").fadeIn();
		return false;
}

}

$("document").ready(function () {

$("#regForm").submit(function () {

	var email=$("#email").val();
	var fname=$("#fname").val();
	var lname=$("#lname").val();
	fname = $.trim(fname);
	lname = $.trim(lname);
	var flag=0;
	
	if(!VALIDMAIL){
		flag=1;
		$("#email").addClass("blank").focus();
	} 
	else { $("#e-mail").fadeOut(); }
	if(fname.length == 0){
		flag=1;
		$("#fname").addClass("blank").focus();
	}
	if(lname.length == 0){
		flag=1;
		$("#lname").addClass("blank").focus();
	}
	if(!isValidPassword()){
		flag=1;
		$("#password").addClass("blank").focus();
		$("#cpassword").val("");
	}
	else { $("#e-pass").fadeOut(); }
	if(!isMatchingPassword()){
		flag=1;
		$("#cpassword").addClass("blank").focus();
	}
	else { $("#e-cpass").fadeOut(); }


if(flag) {
return false;
}

});

});

</script>

</head>
<body>
<div id="flash">
</div>
<div id="header">
<div class='cont'>
<h1><a href='.'><img src="static/images/logo.png" alt="Teamitt"/></a></h1>
</div>
</div>


<div id="content">
<div class="contentWrapper">
<div class="article">
<h2><span>Sign for your new account</span></h2>
</div>
</div>
<div class="article">
<?php
switch($error)
{
case 1:
    echo "<div class='form-error' style='display: block;'>";
    echo "Please enter valid email address.";
    echo "</div>";
          break;
case 2:
    echo "<div class='form-error' style='display: block;'>";
    echo "Please use any private email adress(of your organisation).";
    echo "</div>";
          break;
case 3:
    echo "<div class='form-error' style='display: block;'>";
    echo "User already exist . <a href='forgot.php'>Forgot Password ?</a>";
    echo "</div>";
	break;
case 4:
    echo "<div class='form-error' style='display: block;'>";
    echo "Password should be atleast 6 chars.";
    echo "</div>";
	break;
case 5:
    echo "<div class='form-error' style='display: block;'>";
    echo "Passwords are not matching.";
    echo "</div>";
	break;


case 6:
    echo "<div class='form-error' style='display: block;'>";
    echo "Unknown error occured.";
    echo "</div>";
	break;
default:
        break;

}

?>

<div class="clr"></div>
	<form action="includes/registerUser.php" method="post" id="regForm">
	   <ol>
              <li>
		<label for="fname">First Name:</label>
                <input type="text" id="fname"  placeholder="Your first name" name="fname" class="text" required="true" />
<div class='err' id="e-fname"></div>
              </li>

              <li>
		<label for="lname">Last Name:</label>
                <input type="text" id="lname"  placeholder="Your last name" name="lname" class="text" required="true" />
<div class='err' id="e-lname"></div>
              </li>
              <li>
		<label for="gender">I am :</label>
		<select name="gender" id="gender">

		<option value="M">Male</option>
		<option value="F">Female</option>
		</select>
              </li>



              <li>
		<label for="email">Email:</label>

                <input type="email" id="email"  placeholder="Enter your work email" name="email" class="text" onblur="isValidEmail()" required="true" /><span class='busy'></span>
<div class='err' id="e-mail"></div>
              </li>



              <li>
		<label for="password">Password:</label>
                <input type="password" id="password"  placeholder="Your password" onblur="isValidPassword()" name="password" class="text" required="true" />
		<small>( minimum of 6 characters)</small>

<div class='err' id="e-pass"></div>
              </li>
              <li>
		<label for="cpassword">Confirm Password:</label>
                <input type="password" id="cpassword"  placeholder="Re-enter password" name="cpassword" class="text" required="true" />
<div class='err' id="e-cpass"></div>
              </li>

              <li>
		<label for="title">Title:</label>

                <input id="title"  placeholder="Title" name="title" class="text" required="true" />
              </li>
              <li>
		<label for="phone">Phone:</label>
                <input id="phone"  placeholder="Phone No." name="phone" class="text" required="true" />
              </li>
 <li>
<label></label>
                <input type="submit" name="regForm" id="regForm" value="Submit"  class="send button" />
Already Registered ? <a href='login.php'><b>Login here</a>.

<span id="formLoad"></span>
<span class="formerr"></span>
</li>
</ol>
</form>
</div>


</div>

</div>
<div id="footer">
<a href=".">Home</a>
<span class="pipe">|</span>
<a href="about.html">About</a>

<span class="pipe">|</span>
<a href="contact.html">Contact</a>
<span class="pipe">|</span>
<a href="http://blog.teamitt.com/" target="_blank">Blog</a>
<br/>
<br/>
&copy; 2011 Teamitt, All Rights Reserved.
</div>
</body>
</html>

