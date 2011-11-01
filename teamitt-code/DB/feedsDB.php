<?php
class feedsDB extends DB
{

function getFeeds($type_id,$type_name,$offset,$rows,$logged_in_user_id,$feed_type,$last_feed_id,$post_id,$report_flag,$recent_flag)
{
	if($this->link)
	{
//		if($offset == null)
			$offset = 0;
		if($rows == null)
			$rows = 10;
	if($type_name == 1)
	{
	$query = "SELECT distinct feeds.id, feeds.feed_type, feeds.feed_from, feeds.feed_to, feeds.content_text, feeds.add_time, feeds.more, feeds.goal_id, feeds.due_date,goals.name,feeds.content_id,feeds.project_id
			FROM feeds
			LEFT JOIN goals ON feeds.goal_id = goals.id, visibility_bits
			WHERE $type_id = visibility_bits.type_id
			AND visibility_bits.type_name = $type_name
			AND visibility_bits.feed_id = feeds.id
			AND visibility_bits.flag = 1 
			AND (((feed_type = 1 OR feed_type = 11 OR feed_type =12) AND (feeds.id in (select feed_id from visibility_bits where type_name = $type_name and type_id = $logged_in_user_id))) OR (feed_type != 1 AND feed_type != 11 AND feed_type != 12)) ";
	}
	else
	{
	$query = "SELECT distinct feeds.id, feeds.feed_type, feeds.feed_from, feeds.feed_to, feeds.content_text, feeds.add_time, feeds.more, feeds.goal_id, feeds.due_date,goals.name,feeds.content_id,feeds.project_id
			FROM feeds
			LEFT JOIN goals ON feeds.goal_id = goals.id, visibility_bits
			WHERE $type_id = visibility_bits.type_id
			AND visibility_bits.type_name = $type_name
			AND visibility_bits.feed_id = feeds.id
			AND visibility_bits.flag = 1 "; 
	}
			if($post_id != null)
			{
	$query = "SELECT distinct feeds.id, feeds.feed_type, feeds.feed_from, feeds.feed_to, feeds.content_text, feeds.add_time, feeds.more, feeds.goal_id, feeds.due_date,goals.name,feeds.content_id,feeds.project_id
			FROM feeds
			LEFT JOIN goals ON feeds.goal_id = goals.id, visibility_bits
			WHERE (($type_id = visibility_bits.type_id
			AND visibility_bits.type_name = $type_name) OR(visibility_bits.type_id = $logged_in_user_id AND visibility_bits.type_name = 1))
			AND visibility_bits.feed_id = feeds.id
			AND visibility_bits.flag = 1 "; 
				$query .= "AND feeds.id = $post_id ";
			}
		
		if($report_flag == 1)
		{
	$query = "SELECT distinct feeds.id, feeds.feed_type, feeds.feed_from, feeds.feed_to, feeds.content_text, feeds.add_time, feeds.more, feeds.goal_id, feeds.due_date,feeds.content_id,feeds.project_id
			FROM feeds
			LEFT JOIN feed_receivers ON feeds.id = feed_receivers.feed_id
			WHERE (feeds.feed_from = $type_id or feeds.feed_to = $type_id or feed_receivers.user_id = $type_id ) ";

		}
		if($report_flag == 2)
		{
	$query = "SELECT distinct feeds.id, feeds.feed_type, feeds.feed_from, feeds.feed_to, feeds.content_text, feeds.add_time, feeds.more, feeds.goal_id, feeds.due_date,feeds.content_id,feeds.project_id
			FROM feeds
			WHERE (feeds.feed_from = $type_id) ";

		}
		if($report_flag == 3)
		{
	$query = "SELECT distinct feeds.id, feeds.feed_type, feeds.feed_from, feeds.feed_to, feeds.content_text, feeds.add_time, feeds.more, feeds.goal_id, feeds.due_date,feeds.content_id,feeds.project_id
			FROM feeds
			LEFT JOIN feed_receivers ON feeds.id = feed_receivers.feed_id
			WHERE (feeds.feed_to = $type_id or feed_receivers.user_id = $type_id ) ";

		}
		if($feed_type != null)
			$query .= "AND feed_type = $feed_type ";
		if($last_feed_id != null)
			$query .= "AND feeds.id <  $last_feed_id ";
		if($recent_flag == 1)
		{
		$query .= "ORDER BY feeds.id DESC
				LIMIT $offset,$rows ";
		}
		else	
		{
		$query .= "ORDER BY feeds.last_update_time DESC,feeds.id DESC
				LIMIT $offset,$rows ";
		}
		$result=mysql_query($query,$this->link);
//		echo $query;
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
			 
}
function getMoreUsersOfFeed($feed_id)
{
	if($this->link)
	{
		$query = "select first_name,last_name,user_id,image_src from feed_receivers,users where feed_id = $feed_id and users.id = feed_receivers.user_id and users.activated = 1";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function getUserInfoById($user_id)
{
	if($this->link)
	{
		$query = "select first_name,last_name,image_src,gender from users where users.id = $user_id";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function updateFeedTime($feed_id)
{
	if($this->link)
	{
		$query = "UPDATE feeds SET last_update_time = NOW( ) WHERE id = $feed_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return 1;
		}
		return 0;
	}
	return 0;
	
}
function insertComments($feed_id,$comment_from,$comment_text)
{
	if($this->link)
	{
		$query = "insert into feed_comments(feed_id, comment_from, comment_text , add_time) values($feed_id,$comment_from,\"$comment_text\",NOW())";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
				$query = "SELECT LAST_INSERT_ID() from feed_comments";
				$result = mysql_query($query);
				$row = mysql_fetch_row($result);
				$last_id = $row[0];
				return $last_id;
		}
		return 0;
	}
	return 0;
	
}
function insertLikes($feed_id,$like_from)
{
	if($this->link)
	{
		if(!$this->ifUserLiked($like_from, $feed_id))
			{
			$query = "insert into feed_likes(feed_id, like_from,add_time) values($feed_id,$like_from,NOW())";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				$query = "SELECT LAST_INSERT_ID() from feed_likes";
				$result = mysql_query($query);
				$row = mysql_fetch_row($result);
				$last_id = $row[0];
				return $last_id;
			}
		return 0;
		}
		return 0;
	}
	return 0;
	
}
function getComments($last_comment_id,$user_id,$feed_id)
{
	if($this->link)
	{
		$query = "select first_name,image_src,comment_text,feed_id,comment_from,feed_comments.add_time,feed_comments.id from users,feed_comments 
			 where users.id = feed_comments.comment_from ";
		if($feed_id != null)
			$query .= " and feed_id = $feed_id ";
		$query .= " order by feed_comments.id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function getLikes($last_like_id,$user_id,$feed_id)
{
	if($this->link)
	{
		$query = "select distinct first_name,feed_id,like_from,feed_likes.add_time,feed_likes.id,last_name from users,feed_likes
			 where users.id = feed_likes.like_from
			 and feed_likes.feed_id = $feed_id
			 order by feed_likes.id desc ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function ifUserLiked($user_id,$feed_id)
{
	if($this->link)
	{
		
		$query = "select id from feed_likes where like_from = $user_id and feed_id = $feed_id ";
		$result=mysql_query($query,$this->link);
		
		if(mysql_affected_rows()>0)
		{
			return 1;
		}
		return 0;
	}
	return 0;
}
function getContentIdByFeedId($feed_id)
{
			$query = "select content_id from feeds where id = $feed_id ";
			$result = mysql_query($query,$this -> link);
			$row  = mysql_fetch_array($result);	
			$content_id = $row["content_id"];
			return $content_id;
}
function getContentTypeByFeedId($feed_id)
{
			$query = "select feed_type from feeds where id = $feed_id ";
			$result = mysql_query($query,$this -> link);
			$row  = mysql_fetch_array($result);	
			$feed_type = $row["feed_type"];
			return $feed_type;
}
function deleteFeed($feed_id)
{

	if($this->link)
	{
	         	
		$content_id = $this -> getContentIdByFeedId($feed_id);
		$content_type = $this -> getContentTypeByFeedId($feed_id);
		$table_arr = array(1 => 'action' , 2 => 'thank');
		$table_name = $table_arr[$content_type];
		$query = "delete from ".$table_name."s where thanks.id = $content_id ";
		mysql_query($query,$this->link);
		$query  = "delete from ".$table_name."s_receivers where thank_id = $content_id ";
		mysql_query($query,$this->link);
		$query = "delete from feeds where id = $feed_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function deleteComment($comment_id)
{
	if($this->link)
	{
		$query = "delete from feed_comments where id = $comment_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function deleteLike($feed_id,$user_id)
{
	if($this->link)
	{
		$query = "delete from feed_likes where feed_id = $feed_id and like_from = $user_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function attachToGoal($feed_id,$goal_id){
	if($this->link){
		$query="UPDATE feeds SET goal_id= $goal_id  WHERE id= $feed_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		return 0;
	}
}

function removeFromGoal($feed_id){
	if($this->link){
		$query="UPDATE feeds SET goal_id=0 WHERE id=".$feed_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		else return 0;
	}
}
function getGoalsByUserId($user_id){
	if($this->link){
		$query = "SELECT goals.id, goals.name
			FROM goals,goal_contributors
			WHERE goal_contributors.user_id = $user_id
			AND goal_contributors.goal_id = goals.id and goals.progress_id=2";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return $result;;
		}
		else return 0;
	}
}
function getDueDate($feed_id){
	if($this->link){
		$query="SELECT due_date FROM feeds WHERE id=".$feed_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()==0){
			return 0;
		}
		else{
			$date_info=mysql_fetch_assoc($result);
			$due_date=$date_info['due_date'];
			$date_pattern="[0]{4}-[0]{2}-[0]{2}";
			ereg($date_pattern,$due_date,$ans);
			if(strlen($ans[0])==0){
				return $result;
			}
			else return null;
		}
	}

}
function editDueDate($feed_id,$date){
	if($this->link){
		$query="SELECT due_date FROM feeds WHERE id=".$feed_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()==0){
			return 0;
		}
		else{
			$query2="UPDATE feeds set due_date='".$date."' WHERE id=".$feed_id;
			$result2=mysql_query($query2,$this->link);
			if(mysql_affected_rows()==0){
				return 0;
			}
			//else return 1;
		}
			$query = "select content_id from feeds where id = $feed_id ";
			$result = mysql_query($query,$this -> link);
			$row  = mysql_fetch_array($result);	
			$action_id = $row["content_id"];
			$query = "UPDATE actions set due_date='".$date."' WHERE id=".$action_id;
			$result=mysql_query($query,$this->link);

	}	
	}
function ifBitsExist($feed_id,$type_name,$type_id,$flag)
{
	if($this->link){
	$query = "select id from visibility_bits where flag = $flag 
		and feed_id = $feed_id 
		and type_name = $type_name
		and type_id = $type_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		else
		{
			return 0;
		}
	}
	return 0;
		
}
function changeFeedVisibility($feed_id,$type_name,$type_id,$flag)
{
	
	if($this->link){
		if(!$this -> ifBitsExist($feed_id,$type_name,$type_id,$flag))
		{
		$query = "update visibility_bits set flag = $flag where feed_id = $feed_id and type_name = $type_name ";
		if($type_id != null)
			$query .= " and type_id = $type_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		else
		{
				$query="insert into visibility_bits (feed_id,type_name,type_id) values($feed_id,$type_name,$type_id)";
				$result=mysql_query($query,$this->link);
				if(mysql_affected_rows()>0){
					return 1;
				}
		}
		return 0;
	}
	}
	return 0;
}
function getConnectionsByUserId($user_id,$feed_id,$type_name)
{
        if($this -> link)
        {
		$query = "select distinct  id,first_name,last_name,image_src from  users where  id IN (SELECT  distinct user_connections.user_connection_id FROM users, user_connections WHERE users.id = user_connections.user_id AND users.id =$user_id)";
		$query = "SELECT DISTINCT users.id, first_name, last_name, image_src, flag
			FROM users
			LEFT JOIN visibility_bits ON users.id = visibility_bits.type_id
			AND visibility_bits.type_name = $type_name
			AND visibility_bits.feed_id = $feed_id
			WHERE users.id
			IN (

					SELECT DISTINCT user_connections.user_connection_id
					FROM users, user_connections
					WHERE users.id = user_connections.user_id
					AND users.id = $user_id
			   )
			AND users.activated = 1
			ORDER BY flag DESC,first_name 
			LIMIT 0 , 30";
                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0)
                {
                        return $result;
                }
                return 0;
        }
        return 0;
}
function sharingFeeds($feed_id,$shareids,$forgetids)
{
	if($this->link){
			$uids= explode(",", $shareids);
			$type_name = 1;
			if(count($uids))
			{
				$query="insert into visibility_bits (feed_id,type_name,type_id) values";
				$user = array();
				$index = 0;
				foreach($uids as $uid)
				{
					if($this -> updateBits($feed_id,$type_name,$uid))
					{
						$updateids[$index] = $uid;
						$index++;
					}
					else
						$user[] = " ($feed_id,$type_name,$uid) ";
				}

				$dquery = implode(",", $user);

				$query= $query.$dquery;
			}
		
		$update_query = "update visibility_bits set flag = 0 where feed_id = $feed_id and type_name = $type_name and type_id in ($forgetids) ";
		$result=mysql_query($query,$this->link);
		$result=mysql_query($update_query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		else return 0;
	}
}
function updateBits($feed_id,$type_name,$type_id)
{
	if($this->link){
		$query = "update visibility_bits set flag = 1 where feed_id = $feed_id and type_name = $type_name and type_id = $type_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		else return 0;
	}
}
function thanksRecived($user_id)
{
	if($this->link){
		$query = "select distinct feeds.id 
			from feeds
			LEFT JOIN feed_receivers ON feed_receivers.feed_id = feeds.id 
			 where (feed_to = $user_id or user_id = $user_id )and feed_type = 2";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			/*$ttr = mysql_fetch_array($result);
			$ttr = $ttr["ttr"];*/
			$ttr = mysql_num_rows($result);
			
			return $ttr;
		}
		else return 0;
	}
}
function getProjectNameById($project_id){
	if($this->link){
$query = "SELECT name
FROM projects
WHERE id = $project_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			/*$ttr = mysql_fetch_array($result);
			$ttr = $ttr["ttr"];*/
			$row = mysql_fetch_array($result);
			$project_name = $row["name"];
			
			return $project_name;
		}
		else return 0;
	}
	
}
function ifFeedOwner($feed_id,$user_id)
{
	if($this->link){
	$query = "select id from feeds where feed_from = $user_id and id = $feed_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return $result;
		}
		else return 0;
	}
}
function ifCommentOwner($comment_id,$user_id)
{
	if($this->link){
	$query = "select id from feed_comments where comment_from = $user_id and id = $comment_id ";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return $result;
		}
		else return 0;
	}
}
}

?>
