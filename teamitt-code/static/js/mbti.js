$("document").ready(function () {


$(".mbti-icons a").click(function () {


type=$(this).attr("mtype");
url="includes/getMbtiProp.php";
url = url + "?mtype=" + type;
result_cont = $("#show_" + type);
if(result_cont.is(":visible"))
{
result_cont.fadeOut();
$(this).removeClass("opened").addClass("closed");
}
else
{
result_cont.html("<h3>Loading...</h3>").fadeIn();
result_cont.load(url);
$(this).removeClass("closed").addClass("opened");
}

return false;

});

$(".close-mbti").click(function () {


$(".mbti-result").slideUp();

});

/*function hello
{
alert("hello");
}*/


function deleteComment()
{
	var parent_id = $(this).parents('.help_answer').attr('id');
	var comment_id = parent_id.substring(8,(parent_id.length));
	var reply_data={
	comment_id:comment_id,
	deleteComment:1,
	}
	$.ajax({
	type: "POST",
	url: "includes/mbti_comment.php",
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

$('.mbti_comment').live('click',show_comm_form);

function show_comm_form()
{

	var thisItem = this;
	var mbtisent_id = $(this).parents('.mbti_sent').attr('id');
	
var itemFound = $('#'+mbtisent_id).find('.mbti_show_comm').html();
if(itemFound == undefined)
{
content_html = "<div class='mbti_show_comm'>";
content_html += "<textarea rows='1' cols='10' id='mbti_comm_post' name='mbti_comm_post' placeholder='Enter your comment...'></textarea>";
content_html +=  "</div>";
content_html +=	"<div class='add_answer_div'><input type='button' class='add_help_answer' value='Comment'/></div>" ;
$('#'+mbtisent_id).find('.editor:last').append(content_html);
}
//alert(mbtisent_id);
} 
function likeMe()
{
	var thisItem = this;
	var mbtisent_id = $(this).parents('.mbti_sent').attr('id');
//	var feed_id = parent_id.substring(5,(parent_id.length));
	var reply_data={
	mbtisent_id:mbtisent_id,
	like:1,
	}
	$.ajax({
	type: "POST",
	url: "includes/mbti_comment.php",
//	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
		

	if(data != '0')
	{
	$(thisItem).text('Liked');
	$(thisItem).attr('class','unlike_button');
	var like_count = $('#'+mbtisent_id).find('.likes').attr('id');
	if(like_count == undefined)
	{
		like_html = '<div id = "like_1" class = "likes">';
		like_html += '<span class = "first"><a href = "profile.php?id='+LOGGED_IN_USER_ID+'"><span class = "feed_data"> you </span></a> </span>';
		like_html += 'liked this </div>';
		$('#'+mbtisent_id).find('.editor:first').before(like_html);

	}
	else
	{
			like_html = '<span class = "first"><a href = "profile.php?id='+LOGGED_IN_USER_ID+'"><span class = "feed_data"> you </span></a> </span>';
		
		like_count = like_count.substring(5,(like_count.length));
		like_count = parseInt(like_count);
		like_count++;
		$('#'+mbtisent_id).find('.likes').attr('id','like_'+like_count);
		if(like_count == 2)
		{
			$('#'+mbtisent_id).find('.likes').children('.first').attr('class','second');
			$('#'+mbtisent_id).find('.likes').children('.second').find(".conj").text("and");
		}
		if(like_count == 3)
		{
			$('#'+mbtisent_id).find('.likes').children('.second').attr('class','third');
			$('#'+mbtisent_id).find('.likes').children('.third').find(".conj").text("and");
			$('#'+mbtisent_id).find('.likes').children('.first').attr('class','second');
			$('#'+mbtisent_id).find('.likes').children('.second').find(".conj").text(",");
		}
		if(like_count > 3)
		{
			$('#'+mbtisent_id).find('.likes').children('.third').attr('class','forth');
			$('#'+mbtisent_id).find('.likes').children('.forth').find(".conj").text("and");
			$('#'+mbtisent_id).find('.likes').children('.second').attr('class','third');
			$('#'+mbtisent_id).find('.likes').children('.third').find(".conj").text(",");
			$('#'+mbtisent_id).find('.likes').children('.first').attr('class','second');
			$('#'+mbtisent_id).find('.likes').children('.second').find(".conj").text(",");
		}
		$('#'+mbtisent_id).find('.likes').prepend(like_html);
		
	}
}
}
});

}	
$('.mbti_like').live('click',likeMe); 
/*$(".mbti_like").click(function(){

});*/

$('.mbti_comment_delete').live('click',deleteComment);
$(".add_help_answer").live('click',add_help_answer);
function add_help_answer()
{

	var content = $(this).parent().prevAll('.mbti_show_comm').find('#mbti_comm_post').val();
	var comment_id;
	str = jQuery.trim(content);
	if(str == '')
		return 0;
	$(this).parent().prevAll('.mbti_show_comm').find('#mbti_comm_post').val('');
	var sent_id = $(this).parents('.mbti_sent').attr('id');
	
	var reply_data = {
		body:content,
		sent_id:sent_id,
		comment:1,
	}
	$.ajax({
	type: "POST",
	url: "includes/mbti_comment.php",
	dataType: "json",
	data:reply_data, 	
	timeout:10000,
	error :function() {},
	success:function(data){
	//alert(data);
	comment_id = data;
	
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
	$('#'+sent_id).find(".comments").append(content_html);
}
	});
        //$(this).parent().append(content_html);
}




});
/*$("#mbti_comm_post").bind('keypress',function(e){
        if(e.which==13){

	alert("nitin");
                // Enter pressed... do anything here...
                         }
});*/

function showMBTIProp(){
$('#feedCont').hide();
$('#moreCont').hide();
$('#mbti-query').show();
$("a[mtype='st']").trigger("click");
}
