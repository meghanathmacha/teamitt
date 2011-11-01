<?php
$dir_path ="/home/ec2-user/teamitt/";
$curr_path ="/home/ec2-user/teamitt/sendMail/";

require_once($dir_path."DB/initDB.php");
require_once($dir_path."DB/MailsDB.php");

require_once($curr_path.'PHPMailer_v5.1/class.phpmailer.php');


class Mailer
{
protected $body;
protected $subject;
protected $alt_body;


public function sendMail($email, $name)
{
date_default_timezone_set('America/Toronto');
$mail = new PHPMailer();
$mail->IsSMTP(); 
$mail->Host       = "mail.teamitt.com";
$mail->SMTPDebug  = 0;                     

$mail->SMTPAuth   = true;                 
$mail->SMTPSecure = "ssl";                 
$mail->Host       = "box381.bluehost.com";      
$mail->Port       = 465;                   
$mail->Username   = "notification@teamitt.com"; 
$mail->Password   = "notifyTeamitt";  
$mail->SetFrom('notification@teamitt.com', 'Teamitt');
$mail->AddReplyTo("notification@teamitt.com","Teamitt");

$mail->Subject    = $this->subject;

$msg_body ="<div style='background:#f6f6f6; padding: 20px;'>";
$msg_body .="Hi $name,<br/>";
$msg_body .= $this->body;


$msg_alt_body ="Hi $name,
";
$msg_alt_body .=  $this->alt_body;

$mail->AltBody  = $msg_alt_body;

$mail->MsgHTML($msg_body);

$mail->AddAddress($email,$name);
$mail->Send();

}

}


class Comment extends Mailer
{

private $feedid, $uid;
private $mDB;
public function __construct($vars)
{
$this->mDB = new MailsDB();
$mDB = $this->mDB;
global $curr_path;
$content = $vars["content"];
$this->uid = $vars["userid"];
$uname = $mDB->getFullName($this->uid);
$this->feedid = $vars["feedid"];


$this->subject = "$uname has commented on your post";

$msg_body = "
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
$uname has written, 
<br/>
";
$msg_body .= "
\"$content\"
<br/>
<br/>
Click on the below link to view the post,
<br/><br/>
<a href='http://www.teamitt.com/post.php?id=".$this->feedid."'>http://www.teamitt.com/post.php?id=".$this->feedid."</a>
<br/>
";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;

$msg_alt_body = "

$uname has written,

\"$content\"

Click on the below link to view the post,

http://www.teamitt.com/post.php?id=".($this->feedid)."

";
$msg_alt_body .= file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;




}

public function pushMail()
{
$sentUsers = array();
$sentUsers[$this->uid] = true;

$mDB= $this->mDB;
$feed_recvs = $mDB -> getFeedReceivers($this->feedid, $this->uid);
if(!is_int($feed_recvs)) {
while(list($uid, $email, $name) = mysql_fetch_row($feed_recvs))
{

if(!isset($sentUsers[$uid])) {
$sentUsers[$uid] = 1;
$this->sendMail($email, $name);
}

}
}

//Get directly linked member
$feed_to = $mDB -> getFeedTo($this->feedid, $this->uid);
if(!is_int($feed_to)) {
list($uid, $email, $name) = mysql_fetch_row($feed_to);
if(!isset($sentUsers[$uid])) {
$sentUsers[$uid] = 1;
$this->sendMail($email, $name);
}
}


//Get who already has commented on this post
$feed_commenters = $mDB -> getFeedCommenters($this->feedid, $this->uid);
if(!is_int($feed_commenters)) {
while(list($uid, $email, $name) = mysql_fetch_row($feed_commenters))
{
if(!isset($sentUsers[$uid])) {
$sentUsers[$uid] = 1;
$this->sendMail($email, $name);
}
}
}




}
}




