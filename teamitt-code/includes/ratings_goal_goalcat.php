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
function __construct($id) {

include("../DB/initDB.php");
//include("../DB/widgetDB.php");
include("../DB/surveyDB.php");
//$DB=new widgetDB();
$DB=new surveyDB();

if(!$DB->status)
{
	die("Connection Error");
	exit;
}

$this->DB=$DB;
$this->widget_id = $id;

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
      	$widget_id=$row2['id'];
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
    $this->get_ratings();
}
}
