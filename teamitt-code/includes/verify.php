<?php

if(isset($_POST["useremail"]))
{
    $useremail = $_POST["useremail"];
    $userpassword = $_POST["userpassword"];

    if($useremail == "" || $userpassword == "")
    {
$error = 1;
    }

    else if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',$useremail)){
$error = 2;
}

else
{

$userpass = md5("password=".$userpassword);
   //If matches, check for redirect

    include("DB/initDB.php");
    include("DB/registerDB.php");
    $rDB = new registerDB();
    $id = $rDB->checkLogin($useremail, $userpass);
    if($id)
    {
    session_start();
    $sid = session_id();
    $_SESSION["teamittid"] = $id; 
    if($rDB->isAdmin($id))
	{
	$_SESSION["isAdmin"] = 1; 
	}

    if(isset($_GET["redirect"]))
    {
    $redirect = $_GET["redirect"];
    
     //Check validity of redirect url
      header("Location: $redirect");
    }
    else {
      header("Location: .");

    }
    }
    else {
    $error = 3; //Login failed
    }




}




}



?>
