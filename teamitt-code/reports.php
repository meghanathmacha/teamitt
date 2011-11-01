<?php
include("checkid.php");
include("DB/initDB.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<noscript> <meta http-equiv="refresh" content="0; URL=/?noscript=1" /> </noscript>
<meta name="robots" content="noodp,noydir" />
<meta name="description" content="Teamitt is a real-time, on-the-job leadership and communication training tool that teams at corporations, teams at educational institutions can use to lead and work well in teams resulting in more successful and happy teams.">
<meta name="keywords" content="Teamitt, job leadership, team communication, work well">

<title>Profile Settings - Teamitt</title>

<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/page.css" rel="stylesheet" type="text/css" />
<link href="static/css/setting.css" rel="stylesheet" type="text/css" />
<link href="static/css/form.css" rel="stylesheet" type="text/css" />
<link href="static/css/datePicker.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="static/js/jquery-min.js"/></script>
<script type="text/javascript" src="static/js/date.js"/></script>
<script type="text/javascript" src="static/js/jquery.datePicker.js"/></script>
<link href="static/css/tablesorter_blue.css" rel="stylesheet" type="text/css" />
<link href="static/css/reports.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/reports.js"/></script>
<script type="text/javascript" src="static/js/tablesorter.js"/></script>
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
<div id="contentWrap">

<div id="leftCont">

<?php include("reports-tab.php"); ?>

</div>
<div id="mainCont">
<?php include("reports-in.php") ?>
</div>
<div id = "riteCont">
<?php include("reports-filter.php") ?>
</div>
</div>
<div class="clr"></div>
</div>
<?php 
include("footer.php"); 
?>
</body>
</html>
