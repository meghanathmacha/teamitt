<?php

	require('FirePHPCore/fb.php');

    //$user_id = (int)$_POST['user_id'];
     $user_id = 9;
     
   
   // fb('user id: '.$user_id );
   $widgetId=trim($_POST['widget_id']);
    $rating = new ratings($widgetId);
//   print "<script>alert($widgetId);</script>";
    isset($_POST['fetch']) ? $rating->get_ratings() : $rating->vote();
class ratings {
    //var $data_file = './ratings_goalcat.data.txt';
    private $widget_id;
	private $DB;
    private $data = array(); 
function __construct($wid) {

include("../DB/initDB.php");
include("../DB/widgetDB.php");
$DB=new widgetDB();
if(!$DB->status)
{
	die("Connection Error");
	exit;
}

$this->DB=$DB;
$this->widget_id = $wid;

}
public function get_ratings() {
$DB=$this->DB;
$wid=$this->widget_id;
$r=123;
$result = $DB->selectWidget($wid);
 // $selectwidget = "SELECT * from ratings where widget_id='".$this->widget_id."'";
  
   //   $row2 = mysql_fetch_array($result);
      if(mysql_num_rows($result) == 0){
      	$widget_id=$this->widget_id;
   	$total_points=0;
	$number_votes=0; 
	$dec_avg=0;
	$whole_avg=0;  	
	 

      }
      else{
     
      	while($row2 = mysql_fetch_array($result)) {
     // 	echo "yes";
      	$widget_id=$row2['widget_id'];
   	$total_points=$row2['total_points'];
	$number_votes=$row2['number_votes']; 
	$dec_avg=$row2['dec_avg'];
	$whole_avg=$row2['whole_avg'];  	   	
   $data['widget_id'] = $this->widget_id;
     }
	}
	 $data['widget_id'] = $this->widget_id;
        $data['number_votes'] = (int)$number_votes;
        $data['total_points'] = (int)$total_points;
        $data['dec_avg'] = (double)$dec_avg;
        $data['whole_avg'] = (int)$whole_avg;
	//echo "widget_id".$data['widget_id'];
//	echo "total_points_id".$data['total_points'];
//	echo "whole_avg".$data['whole_avg'];
      echo json_encode($data);
	
  
}

public function vote() {
    
$DB=$this->DB;
    # Get the value of the vote
    preg_match('/star_([1-5]{1})/', $_POST['clicked_on'], $match);
    $vote = $match[1];
    
    $ID = $this->widget_id;
    $dec_avg = round( $vote );
    $whole_avg = round( $dec_avg );
        
    # Update the record if it exists
      $vote = (int)$vote;
     
    $result = $DB->selectWidget($this->widget_id);
      if(mysql_num_rows($result) == 0){
	$DB->AddWidget($ID, 1, $vote, $dec_avg, $whole_avg);
    
      }else{
      	while($row2 = mysql_fetch_array($result)) {
      	$ID=$row2['widget_id'];
   	$total_points=$row2['total_points'];
	$number_votes=$row2['number_votes'];   	   	
   
      }
      $total_points=(int)$total_points;
      $total_points+=$vote;
      $number_votes=(int)$number_votes;
      $number_votes+=1;
      $dec_avg= round( $total_points / $number_votes, 1 );
      $whole_avg = round( $dec_avg );
  //    $total_points=2;
    
     // 	mysql_query("update ratings set total_points=".$total_points.",number_votes=".$number_votes.",dec_avg=".$dec_avg.",whole_avg=".$whole_avg. "where widget_id = '".$ID."'");// or die(mysql_error()); 
    //  	mysql_query("update ratings set whole_avg=5 where widget_id = 'null'");// or die(mysql_error()); 

	$DB->updateRating($this->widget_id, $total_points, $number_votes,  $dec_avg, $whole_avg);
      }
   
    

    # Update the record if it exists
    /*if($this->data[$ID]) {
        $this->data[$ID]['number_votes'] += 1;
        $this->data[$ID]['total_points'] += $vote;
    }
    # Create a new one if it doesn't
    else {
        $this->data[$ID]['number_votes'] = 1;
        $this->data[$ID]['total_points'] = $vote;
    }
    
    $this->data[$ID]['dec_avg'] = round( $this->data[$ID]['total_points'] / $this->data[$ID]['number_votes'], 1 );
    $this->data[$ID]['whole_avg'] = round( $this->data[$ID]['dec_avg'] );
        
        
    file_put_contents($this->data_file, serialize($this->data));
  */
    $this->get_ratings();
    
      //TODO: save to rate table.
  /*    $con = mysql_connect("localhost","lovegeni_sumi1","Pray2god");
      mysql_select_db("lovegeni_goalcat", $con);
      $vote = (int)$vote;
     //TODO: before inserting check if there is rating already.if so then update.
      
      $user_id = (int)$_POST['user_id'];
      
      //TODO: update the user
      $selectUser = "SELECT * from rate_company where user_id=".$user_id." and company_id=".$ID;
      $result=mysql_query($selectUser);
      $row2 = mysql_fetch_array($result);
      if(mysql_num_rows($result) == 0){
    $addClient  = "INSERT INTO 
    rate_company (id, user_id, company_id, rating, create_date, update_date) 
    VALUES ('', $user_id, '$ID', $vote, NOW(), NOW())";
   //  VALUES ('', 1, '1', 1, NOW(), NOW())";
  // VALUES ('', '$user_id', '$ID', '$vote', NOW(), NOW())";
   mysql_query($addClient);
    	mysql_close($con);
   
      }else{
      	while($row2 = mysql_fetch_array($result)) {
      	$ID=$row2['id'];
   
      }
      	mysql_query("update rate_company set rating=".$vote.",update_date=NOW() where id = ".$ID);// or die(mysql_error()); 
   
      }*/
}

# ---
# end class
}
//function return_rating($raw_id) {
//    
//    $widget_data = fetch_rating($raw_id);
//    echo json_encode($widget_data);
//}
//
//# Data is stored as:
//#     widget_id:number_of_voters:total_points:dec_avg:whole_avg
//function fetch_rating($raw_id) {
//    
//    $all  = file('./ratings.data.txt');
//    
//    foreach($all as $k => $record) {
//        if(preg_match("/$raw_id:/", $record)) {
//            $selected = $all[$k];
//            break;
//        }
//    }
//
//    if($selected) {
//        $data = split(':', $selected);
//        $data[] = round( $data[2] / $data[1], 1 );
//        $data[] = round( $data[3] );
//    }
//    else {
//        $data[0] = $raw_id;
//        $data[1] = 0;
//        $data[2] = 0;
//        $data[3] = 0;
//        $data[4] = 0;
//    }
//    
//    return $data;
//}
//
//
//
//
//function register_vote() {
//    
//    preg_match('/star_([1-5]{1})/', $_POST['clicked_on'], $match);
//    $vote = $match[1];
//    
//    $current_data = fetch_rating($_POST['widget']);
//    
//    $new_data[] = $current_data['stars'] + $vote;
//    $new_data[] = $current_data['cast'] + 1;
//    
//
//    # --> This needs to be fixed, since a widget ID is ALWAYS passed in
//    # it should be a class property
//    file_put_contents($_POST['widget'] . '.txt', "{$new_data[0]}\n{$new_data[1]}");
//    
//    return_rating($_POST['widget']);
//}

    //foreach($all as $k => $record) {
    //    if(preg_match("/$raw_id:/", $record)) {
    //        $selected = $all[$k];
    //        break;
    //    }
    //}
    //
    //if($selected) {
    //    $this->data = split(':', $selected);
    //    $this->data[] = round( $this->data[2] / $this->data[1], 1 );
    //    $this->data[] = round( $this->data[3] );
    //}
    //else {
    //    $this->data[0] = $this->widget_id;
    //    $this->data[1] = 0;
    //    $this->data[2] = 0;
    //    $this->data[3] = 0;
    //    $this->data[4] = 0;
    //}
