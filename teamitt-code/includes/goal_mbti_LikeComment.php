<?php 
// SETTING THE STANDARD VARIABLE REQUIRED *** 
$ref = getenv('HTTP_REFERER');
//$base_name =basename($ref);
$url = (parse_url($ref));
$path = $url['path'];
$query = $url['query'];
$id = explode("=",$query);
$profile_id = $id[1];
include ("ajaxid.php");
//echo $url;
include("../DB/initDB.php");
include("../DB/usersDB.php");
include("../DB/MBTIgoals.php"); 
$mbti= new MBTIgoals(); 
if (!$mbti->status) 
	exit; 

$uDB = new usersDB();
if(!$uDB->status)
	exit;
// END STANDARD VARIABLE SETTINGS 
$goalID=$profile_id; 
// IF the 'Like ' button has been clicked the go into this 'if' loop. 
if(isset($_POST['like']))
{	$liked=0;
	$ID = $_POST['mbtisent_id'];
	$type=$_POST['list'];
	$liked=$mbti->ifuserliked($USERID,$ID,$goalID,$type); // check if user has not already liked the comment 
	$res=0; 
	if($liked==0) // if user has not already liked then add the users like into the DB
	{
		$res = $mbti->insertlike($USERID,$goalID , $ID, $type) ;
	}
	//echo $liked;
	echo $res;
}

else if(isset($_POST['comment']))
{
	$mbti_sent_id = $_POST['sent_id'];
	$commtext=$_POST['body'];
	$type=$_POST['list'];
	$res = $mbti->insertcomment($USERID,$mbti_sent_id,$commtext, $type) ;
	echo $res;
//	echo $mbti_sent_id . $commtext . $USERID ; 
}

else if(isset($_POST['deleteComment']))
{

        $comment_id =  $_POST['comment_id'];
	$type=$_POST['list']; 
        $result = $mbti->deleteComment($comment_id,$type);
	echo $result;

}
?>

