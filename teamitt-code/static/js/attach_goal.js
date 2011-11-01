$(document).ready(function()
{
//$('.goal_row').live('click',attachToGoal);
function attachToGoal()
{
//	var parent_id = $(this).parents('.wall_post').attr('id');
//	var feed_id = parent_id.substring(5,(parent_id.length));
	var parent_id = $(this).attr('id');
	var goal_id = parent_id.substring(9,(parent_id.length));
	alert(goal_id);
/*	var reply_data={
	feed_id:feed_id,
	goal_id:goal_id,
	attachToGoal:1,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){},
	});*/


}
});
