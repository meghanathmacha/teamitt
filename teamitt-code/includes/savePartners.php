<?php 
require_once("/home/ec2-user/teamitt/sendMail/sendMail.php");
require_once("DB/initDB.php");
                        require_once("DB/MiscDB.php");

                        $DB = new MiscDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }


$email=$_POST['email'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$company=$_POST['company'];
$size=$_POST['companySize'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$city=$_POST['city'];
$state=$_POST['state'];
$zip=$_POST['zip'];
$promo=$_POST['promo'];

$ret = $DB->addPartner($email,$fname,$lname,$company,$size,$address, $city, $state, $zip, $phone, $promo);

if($ret){


$vars = array("name"=> $fname, "email"=>$email);
//sendMail("Partners", $vars);
// Send a Email to the User.

}

?>
