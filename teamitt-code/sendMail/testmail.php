<?php
include("Mailer.php");
$type = "IRegister";
$vars = array();

/* vars on comment */

/*$vars["feedid"] = "598";
$vars["userid"] = 31;
$vars["content"] = "Try to do it asap !";
*/




/* vars for registration 
$vars["name"] = "Akash Sinha";
$vars["email"] = "akash.reflectperfection@gmail.com";
$vars["ackey"] = "mdlkwjewkdjiowbewjdasnldw";
*/


/* vars for Iregistration */
$vars["name"] = "Akash Sinha";
$vars["email"] = "akash.reflectperfection@gmail.com";

/* vars for action 
$vars["userid"] = 31;
$vars["actionid"] = 172;
$vars["feedid"] = 598;
$vars["content"] = "Gear up for our first customer !";
*/


$mailer = new $type($vars);
$mailer->pushMail();



?>
