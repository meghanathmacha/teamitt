<?php
$useremail ="";
$userpassword ="";
$error=0;
if(isset($_GET["email"]))
{
$useremail =$_GET["email"];
}
include("includes/verify.php");

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="description" content="Teamitt is a real-time, on-the-job leadership and communication training tool that teams at corporations, teams at educational institutions can use to lead and work well in teams resulting in more successful and happy teams.">
<meta name="keywords" content="Teamitt, job leadership, team communication, work well">

<title>Welcome to Teamitt - Teamitt</title>

<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/default.css" rel="stylesheet" type="text/css" />
<link href="static/css/form.css" rel="stylesheet" type="text/css" />
<link href="static/css/button_new.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="static/js/jquery-min.js"/></script>
<script type="text/javascript" src="static/js/post.js"/></script>
</head>
<body>
<?php include("header-default.php"); ?>
<div id="content">
<div id="contentWrap">

<div class="article">
<h2>Welcome to Teamitt
</h2>

<form action="" method="post" id="loginform">
<ol>
<li>
<?php
switch($error)
{
case 1:
    echo "<div class='err' style='display: block;'>";
    echo "Username/password not provided";
    echo "</div>";
          break;
case 2:
    echo "<div class='err' style='display: block;'>";
    echo "Please enter valid email address.";
    echo "</div>";
          break;
case 3:
    echo "<div class='err' style='display: block;'>";
    echo "Wrong username/password given.";
    echo "</div>";
default:
        break;

}

?>

</li>
<li>
<label>Email</label>
<input type="email" name="useremail" required="true" value="<?php echo $useremail;?>" class="text" placeholder="Enter your email here" maxlength="75" id="useremail">
</li>
<li>
<label>Password</label>
<input type="password" name="userpassword" value="<?php echo $userpassword;?>" class="text" placeholder="Enter your password" required="true" id="userpassword">
</li>
<li>
<label></label>
<input type="submit" value="Submit" class="button"> Not registered ? <a href="register.php"><strong>Sign up now</strong></a>
</li>
</ol>
</form>

</div>

</div>
</div>

<?php 
include("footer.php"); 
?>

<script type="text/javascript">
function setFocus() {
              loginform = document.getElementById('loginform');
              if (loginform.useremail && (loginform.useremail.value == null || loginform.useremail.value == '')) {
                    loginform.useremail.focus();
              } 
              else if (loginform.userpassword) {
                            loginform.userpassword.focus();
                              }
                }
       
  window.onload = setFocus;
</script>

</body>
</html>
