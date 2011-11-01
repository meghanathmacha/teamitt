$(document).ready(function(){
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

function wallPost(user_id,domain_name,domain_attribute,rating,company_logo)
{
	body = "you have given "+rating+" stars to "+ domain_attribute +" department of "+ domain_name;
	alert(body);
	alert(user_id);
	
//	body =  "is asking for "+attribute+" rating at your " + domain + " " + domain_value;    

	response_value = rating;
//	var desc = FB.user_infos ? FB.user_infos.first_name : '';
	var desc = ' uses goalcat to help friends and get help from friends and win rewards';
//	var actions = {name:"win free gifts", link:"http://www.goalcat.com/index_27.php?friend_id="+fbid+"&facebook_id="+user_fb_id+"&domain_value_fbid="+domain_value_fbid+"&attribute="+attribute+"&domain="+domain+"&domain_value="+domain_value}

	var actions = {name:"win free gifts", link:"http://ec2-50-19-250-116.compute-1.amazonaws.com/pages.php"};
	FB.api('/'+user_id+'/feed', 'post', { name:body, link:actions.link,  actions:actions, message:'',
			picture:'http://www.goalcat.com/catlogo32.png',
			caption:actions.link,
			description: desc}, function(response) {
			if (!response || response.error) {
			alert('Error occured: ' + (response ? $H(response.error).toJSON() : 'no response!'));
			} else {
			alert('Post ID: ' + response.id);


//			saveaction(response.id, fbid, domain_value_fbid , response_value ,domain, attribute, 'wallpost');
}
});

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
