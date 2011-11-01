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
function removeContributor($userId,$goalId,$DB,$removeBy)
{
	$result=$DB->removeContributor($userId,$goalId);
	$feed_contributor_id = $DB->addGoalAction(13,$removeBy,$userId,"",5,$goalId,$goalId,0,0);
	$v_id = $DB->addVisibility($feed_contributor_id,2,$goalId);
	$v_id = $DB->addVisibility($feed_contributor_id,1,$userId);
	if($result==1){
		echo "success";
	}
	else{
		echo "fail";
	}
}
function removeConnection($userId,$DB,$remove_by)
{
        $result=$DB->RemoveOneConnection($remove_by,$userId);
        if($result==1){
                echo "success";
        }
        else{
                echo "fail";
        }
}

function closeGoal($goal_id,$user_id,$DB){
	$isGoalContributor=$DB->isGoalContributor($goal_id,$user_id);
	if($isGoalContributor){
	$succ=$DB->closeGoal($goal_id);
	$feedid = $DB->addGoalActionClose($goal_id,$user_id,5);
	$visibility_id = $DB->addVisibility($feedid,2,$goal_id);
	$contributor=$DB->getGoalContributor($goal_id,1);
	while($row=mysql_fetch_row($contributor)){
		$DB->addVisibility($feedid,1,$row[0]);
	}

	return 1;
	}
	else{
		return 0;
	}
}

