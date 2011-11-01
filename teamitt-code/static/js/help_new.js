function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
function getLikes(last_like_id)
{
user_id = 1;
	$.ajax({
type: "GET",
url: "get_comments.php",
dataType: "json",
data:"last_like_id="+last_like_id+"&user_id="+user_id,
timeout:10000,
error :function() {

 },
success:function(data){

var data_len = data.length;
var like_html = '';
for(i = 0 ; i < data_len ; i++)
{
	var row = data[i];
	var feed_id = row["feed_id"];
	var liker_id = row["like_from"];	
	var liker_name = row["first_name"];
	var like_id = row["id"];
	if(liker_id == LOGGED_IN_USER_ID)
		liker_name = 'you';
	if(i == 0)
	{
		like_html += '<div class="likes"> <span class="feed_data first">'+liker_name+'</span>';
		if(data_len == 1)
			like_html += 'liked this </div>';
	}
	else if(i == 1)
	{
 		like_html += '<span class = "second"> and <span class="feed_data">'+liker_name+'</span></span>';
		if(data_len == 2)
			like_html += 'liked this </div>';
	}

	else if(i == (data_len -1))
		like_html +=  '<span class = "others"> and <span class="feed_data"> '+(data_len-2)+' others </span> </span> liked this </div>';	
	$('#feed_'+feed_id).find(".add_help_answer").after(content_html);
	
}
}
});
}
function getActionReplyUpdate(last_reply_id)
{
user_id = 1;
	$.ajax({
type: "GET",
url: "get_comments.php",
dataType: "json",
data:"last_reply_id="+last_reply_id+"&user_id="+user_id,
timeout:10000,
error :function() {

// getReplyUpdate(last_ask_id);},
 },
success:function(data){

var data_len = data.length;
var reply_post_html = '';
for(i = 0 ; i < data_len ; i++)
{
	var row = data[i];	
	var reply_content = row["comment_text"];
	reply_content = unescape(reply_content);
	var feed_id = row["feed_id"];
	var comment_id = row["id"];
	var reply_id = comment_id;
	var replier_id = row["comment_from"];
	var replier_name = row["first_name"];
	if(replier_id == LOGGED_IN_USER_ID)
		replier_name = 'you';
	var replier_pic = "uploads/profileimg/profileimg-"+replier_id+".jpg";
	//var replier_pic = row["image_src"];
//	alert(last_reply_id);
	if(i == 0)
		last_reply_id = parseInt(reply_id);
        var replier_profile = "profile.php?id="+replier_id;
	$.ajax({
	    url:replier_pic,
	    type:'HEAD',
	    error: function(){
		replier_pic = "static/images/ambitions.png";
    	},
	    success:function(){
     }
  });
//        var replier_pic = "http://graph.facebook.com/"+replier_id+"/picture";
        var content_html = '<div id = "comment_'+reply_id+'" class="help_answer">'
	if(replier_id == LOGGED_IN_USER_ID)
		content_html+= '<span class = "comment_delete cross"> X </span>';
	content_html += ' <div class="pic_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></div><div class = "help_answer_text"><p class="feed_data">'+replier_name+'</p>'+reply_content+'</div><div class="clr"></div></div>';
//	$('#feed_'+feed_id).find(".add_help_answer").after(content_html);
	$('#feed_'+feed_id).find(".comments").append(content_html);
//        $(this).after(content_html);

	
}
}
});
}
$(document).ready(function(){
$('hr:last').hide();
getActionReplyUpdate(0);
$('.add_help_answer').live('click',add_help_answer);
$('.comment_delete').live('click',deleteComment);
$('.feed_delete').live('click',deleteFeed);
$('#like_button').live('click',likeMe);
$('#unlike_button').live('click',unlikeMe);
$('.attach_goal').live('click',attachToGoal);
$('.remove_goal').live('click',removeFromGoal);
$('.edit_date').live('click',editDueDate);
$('#eventHeader').find('.create_goal_tab').live('click',createGoal);
$('#eventHeader').find('.attach_goal_tab').live('click',attachGoal);
$('.hide_feed').live('click',hideFeed);
$('.more_feeds').live('click',moreFeed);
function moreFeed()
{
	var thisItem = this;
	$('.more_feeds').html("<img src = 'static/images/loading2.gif'/>");
	OFFSET = parseInt(OFFSET) + 10;
	post_data={
	offset:OFFSET,
	user_id:PROFILE_ID,
	type_name:TYPE_NAME,
	}
	$.ajax({
	type: "POST",
	url: "feeds.php",
	data:post_data,
	//timeout:10000,
	error :function() {},
	success:function(data){
	$('#feedCont').append(data);
	$(thisItem).remove();
	}
	});
}
function hideFeed()
{
	var parent_id = $(this).parents('.wall_post').attr('id');
	var feed_id = parent_id.substring(5,(parent_id.length));
	var reply_data={
	feed_id:feed_id,
	changer_id:LOGGED_IN_USER_ID,
	changeFeedV:1,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){},
	});
	$('#feed_'+feed_id).fadeOut(function()
	{
	$(this).remove();
	});


}
function attachGoal()
{
//	$(this).css({'text-decoration':'underline'});
	$('#eventWrap').find('#eventForm').hide();
	$("#eventWrap").find(".attach_goal_content").show();
	
}
function createGoal()
{
	//$(this).css({'text-decoration':'underline'});
	mode = "new";
	var goalForm = $('#eventWrap').find('#eventForm').html();
if(goalForm == undefined)
{
var post_data={
param:"goal",
action:"new"
};
param= '';
//url = "includes/goalactions.php";
url = "includes/createGoal.php";
	
	$.ajax({
type: "POST",
url: url,
//dataType: "json",
//data:post_data,
timeout:10000,
error :function() {

},
success:function(data){
var data_html = "<div class = 'create_goal_content>"+data+"</div>";
$("#eventWrap").find(".attach_goal_content").hide();
$("#eventWrap").find("#eventContent").append(data);

}
});
}
else
{
	$("#eventWrap").find(".attach_goal_content").hide();
	$('#eventWrap').find('#eventForm').show();
}
}
function submitDate(feed_id)
{
	alert(feed_id);
	var date_flag =  $('.edit_date_inp').attr('flag');
	var date_str = $('.edit_date_inp').val();
	alert(date_flag);
	alert(date_str);
	var reply_data={
	feed_id:feed_id,
	editDueDate:1,
	date_str:date_str,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
	

},
	});
	closeBox();
}
function editDueDate()
{
	var item = this;
	var parent_id = $(this).parents('.wall_post').attr('id');
	var feed_id = parent_id.substring(5,(parent_id.length));
	var date_flag = $(this).parents('.feed_base').find('.due_date').attr('flag');
	if(date_flag == '2' )
		var date_val = $(this).parents('.feed_base').find('.due_date').find('.date').text();
	else
		date_val = date_flag;
	openBox('includes/edit_due_date.php','date_val='+date_val);
	$('input#date_submit').live('click',function()
	{
	var date_reg= "^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])";
	$('.edit_date_inp').filter(function() {
        	return $(this).val().match(/\d/);
    	}).attr("flag",'2');
	var date_flag =  $('.edit_date_inp').attr('flag');
	var message =  $('.edit_date_inp').val();
	var date_str = '';
	if(date_flag == 2)
	{
		date_str = message;
		message = "Due on ";
		date_val = date_str;
	}
	else if(date_flag == 1)
		var date_val = '1111-11-11';
	else if(date_flag == 0)
		var date_val = '0000-00-00';
	var reply_data={
	feed_id:feed_id,
	editDueDate:1,
	date_val:date_val,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){

},
	});
	$(item).parents('.feed_base').find('.due_date').attr('flag',date_flag);
	$(item).parents('.feed_base').find('.due_date').find('.date').text(date_str);
	$(item).parents('.feed_base').find('.due_date').find('.date_message').text(message);
	
	
	closeBox();
}

);

}
function removeFromGoal()
{
	var thisItem = this;
	var parent_id = $(this).parents('.wall_post').attr('id');
	var feed_id = parent_id.substring(5,(parent_id.length));
	var reply_data={
	feed_id:feed_id,
	removeFromGoal:1,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
	

},
	});
		$('#feed_'+feed_id).find('.attached_goal').remove();
		$(thisItem).text('Attach to goal');
		$(thisItem).attr('class','attach_goal');
		
	
}
function attachToGoal()
{
	var thisItem = this;
	var parent_id = $(this).parents('.wall_post').attr('id');
	var feed_id = parent_id.substring(5,(parent_id.length));
openBox("includes/show_goals.php","user_id="+LOGGED_IN_USER_ID);	
$('.goal_row').live('click',function()
{
	var parent_id = $(this).attr('id');
	goal_id = parent_id.substring(9,(parent_id.length));
	goal_name = $(this).find('.goal_name').text();
	var reply_data={
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
	success:function(data){
	

},
		
	});
		closeBox();
			var content = "<span class = 'attached_goal' id = 'attached_goal_"+goal_id+"'>on goal <span class = 'feed_data'> "+goal_name+"</span></span>";
		$('#feed_'+feed_id).find('.attached_goal').remove();
		$('#feed_'+feed_id).find('.feed_to').after(content);
		$(thisItem).text('Remove from goal');
		$(thisItem).attr('class','remove_goal');
	
});
}
function unlikeMe()
{
	
}
function deleteComment()
{
	var parent_id = $(this).parents('.help_answer').attr('id');
	var comment_id = parent_id.substring(8,(parent_id.length));
	var reply_data={
	comment_id:comment_id,
	deleter_id:LOGGED_IN_USER_ID,
	deleteComment:1,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){},
	});
	$('#comment_'+comment_id).fadeOut(function()
	{
	$(this).remove();
	});

}
function deleteFeed()
{
	var parent_id = $(this).parents('.wall_post').attr('id');
	var feed_id = parent_id.substring(5,(parent_id.length));
	var reply_data={
	feed_id:feed_id,
	deleter_id:LOGGED_IN_USER_ID,
	deleteFeed:1,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){},
	});
	$('#feed_'+feed_id).fadeOut(function()
	{
	$(this).remove();
	});


}

