$("document").ready(function(){

$(".goal-mbti-icons a").click(function () {


type=$(this).attr("gmtype");

url="./includes/goal_mbti.php"; url = url + "?gmtype=" + type;

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

$('.mbti_like').live('click',likeMe); // when the like button is clicked the 'likeMe' function is called 
$(".add_help_answer").live('click',add_help_answer);
$('.mbti_comment_delete').live('click',deleteComment);
$('.mbti_comment').live('click',show_comm_form);

// LIKE SECTION CODE ************************************
function likeMe() 
{	// 'id' here is the goaltipsID or goalchecklistID. 
	var thisItem = this;
        var list=$(this).parents('.data').attr('id'); 

//alert(list); 
	if (list=='tip') 
	{	
		var mbtisent_id = $(this).parents('.goal_mbti_tip').attr('id');
 		var type=$(this).parents('.goal_mbti_tip').attr('title'); // to check whether the Like is ona tip or checklist item
	}
	if (list=='checklist') 
	{	var mbtisent_id = $(this).parents('.goal_mbti_checklist').attr('id');
                var type=$(this).parents('.goal_mbti_checklist').attr('title'); 
	}	
//alert(mbtisent_id); 
	var reply_data=
	{
        	mbtisent_id:mbtisent_id,
        	like:1,
		//type:type,
		list:list,
        }
	$.ajax(
	{
        	type: "POST",
        	url: "includes/goal_mbti_LikeComment.php",
		dataType: "json",
        	data:reply_data,
        	timeout:10000,
	        error :function() {},
        	success:function(data)
		{//	if (list=='checklist')
		//		alert(data); 
			if (data==1) 
			{	//alert("already exists"); 	
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
// END LIKE SECTION *************************************


// COMMENTS SECTION CODE ********************************
// Showing comment form on clicking the comment link

function show_comm_form()
{

        var thisItem = this;

// CHECK 
//        var mbtisent_id = $(this).parents('.goal_mbti_tip').attr('id');
        var list=$(this).parents('.data').attr('id');
	if (list=='tip')
        {       var mbtisent_id = $(this).parents('.goal_mbti_tip').attr('id');
//                var type=$(this).parents('.goal_mbti_tip').attr('title'); // to check whether the Like is ona tip or checklist item
        }
        if (list=='checklist')
        {       var mbtisent_id = $(this).parents('.goal_mbti_checklist').attr('id');
//                var type=$(this).parents('.goal_mbti_checklist').attr('title');
	}
// alert(list); 

	var itemFound = $('#'+mbtisent_id).find('.mbti_show_comm').html();
	if(itemFound == undefined)
	{
		content_html = "<div class='mbti_show_comm'>";
		content_html += "<textarea rows='1' cols='10' id='mbti_comm_post' name='mbti_comm_post' placeholder='Enter your comment...'></textarea>";
		content_html +=  "</div>";
		content_html += "<div class='add_answer_div'><input type='button' class='add_help_answer' value='Comment'/></div>" ;
		$('#'+mbtisent_id).find('.editor:last').append(content_html);
	}
//alert(mbtisent_id);
}

// Adding a new comment on the goal to the DB 

function add_help_answer()
		{
	var content = $(this).parent().prevAll('.mbti_show_comm').find('#mbti_comm_post').val();
        var comment_id;
        str = jQuery.trim(content);
        if(str == '')
                return 0;
        $(this).parent().prevAll('.mbti_show_comm').find('#mbti_comm_post').val('');

// CHECK
	var list=$(this).parents('.data').attr('id');
        if (list=='tip')
        {       var mbtisent_id = $(this).parents('.goal_mbti_tip').attr('id');
//                var type=$(this).parents('.goal_mbti_tip').attr('title'); // to check whether the Like is ona tip or checklist item
        }
        if (list=='checklist')
        {       var mbtisent_id = $(this).parents('.goal_mbti_checklist').attr('id');
//                var type=$(this).parents('.goal_mbti_checklist').attr('title');
	} 
//alert(type) ; 
//alert(mbtisent_id); 
	
	var reply_data = 
	{       body:content,
                sent_id:mbtisent_id,
                comment:1,
//		type:type, 
		list:list,						
        }

	$.ajax({
        type: "POST",
        url: "includes/goal_mbti_LikeComment.php",
        dataType: "json",
        data:reply_data,
        timeout:10000,
        error :function() {},
        success:function(data)
	{
		comment_id = data;
//		alert(comment_id);
	//	comment_id=1;  
		var replier_profile = "profile.php?id="+LOGGED_IN_USER_ID;
	        var replier_pic = "uploads/profileimg/profileimg-"+LOGGED_IN_USER_ID+".jpg";
		$.ajax({
			url:replier_pic,
		        type:'HEAD',
			error: function(){
      			replier_pic = "static/images/ambitions.png";
        		},
            		success:function(){}
			}); 
		var content_html = '<div id = "comment_'+comment_id+'" class="help_answer">';
	        content_html+= '<span class = "comment_delete cross"> X </span>';
        	content_html += '<div class="pic_answer"><a href = "'+replier_profile+'"><img src="'+replier_pic+'"/></a></div><div class = "help_answer_text"><p class="feed_data">You</p>'+content+'</div><div class="clr"></div></div>';
        	$('#'+mbtisent_id).find(".comments").append(content_html);
	} 
	});	

} // END OF FUNCTION add_help_answer 

// Deleting a comment 

function deleteComment()
{
        var parent_id = $(this).parents('.help_answer').attr('id');
        var comment_id = parent_id.substring(8,(parent_id.length));
	var list=$(this).parents('.data').attr('id');
        if (list=='tip')
        {       
                var type=$(this).parents('.goal_mbti_tip').attr('title'); // to check whether the Like is ona tip or checklist item
        }
        if (list=='checklist')
        {       
                var type=$(this).parents('.goal_mbti_checklist').attr('title');
	}
// CHECK 
//alert(comment_id);
//alert(type); 
        var reply_data={
        comment_id:comment_id,
        deleteComment:1,
//	type:type, 
	list:list,
        }
        $.ajax({
        type: "POST",
        url: "includes/goal_mbti_LikeComment.php",
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




// END COMMENTS SECTION ***********************************


});

function showGoalprop(){ 
$('#GoalFeedCont').show();
$('#goal-mbti-query').hide();
$('#file_section').hide();
} 

function showGoalMBTIprop(){
$('#GoalFeedCont').hide();
$('#goal-mbti-query').show(); 
$('#file_section').hide();
}


