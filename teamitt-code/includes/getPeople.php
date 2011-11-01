 <?php
include("ajaxid.php"); 


    if(isset($_GET['name']))
    {

$name=$_GET["name"];
	include("../DB/initDB.php");
	include("../DB/usersDB.php");
	$DB = new usersDB();
	if(!$DB->status)
	{
		die("Connection Error");
		exit;
	}
$cid = $DB->getCompanyId($USERID);
		
if(strlen(trim($name))>0)
{
	$result = $DB -> getAutoUser($name, $cid);

if(mysql_affected_rows()>0){
while(($row=mysql_fetch_row($result)) && ($row[0]!=$USERID))
{

echo "<li class='search-li' uid='$row[0]'>$row[1]</li>";
}
}
	}

}
?>

