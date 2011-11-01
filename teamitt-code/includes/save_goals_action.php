 <?php
//     if(isset($_POST['action']))
  //  {
	include("../DB/initDB.php");
//	include("../DB/widgetDB.php");
	include("../DB/surveyDB.php");
//	$DB = new widgetDB();
	$DB=new surveyDB();
	if(!$DB->status)
	{
		die("Connection Error");
		exit;
	}
	$user_fbid = $_POST['user_fbid'];
	//$friend_fbid = $_POST['friend_fbid'];
	$post_id = $_POST['post_id'];
	$goal = $_POST['goal'];
	//$attribute        = $_POST['attribute'];
	$action= $_POST['action'];
	//$domain_value_fbid = $_POST['domain_value_fbid'];
	$response_value = $_POST['response_value'];


		$result = $DB -> addAction($post_id,$user_fbid,$goal,$response_value,$action);
		echo $result;

//echo "1";
//}
//	storeAction($user_fbid,$friend_fbid,$post_id,$domain,$attribute,$action,$domain_value_fbid,$response_value);
//	function storeAction($user_fbid,$friend_fbid,$post_id,$domain,$attribute,$action,$domain_value_fbid,$response_value) {
 //   $action = new action();
//     $action  -> save_useraction($user_fbid,$friend_fbid,$post_id,$domain,$attribute,$action,$domain_value_fbid,$response_value);
//    isset($_POST['fetch']) ? $rating->get_ratings() : $rating->vote();
/*class action {
	private $user_fbid;
	private $friend_fbid;
	private $post_id;
	private $domain;
	private $attribute;
	private $action;
	private $domain_value_fbid;
	private $response_value;
	private $DB;
function __construct() {

include("../DB/initDB.php");
include("../DB/widgetDB.php");
$DB = new widgetDB();
if(!$DB->status)
{
	die("Connection Error");
	exit;
}

$this->DB=$DB;
$this->user_fbid = $user_fbid;
$this->friend_fbid = $friend_fbid;
$this -> post_id = $post_id;
$this-> domain = $domain_id;
$this->attribute = $attribute;
$this -> action = $action;
$this -> domain_value_fbid = $domain_value_fbid;
$this -> response_value = $response_value;*/

//}
/*public function save_useraction($user_fbid,$friend_fbid,$post_id,$domain,$attribute,$action,$domain_value_fbid,$response_value) {

$DB=$this->DB;

$result = $DB -> addAction($post_id,$user_fbid,$friend_fbid,$domain_value_fbid,$response_value,$domain,$attribute,$action); 
echo $result;
   }
}*/
?>

