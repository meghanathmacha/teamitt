
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
 if((i%6) == 0 && i != 0)
	 friend_list_html += '</tr><tr>';
 friend_list_html += '<td title = "'+friend_name+'"><img class ="friend_list_pic" src="'+friend_pic+'"></img><div id = "'+span_id+'"class ="friend_list_span"><h5>'+friend_name+'</h5></div></td>';
 if(i == (data_len - 1))
	 friend_list_html += '</tr></table>';
	
}
$('#friend_list > p').html(friend_list_html);
//$('#friend_list').dialog('open');
});

}
$(document).ready(function()
{

$(".friend_list_span").live("click",function()
{
	var span_text = $(this).text();
	var span_id = $(this).attr('id');
	var user_fbid = span_id.substring(5,(span_id.length));
	window.open('user_profile.php?user_fbid='+user_fbid);
});
});
