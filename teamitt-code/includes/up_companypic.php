<?php

$isimage=0;
$flag=0;
if(isset($_FILES['companypic']))
{
$isimage=1;
?>
<?php
$name=$_FILES['companypic']['name'];
$limit=3000000;
$mime=$_FILES['companypic']['type'];
$size=$_FILES['companypic']['size'];
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
                        require_once("../DB/registerDB.php");
                        $DB = new registerDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$id=$DB->getUserCompany($USERID);
//echo "<script>alert('nmae'); </script>";
$path="uploads/companyimg/companyimg-";
$path=$path.$id;
$save_path=$path.".".$ext;
$target_image="../".$path.".".$ext;

$testpath="../uploads/companyimg/companyimg-".$id.".jpg";
$addpicpoint=0;
/*if(!file_exists($testpath))
{
			require_once("../DB/initDB.php");
			require_once("../DB/goalsDB.php");
			$DB = new goalsDB();
$addpicpoint=1;
}*/
$moves=move_uploaded_file($_FILES['companypic']['tmp_name'],$target_image);

$tmp=$_FILES['companypic']['tmp_name'];


chmod(755,$target_image);
if($moves)
{
$flag=0;
$err="Company pic updated.";

$newimg= "../".$path.".jpg";
$newimgpath= $path.".jpg";
$cmd="convert -size 150x200 $target_image -resize 150x200  $newimg";
shell_exec($cmd);
unlink($target_image);
chmod(755,$newimg);
                        require_once("../DB/usersDB.php");
                        $uDB = new usersDB();
                        if(!$uDB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$uDB->updateCompanyImage($newimgpath,$id);
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
echo "<script>window.parent.companyimageupload('$err',$flag,'$newimgpath');</script>";

}

?>
