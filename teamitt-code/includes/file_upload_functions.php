<?php
function get_section_name($query)
{
	$temp_arr=explode("/",$query);
	$temp_arr1=explode(".",$temp_arr[1]);	
	return $temp_arr1[0]; 
}

function display_file_info($rows,$i,$uDB)
{
	echo " <div id='".$rows[$i]['fileID']."' class='file_data' style='display:block;'> ";
	$temp_arr=explode(".",$rows[$i]['filename']);
        if (sizeof($temp_arr)>1)
                $save_name=$temp_arr[0]."_".$rows[$i]['upload_date'].".".$temp_arr[1];
        else
                $save_name=$rows[$i]['filename']."_".$rows[$i]['upload_date'];

        echo " <span class='file_name'><a href='".$rows[$i]['filepath'].$save_name."'>".$rows[$i]['filename']."</a></span>";
        echo "<span class='delete_file'>X</span>";
        echo "<br>";
        $username=$uDB->fullName($rows[$i]['userID'],NULL);     // full name of the user
        echo "<span class='file_owner'><a href='./profile.php?id=".$rows[$i]['userID']."'>".$username."</a></span>";
//      echo "<span class='file_section'>".$rows[$i]['section']."</span>";
        echo "<span class='file_size'>".formatBytes($rows[$i]['filesize'], 1)."</span>";
        echo "<span class='file_date'>".date("Y-m-d @ H:i A", $rows[$i]['upload_date'])."</span>";
        echo "<br>";
	echo "<span class='small_text'>Tags:</span>"; 
        echo "<span class='file_tags'>";
        $tag_arr=explode(",",trim($rows[$i]['related_tags'],","));
        $b=sizeof($tag_arr);
        for ($j=0;$j<$b;$j++)
        {       echo "<span id='tag_".$tag_arr[$j]."' class='file_tag' title='Click to see files with this tag'>".$tag_arr[$j]."</span>";
		if ($b>0)
		{	if (($j>=0) && ($j<($b-1)))
				echo " , ";
		}
        }
        echo "</span>";
	echo "<input type='hidden' name='sectionID' class='sectionID' value='".$rows[$i]['sectionID']."' />"; 	// values to be used in TAG SEARCH 
	echo "<input type='hidden' name='section' class='section' value='".$rows[$i]['section']."' />";	     	//   "     "   	"        "    " 
        echo "</div>";

	return ; 
}

function formatBytes($size, $precision)
{
    $base = log($size) / log(1024);
    $suffixes = array('B', 'Kb', 'Mb', 'Gb', 'Tb');

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}




?>

