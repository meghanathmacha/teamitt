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
$projectId=$_POST['projectId'];
if(isset($_FILES['projectpic']))
{
$isimage=1;
?>
<?php
$name=$_FILES['projectpic']['name'];
//echo "<script>alert('nitesh'); </script>";
$limit=3000000;
$mime=$_FILES['projectpic']['type'];
$size=$_FILES['projectpic']['size'];
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
$path="uploads/projectimg/projectimg-";
$path=$path.$projectId;
$save_path=$path.".".$ext;
$target_image="../".$path.".".$ext;

$testpath="../uploads/projectimg/projectimg-".$projectId.".jpg";
$addpicpoint=0;
/*if(!file_exists($testpath))
{
			require_once("../DB/initDB.php");
			require_once("../DB/goalsDB.php");
			$DB = new goalsDB();
$addpicpoint=1;
}*/
$moves=move_uploaded_file($_FILES['projectpic']['tmp_name'],$target_image);

$tmp=$_FILES['projectpic']['tmp_name'];


chmod(755,$target_image);
if($moves)
{
$flag=0;
$err="Project pic updated.";

$newimg= "../".$path.".jpg";
$newimgpath= $path.".jpg";
$cmd="convert -size 150x200 $target_image -resize 150x200  $newimg";
shell_exec($cmd);
unlink($target_image);
chmod(755,$newimg);
/*                        require_once("../DB/usersDB.php");
                        $uDB = new usersDB();
                        if(!$uDB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$uDB->updateCompanyImage($newimgpath,$id);
*/
}
else
{
$flag=1;
$err="Unknown error occured.";
}

}
echo "<script>window.parent.projectimageupload('$err',$flag,'$newimgpath');</script>";

}

?>