function likeMe()
{
	var parent_id = $(this).parents('.wall_post').attr('id');
	var feed_id = parent_id.substring(5,(parent_id.length));
	var reply_data={
	feed_id:feed_id,
	liker_id:LOGGED_IN_USER_ID,
	like:1,
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){},
	});
	$(this).text('Liked');
	$(this).attr('id','unlike_button');
	var like_count = $('#feed_'+feed_id).find('.likes').attr('id');
	if(like_count == undefined)
	{
		like_html = '<div id = "like_1" class = "likes"><span class = "feed_data first"> you </span> liked this </div>';
		$('#feed_'+feed_id).find('.editor:first').before(like_html);

	}
	else
	{
		
		like_count = like_count.substring(5,(like_count.length));
		like_count = parseInt(like_count);
		like_count++;
		$('#feed_'+feed_id).find('.likes').attr('id','like_'+like_count);
		if(like_count > 1)
		{
			var first_liker = $('#feed_'+feed_id).find('.likes').children('.first').text();
			like_html = '<span class = "feed_data first"> you </span>';
			like_html += '<span class = "second"> and <span class = "feed_data">'+first_liker+'</span></span>';
		}
		if(like_count > 2)
		{
			var second_liker = $('#feed_'+feed_id).find('.likes').children('.second').children('.feed_data').text();
			var others = like_count - 2;
			if(others == 1)
				others = second_liker;
			else
				others  = others+' others'; 
			like_html += '<span class = "others">and <span class = "feed_data">'+others+'</span></span>';
		}
			like_html += ' liked this';
		$('#feed_'+feed_id).find('.likes').html(like_html);
		
	}
}	
function add_help_answer()
{

	var content = $(this).parent().prevAll('.answer_editor').find('#answer_post').val();
	var comment_id;
	if(content == '')
		return 0;
	content = htmlEntities(content);
	$(this).parent().prevAll('.answer_editor').find('#answer_post').val('');
	var parent_id = $(this).parents('.wall_post').attr('id');
	if(parent_id == undefined)
		var parent_id = $(this).parents('.wall_post_right').attr('id');
	if(parent_id.indexOf("feed") != -1)	
	{
		var feed_id = parent_id.substring(5,(parent_id.length));
	var reply_data = {
		body:escape(content),
		feed_id:feed_id,
		replier_id:LOGGED_IN_USER_ID,
		comment:1,
	}
	}
	$.ajax({
	type: "POST",
	url: "comments.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){comment_id = data;
	
        var replier_profile = "profile.php?id="+LOGGED_IN_USER_ID;
	var replier_pic = "uploads/profileimg/profileimg-"+LOGGED_IN_USER_ID+".jpg";
	$.ajax({
	    url:replier_pic,
	    type:'HEAD',
	    error: function(){
		replier_pic = "static/images/ambitions.png";
    	},
	    success:function(){
     }
  });
//	  var replier_pic = "http://graph.facebook.com/"+LOGGED_IN_USER_ID+"/picture";
        var content_html = '<div id = "comment_'+comment_id+'" class="help_answer">';
	content_html+= '<span class = "comment_delete cross"> X </span>';
	content_html += '<div class="pic_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></div><div class = "help_answer_text"><p class="feed_data">you</p>'+content+'</div><div class="clr"></div></div>';
	$('#feed_'+feed_id).find(".comments").append(content_html);
}
	});
        //$(this).parent().append(content_html);
}
});

