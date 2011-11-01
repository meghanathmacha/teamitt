<?php
session_start();

if(isset($_SESSION["teamittid"]))
{
header("Location: .");
die();
}


?>
