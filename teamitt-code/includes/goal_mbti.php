<?php 

include("ajaxid.php");
include("feed_helper.php");

require_once ("../DB/initDB.php") ; 
include ("../DB/MBTIgoals.php") ; 

$profile=0;
$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
if(strlen($url["query"])>0)
{
	$query = explode("=", $url["query"]);
	
} 

//print_r($query) ;

$gmtype=$_GET["gmtype"];
$goalID=$query[1]; 
$mbti=new MBTIgoals(); 	

// echo $gmtype . '<br>' ; 
// echo $goalID . '<br>';


if ($gmtype=='tips') 
{ 
	$tips=$mbti->fetch_goal_tips($goalID);
	$a=sizeof($tips);
        for ($i=0;$i<$a;$i++)
        { 	echo '<div class="goal_mbti_tip" id='.$tips[$i]['goaltipsID'].' title="tip">';
                echo ($i+1).') '.$tips[$i]['tips'];
		echo '<div class="goal_tip_base">'; 
		$liked_result=0; // get the number of previous likes here 
		
		$ref = getenv('HTTP_REFERER');
		$url = (parse_url($ref));
		$path = $url['path'];
		$query = $url['query'];
		$goalid = explode("=",$query);
		$goalID = $goalid[1];
		$liked_result=$mbti->ifuserliked($USERID,$tips[$i]['goaltipsID'],$goalID, 'tip');
		
		if ($liked_result==1) 
		{	echo '<span class="mbti_unlike">Liked</span>'; 
			echo '<span class="mbti_comment">Comment</span>';  	
		}	
		else 
		{	echo '<span class="mbti_like">Like</span>'; 
			echo '<span class="mbti_comment">Comment</span>'; 
		}  
		echo '</div>';
 
		// function call to all the likes for this particular tip at this line 
		include_once("goal_mbti_functions.php");	
		echo getLikers($tips[$i]['goaltipsID'], $goalID, $mbti, $USERID, 'tip');		
		
		echo '<div class="editor comments">'; 
		echo getComments($tips[$i]['goaltipsID'],$goalID, $mbti ,$USERID, 'tip');		//function call to get all the comments given for this tip 
		echo '</div>' ;
		echo '<div class="editor">'; 
		echo '</div>'; 
		echo '</div>';  
 		
	} 
} 
if ($gmtype=='checklist') 
{ 
	$checklist=$mbti->fetch_goal_checklist($goalID);
        $a=sizeof($checklist);
	//echo '<div id="test">'.print_r($checklist).' </div>';
        for ($i=0;$i<$a;$i++)
        {	echo '<div class="goal_mbti_checklist" id='.$checklist[$i]['goalchecklistID'].' title="checklist">';
		echo ($i+1). ') ' . $checklist[$i]['checklist'];
		echo '<div class="goal_checklist_base">';
		$liked_result=0; // get the number of previous likes here
		
		$ref = getenv('HTTP_REFERER');
                $url = (parse_url($ref));
                $path = $url['path'];
                $query = $url['query'];
                $goalid = explode("=",$query);
                $goalID = $goalid[1];
                $liked_result=$mbti->ifuserliked($USERID,$checklist[$i]['goalchecklistID'],$goalID, 'checklist');

		if ($liked_result==1)
                {       echo '<span class="mbti_unlike">Liked</span>';
                        echo '<span class="mbti_comment">Comment</span>';
                }
                else
                {       echo '<span class="mbti_like">Like</span>';
                        echo '<span class="mbti_comment">Comment</span>';
                }
                echo '</div>';

                // function call to all the likes for this particular tip at this line 
		include_once("goal_mbti_functions.php");
                echo getLikers($checklist[$i]['goalchecklistID'], $goalID, $mbti, $USERID, 'checklist');
                echo '<div class="editor comments">';
                        //function call to get all the comments given for this tip 
		echo getComments($checklist[$i]['goalchecklistID'],$goalID, $mbti ,$USERID, 'checklist');
                echo '</div>' ;
                echo '<div class="editor">';
                echo '</div>';
                echo '</div>';

	}	
}
/*
// This function updates the consolidated MBTI score of a gaol/project whenever a new user is added to a goal OR the goal has just been created and the owner is to be added to the consolidated MBTI table. 
// INPUT: the goalID of the goal, the userID of the user added to the goal. 
// OUTPUT: the function updates the existing record of a goal in the consolidated MBTI table. 
// By: Abhijeet

function update_goal_consolidated_mbti($goalID, $userID, $op, $mbti, $users) 
{ 	$new_goal=0; 
	$user_mbti=$users->getMBTI($userID); 
	if ($user_mbti==NULL) 
	 	return 0; 
	
	if ($op=='new') 
		$goal_mbti=array('goalID'=>$goalID,'E'=>0,'I'=>0,'S'=>0,'N'=>0,'F'=>0,'T'=>0,'J'=>0,'P'=>0 );
	else
	{ 	
		$goal_mbti=$mbti->get_consolidated_MBTI($goalID); 
		if ($goal_mbti==NULL) 
			return 0; 
 	} 
			
	if ($op!='remove')
	{ 
		// add the new consolidated score from the user added 
		if (stristr($user_mbti,"E")!=FALSE)
			$goal_mbti['E']=$goal_mbti['E']+1; 	
		if (stristr($user_mbti,"I")!=FALSE)
	       	        $goal_mbti['I']=$goal_mbti['I']+1;
		if (stristr($user_mbti,"S")!=FALSE)
			$goal_mbti['S']=$goal_mbti['S']+1;
		if (stristr($user_mbti,"N")!=FALSE)
        	        $goal_mbti['N']=$goal_mbti['N']+1;
		if (stristr($user_mbti,"F")!=FALSE)
        	        $goal_mbti['F']=$goal_mbti['F']+1;
		if (stristr($user_mbti,"T")!=FALSE)
        	        $goal_mbti['T']=$goal_mbti['T']+1;
		if (stristr($user_mbti,"J")!=FALSE)
        	        $goal_mbti['J']=$goal_mbti['J']+1;
		if (stristr($user_mbti,"P")!=FALSE)
        	        $goal_mbti['P']=$goal_mbti['P']+1;
	} 
	if ($op=='remove') 
	{ 	
		// subtract the new consolidated score from the user removed from the group 
                if (stristr($user_mbti,"E")!=FALSE)
                        $goal_mbti['E']=$goal_mbti['E']-1;
                if (stristr($user_mbti,"I")!=FALSE)
                        $goal_mbti['I']=$goal_mbti['I']-1;
                if (stristr($user_mbti,"S")!=FALSE)
                        $goal_mbti['S']=$goal_mbti['S']-1;
                if (stristr($user_mbti,"N")!=FALSE)
                        $goal_mbti['N']=$goal_mbti['N']-1;
                if (stristr($user_mbti,"F")!=FALSE)
                        $goal_mbti['F']=$goal_mbti['F']-1;
                if (stristr($user_mbti,"T")!=FALSE)
                        $goal_mbti['T']=$goal_mbti['T']-1;
                if (stristr($user_mbti,"J")!=FALSE)
                        $goal_mbti['J']=$goal_mbti['J']-1;
                if (stristr($user_mbti,"P")!=FALSE)
                        $goal_mbti['P']=$goal_mbti['P']-1;
	}
	if ($op=='new') 
		$result=$mbti->insert_consolidated_goal_mbti($goal_mbti); 
	else 
		$result=$mbti->update_consolidated_goal_mbti($goal_mbti); 

	if ($result==NULL) 
		return 0; 
	
	return $goal_mbti; 		
}

function update_goal_mbti_tips($goal_mbti,$mbti,$op)
{	
	$newtipstoadd=array(); $goal_tips=array(); $goal_mbti_tips=array(); 
	
	// get all mbti tips from goal_mbti_tips for the goal_mbti array 
	$goal_mbti_tips=$mbti->get_goal_mbti_tips($goal_mbti); 		
	if ($goal_mbti_tips==NULL) 
		return 0; 

//print_r($goal_mbti_tips); 
//echo '<br>check above';	
	// get all tips assigned from goal_tips for the goalID 
	if ($op=='add') 
	{	$goal_tips=$mbti->get_goal_tips($goal_mbti['goalID']); 
                $a=sizeof($goal_mbti_tips); $b=sizeof($goal_tips);
		if ($a>$b)
                {       for ($i=0;$i<$a;$i++)
                        {       $check=1; 
                                for ($j=0;$j<$b;$j++)
                                {	
                                        if ($goal_mbti_tips[$i]['tipsID']!=$goal_tips[$j]['tipsID'])    
                                        {     
						$check=0; 
					}
					else 
					{	$check=1; 
						break; 
					}
                                }       
				if ($check==0) 
					$newtipstoadd[]=array('tipsID'=>$goal_mbti_tips[$i]['tipsID']);				
                        }
                }
        }               
	
	if ($op=='new')
                $newtipstoadd=$goal_mbti_tips;

	$c=sizeof($newtipstoadd); $goalID=$goal_mbti['goalID']; 
	for ($i=0;$i<$c; $i++) 
	{ 	
		$mbti->add_new_tips($goalID,$newtipstoadd[$i]['tipsID']);
	} 

	return 1;  
}

function update_goal_mbti_checklist($goal_mbti, $mbti) 
{
        // get mbti checklist from goal_mbti_checklist for the goal_mbti array 
        $goal_mbti_checklist=$mbti->get_goal_mbti_checklist($goal_mbti);
        if ($goal_mbti_checklist==NULL)
                return 0;

        // get checklist assigned from goal_checklist for the goalID 
        $goal_checklist=$mbti->get_goal_checklist($goal_mbti['goalID']);

        $flag=0; $newcheckstoadd=array();  
	if ($goal_checklist==NULL)
		$flag=1; 

	if ($flag==1) 
		$newcheckstoadd=$goal_mbti_checklist; 
	else
        {       $a=sizeof($goal_mbti_checklist); $b=sizeof($goal_checklist);
                if ($a>$b)
                {       for ($i=0;$i<$a;$i++)
                        {       $check=1;
                                for ($j=0;$j<$b;$j++)
                                {
                                        if ($goal_mbti_checklist[$i]['checklistID']!=$goal_checklist[$j]['checklistID'])
                                        {
                                                $check=0;
                                        }
                                        else
                                        {       $check=1;
                                                break;
                                        }
                                }
                                if ($check==0)
                                        $newcheckstoadd[]=array('checklistID'=>$goal_mbti_checklist[$i]['checklistID']);
                        }
                }
        }
        $c=sizeof($newcheckstoadd); $goalID=$goal_mbti['goalID'];
        for ($i=0;$i<$c; $i++)
        {
                $mbti->add_new_checklist_item($goalID,$newcheckstoadd[$i]['checklistID']);
        }
        return 1;
}

function show_goal_tips($goalID, $mbti) 
{ 	if ($goalID==0) 
		return; 
	$goal_tips=$mbti->fetch_goal_tips($goalID); 
	// display the tips fetched 
	if ($goal_tips!=NULL) 
	{	 
		$size=sizeof($goal_tips); 
		for ($i=0;$i<$size;$i++) 
			print "<br><a href=''>".$goal_tips[$i]['tips']."</a>\n"; 
	}
	return; 

}// END OF FUNCTION 

function show_goal_checklist($goalID, $mbti)
{	if ($goalID==0) 
		return; 
	$goal_checklist=$mbti->fetch_goal_checklist($goalID); 
	if ($goal_checklist!=NULL)
        {
                $size=sizeof($goal_checklist);
                for ($i=0;$i<$size;$i++)
                        print "<br><a href=''>".$goal_checklist[$i]['checklist']."</a>\n";
        }

	return; 
} // END OF FUNCTION 
*/
?>