function goalJoin($goal_id,$user_id,$DB)
{
	$success=$DB->addGoalContributor($goal_id,$user_id,1);
	// $result=$DB->confirmRequest($userId,$goalId);
        $feed_contributor_id = $DB->addGoalAction(9,$user_id,0,"",5,$goal_id,$goal_id,0,0);
        $v_id = $DB->addVisibility($feed_contributor_id,2,$goal_id);
        $v_id = $DB->addVisibility($feed_contributor_id,1,$user_id);

}
function createGoal()
{
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Create Goal</div>";
	include("createGoal.php");
}
function postItem($data,$id,$DB,$param,$company_id,$userId, $mbti, $users)
{
	$perfs = explode("&", $data);
	$INP=array();
	foreach($perfs as $perf) {
		$perf_key_values = explode("=", $perf);
		$key = urldecode($perf_key_values[0]);
		$values = urldecode($perf_key_values[1]);
		$INP[$key]=$values;
	}
	postGoal($INP,$id,$DB,$param,$company_id,$userId, $mbti, $users);
}
function editGoal($goalId,$userId,$DB)
{
	$succ = $DB->GetGoalProfile($goalId);
	while($row=mysql_fetch_row($succ))
	{
		$goal_name = $row[0];
		$fname  = $row[1];
		$lname  = $row[2];
		$goal_objective = $row[3];
		$goal_key_results = $row[4];
		$created_by = $fname." ".$lname;
		$due_date=$row[5];
		$progress_id=$row[6];
		$visibility_id=$row[7];
		$image_src=$row[8];
	}
	$contributors="";
	$succ=$DB->getGoalContributor($goalId,1);
	while($row=mysql_fetch_row($succ))
	{
		$contributors=$contributors.$row[1].",";
	}
	echo "<script>fillForm('$goal_name','$created_by','$goal_objective','$goal_key_results','$due_date','$progress_id','$visibility_id','$image_src','$contributors');</script>";
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Edit Goal</div>";
	$EDITGOALID=$userId;
	include("createGoal.php");
}
function postGoal($INP,$id,$DB,$param,$company_id,$userId, $mbti, $users)
{
	$succ=1;
	if($INP["name"]=="")
	{
		$succ = 0;
		$err = "Goal Name missing";
	}
	if($succ==1)
	{
		if($param=="submit"){
			$INP['image_src']="static/images/ambitions.png";
			$succ = $DB->addGoal($INP["name"],$id,$company_id,$INP['image_src'],$INP['visibility'],$INP["objective"],$INP['due_date'],$INP["key_result"],$INP['progress']);
			$goalid=$succ;
			$success=$DB->addGoalContributor($goalid,$id,1);
			//$path="../uploads/goalimg/goalimg-".$goalid.".jpg";
			//copy($INP['image_src'],$path);
			$feedid = $DB->addGoalAction(4,$id,0,$INP["name"],2,0,$goalid,$INP['visibility'],0);
			$visibility_id = $DB->addVisibility($feedid,2,$goalid);
			$visibility_id = $DB->addVisibility($feedid,3,$company_id);
			$more=0;
			 $err = "Goal successfully added.";
 
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
			$updateSucc = $DB->GetGoalProfile($id);
			while($row=mysql_fetch_row($updateSucc))
			{
				$goal_name = $row[0];
				$fname  = $row[1];
				$lname  = $row[2];
				$goal_objective = $row[3];
				$goal_key_results = $row[4];
				$created_by = $fname." ".$lname;
				$due_date=$row[5];
				$progress_id=$row[6];
				$visibility_id=$row[7];
				$image_src=$row[8];
			}
			$editFields="";
			$i=1;
			if($goal_name!=$INP["name"]){
				$editFields=$editFields.$i.". Goal Name from <b>".$goal_name."</b> to <b>".$INP['name']."</b><br>";
				$i++;
			}
			if($goal_objective!=$INP["objective"]){
				$editFields=$editFields.$i.".<b> Goal Objective </b><br>";
				$i++;
			}
			if($goal_key_results!=$INP["key_result"]){
				$editFields=$editFields.$i.".<b> key Result</b><br>";
				$i++;
			}
			if($progress_id!=$INP["progress"]){
				$editFields=$editFields.$i.".<b>Goal Progress</b><br>";
				$i++;
			}
			if($image_src!=$INP["image_src"]){
				$editFields=$editFields.$i.".<b>Goal Image</b><br>";
				$i++;
			}
			if($due_date!=$INP["due_date"]){
				$editFields=$editFields.$i.".<b>Due Date</b><br>";
				$i++;
			}
			if($editFields!=""){
			$succes = $DB->updateGoal($INP["name"],$id,$INP['image_src'],$INP['visibility'],$INP["objective"],$INP['due_date'],$INP["key_result"],$INP['progress']);
			$feedId = $DB->addGoalAction(14,$userId,0,$editFields,5,$id,$id,0,0);
			$v_id = $DB->addVisibility($feedId,2,$id);
			//$v_id = $DB->addVisibility($feedId,3,$company_id);
			$contributor=$DB->getGoalContributor($id,1);
			while($row=mysql_fetch_row($contributor)){
				$DB->addVisibility($feedId,1,$row[0]);
			}	
			}
			 $err = "Goal successfully edited.";
		}
		if(!$succ){ $err="connection interrupted.";}
		else { $err = $err;}

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
$mbti=new MBTIgoals();
$users=new usersDB();
$DB = new goalsDB();
$uDB=new usersDB();
$company_id = $uDB->getCompanyId($USERID);

if(!$DB->status)
{
	exit;
}
$param=$_POST["param"];
$action=$_POST["action"];

switch($param){

	case "goal":
		switch($action){
			case "new":
				createGoal();
				break;

			case "edit":
				$goal_id=$_POST["goalid"];
				editGoal($goal_id,$USERID,$DB);
				break;


			case "submit":
				$values=$_POST["values"];
				$userId=$USERID;

				postItem($values,$userId,$DB,"submit",$company_id,$userId, $mbti, $users);
				break;

			case "update":
				$values=$_POST["values"];
				$goalid=$_POST["goalid"];
				$userId=$USERID;
				postItem($values,$goalid,$DB,"update",$company_id,$userId, $mbti, $users);
				break;
			case "join";
				$goalid=$_POST["goalid"];
				$isPendingContri=$DB->isPendingGoalContributor($goal_id,$USERID);
				if($isPendingContri==0){
					goalJoin($goalid,$USERID,$DB);
				}
				break;
			case "close";
				$goalid=$_POST["goalid"];
				closeGoal($goalid,$USERID,$DB);
				break;
			case "connections":
				$userId=$USERID;
				//addconn($userId,$DB);
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
				$goalId=$_POST['goalid'];
				$removeBy=$USERID;	
				removeContributor($userId,$goalId,$DB,$removeBy);
				break;
			case "removeConnection":
				$userId=$_POST['userid'];
				$removeBy=$USERID;	
				removeConnection($userId,$uDB,$removeBy);
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
