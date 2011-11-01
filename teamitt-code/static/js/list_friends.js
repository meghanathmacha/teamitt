
function show_friend_list()
{
 ARR_INDX = 0;
FB.api("/me/friends?fields=name,picture,id", function(response){
 
var  friend_data = response.data;
var data_len = friend_data.length;
var friend_list_html = '';
//data_len = 5;
for(i = 0 ; i < data_len ; i++)
{
 friend_pic = friend_data[i].picture;
 friend_name = friend_data[i].name;
 friend_fbid  = friend_data[i].id;
 span_id = "fb_id"+friend_fbid;
 if(i ==0)
	 friend_list_html += '<table class = "friend_list_table"><tr>';
 if((i%5) == 0 && i != 0)
	 friend_list_html += '</tr><tr>';
 friend_list_html += '<td><img class ="friend_list_pic" src="'+friend_pic+'"></img><span id = "'+span_id+'"class ="friend_list_span">Add</span></td>';
 if(i == (data_len - 1))
	 friend_list_html += '</tr></table>';
	
}
$('#friend_list > p').html(friend_list_html);
$('#friend_list').dialog('open');
});

}
$(document).ready(function()
{
var FRND_ARR = new Array();
var ARR_INDX = 0;
$('#friend_list').dialog({
autoOpen: false,
width: 350,
height: 500,
buttons: {
  "Post": function() {
		var image_id = parseInt(QUES_ID);
		if(QUES_ID == 1)
			var image_id = parseInt(QUES_ID) + 63;
		else
			var image_id = parseInt(QUES_ID) + 22;
		
		var logo = "http://startups.goalcat.com/cache/image"+image_id+".jpg";
 for(i = 0 ; i < ARR_INDX ; i++)
 {
	if(FRND_ARR[i] != "0")
	{
		user_fbid = FRND_ARR[i];
		wallPost(user_fbid,null,null,null,logo,"pollPost");
	}
 }
		user_fbid = FB.getSession().uid;
		wallPost(user_fbid,null,null,null,logo,"pollPost");
		var popup_msg = "Successfully posted";
		$('#dialog > p').html(popup_msg);
		$('#dialog').dialog('open');
//  alert(FRND_ARR);
  $(this).dialog("close");
  },
  "Cancel": function() {
  $(this).dialog("close");
  }
  }
});
//$('.poll_header').click(show_friend_list);
$(".friend_list_span").live("click",function()
{
	var span_text = $(this).text();
	var span_id = $(this).attr('id');
	var user_fbid = span_id.substring(5,(span_id.length));
	if(span_text == 'Add')
	{
	FRND_ARR[ARR_INDX] = user_fbid;                               //Here you can apply good alogrithm like Binary Heap.
//	alert(user_fbid);
	ARR_INDX++;
	$(this).text("Del");
//	$(this).parents('.friend_list_pic').css({"opacity:0.8"});
	}
	else
	{
	for(i = 0 ; i < ARR_INDX ; i++)
	{
		if(FRND_ARR[i] == user_fbid)
		{	
			FRND_ARR[i] = '0';
		}
	}
	$(this).text("Add");
//	$(this).parents('.friend_list_pic').css({"opacity:1"});
	
	}
//	alert(FRND_ARR);
	
});
});
