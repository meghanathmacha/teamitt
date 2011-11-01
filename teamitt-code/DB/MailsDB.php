<?php

class MailsDB extends DB
{

	public function putmail($MAIL_TYPE, $vars)
	{
		$serialized_vars = serialize($vars);

		if($this->link)
		{
		$query = "insert into mail_queue (mail_type, vars) values ('$MAIL_TYPE', '$serialized_vars')";
		mysql_query($query);

		}

	}

	public function getmail($max=100)
	{
		if($this->link)
		{
		$query = "select mail_id, mail_type, vars from mail_queue limit 0,$max";
		$result = mysql_query($query);
		return $result;

		}

	}

	public function removemail($mail_id)
	{

		if($this->link)
		{
		$query = "delete from mail_queue where mail_id = $mail_id";
		$result = mysql_query($query);
		if(mysql_affected_rows() > 0)
		{
			return True;
		}
		return False;
		}

	}





	public function getActionReceivers($action_id, $uid)
	{
		if($this->link)
		{
			$query="select email_id, first_name from action_receivers, users where action_receivers.user_id = users.id and action_id=$action_id and users.id != $uid";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;


	}

	public function getThankReceivers($thank_id)
	{
		if($this->link)
		{
			$query="select email_id, first_name from thank_receivers, users where thank_receivers.user_id = users.id and thank_id=$thank_id";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;


	}

	public function getBadgeName($badgeid)
	{
                if($this->link && $badgeid)
                {
			$query = "SELECT badgename FROM badges WHERE badgeid = $badgeid";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				$row = mysql_fetch_row($result);
				return $row[0];
                        }

                        return NULL;
                }
                return NULL;
	}




	public function getFeedReceivers($feed_id, $uid)
	{
		if($this->link)
		{
			$query="select users.id,email_id, first_name from feed_receivers, users where feed_receivers.user_id = users.id and feed_id=$feed_id";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;


	}

	public function getFeedTo($feed_id, $uid)
	{
		if($this->link)
		{
			$query="select users.id, email_id, first_name from feeds, users where feed_to = users.id and feeds.id=$feed_id";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;


	}
	public function getFeedCommenters($feed_id, $uid)
	{
		if($this->link)
		{
			$query="select users.id,email_id, first_name from feed_comments, users where comment_from = users.id and feed_id=$feed_id";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return $result;
			}
			return 0;
		}
		return 0;


	}

	

	public function getFullName($uid)
	{
		if($this->link)
		{
			$query="select CONCAT(first_name, ' ', last_name) from users where id=$uid ";
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

	
	public function getInviteKey($uid, $email)
	{
                if($this->link)
                {
			$query = "SELECT ikey from invitations WHERE userid = $uid and invited = '$email'";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				$row = mysql_fetch_row($result);
				return $row[0];
                        }

                        return NULL;
                }
                return NULL;
	}


}

?>
