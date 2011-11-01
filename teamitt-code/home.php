<?php
include("checkid.php");

require("DB/initDB.php");
require("DB/usersDB.php");
require("DB/goalsDB.php");
$uDB = new usersDB();
$gDB = new goalsDB();


$company_id = $uDB->getCompanyId($USERID);
$company_name = $uDB->getCompanyName($USERID);
$COMPANY_ID = $company_id;



$now=time();
$startDate=$uDB->getCompanyBadgeGivingStartDate($COMPANY_ID);
$startTime=strtotime($startDate);
$days=((int)(($now-$startTime)/(60*60*24)));
$frequency=$uDB->getCompanyFrequency($COMPANY_ID);
$betweenDays=$days%$frequency;
$result=$updateBit=$uDB->getUpdateBit($COMPANY_ID);
while($row=mysql_fetch_row($result)){
$updateId=$row[1];
$updateBit=$row[0];
}
if($betweenDays == ($frequency-1) || ($updateBit==0 && ($betweenDays < $frequency) )){
if(!$updateBit){
$uDB->updateUpdateBit($updateId);
}
$uDB->updateBadgePoints($COMPANY_ID);
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="robots" content="noodp,noydir" />
<title><?php echo $company_name;?> - Teamitt </title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/page.css" rel="stylesheet" type="text/css" />
<link href="static/css/feeds.css" rel="stylesheet" type="text/css" />
<link href="static/css/goals.css" rel="stylesheet" type="text/css" />
<link href="static/css/button_new.css" rel="stylesheet" type="text/css" />
<link href="static/css/events.css" rel="stylesheet" type="text/css" />
<link href="static/css/datePicker.css" rel="stylesheet" type="text/css" />
<link href="static/css/edit_date.css" rel="stylesheet" type="text/css" />
<link href="static/css/attach_goal.css" rel="stylesheet" type="text/css" />
<link href="static/css/tabs.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="static/js/jquery-min.js"/></script>
<script type="text/javascript" src="static/js/post.js"/></script>
<script type="text/javascript" src="static/js/feeds.js"/></script>
<script type="text/javascript" src="static/js/search.js"/></script>
<script type="text/javascript" src="static/js/companypic.js"/></script>
<script type="text/javascript" src="static/js/goal.js"/></script>
<script type="text/javascript" src="static/js/date.js"/></script>
<script type="text/javascript" src="static/js/pop.js"/></script>
<script type="text/javascript" src="static/js/jquery.datePicker.js "/></script>
<script>
var PROFILEUSERID = <?php echo $USERID;?>;
</script>
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
<div id="contentWrap">

<div id="leftCont">

<?php include("home-leftCont.php"); ?>
</div>
<div id="mainCont">
<?php include("home-mainCont.php"); ?>
</div>
<div id="riteCont">
<?php include("home-rightCont.php"); ?>
</div>


</div>
<div class="clr"></div>

</div>

<?php 
include("footer.php"); 
?>


<div id="eventCont">
<div id="eventWrap">
<div class="eload"></div>
<div class="etext"></div>
</div>
</div>

</body>
</html>
