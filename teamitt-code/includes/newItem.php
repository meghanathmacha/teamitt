<?php
function postevent($INP,$userid,$DB,$fbDB)
{
if($userid=="" || !($fbDB->checkClient($userid)))
{
$succ = 0;
$err = "invalid userid";
}
else if($INP["event_name"]=="")
{
$succ = 0;
$err = "event name missing";
}
else if($INP["event_type"]=="")
{
$succ = 0;
$err = "event type missing";
}
else if($INP["event_place"]=="")
{
$succ = 0;
$err = "event location missing";
}
else if($INP["event_time"]=="")
{
$succ = 0;
$err = "event time missing";
}
else if($INP["company"]=="")
{
$succ = 0;
$err = "invalid form";
}

else
{
$succ = $DB->AddEvent($userid,$INP["company"],$INP["event_name"],$INP["event_type"],$INP["event_place"],$INP["event_time"]);
if(!$succ){ $err="connection interrupted";}
else { $err = "Event Added";}

}


$value= array('success' => $succ, 'err' => $err);
$output = json_encode($value);

echo $output;




}


function postjob($INP,$userid,$DB,$fbDB)
{
if($userid=="" || !($fbDB->checkClient($userid)))
{
$succ = 0;
$err = "invalid userid";
}
else if($INP["title"]=="")
{
$succ = 0;
$err = "job title missing";
}
else if($INP["skills_reqd"]=="")
{
$succ = 0;
$err = "required skills missing";
}
else if($INP["skills_opt"]=="")
{
$succ = 0;
$err = "optional skills missing";
}
else if($INP["qual"]=="")
{
$succ = 0;
$err = "educational qualification missing";
}
else if($INP["exp"]=="")
{
$succ = 0;
$err = "past experience missing";
}

else if($INP["description"]=="")
{
$succ = 0;
$err = "job description missing";
}
else if($INP["about"]=="")
{
$succ = 0;
$err = "about company field missing";
}



else
{
$succ = $DB->AddJob($userid,$INP["company"],$INP["title"],$INP["skills_reqd"],$INP["skills_opt"],$INP["qual"], $INP["exp"],$INP["description"],$INP["about"]);
if(!$succ){ $err="connection interrupted.";}
else { $err = "Job successfully added.";}

}


$value= array('success' => $succ, 'err' => $err);
$output = json_encode($value);

echo $output;




}





function postItem($data,$userid,$DB,$fbDB)
{
$perfs = explode("&", $data);
$INP=array();
foreach($perfs as $perf) {
    $perf_key_values = explode("=", $perf);
    $key = urldecode($perf_key_values[0]);
    $values = urldecode($perf_key_values[1]);
$INP[$key]=$values;
}

if($INP["itemType"]=="event")
{
postevent($INP,$userid,$DB,$fbDB);
}
else
{
postjob($INP,$userid,$DB,$fbDB);
}




}




function addevent($company,$DB)
{
echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add events for $company</div>";
include("addevent_form.php");
}
function addjob($company,$DB)
{
echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Add Jobs for $company</div>";
include("addjob_form.php");
}





include("../DB/initDB.php");
include("../DB/eventDB.php");
$DB = new eventDB();
if(!$DB->status)
{
exit;
}

$type = $_POST["type"];

switch($type)
{
case "addevent":
	     $company=$_POST["company"];
             addevent($company,$DB);
  	     break;
case "addjob":
	     $company=$_POST["company"];
             addjob($company,$DB);
	     break;
case "postItem":
	     $values=$_POST["values"];
	     $userid=$_POST["userid"];
	     include("../DB/fbActivity.php");
	     $fbDB = new fbActivityDB();
             postItem($values,$userid,$DB,$fbDB);
  	     break;
default:
	break;

}
