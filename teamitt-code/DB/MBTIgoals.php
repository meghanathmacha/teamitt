<?php
class MBTIgoals extends DB
{

	public function get_consolidated_MBTI($goalID)
	{
		if ($this->link) 
		{ 
			$query="SELECT * FROM goal_consolidated_mbti where goalID=". $goalID; 
			$recordset=mysql_query($query, $this->link); 
			if (mysql_affected_rows()==0)		// goal has just been created and so no entry in the consolidated mbti table. So return 1 to add.  
				return 1; 
			if (mysql_affected_rows()==1) 		// consolidated mbti recored exists. 	
			{ 
				$row=mysql_fetch_array($recordset); 
				return $row; 
			} 
			return 0; 
		} 
		return 0; 
	}
	
	public function insert_consolidated_goal_mbti($goal_mbti)
	{ 
		if ($this->link)
                {       
			$query="INSERT INTO `goal_consolidated_mbti`(`goalID`, `E`, `I`, `S`, `N`, `F`, `T`, `J`, `P`) VALUES (".$goal_mbti['goalID'].",".$goal_mbti['E'].",".$goal_mbti['I'].",".$goal_mbti['S'].",".$goal_mbti['N'].",".$goal_mbti['F'].",".$goal_mbti['T'].",".$goal_mbti['J'].",".$goal_mbti['P'].")";
                        mysql_query($query, $this->link);
                        //echo $query . '<BR>' ;
                        return 1;
                }
                return 0;

	} 
	public function update_consolidated_goal_mbti($goal_mbti)
	{ 
		if ($this->link) 
		{	echo 'updating<BR>' ;  
			$query="UPDATE `goal_consolidated_mbti` SET `E`=".$goal_mbti['E'].", `I`=".$goal_mbti['I'].",`S`=".$goal_mbti['S'].",`N`=".$goal_mbti['N'].",`F`=".$goal_mbti['F'].",`T`=".$goal_mbti['T'].",`J`=".$goal_mbti['J'].",`P`=".$goal_mbti['P']. " WHERE `goalID`=".$goal_mbti['goalID']; 
			mysql_query($query, $this->link); 
			//echo $query . '<BR>' ; 
			return 1; 
		}
		return 0; 
	}

