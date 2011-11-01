<?php
function saveBadgePoints($bDB,$badgeId,$val,$uDB,$userId){
$compId=$uDB->getCompanyId($userId);
if(is_numeric($val)){
$return=$bDB->saveBadgePoints($badgeId,$val,$compId);
return $return;
}
else{
return 0;
}
}
function saveUserBadgePoints($uDB,$userId,$val){
if(is_numeric($val)){
$remPoint=$uDB->getUserRemainingPoint($userId);
if($remPoint > $val){
$uDB->updateUserRemainingBadgePoints($userId,$val);
}
$return=$uDB->saveUserBadgePoints($userId,$val);
return $return;
}
else{
return 0;
}
}
function saveCompanyFrequency($uDB,$compId,$val){
if(is_numeric($val)){
$return=$uDB->saveCompanyFrequency($compId,$val);
return $return;
}
else{
return 0;
}
}

require_once("../DB/initDB.php");
require_once("../DB/badgeDB.php");
require_once("../DB/usersDB.php");
require_once("../checkid.php");
$bDB=new badgeDB();
$uDB=new usersDB();
$userId=$USERID;
$param=$_POST["param"];

if($param=="saveBadgePoints"){
$badgeId=$_POST['badgeId'];
$val=$_POST['value'];
$ret=saveBadgePoints($bDB,$badgeId,$val,$uDB,$userId);
print(json_encode($ret));

}
if($param=="saveUserBadgePoints"){
$userId=$_POST['userId'];
$val=$_POST['value'];
$ret=saveUserBadgePoints($uDB,$userId,$val);
print(json_encode($ret));

}
if($param=="saveCompanyFrequency"){

$compId=$_POST['companyId'];
$val=$_POST['value'];
//echo "<script>alert('$compId')</script>";
//echo "<script>alert('$val')</script>";
$ret=saveCompanyFrequency($uDB,$compId,$val);
print(json_encode($ret));

}

?>
