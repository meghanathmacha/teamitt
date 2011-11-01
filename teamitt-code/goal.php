<?php
include("checkid.php");
if(isset($_GET['id'])){
$GoalId=$_GET['id'];
}
else{
header('Location: home.php');
die();
}
require("DB/initDB.php");
require("DB/goalsDB.php");
require("DB/usersDB.php");
$gDB = new goalsDB();
$uDB=new usersDB();
$result=$gDB->getGoalsById($GoalId);
if($result==0){
header('Location: home.php');
die();
}
while($row=mysql_fetch_row($result)){
$GoalName=$row[0];
$GoalImageSrc=$row[1];
$GoalObjective=$row[2];
$GoalDueDate=$row[3];
$GoalKeyResult=$row[4];
$CreatorFName=$row[5];
$CreatorLName=$row[6];
$CreatorId=$row[7];
$GoalProgress=$row[8];
$GoalAddTime=$row[9];
}

$owner = $CreatorId;

$canedit=$gDB->isGoalContributor($GoalId,$USERID);
if($GoalProgress=="Close"){
$canedit=0;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="robots" content="noodp,noydir" />
<title><?php echo $GoalName ?></title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/goals.css" rel="stylesheet" type="text/css" />
<link href="static/css/page.css" rel="stylesheet" type="text/css" />
<link href="static/css/feeds.css" rel="stylesheet" type="text/css" />
<link href="static/css/button_new.css" rel="stylesheet" type="text/css" />
<link href="static/css/events.css" rel="stylesheet" type="text/css" />
<link href="static/css/datePicker.css" rel="stylesheet" type="text/css" />
<link href="static/css/edit_date.css" rel="stylesheet" type="text/css" />
<link href="static/css/attach_goal.css" rel="stylesheet" type="text/css" />
<link href="static/css/tabs.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="static/js/jquery-min.js"/></script>
<script type="text/javascript" src="static/js/post-goal.js"/></script>
<script type="text/javascript" src="static/js/search.js"/></script>
<script type="text/javascript" src="static/js/goal.js"/></script>
<script type="text/javascript" src="static/js/date.js"/></script>
<script type="text/javascript" src="static/js/pop.js"/></script>
<script type="text/javascript" src="static/js/feeds.js"/></script>
<script type="text/javascript" src="static/js/jquery.datePicker.js "/></script>
<script type="text/javascript" src="static/js/flash.js"/></script>
<script type="text/javascript" src="static/js/selectparam.js "/></script>
<script>
var GOAL_ID = <?php echo $GoalId;?>;

</script>
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
<div id="contentWrap">
<div id='try'></div>
<div id="leftCont">

<?php include("goal-leftCont.php"); ?>
</div>
<div id="mainCont">
<?php include("goal-mainCont.php"); ?>
</div>
<div id="riteCont">
<?php include("goal-rightCont.php"); ?>
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
