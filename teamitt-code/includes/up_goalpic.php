<?php

/*session_start();
  if(isset($_SESSION["fbid"]))
  {
  $userid = $_SESSION["fbid"];
  }
  else
  {
  die();
  }*/
$isimage=0;
$flag=0;
if(isset($_FILES['goalpic']))
{
	print_r ($_FILES);
	$isimage=1;
	?>

		<?php
		$name=$_FILES['goalpic']['name'];
	$limit=3000000;
	$mime=$_FILES['goalpic']['type'];
	$size=$_FILES['goalpic']['size'];
	$arr['image/jpg']=1;
	$arr['image/jpeg']=1;
	$arr['image/pjpeg']=1;
	$arr['image/png']=1;
	$arr['image/x-png']=1;
	$arr['image/gif']=1;
	$flag=0;
	$target_image="abc";
	$ext=substr($mime,6);

	if($size>=$limit)
	{
		//echo  "<script>alert('feffrefrere1');</script>";
		$err="Image file size exceeded. Max accepted size is 4 MB !";
		$flag=1;
	}

	else if(!isset($arr[$mime]))
	{
		//echo  "<script>alert('feffrefrere2');</script>";
		$err="Image format not supported ! (only jpeg,jpg,png and gifs are allowed).";
		$flag=1;
	}
	else if($_FILES['goalpic']['error']!=UPLOAD_ERR_OK)
	{
		//echo  "<script>alert('feffrefrere3');</script>";
		$err="Uploading error ! try again.";
		$flag=1;
	}

	else{

		//echo  "<script>alert('fefre');</script>";
		$id=$_GET["id"];
		$path="uploads/goalimg/goalimg-";
		$path=$path.$id;
		$target_image="../".$path.".".$ext;

		$testpath="../uploads/goalimg/goalimg-".$id.".jpg";
		$addpicpoint=0;
		/*if(!file_exists($testpath))
		  {
		  require_once("../DB/initDB.php");
		  require_once("../DB/goalsDB.php");
		  $DB = new goalsDB();
		  $addpicpoint=1;
		  }*/
		$moves=move_uploaded_file($_FILES['goalpic']['tmp_name'],$target_image);

		$tmp=$_FILES['goalpic']['tmp_name'];


		chmod(755,$target_image);
		//echo  "<script>alert('$moves');</script>";
		if($moves)
		{
			//echo  "<script>alert('move');</script>";
			$flag=0;
			$err="Goal pic updated.";

			$newimg= "../".$path.".jpg";
			$newimgpath= $path.".jpg";
			$cmd="convert -size 150x200 $target_image -resize 150x200  $newimg";
			shell_exec($cmd);
			unlink($target_image);
			chmod(755,$newimg);
			/*if($addpicpoint)
			  {
			  $DB->addGoalPoints($id, "goalpic",$userid,50,0,0);
			  }
			 */

		}
		else
		{
			$flag=1;
			$err="Unknown error occured.";
		}

	}
	//ho  "<script>alert('reaced');</script>";
	echo "<script>window.parent.picupload('$err',$flag,'$newimgpath',$addpicpoint);</script>";

}

?>
