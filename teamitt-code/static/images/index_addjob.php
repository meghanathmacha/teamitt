<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
</style>
<title>Startup World - Goalcat</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name = "description" content = "startup world" >
<meta name = "keywords" content = "companies,ratings,startup,goalcat" >
<link href="/static/css/style.css" media="" rel="stylesheet" type="text/css" />
<link href="/static/css/rating_css.css" media="" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/events.css" type="text/css" />
<script type="text/javascript" src="/static/js/cufon-yui.js"></script>
<script type="text/javascript" src="/static/js/arial.js"></script>
<script type="text/javascript" src="/static/js/cuf_run.js"></script>
<script src="/static/js/jquery-latest.js" type="text/javascript"></script>
<script src="/static/js/rating_js.js" type="text/javascript"></script>
<script src="/static/js/saveuser.js" type="text/javascript"></script>

<!-- Addevent css -->
<script type="text/javascript" src="/static/js/jquery-ui-1.8.6.custom.min.js"></script>
 <script src="/static/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
  <link rel='stylesheet' href="/static/css/jquery-ui-1.8.6.custom.css" type="text/css" />

</head>
<body>
<div id="header">
<div class='fbbut'>
<fb:login-button autologoutlink='true' perms='email,user_birthday,status_update,publish_stream,user_photos,user_events,friends_events,user_groups,friends_groups,user_activities,friends_activities,user_photos,friends_photos,user_photo_video_tags,friends_photo_video_tags'></fb:login-button> 
</div>
<div id='logo'>
<h1>Goalcat</h1>
<h3>Startup World</h3>
</div>
</div>
<div id="fb-root"></div> 
<script src="/static/js/fblogin.js" type="text/javascript"></script> 
<script src="/static/js/newItem.js" type="text/javascript"></script>
</div>
<div id="content">
<div class='top'>

<?php
			require("includes/action_user.php");
			require_once("DB/initDB.php");
			require_once("DB/widgetDB.php");
			include("DB/eventDB.php");
			$DB = new widgetDB();
			$eDB = new eventDB();
			if(!$DB->status)
			{
			die("Connection Error");
			exit;
			}
$flag=0;
$start=1;
if(isset($_GET['start'])){
	$start=$_GET['start'];
}
$run=$_GET['run'];
$point=65;

while($point!=91){
	?>
		<div class='elem'>
		<a href='?start=1&run=<?php echo chr($point); ?>'><?php echo chr($point); ?></a>
		</div>
		<?php
		$point+=1;
}
?>
</div>
<div class='change' id='topchange'>
</div>
<div class='border'>
<?php
$file=fopen("companies","r");
$char="";
if(isset($_GET['run'])){
	$char=strToUpper($_GET['run']);
}

$offset=($start-1)*8;
$over=0;
while($over!=$offset) {
	$line=fgets($file);
	if($run!="" && strToUpper($line[0])==$char){
		$over++;
	}
	else if($run==""){
		$over++;
	}
	
}

$offset=$offset+8;

