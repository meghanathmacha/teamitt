<?php
$loc=$_POST['location'];
//$loc="Facebook";
include("../DB/initDB.php");
include("../DB/location.php");
$DB = new loc();
if(!$DB->status)
{
	die("Connection Error");
	exit;
}

$res=$DB->getLocation($loc);
//echo mysql_num_rows($res);
$c=array();
while($row=mysql_fetch_array($res)){
	$lat=$row['latitude'];
	$lon=$row['longitude'];
	$add=$row['address'];
	$c[]=array("latitude"=>$lat,"longitude"=>$lon,"address"=>$add);
}
echo json_encode($c);
?>
