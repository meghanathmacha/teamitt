<?php
include("imagefunctions.php");

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
$path="dealImg-";
$path=$path.$dealid;

$target_image="uploads/dealimg/".$path.".".$ext;
$avatar_image="uploads/dealimg/".$path."_avatar.".$ext;

echo "image sent to move";
$moves=move_uploaded_file($_FILES['giftimg']['tmp_name'],$target_image);


chmod(755,$target_image);
if($moves)
{
$DB->uploadImage($dealid, $ext);
unlink($avatar_image);


    $max_width = 600; 
$large_image_location=$target_image;
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
        header("Location:deal3.php?id=".$dealid);
        die();
    }
    else
    {
        //make the original to be the avator of width 200 and height 120
            $scale=$thumb_width/$width;
            copy($target_image,$avatar_image);
chmod(755,$avatar_image);
        $uploaded = resizeImage($avatar_image,$width,$thumb_height,$scale);
            //Show other details
            header("Location:showdeal.php?id=".$dealid);

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



?>
