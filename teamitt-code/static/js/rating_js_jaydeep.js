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
	'/includes/ratings_goalcat.php',
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
				var company_logo = $(this).parents('.desc').prev().find('img').attr('src');
				var rating_attr = widget_id.split(".");
				var domain_name = rating_attr[0];
				var domain_attribute = rating_attr[1];
				
				var clicked_data = {
clicked_on : $(star).attr('class'),
widget_id : $(star).parent().attr('id'),
user_id : $(star).parent().attr('rater_fbid')
};
$.post(
	'/includes/ratings_goalcat.php',
	clicked_data,
	function(INFO) {
	widget.data( 'fsr', INFO );
	set_votes(widget);
	},
	'json'
      );
wallPost(user_id,domain_name,domain_attribute,rating,company_logo);
});

function wallPost(user_fbid,domain_name,attribute,rating,company_logo)
{
	body = "you have given "+rating+" stars to "+ attribute +" department of "+ domain_name;
	alert(body);
//	alert(user_id);
	
//	body =  "is asking for "+attribute+" rating at your " + domain + " " + domain_value;    

	var response_value = rating;
	var domain_value_fbid = domain_name;
	var domain = "company";
	var action =  "wallpost";
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
			 url: "/includes/save_action.php",
			 dataType: "html",
		         data:"user_fbid="+user_fbid+"&post_id="+post_id+"&domain_value_fbid="+domain_value_fbid+"&response_value="+response_value+"&domain="+domain+"&attribute="+attribute+"&action="+action+"&friend_fbid="+friend_fbid,
                	 success:function(msg){
			if(msg != 1)
				alert("Database error occured");
}
		});

//			saveaction(response.id, fbid, domain_value_fbid , response_value ,domain, attribute, 'wallpost');
}
});
}
/*			 $('.action_user').show();
			var data = $('.action_user').text();
			 $('.action_user').hide();
//			var data  = '<?php echo $data ?>';
			data = eval('(' + data + ')');
			var data_len = data.length;
			var i = data_len -1;
			var company_name,list_user_fbid;
//			alert(data[i]);
			makeWall(data[i],function(){alert("success");});
		function makeWall(data , success)
		{
				var flag = 0;
//				alert(data);
				company_name = String(data["company_name"]);
				list_user_fbid = String(data["user_fbid"]);
//						$('.action_users').html("hello");
			var action_user_html = '<table><tr>';
//				setTimeout(10000);
//							alert(list_user_fbid);
			var user_query = FB.Data.query('SELECT name, pic_square, uid FROM user WHERE uid in '+list_user_fbid);
			FB.Data.waitOn([user_query],
					function () {
					FB.Array.forEach(user_query.value, 
						function(row){
					action_user_html += '<td><img src="'+row.pic_square+'"></img></td>'; 
//					$('.action_users').append(action_user_html);

						});
						action_user_html += '</tr></table>';
						alert(company_name);
						$('.action_users').html(action_user_html);
						success();
		});
}*/

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
