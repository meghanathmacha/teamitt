
function sortByName(a, b) {
    var x = a.name.toLowerCase();
    var y = b.name.toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}
function show_friend_list()
{
 ARR_INDX = 0;
FB.api("/me/friends?fields=name,picture,id", function(response){
 
var  friend_data = response.data.sort(sortByName);
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
 if((i%15) == 0 && i != 0)
	 friend_list_html += '</tr><tr>';
 friend_list_html += '<td title = "'+friend_name+'"><img class ="friend_list_pic" src="'+friend_pic+'"></img><span id = "'+span_id+'"class ="friend_list_span">Ask</span></td>';
 if(i == (data_len - 1))
	 friend_list_html += '</tr></table>';
	
}
var val=FB.getSession().uid;
$.post("includes/linkedin_friend_selector.php",{ fbid : val },function(data){
var str='';
var data_length=data.length;
for(i = 0 ; i < data_length ; i++)
{

 conn_userid = data[i].user_id;
 conn_first_name = data[i].first_name;
 conn_last_name = data[i].last_name;
 conn_img = data[i].img_url;
 if(i ==0){
 str += '<table class = "friend_list_table"><tr>';
 }
 if((i%15) == 0 && i != 0){
 str += '</tr><tr>';
 }
 str += '<td title = "'+conn_first_name+'"><img class ="friend_list_pic" width="50px" src="'+conn_img+'"></img><span id = "'+conn_userid+'" class ="friend_list_linkedin_span">Ask</span></td>';
 if(i == (data_length - 1))
 str += '</tr></table>';

 }
//alert(str);
$('#linkedin_friend_list > p').html(str);
},"json");
$('#friend_list > p').html(friend_list_html);
});
//$('#friend_list').dialog('open');

}
$(document).ready(function()
{

$(".friend_list_span").live("click",function()
{
	var span_text = $(this).text();
	var span_id = $(this).attr('id');
	var user_fbid = span_id.substring(5,(span_id.length));
	window.location = 'http://startups.goalcat.com/user_profile.php?user_fbid='+user_fbid;
});
$(".friend_list_linkedin_span").live("click",function()
{
//	var span_text = $(this).text();
	var span_id = $(this).attr('id');
//	var user_fbid = span_id.substring(5,(span_id.length));
	window.location = 'http://startups.goalcat.com/temp_profile.php?user_linkedinid='+span_id;
});
});
