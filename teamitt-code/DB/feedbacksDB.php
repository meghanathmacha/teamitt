<?php
class feedbacksDB extends DB
{
public function addFeedback($feedbackFor,$feedbackBy,$feedback)
{

	if($this -> link)
	{

		//	$query="insert into goal_peoples (goalid, peopleid) values ";
			$query="insert into feedbacks(feedback_for,feedback_by,feedback)values ($feedbackFor,$feedbackBy,'$feedback')";
			//$query="insert into feedbacks(feedback_for,feedback_by,feedback)values (1,3,'feedback')";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;
	}
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

public function addFeedbackAction($feed_type,$feed_from,$feed_to,$content_text,$content_type,$content_id,$goal_id,$visibility_id,$more)
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

}
?>
