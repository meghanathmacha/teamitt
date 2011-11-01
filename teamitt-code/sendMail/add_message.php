<?php
include './config.php';
/* we use the db_options and mail_options here */

date_default_timezone_set('America/Toronto');


$mail_queue =& new Mail_Queue($db_options, $mail_options);


$from = 'info@teamitt.com';
$to = "akash.reflectperfection@gmail.com";
$message = 'Hi! This is test message!! :)';

$hdrs = array( 'From'    => $from,
               'To'      => $to,
               'Subject' => "test message body"  );

/* we use Mail_mime() to construct a valid mail */
$mime =& new Mail_mime();
$mime->setTXTBody($message);
$body = $mime->get();
// the 2nd parameter allows the header to be overwritten
// @see http://pear.php.net/bugs/18256
$hdrs = $mime->headers($hdrs, true); 

/* Put message to queue */
$mail_queue->put($from, $to, $hdrs, $body);

?> 