	public function get_goal_mbti_tips($goal_mbti)
	{	
		if ($this->link)
                {
			$query="SELECT tipsID from `goal_mbti_tips` where ";
			$flag=0; 
			if ($goal_mbti['E']>0) 
				if ($flag==0) 
				{	$query=$query . "`mbti_type`='E'"; 
					$flag=1; 
				} 
			if ($goal_mbti['I']>0)
				if ($flag==0) 
                                {	$query=$query . "`mbti_type`='I'";
					$flag=1; 
				}
				else 
					$query=$query . " OR `mbti_type`='I'";
			if ($goal_mbti['S']>0)
				if ($flag==0) 
				{ 	$query=$query . "`mbti_type`='S'";
					$flag=1; 
				}
				else
					$query=$query . " OR `mbti_type`='S'";
			if ($goal_mbti['N']>0)
                                if ($flag==0)
                                {	$query=$query . "`mbti_type`='N'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR `mbti_type`='N'";
			if ($goal_mbti['F']>0)
                                if ($flag==0)
                                {	$query=$query . "`mbti_type`='F'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR `mbti_type`='F'";
			if ($goal_mbti['T']>0)
                                if ($flag==0)
                                {	$query=$query . "`mbti_type`='T'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR `mbti_type`='T'";
			if ($goal_mbti['J']>0)
                                if ($flag==0)
                                {	$query=$query . "`mbti_type`='J'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR `mbti_type`='J'";
			if ($goal_mbti['P']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type`='P'";
                                        $flag=1;
                                }
                                else
					 $query=$query . " OR `mbti_type`='P'";	
			$recordset=mysql_query($query, $this->link);
			if (mysql_affected_rows()>0)
                        {	
				$r=mysql_num_rows($recordset);
				for ($i=0; $i<$r; $i++) 
				{ 
                                	$row[]=mysql_fetch_assoc($recordset);
				}
                                return $row;
                        }
                        return 0;		
		}
		return 0; 
	} // END OF FUNCTION 

	public function get_goal_tips($goalID) 
	{
		if ($this->link)
                {	
			$query="SELECT tipsID from goal_tips where goalID=". $goalID;
			$recordset=mysql_query($query, $this->link); 
//			echo ' goal_tips ' . mysql_num_rows($recordset) . ' ** '; 
			if (mysql_affected_rows()>0) 
			{ 
				$r=mysql_num_rows($recordset);
                                for ($i=0; $i<$r; $i++)
                                {
                                        $row[]=mysql_fetch_assoc($recordset);
                                }
                                return $row;
			} 
			return 0; 
		} 
 		return 0; 
	} // END OF FUNCTION 
	
	public function add_new_tips($goalID,$tipsID)
	{ 	
		if ($this->link)
                {	
			$query="INSERT INTO `goal_tips`(`goalID`, `tipsID`) VALUES (".$goalID.",".$tipsID." )"; 
			mysql_query($query, $this->link);	
		}
		
	} // END OF FUNCTION 	
	
	public function get_goal_mbti_checklist($goal_mbti)
	{	if ($this->link) 
		{ 
			$query="SELECT checklistID from goal_mbti_checklist where ";
			$flag=0; 

                        if ($goal_mbti['E']>0)
				if ($flag==0) 
				{	$query=$query . "mbti_type='E'";
					$flag=1; 
				} 
                        if ($goal_mbti['I']>0)
				if ($flag==0) 
				{ 	$query=$query . "mbti_type='I'";
					$flag=1; 
				} 
				else 
					$query=$query . " OR mbti_type='I'";
                        if ($goal_mbti['S']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type='S'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR mbti_type='S'";
                        if ($goal_mbti['N']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type='N'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR mbti_type='N'";
                        if ($goal_mbti['F']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type='F'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR mbti_type='F'";
                        if ($goal_mbti['T']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type='T'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR mbti_type='T'";
                        if ($goal_mbti['J']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type='J'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR mbti_type='J'";
                        if ($goal_mbti['P']>0)
                                if ($flag==0)
                                {	$query=$query . "mbti_type='P'";
                                        $flag=1;
                                }
                                else
					$query=$query . " OR mbti_type='P'";
                        $recordset=mysql_query($query, $this->link);
                        if (mysql_affected_rows()>0)
                        {       $r=mysql_num_rows($recordset);
                                for ($i=0; $i<$r; $i++)
                                {
                                        $row[]=mysql_fetch_assoc($recordset);
                                }
                                return $row;
                        }
                        return 0;
		} 
		return 0;  

	} // END OF FUNCTION 

	public function get_goal_checklist($goalID)
	{ 
		if ($this->link) 
		{ 
			$query="SELECT checklistID from goal_checklist where goalID=". $goalID;
                        $recordset=mysql_query($query, $this->link);
                        if (mysql_affected_rows()>0)
                        {
                                $r=mysql_num_rows($recordset);
                                for ($i=0; $i<$r; $i++)
                                {
                                        $row[]=mysql_fetch_assoc($recordset);
                                }
                                return $row;
                        }
                        return 0;	
		} 
		return 0; 
	} // END OF FUNCTION 

	public function add_new_checklist_item($goalID, $checklistID) 
	{ 
		if ($this->link)
                {
		        $query="INSERT INTO `goal_checklist` (`goalID`, `checklistID`) VALUES (".$goalID.",".$checklistID." )";
	//		echo ' (Query:' . $query . ') ' ; 	
			mysql_query($query, $this->link);
                }
	
	} // END OF FUNCTION 

	public function fetch_goal_tips($goalID)
	{ 	
		if ($this->link) 
		{ 	$query="SELECT a.goaltipsID AS goaltipsID, b.tipsID AS tipsID, b.tips AS tips, b.mbti_type AS mbti_type from goal_tips as a, goal_mbti_tips as b where b.tipsID=a.tipsID and a.goalID=".$goalID." order by b.mbti_type"; 
//			$query="SELECT tipsID, tips, mbti_type from goal_mbti_tips where tipsID in (SELECT tipsID from goal_tips where goalID=".$goalID.") order by mbti_type ";
			$recordset=mysql_query($query, $this->link) ; 
			if (mysql_affected_rows()>0)
                        {
                                $r=mysql_num_rows($recordset);
                                for ($i=0; $i<$r; $i++)
                                {
                                        $row[]=mysql_fetch_assoc($recordset);
                                }
                                return $row;
                        }
                        return 0;
		} 
		return 0; 
	} // END OF FUNCTION 

	public function fetch_goal_checklist($goalID)
	{ 
		if ($this->link)
                {

                        $query="SELECT a.checklistID AS checklistID, a.checklist AS checklist, a.mbti_type AS mbti_type, b.goalchecklistID AS goalchecklistID from goal_mbti_checklist as a, goal_checklist as b where a.checklistID=b.checklistID and b.goalID=".$goalID." order by a.mbti_type";
//                        $query="SELECT checklistID, checklist, mbti_type from goal_mbti_checklist where checklistID in (SELECT checklistID from goal_checklist where goalID=".$goalID.") order by mbti_type";
                        $recordset=mysql_query($query, $this->link) ;
                        if (mysql_affected_rows()>0)
                        {
                                $r=mysql_num_rows($recordset);
                                for ($i=0; $i<$r; $i++)
                                {
                                        $row[]=mysql_fetch_assoc($recordset);
                                }
                                return $row;
                        }
                        return 0;
                }
                return 0;

	} // END OF FUNCTION

	public function ifuserliked($userID,$ID,$goalID, $type)
	{	if ($this->link) 
		{	if ($type=='tip') 
				$query="SELECT goaltipsID from goal_tips_like where goaltipsID=".$ID." and userID=".$userID;
			else
				$query="SELECT goalchecklistID from goal_checklist_like where goalchecklistID=".$ID." and userID=".$userID;
			//echo '<div id="test">'.$query.$type.'</div>';
			mysql_query($query, $this->link); 
			if (mysql_affected_rows()>0)
			{	
				return 1; 
			}
			else 
			{	
				return 0; 
			}
		} 
		return 9;
	}// END OF FUNCTION 
	
	public function insertlike($userID,$goalID,$ID, $type)
	{ 	if ($this->link) 
		{	if ($type=='tip') 
				$query="INSERT INTO `goal_tips_like`(`goaltipsID`, `userID`) VALUES (".$ID.",".$userID.")"; 
			else
				$query="INSERT INTO goal_checklist_like (goalchecklistID, userID) VALUES (".$ID.",".$userID.")";
			mysql_query($query,$this->link); 
			if (mysql_affected_rows()>0)
				return 1; 
			else 
				return 666; 
		}
		return 9; 
	} // END OF FUNCTION

 	public function getlikes($ID, $type)
	{	if ($this->link) 
		{	if ($type=='tip') 
				$query="SELECT id, first_name from users where id IN (SELECT userID from goal_tips_like where goaltipsID=".$ID.")"; 
			if ($type=='checklist') 
				$query="SELECT id, first_name from users where id IN (SELECT userID from goal_checklist_like where goalchecklistID=".$ID.")"; 
			$result = mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0)
                        {
                                return $result;
                        }
		} 
		return 0; 
	} // END OF FUNCTION getlikes

	public function insertcomment($USERID,$ID,$commtext, $type)
	{
		if ($this->link) 
		{ 	if ($type=='tip')
				$query="INSERT INTO `goal_tips_comments`(`goaltipsID`, `comments`, `userID`) VALUES (".$ID.",'".$commtext."', ".$USERID.")"; 
			if ($type=='checklist')
				$query="INSERT INTO goal_checklist_comments (goalchecklistID, comments, userID) VALUES (".$ID.",'".$commtext."',".$USERID.")"; 
			mysql_query($query,$this->link);
                        if (mysql_affected_rows()>0)
			{	if ($type=='tip') 
					$query = "SELECT LAST_INSERT_ID() from goal_tips_comments";
				if ($type=='checklist')
					$query="SELECT LAST_INSERT_ID() from goal_checklist_comments"; 
                       	 	$result = mysql_query($query);
	                        $row = mysql_fetch_row($result);
        	                $last_id = $row[0];
                	        return $last_id;
				//return $query; 
			}
			return 0; 
		} 
		return 0; 
	} // END OF function insertcomment

	public function getComments($ID, $type)
	{
		if ($this->link) 
		{ 	if ($type=='tip') 
				$query="SELECT first_name, comments as comment_text, userID as comment_from, tipcommentID as id from goal_tips_comments, users where goaltipsID=".$ID." and  users.id IN (SELECT userID from goal_tips_comments where goaltipsID=".$ID.")"; 
			if ($type=='checklist') 
				$query="SELECT first_name, comments as comment_text, userID as comment_from, checklistcommentID as id from goal_checklist_comments, users where goalchecklistID=".$ID." and  users.id IN (SELECT userID from goal_checklist_comments where goalchecklistID=".$ID.")"; 
			$result = mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0)
                        {
                                return $result;
                        }
			return 0; 
		} 
		return 0; 
	}

	public function deleteComment($comment_id, $type)
        {
                if($this->link)
                {	if ($type=='tip') 
				$query = "delete from goal_tips_comments where tipcommentID =".$comment_id;
			else
				$query = "delete from goal_checklist_comments where checklistcommentID =". $comment_id ;
                        $result=mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0)
                        {
                                return $result;
                        }
                        return 0;
                }
                return 0;
        }



} // END OF CLASS MBTIgoals 

?>