class Action extends Mailer
{
private $actionid,$uid;
private $mDB;
public function __construct($vars)
{

$this->mDB = new MailsDB();
$mDB = $this->mDB;
global $curr_path;
$action = $vars["content"];
$this->uid = $vars["userid"];
$uname = $mDB->getFullName($this->uid);
$this->actionid = $vars["actionid"];
$feedid = $vars["feedid"];

$extension ="";
if(isset($vars["goal"]))
{
$extension =" on the goal - ".$vars["goal"];
}
else if(isset($vars["project"]))
{
$extension =" on the project - ".$vars["project"];
}


$this->subject = "$uname has assigned a new action to you".$extension;

$msg_body = "
<br/>
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
$uname has assigned a new action for you, 
<br/>
";
$msg_body .= "
<br/>
\"$action\"
<br/><br/>
Click on below link to view the post,
<br/><br/>
<a href='http://www.teamitt.com/post.php?id=".$feedid."'>http://www.teamitt.com/post.php?id=".$feedid."</a>
<br/>
";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;


$msg_alt_body = "

$uname has assigned a new action for you,

\"$action\"

Click on the below link to view the post,

http://www.teamitt.com/post.php?id=".($feedid)."

";
$msg_alt_body .= file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;




}

public function pushMail()
{
$acid = $this->actionid;
$mDB= $this->mDB;
$action_recvs = $mDB -> getActionReceivers($acid, $this->uid);
while(list($email, $name) = mysql_fetch_row($action_recvs))
{
$this->sendMail($email, $name);
}

}



}



class Thank extends Mailer
{
private $thankid,$uid;
private $mDB;
public function __construct($vars)
{

$this->mDB = new MailsDB();
$mDB = $this->mDB;
global $curr_path;
$content = $vars["content"];
$this->uid = $vars["userid"];
$uname = $mDB->getFullName($this->uid);
$this->thankid = $vars["thankid"];
$feedid = $vars["feedid"];
$badgeid = $vars["badgeid"];
$badge = $mDB->getBadgeName($badgeid);


$this->subject = "$uname has thanked you ";
if($badgeid)
{
$this->subject .= "for $badge";
}

$msg_body = "
<br/>
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
$uname has written, 
<br/>
";
$msg_body .= "
<br/>
\"$content\"
<br/><br/>
Click on below link to view the post,
<br/><br/>
<a href='http://www.teamitt.com/post.php?id=".$feedid."'>http://www.teamitt.com/post.php?id=".$feedid."</a>
<br/>
";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;


$msg_alt_body = "

$uname has written you,

\"$content\"

Click on the below link to view the post,

http://www.teamitt.com/post.php?id=".($feedid)."

";
$msg_alt_body .= file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;
}

public function pushMail()
{
$tid = $this->thankid;
$mDB= $this->mDB;
$thank_recvs = $mDB -> getThankReceivers($tid);
while(list($email, $name) = mysql_fetch_row($thank_recvs))
{
$this->sendMail($email, $name);
}
}

}


class Invite extends Mailer
{
private $uid, $emails;
private $mDB;
private $invite_body="";
private $invite_alt_body="";
public function __construct($vars)
{

$this->mDB = new MailsDB();
$mDB = $this->mDB;
global $curr_path;
$this->emails = $vars["emails"];
$this->uid = $vars["userid"];
$uname = $mDB->getFullName($this->uid);
$company = $mDB->getCompanyName($this->uid);


$this->subject = "[Invitations] $uname has invited you on Teamitt ";

$msg_body = "
<br/>
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
$uname has invited to join the network of $company at Teamitt, 
<br/>
";
$msg_body .= "
<br/><br/>
Click on below link to get connected,
<br/>

";

$this->invite_body = $msg_body;


$msg_alt_body = "

$uname has invited you to join the network of $company at Teamitt,

Click on the below link to get connected,

";
$this->invite_alt_body = $msg_alt_body;
}

public function pushMail()
{

global $curr_path;

$mDB= $this->mDB;
$uid = $this->uid;

$emails =$this->emails;


$emails = explode(",", $emails);

foreach($emails as $email)
{
$temp = explode("@", $email);
$name = $temp[0];

$ikey = $mDB -> getInviteKey($uid, $email);
$msg_body= $this->invite_body;
$msg_alt_body= $this->invite_alt_body;
$msg_body .="
<br/>
<a href='http://www.teamitt.com/invited.php?ikey=".$ikey."'>http://www.teamitt.com/invited.php?ikey=".$ikey."</a>
";

$msg_alt_body .="http://www.teamitt.com/invited.php?ikey=".$ikey;

$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$msg_alt_body .= file_get_contents($curr_path.'mail_footer.txt');

$this->body = $msg_body;
$this->alt_body = $msg_alt_body;

$this->sendMail($email, $name);

}

}


}







?>


