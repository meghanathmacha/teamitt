<?php
include ("../checkid.php");
require_once ("goal_mbti.php");
 
function confirmRequest($userId,$goalId,$DB, $mbti, $users)
{
/*	// *A : CALL to update goal consolidated mbti 
	$goal_mbti=array() ; $j=0; 
	$goal_mbti=update_goal_consolidated_mbti($goalId, $userId, 'add', $mbti, $users);	
 	if ($goal_mbti!=NULL)
        {       $j=update_goal_mbti_tips($goal_mbti, $mbti, 'add');
                if ($j!=0)
                {       $j=update_goal_mbti_checklist($goal_mbti, $mbti);
			if ($j==0) 
				echo 'failed to update goal checklist<br>' ; 
                }
		else 
			echo 'failed to updated goal tips<br>'; 
        }
	else 
		echo 'fail: update consolidated mbti<br>'; 
	// *A 
*/
	$result=$DB->confirmRequest($userId,$goalId);
	$feed_contributor_id = $DB->addGoalAction(9,$userId,0,"",5,$goalId,$goalId,0,0);
	$v_id = $DB->addVisibility($feed_contributor_id,2,$goalId);
	$v_id = $DB->addVisibility($feed_contributor_id,1,$userId);
	if($result==1){
		echo "success";
	}
	else{
		echo "fail";
	}
}
function removeContributor($userId,$projectId,$DB)
{
	$result=$DB->removeContributor($userId,$projectId);
	$feed_contributor_id = $DB->addProjectAction(18,$userId,0,"",6,$projectId,0,0);
	$v_id = $DB->addVisibility($feed_contributor_id,4,$projectId);
	$v_id = $DB->addVisibility($feed_contributor_id,1,$userId);
	if($result==1){
		echo "success";
	}
	else{
		echo "fail";
	}
}

function closeProject($project_id,$user_id,$DB){
	$isProjectContributor=$DB->isProjectContributor($project_id,$user_id);
	if($isProjectContributor){
	$succ=$DB->closeProject($project_id);
	$feedid = $DB->addProjectActionClose($project_id,$user_id,17);
	$visibility_id = $DB->addVisibility($feedid,4,$project_id);
	return 1;
	}
	else{
		return 0;
	}
}

