<?php
include("ajaxid.php");
$isimage=0;
$flag=0;
if(isset($_FILES['profilepic']))
{
$isimage=1;
?>

<?php
$name=$_FILES['profilepic']['name'];
//echo "<script>alert('nitesh'); </script>";
$limit=3000000;
$mime=$_FILES['profilepic']['type'];
$size=$_FILES['profilepic']['size'];
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
else if($_FILES['profilepic']['error']!=UPLOAD_ERR_OK)
{
$err="Uploading error ! try again.";
$flag=1;
}

else{

$id=$USERID;
$path="uploads/profileimg/profileimg-";
$path=$path.$id;
$save_path=$path.".".$ext;
$target_image="../".$path.".".$ext;

$testpath="../uploads/profileimg/profileimg-".$id.".jpg";
$addpicpoint=0;
/*if(!file_exists($testpath))
{
			require_once("../DB/initDB.php");
			require_once("../DB/goalsDB.php");
			$DB = new goalsDB();
$addpicpoint=1;
}*/
$moves=move_uploaded_file($_FILES['profilepic']['tmp_name'],$target_image);

$tmp=$_FILES['profilepic']['tmp_name'];


chmod(755,$target_image);
if($moves)
{
$flag=0;
$err="Profile pic updated.";

$newimg= "../".$path.".jpg";
$newimgpath= $path.".jpg";
$cmd="convert -size 150x200 $target_image -resize 100x100  $newimg";
shell_exec($cmd);
unlink($target_image);
chmod(755,$newimg);
require_once("../DB/initDB.php");
                        require_once("../DB/checkUser.php");
                        $DB = new userDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$DB->updateImage($newimgpath,$id);
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
echo "<script>window.parent.imageupload('$err',$flag,'$newimgpath');</script>";

}

?>
