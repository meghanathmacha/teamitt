$(document).ready(function()
{
	loadFollowers();
	$('.follow_button').live('click',followMe);
	$('.load_followers').live('click',loadFollowers);
	
function followMe()
{
	var content_id = $(this).attr('id');
	content_id = content_id.substring(8,content_id.length);
	var follow_state = $(this).attr('state');
	var type_name = $(this).attr('type');
	if(type_name = 'goal')
		type_id = 1;
	if(follow_state = 'no')
	{
	var ajax_data = {
		insertFollower:1,
		content_id:content_id,
		user_fbid:LOGGED_IN_USER_ID,
		type_id:type_id
	}
	$.ajax({
	type: "POST",
	url: "includes/follow_helper.php",
	dataType: "json",
	data:ajax_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
		$('.follow_button').attr('state','yes');
		$('.follow_button').text('Following');
		$('.follow_button').attr('class','followed_button');
		follower_name = LOGGED_IN_USER_NAME;
		follower_fbid = LOGGED_IN_USER_ID;
		follower_pic = "http://graph.facebook.com/"+follower_fbid+"/picture";
		follower_profile = "profile.php?id="+follower_fbid;
	        follower_list_html = "<div class='follower'><div class='follower_img'><a href ='"+follower_profile+"'>"
				   +"<img src = '"+follower_pic+"' /></a>"
				   +"</div><div class='follower_name'><p>"+follower_name+"</p></div></div>";	
		$('.followers_list').append(follower_list_html);
	},
	});
	
	}
	
	
}
function loadFollowers()
{
	var content_id = $('.follow_button').attr('id');
	if(content_id == undefined)
	{
		var content_id = $('.followed_button').attr('id');
		var type_name = $('.followed_button').attr('type');
	}		
	else
	{
		var type_name = $('.follow_button').attr('type');
	}
	content_id = content_id.substring(8,content_id.length);
	if(type_name = 'goal')
		type_id = 1;
	var ajax_data = {
		getFollowerByContentId:1,
		content_id:content_id,
		type_id:type_id
	}
	$.ajax({
	type: "POST",
	url: "includes/follow_helper.php",
	dataType: "json",
	data:ajax_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
	var data_len = data.length;
	var follower_list_html = '<div class = "follow_header"><p>Followers</p> </div>';
	for(i = 0 ; i < data_len ; i++)
	{
		var row = data[i];	
		follower_name = row["facebook_name"];
		follower_fbid = row["facebook_id"];
		follower_pic = "http://graph.facebook.com/"+follower_fbid+"/picture";
		follower_profile = "profile.php?id="+follower_fbid;
	        follower_list_html += "<div class='follower'><div class='follower_img'><a href ='"+follower_profile+"'>"
				   +"<img src = '"+follower_pic+"' /></a>"
				   +"</div><div class='follower_name'><p>"+follower_name+"</p></div></div>";	
	}
		$('.followers_list').html(follower_list_html);
	}
	,
	});
	
	
	
}
});
