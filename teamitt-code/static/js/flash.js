function showFlash(msg)
{
	$("#flash").text(msg);	
	$("#flash").slideDown(300);
	setTimeout("hideFlash()",4000);
}
function hideFlash()
{
	$("#flash").slideUp();
}
