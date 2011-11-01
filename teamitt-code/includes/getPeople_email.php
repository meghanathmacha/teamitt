 <?php
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
		
if(strlen(trim($name))>0)
{
	$result = $DB -> getAutoUserEmail($name);

if(mysql_affected_rows()>0){
while($row=mysql_fetch_row($result))
{
echo "<li class='search-li'>$row[0]</li>";
}
}
	}

}
?>

