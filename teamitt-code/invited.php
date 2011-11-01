<?php
//$ikey ="631725d2dfe599978c8a";
if(!isset($_GET["ikey"]))
{
header("Location: .");
die();
}
$ikey= $_GET["ikey"];
$ikey= htmlspecialchars($ikey);

include("DB/initDB.php");
include("DB/registerDB.php");
$error = -1;

$rDB = new registerDB();

$key_info = $rDB ->getInviteKey($ikey);
if(is_int($key_info))
{
$error = 1;
}
else
{

$error =0 ;
list($email, $company_id, $company_name) = $key_info; 

if($rDB->checkExistingUser($email))
{
$rDB->removeInviteKey($ikey);
$error=1;
}
else
{

$fname ="";
$lname ="";
$title ="";
$gender ="";
$m_type ="";
$f_type ="";

if(isset($_POST["fname"]))
{

$fname = mysql_escape_string($_POST["fname"]);
$lname = mysql_escape_string($_POST["lname"]);
$title = mysql_escape_string($_POST["title"]);
$gender = $_POST["gender"];
$pass1 = $_POST["userpassword"];
$pass2 = $_POST["cuserpassword"];

if($fname == "" || $lname == "" || $title == "")
{
$error = 2;
}
else if(strlen($pass1) < 6) { $error = 3;}
else if($pass1 != $pass2) { $error = 4;}
else
{
$pass = md5("password=".$pass1);

$rDB->insertUser($email, $fname, $lname, $gender, $company_id, $tite, "", $pass, 1);
$uid = $rDB->getUserId($email);
if($uid)
{

include("sendMail/sendMail.php");
$vars=array("email"=>$email, "name"=>$fname);
sendMail("IRegister", $vars);
$rDB->removeInviteKey($ikey);
$error=6;
//Redirect where ?
}
else
{
$error = 5;
}

}
}

}


if($gender != "M") {
$f_type="selected='selected'";
} else {

$m_type="selected='selected'";
}




}



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="robots" content="noodp,noydir" />
<meta name="description" content="Teamitt is a real-time, on-the-job leadership and communication training tool that teams at corporations, teams at educational institutions can use to lead and work well in teams resulting in more successful and happy teams.">
<meta name="keywords" content="Teamitt, job leadership, team communication, work well">

<title>Get Connected at Teamitt</title>

<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/default.css" rel="stylesheet" type="text/css" />
<link href="static/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="static/js/jquery-min.js"/></script>
</head>
<body>
<?php include("header-default.php"); ?>
<div id="content">
<div id="contentWrap">

<div class="article">
<?php if($company_name) {
?>
<h2>Get connected with the <?php echo $company_name;?>'s network on Teamitt
</h2>
<?php
}
?>

<?php
switch($error)
{
case 1:
    echo "<div class='form-error' style='display: block;'>";
    echo "Invalid key entered. <a href='.'>Click here</a> to go home.";
    echo "</div>";
          break;
case 2:
    echo "<div class='form-error' style='display: block;'>";
    echo "Please fill all the fields.";
    echo "</div>";
	include("rform.php");
          break;
case 3:
    echo "<div class='form-error' style='display: block;'>";
    echo "Passowrd should be of atleast 6 characters.";
    echo "</div>";
	include("rform.php");
	break;
case 4:
    echo "<div class='form-error' style='display: block;'>";
    echo "Passwords are not matching.";
    echo "</div>";
	include("rform.php");
	break;
case 5:
    echo "<div class='form-error' style='display: block;'>";
    echo "Unknown error occured.";
    echo "</div>";
	include("rform.php");
	break;
case 6:
    echo "<div class='succ' style='display: block;'>";
echo "Thanks $fname for registering. <a href='login.php'><b>Click here</b></a> to login now.";
    echo "</div>";
	break;
case 0:
	include("rform.php");
	break;
default:
        break;

}

?>

</div>

</div>
</div>

<?php 
include("footer.php"); 
?>


</body>
</html>
