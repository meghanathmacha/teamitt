<?php
if(isset($_SESSION["isAdmin"]))
{
$LEVEL=$_SESSION["isAdmin"];
}
else
{
exit;
}
?>

