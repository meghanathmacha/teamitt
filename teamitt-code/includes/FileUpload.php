<?php 
include("ajaxid.php");
include("feed_helper.php");

require_once ("../DB/initDB.php") ;
include ("../DB/FileUpload.php") ;
include_once("FileUpload_functions.php");
include_once("checkid.php");
include_once("../DB/usersDB.php");

$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
if(strlen($url["query"])>0)
        $query = explode("=", $url["query"]);

//$action_type=$_GET["action_type"];
$goalID=$query[1];
$fDB=new FileUpload();
$uDB=new usersDB();
$userID=$USERID;
$username=$uDB->fullName($userID,NULL);


?> 
