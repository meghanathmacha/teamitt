<?php
include ("../checkid.php");
function createGoal()
{
echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Create Goal</div>";
include("createGoal.php");
}
function postItem($data,$userId,$DB)
{
$perfs = explode("&", $data);
$INP=array();
foreach($perfs as $perf) {
    $perf_key_values = explode("=", $perf);
    $key = urldecode($perf_key_values[0]);
    $values = urldecode($perf_key_values[1]);
$INP[$key]=$values;
}
postGoal($INP,$userId,$DB);
}
function editGoal($userId,$DB)
{
$succ = $DB->GetGoalProfile($userId);
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
//echo "<script>alert('$due_date');</script>";
echo "<script>fillForm('$goal_name','$created_by','$goal_objective','$goal_key_results','$due_date','$progress_id','$visibility_id','$image_src');</script>";
/*while($e=mysql_fetch_assoc($succ))
        $output[]=$e;
//echo (json_encode($output));*/


echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Edit Goal</div>";
include("createGoal.php");
}


function postGoal($INP,$userId,$DB)
{
/*if($userid=="" || !($fbDB->checkClient($userid)))
{
$succ = 0;
$err = "invalid userid";
}*/
$contributors=explode(",",$INP['contributors']);
$contributors_num=count($contributors);
$succ=1;
 if($contributors_num > 0 && $INP['contributors']!=""){
//if($INP['contributors']=="")
//break;
for($i=0;$i<$contributors_num-1;$i++)
{
$check=$DB->userCheck($contributors[$i]);
if($check==0)
{
$succ=0;
$err="Wrong Email Id";
break;
}
}
}
 if($INP["name"]=="")
{
$succ = 0;
$err = "Goal Name missing";
}
/*else if($INP["exp"]=="")
{
$succ = 0;
$err = "past experience missing";
}

else if($INP["description"]=="")
{
$succ = 0;
$err = "job description missing";
}*/
if($succ==1)
{
$image_src="image";
$visibility_id=1;
$duedate="";
$progress_id=1;
$succ = $DB->addGoal($INP["name"],$userId,$INP['image_src'],$INP['visibility'],$INP["objective"],$INP['due_date'],$INP["key_result"],$INP['progress']);
$goalid=$succ;
//$succ = $DB->addGoal("name",28,"image_src",1,"objective",'',"key_result",2);
$feedid = $DB->addGoalAction($INP["name"],$userId,$goalid,$INP['visibility']);
$visibility_id = $DB->addVisibility($feedid,$goalid);
for($i=0;$i<$contributors_num-1;$i++)
{
$success=$DB->addGoalContributor($goalid,$contributors[$i]);
}
if(!$succ){ $err="connection interrupted.";}
else { $err = "Goal successfully added.";}

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

/*if($userid=="" || !($fbDB->checkClient($userid)))
{
$succ = 0;
$err = "invalid userid";
}*/
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
	//echo "nitin";
	echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add Connections (<strong id='rC'>0</strong>)</div>";
	echo "<div class='rewards'>";
      	$res = $DB ->ShowAllConnections($userId);
  //    	$res = $gDB -> newGoalRewards($goalid,0,20);
    //  $left = $gDB -> leftGoalRewards($goalid);
      //  $left=(2-$left);


$rcount=0;
        while($row=mysql_fetch_row($res))
        {
      //  $id=$row[0];
        //$path="/uploads/giftimg/giftImg-".$id."_avatar.jpg";
        //$title=$row[2];
	$id = $row[0];
	$fname=$row[1];
	$lname=$row[2];
	$img_src=$row[3];
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





include("../DB/initDB.php");
include("../DB/goalsDB.php");
$DB = new goalsDB();
if(!$DB->status)
{
exit;
}



//$goalid=$_POST["goalid"];
$param=$_POST["param"];
$action=$_POST["action"];

//session_start();

//$userid=$_SESSION["fbid"];

/* $userid=$_POST["userid"];
$userid=mysql_escape_string($userid); */

/*			require_once("../DB/initDB.php");
			require_once("../DB/goalsDB.php");
			$DB = new goalsDB();
			if(!$DB->status)
			{
				die("Connection Error");
				exit;
			}*/

/* check validity of userid and owner of goal */
/* if(!$DB->goalOwner($goalid, $userid))
{
$val=array('status'=>0,'msg'=>'Invalid user exception.');
print(json_encode($val));
die();
}*/


switch($param){

	case "goal":
		switch($action){
		case "new":
			createGoal();
			break;

		 case "edit":
                        editGoal($USERID,$DB);
                        break;


		case "submit":
			$values=$_POST["values"];
			$userId=$USERID;

			postItem($values,$userId,$DB);
			break;

		 case "save_edit":
                        $values=$_POST["values"];
                        $userId=$USERID;
                        editedItem($values,$userId,$DB);
                        break;
		case "connections":
                        $userId=$USERID;
			addconn($userId,$DB);
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
/*	case "reward":
		switch($action){
			case "remove":
				$id=$_POST["id"];
			if(!$DB->goalRewardExists($goalid, $id))
			{
				$val=array('status'=>0,'msg'=>'Reward is invalid');
				print(json_encode($val));
				die();
			}
			else if($DB->removeGoalReward($goalid, $id))
			{
				$DB->removeGoalPoints($goalid, "reward", $userid, $id);
				$msg="Reward removed.";
				$val=array('status'=>1,'msg'=>$msg);
				print(json_encode($val));
			}
			else
			{
				$val=array('status'=>2,'msg'=>'Unknown Error Occured');
				print(json_encode($val));
			}
			break;
			case "new":
			showRewards($DB, $goalid);
				break;
			case "save":
			$ids=$_POST["ids"];
			$ret=$DB->AddGoalReward($goalid, $ids);
				if($ret){
					$rids= explode(",", $ids);
					foreach($rids as $rid)
					{
						$DB->addGoalPoints($goalid, "reward",$userid,50,$rid,0);
					}

					

					require_once("../DB/giftsDB.php");
					$gDB= new giftsDB();
					$details=$gDB->getGiftsDetail($ids);
				$retarr=array();
					$msg="Reward Added. You have added ".(count($rids)*50)." more points to this goal.";
				$retarr[]=array('status'=>1,'msg'=>$msg);
				while($row=mysql_fetch_row($details))
				{
								
        				$id=$row[0];
        			$path="uploads/giftimg/giftImg-".$id."_avatar.jpg";
			        $title=$row[2];
				$retarr[]=array('id'=>$id,'path'=>$path,'title'=>$title);
		
				}
				print(json_encode($retarr));
				}
				else
				{
				$msg="Unknown error occured.";
				$val=array('status'=>0,'msg'=>$msg);
				print(json_encode($val));
				}
				break;
			default:
			break;
		}	
			break;

	case "people":
		switch($action){
			case "remove":
				$id=$_POST["id"];
			if(!$DB->goalPeopleExists($goalid, $id))
			{
				$val=array('status'=>0,'msg'=>'Inputs are invalid');
				print(json_encode($val));
				die();
			}
			else if($DB->removeGoalPeople($goalid, $id))
			{
				$DB->removeGoalPoints($goalid, "people", $userid, $id);
				$msg="Person removed.";
				$val=array('status'=>1,'msg'=>$msg);
				print(json_encode($val));
			}
			else
			{
				$val=array('status'=>2,'msg'=>'Unknown Error Occured');
				print(json_encode($val));
			}
			break;

			case "new":
			showPeoples($DB, $goalid);
				break;
			case "save":
			$ids=$_POST["ids"];
			$ret=$DB->AddGoalPeople($goalid, $ids);
				if($ret){
					$pids= explode(",", $ids);
					foreach($pids as $pid)
					{
						$DB->addGoalPoints($goalid, "people",$userid,50,$pid,0);
					}

					require_once("../DB/peoplesDB.php");
					$gDB= new peoplesDB();
					$details=$gDB->getPeoplesDetail($ids);
					$retarr=array();
					$msg="Person Added. You have added ".(count($pids)*50)." more points to this goal.";
				$retarr[]=array('status'=>1,'msg'=>$msg);
				while($row=mysql_fetch_row($details))
				{
								
        				$id=$row[0];
        			$path="/uploads/peoples/peopleimg-".$id."_avatar.jpg";
				$testpath="..".$path;
				if(!file_exists($testpath))
				{
					$path="uploads/peoples/fp.gif";
				}

			        $title=$row[1];
				$retarr[]=array('id'=>$id,'path'=>$path,'title'=>$title);
		
				}
				print(json_encode($retarr));
				}
				else
				{
				$msg="Unknown error occured.";
				$val=array('status'=>0,'msg'=>$msg);
				print(json_encode($val));
				}
				break;
			default:
			break;

		}*/
	default:
		break;

}


?>
