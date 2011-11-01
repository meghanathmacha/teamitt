function showquotes(id)
{
$('#pop-up-body').load('quotes_goal.php?id='+id,function()
{
$('#pop-up-body').show();
});
}

function hidepopup()
{
$('#pop-up').hide();
}

function gift_goodie(count,owner,goal_id,goodie_id)
{
var goodie_src=$('#goodie_img_'+count).attr('src');
var login_id=FB.getSession().uid;
var goal_title=$('#goal_title').html();
var profile_url= "user_profile.php?user_fbid="+login_id;
 var fpic = "http://graph.facebook.com/"+login_id+"/picture";
$.post('insert_points.php?id='+login_id+'&goodie_id='+goodie_id+'&goal_id='+goal_id+'&action_for='+owner);
var quote=$('#goodie_'+count).html();
$('#mainCont').append('<div  class = "wall_post"><div class = "wall_pic" ><a href = "'+profile_url+'"><img src="'+fpic+'"/></a></div><div class = "wall_help_message"><h3>Has Gifted '+quote+'</h3><img src="'+goodie_src+'" style="width:50px;height:50px;"/></div></div>');

 var domain = "company";
        var friend_fbid = owner;
        var extend_quote="Gifted the    '"+ quote +"' For the Goal '"+goal_title +"'";
        var desc = ' uses goalcat to help friends and get help from friends and win rewards';
        var  company_logo =  'http://home.goalcat.com/'+goodie_src;
        var message=quote;
        var actions = {name:"win free gifts", link:"http://goalcat.com"};
        var body;
        var user_fbid='';
        body="Has Gifted you the";
        FB.api('/me/feed', 'post', { name:extend_quote, link:actions.link,  actions:actions, message:'',
                        picture:company_logo,
                        caption:actions.link,
                        description: desc}, function(response) {
  if (!response || response.error) {
  } else {
  }
});
        var extend_quote="Has Gifted You the    '"+ quote +"' For the Goal '"+goal_title+"'";
 FB.api('/'+friend_fbid+'/feed', 'post', { name:extend_quote, link:actions.link,  actions:actions, message:'',
                        picture:company_logo,
                        caption:actions.link,
                        description: desc}, function(response) {
  if (!response || response.error) {
  } else {
  }
});

}

