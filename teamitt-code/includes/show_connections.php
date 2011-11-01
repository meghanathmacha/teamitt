<?php
require_once('../checkid.php');
require_once("../DB/initDB.php");
require_once("../DB/feedsDB.php");
$feedsDB = new feedsDB();
$feed_id = isset($_GET['feed_id']) ? $_GET['feed_id'] :0;
$type_name = isset($_GET['type_name']) ? $_GET['type_name'] :1;

$result = $feedsDB -> getConnectionsByUserId($USERID,$feed_id,$type_name);
$content_html = '';
$header_html = '';
$count = 0;
while(($row = mysql_fetch_array($result))!= null)
{
	$first_name = $row["first_name"];
	$last_name = $row["last_name"];
	$img_src = $row["image_src"];
	$connection_id = $row["id"];
	$img_src = "uploads/profileimg/profileimg-$connection_id.jpg";
	
	if(!file_exists("../".$img_src))
		$img_src = "static/images/user_icon.png";
	$flag = $row["flag"];
	if($flag == 1)
		$count++;
 $content_html .= "<div class='reward-wrap'>";
if($flag == 1)
	$content_html .= "<div class='reward rselected' rewardid='$connection_id'>";
else if($flag == null)
	$content_html .= "<div class='reward first_time' rewardid='$connection_id'>";
else if($flag == 0)
	$content_html .= "<div class='reward' rewardid='$connection_id'>";
$content_html .= "<div class='reward-img'>";
$content_html .= "<img src='$img_src' width='190px' />";
$content_html .= "</div>";
$content_html .= "<div class='reward-title'>$first_name</div>";
$content_html .= "</div>";
$content_html .= "</div>";
}
$content_html .= "<div class='clr'></div>";
$content_html .= "</div>";
$content_html .= "</div>";
$content_html.=  "<div id='eventFooter'>";
$content_html .= '<input type="button" value="Done" onClick="submitConnections('.$feed_id.');"/>';
$content_html .= '<div class="clr"></div>';
$content_html .= "</div>";
$header_html .=  "<div id='eventHeader'><span onClick='closeEvent();'></span>Select Users to Share this Feed(<strong id='rC'>$count</strong>)</div>";
$header_html .= "<div class='rewards'>";
$content_html = $header_html.$content_html;
echo $content_html;

?>
