<?php
class postsDB extends DB
{


        public function AddAction($action, $USERID, $param_type, $param_id)
        {
                if($this->link)
                {
		$query=" insert into actions (content, addedby, param_type, param_id) values(\"$action\", $USERID, $param_type,  $param_id)";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				/*$q = "Select LAST_INSERT_ID() FROM actions";
				$r = mysql_query($q);
				$ro = mysql_fetch_row($r);
				return $ro[0];*/
				return mysql_insert_id();
				
                        }

                        return 0;
                }
                return 0;
        }

	public function insertActionReceivers($action_id, $userids)
	{
		if($this->link)
		{
			$uids= explode(",", $userids);
			if(count($uids))
			{
				$query="insert into action_receivers (action_id, user_id) values";
				$user = array();
				foreach($uids as $uid)
				{
					$user[] = " ($action_id, $uid) ";
				}

				$dquery = implode(",", $user);

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



	public function AddThank($thank, $USERID, $badgeid)
        {
                if($this->link)
                {
		if(!is_numeric){ $badgeid =0; }
		$query=" insert into thanks (content, addedby, badgeid) values(\"$thank\", $USERID, $badgeid)";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				/*$q = "Select LAST_INSERT_ID() FROM thanks";
				$r = mysql_query($q);
				$ro = mysql_fetch_row($r);
				return $ro[0];*/
				return mysql_insert_id();
                        }

                        return 0;
                }
                return 0;
        }

	public function insertThankReceivers($thank_id, $userids)
	{
		if($this->link)
		{
			$uids= explode(",", $userids);
			if(count($uids))
			{
				$query="insert into thank_receivers (thank_id, user_id) values";
				$user = array();
				foreach($uids as $uid)
				{
					$user[] = " ($thank_id, $uid) ";
				}

				$dquery = implode(",", $user);

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


public function AddUpdate($update, $USERID)
        {
                if($this->link)
                {
		$query=" insert into updates (content, addedby) values(\"$update\", $USERID)";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				/*$q = "Select LAST_INSERT_ID() FROM updates";
				$r = mysql_query($q);
				$ro = mysql_fetch_row($r);
				return $ro[0];*/
				return mysql_insert_id();
                        }

                        return 0;
                }
                return 0;
        }

public function AddFeedback($feedback, $PROFILEID, $USERID, $given)
        {
                if($this->link)
                {
		$query=" insert into feedbacks (feedback_for, feedback_by, feedback, given) values($PROFILEID, $USERID, \"$feedback\", $given)";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				/*$q = "Select LAST_INSERT_ID() FROM updates";
				$r = mysql_query($q);
				$ro = mysql_fetch_row($r);
				return $ro[0];*/
				return mysql_insert_id();
                        }

                        return 0;
                }
                return 0;
        }



	public function insertFeed($feed_type, $feed_from, $feed_to, $content_text, $content_type, $content_id, $more)
        {
                if($this->link)
                {
		$query=" insert into feeds (feed_type, feed_from, feed_to, content_text, content_type, content_id, goal_id, more, add_time, last_update_time) values($feed_type, $feed_from, $feed_to, \"$content_text\", '$content_type', $content_id, 0, $more, NOW(), NOW())";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				/*	$q = "Select LAST_INSERT_ID() FROM feeds";
				$r = mysql_query($q);
				$ro = mysql_fetch_row($r);
				return $ro[0];*/
				return mysql_insert_id();
                        }

                        return 0;
                }
                return 0;
        }


	public function insertProjectFeed($feed_type, $feed_from, $feed_to, $content_text, $content_type, $content_id, $project_id, $more)
        {
                if($this->link)
                {
		$query=" insert into feeds (feed_type, feed_from, feed_to, content_text, content_type, content_id, project_id, more, add_time) values($feed_type, $feed_from, $feed_to, \"$content_text\", '$content_type', $content_id, $project_id, $more, NOW())";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				/*	$q = "Select LAST_INSERT_ID() FROM feeds";
				$r = mysql_query($q);
				$ro = mysql_fetch_row($r);
				return $ro[0];*/
				return mysql_insert_id();
                        }

                        return 0;
                }
                return 0;
        }


	public function insertFeedReceivers($feed_id, $userids)
	{
		if($this->link)
		{
			$uids= explode(",", $userids);
			if(count($uids))
			{
				$query="insert into feed_receivers (feed_id, user_id) values";
				$user = array();
				foreach($uids as $uid)
				{
					$user[] = " ($feed_id, $uid) ";
				}

				$dquery = implode(",", $user);

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

	public function insertVisibility($feed_id, $type_name, $userids)
	{
		if($this->link)
		{
			$uids= explode(",", $userids);
			if(count($uids))
			{
				$query="insert into visibility_bits (feed_id, type_name, type_id) values";
				$user = array();
				foreach($uids as $uid)
				{
					$user[] = " ($feed_id, $type_name, $uid) ";
				}

				$dquery = implode(",", $user);

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





}

?>