function projectJoin($project_id,$user_id,$DB)
{
	$success=$DB->addProjectContributor($project_id,$user_id,1);
}
function createProject()
{
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Create Project</div>";
	include("createProject.php");
}
function postItem($data,$id,$DB,$param,$company_id,$userId)
{
	$perfs = explode("&", $data);
	$INP=array();
	foreach($perfs as $perf) {
		$perf_key_values = explode("=", $perf);
		$key = urldecode($perf_key_values[0]);
		$values = urldecode($perf_key_values[1]);
		$INP[$key]=$values;
	}
	postProject($INP,$id,$DB,$param,$company_id,$userId);
}
function editProject($projectId,$userId,$pDB)
{
	$succ = $pDB->getProjectProfile($projectId);
	while($row=mysql_fetch_row($succ))
	{
		$project_name = $row[0];
		$fname  = $row[1];
		$lname  = $row[2];
		$goal_objective = $row[3];
		$created_by = $fname." ".$lname;
		$due_date=$row[4];
		$progress_id=$row[5];
	}
	echo "<script>fillProjectForm('$project_name','$created_by','$goal_objective','$due_date','$progress_id');</script>";
	$EDITPROJECTID=$projectId;
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Edit Project</div>";
	include("createProject.php");
}
function postProject($INP,$id,$DB,$param,$company_id,$userId)
{
	$succ=1;
	if($INP["name"]=="")
	{
		$succ = 0;
		$err = "Project name missing";
	}
	if($succ==1)
	{
		if($param=="submit"){
			$succ = $DB->addProject($INP["name"],$id,$company_id,$INP["objective"],$INP['due_date'],$INP['progress']);
			$projectid=$succ;
			 $err = "Project successfully added";
			$success=$DB->addProjectContributors($projectid,$id);
		///	$path="../uploads/goalimg/goalimg-".$goalid.".jpg";
		///	copy($INP['image_src'],$path);
			$feedid = $DB->addProjectAction(15,$id,0,$INP["name"],6,$projectid,0,0);
			$visibility_id = $DB->addVisibility($feedid,4,$projectid);
		//	$more=0;
 
/*			// *A : CALL to update goal consolidated mbti 
		        $goal_mbti=array() ; $j=0;
 		        $goal_mbti=update_goal_consolidated_mbti($goalid, $id, 'new', $mbti, $users);
  		        if ($goal_mbti!=NULL)
		        {       $j=update_goal_mbti_tips($goal_mbti, $mbti,'new');
		                if ($j!=0)
		                {       $j=update_goal_mbti_checklist($goal_mbti, $mbti);
		                        if ($j==0)
		                                echo 'failed to update goal checklist<br>' ;
		                }        
		                else 
                		        echo 'failed to updated goal tips<br>';
		        }
		        else 
		                echo 'fail: update consolidated mbti<br>';
 		        // *A 
*/
		}
		else if($param="update"){
			$updateSucc = $DB->getProjectProfile($id);
			while($row=mysql_fetch_row($updateSucc))
			{
				$project_name = $row[0];
				$fname  = $row[1];
				$lname  = $row[2];
				$project_objective = $row[3];
				$created_by = $fname." ".$lname;
				$due_date=$row[4];
				$progress_id=$row[5];
			}
			$editFields="";
			$i=1;
			if($project_name!=$INP["name"]){
				$editFields=$editFields.$i.". Projectname from ".$project_name." to ".$INP['name']."<br>";
				$i++;
			}
			if($project_objective!=$INP["objective"]){
				$editFields=$editFields.$i.". project Objective <br>";
				$i++;
			}
			if($progress_id!=$INP["progress"]){
				$editFields=$editFields.$i." ProjectProgress<br>";
				$i++;
			}
			if($editFields!=""){
			$succes = $DB->updateProject($INP["name"],$id,$INP["objective"],$INP['due_date'],$INP['progress']);
			 $err = "Project successfully edited.";
			//$feedid = $DB->addProjectAction(15,$id,0,$INP["name"],6,$projectid,0,0);
			$feedId = $DB->addProjectAction(16,$userId,0,$editFields,6,$id,0,0);
			$v_id = $DB->addVisibility($feedId,4,$id);
			}
		}
		if(!$succ){ $err="connection interrupted.";}

	}


	$value= array('success' => $succ, 'err' => $err);
	$output = json_encode($value);

	echo $output;

}

