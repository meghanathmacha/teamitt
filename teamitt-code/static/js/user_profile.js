
$('.action_user').find('img').live('click',function()
{
rater_fbid = $(this).attr('class');
user_fbid=getid();
if(!user_fbid)
{
FB.login(function(response) {
  if (response.session) {
 if (response.perms) {
user_fbid = FB.getSession().uid; 
window.location = "user_profile.php?user_fbid="+rater_fbid;

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
window.location = "user_profile.php?user_fbid="+rater_fbid;
}
});
