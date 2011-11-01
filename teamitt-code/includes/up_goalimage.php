<?php
$isimage=0;
$flag=0;
if(isset($_FILES['goalpic']))
{
$isimage=1;
$goalId=$_POST['goalId'];
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
$err="Image file size exceeded. Max accepted size is 4 MB !";
$flag=1;
}

else if(!isset($arr[$mime]))
{
$err="Image format not supported ! (only jpeg,jpg,png and gifs are allowed).";
$flag=1;
}
else if($_FILES['companypic']['error']!=UPLOAD_ERR_OK)
{
$err="Uploading error ! try again.";
$flag=1;
}

else{
include("../checkid.php");
require_once("../DB/initDB.php");
/*                        require_once("../DB/registerDB.php");
                        $DB = new registerDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$id=$DB->getUserCompany($USERID);*/
//echo "<script>alert('nmae'); </script>";
$path="uploads/goalimg/goalimg-";
$path=$path.$goalId;
$save_path=$path.".".$ext;
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
if($moves)
{
$flag=0;
$err="Goal pic updated.";

$newimg= "../".$path.".jpg";
$newimgpath= $path.".jpg";
$cmd="convert -size 150x200 $target_image -resize 150x200  $newimg";
shell_exec($cmd);
unlink($target_image);
chmod(755,$newimg);
                        require_once("../DB/goalsDB.php");
                        $gDB = new goalsDB();
                        if(!$gDB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
		$gDB->updateGoalImage($newimgpath,$goalId);
/*if($addpicpoint)
{
$DB->addGoalPoints($id, "profilepic",$userid,50,0,0);
}
*/

}
else
{
$flag=1;
$err="Unknown error occured.";
}

}
echo "<script>window.parent.goalimageupload('$err',$flag,'$newimgpath');</script>";

}

?>
