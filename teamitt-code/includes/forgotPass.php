<?php

if(isset($_POST["useremail"]))
{
    include("DB/initDB.php");
    include("DB/registerDB.php");
    $rDB = new registerDB();
    $useremail = $_POST["useremail"];

    if($useremail == "")
    {
$error = 1;
    }

    else if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',$useremail)){
$error = 2;
}

else if(!($uid = $rDB->checkExistingUser($useremail)))
{
$error = 3;
}
else if(!$rDB-> IfUserActivated($useremail))
{
$error = 4;
}
else
{
$key = "Recovery@Teamitt".$email.time();
$key = md5("key=".$key);

if($rDB->insertRecoveryKey($uid,$key))
{



$error=0;
}
else
{
$error=6;
}

}







}



?>
