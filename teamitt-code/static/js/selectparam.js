$("document").ready(function (){


$(".reward").live("click",function (){
var cnt=$("#rC").text();
cnt=parseInt(cnt);
if($(this).hasClass("rchanged"))
{
$(this).removeClass("rchanged");
}
else {
$(this).addClass("rchanged");
}
if($(this).hasClass("rselected"))
{
$(this).removeClass("rselected");
cnt = cnt - 1;
}
else {
$(this).addClass("rselected");
cnt = cnt+1;
}

$("#rC").text(cnt);

});

});

function closeEvent()
{
$("#eventCont").fadeOut();

}


function submitConnections(feed_id)
{
psel="rselected";
pattr="rewardid";
change="rchanged";
$("#eventFooter input[type='button']").attr("disabled","true");
var share_us = new Array();
var forget_us = new Array();
var share_count =forget_count = 0;
$("."+change).each(function (index){
if($(this).hasClass(psel))
{
	share_us[share_count]=$(this).attr(pattr); 
	share_count++;
}
else
{
	forget_us[forget_count]=$(this).attr(pattr); 
	forget_count++;
}

});

if(share_count == 0 && forget_count == 0)
	closeBox();
if(share_us.length || forget_us.length)
{
var shareids= share_us.join(",");
var forgetids = forget_us.join(",");
$(".rewards").css("opacity","0.6");
$("#eventFooter span").addClass("submitting").text("Adding . . .");
url="comments.php";

$.post(url,{
	forgetids: forgetids,
	shareids: shareids,
	sharingFeeds:1,
	feed_id:feed_id	
	}, function (data){
	closeBox();
//	alert(data);
msg = "Visibility Successfully Changed";
showFlash(msg);

});

}
}
function submitParam(id, param)
{
psel="rselected";
pattr="rewardid";

$("#eventFooter input[type='button']").attr("disabled","true");
var params= new Array();

$("."+psel).each(function (index){
params[index]=$(this).attr(pattr); 

});

if(params.length)
{
var paramids= params.join(",");

$(".rewards").css("opacity","0.6");
$("#eventFooter span").addClass("submitting").text("Adding . . .");
url="includes/users_connections.php";
if(param=="goalContributor"){
goalId=GOAL_ID;
projectId=0;
}
else if(param=="projectContributor"){
projectId=PROJECT_ID;
goalId=0;
}
else{
goalId=0;
projectId=0;
}
$.post(url,{
	param: param,
	action:"save",
	ids: paramids,
	goalid:goalId,
	projectid:projectId,
	}, function (data){
$("#flash").text(data[0].msg);
$("#flash").slideDown(300);
setTimeout("hideflash()",4000);
str="";
if(data[0].status)
{
for(i=1; i<data.length; i++)
{
var paramid=data[i].id;
title=data[i].title;
path=data[i].path;
if(path=="")
{
path="static/images/teamitt-user.jpg";
}
imgpath=path+"?timestamp=" + new Date().getTime();
//var imstr="<img src='"+imgpath+"' height='50px' />";
if(param=="goalContributor" || param=="projectContributor"){

	str+="<li><div class='userPic'><div style='float:left;'><a href='profile.php?id="+paramid+"'><img src='"+imgpath+"' style='width:50px;height:50px;'/></a></div><div class='userDesc'><a href='profile.php?id="+paramid+"'>"+title+"</a></div><div style='clear:both;'></div></div></li>";

}
else{
str+="<li><div class='tuserpic fl'><a href ='profile.php?id="+paramid+"'><img src='"+imgpath+"' style='width:50px;height:50px;' /></a></div><a href='profile.php?id="+paramid+"'>"+title+"</a></li>";
}

}
if(param=="goalContributor" || param=="projectContributor"){
$(".connections").find("ul:first").prepend(str);
}
else{
init_conn = $("#num_of_conn").text();
init_conn = parseInt(init_conn);
$("#num_of_conn").text(init_conn+data.length-1);
$(".connections").find("ul:first").prepend(str);
}
closeEvent();
}
else
{
closeEvent();
}
	}, "json");




}
else
{
closeEvent();
}



}


