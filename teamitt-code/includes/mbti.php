<?php

include("../DB/initDB.php");
include("../DB/usersDB.php");
$DB = new usersDB();
if(!$DB->status)
{
exit;
}

$score_type=$_POST["score_type"];

include("ajaxid.php");
if($DB-> insertMBTI($USERID, $score_type))
{
$succ=$score_type;
}

print(json_encode($succ));


?>
