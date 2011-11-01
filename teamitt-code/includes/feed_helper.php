<?php
function composeComments($result,$USERID,$comment_type)
{
	$content_html = '';
	while(($row = mysql_fetch_array($result))!= null)
	{
	 $reply_content = $row["comment_text"];
//	 $reply_content = unescape(reply_content);
	 $feed_id = $row["feed_id"];
	 $comment_id = $row["id"];
	 $reply_id = $comment_id;
	 $replier_id = $row["comment_from"];
	 $replier_name = $row["first_name"];
	if($replier_id == $USERID)
		$replier_name = 'you';
	$replier_pic = "uploads/profileimg/profileimg-".$replier_id.".jpg";
        $replier_profile = "profile.php?id=".$replier_id;
	if(!file_exists($replier_pic))
		$replier_pic = "static/images/teamitt-user.jpg";
        $content_html .= '<div id = "comment_'.$reply_id.'" class="help_answer">';
	if($replier_id == $USERID)
	{

		if($comment_type==2)
		{	
		$content_html .= '<span class = "mbti_comment_delete cross"> X </span>';
		}
		else
		{		
		$content_html .= '<span class = "comment_delete cross"> X </span>';
		}
}
	$content_html .= '<div class="pic_answer"><a href = "'.$replier_profile.'"><img src="'.$replier_pic.'"/></a></div><div class = "help_answer_text">';
	$content_html .= '<a href = "'.$replier_profile.'">';
	$content_html .= '<p class="feed_data">'.$replier_name.'</p>';
	$content_html .= '</a>'.$reply_content.'</div><div class="clr"></div></div>';
	}
	return $content_html;
	
}
function composeSideButtons($feed_from_id,$profile_id,$USERID,$ifOpenFeed)
{
	$wallhtml = '';
	if($USERID == $feed_from_id)
		$wallhtml .= '<span class="feed_delete cross" title = "Delete"> X </span>';
	if($profile_id == $USERID)
	{
	$wallhtml .= '<a class="cross edit_visibility" title = "Share with others" >V</a>';
	if($ifOpenFeed)
		$wallhtml .= '<a class="cross close_feed" title = "Already on Company Feeds">C</a>';
	else
		$wallhtml .= '<a class="cross open_feed" title = "Show on company feeds">C</a>';
	$wallhtml .= '<a class="cross hide_feed" title = "Hide this">H</a>';
	}
	return $wallhtml;
}
function getPic($id,$type_name)
{
	$fpic = "/home/ec2-user/teamitt/uploads/profileimg/profileimg-$id.jpg";
	$pic = "uploads/profileimg/profileimg-$id.jpg";
	if(!file_exists($fpic))
		$pic = "/static/images/userpic.jpg";
	return $pic;
}
function viewFeed($user_id,$feed_id,$feed_from_id,$message,$ifUserLiked,$feed_base,$USERID,$like_users,$comments,$side_buttons)
{
        $wallhtml .= '<div id = "feed_'.$feed_id.'" class = "wall_post"><br/>';
        $feed_from_profile = "profile.php?id=".$feed_from_id;
        $feed_from_pic  = getPic($feed_from_id,1);	
//	$wallhtml .= '<div class="side_pic"><a href="'.$receiver_url.'"><img src ="'.$receiver_pic.'"/></a></div>';
	$wallhtml .= '<div class="wall_content">';
	$wallhtml .= '<div class = "wall_pic" ><div><a href = "'.$feed_from_profile.'"><img class = "wall_pic_img" src="'.$feed_from_pic.'"/></a></div></div>';
	$wallhtml .= '<div class="w-m">';
	$wallhtml .= '<div class="wall_msg">';
	$wallhtml .= '<div class = "wall_help_message">';
	$wallhtml .= $side_buttons;
	$wallhtml .= $message;
	$wallhtml.= '</div>';
	$wallhtml.= '<br>';
	$wallhtml.=  '<div class="feed_base">';
	$wallhtml .= $feed_base;
	$wallhtml .= '</div>';
	$wallhtml .= '</div>';
        $wallhtml .= '<br>';
	$wallhtml .= $like_users;
	$wallhtml .= '<div class="editor comments">'.$comments.'</div>';
	$wallhtml .= '<div class="editor">';
	$wallhtml .= '<div class="yui-skin-sam answer_editor" style=""><textarea placeholder="Push your comment." name="answer_post" id="answer_post" cols="10" rows="2"></textarea></div>';
	$wallhtml .= '<div class="add_answer_div"><input type="button" value = "Push" class="add_help_answer"></input></div>';
	$wallhtml .= '</div>';
	$wallhtml .= '<div class="clr"></div>';
	$wallhtml .= '</div>';
	$wallhtml .= '</div>';
	$wallhtml .= '<div class="clr"></div>';
	$wallhtml .= '</div>';
//	$wallhtml .= '</div>';
	return $wallhtml;
}
function composeFeedBase($feed_type,$ifUserLiked,$time_ago,$due_date,$goal_id,$project_id)
{
	$wallhtml = '';
	$wallhtml.=  '<span class = "feed_time"> '.$time_ago.' </span>';
	$wallhtml.=  '<span class = "dot"> . </span>';
	if($feed_type == 1)
	{
		if(!$due_date || $due_date == '0000-00-00')
		{
			$message = "No due date";
			$date_flag = 0;
		}
		else if($due_date == '1111-11-11')
		{
			$message = 'Action completed';
			$date_flag = 1;
		}
		else if($due_date != null)
		{
			$message = "Due on ";
			$date_flag = 2;
			$date = $due_date;
		}
	
		$wallhtml.= '<span flag = "'.$date_flag.'" class = "due_date edit_date"><a><span class = "date_message" style="color:#00578A;">' .$message.'</span><span class = "date" style="color:#00578A;">'.$date.'</span></a></span>';
		$wallhtml.=  '<span class = "dot"> . </span>';
	}
	if($ifUserLiked)
		$wallhtml.= '<span id = "unlike_button" class = ""><a>Unlike</a></span>';
	else
		$wallhtml.= '<span id = "like_button" class = ""><a>Like</a> </span>';
	if($feed_type == 1)
	{
		$wallhtml.=  '<span class = "dot"> . </span>';
//		$wallhtml.= '<span class = "edit_date"> <a>Due date</a></span>';
//		$wallhtml.=  '<span class = "dot"> . </span>';
		if(!$goal_id && !$project_id)
			$wallhtml.= '<span class = "attach_goal"><a>Attach to goal</a></span>';
		else if ($goal_id)
			$wallhtml.= '<span class = "remove_goal"><a>Remove from goal</a></span>';
	}
	return $wallhtml;
		
}

