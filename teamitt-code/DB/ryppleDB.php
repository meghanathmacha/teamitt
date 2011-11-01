<?php
class ryppleDB extends DB{

sharingFeeds($feed_id,$shareids,$forgetids)
{
			$uids= explode(",", $shareids);
			$type_name = 1;
			if(count($uids))
			{
				$query="insert into visiblity_bits (feed_id,type_name,type_id) values";
				$user = array();
				foreach($uids as $uid)
				{
					$user[] = " ($feed_id,$type_name,$uid) ";
				}

				$dquery = implode(",", $user);

				$query= $query.$dquery;
			}
}
function deleteUser($feed_id,$user_id){
if($this->link){
	for($i=0;$i<count($user_id);$i++){
		$query1="SELECT * from visibility_bits WHERE feed_id=".$feed_id." type_name=1 type_id=".$user_id[$i][0];
		$result=mysql_query($query1,$this->link);
		if(mysql_affected_rows()==0){
			$query2="INSERT INTO visibility_bits ( feed_id , type_name , type_id,flag) VALUES (".$feed_id.", 1, ".$user_id[$i][0].",$user_id[$i][1])";
			$result=mysql_query($query2,$this->link);	
		}
		else{
			$query3="UPDATE visibility_bits SET flag=".$user_id[$i][1]." WHERE feed_id=".$feed_id." AND type_name=1 AND type_id=".$user_id[$i][0];
			$result=mysql_query($query3,$this->link);
		}
	}
	return $result;

}
}

function attachToGoal($feed_id,$goal_id){
	if($this->link){
		$query="UPDATE feeds SET goal_id=".$goal_id." WHERE id=".$feed_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return 1;
		}
		else return 0;
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

function ThankGiven($user_id){
	if($this->link){
		$query="SELECT * from feeds WHERE feed_type=2 AND feed_from=".$user_id;
		$result=mysql_query($query,$this->link);
		//$tg=mysql_affected_rows();
		if(mysql_affected_rows()>0){
			return $result;
		}
		else return 0;
	}
}

function ThankReceived($user_id){
	if($this->link){
		$query="SELECT id from feeds WHERE feed_type=2 AND feed_to=".$user_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return $result;
		}
		else return 0;
//		$tr=mysql_affected_rows();
	}
}

function checkExistence($user_id,$feed_id){
	if($this->link){
		$query="SELECT * from visibility_bits WHERE type_name=1 AND type_id=".$user_id." feed_id=".$feed_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()==0){
			return 0;
		}
		else return 1;
	}
//	else return true;
}

function checkConnection($user1,$user2){
	if($this->link){
		$query="SELECT * from friend_relations WHERE user_1=".$user1." user_2=".$user2;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()==0){
			return 0;
		}
		else return 1;
	}

}

function getConncetion($user1){
	if($this->link){
		$query="SELECT user_2 from friend_relations WHERE user_1=".$user1;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0){
			return $result;
		}
		else return null;
	}
}

function commentExistence($user_id,$feed_id){
	if($this->link){
		$query="SELECT * from feed_comments WHERE feed_id=".$feed_id." AND comment_from=".$user_id;
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()==0){
			return 0;
		}
		else return 1;
	}
}

}

function getGoalsByUserId($user_id){
	if($this->link){
		$query = "select goals.id,goals.name
		  	from goals,users,goal_contributors 
			where users.id = $user_id
			and user.email_id = goal_contributors.email_id
			and goal_contributors.id = goals.id "
		$query1="SELECT email_id FROM users WHERE id=".$user_id;
		$result=mysql_query($query1,$this->link);
		if(mysql_affected_rows()==0){
			return 0;
		}
		else{
			$user_info=mysql_fetch_assoc($result);
			$user_email=$user_info['email_id'];
			$query2="SELECT goal_id FROM goal_contributors WHERE user_email_id='".$user_email."'";
			$result2=mysql_query($query2,$this->link);
			if(mysql_affected_rows()==0){
				return 0;
			}
			else{
				$goal_info=mysql_fetch_assoc($result2);
				$goal_id=$goal_info('goal_id');
				$query3="SELECT * FROM goals WHERE id=".$goal_id;
				$result3=mysql_query($query3,$this->link);
				if(mysql_affected_rows()==0){
					return 0;
				}
				else return $result3;
			}
		}
	}
}


function getConnectionGoal($user_id){



}
function getAllGoals($user_id){
// user_id ->
	if($this->link){
		$query1="SELECT company_id FROM id WHERE id=".$user_id;
		$result1=mysql_query($query1,$this->link);
		$user_info=mysql_fetch_assoc($result1);
		$company_id=user_info['company_id'];
		
		$query2="SELECT email_id FROM users WHERE company_id=".$company_id;
		$result2=mysql_query($query2,$this->link);
		


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
			else return 1;
		}
	}	
}

?>
