<?php 

function get_consolidated_MBTI($goalID, $userID, $mbti, $users, $gDB)
{	$log=array(); $list=NULL; 

	$list=$gDB->getGoalContributor($goalID, 1); 
	$log[]='Got Goal contributors'; 

	$u=array(); 
	while ($row=mysql_fetch_row($list)) 
		$u[]=$row[0]; 
	
	$a=sizeof($u); 
	$user_mbti=array(); 
	for ($i=0; $i<$a; $i++) 
	{ 	
		$mbti_val=$users->getMBTI($u[$i]); 
		if (($mbti_val!=NULL)&&($mbti_val!='')) 
			$user_mbti[]=$mbti_val; 
	}
//	$log=[]='Updated user_mbti array with mbti values'; 
	
	$goal_mbti=array('goalID'=>$goalID,'E'=>0,'I'=>0,'S'=>0,'N'=>0,'F'=>0,'T'=>0,'J'=>0,'P'=>0 );
	$a=sizeof($user_mbti); 
	for ($i=0; $i<$a; $i++) 
	{	
		if (stristr($user_mbti[$i],"E")!=FALSE)
                        $goal_mbti['E']=$goal_mbti['E']+1;
                if (stristr($user_mbti[$i],"I")!=FALSE)
                        $goal_mbti['I']=$goal_mbti['I']+1;
                if (stristr($user_mbti[$i],"S")!=FALSE)
                        $goal_mbti['S']=$goal_mbti['S']+1;
                if (stristr($user_mbti[$i],"N")!=FALSE)
                        $goal_mbti['N']=$goal_mbti['N']+1;
                if (stristr($user_mbti[$i],"F")!=FALSE)
                        $goal_mbti['F']=$goal_mbti['F']+1;
                if (stristr($user_mbti[$i],"T")!=FALSE)
                        $goal_mbti['T']=$goal_mbti['T']+1;
                if (stristr($user_mbti[$i],"J")!=FALSE)
                        $goal_mbti['J']=$goal_mbti['J']+1;
                if (stristr($user_mbti[$i],"P")!=FALSE)
                        $goal_mbti['P']=$goal_mbti['P']+1; 

	}
//	$log[]='goal_mbti array initialized with all mbti values from the goal contributors'; 

	$res=update_goal_mbti_tips($goal_mbti,$mbti); 
	if ($res==1) 
	{	$res=update_goal_mbti_checklist($goal_mbti, $mbti); 
//		if ($res!=1) 
//			$log[]='Failed to updated checklist'; 
	}
//	else 
//		$log[]='Failed to update tips'; 	
	
	return $goal_mbti; 	
//	return $u;  
	

} 

function update_goal_mbti_tips($goal_mbti,$mbti)
{	$log=array(); 
        $newtipstoadd=array(); $goal_tips=array(); $goal_mbti_tips=array();

        // get all mbti tips from goal_mbti_tips for the goal_mbti array 
        $goal_mbti_tips=$mbti->get_goal_mbti_tips($goal_mbti);
        if ($goal_mbti_tips==NULL)
        {	//$log[]='No goal_mbti_tips'; 
	        return 0;
	} 
//	else 
//		$log[]='initialized goal_mbti_tips array'; 
	
	$goal_tips=$mbti->get_goal_tips($goal_mbti['goalID']);
	$flag=0; 
	if ($goal_tips==NULL) 
	{	$flag=1; 
		//$log[]='No tips in the goal_tips table'; 
	}	
//        else 
//		$log[]='Fetched tips from the goal_tips table'; 

	// get all tips assigned from goal_tips for the goalID 
	if ($flag==1)
                $newtipstoadd=$goal_mbti_tips;
        else
        {       // $goal_tips=$mbti->get_goal_tips($goal_mbti['goalID']);
                $a=sizeof($goal_mbti_tips); $b=sizeof($goal_tips);
               // if ($a>$b)
               // {       
			for ($i=0;$i<$a;$i++)
                        {       $check=1;
                                for ($j=0;$j<$b;$j++)
                                {
                                        if ($goal_mbti_tips[$i]['tipsID']!=$goal_tips[$j]['tipsID'])
                                        {
                                                $check=0;
                                        }
                                        else
                                        {       $check=1;
                                                break;
                                        }
                                }
                                if ($check==0)
                                        $newtipstoadd[]=array('tipsID'=>$goal_mbti_tips[$i]['tipsID']);
                        }
             //   }
	//	else 
	//		$log[]='Goal_tips > goal_mbti_tips'; 
        }

        $c=sizeof($newtipstoadd); $goalID=$goal_mbti['goalID'];
        for ($i=0;$i<$c; $i++)
        {
                $mbti->add_new_tips($goalID,$newtipstoadd[$i]['tipsID']);
        }
//	$log[]='Added all the new tips found to the goal_tips table'; 
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
//                if ($a>$b)
  //              {       
			for ($i=0;$i<$a;$i++)
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
//                }
        }
        $c=sizeof($newcheckstoadd); $goalID=$goal_mbti['goalID'];
        for ($i=0;$i<$c; $i++)
        {
                $mbti->add_new_checklist_item($goalID,$newcheckstoadd[$i]['checklistID']);
        }
        return 1;
}

function getLikers($ID, $goalID, $mbti, $userID, $type)
{		
	
	$like_result=$mbti->getlikes($ID, $type); 
	$like_count = 0;
        $like_arr=array();
        $you_flag = -1;
	while(($like_row = mysql_fetch_array($like_result)) != null)
	{	$liker_id = $like_row['id']; 
		$liker_name = $like_row['first_name']; 
		if ($liker_id==$userID) 
		{ 
			$liker_name='You'; 
			$you_flag=$like_count; 
		} 
		$like_arr[$like_count]['id']=$liker_id; 
		$like_arr[$like_count]['name']=$liker_name;
		$like_count++; 		
	}
	include_once("feed_helper.php"); 
	$like_users=composeLikers($like_arr,$you_flag);
	return $like_users;
	
} // END OF getLikers

function getComments($ID,$goalID, $mbti ,$USERID, $type)
{	 
	$comments = $mbti->getComments($ID, $type);
	include_once("feed_helper.php");
	$comments = composeComments($comments,$USERID,2);
        return $comments;
} // END of getComments


?> 
