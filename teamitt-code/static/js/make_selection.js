$("document").ready(function (){


$(".reward").live("click",function (){
var cnt=$("#rC").text();
cnt=parseInt(cnt);
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

url="includes/company.php";

$.post(url,{
	param: param,
	action:"save",
	ids: paramids,
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
imgpath=path+"?timestamp=" + new Date().getTime();
var imstr="<img src='"+imgpath+"' height='50px' />";
str+="<li><div class='tuserpic fl'>"+imstr+"</div>"+"<a href='http://home.goalcat.com/teamitt/profile.php?id="+paramid+"'>"+title+"</a></li>";

}
$(".connections").find("ul:first").append(str);
closeEvent();
}
else
{
closeEvent();
}
	},"json");




}
else
{
closeEvent();
}



}


