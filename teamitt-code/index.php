<?php
session_start();
if(isset($_SESSION["teamittid"]))
{
include("home.php");
}
else
{
include("home-page.html");
}





?>
