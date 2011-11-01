<?php
class badgeDB extends DB
{

	public function getBadgeIdByThankId($thank_id)
	{
                if($this->link)
                {
			$query = "SELECT badges.badgeid,badgename,url
				FROM thanks,badges
				WHERE id = $thank_id
				and thanks.badgeid = badges.badgeid ";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				return $result;
                        }

                        return 0;
                }
                return 0;
	}
	public function getBadge($badgeid,$compId)
	{
                if($this->link)
                {
			$query = "SELECT badgename,url,total_points FROM badges,company_badge_points WHERE badgeid = $badgeid and badges.badgeid=company_badge_points.badge_id and company_id=$compId";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				$row = mysql_fetch_row($result);
				return $row;
                        }

                        return 0;
                }
                return 0;
	}


        public function getBadges()
        {
                if($this->link)
                {
$query="select badgeid, badgename, url,badge_points from badges";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				return $result;
                        }

                        return 0;
                }
                return 0;
        }
	 public function getBadgesByCompanyId($compId)
        {
                if($this->link)
                {
		$query="select badgeid, badgename, url,total_points from badges,company_badge_points where badges.badgeid=company_badge_points.badge_id and company_id=$compId";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
                                return $result;
                        }

                        return 0;
                }
                return 0;
        }

	public function getrandomBadge($rempts)
        {
                if($this->link)
                {
$query="select badgeid, badgename, url from badges where $rempts >= badge_points order by RAND() limit 1";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
$row=mysql_fetch_row($result);
				return $row;
                        }

                        return 0;
                }
                return 0;
        }



	public function getBadgeUrl($badgeid)
        {
                if($this->link)
                {
$query="select  url from badges where badgeid=$badgeid";
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
	public function saveBadgePoints($badgeId,$points,$compId)
	{
        if($this->link)
        {
                $query="update company_badge_points set total_points=$points where badge_id=$badgeId and company_id=$compId ";
                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
	}




}
?>

