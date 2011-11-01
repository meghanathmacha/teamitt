<?php
function showevent($id,$DB)
{
echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Showing Event</div>";
$event = $DB->getEvent($id);
$row=mysql_fetch_row($event);
echo "<div class='eventData'>";
echo "<h2>$row[0]</h2>";
echo "<ul>";
echo "<li>$row[3]</li>";
echo "<li>at: $row[2], $row[1]</li>";
echo "<li>on: $row[4]</li>";

echo "</ul>";
echo "</div>";



}


include("../DB/initDB.php");
include("../DB/eventDB.php");
$DB = new eventDB();
if(!$DB->status)
{
exit;
}

$type = $_POST["type"];
$id = $_POST["id"];

switch($type)
{
case "event":
             showevent($id,$DB);
  	     break;
default:
	break;

}
