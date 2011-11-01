<?php
function getWeekRange($date) {
    $ts = strtotime($date);
    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    return array(date('Y-m-d', $start),
                 date('Y-m-d', strtotime('next sunday', $start)));
}
function getTWeekRange()
{
/*$start = date('m/d/y',mktime(0,0,0,date('m')-1,1,date('y')));
$end = date('m/d/y',mktime(0,0,0,date('m'),0,date('y')));*/
$weekday = date('w', mktime(0,0,0,date('m'), date('d'), date('y'))); 
        $sunday  = date('d') - $weekday; 
$start = date('Y-m-d',mktime(0,0,0,date('m'),$sunday,date('y')));
$end = date('Y-m-d',mktime(0,0,0,date('m'),$sunday+8,date('y')));
    return array($start,$end);

}
function getLWeekRange()
{
/*$start = date('m/d/y',mktime(0,0,0,date('m')-1,1,date('y')));
$end = date('m/d/y',mktime(0,0,0,date('m'),0,date('y')));*/
$weekday = date('w', mktime(0,0,0,date('m'), date('d'), date('y'))); 
        $sunday  = date('d') - $weekday; 
$start = date('Y-m-d',mktime(0,0,0,date('m'),$sunday-7,date('y')));
$end = date('Y-m-d',mktime(0,0,0,date('m'),$sunday+1,date('y')));
    return array($start,$end);

}
function getLMonthRange()
{
/*$start = date('m/d/y',mktime(0,0,0,date('m')-1,1,date('y')));
$end = date('m/d/y',mktime(0,0,0,date('m'),0,date('y')));*/
$start = date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('y')));
$end = date('Y-m-d',mktime(0,0,0,date('m'),0,date('y')));
    return array($start,$end);

}
function getTMonthRange()
{
/*$start = date('m/d/y',mktime(0,0,0,date('m')-1,1,date('y')));
$end = date('m/d/y',mktime(0,0,0,date('m'),0,date('y')));*/
$start = date('Y-m-d',mktime(0,0,0,date('m'),1,date('y')));
$end = date('Y-m-d',mktime(0,0,0,date('m')+1,0,date('y')));
    return array($start,$end);

}
function getLYearRange()
{
$start = date('Y-m-d',mktime(0,0,0,1,1,date('y')-1));
$end = date('Y-m-d',mktime(0,0,0,12,31,date('y')-1));
    return array($start,$end);

}
function getTYearRange()
{
$start = date('Y-m-d',mktime(0,0,0,1,1,date('y')));
$end = date('Y-m-d',mktime(0,0,0,12,31,date('y')));
    return array($start,$end);

}
//var_dump(getMonthRange());
//var_dump(getYearRange());
?>
