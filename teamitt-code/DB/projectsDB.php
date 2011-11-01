<?php
class projectsDB extends DB
{

public function projectName($project_id)
{

                $query = "SELECT projects.name FROM projects where projects.id=$project_id";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
		$row=mysql_fetch_row($result);
                        return $row[0];
		}		
return 0;



}





	public function addProject($name,$user_id,$company_id,$objective,$due_date,$progress_id)
	{
		if($this->link)
		{

			//$query="insert into feeds (feed_type,feed_from,content_text,content_type,content_id,visibility_type,more)values(1,$user_id,'$goal',2,'$goal_id','$visibility_id',0)";
			$query="insert into projects (name,created_by,company_id,objective,due_date,add_time,progress_id)values('$name',$user_id,$company_id,'$objective','$due_date',NOW(),$progress_id)";
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
	public function getProjectById($id)
        {
                if($this -> link)
                {
                        $query="select projects.name,objective,DATE_FORMAT(due_date,'%D %M %Y'),first_name,last_name,created_by,progress_types.name ,DATE_FORMAT(projects.add_time,'%D %M %Y') from projects,users,progress_types  where projects.created_by=users.id and progress_types.id=projects.progress_id and projects.id = $id";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
                                return $result;
                        }
                        return 0;
                }
                return 0;
        }
	function isCompanyProject($companyId,$projectId){
        if($this->link){
                $query = "select *
                        FROM projects
                        WHERE projects.company_id = $companyId and projects.id=$projectId";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
                        return 1;
                }
                else return 0;
        	}
	}
	public function getProjectContributor($project_id,$flag)
	{
        if($this -> link)
        {
                $query = "select users.id,users.email_id,users.image_src,users.first_name,users.last_name  from users,project_contributors where project_contributors.project_id = $project_id and project_contributors.user_id=users.id and project_contributors.flag=$flag";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return $result;
                }
                return 0;
        }
        return 0;
	}
	public function showProjectPotentialConnection($companyId,$projectId){

                if($this->link){
                        $query="select distinct  id,first_name,last_name,image_src from  users where  id NOT IN (SELECT  distinct project_contributors.user_id FROM project_contributors WHERE project_contributors.project_id = $projectId ) and users.company_id=$companyId";
                        $result=mysql_query($query,$this->link);
                        if(mysql_affected_rows()>0){
                                return $result;
                        }
                return 0;
                }
        return 0;
}

public function addProjectContributors($projectId,$peoples)
{

        if($this -> link)
        {

                $pids= explode(",", $peoples);
                if(count($pids))
                {
                        $query="insert into project_contributors (project_id,user_id,flag) values ";
                        $people = array();
                        foreach($pids as $pid)
                        {
                                $people[] = " ($projectId, $pid,1) ";
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

public function isProjectOwner($project_id,$user_id)
{
        if($this -> link)
        {
                $query = "select * from projects where id=$project_id and created_by=$user_id";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
}

public function isProjectContributor($project_id,$user_id)
{
        if($this -> link)
        {
                $query = "select users.id,users.email_id,users.image_src,users.first_name,users.last_name  from users,project_contributors where project_contributors.project_id = $project_id and project_contributors.user_id=users.id and users.id=$user_id and project_contributors.flag=1";
                $result=mysql_query($query,$this->link);

                if(mysql_affected_rows()>0)
                {
                        return 1;
                }
                return 0;
        }
        return 0;
}
function getProjectByCompanyId($company_id){
        if($this->link){
                $query = "SELECT projects.id, projects.name,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name,users.first_name,users.id
                        FROM projects,progress_types,users
                        WHERE projects.company_id = $company_id and progress_types.id=projects.progress_id and users.id=projects.created_by";

                $result=mysql_query($query,$this->link);
                if(mysql_affected_rows()>0){
                        return $result;
                }
                else return 0;
        }
}
public function getProjectProfile($id)
{
        if($this -> link)
        {
                $query = "select projects.name,users.first_name,users.last_name,projects.objective,DATE(projects.due_date),projects.progress_id from projects,users where projects.id=$id and projects.created_by=users.id";
//               if($user_id != null)
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
public function updateProject($project,$project_id,$objective,$due_date,$progress_id)
{
if($this->link)
{



$query="update  projects set name ='$project',objective='$objective',due_date='$due_date',progress_id=$progress_id where id=$project_id";
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
public function getProjectStatus($projectId)
{
         if($this -> link)
        {
$query="select projects.progress_id from projects where projects.id=$projectId ";
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
public function removeContributor($user_id,$project_id)
{
        if($this -> link)
        {
                $query = "DELETE FROM project_contributors WHERE project_id=$project_id and user_id=$user_id";
                $result=mysql_query($query,$this->link);

          /*      if(mysql_affected_rows()>0)
                {
                        return 1;
                }*/
                return 1;
        }
        return 0;
}
public function closeProject($project_id)
{
if($this->link)
{



$query="update  projects set progress_id=3 where id=$project_id";
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
function getProjectByUserId($user_id){
        if($this->link){
$query="select DISTINCT projects.id,projects.name,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name  from projects,project_contributors,progress_types where  project_contributors.flag=1 and project_contributors.project_id=projects.id and project_contributors.user_id=$user_id and projects.progress_id=progress_types.id ";

//              $query="select DISTINCT goals.id,goals.name,goals.image_src,DATE_FORMAT(due_date,'%D %M %Y'),progress_types.name  from goals,goal_contributors,users,progress_types where users.id=$user_id and ((users.email_id=goal_contributors.user_email_id and goal_contributors.flag=1 and goal_contributors.goal_id=goals.id ) or goals.created_by=$user_id)and goals.progress_id=progress_types.id ";

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
public function addProjectAction($feed_type,$feed_from,$feed_to,$content_text,$content_type,$content_id,$visibility_id,$more)
{
if($this->link)
{

$query="insert into feeds (feed_type,feed_from,feed_to,content_text,content_type,content_id,project_id,visibility_type,more)values($feed_type,$feed_from,$feed_to,'$content_text',$content_type,$content_id,$content_id,$visibility_id,$more)";


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
public function addProjectActionClose($project_id,$user_id,$feed_type)
{
if($this->link)
{

$query="insert into feeds (feed_type,feed_from,content_text,content_type,project_id,visibility_type,more)values($feed_type,$user_id,'',5,$project_id,1,0)";


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
public function addProjectContributor($project_id,$user_id,$flag)
{
//echo "<script>alert('goal');</script>";
//echo "<script>alert('check');</script>";
//if($check==0)
//return 0;
//else
{
if($this->link)
{

$query="insert into project_contributors (project_id,user_id,flag,add_time)values($project_id,'$user_id',$flag,NOW())";


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


}
?>
