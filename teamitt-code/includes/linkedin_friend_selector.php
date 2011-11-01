<?php
require_once("../DB/initDB.php");
include("../DB/linkedInDB.php");
$lDB = new linkedInDB();
if(!$lDB->status)
{
	die("Connection Error");
	exit;

}
$fbid="";
if(isset($_POST['fbid'])){
	$fbid=$_POST['fbid'];
}
$res=$lDB->lastId($fbid);
$row=mysql_fetch_array($res);
$connof_id=$row['id'];
$result=$lDB->connectionInfo($connof_id);
$arr=array();
$num_conn=mysql_num_rows($result);
for($i=0;$i<$num_conn;$i++){
	$row=mysql_fetch_array($result);
	$uid=$row['user_id'];
	$first_name=$row['first_name'];
	$last_name=$row['last_name'];
	$img=$row['img_url'];
	$arr[]=array("user_id"=>$uid,"first_name"=>$first_name,"last_name"=>$last_name,"img_url"=>$img);
}
echo json_encode($arr);
?>
