<?php

function getDifference($startDate,$endDate)
{
    list($date,$time) = explode(' ',$endDate);
    $startdate = explode("-",$date);
    $starttime = explode(":",$time);

    list($date,$time) = explode(' ',$startDate);
    $enddate = explode("-",$date);
    $endtime = explode(":",$time);

    $secondsDifference = mktime($endtime[0],$endtime[1],$endtime[2],
        $enddate[1],$enddate[2],$enddate[0]) - mktime($starttime[0],
            $starttime[1],$starttime[2],$startdate[1],$startdate[2],$startdate[0]);
    
            return $secondsDifference;
} 


$now=date("Y-m-d G:i:s");
$tomorrow = mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
$tm=date("Y-m-d G:i:s ", $tomorrow); 
$diff=getDifference($tm,$now);

$hr=0;
$min=0;
$sec=0;
$sec=$diff;

if($sec>60)
{
$min=floor($sec/60);
$sec=$diff%60;
if($min>60)
{
$hr=floor($min/60);
$min=$min%60;
}
}


echo $hr.":".$min.":".$sec;

?>
