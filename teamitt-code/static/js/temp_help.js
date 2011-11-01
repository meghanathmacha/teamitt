
function doPoll(last_ask_id) {
	$.ajax({
type: "GET",
url: "get_help_update.php",
dataType: "json",
data:"last_ask_id="+last_ask_id+"&helper_fbid="+user_fbid,
timeout:60000,
error :function() { doPoll(last_ask_id);},
success:function(data){

var data_len = data.length;
var wallhtml = '';
for(i = 0 ; i < data_len ; i++)
{
var row = data[i];
var message = row["ask_content"];
var asker_fbid = row["asker_fbid"];
var ask_id = row["ask_id"];
if(last_ask_id < ask_id)
last_ask_id = ask_id;
var asker_pic = "http://graph.facebook.com/"+asker_fbid+"/picture";
wallhtml += '<div class = "wall_post"><div class = "wall_pic" ><img src="'+asker_pic+'"/></div><div class = "wall_help_message">'+message+'</div></div>';						
$('#mainCont').prepend(wallhtml);
}
//	  setTimeout(doPoll(last_ask_id)),
//	 
 alert(last_ask_id);
doPoll(last_ask_id); 
}
}); 
}
$(document).ready(function(){
var CATEGORY;
var OBJECT_NAME;        //university or locatation etc name;

/*$.ajaxSetup({
timeout: 10 //set a global ajax timeout of a minute
});*/
doPoll(0); 


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
	width: 620,
	height: 490,
	buttons: {
	"Ask": function() {
	ask_help_post();
//	$('#ask_help_dialog >.yui-skin-sam').hide();
	$(this).dialog("close");
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
function ask_help_post()
{
  var receiver_email = $('input[name="receiver_email"]').val();
  askEditor.saveHTML();
 
  var content = askEditor.get('element').value;
  //var  receiver_email = PROFILE_USER_EMAIL;	
  var receiver_fbid = user_fbid;
  var sender_fbid = LOGGED_IN_USER_ID;
  var sender_name = LOGGED_IN_USER_NAME;
  var receiver_name = PROFILE_USER_NAME;
  var sender_email = LOGGED_IN_USER_EMAIL;  
  var subject = "Want an help";
opts = new Array();
opts["subject"] = subject;
opts["message"] = content;
  //send_message(user_fbid,opts);	
 $.getJSON("mail_sender.php?body="+content+"&receiver_email="+receiver_email+"&sender_email="+sender_email+"&category="+CATEGORY+"&object_name="+OBJECT_NAME+"&receiver_fbid="+receiver_fbid+"&sender_fbid="+sender_fbid+"&receiver_name="+receiver_name+"&sender_name="+sender_name,function(data){});
//alert(html);
}
function add_recipe_post()
{
  addEditor.saveHTML();
 
  var content = addEditor.get('element').value;
//  var  receiver_email = PROFILE_USER_EMAIL;	
 // var receiver_fbid = user_fbid;
  var adder_fbid = LOGGED_IN_USER_ID;
  var title = OBJECT_NAME;
  ///var sender_name = LOGGED_IN_USER_NAME;
//  var receiver_name = PROFILE_USER_NAME;
 // var sender_email = LOGGED_IN_USER_EMAIL;  
 $.getJSON("mail_sender.php?body="+content+"&adder_fbid="+adder_fbid+"&category="+CATEGORY+"&object_name="+OBJECT_NAME+"&title="+title,function(data){alert(data);});
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
		askEditor.render();
		addEditor.render();
		dialogInit();
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
        if(SAME_USER)	
	{
		$('#add_recipe_dialog').dialog('open');
		$('#add_recipe_dialog >.yui-skin-sam').show();
	}
	else
	{
//		var input_html = '<input type = "text"/>';
//		$('#ask_help_dialog').append(input_html);
		$('#ask_help_dialog').dialog('open');
		$('#ask_help_dialog >.yui-skin-sam').show();
		//$('.yui-skin-sam').show();
	}	
// 	$('#text_editor_dialog > p').html(editor_html);
});
});

