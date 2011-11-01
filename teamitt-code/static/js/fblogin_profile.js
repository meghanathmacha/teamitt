	var val='i';
	var LOGGED_IN_USER_NAME;
	var LOGGED_IN_USER_EMAIL;
	var PROFILE_USER_EMAIL;
	var PROFILE_USER_NAME;
			   var LOGGED_IN_USER_ID;
	var SAME_USER = 0;
$(document).ready(function()
{
		window.fbAsyncInit = function() {
			FB.init({appId: '179416485403667', status: true, cookie: true, xfbml: true});

			FB.Event.subscribe('auth.login', function(response) {
				login();
			});
			FB.Event.subscribe('auth.logout', function(response) {
				logout();
			});

			FB.getLoginStatus(function(response) {
				if (response.session) {
					greet();
				if(list_post_id != '')
					wallPost(list_post_id);
				showVersity(user_fbid);
				}

			});

		};
});
/*		FB.api(
		    {
		      method: 'fql.query',
		      query: 'SELECT first_name, email FROM user WHERE uid='+FB.getSession().uid
		    },
	 	    function(response) {
		           LOGGED_IN_USER_NAME = response[0].first_name;
			   LOGGED_IN_USER_EMAIL = response[0].email;

		    }
		      );
		};*/
			function showVersity(user_fbid)
			{
				 var university_html = '';
				 var user_pic_html = '';
				 var user_name_html = '';
				 LOGGED_IN_USER_ID = FB.getSession().uid; 
				 if(user_fbid == "")
				 	user_fbid = LOGGED_IN_USER_ID;
				 var universityquery = FB.Data.query('SELECT education_history,name,pic,email,hometown_location,current_location,work_history, uid FROM user WHERE uid ='+user_fbid);
				 FB.Data.waitOn([universityquery],
						 function () {
						 FB.Array.forEach(universityquery.value,

							 function(row){
							 user_pic = row.pic;
						 user_name = row.name;
						         user_mail = row.email;
							 PROFILE_USER_EMAIL = user_mail;
							 PROFILE_USER_NAME = user_name;
							 user_pic_html += '<img src ="'+user_pic+'"></img>';
							 user_name_html += '<div class="user_name">'+user_name+'</div>';
							 steducation=row.education_history;
	
			   				 if(parseInt(LOGGED_IN_USER_ID) == parseInt(user_fbid))
							 {
								val = "Add Receipe";
								SAME_USER = 1;
//								dialogInit();
							 }
							else
							{
								val = "Ask Help";
//								dialogInit();
							}

							 if(steducation != null)
								 arr_len = steducation.length;
							 else
								arr_len = 0;
				 			university_html += '<li class="li-header">Universities</li>';
							 while(arr_len--)
							 {
							 	university_name =  steducation[arr_len]['name'];
				 				university_html += '<li>'
					           			  +'<span><a href="#" class= "university_name">'+university_name+'</a></span>'
									  +'<span> <input type="button" class = "ask_help" value= "'+val+'" /></span>'
									  +'</li>';
							 }
							});
							$('.user-pic').prepend(user_pic_html);
							$('.points').before(user_name_html);
							//$('#university_name').text(university);
							$('#nav-links').append(university_html);
							$('.points').show();
							
							 });
							 
			}
			function wallPost(list_post_id)
			{
				var badge_arr = new Array();
				badge_arr[0] = '/badges/badge1.png';
				badge_arr[1] = '/badges/badge2.png';
				badge_arr[2] = '/badges/badge3.png';
				var count = 0;
				// alert(list_post_id);
				// alert("you have been redirected to user_profile");
				var wallhtml = '';
				// var comment_query = FB.Data.query('select post_id,attribution,app_data from stream where post_id = "100000848325600_211521042219505"');
				var comment_query = FB.Data.query('select post_id,attribution,app_data from stream where post_id in' +list_post_id);
				FB.Data.waitOn([comment_query],
						function() {
						// alert(comment_query.value);
						FB.Array.forEach(comment_query.value,
							function(row){
							data = row.app_data['attachment_data'];
							data = eval('(' + data + ')');
							company_logo = data['media'][0]['src'];
							message = data['name'];
							// alert(data['name']);
							// alert(data['name']);
							index = count%3;
							wallhtml += '<div class = "wall_post"><div class = "wall_pic" ><img src="'+company_logo+'"/></div>'
							+ '<div class = "wall_message">'+message+'</div><div class="badge_pic">'
							+ '<img src = "'+badge_arr[index]+'"/></div></div>';
							count++;

							});
						$('#mainCont').append(wallhtml);
						});
			} 
		(function() {
			var e = document.createElement('script');
			e.type = 'text/javascript';
			e.src = document.location.protocol +
				'//connect.facebook.net/en_US/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		}());

		function login(){
			FB.api('/me', function(response) {
			//	alert('You have successfully logged in, '+response.name+"!");//THIS WORKS
				
			});
			//raphaels();
		}
		function logout(){
			alert('You have successfully logged out!');
		}
		function greet(){
			FB.api('/me', function(response) {
				//friendCompany();
				//alert('Welcome, '+response.name+"!");
				//uid=response.session.uid;
				//alert(uid);
			   LOGGED_IN_USER_ID = FB.getSession().uid; 
		           LOGGED_IN_USER_NAME = response.name;
			   LOGGED_IN_USER_EMAIL = response.email;
				 name = response.name;
				 email = response.email;
				//alert(name);
				//alert(email);
				
				$(function(){
				    //var session = FB.getSession();

				  //  alert(FB.getSession().uid);
				    saveuser(FB.getSession().uid, name, email);
				});
				
				
				
			});
		}
		
