<?php
include("../DB/initDB.php");
include("../DB/usersDB.php");
include("../DB/badgeDB.php");
include("../checkid.php");
$uDB= new usersDB();
$DB = new badgeDB();
if(!$DB->status)
{
	exit;
}
$remainingPoints=$uDB->getUserRemainingPoint($USERID);
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Select Badge</div>";
echo "<div id='badgeList'>";
$compId=$uDB->getCompanyId($USERID);
$badges=$DB->getBadgesByCompanyId($compId);
while($badge=mysql_fetch_row($badges))
{
if($remainingPoints < $badge[3]){
echo "<div class='cant-select-badge' badgeid='$badge[0]'>";
echo "<img src='../static/images/lock.png' style='vertical-align:top;'/>";
}
else{
echo "<div class='select-badge' badgeid='$badge[0]'>";
}
echo "<img src='$badge[2]' width='60px'/>";
echo "<div class='badgename'>$badge[1]</div>";
echo "<div><span style='font-size:10px;'>Badge Points: $badge[3] </span></div>";
echo "</div>";
}
echo "<div class='clr'></div>";
echo "</div>";



?>
