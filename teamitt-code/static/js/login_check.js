$(document).ready(function(){

$('#header-links').find('.nav a').live('click',loginCheck);
$('.attend_share_col a').live('click',loginCheck);
});
function loginCheck()
{
event.preventDefault();
//rater_fbid = $(this).attr('class');
user_fbid = FB.getSession();
if(user_fbid == null)
	user_fbid = 0;
var href = $(this).attr('href');
/*if(href == undefined)
	href = url.href;*/
if(!user_fbid)
{
FB.login(function(response) {
  if (response.session) {
 if (response.perms) {
user_fbid = FB.getSession().uid; 
setSession("enable",FB.getSession().uid);	
greet();
//$(this).trigger();
//window.parent.location.href= href;
window.location = href;
//window.open(href);

      // user is logged in and granted some permissions.
            // perms is a comma separated list of granted permissions
                } else {
			
					user_fbid=0;
                      // user is logged in, but did not grant any permissions
                          }
                             } else {
					user_fbid=0;
                                // user is not logged in
                                   }
                                   }, {perms:'email,user_birthday,status_update,publish_stream,user_photos,user_events,friends_events,user_groups,friends_groups,user_activities,friends_activities,user_photos,friends_photos,user_photo_video_tags,friends_photo_video_tags,offline_access'});
}
else
{
//$(this).trigger();
window.location = href;
//window.parent.location.href= href;
//window.open(href);
}
}
