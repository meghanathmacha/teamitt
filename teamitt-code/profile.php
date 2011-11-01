<?php
include("checkid.php");
require("DB/initDB.php");
require("DB/usersDB.php");
require("DB/goalsDB.php");
require("DB/reportDB.php");
$uDB = new usersDB();
$gDB=new goalsDB();
$reportDB = new reportDB();
$PROFILEID = 0;
$user_compid = $uDB->getCompanyId($USERID);
if(isset($_GET["id"]))
{
$PROFILEID = mysql_escape_string($_GET["id"]);
$compid = $uDB->getCompanyId($PROFILEID);
$fullname = $uDB->FullName($PROFILEID);
$firstname = $uDB->firstName($PROFILEID);


if( $PROFILEID == $USERID || is_int($fullname) || $user_compid != $compid)
{
header("Location: profile.php");
die();
}

$company_id = $compid;

} 
else
{
$fullname = $uDB->FullName($USERID);
$firstname = $uDB->firstName($USERID);
$company_id = $user_compid;
}



?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="robots" content="noodp,noydir" />
<title><?php echo $fullname;?> - Teamitt</title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/page.css" rel="stylesheet" type="text/css" />
<link href="static/css/feeds.css" rel="stylesheet" type="text/css" />
<link href="static/css/goals.css" rel="stylesheet" type="text/css" />
<link href="static/css/edit_date.css" rel="stylesheet" type="text/css" />
<link href="static/css/attach_goal.css" rel="stylesheet" type="text/css" />
<link href="static/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="static/css/button_new.css" rel="stylesheet" type="text/css" />
<link href="static/css/datePicker.css" rel="stylesheet" type="text/css" />
<link href="static/css/events.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="static/js/jquery-min.js"/></script>
<script type="text/javascript" src="static/js/pop.js"/></script>
<script type="text/javascript" src="static/js/selectparam.js"/></script>
<script type="text/javascript" src="static/js/flash.js"/></script>
<script type="text/javascript" src="static/js/date.js"/></script>
<script type="text/javascript" src="static/js/jquery.datePicker.js"/></script>
<script type="text/javascript" src="static/js/attach_goal.js"/></script>
<?php if($PROFILEID) { ?>
<script type="text/javascript" src="static/js/post-profile.js"/></script>
<script>
var plarray = new Array();
plarray["action"] = "Post actions for <?php echo $fullname;?>";
plarray["thank"] = "Give thanks to <?php echo $fullname;?>";
plarray["giveFeedback"] = "Give feedback to <?php echo $fullname;?>";
plarray["askFeedback"] = "Ask feedback from <?php echo $fullname;?>";
</script>

<?php } else { ?>
<script type="text/javascript" src="static/js/post.js"/></script>

<?php } ?>
<script type="text/javascript" src="static/js/search.js"/></script>
<script type="text/javascript" src="static/js/feeds.js"/></script>
<script type="text/javascript" src="static/js/goal.js"/></script>

<script>
var PROFILEUSERID = <?php echo $USERID;?>;
</script>

</head>
<body>
<?php include("header.php"); ?>
<div id="content">
<div id="contentWrap">
<div id="leftCont">

<?php include("profile-leftCont.php"); ?>
</div>
<div id="mainCont">
<?php include("profile-mainCont.php"); ?>
</div>
<div id="riteCont">
<?php include("profile-rightCont.php"); ?>
</div>


</div>
<div class="clr"></div>

</div>

<div id="eventCont">
<div id="eventWrap">
<div class="eload"></div>
<div class="etext"></div>
</div>
</div>

<?php 
include("footer.php"); 
?>



</body>
</html>
