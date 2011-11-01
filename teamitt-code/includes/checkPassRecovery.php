<?php 
require_once("../DB/initDB.php");
                        require_once("../DB/checkUser.php");
                        $DB = new userDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$pass=$_POST['password'];
$rtpass=$_POST['rtpassword'];
$id=$_POST['id'];
if($pass!=$rtpass){
	header("Location:../newPass.php?err=1");
}
else{
$DB->deleteRecoveryKey($id);
$password=md5("password="+$pass);
$DB->updatePass($id,$password);
header("Location:../login.php?err=2");
}
?>