function editedItem($data,$userId,$DB)
{
	$perfs = explode("&", $data);
	$INP=array();
	foreach($perfs as $perf) {
		$perf_key_values = explode("=", $perf);
		$key = urldecode($perf_key_values[0]);
		$values = urldecode($perf_key_values[1]);
		$INP[$key]=$values;
	}
	editedGoal($INP,$userId,$DB);
}
function editedGoal($INP,$userId,$DB)
{
	$succ = $DB->editGoal($userId);
	if(!$succ){ $err="connection interrupted.";}
	else { $err = "Goal successfully edited.";}

	$value= array('success' => $succ, 'err' => $err);
	while($row=mysql_fetch_row($succ))
	{
		$fname = $succ[0];
		$lname = $succ[1];
	}
	$output = json_encode($value);

	echo $output;
}
function addconn($userId,$DB)
{
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add Connections (<strong id='rC'>0</strong>)</div>";
	echo "<div class='rewards'>";
	$res = $DB ->ShowAllConnections($userId);
	$rcount=0;
	while($row=mysql_fetch_row($res))
	{
		$id = $row[0];
		$fname=$row[1];
		$lname=$row[2];
		$img_src=$row[3];
		if($img_src=="")
			$img_src="static/images/ambitions.png";	
		$name=$fname." ".$lname;
		?>
			<div class='reward-wrap'>
			<div class='reward' rewardid="<?php echo $id;?>">
			<div class='reward-img'>
			<img src="<?php echo $img_src;?>" width="190px" />
			</div>
			<div class="reward-title">
			<?php echo $name;?>
			</div>
			</div>
			</div>
			<?php
			//$rcount++;
	}
	/*if($rcount==20)
	  {
	  echo "<div class='reward-wrap '><div class='loadMore' param='reward' offset='20'><div class='reward-img loadMore-img'></div> <div class='reward-title'>Load More ..</div></div></div>";
	  }*/


	?>
		<div class="clr"></div>
		</div>
		<div id="eventFooter">
		<input type="button" value="Done" onClick="submitParam('<?php echo $id;?>', 'people');"/>
		<!--span class="ft">Note: You can do max <?php echo $left;?> selection.</span-->
		<div class="clr"></div>
		</div>
		<!--script type="text/javascript">
		var maxreward=<?php echo $left;?>;
	</script-->

		<?php
}
function SaveConn($userId,$DB,$ids)
{
	$succ = $DB->SaveConnections($userId,$ids);
	if($succ){
		$pids= explode(",", $ids);

		$retarr[]=array('status'=>1,'msg'=>$msg);
		foreach($pids as $pid)
		{

			$details = $DB ->GetConnections($pid);

			while($row=mysql_fetch_row($details))
			{

				$id=$row[0];
				$path=$row[3];
				/*$testpath="..".$path;
				  if(!file_exists($testpath))
				  {
				  $path="uploads/peoples/fp.gif";
				  }*/

				$fname=$row[1];
				$lname=$row[2];
				$name = $fname." ".$lname;


			}
			$retarr[]=array('id'=>$id,'path'=>$path,'title'=>$name);
		}




		print(json_encode($retarr));
		/*else
		  {
		  $msg="Unknown error occured.";
		  $val=array('status'=>0,'msg'=>$msg);
		  print(json_encode($val));

		  }*/
	}
}



function showPeoples($pDB, $goalid){
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Select Peoples (<strong id='pC'>0</strong>)</div>";
	echo "<div class='rewards'>";
	$res = $pDB -> newGoalPeoples($goalid,0,20);
	$left = $pDB -> leftGoalPeoples($goalid);
	$left=(2-$left);
	$pcount=0;
	while($row=mysql_fetch_row($res))
	{
		$id=$row[0];
		$path="/uploads/peoples/peopleimg-".$id."_avatar.jpg";
		$testpath="..".$path;
		if(!file_exists($testpath))
		{
			$path="uploads/peoples/fp.gif";
		}
		$name=$row[1];
		?>
			<div class='reward-wrap'>
			<div class='people' peopleid="<?php echo $id;?>">
			<div class='reward-img'>
			<img src="<?php echo $path;?>" height="140px" />
			</div>
			<div class="reward-title">
			<?php echo $name;?>
			</div>
			</div>
			</div>
			<?php
			$pcount++;
	}
	if($pcount==20)
	{
		echo "<div class='reward-wrap '><div class='loadMore' param='people' offset='20'><div class='reward-img loadMore-img'></div> <div class='reward-title'>Load More ..</div></div></div>";
	}


	?>
		<div class="clr"></div>
		</div>
		<div id="eventFooter">
		<input type="button" value="Done" onClick="submitParam(<?php echo $goalid;?>, 'people');"/>
		<span class="ft">Note: You can do max <?php echo $left;?> selection.</span>
		<div class="clr"></div>
		</div>
		<script type="text/javascript">
		var maxpeople=<?php echo $left;?>;
	</script>

		</div>

		<?php




}

