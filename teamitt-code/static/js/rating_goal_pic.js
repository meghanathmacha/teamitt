function showrating(company)
{
var company=company.replace(".","");
var company=company.replace(" ","");
var company=company.replace("(","");
var company=company.replace(")","");
if(company.length > 10)
var company=company.substring(0,10);
$('#rat'+company).show();
$('#univ'+company).hide();
$('#invest'+company).hide();
}

function showTop()
{

var txt=$("#downchange").html();
$("#topchange").html(txt);


}

$(document).ready(function(){

showTop();




		$('.rate_widget').each(function(i) {
			var widget = this;
			var out_data = {
widget_id : $(widget).attr('id'),
fetch: 1
};
$.post(
	'/includes/ratings_goal_goalcat.php',
	out_data,
	function(INFO) {
	$(widget).data( 'fsr', INFO );
	set_votes(widget);
	},
	'json'
      );
});

		$(".ratings_stars").live("mouseover mouseout", function(event) {
			if (event.type== 'mouseover')
			{
			$(this).prevAll().andSelf().addClass('ratings_over');
			$(this).nextAll().removeClass('ratings_vote');
			}
			else
			{
			$(this).prevAll().andSelf().removeClass('ratings_over');
			set_votes($(this).parent());
			}
			}
			);
		
$('#dialog').dialog({
autoOpen: false,
width: 350,
height: 200,
/*buttons: {
},
"Cancel": function() {
$(this).dialog("close");
}
}*/
});

	$('.addDream').live('click',function()
	{
		var domain_name = $(this).parent().children('p').text();
		var user_fbid = FB.getSession().uid;
		var company_logo = $(this).parent().nextAll('.image').find('.cont').find('img').attr('src');	
		wallPost(user_fbid,domain_name,null,null,company_logo,"dream_job_post");
		
	});
		$('.ratings_stars').live("click", function() {
				var star = this;
				var widget = $(this).parent();
				widget_id = $(star).parent().attr('id');
				user_id = $(star).parent().attr('rater_fbid');
				user_id = FB.getSession().uid;
				var clicked_on = $(star).attr('class');
				var rating = clicked_on.split(" ");
				rating = rating[0].split("_");
				rating = rating[1];
				var company_logo = $(this).parents('.desc').prevAll('.image').find('.cont').find('img').attr('src');
				var rating_attr = widget_id.split(".");
				var domain_name = rating_attr[0];
				var domain_attribute = rating_attr[1];
				
				var clicked_data = {
clicked_on : $(star).attr('class'),
widget_id : $(star).parent().attr('id'),
user_id : $(star).parent().attr('rater_fbid')
};
$.post(
	'/includes/ratings_goal_goalcat.php',
	clicked_data,
	function(INFO) {
	widget.data( 'fsr', INFO );
	set_votes(widget);
	},
	'json'
      );
wallPost(user_id,domain_name,domain_attribute,rating,company_logo,"wallpost",widget_id);
});

function wallPost(user_fbid,domain_name,attribute,rating,company_logo,action,widget_id)
{
	attribute = attribute || '';
	rating = rating || 0;
	
	if(action == 'wallpost')
		body = "you have given "+rating+" stars to "+ attribute +" department of "+ domain_name;
	else
		body = domain_name+"is my dream company.what is yours....?";
	$('#dialog > p').html(body);
	$('#dialog').dialog('open');		
//	alert(body);
//	alert(user_id);
	
//	body =  "is asking for "+attribute+" rating at your " + domain + " " + domain_value;    
	var response_value = rating;
	var domain_value_fbid = domain_name;
	var domain = "company";
//	var action =  "wallpost";
	var friend_fbid = "none";
//	var desc = FB.user_infos ? FB.user_infos.first_name : '';
	var desc = ' uses goalcat to help friends and get help from friends and win rewards';
//	var actions = {name:"win free gifts", link:"http://www.goalcat.com/index_27.php?friend_id="+fbid+"&facebook_id="+user_fb_id+"&domain_value_fbid="+domain_value_fbid+"&attribute="+attribute+"&domain="+domain+"&domain_value="+domain_value}

	var actions = {name:"win free gifts", link:"http://goalcat.com"};
	FB.api('/'+user_fbid+'/feed', 'post', { name:body, link:actions.link,  actions:actions, message:'',
			picture:company_logo,
			caption:actions.link,
			description: desc}, function(response) {
			if (!response || response.error) {
			alert('Error occured: ' + (response ? $H(response.error).toJSON() : 'no response!'));
			} else {
			//alert('Post ID: ' + response.id);			
			var post_id = response.id;
			 $.ajax({
  			 type: "POST",
			 url: "/includes/save_goals_action.php",
			 dataType: "html",
		         data:"user_fbid="+user_fbid+"&post_id="+post_id+"&domain_value_fbid="+domain_value_fbid+"&response_value="+response_value+"&domain="+domain+"&attribute="+attribute+"&action="+action+"&friend_fbid="+friend_fbid+"&goal="+widget_id,
                	 success:function(msg){
			if(msg != 1)
				alert("Database error occured");
			else
			{
			       showRater(domain_name ,user_fbid);
			}
		}
		});

//			saveaction(response.id, fbid, domain_value_fbid , response_value ,domain, attribute, 'wallpost');
}
});

}
function showRater(domain_name ,user_fbid)
{
	
			/* To add rater_user dynamically in the list ,added by Jaydeep */
				var action_divid = 'action_'+domain_name;
				//	alert(action_divid);			
				var flag = 1;
				$('#'+action_divid).find('td').each(function()
				{
			
				var img_src =  $(this).children('img').attr('src');
				if(img_src.indexOf(user_fbid) != -1)
					flag = 0;

				});

				if(flag)
				{
					var table_html = $('#'+action_divid).children('table').html();
				//	alert(table_html);			
					var new_company = 0;
					var user_actionhtml = '<td><img src = "http://graph.facebook.com/'+user_fbid+'/picture"></img></td>';
					if(table_html == null)
					{
						new_company = 1;
				//		alert(table_html);			
					}
					if(new_company)
					{
			 			user_actionhtml = '<table><tr>'+user_actionhtml+'</tr></table>';
						$('#'+action_divid).html(user_actionhtml);
					}
					else if(!new_company)
					{
						$('#'+action_divid).find('td').last().after(user_actionhtml);
					}
						
				}
		
}
function set_votes(widget) {
	var avg = $(widget).data('fsr').whole_avg;
	var votes = $(widget).data('fsr').number_votes;
	var exact = $(widget).data('fsr').dec_avg;
	window.console && console.log('and now in set_votes, it thinks the fsr is ' + $(widget).data('fsr').number_votes);
	$(widget).find('.star_' + avg).prevAll().andSelf().addClass('ratings_vote');
	$(widget).find('.star_' + avg).nextAll().removeClass('ratings_vote');
	$(widget).find('.total_votes').text( votes + ' votes recorded (' + exact + ' rating)' );
}



});
