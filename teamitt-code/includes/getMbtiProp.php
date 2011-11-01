<?php

include("ajaxid.php");
include("feed_helper.php");

$profile=0;
$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
if(strlen($url["query"])>0)
{
$query = explode("=", $url["query"]);
if($query[1]!=$USERID)
{
$profile =$query[1];
}
}

if(!$profile) { die(); }


include("../DB/initDB.php");
include("../DB/usersDB.php");
$DB = new usersDB();
if(!$DB->status)
{
exit;
}
$usermbti = $DB->getMBTI($USERID);
$connmbti = $DB->getMBTI($profile);

//echo "Properties between ".$usermbti. "and ". $connmbti. ": ";


$mtype=$_GET["mtype"];


$relationship_files=array(
				"EI",
				"IE",
				"SN",
				"NS",
				"FT",
				"TF",
				"JP",
				"PJ"
			  );

# Function call


# This function accepts the MBTI types of a USER and its CONNECTION 
# and returns the relavant file names 
# which represent the pre-defined relationships between the two MBTI types 
function send_MBTI_relationship_file($user, $connection, $relationship_files,$DB,$type,$USERID)
{	# variable for the list of files to be returned
	$file_list="";	

# if the MBTI type is more than 4 characters then the function returns no files
	if (strlen($user)==4)
	{	if (strlen($connection)==4) 
		{ 	
			$user=chunk_split($user,1,"");
			$connection=chunk_split($connection,1,"");
				$prev=0; 

# checking for relationship files after comparing the USER and CONNECTION's MBTI types
			for ($i=0; $i<4; $i++) 
			{	$arr_key=$user[$i] . $connection[$i];

				if (in_array($arr_key,$relationship_files))  
				{	# adding the file names found to the file_list variable	
					$file_list = $DB->getMBTIContent($arr_key,$type);

					while($row=mysql_fetch_row($file_list))
				{
					$contents = nl2br($row[1]);
					$id = $row[0];
					$order=$row[2]+$prev;
							echo "<div class=\"mbti_sent\" id=$id>";
						
							echo $order.') '. $contents;

							echo "<div class=\"mbti_base\">";

$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
$path = $url['path'];
$query = $url['query'];
$profileid = explode("=",$query);
$profile_id = $profileid[1];
$res =$DB->ifuserliked($USERID,$id,$profile_id); 
if($res==1)
{
	echo "<span class=\"mbti_unlike\">Liked</span>";
echo "<span class=\"mbti_comment\">Comment</span>";
}
else 
{

	echo "<span class=\"mbti_like\">Like </span>";
echo "<span class=\"mbti_comment\">Comment</span>";
}
echo "</div>";

	echo getLikers($id,$profile_id,$DB,$USERID);		
echo '<div class="editor comments">';

echo getComments($id,$profile_id,$DB,$USERID);
echo "</div>";
echo '<div class = "editor">';

/*echo "<textarea rows=\"2\" cols=\"10\" id=\"mbti_comm_post\" name=\"mbti_comm_post\" placeholder=\"Enter your comment...\"></textarea>";
						echo "</div><div class=\"add_answer_div\"><a class=\"add_help_answer\" href=\"javascript:void();\">Post</a></div>";*/
							echo "</div></div>";

				}

			} 						 
			$prev = $order; 

		}
	} 
		else
		{	echo "Incorrect MBTI value of CONNECTION"; 
		}        
	} 
	else 
	{	echo "Incorrect MBTI value of USER.\n";
	}
}
function getLikers($sent_id,$like_to,$DB,$USERID)
{
$like_result = $DB-> getLikes($sent_id,$like_to);             //2 == goals
	$like_count = 0;
	$like_arr=array();	
	$you_flag = -1;
while(($like_row = mysql_fetch_array($like_result)) != null)
{
	$sent_id = $like_row["sent_id"];
	$liker_id = $like_row["like_from_id"];	
	$liker_name = $like_row["first_name"];
	$like_id = $like_row["id"];
	if($liker_id == $USERID)
	{
		$liker_name = 'you';
		$you_flag = $like_count;
	}
	$like_arr[$like_count]['id'] = $liker_id;	
	$like_arr[$like_count]['name'] = $liker_name;	
	$like_count++;
}
$like_users=composeLikers($like_arr,$you_flag);
return $like_users;
}
function getComments($sent_id,$comment_to,$DB,$USERID)
{
	$comments = $DB -> getComments($comment_to,$sent_id); 
	$comments = composeComments($comments,$USERID,2);
	return $comments;
}
function st($usermbti,$connmbti,$relationship_files,$DB,$USERID)
{
if($usermbti=="")
{
echo "Add your MBTI <a href='settings.php?profile'>here</a>";
}
else
{
send_MBTI_relationship_file(strtoupper($usermbti),strtoupper($connmbti),$relationship_files,$DB,"st",$USERID); 
}
}

function comm($usermbti,$connmbti,$relationship_files,$DB,$USERID)
{
if($usermbti=="")
{
echo "Add your MBTI <a href='settings.php?profile'>here</a>";
}
else
{
$res = send_MBTI_relationship_file(strtoupper($usermbti),strtoupper($connmbti),$relationship_files,$DB,"comm",$USERID); 
}
}
function cr($usermbti,$connmbti,$relationship_files,$DB,$USERID)
{
if($usermbti=="")
{
echo "Add your MBTI <a href='settings.php?profile'>here</a>";
}
else
{
$res = send_MBTI_relationship_file(strtoupper($usermbti),strtoupper($connmbti),$relationship_files,$DB,"cr",$USERID); 
}
}
function sm($usermbti,$connmbti,$relationship_files,$DB,$USERID)
{
if($usermbti=="")
{
echo "Add your MBTI <a href='settings.php?profile'>here</a>";
}
else
{
$res = send_MBTI_relationship_file(strtoupper($usermbti),strtoupper($connmbti),$relationship_files,$DB,"sm",$USERID); 
}
}


switch($mtype){
case "com":
	comm($usermbti,$connmbti,$relationship_files,$DB,$USERID);
	break;
case "cr":

	cr($usermbti,$connmbti,$relationship_files,$DB,$USERID);
	break;
case "sm":
	sm($usermbti,$connmbti,$relationship_files,$DB,$USERID);
	break;

default:
	st($usermbti,$connmbti,$relationship_files,$DB,$USERID);
	break;

}


?>
