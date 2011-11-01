 <?php
     if(isset($_GET['cname']))
    {
$cname=$_GET["cname"];
	include("../DB/initDB.php");
	include("../DB/widgetDB.php");
	$DB = new widgetDB();
	if(!$DB->status)
	{
		die("Connection Error");
		exit;
	}
		
if(strlen(trim($cname))>0)
{
	$result = $DB -> getAutoCompany($cname);

if(mysql_affected_rows()>0){
while($row=mysql_fetch_row($result))
{
echo "<li class='search-li'>$row[0]</li>";
}
}
	}

}
?>

