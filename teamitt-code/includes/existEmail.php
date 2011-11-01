<?php
require_once("../DB/initDB.php");
                        require_once("../DB/checkUser.php");
                        $DB = new userDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$email=$_POST['email'];

// Check whether user exists
if($DB->emailExists($email)){
	echo "1";
	return;
}
echo "0";
?>
