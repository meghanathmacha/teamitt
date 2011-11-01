<?php
if(!isset($_GET["key"]))
{
header("Location: .");
die();
}
$key= $_GET["key"];
$key= htmlspecialchars($key);

include("DB/initDB.php");
include("DB/registerDB.php");
$error = -1;

$rDB = new registerDB();

$userid = $rDB ->searchKey($key);
if(!$userid)
{
$error = 1;
}
else
{

if($rDB->activateUser($userid))
{
	$rDB->removeKey($key);
$error = 0;
	list($email, $fname) = $rDB->getUserBasicInfo($userid);
include("sendMail/sendMail.php");
$vars=array("email"=>$email, "name"=>$fname);
sendMail("Activate", $vars);
header("Location: activated.php");
die();
}
else
{
$error = 2;

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

<title>Activated your account - Teamitt</title>

<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/default.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="static/js/jquery-min.js"/></script>
</head>
<body>
<?php include("header-default.php"); ?>
<div id="content">
<div id="contentWrap">

<div class="article">
<h2>
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
    echo "Unknown error occured.";
    echo "</div>";
          break;
case 0:
    echo "<div class='succ' style='display: block;'>";
echo "Congratulations $fname, your account has been activated. <a href='login.php'><b>Click here</b></a> to login now.";
    echo "</div>";
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
