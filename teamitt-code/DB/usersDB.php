<?php
class usersDB extends DB
{
	public function getAutoUser($name, $cid)
	{
		if($this->link)
		{
			$query="select id,CONCAT(first_name,' ', last_name) from users where company_id = $cid and (CONCAT(first_name, ' ', last_name) like '$name%' or first_name like '$name%' or last_name like '$name%') limit 0,10";

			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}

			return 0;
		}
		return 0;
	}
	public function getAutoUserEmail($name)
	{
		if($this->link)
		{
			$query="select email_id from users where email_id like '$name%'  limit 0,10";

			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}

			return 0;
		}
		return 0;
	}
	public function firstName($uid)
	{
		if($this->link)
		{
			$query="select first_name from users where id=$uid";

			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);
				return $row[0];
			}

			return 0;
		}
		return 0;
	}

	public function fullName($uid,$cid)
	{
		if($this->link)
		{
			$query="select CONCAT(first_name, ' ', last_name) from users where id=$uid ";
			if($cid != null)
				$query .= " and company_id = $cid";
			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);
				return $row[0];
			}

			return 0;
		}
		return 0;
	}





	public function getCompanyId($uid)
	{
		if($this->link)
		{
			$query="select company_id from users where id=$uid";
			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);
				return $row[0];
			}

			return 0;
		}
		return 0;
	}
		 public function getCompanyFrequency($id)
        {
                if($this->link)
                {
                        $query="select frequency_badge_points from company_badges where company_id=$id";
                        $result = mysql_query($query , $this -> link);
			$frequency=0;
                        while($row=mysql_fetch_row($result))
                        {
				$frequency=$row[0];
                        }
                                return $frequency;

                }
                return 0;
        }
	 public function getUpdateBit($id)
        {
                if($this->link)
                {
                        $query="select update_bit,id from company_badges where company_id=$id";
                        $result = mysql_query($query , $this -> link);
                        $update_bit=0;
			if(mysql_affected_rows()>0){
				return $result;
			}

                }
                return 0;
        }
	 public function getUserRemainingPoint($userId)
        {
                if($this->link)
                {
                        $query="select remaining_badge_points from users where id=$userId";
                        $result = mysql_query($query , $this -> link);
                        $update_bit=0;
                        if(mysql_affected_rows()>0){
                               	$row=mysql_fetch_row($result);
				return $row[0];
                        }
			return 0;

                }
                return 0;
        }
	 public function getUserTotalPoint($userId)
        {
                if($this->link)
                {
                        $query="select badge_points from users where id=$userId";
                        $result = mysql_query($query , $this -> link);
                        $update_bit=0;
                        if(mysql_affected_rows()>0){
                                $row=mysql_fetch_row($result);
                                return $row[0];
                        }
                        return 0;

                }
                return 0;
        }

	public function getCompanyBadgeGivingStartDate($id)
        {
                if($this->link)
                {
                        $query="select DATE_FORMAT(start_date,'%D %M %Y') from company_badges where company_id=$id";
                        $result = mysql_query($query , $this -> link);
                        $start_date=0;
                        while($row=mysql_fetch_row($result))
                        {
                                $start_date=$row[0];
                        }
                                return $start_date;

                }
                return 0;
        }

	public function getCompanyName($uid)
	{
		if($this->link)
		{
			$query="select name from companies, users where users.company_id = companies.id and users.id=$uid";

			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);
				return $row[0];
			}

			return 0;
		}
		return 0;
	}

	public function getCompanyDomain($uid)
	{
		if($this->link)
		{
			$query="select domain from companies, users where users.company_id = companies.id and users.id=$uid";

			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);
				return $row[0];
			}

			return 0;
		}
		return 0;
	}


	public function getImage($id)
	{
		if($this->link)
		{
			$query = "select image_src from users where id='$id'";
			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $row['image_src'];
			}

			return 0;
		}
		return 0;
	}
	public function insertMBTI($userId,$score_type)
	{
		if($this->link)
		{
			$query = "update users set MBTIScore='$score_type'  where id=$userId";


			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;
		}

	}
	 public function updateUpdateBit($id)
        {
                if($this->link)
                {
                        $query = "update company_badges set update_bit=1  where id=$id";


                        $result=mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0)
                        {
                                return 1;
                        }
                        return 0;
                }

        }

	 public function updateBadgePoints($companyId)
        {
                if($this->link)
                {
                        $query = "update users set remaining_badge_points=badge_points  where company_id=$companyId";


                        $result=mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0)
                        {
                                return 1;
                        }
                        return 0;
                }

        }

	public function getMBTI($userId)
	{
		if($this->link)
		{
			$query="select MBTIScore from users  where id=$userId";
			$result=mysql_query($query,$this->link);

			$num_rows = mysql_num_rows($result);
			//$num_rows = $num_rows-1;
			if($num_rows > 0)
			{
				$row=mysql_fetch_row($result);
				return $row[0];
			}			
			return 0;
		} 
		return 0;
	}
	public function ifuserliked($like_from_id,$sent_id,$like_to_id)
	{
		if($this->link)
		{
			$query="select id from mbti_likes where sent_id='$sent_id' and like_to_id=$like_to_id and like_from_id = $like_from_id";
			$result = mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;
		} 
		return 0;

	}

	function deleteComment($comment_id)
	{
		if($this->link)
		{
			$query = "delete from mbti_comment where id = $comment_id ";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}
	public function insertlike($userId,$profileid,$sentid)
	{
		if($this->link)
		{
			$query="insert into mbti_likes (like_to_id,like_from_id,sent_id) values ($profileid,$userId,'$sentid')";
			mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
		} 
		return 0;
	}
	public function getLikes($sentid,$like_to)
	{
		if($this->link)
		{
			$query="select like_from_id, first_name,mbti_likes.id from mbti_likes,users where sent_id='$sentid' and like_to_id=$like_to and users.id = like_from_id";
			$result = mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
		} 
		return 0;
	}
	public function getComments($profile_id,$sentid)
	{
		if($this->link)
		{
			$query="select mbti_comment.id, first_name,comment_from,comments as comment_text from mbti_comment,users where sent_id='$sentid' and comment_to=$profile_id and users.id = comment_from";
			$result = mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
		} 
		return 0;
	}
	public function insertcomment($type,$comment_from,$comment_to,$sentid,$body)
	{
		$query = "insert into mbti_comment (comment_type ,comment_from,comment_to,sent_id,comments) values ('$type',$comment_from,$comment_to,'$sentid','$body')";
		mysql_query($query,$this -> link);
		if(mysql_affected_rows()>0)
		{
			$query = "SELECT LAST_INSERT_ID() from mbti_comment";
			$result = mysql_query($query);
			$row = mysql_fetch_row($result);
			$last_id = $row[0];
			return $last_id;
		}
		return 0;
	}
	public function getMBTIContent($reltype,$mbtiprop)
	{
		if($this->link)
		{
			$query="select id,content,order_num  from mbti_rel  where rel_type='$reltype' and mbti_prop='$mbtiprop' order by order_num";
			$result=mysql_query($query,$this->link);

			return $result;
		} 
		return 0;
	}
	public function updateCompanyImage($image,$id)
	{
		if($this->link)
		{
			$query="update companies set image_src='$image' where id='$id'";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;
		}
		return 0;
	}

	public function getCompanyImage($company_id)
	{
		if($this->link)
		{
			$query="select companies.image_src from companies where id=$company_id";
			$result = mysql_query($query , $this -> link);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $row['image_src'];
			}

			return 0;
		}
		return 0;
	}

	public function SaveConnections($userId,$peoples)
	{

		if($this -> link)
		{

			$pids= explode(",", $peoples);
			if(count($pids))
			{
				$query="insert into user_connections (user_id,user_connection_id) values ";
				$people = array();
				foreach($pids as $pid)
				{
					$people[] = " ($userId, $pid) ";
				}

				$dquery = implode(",", $people);

				$query= $query.$dquery;
				$result=mysql_query($query,$this->link);
				if(mysql_affected_rows()>0)
				{
					return 1;
				}
				return 0;
			}

		}
	}
	public function SaveOneConnection($userId,$people)
	{

		if($this -> link)
		{

			$query="insert into user_connections (user_id,user_connection_id) values ($userId,$people)";

			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;

		}
	}
	public function RemoveOneConnection($userId,$people)
	{

		if($this -> link)
		{
			$query = "delete from user_connections where user_id=$userId and user_connection_id=$people";

			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;

		}
	}
	public function GetConnections($userId)
	{

		if($this -> link)
		{

			$query = "select distinct  id,first_name,last_name,image_src from users where id=$userId";

			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}

	public function NumOfCompConn($compId)
	{
		if($this -> link)
		{
			$query = "select count(*) from  users where company_id=$compId and activated=1";

			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);

				return $row[0];
			}
			return 0;
		}
		return 0;

	}
	public function isCompanyUser($companyId,$userId)
	{
		if($this -> link)
		{
			$query = "select * from users where users.company_id=$companyId and users.id=$userId";

			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{

				return 1;
			}
			return 0;
		}
		return 0;

	}

	public function NumOfConn($userId,$compId)
	{
		if($this -> link)
		{
			$query = "select count(*) from  users where  id IN (SELECT  distinct user_connections.user_connection_id FROM users, user_connections WHERE users.id = user_connections.user_id AND users.id =$userId) and company_id=$compId and activated=1";

			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);

				return $row[0];
			}
			return 0;
		}
		return 0;

	}
	public function ShowAllConnectionsUser($userId,$limit,$compId)
	{

		if($this -> link)
		{
			$query = "select distinct  id,first_name,last_name,image_src from  users where  id IN (SELECT  distinct user_connections.user_connection_id FROM users, user_connections WHERE users.id = user_connections.user_id AND users.id =$userId) and company_id=$compId and activated=1 order by RAND() limit $limit, ".($limit+8) ;
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}
	 public function showUserConnection($userId,$compId)
        {

                if($this -> link)
                {
                        $query = "select distinct  id,first_name,last_name,image_src from  users where  id IN (SELECT  distinct user_connections.user_connection_id FROM users, user_connections WHERE users.id = user_connections.user_id AND users.id =$userId) and company_id=$compId and activated=1 order by RAND()";
                        $result=mysql_query($query,$this->link);

                        if(mysql_affected_rows()>0)
                        {
                                return $result;
                        }
                        return 0;
                }
                return 0;
        }

	public function NumOfHavingMeInConn($userId,$compId)
	{
		if($this -> link)
		{
			$query = "SELECT count(*) FROM users WHERE id IN ( SELECT DISTINCT user_connections.user_id FROM users, user_connections WHERE users.id = user_connections.user_id AND user_connections.user_connection_id =$userId ) AND company_id =$compId AND activated =1 ORDER BY first_name, last_name";

			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_row($result);

				return $row[0];
			}
			return 0;
		}
		return 0;

	}
	public function HavingMeInConnections($userId,$limit,$compId)
	{

		if($this -> link)
		{
			$query = "SELECT DISTINCT id, first_name, last_name, image_src FROM users WHERE id IN ( SELECT DISTINCT user_connections.user_id FROM users, user_connections WHERE users.id = user_connections.user_id AND user_connections.user_connection_id =$userId ) AND company_id =$compId AND activated =1 ORDER BY  RAND() limit $limit, ".($limit+8);
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}
	public function GetCompconnections($compId,$limit)
	{

		if($this -> link)
		{
			$query = "select distinct id,first_name,last_name,image_src from users where company_id=$compId and activated=1 ORDER BY RAND() limit $limit". ($limit+8);
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}

	public function ShowCompconnections($compId,$limit)
	{

		if($this -> link)
		{
			$query = "select distinct id,first_name,last_name,image_src,badge_points,remaining_badge_points from users where company_id=$compId and activated=1";
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}
	public function NumCompconnections($compId)
	{

		if($this -> link)
		{
			$query = "select count(id) from users where company_id=$compId and activated=1";
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
			$row = mysql_fetch_row($result);
				return $row[0];
			}
			return 0;
		}
		return 0;
	}
	 public function saveUserBadgePoints($userId,$points)
        {
        if($this->link)
        {
                $query="update users set badge_points=$points where id=$userId ";
                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
        }
	 public function updateUserRemainingBadgePoints($userId,$points)
        {
        if($this->link)
        {
                $query="update users set remaining_badge_points=$points where id=$userId ";
                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
        }

	 public function saveCompanyFrequency($compId,$points)
        {
        if($this->link)
        {
//                $query="update companies set frequency_badge_points=$points where id=$compId ";
		$query="insert into company_badges (company_id,frequency_badge_points,update_bit) values ($compId,$points,0)";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
        }

	public function ShowAllConnections($userId,$compId)
	{

		if($this -> link)
		{
			$query = "select distinct  id,first_name,last_name,image_src from  users where  id NOT IN (SELECT  distinct user_connections.user_connection_id FROM users, user_connections WHERE users.id = user_connections.user_id AND users.id =$userId) and users.id != $userId and company_id=$compId and activated=1 order by rand()";
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;
	}
	function isConnected($user_id,$id)
	{
		if($this -> link)
		{
			$query = "select distinct  id from  user_connections WHERE user_id = $user_id AND user_connection_id=$id" ;
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;
		}
		return 0;
	}

	public function get_matching_mbti($userID, $connection_mbti_value, $connectionID)
	{
		$same_mbti_connections=array(); 
		if ($this->link) 
		{	$query="SELECT id, CONCAT(first_name,' ', last_name) as name, image_src, MBTIScore from users where id IN (SELECT user_connection_id FROM user_connections where user_id=".$userID.") and MBTIScore='".$connection_mbti_value."' and id!=".$connectionID; 
			$result=mysql_query($query,$this->link); 
			if (mysql_affected_rows()>0) 
			{	while ($row=mysql_fetch_array($result)) 
				//$same_mbti_connections[]=$row['first_name'];  
				$same_mbti_connections[]=$row; 	

			} 
		} 
		return $same_mbti_connections; 
	}



}

?>

