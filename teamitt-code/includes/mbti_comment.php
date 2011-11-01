<?php 
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
$uDB = new usersDB();
if(!$uDB->status)
{
exit;
}

if(isset($_POST['like']))
{
$mbti_sent_id = $_POST['mbtisent_id'];
$liked=$uDB->ifuserliked($USERID,$mbti_sent_id,$profile_id);
//echo $liked;
if($liked!=1)
{
	$res = $uDB->insertlike($USERID,$profile_id,$mbti_sent_id) ;
}
//echo $res;
else echo "0";
}

else if(isset($_POST['comment']))
{
$mbti_sent_id = $_POST['sent_id'];
$commtext=$_POST['body'];
//$type=$_POST['type'];
$res = $uDB->insertcomment("comm",$USERID,$profile_id,$mbti_sent_id,$commtext) ;
echo $res;
}

else if(isset($_POST['deleteComment']))
{

        $comment_id =  $_POST['comment_id'];
        $result = $uDB -> deleteComment($comment_id);
	echo $result;

}
?>

