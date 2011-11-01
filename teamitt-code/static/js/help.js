function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
function getGoalReplyUpdate(last_reply_id)
{
	$.ajax({
type: "GET",
url: "get_goal_reply_update.php",
dataType: "json",
data:"last_reply_id="+last_reply_id+"&user_fbid="+user_fbid,
timeout:10000,
error :function() {

// alert(last_ask_id);
// getReplyUpdate(last_ask_id);},
 },
success:function(data){

var data_len = data.length;
var reply_post_html = '';
for(i = 0 ; i < data_len ; i++)
{
	var row = data[i];	
	var reply_content = row["reply_content"];
	reply_content = unescape(reply_content);
	var goal_id = row["goal_id"];
	var reply_id = row["reply_id"];
	var replier_fbid = row["replier_fbid"];
//	alert(last_reply_id);
	if(i == 0)
		last_reply_id = parseInt(reply_id);
        var replier_profile = "user_profile.php?user_fbid="+replier_fbid;
        var replier_pic = "http://graph.facebook.com/"+replier_fbid+"/picture";
        var content_html = '<div class="help_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></img><div class = "help_answer_text">'+reply_content+'</div></div>';
//	alert(content_html);
	$('#goal_'+goal_id).find(".add_help_answer").after(content_html);
//        $(this).after(content_html);

	
}
}
});
}
function getActionReplyUpdate(last_reply_id)
{
	$.ajax({
type: "GET",
url: "get_action_reply_update.php",
dataType: "json",
data:"last_reply_id="+last_reply_id+"&user_fbid="+user_fbid,
timeout:10000,
error :function() {

// alert(last_ask_id);
// getReplyUpdate(last_ask_id);},
 },
success:function(data){

var data_len = data.length;
var reply_post_html = '';
for(i = 0 ; i < data_len ; i++)
{
	var row = data[i];	
	var reply_content = row["reply_content"];
	reply_content = unescape(reply_content);
	var action_id = row["action_id"];
	var reply_id = row["reply_id"];
	var replier_fbid = row["replier_fbid"];
//	alert(last_reply_id);
	if(i == 0)
		last_reply_id = parseInt(reply_id);
        var replier_profile = "user_profile.php?user_fbid="+replier_fbid;
        var replier_pic = "http://graph.facebook.com/"+replier_fbid+"/picture";
        var content_html = '<div class="help_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></img><div class = "help_answer_text">'+reply_content+'</div></div>';
//	alert(content_html);
	$('#action_'+action_id).find(".add_help_answer").after(content_html);
//        $(this).after(content_html);

	
}
}
});
}
function getReplyUpdate(last_reply_id)
{
	$.ajax({
type: "GET",
url: "get_reply_update.php",
dataType: "json",
data:"last_reply_id="+last_reply_id+"&user_fbid="+user_fbid,
timeout:10000,
error :function() {

// alert(last_ask_id);
// getReplyUpdate(last_ask_id);},
 },
success:function(data){

var data_len = data.length;
var reply_post_html = '';
for(i = 0 ; i < data_len ; i++)
{
	var row = data[i];	
	var reply_content = row["reply_content"];
	reply_content = unescape(reply_content);
	var ask_id = row["ask_id"];
	var reply_id = row["reply_id"];
	var replier_fbid = row["replier_fbid"];
//	alert(last_reply_id);
	if(i == 0)
		last_reply_id = parseInt(reply_id);
        var replier_profile = "user_profile.php?user_fbid="+replier_fbid;
        var replier_pic = "http://graph.facebook.com/"+replier_fbid+"/picture";
        var content_html = '<div class="help_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></img><div class = "help_answer_text">'+reply_content+'</div></div>';
//	alert(content_html);
	$('#help_'+ask_id).find(".add_help_answer").after(content_html);
//        $(this).after(content_html);

	
}
}
});
}
function doPoll(last_ask_id) {
	$.ajax({
type: "GET",
url: "get_help_update.php",
dataType: "json",
data:"last_ask_id="+last_ask_id+"&user_fbid="+user_fbid,
timeout:10000,
error :function() {

// alert(last_ask_id);
// doPoll(last_ask_id);
},
success:function(data){

var data_len = data.length;
var wallhtml = '';
for(i = 0 ; i < data_len ; i++)
{
var row = data[i];
var message = row["ask_content"];
var asker_fbid = row["asker_fbid"];
var helper_fbid = row["helper_fbid"];
var ask_id = row["ask_id"];
if(i == 0)
	last_ask_id = parseInt(ask_id);

var asker_pic = "http://graph.facebook.com/"+asker_fbid+"/picture";
var helper_pic = "http://graph.facebook.com/"+helper_fbid+"/picture";
var asker_profile_url = "user_profile.php?user_fbid="+asker_fbid;
var helper_profile_url = "user_profile.php?user_fbid="+helper_fbid;

wallhtml += '<div id = "help_'+ask_id+'" class = "wall_post"><div class = "wall_pic" ><a href = "'+asker_profile_url+'"><img src="'+asker_pic+'"/></a></div><div class = "wall_help_message">'+message+'</div>'
	 + '<div class = "side_pic"><a href="'+helper_profile_url+'"><img src = "'+helper_pic+'" /></a> </div>'						      +'<div class = "add_help_answer"> Answer this </div></div>';

}  
$('#mainCont').prepend(wallhtml);
//doPoll(last_ask_id);
 
}
}); 
}
$(document).ready(function(){
var CATEGORY;
var OBJECT_NAME;        //university or locatation etc name;

/*$.ajaxSetup({
timeout: 10 //set a global ajax timeout of a minute
});*/
//doPoll(0); 
getReplyUpdate(0);
getActionReplyUpdate(0);
getGoalReplyUpdate(0);
$('.add_help_answer').live('click',add_help_answer);
function add_help_answer()
{

/*if(($(this).text()) != "Post")
    {
        $(this).text('Post');
var answer_editor_html = '<div class="yui-skin-sam answer_editor" style="">'
			+ '<textarea name="answer_post" id="answer_post" cols="82" rows="2">'
			+ '</textarea></div>';
    	$(this).before(answer_editor_html);
	//answerEditor.render();
        //$('.answer_editor').show();
    
    }
    else
    {*/
	var content = $(this).prevAll('.answer_editor').find('#answer_post').val();
	content = htmlEntities(content);
	$(this).prevAll('.answer_editor').find('#answer_post').val('');
	var parent_id = $(this).parents('.wall_post').attr('id');
	if(parent_id == undefined)
		var parent_id = $(this).parents('.wall_post_right').attr('id');
	if(parent_id.indexOf("help") != -1)	
	{
		var ask_id = parent_id.substring(5,(parent_id.length));
	var reply_data = {
		body:escape(content),
		ask_id:ask_id,
		replier_fbid:LOGGED_IN_USER_ID,
		replier_name:LOGGED_IN_USER_NAME
	}
	}
	else if(parent_id.indexOf("action") != -1)	
	{
		var action_id = parent_id.substring(7,(parent_id.length));
	var reply_data = {
		body:escape(content),
		action_id:action_id,
		replier_fbid:LOGGED_IN_USER_ID,
		replier_name:LOGGED_IN_USER_NAME
	}
	}
	else if(parent_id.indexOf("goal") != -1)	
	{	
		var goal_id = parent_id.substring(5,(parent_id.length));
	var reply_data = {
		body:escape(content),
		goal_id:goal_id,
		replier_fbid:LOGGED_IN_USER_ID,
		replier_name:LOGGED_IN_USER_NAME
	}
	}
//	answerEditor.saveHTML();
//	var content = answerEditor.get('element').value;
//	$(this).prevAll('.side_pic').next().remove();
//	$(this).prevAll('.answer_editor').remove();
	$.ajax({
	type: "POST",
	url: "mail_sender.php",
	dataType: "json",
//	contentType: "application/json; charset=utf-8",
// 	data:"body="+content+"&ask_id="+ask_id+"&replier_fbid="+LOGGED_IN_USER_ID,
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){},
	});
// 	$.getJSON("mail_sender.php?body="+content+"&ask_id="+ask_id+"&replier_fbid="+LOGGED_IN_USER_ID,function(data){});
//	    $(this).text('Answer this');
        var replier_profile = "user_profile.php?user_fbid="+LOGGED_IN_USER_ID;
        var replier_pic = "http://graph.facebook.com/"+LOGGED_IN_USER_ID+"/picture";
        var content_html = '<div class="help_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></img><div class = "help_answer_text">'+content+'</div></div>';
        $(this).after(content_html);

/*	alert(ask_id);
	alert(LOGGED_IN_USER_ID);
	alert(content);*/
    //}
}
function dialogInit()
{
	$('#add_recipe_dialog').dialog({
	autoOpen: false,
	width: 620,
	height: 490,
	buttons: {
	"Add": function() {
	add_recipe_post();
//	$('.yui-skin-sam').hide();	
	$(this).dialog("close");
	},
	"Cancel": function() {
//	$('.yui-skin-sam').hide();	
	$(this).dialog("close");
	}
	}
	});
	$('#ask_help_dialog').dialog({
	autoOpen: false,
	width: 650,
	height: 620,
	buttons: {
	"Ask": function() {
 	 askEditor.saveHTML();
	 var content = askEditor.get('element').value;
	if(content != '')
	{
		ask_help_post(content);
//	$('#ask_help_dialog >.yui-skin-sam').hide();
		$(this).dialog("close");
	}
	else
	{
		var html = "Write your question here"
		askEditor.execCommand('inserthtml', html);
	}
	},
	"Cancel": function() {
//	$('.yui-skin-sam:visible').hide();	
	$(this).dialog("close");
	}
	}
	});
}
function send_message(to, opts) {

var href = 'http://www.facebook.com/?compose&sk=messages'
    href += "&id=" + to
    href += "&subject=" + encodeURIComponent(opts['subject'] || "Hello")
    href += "&message=" + encodeURIComponent(opts['message'] || "Hello")
// window.location.href = href;
 window.open(href);
 //return new Element('a', {href:href, 'class':"button button-blue", style:opts.style, target:'_blank'}).update(opts.label || "Send Message")
} 
function ask_help_post(content)
{
  
  
  //var  receiver_email = PROFILE_USER_EMAIL;
  content = htmlEntities(content);
  var receiver_fbid = user_fbid;
  var sender_fbid = LOGGED_IN_USER_ID;
  var sender_name = LOGGED_IN_USER_NAME;
  var receiver_name = PROFILE_USER_NAME;
  var sender_email = LOGGED_IN_USER_EMAIL;  
  var subject = "Want an help";
opts = new Array();
opts["subject"] = subject;
opts["message"] = content;
  var receiver_email = $('input[name="receiver_email"]').val();
  var goal_id = $('select[name="goal_selection"]').children(":selected").val();
  if(goal_id == '0' || goal_id == undefined)
  {
	  var option_title = $('#add_goal').val();
	  $.getJSON("includes/add_goal.php?title="+option_title+"&user_fbid="+LOGGED_IN_USER_ID,
		function(goal_id){
			
			goal_id = parseInt(goal_id);
 			$.getJSON("mail_sender.php?body="+content+"&receiver_email="+receiver_email+"&sender_email="+sender_email+"&category="+CATEGORY+"&object_name="+OBJECT_NAME+"&receiver_fbid="+receiver_fbid+"&sender_fbid="+sender_fbid+"&receiver_name="+receiver_name+"&sender_name="+sender_name+"&goal_id="+goal_id,function(data){});

		});
  }
  else
  {
  //send_message(user_fbid,opts);	
 $.getJSON("mail_sender.php?body="+content+"&receiver_email="+receiver_email+"&sender_email="+sender_email+"&category="+CATEGORY+"&object_name="+OBJECT_NAME+"&receiver_fbid="+receiver_fbid+"&sender_fbid="+sender_fbid+"&receiver_name="+receiver_name+"&sender_name="+sender_name+"&goal_id="+goal_id,function(data){});
}

/*	var wallhtml += '<div id = "help_'.$ask_id.'" class = "wall_post"><div class = "wall_pic" ><a href = "'.$asker_profile_url.'"><img src="'.$asker_pic.'"/></a></div>'
	 	     + '<div class = "side_pic"><a href="'.$helper_profile_url.'"><img src = "'.$helper_pic.'" /></a> </div>'						     		
		     +'<div class = "wall_help_message">'.$message.'</div>'
	             +'<div class="yui-skin-sam answer_editor" style="">'
		     + '<textarea name="answer_post" id="answer_post" cols="73" rows="2">'
		     + '</textarea></div>'
		     +'<div class="add_help_answer"> Post </div></div>';*/
}
function add_recipe_post()
{
  addEditor.saveHTML();
 
  var content = addEditor.get('element').value;
//  var  receiver_email = PROFILE_USER_EMAIL;	
 // var receiver_fbid = user_fbid;
  var adder_fbid = LOGGED_IN_USER_ID;
  var title = OBJECT_NAME;
 var  adder_name = LOGGED_IN_USER_NAME;
//  var receiver_name = PROFILE_USER_NAME;
 // var sender_email = LOGGED_IN_USER_EMAIL;  
  var goal_id = $('select[name="goal_selection"]').children(":selected").val();
  if(goal_id == '0' || goal_id == undefined)
  {
	  var option_title = $('#add_goal').val();
	  $.getJSON("includes/add_goal.php?title="+option_title+"&user_fbid="+LOGGED_IN_USER_ID,
		function(goal_id){
			
			goal_id = parseInt(goal_id);
 $.getJSON("mail_sender.php?body="+content+"&adder_fbid="+adder_fbid+"&category="+CATEGORY+"&object_name="+OBJECT_NAME+"&title="+title+"&adder_name="+adder_name+"&goal_id="+goal_id,function(data){});
	});

  }
 else
{
 $.getJSON("mail_sender.php?body="+content+"&adder_fbid="+adder_fbid+"&category="+CATEGORY+"&object_name="+OBJECT_NAME+"&title="+title+"&adder_name="+adder_name+"&goal_id="+goal_id,function(data){});
}
}
var addEditor = new YAHOO.widget.Editor('recipe_post', {
    height: '100px',
    width: '522px',
    dompath: true, //Turns on the bar at the bottom
  animate: true //Animates the opening, closing and moving of Editor windows
});
var askEditor = new YAHOO.widget.Editor('help_post', {
    height: '100px',
    width: '522px',
    dompath: true, //Turns on the bar at the bottom
  animate: true //Animates the opening, closing and moving of Editor windows
});
/*var answerEditor = new YAHOO.widget.Editor('answer_post', {
    height: '100px',
    width: '522px',
    dompath: true, //Turns on the bar at the bottom
  animate: true //Animates the opening, closing and moving of Editor windows
});*/
		askEditor.render();
		addEditor.render();
		dialogInit();
		$('select[name="goal_selection"]').live('change',function()
		{
		var goal_id = $(this).children(":selected").val();
		if(goal_id == '0')
		{
			$('#add_goal').parents('tr').fadeIn();
			$('#add_goal').val("University Goal");
		}
		else
		{
			$('#add_goal').parents('tr').fadeOut();
		}
		});
$('.ask_help').live('click',function()
{
	OBJECT_NAME = $(this).parent().parent().find('.university_name').text();
	CATEGORY = 'University';
/*var editor_html = '';
	 editor_html += '<div class="yui-skin-sam">'
		  +'<textarea name="msgpost" id="msgpost" cols="50" rows="10">'
		  +'<strong>Your</strong> HTML <em>code</em> goes here.<br>'
		  +'This text will be pre-loaded in the editor when it is rendered.'
		  +'</textarea></div>';*/
		$('.help_form').empty();
        if(SAME_USER)	
	{
/*	        $('#add_recipe_form').load("includes/help_form.php?user_fbid="+LOGGED_IN_USER_ID);
		$('.mail_input').remove();	
	        $('#add_recipe_form').load("addrecipe.php");
		$('#add_recipe_dialog').dialog('open');
		$('#add_recipe_dialog >.yui-skin-sam').show();*/
		window.open("addrecipe.php");
	}
	else
	{
//		var input_html = '<input type = "text"/>';
//		$('#ask_help_dialog').append(input_html);
/*		$('select[name="goal_selection"]').live('change',function()
		{
		var goal_id = $(this).children(":selected").val();
		if(goal_id == '0')
		{
			$('#add_goal').parents('tr').fadeIn();
			$('#add_goal').val("University Goal");
		}
		else
		{
			$('#add_goal').parents('tr').fadeOut();
		}
		});
	        $('.help_form').load("includes/help_form.php?user_fbid="+LOGGED_IN_USER_ID);	*/
	        $('#ask_help_form').load("includes/help_form.php?user_fbid="+LOGGED_IN_USER_ID+"&profile_user_fbid="+user_fbid);	
		$('#ask_help_dialog').dialog('open');
		$('#ask_help_dialog >.yui-skin-sam').show();
		//$('.yui-skin-sam').show();
	}	
// 	$('#text_editor_dialog > p').html(editor_html);
});
});

