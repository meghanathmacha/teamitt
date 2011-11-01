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
 $events=$DB->selectComp($name);
                $row=mysql_fetch_row($events);
                $comp_id=$row[0];

//echo $comp_id;
$university_info=$DB->getUniversity($comp_id);
$row=mysql_fetch_row($university_info);
                $founder=$row[0];
                $university=$row[1];
$data=array();
$data["founder"]=$founder;
$data["university"]=$university;
 echo json_encode($data);

