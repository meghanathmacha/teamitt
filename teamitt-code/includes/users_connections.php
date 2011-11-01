<?php

include("ajaxid.php");
function addconn($userId,$DB)
{
        echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add Connections (<strong id='rC'>0</strong>)</div>";
        echo "<div class='rewards'>";
	$compId = $DB->getCompanyId($userId);
        $res = $DB ->ShowAllConnections($userId,$compId);
$rcount=0;
        while($row=mysql_fetch_row($res))
        {
        $id = $row[0];
        $fname=$row[1];
        $lname=$row[2];
        $img_src=$row[3];
	if($img_src=="")
	$img_src="static/images/teamitt-user.jpg";	
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
}
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


function addNewProjectContributor($projectId,$userId,$pDB,$uDB)
{
        echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add Contributor (<strong id='rC'>0</strong>)</div>";
        echo "<div class='rewards'>";
        $companyId = $uDB->getCompanyId($userId);

        $res = $pDB ->showProjectPotentialConnection($companyId,$projectId);
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
}
?>
<div class="clr"></div>
                </div>
         <div id="eventFooter">
<input type="button" value="Done" onClick="submitParam('<?php echo $id;?>', 'projectContributor');"/>
<!--span class="ft">Note: You can do max <?php echo $left;?> selection.</span-->
<div class="clr"></div>
</div>
<!--script type="text/javascript">
var maxreward=<?php echo $left;?>;
</script-->

<?php
}

function addNewGoalContributor($goalId,$userId,$gDB,$uDB)
{
        echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add Contributor (<strong id='rC'>0</strong>)</div>";
        echo "<div class='rewards'>";
	$companyId = $uDB->getCompanyId($userId);

        $res = $gDB ->showGoalPotentialConnection($companyId,$goalId);
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
}
?>
<div class="clr"></div>
                </div>
         <div id="eventFooter">
<input type="button" value="Done" onClick="submitParam('<?php echo $id;?>', 'goalContributor');"/>
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
			
				$retarr = array();
				$msg = "Connections added";
                                $retarr[]=array('status'=>1,'msg'=>$msg);
                                        foreach($pids as $pid)
                                        {

                                        $details = $DB ->GetConnections($pid);

                                while($row=mysql_fetch_row($details))
                                {

                                        $id=$row[0];
                                $path=$row[3];
                                $fname=$row[1];
                                $lname=$row[2];
                                $name = $fname." ".$lname;
                                }
                                $retarr[]=array('id'=>$id,'path'=>$path,'title'=>$name);
                                        }

                                print(json_encode($retarr));
}
}

function SaveOneConn($userId,$DB,$id)

{
                $succ = $DB->SaveOneConnection($userId,$id);
}
function RemoveOneConn($userId,$DB,$id)

{
                $succ = $DB->RemoveOneConnection($userId,$id);
}
function saveGoalContributor($goalId,$gDB,$ids,$DB)
{
                $succ = $gDB->addGoalContributors($goalId,$ids);
                if($succ){
                                        $pids= explode(",", $ids);

				$retarr = array();
				$msg ="Goal Contributors added";
                                $retarr[]=array('status'=>1,'msg'=>$msg);
                                        foreach($pids as $pid)
                                        {

                                        $details = $DB ->GetConnections($pid);

                                while($row=mysql_fetch_row($details))
                                {

                                        $id=$row[0];
                                $path=$row[3];
                                $fname=$row[1];
                                $lname=$row[2];
                                $name = $fname." ".$lname;
                                }
                                $retarr[]=array('id'=>$id,'path'=>$path,'title'=>$name);
                                        }

                                print(json_encode($retarr));
}
}
function saveProjectContributor($projectId,$pDB,$ids,$DB)
{
                $succ = $pDB->addProjectContributors($projectId,$ids);
                if($succ){
                                        $pids= explode(",", $ids);

				$retarr = array();
				$msg = "Project Contributors added";
                                $retarr[]=array('status'=>1,'msg'=>$msg);
                                        foreach($pids as $pid)
                                        {

                                        $details = $DB ->GetConnections($pid);

                                while($row=mysql_fetch_row($details))
                                {

                                        $id=$row[0];
                                $path=$row[3];
                                $fname=$row[1];
                                $lname=$row[2];
                                $name = $fname." ".$lname;
                                }
                                $retarr[]=array('id'=>$id,'path'=>$path,'title'=>$name);
                                        }

                                print(json_encode($retarr));
}
}

include("../DB/initDB.php");
include("../DB/usersDB.php");
include("../DB/goalsDB.php");
include("../DB/projectsDB.php");
$DB = new usersDB();
$gDB=new goalsDB();
$pDB=new projectsDB();
if(!$DB->status)
{
exit;
}
$param=$_POST["param"];
$action=$_POST["action"];

switch($param){
	case "goal":
		switch ($action){
			case "connections":
      	        	        addconn($USERID,$DB);
                        	break;
			case "addConnections":
				$goalId=$_POST['goalid'];
				addNewGoalContributor($goalId,$USERID,$gDB,$DB);
				break;
			default:
			break;
		}
		break;
	 case "project":
                switch ($action){
                        case "connections":
                                addconn($USERID,$DB);
                                break;
                        case "addProjectConnections":
                                $projectId=$_POST['projectid'];
                                addNewProjectContributor($projectId,$USERID,$pDB,$DB);
                                break;
                        default:
                        break;
                }
		break;


		case  "people":
                switch($action)
                {
			case "connections":
      	        	        addconn($USERID,$DB);
                        	break;

                        case "save":
                        $ids=$_POST["ids"];
                                SaveConn($USERID,$DB,$ids);
                                break;
			case "saveoneconn":
			$id=$_POST['profileid'];
				SaveOneConn($USERID,$DB,$id);
				break;

			case "removeoneconn":
			$id=$_POST['profileid'];
				RemoveOneConn($USERID,$DB,$id);
				break;

                        default:
                                break;

                }
		break;
		case  "goalContributor":
                switch($action)
                {

                        case "save":
                        $ids=$_POST["ids"];
			$goalId=$_POST['goalid'];
                                saveGoalContributor($goalId,$gDB,$ids,$DB);
                                break;
                        default:
                                break;

                }
		break;
		 case  "projectContributor":
                switch($action)
                {

                        case "save":
                        $ids=$_POST["ids"];
                        $projectId=$_POST['projectid'];
                                saveProjectContributor($projectId,$pDB,$ids,$DB);
                                break;
                        default:
                                break;

                }
		break;



default:
break;

}

?>