while(($line=fgets($file))!==false) {
	if($char!="" && strToUpper($line[0])!=$char){ continue;}
	if($over==$offset){
		break;
	}
	$over++;	
	echo "<div class='img'>";
	$val=split("\t",$line);
	$count=count($val);
	?>
              <div class='tabs'>   
              <img src='/static/images/jobs-icon3.png' width='32' />
            </div>
		<div class='image'>
		<div class='cont'>
		<?php	if($count==3){?>
			<img align='middle' src="<?php echo $val[1]; ?>" alt='Add Image' width='120' />
				<?php }
	else{
		?>
			<img align='middle' src='' alt='Add Image' width='120' />
			<?php echo $val[$count-1]; ?>
			<?php } ?>
			</div>
		<div class='fund'><strong><?php echo $val[0];?></strong><br> ( Funding : $<?php echo $val[$count-1]/1000000; ?>M )</div>

			</div>
                       <div class="events">
                       	<ul>
			<?php $events=$eDB->getEvents($val[0]);
			while($row=mysql_fetch_row($events)) {
 			?>
  			<li >
			<a href='#' title="<?php echo $row[1];?>" onClick="showpop('event',<?php echo $row[0];?>);return false;">
			<?php echo substr($row[1],0,6); if(strlen($row[1])>6) { echo "..";} ?>
			</a>
			</li>
 			<?php } ?>
			</ul>
			</div>
			<div class='desc'>
			<table>
			<tr>
			<td>Team</td>
			<td><div id='<?php echo $val[0]; ?>.team' rater_fbid='FB.getSession().uid' class='rate_widget'><div class='star_1 ratings_stars'></div><div class='star_2 ratings_stars'></div><div class='star_3 ratings_stars'></div><div class='star_4 ratings_stars'></div><div class='star_5 ratings_stars'></div></div></td>
			</tr>
			<tr>
			<td>Market</td>
			<td><div id='<?php echo $val[0]; ?>.market'  rater_fbid='FB.getSession().uid' class='rate_widget'><div class='star_1 ratings_stars'></div><div class='star_2 ratings_stars'></div><div class='star_3 ratings_stars'></div><div class='star_4 ratings_stars'></div><div class='star_5 ratings_stars'></div></div></td>
			</tr>
			<tr>
			<td>Technology</td>
			<td><div id='<?php echo $val[0]; ?>.technology'  rater_fbid='FB.getSession().uid' class='rate_widget'><div class='star_1 ratings_stars'></div><div class='star_2 ratings_stars'></div><div class='star_3 ratings_stars'></div><div class='star_4 ratings_stars'></div><div class='star_5 ratings_stars'></div></div></td>
			</tr>
			<tr>
			<td>Investors</td>
			<td><div id='<?php echo $val[0]; ?>.funding' rater_fbid='FB.getSession().uid' class='rate_widget'><div class='star_1 ratings_stars'></div><div class='star_2 ratings_stars'></div><div class='star_3 ratings_stars'></div><div class='star_4 ratings_stars'></div><div class='star_5 ratings_stars'></div></div></td>
			</tr>
			<tr>
			<td>Business Model</td>
			<td><div  id='<?php echo $val[0]; ?>.business_model' rater_fbid='FB.getSession().uid' class='rate_widget'><div class='star_1 ratings_stars'></div><div class='star_2 ratings_stars'></div><div class='star_3 ratings_stars'></div><div class='star_4 ratings_stars'></div><div class='star_5 ratings_stars'></div></div></td>
			</tr>
                       			</table>
			</div>
			
			<?php 
			$action_userhtml = actionUserhtml($val[0],$DB);
			if($action_userhtml)
				echo "<div class = 'action_user'>$action_userhtml</div>";
			?>
			</div>
			<?php
}
?>
</div>
<div class='clr'></div>
</div>
<br><br>
<div class='change' id='downchange'>

<?php
if($over!=$offset)
{
        $flag=1;
}
if($start!=1){
        $st=$start-1;
	if($run==""){
		echo "<span><a title='Previous' href='?start=".$st."'><img src='http://www.phoca.cz/demo/components/com_phocagallery/assets/images/icon-prev.gif'></a></span>";
	}
	else{
		echo "<span><a title='Previous' href='?start=".$st."&run=".$run."'><img src='http://www.phoca.cz/demo/components/com_phocagallery/assets/images/icon-prev.gif'></a></span>";
	}
}
if($flag!=1){
	$st=$start+1;
	if($run==""){
		echo "<span><a title='Next' href='?start=".$st."'><img src='http://www.phoca.cz/demo/components/com_phocagallery/assets/images/icon-next.gif'></a></span>";
	}
	else{
		echo "<span><a title='Next' href='?start=".$st."&run=".$run."'><img src='http://www.phoca.cz/demo/components/com_phocagallery/assets/images/icon-next.gif'></a></span>";
	}
}
?>
</div>

<div class='clr'></div>
<?php include("footer.php");?>
<div id="eventCont">
<div id='eventWrap'>
<div class='etext'></div>
<div class='eload'></div>
</div>
</div>
</body>
</html>
