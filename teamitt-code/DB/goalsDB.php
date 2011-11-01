<?php
class goalsDB extends DB
{
/* Leave comment about this function 

1) What does it do ?
2) When do you call it ?
3) details regarding the parameters and return type

=================Example==================

- Used to get the name of the user for some id
- Calling it to show name on profile bar

@param1:id, corresponds to userid
@return user names on success, otherwise returns 0

*/
public function addMoreGoalAction($feed_id,$user_id)
{
if($this->link)
{

$query="insert into feed_receivers (feed_id,user_id)values($feed_id,$user_id)";


$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
//$row=mysql_fetch_row($result);
return mysql_insert_id();
}
return 0;
}
return 0;
}

public function addVisibility($feed_id,$type_name,$type_id)
{
if($this->link)
{

$query="insert into visibility_bits (feed_id,type_name,type_id)values($feed_id,$type_name,$type_id)";


$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
//$row=mysql_fetch_row($result);
return mysql_insert_id();
}
return 0;
}
return 0;
}

public function addGoalAction($feed_type,$feed_from,$feed_to,$content_text,$content_type,$content_id,$goal_id,$visibility_id,$more)
{
if($this->link)
{

$query="insert into feeds (feed_type,feed_from,feed_to,content_text,content_type,content_id,goal_id,visibility_type,more)values($feed_type,$feed_from,$feed_to,'$content_text',$content_type,$content_id,$goal_id,$visibility_id,$more)";


$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
//$row=mysql_fetch_row($result);
return mysql_insert_id();
}
return 0;
}
return 0;
}

public function addGoalActionClose($goal_id,$user_id,$feed_type)
{
if($this->link)
{

$query="insert into feeds (feed_type,feed_from,content_text,content_type,goal_id,visibility_type,more)values($feed_type,$user_id,'',4,$goal_id,1,0)";


$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
//$row=mysql_fetch_row($result);
return mysql_insert_id();
}
return 0;
}
return 0;
}

public function lastGoalId()
{
        if($this -> link)
        {
                $query = "select MAX(id)  from goals ";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return $result;
                }
                return 0;
        }
        return 0;
}


public function getGoalCount($userId,$progressId)
{
	 if($this -> link)
        {
$query="select DISTINCT goals.id,goals.name,goals.image_src,DATE_FORMAT(due_date,'%D %M %Y')  from goals,goal_contributors where  goal_contributors.flag=1 and goal_contributors.goal_id=goals.id and goal_contributors.user_id=$userId and goals.progress_id=$progressId ";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return mysql_num_rows($result);
                }
                return 0;
        }
        return 0;

}
public function getGoalStatus($goalId)
{
         if($this -> link)
        {
$query="select goals.progress_id from goals where goals.id=$goalId ";
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

public function userCheck($user_email_id)
{
        if($this -> link)
        {
                $query = "select id  from users where email_id = '$user_email_id' ";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
}
public function getEmailId($user_id)
{
        if($this -> link)
        {
                $query = "select email_id  from users where id = $user_id ";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return $result;
                }
                return 0;
        }
        return 0;
}
public function getUserId($email_id)
{
        if($this -> link)
        {
                $query = "select id  from users where email_id = '$email_id' ";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return $result;
                }
                return 0;
        }
        return 0;
}

public function getGoalContributor($goal_id,$flag)
{
        if($this -> link)
        {
                $query = "select users.id,users.first_name,users.last_name,users.image_src  from users,goal_contributors where goal_contributors.goal_id = $goal_id and goal_contributors.user_id=users.id and goal_contributors.flag=$flag";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return $result;
                }
                return 0;
        }
        return 0;
}
public function getGoalContributorExceptUser($goal_id,$email_id,$flag)
{
        if($this -> link)
        {
//echo "<script>alert('$email_id')</script>";
                $query = "select users.id,users.email_id,users.image_src,users.first_name,users.last_name  from users,goal_contributors where goal_contributors.goal_id = $goal_id and goal_contributors.user_email_id=users.email_id and goal_contributors.flag=$flag and goal_contributors.user_email_id!='$email_id'";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
//echo "<script>alert('inside')</script>";
                        return $result;
                }
                return 0;
        }
        return 0;
}

