function companyimagetaken(){
	$("#company-image-upload-load").addClass("upload-act").css("display","block");
	$("form[name='companypicform']").submit();
}

function companyimageupload(msg, state, imgpath)
{
$("#flash").text(msg);
$("#flash").slideDown(400);
setTimeout(function () { $("#flash").slideUp(500); }, "3000");

if(state==0)
{
$('#fileUpload').val(imgpath);
imgpath=imgpath+"?timestamp=" + new Date().getTime();
$("#companydp").attr("src",imgpath);
$(".company-image-upload-text span.txt").text("Change Company Pic");

}
$("#company-image-upload-load").removeClass("upload-act").css("display","none");
setTimeout("hideflash()",4000);
}


