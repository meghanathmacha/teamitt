<?php


$param=$_POST["param"];
$offset=$_POST["offset"];

session_start();

$userid=$_SESSION["fbid"];

/* $userid=$_POST["userid"];
$userid=mysql_escape_string($userid); */

			require_once("../DB/initDB.php");
			require_once("../DB/goalsDB.php");
			$DB = new goalsDB();
			if(!$DB->status)
			{
				die("Connection Error");
				exit;
			}

switch($param){

	case "reward":
			require_once("../DB/giftsDB.php");
			$gDB = new giftsDB();
			$ret=$gDB->showGifts($offset, $offset+20);
				$retarr=array();
				if(!is_int($ret)){
				$retarr[]=array('more'=>1,'numrow'=>mysql_affected_rows());
				while($row=mysql_fetch_row($ret))
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
				$retarr[]=array('more'=>0,'numrow'=>0);
				print(json_encode($retarr));
				}
				break;

	case "people":
					require_once("../DB/peoplesDB.php");
					$pDB= new peoplesDB();
					$ret=$pDB->getPeoples($offset, $offset+20);
					$retarr=array();
				if(!is_int($ret)){
				$retarr[]=array('more'=>1,'numrow'=>mysql_affected_rows());
				while($row=mysql_fetch_row($ret))
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
				$retarr[]=array('more'=>0,'numrow'=>0);
				print(json_encode($retarr));
				}
				break;
	default:
		break;

}


?>
