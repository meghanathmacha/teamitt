<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<title>Nettuts.com | Login</title>  
<link rel="stylesheet" type="text/css" media="All" href="css/style.css" />  
</head>  
<body>  

<div id="wrap">  

<?php   

mysql_connect("localhost", "root", "nitesh") or die(mysql_error());  
mysql_select_db("paypal") or die(mysql_error());  

if(isset($_POST['email']) && isset($_POST['password'])){  

	// Verify  

	$email = mysql_escape_string($_POST['email']);  
	$password = md5($_POST['password']);  

	$gUser = mysql_query("SELECT * FROM users WHERE email='".$email."' AND password='".$password."' LIMIT 1") or die(mysql_error());  
	$verify = mysql_num_rows($gUser);  

	if($verify > 0){  
		echo '<h3>Login Complete</h3> 
			<p>Click here to download our program</p>';  
	}else{  
		echo '<h3>Login Failed</h3> 
			<p>Sorry your login credentials are incorrect.';  
	}  

}else{  
	?>  

		<h3>Login</h3>  
		<p>Please enter your login credentials to get access to the download area</p>  

		<form method="post" action="" >  
		<fieldset>  
		<label for="email">Email:</label><input type="text" name="email" value="" />  
		<label for="password">Password:</label><input type="text" name="password" value="" />  
		<input type="submit" value="Login" />  
		</fieldset>  
		</form>  

		<?php  
}  
?>  

</div>  

</body>  
</html>  