public function isGoalContributor($goal_id,$user_id)
{
        if($this -> link)
        {
                $query = "select users.id,users.email_id,users.image_src,users.first_name,users.last_name  from users,goal_contributors where goal_contributors.goal_id = $goal_id and goal_contributors.user_id=users.id and users.id=$user_id and goal_contributors.flag=1";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
}
public function isPendingGoalContributor($goal_id,$user_id)
{
        if($this -> link)
        {
                $query = "select users.id,users.email_id,users.image_src,users.first_name,users.last_name  from users,goal_contributors where goal_contributors.goal_id = $goal_id and goal_contributors.user_id=users.id and users.id=$user_id and goal_contributors.flag=0";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
}

public function isGoalOwner($goal_id,$user_id)
{
        if($this -> link)
        {
                $query = "select * from goals where id=$goal_id and created_by=$user_id";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
}

public function deleteGoalContributor($goal_id)
{
        if($this -> link)
        {
                $query = "DELETE FROM goal_contributors WHERE goal_id=$goal_id ";
                $result=mysql_query($query,$this->link);

          /*      if(mysql_affected_rows()>0)
                {
                        return 1;
                }*/
                return 1;
        }
        return 0;
}

public function removeContributor($user_id,$goal_id)
{
        if($this -> link)
        {
                $query = "DELETE FROM goal_contributors WHERE goal_id=$goal_id and user_id='$user_id'";
                $result=mysql_query($query,$this->link);

          /*      if(mysql_affected_rows()>0)
                {
                        return 1;
                }*/
                return 1;
        }
        return 0;
}

public function addGoalContributor($goal_id,$user_id,$flag)
{
//echo "<script>alert('goal');</script>";
//echo "<script>alert('check');</script>";
//if($check==0)
//return 0;
//else
{
if($this->link)
{

$query="insert into goal_contributors (goal_id,user_id,flag,add_time)values($goal_id,'$user_id',$flag,NOW())";


$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
//$row=mysql_fetch_row($result);
return 1;
}
return 0;
}
}
return 0;
}
public function addGoalContributors($goalId,$peoples)
{

        if($this -> link)
        {

                $pids= explode(",", $peoples);
                if(count($pids))
                {
                        $query="insert into goal_contributors (goal_id,user_id,flag) values ";
                        $people = array();
                        foreach($pids as $pid)
                        {
                                $people[] = " ($goalId, $pid,1) ";
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


public function addGoal($goal,$user_id,$company_id,$image_src,$visibility_id,$objective,$due_date,$key_results,$progress_id)
{
if($this->link)
{

$query="insert into feeds (feed_type,feed_from,content_text,content_type,content_id,visibility_type,more)values(1,$user_id,'$goal',2,'$goal_id','$visibility_id',0)";


$query="insert into goals (name,created_by,company_id,image_src,visibility_id,objective,due_date,key_results,add_time,progress_id)values('$goal',$user_id,$company_id,'$image_src',$visibility_id,'$objective','$due_date','$key_results',NOW(),$progress_id)";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
$row=mysql_fetch_row($result);
return mysql_insert_id();
}
return 0;
}
return 0;
}
public function showGoalPotentialConnection($companyId,$goalId){
	
		if($this->link){
			$query="select distinct  id,first_name,last_name,image_src from  users where  id NOT IN (SELECT  distinct goal_contributors.user_id FROM goal_contributors WHERE goal_contributors.goal_id = $goalId ) and users.company_id=$companyId";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0){
				return $result;
			}
		return 0;
		}
	return 0;
}
public function confirmRequest($userId,$goalId)
{
	if($this->link)
	{
		$query="update goal_contributors set flag=1 where goal_id=$goalId and user_id='$userId'";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)	
		{
			return 1;
		}
		return 0;
	}
	return 0;
}	
public function updateGoal($goal,$goal_id,$image_src,$visibility_id,$objective,$due_date,$key_results,$progress_id)
{
if($this->link)
{



$query="update  goals set name ='$goal',image_src='$image_src',visibility_id=$visibility_id,objective='$objective',due_date='$due_date',key_results='$key_results',progress_id=$progress_id where id=$goal_id";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
$row=mysql_fetch_row($result);
return  -1;
}
return 0;
}
return 0;
}

public function closeGoal($goal_id)
{
if($this->link)
{



$query="update  goals set progress_id=3 where id=$goal_id";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
//$row=mysql_fetch_row($result);
return  1;
}
return 0;
}
return 0;
}


public function getGoalsById($id)
        {
                if($this -> link)
                {
		
			$query="select goals.name,goals.image_src,objective,DATE_FORMAT(due_date,'%D %M %Y'),key_results,first_name,last_name,created_by,progress_types.name,DATE_FORMAT(goals.add_time,'%D %M %Y') from goals,users,progress_types  where goals.created_by=users.id and progress_types.id=goals.progress_id and goals.id = $id";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {	
                                return $result;
                        }
                        return 0;
                }
                return 0;
        }


public function GetGoalProfile($id)
{
	if($this -> link)
	{
		$query = "select goals.name,users.first_name,users.last_name,goals.objective,goals.key_results,DATE(goals.due_date),goals.progress_id,goals.visibility_id,goals.image_src  from goals,users where goals.id=$id and goals.created_by=users.id";
//		 if($user_id != null)
  //                       $query .= " AND users.id = $user_id limit 1 ";

		//$query = "select name,objective,key_results  from goals where created_by = $user_id limit 1";
		$result=mysql_query($query,$this->link);
		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}

public function editGoal($user_id)
{
	if($this -> link)
	{
		$query = "select first_name ,last_name  from users where id = $user_id ";
		$result=mysql_query($query,$this->link);

		if(mysql_affected_rows()>0)
		{
			return $result;
		}
		return 0;
	}
	return 0;
}
function getGoalByUserId($user_id){
        if($this->link){
$query="select DISTINCT goals.id,goals.name,goals.image_src,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name,users.first_name,users.id  from goals,goal_contributors,progress_types,users where  goal_contributors.flag=1 and goal_contributors.goal_id=goals.id and goal_contributors.user_id=$user_id and goals.progress_id=progress_types.id and goals.created_by=users.id";

//		$query="select DISTINCT goals.id,goals.name,goals.image_src,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name  from goals,goal_contributors,users,progress_types where users.id=$user_id and ((users.email_id=goal_contributors.user_email_id and goal_contributors.flag=1 and goal_contributors.goal_id=goals.id ) or goals.created_by=$user_id)and goals.progress_id=progress_types.id ";

                /*$query = "SELECT goals.id, goals.name,goals.image_src,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name
                        FROM goals,progress_types
                        WHERE goals.created_by = $user_id and progress_types.id=goals.progress_id";*/

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
                        return $result;;
                }
                else return 0;
        }
}
function getGoalByCompanyId($company_id){
        if($this->link){
                $query = "SELECT goals.id, goals.name,goals.image_src,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name,users.first_name,users.id
                        FROM goals,progress_types,users
                        WHERE goals.company_id = $company_id and progress_types.id=goals.progress_id and users.id=goals.created_by";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
                        return $result;
                }
                else return 0;
        }
}

function isCompanyGoal($companyId,$goalId){
        if($this->link){
                $query = "select *
                        FROM goals
                        WHERE goals.company_id = $companyId and goals.id=$goalId";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
                        return 1;
                }
                else return 0;
        }
}

function goalName($goalid)
{

                $query = "SELECT goals.name FROM goals where goals.id=$goalid";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
		$row=mysql_fetch_row($result);
                        return $row[0];
		}		
return 0;



}
 public function updateGoalImage($image,$id)
        {
                if($this->link)
                {
                        $query="update goals set image_src='$image' where id='$id'";
                        $result=mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0)
                        {
                                return 1;
                        }
                        return 0;
                }
                return 0;
        }
public function countGoalProgress($userId,$progress){
	if($this->link)
	{
		$query="select count(goals.id) from goals,goal_contributors where goals.progress_id=$progress and goal_contributors.user_id=$userId and goals.id=goal_contributors.goal_id";
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

public function getGoalOwner($goalId){
        if($this->link)
        {
                $query="select created_by from goals where goals.id=$goalId ";
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

}

?>
