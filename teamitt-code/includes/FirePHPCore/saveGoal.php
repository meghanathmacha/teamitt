<?php
	$con = mysql_connect("localhost","lovegeni_sumi1","Pray2god");
	mysql_select_db("lovegeni_goalcat", $con);
	$goalTitle        = $_POST['goalTitle'];
	$goalDesc        = $_POST['goalDesc'];
	$goalType        = $_POST['goalType'];
	$goalCategory       = $_POST['goalCategory'];
	$supporter       = $_POST['supporter'];
	$supfbid       = $_POST['supfbid'];
	$fbid = $_POST['fbid'];
	$userid;
	$fbconfig['appid' ]  = "179416485403667";
    $fbconfig['api'   ]  = "0207dbe93feb95ec2a716b8571443828";
    $fbconfig['secret']  = "d36f6c18f2cfff692d9e6e68c30cadee";
     try{
     	require('FirePHPCore/fb.php');
        include_once "facebook.php";
    }
    catch(Exception $o){
        echo '<pre>';
        print_r($o);
        echo '</pre>';
    }
 $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => true,
    ));
$select_user = mysql_query("SELECT * FROM user WHERE facebook_id='$fbid'");
while($row = mysql_fetch_array($select_user))
  {
  $userid =  $row['id'];
  
  }
  	$addClient  = "INSERT INTO 
    goal (id, user_id, title, description, goal_type, category, status, create_date, updated_date) 
   VALUES ('', '$userid', '$goalTitle', '$goalDesc','$goalType', '$goalCategory', '', NOW(), NOW())";
  	// VALUES ('', '', '$facebook_id','$facebook_name', '$email', '', '', '', '', '', '', '', '', '', '', '', NOW(), NOW())";
    mysql_query($addClient);
    	$goal_id = mysql_insert_id();
    	//$supfbid1 = explode(";",$supfbid);
    	//foreach ($supfbid1 as $key => $value){
    	if(stripos($supfbid, ";") == (strlen($supfbid)-1)){
    	$supfbid = substr($supfbid,0, (strlen($supfbid)-1));
    	$feedurl = '/'.$supfbid.'/feed';
    	// $feedurl = '/me/feed';1301290302
    	// $feedurl = '/1301290302/feed';
    	//  $feedurl = '/1433022034/feed';
    	}
    	$addSup  = "INSERT INTO 
   supporter (id, user_id, goal_id, facebook_id, facebook_name, create_date) 
   VALUES ('', '$userid', '$goal_id', '$supfbid','$supporter', NOW())";
    	 mysql_query($addSup) or die(mysql_error());
    	//}
    mysql_close($con);
    
     $statusUpdate = $facebook->api($feedurl, 'post', array('message'=> 'sumi goal', 'cb' => ''));//THIS WORKS

?>
