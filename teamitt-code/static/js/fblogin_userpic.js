	var val='i';
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
/*				 var adder_name = getfbName(adder_fbid);
				alert(adder_name);
				 var asker_name = getfbName(asker_fbid);
				 var helper_name = getfbName(helper_fbid);*/
				 stickHtml(adder_fbid,"adder_name");
				 stickHtml(asker_fbid,"asker_name");
				 stickHtml(helper_fbid,"helper_name");
				//	logged_in_user_fbname = response.name;
					greet();
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
	function stickHtml(user_fbid,class_name)
	{
		FB.api(
		    {
		      method: 'fql.query',
		      query: 'SELECT name FROM user WHERE uid='+user_fbid
		    },
	 	    function(response) {
		           user_name = response[0].name;
			 content = user_name;   
			$('.'+class_name).html(content);

		    }
			
		      );
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
			//	logged_in_user_fbname = response.name;
			//	alert('You have successfully logged in, '+response.name+"!");//THIS WORKS
				
			});
			//raphaels();
		}
		function logout(){
			alert('You have successfully logged out!');
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
				//alert(name);
				//alert(email);
				
				$(function(){
				    //var session = FB.getSession();

				  //  alert(FB.getSession().uid);
				    saveuser(FB.getSession().uid, name, email);
				});
				
				
				
			});
		}
		