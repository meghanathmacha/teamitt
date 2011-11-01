<?php
// Poll option definitions
$options[1] = 'jQuery';
$options[2] = 'Ext JS';
$options[3] = 'Dojo';
$options[4] = 'Prototype';
$options[5] = 'YUI';
$options[6] = 'mootools';

// Column definitions
define('OPT_ID', 0);
define('OPT_TITLE', 1);
define('OPT_VOTES', 2);

define('HTML_FILE', 'index.html');


if ($_GET['poll'] || $_POST['poll']) {
  poll_submit();
}
else if ($_GET['vote'] || $_POST['vote']) {
  poll_ajax();
}
else {
  poll_default();
}


function poll_ajax() {
// Initialize the DB
require_once("../DB/initDB.php");
require_once("../DB/pollDB.php");
$pollDB= new pollDB();
if(!$pollDB->status)
{
	die("Connection Error");
	exit;
}
 $data =array();
  $id = $_GET['vote'] ;
  $voter_fbid = $_GET['voter_id'] ;
 $result = $pollDB -> insertVotes($id);
 $result = $pollDB -> updateVoter($id,$voter_fbid);
 if(!$result)									//new voter
 $result = $pollDB -> insertVoter($id,$voter_fbid);
	
$result = $pollDB -> getOptions($id);
$rows = array();
$question_id = 0;
//echo "result";
while($r = mysql_fetch_array($result))
{	
	$rows[0][] = $r;
	if(!$question_id)
		$question_id = $r['question_id'];
}
	
$result = $pollDB -> selectLastXVoters($question_id,3);
while($r = mysql_fetch_array($result))
{	
	$rows[1][] = $r;
}
 print json_encode($rows);

}


