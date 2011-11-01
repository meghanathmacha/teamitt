<?php

require_once "Mail/Queue.php";

// options for storing the messages
// type is the container used, currently there are 'creole', 'db', 'mdb' and 'mdb2' available
$db_options['type']       = 'mdb2';
// the others are the options for the used container
// here are some for db
$db_options['dsn']        = 'mysql://mailer:teamitt@mailmand@localhost/Mailer';
$db_options['mail_table'] = 'mail_queue';

// here are the options for sending the messages themselves
// these are the options needed for the Mail-Class, especially used for Mail::factory()
$mail_options['driver']    = 'smtp';
$mail_options['host']      = 'mail.teamitt.com';
$mail_options['port']      =  465;
$mail_options['localhost'] = 'localhost'; //optional Mail_smtp parameter
$mail_options['auth']      = true;
$mail_options['username']  = 'info@teamitt.com';
$mail_options['password']  = 'infomail@teamitt.com';

?> 
