<?php
include("checkid.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="robots" content="noodp,noydir" />
<meta name="description" content="Teamitt is a real-time, on-the-job leadership and communication training tool that teams at corporations, teams at educational institutions can use to lead and work well in teams resulting in more successful and happy teams.">
<meta name="keywords" content="Teamitt, job leadership, team communication, work well">


<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/page.css" rel="stylesheet" type="text/css" />
<link href="static/css/datePicker.css" rel="stylesheet" type="text/css" />
<link href="static/css/goals.css" rel="stylesheet" type="text/css" />
<link href="static/css/edit_date.css" rel="stylesheet" type="text/css" />
<link href="static/css/attach_goal.css" rel="stylesheet" type="text/css" />
<link href="static/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="static/css/button_new.css" rel="stylesheet" type="text/css" />
<link href="static/css/events.css" rel="stylesheet" type="text/css" />
<link href="static/css/feeds.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="static/js/jquery-min.js"/></script>
<script type="text/javascript" src="static/js/date.js"/></script>
<script type="text/javascript" src="static/js/jquery.datePicker.js"/></script>
<script type="text/javascript" src="static/js/pop.js"/></script>
<script type="text/javascript" src="static/js/selectparam.js"/></script>
<script type="text/javascript" src="static/js/flash.js"/></script>
<script type="text/javascript" src="static/js/attach_goal.js"/></script>
<script type="text/javascript" src="static/js/feeds.js"/></script>
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
<div id="contentWrap">

<div id="leftCont">

<?php 
$post_id = $_GET['id'];
$TYPE_NAME = 3;
include("feeds.php"); 

if($feed_from == $USERID)
	$feed_from_name = "Your";
?>

</div>
<div id="mainCont">
</div>
<div id = "riteCont">
</div>
</div>
<div class="clr"></div>
</div>
<title><?php echo $feed_from_name;?>'s post</title>
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
