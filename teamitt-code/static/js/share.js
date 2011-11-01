$(document).ready(function()
{
	$('.share_button').live('click',share);
});
function share()
{
	
	var content_id = $(this).attr('content');
	content_id = content_id.substring(8,content_id.length);
	var share_state = $(this).attr('state');
	var type_name = $(this).attr('type');
	var link = "http://home.goalcat.com";
	
	var count = 0;
	var peopleId = new Array();
	var rewardId = new Array();
	var peopleTitle = new Array();
	var peopleImg = new Array();
	var rewardTitle = new Array();
	var rewardImg = new Array();
	$('#peopleSection').find(".activeparam").each(function(){
		peopleId[count]= $(this).attr('paramid');
		count++;
		
	});
	count = 0
	$('#peopleSection').find(".basic-title").each(function(){
		peopleTitle[count]= $(this).text();
		count++;
		
	});
	count=0;
	$('#peopleSection').find(".basic-pic").each(function(){
		peopleImg[count]= $(this).find("img").attr('src');
		count++;
		
	});
	$('#rewardSection').find(".activeparam").each(function(){
		rewardId[count]= $(this).attr('paramid');
		count++;
		
	});
	count = 0
	$('#rewardSection').find(".basic-title").each(function(){
		rewardTitle[count]= $(this).text();
		count++;
		
	});
	count=0;
	$('#rewardSection').find(".basic-pic").each(function(){
		rewardImg[count]= $(this).find("img").attr('src');
		count++;
		
	});

/*	var rewardImg = new Array();
	
	rewardImg[0] = "http://home.goalcat.com/uploads/giftimg/giftImg-"+rewardId[0]+"_avatar.jpg";
	rewardImg[1] = "http://home.goalcat.com/uploads/giftimg/giftImg-"+rewardId[1]+"_avatar.jpg";*/
	if(type_name = 'goal')
	{
		type_id = 1;
		link += "/goal.php"
		var title = $('#goal_title').text();
	}
	if(content_id)
		link += "?id="+content_id;
	var body = LOGGED_IN_USER_NAME+" shared goal on Goalcat";
	var desc = title;
	var logo = 'http://www.goalcat.com/catlogo32.png';
	var properties = {"Reward-1":rewardTitle[0] ,"Reward-2":rewardTitle[1],"Role Model-1" : peopleTitle[0],"Role Model -2":peopleTitle[1]};
	if(rewardImg.length)
		logo = "http://home.goalcat.com/"+rewardImg[0];
	logo_link = link;
	wallpost(link,body,desc,logo,properties,logo_link);
}
function wallpost(link,body,desc,logo,properties,logo_link)
{
	var actions = {name:"win free gifts", link:link};
	    FB.ui(
   {
     method: 'stream.publish',
     message: '',
     attachment: {
       name: actions.name,
       caption: body,
       description: (
         "<b>"+desc+"</b>"
       ),
       	properties:properties,
      media :[{
                      'type' : 'image',
                      'src' : logo,
			'href': logo_link
                }],
       href: 'http://home.goalcat.com'
     },
     action_links: [
       { text: actions.name , href:actions.link}
     ],
     user_message_prompt: ''
   },
   function(response) {

   }
 );

/*	var actions = {name:"win free gifts", link:link};
	FB.api('/'+LOGGED_IN_USER_ID+'/feed', 'post', { name:body, link:actions.link,  actions:actions, message:'',
			picture:logo,
			caption:actions.link,
			description: desc}, function(response) {
			if (!response || response.error) {
			alert('Error occured: ' + (response ? $H(response.error).toJSON() : 'no response!'));
			} else {
	//		alert('Post ID: ' + response.id);		
	}
	});*/
}