function showRewards($gDB, $goalid)
{
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Select Rewards (<strong id='rC'>0</strong>)</div>";
	echo "<div class='rewards'>";
	$res = $gDB -> newGoalRewards($goalid,0,20);
	$left = $gDB -> leftGoalRewards($goalid);
	$left=(2-$left);

	$rcount=0;
	while($row=mysql_fetch_row($res))
	{
		$id=$row[0];
		$path="/uploads/giftimg/giftImg-".$id."_avatar.jpg";
		$title=$row[2];
		?>
			<div class='reward-wrap'>
			<div class='reward' rewardid="<?php echo $id;?>">
			<div class='reward-img'>
			<img src="<?php echo $path;?>" width="190px" />
			</div>
			<div class="reward-title">
			<?php echo $title;?>
			</div>
			</div>
			</div>
			<?php
			$rcount++;
	}
	if($rcount==20)
	{
		echo "<div class='reward-wrap '><div class='loadMore' param='reward' offset='20'><div class='reward-img loadMore-img'></div> <div class='reward-title'>Load More ..</div></div></div>";
	}


	?>
		<div class="clr"></div>
		</div>
		<div id="eventFooter">
		<input type="button" value="Done" onClick="submitParam(<?php echo $goalid;?>, 'reward');"/>
		<span class="ft">Note: You can do max <?php echo $left;?> selection.</span>
		<div class="clr"></div>
		</div>
		<script type="text/javascript">
		var maxreward=<?php echo $left;?>;
	</script>

		<?php

}




require_once("../DB/initDB.php");
include("../DB/goalsDB.php");
include("../DB/usersDB.php");
require_once("../DB/MBTIgoals.php");
include("../DB/projectsDB.php");
$mbti=new MBTIgoals();
$users=new usersDB();
$DB = new goalsDB();
$uDB=new usersDB();
$company_id = $uDB->getCompanyId($USERID);
$pDB=new projectsDB();
if(!$DB->status)
{
	exit;
}
$param=$_POST["param"];
$action=$_POST["action"];
switch($param){

	case "project":
		switch($action){
			case "new":
				createProject();
				break;

			case "edit":
				$project_id=$_POST["projectid"];
				editProject($project_id,$USERID,$pDB);
				break;


			case "submit":
				$values=$_POST["values"];
				$userId=$USERID;

				postItem($values,$userId,$pDB,"submit",$company_id,$userId);
				break;

			case "update":
				$values=$_POST["values"];
				$projectid=$_POST["projectid"];
				$userId=$USERID;
				postItem($values,$projectid,$pDB,"update",$company_id,$userId);
				break;
			case "join";
				$projectid=$_POST["projectid"];
		//		$isPendingContri=$DB->isPendingGoalContributor($goal_id,$USERID);
		//		if($isPendingContri==0){
					projectJoin($projectid,$USERID,$pDB);
		//		}
				break;
			case "close";
				$projectid=$_POST["projectid"];
				closeProject($projectid,$USERID,$pDB);
				break;
			case "connections":
				$userId=$USERID;
				addconn($userId,$DB);
				break;

			//echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Create Goal</div>";
			//echo "<div> Want to clost the Goal <input type='button' value='yes' onclick='close()' /><input type='button' value='cancel' /></div>";
			default:
				break;
		}
	case "user":
		switch($action)
		{
			case "confirmRequest":
				$userId=$_POST['userid'];
				$goalId=$_POST['goalid'];
				confirmRequest($userId,$goalId,$DB, $mbti, $users);
				break;
			case "removeContributor":
				$userId=$_POST['userid'];
				$projectId=$_POST['projectid'];
	
				removeContributor($userId,$projectId,$pDB);
				break;
			default:
				break;
		}
	case  "people":
		switch($action)
		{

			case "save":
				$ids=$_POST["ids"];
				SaveConn($USERID,$DB,$ids);
				break;
			default:
				break;

		}

	default:
	break;

}


?>
