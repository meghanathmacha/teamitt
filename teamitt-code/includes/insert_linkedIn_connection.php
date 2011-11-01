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
$userid="";
if(isset($_POST['fbid'])){
$fbid=$_POST['fbid'];
}
if(isset($_POST['userid'])){
	$userid=$_POST['userid'];
	$userinfo=$_POST['userinfo'];

}
if($fbid!="" && $userid!=""){
	$connectionInfo=$_POST['connection'];
	$connections=explode(",",$connectionInfo);
	$str=array();
	for($i=0;$i<count($connections);$i++){
		$temp=split(" ",$connections[$i]);
		$str[$i]['uid']=$temp[0];
		$str[$i]['fname']=$temp[1];
		$str[$i]['lname']=$temp[2];
		$str[$i]['img']=$temp[3];
		$str[$i]['company']=$temp[4];
	}
	//      echo $str[0]['uid'];
	$res=$lDB->linkedInClient($userid);
	if(mysql_num_rows($res)>=1){
		// Update last login date
		$result1=$lDB->updateLinkedInLogin($userid);
		//add new connections
		$row=mysql_fetch_array($res);
		$connof_id=$row['id'];
		// Get all the existing connections from DB
		$result1=$lDB->linkedInConnections($connof_id);
		// Check for new connections
		$result2=$lDB->addNewConnections($connof_id,$str,$result1);
	}
	else{
		$info=split(" ",$userinfo);
		$results=$lDB-> addLinkedInClient($fbid, $info[0], $info[1], $info[2]);
//		echo $results;
		$result1=$lDB->lastId($fbid);
		$row=mysql_fetch_array($result1);
		$connof_id=$row['id'];
		$result2=$lDB->addAllConnections($connof_id,$str);
		// add all connections
	}
}
?>
