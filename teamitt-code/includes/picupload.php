<?php
include("imagefunctions.php");
if (isset($_POST["upload_thumbnail"])){ // && strlen($large_photo_exists)>0) {

$x1 = $_POST["x1"];
$y1 = $_POST["y1"];
$x2 = $_POST["x2"];
$y2 = $_POST["y2"];
$w = $_POST["w"];
$h = $_POST["h"];
$scale = $thumb_width/$w;
$large_image_location="giftimg/giftImg-1.jpeg";
$thumb_image_location="giftimg/giftImg-1_thumb.jpeg";

$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
header("location:".$_SERVER["PHP_SELF"]);
exit();
}


$isimage=0;
$flag=0;
if(isset($_FILES['giftimg']))
{
$isimage=1;
    //$semail=$_COOKIE['semail'];
?>

<?php
$limit=3000000;
$mime=$_FILES['giftimg']['type'];
$size=$_FILES['giftimg']['size'];
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
$err="Image File Size Exceeded. Max accepted size is 4 MB !";
$flag=1;
}

else if(!isset($arr[$mime]))
{
$err="Image Format Not Supported ! (only jpeg,jpg,png,bmp and gifs are allowed)";
$flag=1;
}
else if($_FILES['giftimg']['error']!=UPLOAD_ERR_OK)
{
$err="Uploading Error ! Try again ";
$flag=1;
}

else{


$dates=date('h_m_s');
$path="giftImg-";
$path=$path.$giftid;

$target_image="uploads/giftimg/".$path.".".$ext;
$avatar_image="uploads/giftimg/".$path."_avatar.jpg";

echo "image sent to move";
$moves=move_uploaded_file($_FILES['giftimg']['tmp_name'],$target_image);


chmod(755,$target_image);
if($moves)
{

$newimg= "uploads/giftimg/".$path.".jpg";
$cmd="convert $target_image $newimg";
shell_exec($cmd);
unlink($target_image);


$DB->uploadImage($giftid, $newimg);
unlink($avatar_image);


    $max_width = 600; 
$large_image_location=$newimg;
    $width = getWidth($large_image_location);
    $height = getHeight($large_image_location);
    
    if ($width > $max_width){
        $scale = $max_width/$width;
        $uploaded = resizeImage($large_image_location,$width,$height,$scale);

    }else{
        $scale = 1;
        $uploaded = resizeImage($large_image_location,$width,$height,$scale);
    }

    if($width>220)
    {
        //go for cropping
        header("Location:step3.php?id=".$giftid);
        die();
    }
    else
    {
        //make the original to be the avator of width 200 and height 120
            $scale=$thumb_width/$width;
            copy($newimg,$avatar_image);
chmod(755,$avatar_image);
        $uploaded = resizeImage($avatar_image,$width,$thumb_height,$scale);
            //Show other details
            header("Location:showgift.php?id=".$giftid);

    }


//Create the upload directory with the right permissions if it doesn't exist

//Check to see if any images with the same name already exist
}
else
{

$err="File can't be moved ";
$flag=1;
}

}

}

?>
