<?php
if(isset($_GET['hideFeed']))
{
	$msg_html=  "<div id='eventHeader'><span onClick='closeBox();'></span> Do you really want to hide this</div>";
	$msg = "If you do this,this post will no longer appear in your feeds.";	      
	$msg .= "Do you really want to do this";
	$msg_html.= "<div class ='confirm_message'>$msg</div>";
	$msg_html.=  "<div id='eventFooter'>";
	$msg_html .= '<input type="button" value="Yes" id = "confirm_submit" onClick=""/>';
	$msg_html .= '<div class="clr"></div>';
	$msg_html .= "</div>";
	echo $msg_html;
}
if(isset($_GET['deleteFeed']))
{
	$msg_html=  "<div id='eventHeader'><span onClick='closeBox();'></span> Do you really want to delete this</div>";
	$msg = "If you do this,this post will be deleted and no longer visible to anyone.";	      
	$msg .= "Do you really want to do this";
	$msg_html.= "<div class ='confirm_message'>$msg</div>";
	$msg_html.=  "<div id='eventFooter'>";
	$msg_html .= '<input type="button" value="Yes" id = "confirm_submit" onClick=""/>';
	$msg_html .= '<div class="clr"></div>';
	$msg_html .= "</div>";
	echo $msg_html;
}
if(isset($_GET['openFeed']))
{
	$msg_html=  "<div id='eventHeader'><span onClick='closeBox();'></span> Do you really want to post this in company feeds</div>";
	$msg = "If you do this,this post will be visible in company feeds and anyone in your company will be able to like and make comments on this post.";	      
	$msg .= "Do you really want to do this";
	$msg_html.= "<div class ='confirm_message'>$msg</div>";
	$msg_html.=  "<div id='eventFooter'>";
	$msg_html .= '<input type="button" value="Yes" id = "confirm_submit" onClick=""/>';
	$msg_html .= '<div class="clr"></div>';
	$msg_html .= "</div>";
	echo $msg_html;
}
if(isset($_GET['closeFeed']))
{
	$msg_html=  "<div id='eventHeader'><span onClick='closeBox();'></span>Already posted in Company Feeds</div>";
	$msg = "This feed already is in company feeds ";
	$msg_html.= "<div class ='confirm_message'>$msg</div>";
	$msg_html.=  "<div id='eventFooter'>";
	$msg_html .= '<input type="button" value="Okay" id = "confirm_submit" onClick=""/>';
	$msg_html .= '<div class="clr"></div>';
	$msg_html .= "</div>";
	echo $msg_html;
}
if(isset($_GET['completedGoal']))
{
	$msg_html=  "<div id='eventHeader'><span onClick='closeBox();'></span>Already posted in Company Feeds</div>";
	$msg = "Do you want to complete the Goal ";
	$msg_html.= "<div class ='confirm_message'>$msg</div>";
	$msg_html.=  "<div id='eventFooter'>";
	$msg_html .= '<input type="button" value="Okay" id = "confirm_submit" onClick=""/>';
	$msg_html .= '<div class="clr"></div>';
	$msg_html .= "</div>";
	echo $msg_html;
}
?>
