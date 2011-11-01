<?php
include("../DB/initDB.php");
include("../DB/location.php");
$DB = new loc();
if(!$DB->status)
{
        die("Connection Error");
        exit;
}
$name=$_GET['company'];
$count=0;
 $events=$DB->selectComp($name);
                $row=mysql_fetch_row($events);
                $comp_id=$row[0];

//echo $comp_id;
$university_info=$DB->getInvestor($comp_id);
while($row=mysql_fetch_row($university_info))
{
                $type=$row[0];
                $investor=$row[1];
//$data=array();
$data[$count]["type"]=$type;
$data[$count]["investor"]=$investor;
$count++;
}
if($count==0)
{
$data[0]["type"]=4;
}
 echo json_encode($data);

