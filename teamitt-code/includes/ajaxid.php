<?php
session_start();
if(isset($_SESSION["teamittid"]))
{
$USERID=$_SESSION["teamittid"];
}
else
{
exit;
}
?>

