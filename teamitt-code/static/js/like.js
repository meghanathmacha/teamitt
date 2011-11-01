$(document).ready(function()
{
	$('.load_likes').live('click',loadLikes);
	$('.like_button').live('click',likeMe);
	
function likeMe()
{
	var content_id = $(this).attr('content');
	content_id = content_id.substring(8,content_id.length);
	var like_state = $(this).attr('state');
	var type_name = $(this).attr('type');
	if(type_name = 'ask')
		type_id = 1;
	if(like_state = 'no')
	{
	var ajax_data = {
		insertLiker:1,
		content_id:content_id,
		user_fbid:LOGGED_IN_USER_ID,
		type_id:type_id
	}
	$.ajax({
	type: "POST",
	url: "includes/like_helper.php",
	dataType: "json",
	data:ajax_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
/*		$('.like_button').attr('state','yes');
		$('.like_button').text('Liked');
		$('.like_button').attr('class','liked_button button');*/
/*		likeer_name = LOGGED_IN_USER_NAME;
		likeer_fbid = LOGGED_IN_USER_ID;
		likeer_pic = "http://graph.facebook.com/"+liker_fbid+"/picture";
		likeer_profile = "profile.php?id="+likeer_fbid;
	        likeer_list_html = "<div class='likeer'><div class='liker_img'><a href ='"+liker_profile+"'>"
				   +"<img src = '"+liker_pic+"' /></a>"
				   +"</div><div class='liker_name'><p>"+liker_name+"</p></div></div>";	
		$('.likers_list').append(liker_list_html);*/
	},
	});
		$(this).attr('state','yes');
		$(this).text('Liked');
		$(this).attr('class','liked_button button');
	
	
	}
	
	
}
function loadLikes()
{
	
	var content_id = $(this).attr('content');
/*	if(content_id == undefined)
	{
		var content_id = $('.followed_button').attr('id');
		var type_name = $('.followed_button').attr('type');
	}		
	else
	{*/
		var type_name = $(this).attr('type');
//	}
	content_id = content_id.substring(8,content_id.length);
	if(type_name = 'ask')
		type_id = 1;
	var ajax_data = {
		getLikerByContentId:1,
		content_id:content_id,
		type_id:type_id
	}
	$.ajax({
	type: "POST",
	url: "includes/like_helper.php",
	dataType: "json",
	data:ajax_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
	var data_len = data.length;
//	var liker_list_html = '<div class = "follow_header"><p>Followers</p> </div>';
	var liker_list_html = '';
	for(i = 0 ; i < data_len ; i++)
	{
		var row = data[i];	
		content_id  = row['content_id'];
		type_id = row['post_type_id'];
		liker_name = row["facebook_name"];
		liker_fbid = row["facebook_id"];
		liker_pic = "http://graph.facebook.com/"+liker_fbid+"/picture";
		liker_profile = "profile.php?id="+liker_fbid;
	        liker_list_html += "<div class='liker' style='margin-top:5px;'>"
				 //+"<div class='liker_img'><a href ='"+liker_profile+"'>"
				   //+"<img src = '"+liker_pic+"' /></a>"
				   //+"</div>"
				  +"<div class='liker_name'><p>"
				  +"<a href ='"+liker_profile+"' style='text-decoration:underline;'>"
				  +liker_name+"</a></p></div></div>";	
		if(type_id = 1)
		{
			$('.ask_'+content_id).html(liker_list_html);
		}
	}
	}
	,
	});
	
	
	
}
});
