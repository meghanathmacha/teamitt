<?php 
require_once('Debug.class.php');
$isAuthorized = false;
$settings = @parse_ini_file(dirname(__FILE__).'/settings.ini');

if($settings['FirePHP']=='Enabled' || $isAuthorized) {
  Debug::init();
  Debug::setEnabled(true);
}
$url = 'hi';
Debug::log('Debug', 'URL', $url);

include_once "fbmain-fbpost.php";
 $fbid1        = $_POST['supporter'];
 //$fbid1 = '437;';
 //$fbid1 = '1433022034;1289611055;';
 //$feedurl = '/'.$fbid.'/feed';
 $fbconfig['appid' ]  = "179416485403667";
    $fbconfig['api'   ]  = "0207dbe93feb95ec2a716b8571443828";
    $fbconfig['secret']  = "d36f6c18f2cfff692d9e6e68c30cadee";
     try{
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
    
    	$fbid = explode(";",$fbid1);
    	
    	foreach ($fbid as $key => $value){
    $feedurl = '/'.$value.'/feed';
  try {
  	echo "<div>.$feedurl.</div>";
  $statusUpdate = $facebook->api($feedurl, 'post', array('message'=> 'sumi goal', 'cb' => ''));//THIS WORKS
  	//implement call back.
 //$statusUpdate = $facebook->api('/1301290302/feed', 'post', array('message'=> 'sumi goal', 'cb' => ''));//THIS WORKS
   } catch (FacebookApiException $e) {
                        d($e);
                    }
    
    	}
    	 function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }

?>