function composeMessage($feed_type,$content_text,$feed_from_id,$feed_from_name,$more,$goal_data,$badge_arr,$project_data)
{


		$feed_from_profile_url = "profile.php?id=".$feed_from_id;
		$start_atag = "<a href = $feed_from_profile_url>";
		$end_atag = "</a>";
		$message = $start_atag;
		$goal_url = "goal.php?id=$goal_data[0]";
		if($goal_data[1] == "this")
			$goal_text = "this goal";
		else
			$goal_text = "goal <a href='$goal_url'> $goal_data[1] </a>";
		$project_url = "project.php?id=$project_data[0]";

		if($project_data[1] == "this")
			$project_text = "this project";
		else
			$project_text = "project <a href='$project_url'> $project_data[1] </a>";
	if($feed_type == 13)
	{
			$hv = " has";
			if($feed_from_name == "you")
				$hv = " have";
			$message .= "<span class = 'feed_data' > $feed_from_name </span> $end_atag removed $more from $goal_text ";
//			$message .= "<span class = 'feed_data'> $more </span> $end_atag $hv no longer contributor for $goal_text ";
			//$message = "now,".$message;
	}	
	if($feed_type == 18)
	{
			$hv = " is";
			if($feed_from_name == "you")
				$hv = " are";
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag $hv no longer contributor for $project_text";
			//$message = "now,".$message;
	}	
	if($feed_type == 14)
	{
			$goal_url = "goal.php?id=$goal_data[0]";
			if($goal_data[1] == "this")
				$goal_text = "this goal";
			else
				$goal_text = "goal <a href='$goal_url'> $goal_data[1] </a>";
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag made following changes in $goal_text";
			$message .= "<p class='feed_data'>$content_text</p>";
	}	
	if($feed_type == 16)
	{
			$project_url = "project.php?id=$project_data[0]";
			if($project_data[1] == "this")
				$project_text = "this project";
			else
				$project_text = "goal <a href='$project_url'> $project_data[1] </a>";
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag made following changes in $project_text";
			$message .= "<p class='feed_data'>$content_text</p>";
	}	
	if($feed_type == 12)
	{
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag asked feedback from $more";
			$message .= "<p class='feed_data'>$content_text</p>";
		
	}	
	if($feed_type == 11)
	{
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag gave feedback about $more";
			$message .= "<p class='feed_data'>$content_text</p>";
		
	}	
        if($feed_type == 4)
	{
		$message .= "<span class='feed_data'>".$feed_from_name."</span > $end_atag created $goal_text";
	}
        if($feed_type == 15)
	{
		$message .= "<span class='feed_data'>".$feed_from_name."</span > $end_atag created $project_text";
	}
	else if($feed_type == 1)   //action
	   {
		//$message = "Action for <span class='feed_data first'> ".$feed_to_name;
		$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag wrote ";
		$message .= "action for ".$more;
		if($goal_data[0])
		{
			$goal_url = "goal.php?id=$goal_data[0]";
			$message .= "<span class = 'attached_goal' id = 'attached_goal_$goal_data[0]'> on $goal_text</span>";
		}
		else if($project_data[0])
		{
			$project_url = "goal.php?id=$project_data[0]";
			$message .= "<span class = 'attached_goal' id = 'attached_goal_$project_data[0]'> on $project_text</span>";
		}
		$message .= "<p class='feed_data'>$content_text</p>";
	   }
	else if($feed_type == 5)   //close
	   {
		$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag completed $goal_text";
	   }
	else if($feed_type == 17)   //close
	   {
		$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag completed $project_text";
	   }
/*	else if($feed_type == 7)   //close
	   {
		$message = "<span class = 'feed_data'> $feed_from_name ";
	   }*/
	else if($feed_type == 6)   //join
	   {
		$message .= "<span class = 'feed_data'> $feed_from_name invited $more to join $goal_text";
	   }
	else if($feed_type == 9)   //join
	   {
		$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag joined $goal_text";
	   }
	else if($feed_type == 2)   //thanks
	   {
			$badge_url = $badge_arr['url'];
			$badge_name = $badge_arr['badgename'];
		if($badge_url)
		{
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag thanked $more for $badge_name";
			$message .= "<div class = 'feed_text'> <div><img src = '$badge_url'></img></div><div class = 'feed_data'> $content_text</div></div>";
			$message .= "<div class = 'clr'></div>";
		}
		else
		{
			$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag thanked $more";
			$message .= "<p class='feed_data'>$content_text</p>";
		}

	   }
	else if($feed_type == 3)   //update
	   {
		$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag posted an update";
		if($goal_data[0])
		{
			$goal_url = "goal.php?id=$goal_data[0]";
			$message .= "<span class = 'attached_goal' id = 'attached_goal_$goal_data[0]'> for $goal_text </span>";
		}
		$message .= "<p class='feed_data'>$content_text</p>";
	   }
	else if($feed_type == 10)   //update
	   {
		$message .= "<span class = 'feed_data'> $feed_from_name </span> $end_atag has given feedback to  $more";
		$message .= "<p class='feed_data'>$content_text</p>";
	   }
	return $message;
}
function composeContent($users)
{
	$total_users = count($users);
	for($i = 0; $i < $total_users ; $i++)
	{
		
	}
}
function composeFeedTos($more_arr,$you_flag)
{
	$more_users = composeUsers($more_arr,$you_flag);
	$more_count = count($more_arr);
	if($more_count > 0)
	{
		$more_users  = '<span class = "feed_to">'.$more_users.'</span>';	
		return $more_users;
	}

}
function composeLikers($more_arr,$you_flag)
{
	$more_users = composeUsers($more_arr,$you_flag);
	$more_count = count($more_arr);
	if($more_count > 0)
	{
	$more_users = '<div id = "like_'.$more_count.'" class="likes">'.$more_users;
	$more_users .= ' liked this </div>';
	return $more_users;
	}

}
function composeUsers($more_arr,$you_flag)
{
	$more_users = '';
	$more_count = count($more_arr);
	$class_name[0] = "first";
	$class_name[1] = "second";
	$class_name[2] = "third";
	$conjuction[0] = "";
	if($more_count > 2)
		$conjuction[1] = ",";
	else
		$conjuction[1] = " and";
		
	$conjuction[2] = " and";
	$count_users = 0;
	if($you_flag != -1)
	{
		$i = $you_flag;
		$profile_url = "profile.php?id=".$more_arr[$i]['id'];
		$more_users .= '<span class = '.$class_name[$count_users].'><span class="conj">'.$conjuction[$count_users].'</span>';
		$more_users .= '<a href = "'.$profile_url.'">';
		$more_users .= '<span class="feed_data">'.$more_arr[$i]['name'].'</span>';
		$more_users .= '</a>';
		$more_users .= '</span>';
	$count_users++;
	}
	for($i = 0 ; $i < $more_count ; $i++)
	{
		if($i != $you_flag)
		{
		$profile_url = "profile.php?id=".$more_arr[$i]['id'];
		$more_users .= '<span class = '.$class_name[$count_users].'><span class="conj">'.$conjuction[$count_users].'</span>';
		$more_users .= '&nbsp;<a href = "'.$profile_url.'">';
		$more_users .= '<span class="feed_data">'.$more_arr[$i]['name'].'</span>';
		$more_users .= '</a>';
		$more_users .= '</span>';
		//$more_users .= '<span class = '.$class_name[$count_users].'>'.$conjuction[$count_users].' <span class="feed_data">'.$more_arr[$i]['name'].' </span></span>';
	$count_users++;
		}
		if($more_count > 3 && $count_users == 2)
			break; 
	}
		if($more_count > 3)
		{	
			$others = ($more_count - 2)." others";
		$more_users .=  '<span class = "others"> <span class = "conj">and </span><span class="feed_data">';
		$more_users .= $others;
		$more_users .= '<ul class="others-list">';
		$index = 2;
		if($you_flag != -1 && $you_flag != 0)
			$index = 1;
		for($i = $index ;$i < $more_count ; $i++)	 
		{
		    if($i != $you_flag)
		    {
		    $id = $more_arr[$i]['id'];
		    $name = $more_arr[$i]['name'];
		    $profile_url = "profile.php?id=".$id;
		    $more_users .= '<li>'; 
		    $more_users.='<a href = "'.$profile_url.'">'.$name.'</a>';
		    $more_users .= '</li>';
		   }
		
		}
		$more_users .= '</ul></span> </span>'; 
		}
	
	return $more_users;
}
?>
