<?php


// # INCLUDE BASIC FILES 
include("ajaxid.php");
include("feed_helper.php");
include_once("checkid.php");

// # INCLUDE DB FILES 
require_once ("../DB/initDB.php") ;
include_once("../DB/FileUpload.php");
include_once("../DB/usersDB.php");

$uDB=new usersDB();
$fDB=new FileUpload(); 

// # INCLUDE ADDITIONAL FUNCTION FILES 
include_once("file_upload_functions.php");

// # SET COMMON VARIABLES 
$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
if(strlen($url["query"])>0)
        $query = explode("=", $url["query"]);

$category=get_section_name($url['path']);
$belongstoID=$query[1]; // in profile pages $query[1] could be userID also 
$userID=$USERID;   // logged in user ID
$username=$uDB->fullName($userID,NULL); // full name of the user 

// FOR LOADING THE FORM DATA 
if(isset($_GET['action_type']))
{
        $action_type=$_GET['action_type'];
        if ($action_type=="uploadfile")
        {	
		echo "<div id='show_upload_form' class='upload_form'>";
		echo '<form id="upload_file" name="upload_file" method="POST" enctype="multipart/form-data" target="upload_target" action="./includes/file_upload.php">';		
		echo "File:<input type='file' name='filetoupload' id='filetoupload' /><br/>";
		echo "<div id='tags' class='tags'>"; 
		echo "<div id='tag_list' class='tag_list'>";
		echo "<div class='tag_title' style='display:none;'>Selected Tags:</div>";
		echo "</div>";
		echo "<div id='tag_txtbox' class='tag_txtbox' style='display: inline-block;'>";
		echo "Tag the File:<input  type='text' name='txt_tags' class='txt_tags' id='txt_tags' role='textbox' onkeypress='show_tag_suggestions(event,this.value);' onkeyup='suggestions(this.value);' title='Add tag by typing tag name and pressing <,> or <space> or <enter>' />";
		echo "<input type='button' id='add_tag' class='add_tag' name='add_tag' value='Add Tag' />";
		echo "</div>";
		echo "</div>"; 
		echo "<input type='submit' name='submit' value='Upload' id='submit' onClick='validate_submit(event);'/>";
		echo "<input type='hidden' name='submit1' value='1'/>";
		echo "<iframe id='upload_target' name='upload_target' src='' style='width:0px;height:0px;border:0px solid #fff;'></iframe>";
		echo "</form>";
		echo "<div id='action_message' class='action_message' > </div>"; 
		echo "</div>"; 

        }
        if ($action_type=="showuploadedfiles")
        {	$tag='all';
		if(isset($_GET['tag']))	
		{
			$tag=$_GET['tag']; 
			$category=$_GET['section']; 
			$belongstoID=$_GET['sectionID'];
			echo "<div id='show_all_files' class='show_all_files'>";
			echo "<span class='display_tag_info'>Showing files with Tag: ".$tag."</span>";
			echo "<span class='showallfiles'>Show all files</span>";
			echo "</div>"; 
		}	
		echo "<div id='file_list' class='file_list'>";
		// upload the file data from the database here
		$rows=$fDB->get_uploaded_files($category,$belongstoID,$tag); 
		$a=sizeof($rows); 
		for ($i=0;$i<$a;$i++) 
			display_file_info($rows,$i,$uDB);
		echo "</div>";
        }

} // END OF BASIC LOADING 



