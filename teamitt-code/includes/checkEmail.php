<?php
require_once("../DB/initDB.php");
                        require_once("../DB/registerDB.php");
                        $rDB = new registerDB();
                        if(!$rDB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$email=$_POST['email'];
if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',$email)){
	echo "1";
	return;
}

// Filtering out email ids


$temp=split('@',$email);
$domain=$temp[1];
if($rDB->checkDomain($domain)) {
	echo "2";
	return;
}

// Check whether user exists
if($rDB->checkExistingUser($email)){
	echo "3";
	return;
}
else{
echo "4";
return;
}
?>
