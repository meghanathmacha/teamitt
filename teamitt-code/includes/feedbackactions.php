<?php
require_once("../DB/initDB.php");
require_once("../DB/usersDB.php");
require_once("../DB/feedbacksDB.php");
require_once("../checkid.php");
$uDB=new usersDB();
$fDB=new feedbacksDB();
function newPeerLoop($userProfileId,$uDB){
	$userName=$uDB->firstName($userProfileId);
	echo "<div id='eventHeader'><span onClick='closePopupEvent();'></span>New Peer Loop on ".$userName."</div> ";
	include("newPeerLoop.php");
}
function giveFeedback($userProfileId,$uDB){
	$userName=$uDB->firstName($userProfileId);
	echo "<div id='eventHeader'><span onClick='closePopupEvent();'></span>Give Feedback on ".$userName."</div> ";
	include("giveFeedback.php");
}
function submitFeedback($data,$fDB,$userId){
 $perfs = explode("&", $data);
        $vals=array();
        foreach($perfs as $perf) {
                $perf_key_values = explode("=", $perf);
                $key = urldecode($perf_key_values[0]);
                $values = urldecode($perf_key_values[1]);
                $vals[$key]=$values;
        }

$userProfileId=$vals['userProfileId'];
$feedback=$vals['feedback'];
$succ=$fDB->addFeedback($userProfileId,$userId,$feedback);
$fId=$fDB->addFeedbackAction(9,$userId,$userProfileId,$feedback,0,0,0,0,0);
$suc=$fDB->addVisibility($fId,4,$userId);
$suc=$fDB->addVisibility($fId,4,$userProfileId);
echo $succ;
}
$param=$_POST['param'];
if($param == "newPeerLoop"){
	$userProfileId=$_POST['userProfileId'];
	newPeerLoop($userProfileId,$uDB);
}
else if($param == "giveFeedback"){
	$userProfileId=$_POST['userProfileId'];
	giveFeedback($userProfileId,$uDB);
}
else if($param=="submitFeedback"){
	$vals=$_POST['vals'];
	$userId=$USERID;
	submitFeedback($vals,$fDB,$userId);
}
?>