// EXECUTED on Submit.click() for a file to be uploaded
if(isset($_POST['submit1']))
{	

	$log=array(); // if needed, you can pass this array to calling function to check the point of execution before fatal error. 
	$max_filesize = 5242880; // Maximum filesize in BYTES (currently 5MB).
	$upfile='filetoupload';  // name of the tag in which file was uploaded in the HTML page. 
	$tags=$_POST['tag_input']; 
	$timestamp=time();
	$base_path="/home/ec2-user/teamitt/file_uploads/";
	$upload_path=$base_path.$category.'/';
        $upload_path1="file_uploads/".$category.'/';
	$filename = $_FILES[$upfile]['name']; // Get the name of the file (including file extension).
	$temp_arr=explode(".",$_FILES[$upfile]['name']);
	if (sizeof($temp_arr)>1)
		$save_name=$temp_arr[0]."_".$timestamp.".".$temp_arr[1];
	else 
		$save_name=$filename."_".$timestamp; 
	
	$filesize=filesize($_FILES[$upfile]['tmp_name']);

	if (!is_dir($upload_path))
	{	if (!mkdir($upload_path,0777))	
		{       $log[]="Error in creating section directory";
                        die("Error in creating section directory"); 
                }	
		else 
			chmod($base_path,777);		
	}
	$upload_path=$upload_path . $belongstoID . '/';
        $upload_path1=$upload_path1 . $belongstoID . '/';
		
	if (!is_dir($upload_path))
        {        if (!mkdir($upload_path,0777))
		{	$log[]="Error in creating ID directory";
			die("Error in creating ID  irectory"); 
		}
	}
	// Now check the filesize, if it is too large then DIE and inform the user.
        if($filesize > $max_filesize)
        {       $log[]="File size greater than the MAXIMUM file size allowed";
		die("File size greater than the MAXIMUM file size allowed");
	}
	// Check if we can upload to the specified path, if not DIE and inform the user.
        if(!is_writable($upload_path))
	{	$log[]="Upload path not writable"; 
		$die("Upload path not writable"); 
	}

	// UPLOADING the file on the server
	if(move_uploaded_file($_FILES[$upfile]['tmp_name'],$upload_path .$save_name))
        {	chmod($upload_path. $save_name , 777);
		// PUT YOUR DB QUERY FUNCTION TO INSERT THE FILE INTO THE DB after it has been uploaded to the server.
		$a=sizeof($tags); $related_tags="";
		for ($i=0;$i<$a;$i++) 
		{	$tag=$tags[$i]; 
			$related_tags=$related_tags . $tags[$i] . ',';
			$tag_search=$fDB->find_tag($tag);
			if ($tag_search!=-1) 	
			{	if ($tag_search==0) 	// TAG NOT FOUND. ITS A NEW TAG. 
					$result=$fDB->insert_new_tag($tag,$category,$userID); 	// returns last_insert_id
				else 			// TAG EXISTS
				{	// append the new select and userid to the tag data found 
					$tagID=$tag_search['tagID'];
					if (stristr($tag_search['section'],$category)==FALSE)	
						$section=$tag_search['section'].",".$category;
					else 
						$section=$tag_search['section'];
					if (stristr($tag_search['usersID'],"'".$userID."'")==FALSE)
						$usersID=$tag_search['usersID'].",".$userID;
					else 
						$usersID=$tag_search['usersID'];
					$result=$fDB->update_new_tag($tagID,$section,$usersID);  // returns tagID of the updated row 
				}
			}
			else 
				$result=0;
		}
		if ($result>0)
			$result=$fDB->insert_file_details($filename, $related_tags, $userID, $category, $belongstoID, $filesize, $upload_path1, $timestamp ); 
		// $result has the autoincremented last_insert_id() OR the tagID of the table in which the file details have been submitted.
		if ($result>0)
                	echo "<div id='upload_message' title='success'>Successful";
                else
                        echo "<div id='upload_message' title='fail'>";
                echo "</div>";
		$log[]="File uploaded successfully"; 
	}
	else 
	{	echo "<div id='upload_message' title='Error In file Upload'> "; echo "</div>";
		$log[]="Error In file Upload";		
	}

	// IF The recently uploaded file has to be immediately shown in some other section then send the following details:
	$filesize=formatBytes($filesize, 1);
	$fdate=date("Y-m-d H:i A", $timestamp);
	$related_tags=trim($related_tags,",") ;
	echo "<script>window.parent.afterUpload('$result','$filename','$related_tags','$fdate','$upload_path1','$filesize','$username','$category','$belongstoID','$save_name');</script>"; 

} // END OF UPLOAD 

if(isset($_POST['delete_file']))
{
	$fileID=$_POST['fileID'];
	echo $fDB->delete_uploaded_file($fileID); 	
}


if(isset($_POST['get_suggestions']))
{	$word=$_POST['word'];
	$result=$fDB->get_suggestions_for_tag($word);
	if (sizeof($result)>0)
	{	$output=json_encode($result); 
		echo $output; 
	}
	else
		echo 0;  
}

?>

