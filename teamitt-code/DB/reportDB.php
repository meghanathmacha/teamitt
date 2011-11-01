<?php
class reportDB extends DB
{
public function runQuery($query)
{
		if($this->link)
		{
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
public function getUsersByCompanyId($company_id)
{
	$query = "select users.id,first_name,last_name,image_src from users where users.company_id = $company_id and activated = 1";
	return $this -> runQuery($query);
}
public function getTopUser($company_id,$from_date,$end_date)
{
	$query = "SELECT COUNT( thank_id ) AS thanks_count, first_name ,last_name,users.id,image_src
FROM users, thank_receivers, thanks
WHERE users.company_id =$company_id
AND thank_receivers.thank_id = thanks.id
AND users.id = thank_receivers.user_id
AND  addedon BETWEEN '$from_date' AND '$end_date' 
GROUP BY users.id
ORDER BY thanks_count DESC 
";
$result = $this -> runQuery($query);
return $result;
}
public function getUsersThanksInvolvedIn($user_id,$from_date,$end_date,$time_range)
{
$query = "SELECT addedby,thank_receivers.user_id,content,badgename
FROM thanks, badges,thank_receivers
WHERE ( thanks.addedby = $user_id OR thank_receivers.user_id = $user_id )
AND thanks.badgeid = badges.badgeid
AND thank_receivers.thank_id = thanks.id ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	$result =  $this -> runQuery($query);

	return $result;

}
public function getUsersThanksSentTo($user_id,$from_date,$end_date,$time_range)
{
$query = "SELECT users.first_name,users.last_name,content,badgename
FROM thanks, badges, users,thank_receivers
WHERE thanks.addedby = $user_id
AND thanks.badgeid = badges.badgeid
AND thank_receivers.thank_id = thanks.id
AND thank_receivers.user_id = users.id ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	$result =  $this -> runQuery($query);

	return $result;
}

public function getUsersThanksReceivedFrom($user_id,$from_date,$end_date,$time_range)
{
$query = "SELECT users.first_name, content, badgename,users.last_name
FROM thanks, thank_receivers, badges, users
WHERE thanks.id = thank_receivers.thank_id
AND thank_receivers.user_id = $user_id
AND thanks.badgeid = badges.badgeid
AND addedby = users.id ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	$result =  $this -> runQuery($query);
	return $result;
}
public function getPointsReceivedByUserId($user_id,$from_date,$end_date,$time_range)
{
$query = "SELECT SUM( badges.badge_points ) as total_points
FROM thanks, thank_receivers, badges, users
WHERE thanks.id = thank_receivers.thank_id
AND thank_receivers.user_id = $user_id
AND thanks.badgeid = badges.badgeid
AND thank_receivers.user_id = users.id ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	$result =  $this -> runQuery($query);
	return $result;


}
public function getPointsSentByUserId($user_id,$from_date,$end_date,$time_range)
{
$query = "SELECT SUM( badges.badge_points ) as total_points
FROM thanks, badges, users
WHERE thanks.addedby = $user_id
AND thanks.badgeid = badges.badgeid
AND thanks.addedby = users.id ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	$result =  $this -> runQuery($query);
	return $result;


}
public function getPointsDetailsByUserId($user_id)
{
$query  = "SELECT badge_points,remaining_badge_points 
	   FROM users
	   WHERE users.id = $user_id ";
	
$result =  $this -> runQuery($query);
return $result;
}
public function getDueGoalsByUserId($user_id,$from_date,$end_date,$time_range)
{
$query = "SELECT DISTINCT goals.id
FROM goals
LEFT JOIN goal_contributors ON goals.id = goal_contributors.goal_id
WHERE (
goals.created_by =$user_id
OR goal_contributors.user_id =$user_id ) 
AND due_date < current_date 
AND progress_id != 3";
	if($from_date != null & $end_date != null)
		$query .= " AND  due_date BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND due_date >= date_sub(current_date , INTERVAL 1 $time_range) ";
		$result =  $this -> runQuery($query);
		$count = 0;
		if($result != 0)
			$count = mysql_num_rows($result);
		return $count;


}
public function getGoalsByUserId($user_id,$from_date,$end_date,$time_range,$progress_type)
{
$query = "SELECT DISTINCT goals.id
FROM goals
LEFT JOIN goal_contributors ON goals.id = goal_contributors.goal_id
WHERE (
goals.created_by =$user_id
OR goal_contributors.user_id =$user_id )";
        if($progress_type != null)
		$query .= " AND progress_id = $progress_type ";
	if($from_date != null & $end_date != null)
		$query .= " AND  due_date BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND due_date >= date_sub(current_date , INTERVAL 1 $time_range) ";
		$result =  $this -> runQuery($query);
		$count = 0;
		if($result != 0)
			$count = mysql_num_rows($result);
		return $count;

}
public function thanksReceivedByUserId($user_id,$from_date,$end_date,$time_range)
{
	$query = "SELECT COUNT( thank_id ) AS thanks_count
		FROM users, thank_receivers,thanks
		WHERE users.id = $user_id
		and thank_receivers.thank_id = thanks.id
	AND users.id = thank_receivers.user_id ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	$result = $this -> runQuery($query);
//	echo $query;
	return $result;

}
public function thanksGivenByUserId($user_id,$from_date,$end_date,$time_range)
{
	$query = "SELECT  COUNT( thanks.id ) AS thanks_count
		FROM users, thanks
		WHERE users.id = $user_id
		AND users.id = thanks.addedby ";
	if($from_date != null & $end_date != null)
		$query .= " AND  addedon BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND addedon >= date_sub(current_date , INTERVAL 1 $time_range) ";
	return $this -> runQuery($query);
}
public function actionsCompletedByUserId($user_id,$from_date,$end_date,$time_range)
{
		$query = "select distinct feeds.id as actions_count
			from feeds
			LEFT JOIN feed_receivers ON feed_receivers.feed_id = feeds.id 
			 where (feed_to = $user_id or user_id = $user_id )and feed_type = 1 and due_date = '1111-11-11' ";	
		if($from_date != null & $end_date != null)
			$query .= " AND  add_time BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND add_time >= date_sub(current_date , INTERVAL 1 $time_range) ";
		$result =  $this -> runQuery($query);
		$actions_count = 0;
		if($result != 0)
			$actions_count = mysql_num_rows($result);
		return $actions_count;
/*	$query = "SELECT  COUNT( actions.id ) AS actions_count
		FROM users, action_receivers ,ations
		WHERE users.id = $user_id
		AND actions.due_date = '1111-11-11'
		AND action_receivers.user_id = users.id
		AND actions.id = action_receivers.action_id "; */
		
//	return $this -> runQuery($query);
}
public function actionsDueByUserId($user_id,$from_date,$end_date,$time_range)
{
		$query = "select distinct feeds.id as actions_count
			from feeds
			LEFT JOIN feed_receivers ON feed_receivers.feed_id = feeds.id 
			 where (feed_to = $user_id or user_id = $user_id )and feed_type = 1 and due_date != '1111-11-11' ";	
		if($from_date != null & $end_date != null)
			$query .= " AND  add_time BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND add_time >= date_sub(current_date , INTERVAL 1 $time_range) ";
		$result =  $this -> runQuery($query);
		$actions_count = 0;
		if($result != 0)
			$actions_count = mysql_num_rows($result);
		return $actions_count;
}
public function feedbackRequestedByUserId($user_id,$from_date,$end_date,$time_range)
{
		$query = "select distinct feeds.id as actions_count
			from feeds
			LEFT JOIN feed_receivers ON feed_receivers.feed_id = feeds.id 
			 where (feed_to = $user_id or user_id = $user_id )and feed_type = 12 ";	
		if($from_date != null & $end_date != null)
			$query .= " AND  add_time BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND add_time >= date_sub(current_date , INTERVAL 1 $time_range) ";
		$result =  $this -> runQuery($query);
		$actions_count = 0;
		if($result != 0)
			$actions_count = mysql_num_rows($result);
		return $actions_count;
}
public function feedbackGivenByUserId($user_id,$from_date,$end_date,$time_range)
{
		$query = "select distinct feeds.id as actions_count
			from feeds
			LEFT JOIN feed_receivers ON feed_receivers.feed_id = feeds.id 
			 where (feed_to = $user_id or user_id = $user_id )and feed_type = 11 ";	
		if($from_date != null & $end_date != null)
			$query .= " AND  add_time BETWEEN '$from_date' AND '$end_date' ";
	else if($time_range != null)
		$query .= " AND add_time >= date_sub(current_date , INTERVAL 1 $time_range) ";
		$result =  $this -> runQuery($query);
		$actions_count = 0;
		if($result != 0)
			$actions_count = mysql_num_rows($result);
		return $actions_count;
}
	public function getBadgesFromFeeds()
	{
		if($this->link)
		{
			$newarr = array();
			$query = "SELECT feed_to, count(feed_to) FROM feeds WHERE feed_type = 2 group by feed_to";				
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				while($row = mysql_fetch_array($result))
				{
					$newarr[$row[0]]=$row[1];
				}
				return $newarr; 
			}
			return 0;
		}
		return 0;
	}
	public function getBadgesFromFR()
	{
		if($this->link)
		{
			$newarr = array();
			$query = "select user_id, count(user_id) from feed_receivers where feed_id in (select feed_id from
				feeds where feed_type = 2) group by user_id";
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				while($row = mysql_fetch_array($result))
				{
					$newarr[$row[0]]=$row[1];
				}
				return $newarr; 
			}
			return 0;
		}
		return 0;
	}
	public function getCompanies()
	{
		if($this->link)
		{
			$newarr = array();
			$query = "select id, name from companies where name not like ''";
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				while($row = mysql_fetch_array($result))
				{
					$newarr[$row[0]]=$row[1];
					//array_push($newarr,$row[0]);
				}
				return $newarr; 
			}
			return 0;
		}
		return 0;
	}	
	public function getUsersfromCompanyId($cid)
	{
		if($this->link)
		{
			$newarr = array();
			$query = "select id from users where company_id=$cid";
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				while($row = mysql_fetch_array($result))
				{
					$newarr[$row[0]]=$row[1];
				//	array_push($newarr,$row[0]);
				}
				return $newarr; 
			}
			return 0;
		}
		return 0;
	}	
}

?>

