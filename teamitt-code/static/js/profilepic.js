function imagetaken(){
	$("#image-upload-load").addClass("upload-act").css("display","block");
	$("form[name='profilepicform']").submit();
}

function imageupload(msg, state, imgpath)
{
$("#flash").text(msg);
$("#flash").slideDown(400);

if(state==0)
{
$('#fileUpload').val(imgpath);
imgpath=imgpath+"?timestamp=" + new Date().getTime();
$("#profiledp").attr("src",imgpath);
$(".image-upload-text span.txt").text("Change Profile Pic");

}
$("#image-upload-load").removeClass("upload-act").css("display","none");
setTimeout("hideflash()",4000);
}

