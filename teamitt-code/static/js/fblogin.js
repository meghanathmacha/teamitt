	var val='i';
	var LOGGED_IN_USER_NAME;
	var LOGGED_IN_USER_EMAIL;
	var PROFILE_USER_EMAIL;
	var PROFILE_USER_NAME;
			   var LOGGED_IN_USER_ID;
	var logged_in_user_fbname;
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
				//	logged_in_user_fbname = response.name;
						setSession("enable",FB.getSession().uid);	
					greet();
				}
				else
					{			
						setSession("disable", 0);	

				}
			});
		FB.api(
		    {
		      method: 'fql.query',
		      query: 'SELECT first_name, email FROM user WHERE uid='+FB.getSession().uid
		    },
	 	    function(response) {
		           logged_in_user_fbname = response[0].first_name;

		    }
		      );
		};
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
						setSession("enable",FB.getSession().uid);	
				 //   alert(FB.getSession().uid);
  			window.location = "user_profile.php?user_fbid="+FB.getSession().uid; 
			
			//	logged_in_user_fbname = response.name;
			//	alert('You have successfully logged in, '+response.name+"!");//THIS WORKS
				
			});
			//raphaels();
		}
		function logout(){
			window.location="index.php?logout";
		}
		function friendList(){
	    	FB.api("/me/friends?fields=name,picture,id", handleFriends1);
	    	alert("friendcompany");
	   	 }
	    
		function greet(){
			FB.api('/me', function(response) {
				//friendCompany();
				//alert('Welcome, '+response.name+"!");
				//uid=response.session.uid;
				//alert(uid);
				 name = response.name;
				 email = response.email;

				 LOGGED_IN_USER_NAME = name;
				 LOGGED_IN_USER_EMAIL = email;
				 LOGGED_IN_USER_ID = FB.getSession().uid;
				//alert(name);
				//alert(email);
				
				$(function(){
				    //var session = FB.getSession();

				  //  alert(FB.getSession().uid);
				    saveuser(FB.getSession().uid, name, email);
				});
				
				
				
			});
		}
		
