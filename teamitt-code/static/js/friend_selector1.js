var FRIEND_DATA;
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
FRIEND_DATA = friend_data;
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
	 friend_list_html += '<div class = "friend_list_table">';
/* if((i%6) == 0 && i != 0)
	 friend_list_html += '</tr><tr>';*/
 friend_list_html += '<div class  = "friend_window" title = "'+friend_name+'"><img class ="friend_list_pic" src="'+friend_pic+'"></img><div id = "'+span_id+'"class ="friend_list_span"><h5>'+friend_name+'</h5></div></div>';
 if(i == (data_len - 1))
	 friend_list_html += '</div>';
	
}
$('#friend_list > p').html(friend_list_html);
$.getJSON("includes/top_helper.php",showTopHelpers);
//$('#friend_list').dialog('open');
});

}
function showTopHelpers(rows)
{
		rows_len = rows.length;
		var tophelpers_html = '<div class = "top_helper_header"><p>Your Top Helper Friends </p> </div>';
		for(i = 0 ; i < rows_len ; i++)
		{
			row = rows[i];
			var top_helper_fbid  = row['action_by'];
			var data_len = FRIEND_DATA.length;
			for(j = 0 ; j < data_len ; j++)
			{
				 friend_fbid  = FRIEND_DATA[j].id;
				 if(top_helper_fbid == friend_fbid)
				 {
					var top_helper_name = row['facebook_name'];
					var top_helper_points = row['total_points'];
					var top_helper_pic = "https://graph.facebook.com/"+top_helper_fbid+"/picture";
					var top_helper_profile = "user_profile.php?user_fbid="+top_helper_fbid;
				        tophelpers_html += "<div class='top_helper'><div class='top_helper_img'><a href ='"+top_helper_profile+"'><img src = '"+top_helper_pic+"' /></a>"
				  			+  "</div><div class='top_helper_name'><p>"+top_helper_name+"</p><p>(Points:"+top_helper_points+")</p></div></div>";	 
				 }
			}
		}
		$('#leftCont').html(tophelpers_html);
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
