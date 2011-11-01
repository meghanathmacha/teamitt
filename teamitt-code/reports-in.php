

<script>
$(document).ready(function() 
    { 
        $(".tablesorter").tablesorter(); 
    } 
); 
    </script>
<?php
require_once('checkid.php');
require_once("includes/getRange.php");
require_once("DB/initDB.php");
require_once('DB/reportDB.php');
require_once("DB/usersDB.php");
$userDB = new usersDB();
$company_id  = $userDB->getCompanyId($USERID);
$reportDB = new reportDB();
$report_type = isset($_POST['type'])?$_POST['type']:'overall';
$from_date = $_POST['from_date'];
$end_date = $_POST['end_date'];
$time_range =  $_POST['time_range'];
if($time_range != 'DAY')
{
if($time_range == 'TWEEK')
	list($from_date ,$end_date) = getTWeekRange();
else if($time_range == 'LWEEK')
	list($from_date ,$end_date) = getLWeekRange();
else if($time_range == 'TMONTH')
	list($from_date ,$end_date) = getTMonthRange();
else if($time_range == 'LMONTH')
	list($from_date ,$end_date) = getLMonthRange();
else if($time_range == 'TYEAR')
	list($from_date ,$end_date) = getTYearRange();
else if($time_range == 'LYEAR')
	list($from_date ,$end_date) = getLYearRange();
}
$report_flag = $_POST['report_flag'];
if($report_type == 'overall')
{
$report_html = "<table class='tablesorter' id = 'report-table'>";
$report_html .= "<thead><tr>";
$report_html .= "<th>Name</th>";
$report_html .= "<th>Thanks Received</th>";
$report_html .= "<th>Thanks Sent</th>";
$report_html .= "<th>Actions assigned</th>";
$report_html .= "<th>Active Actions</th>";
$report_html .= "<th>Feedback Requested</th>";
$report_html .= "<th>Feedback Given</th>";
$report_html .= "</tr></thead>";
$report_html .= "<tbody>";
//$company_id = 9;
$result = $reportDB-> getUsersByCompanyId($company_id);
while(($row = mysql_fetch_array($result)) != null)
{
$user_id = $row['id'];
$user_name = $row["first_name"] . " " .$row["last_name"];
$feedbacks_given = $reportDB -> feedbackGivenByUserId($user_id,$from_date,$end_date,$time_range);
$feedbacks_requested =  $reportDB -> feedbackRequestedByUserId($user_id,$from_date,$end_date,$time_range);
$actions_due = $reportDB-> actionsDueByUserId($user_id,$from_date,$end_date,$time_range);
$actions_completed = $reportDB-> actionsCompletedByUserId($user_id,$from_date,$end_date,$time_range);
$thanks_given= $reportDB-> thanksGivenByUserId($user_id,$from_date,$end_date,$time_range);
$thanks_given = mysql_fetch_array($thanks_given);
$thanks_given = $thanks_given["thanks_count"];
$thanks_received = $reportDB-> thanksReceivedByUserId($user_id,$from_date,$end_date,$time_range);
$thanks_received = mysql_fetch_array($thanks_received);
$thanks_received = $thanks_received["thanks_count"];
$report_html .= "<tr>";
$report_html.= "<td>$user_name</td>";
$report_html .= "<td>$thanks_received</td>";
$report_html .= "<td>$thanks_given</td>";
$report_html .= "<td>$actions_completed</td>";
$report_html .= "<td>$actions_due</td>";
$report_html .= "<td>$feedbacks_requested</td>";
$report_html .= "<td>$feedbacks_given</td>";
$report_html .= "</tr>";

}
$report_html .= "</tbody>";
$report_html .= "</table>";
echo $report_html;
}
else if($report_type == 'badge')
{
if($report_flag != '')
{
 require_once("badge-report.php");
}
else
{
$report_html = "<table class='tablesorter badge-table' >";
$report_html .= "<thead><tr>";
$report_html .= "<th>Name</th>";
$report_html .= "<th>Points Received</th>";
$report_html .= "<th>Points Sent</th>";
$report_html .= "</tr></thead>";
$report_html .= "<tbody>";
//$company_id = 9;
$result = $reportDB-> getUsersByCompanyId($company_id);
while(($row = mysql_fetch_array($result)) != null)
{
$user_id = $row['id'];
$user_name = $row["first_name"] . " " .$row["last_name"];
$points_sent = $reportDB-> getPointsSentByUserId($user_id,$from_date,$end_date,$time_range);
$points_received = $reportDB-> getPointsReceivedByUserId($user_id,$from_date,$end_date,$time_range);
$points_sent = mysql_fetch_array($points_sent);
$points_sent = $points_sent["total_points"];
$points_received  = mysql_fetch_array($points_received);
$points_received = $points_received["total_points"];
if($points_sent == null)
	$points_sent = 0;
if($points_received == null)
	$points_received = 0;
$report_html .= "<tr uid='$user_id'>";
$report_html.= "<td class='name-td'>$user_name</td>";
$report_html .= "<td class='points-sent'>$points_received</td>";
$report_html .= "<td class='points-received'>$points_sent</td>";
$report_html .= "</tr>";

}
$report_html .= "</tbody>";
$report_html .= "</table>";
echo $report_html;
}
}
else
//else if($report_type == 'goal')
{
$report_html = "<table class='tablesorter' id = 'report-table'>";
$report_html .= "<thead><tr>";
$report_html .= "<th>Name</th>";
$report_html .= "<th>Total Goals</th>";
$report_html .= "<th>Active Goals</th>";
$report_html .= "</tr></thead>";
$report_html .= "<tbody>";
//$company_id = 9;
$result = $reportDB-> getUsersByCompanyId($company_id);
while(($row = mysql_fetch_array($result)) != null)
{
$user_id = $row['id'];
$user_name = $row["first_name"] . " " .$row["last_name"];
$total_goals= $reportDB-> getGoalsByUserId($user_id,$from_date,$end_date,$time_range,$progress_type);
$due_goals = $reportDB-> getDueGoalsByUserId($user_id,$from_date,$end_date,$time_range);
$report_html .= "<tr>";
$report_html.= "<td>$user_name</td>";
$report_html .= "<td>$total_goals</td>";
$report_html .= "<td>$due_goals</td>";
$report_html .= "</tr>";

}
$report_html .= "</tbody>";
$report_html .= "</table>";
echo $report_html;
}
?>
<script>
REPORT_FLAG='<?php echo $report_flag?>';
REPORT_USER_ID = '<?php echo $user_id ?>';
</script>
