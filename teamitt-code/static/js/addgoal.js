var maxreward=2;
var maxpeople=2;

$("document").ready(function (){


$(".reward").live("click",function (){

var cnt=$("#rC").text();
cnt=parseInt(cnt);
if($(this).hasClass("rselected"))
{
$(this).removeClass("rselected");
cnt = cnt - 1;
}
else if(cnt< maxreward)
{
$(this).addClass("rselected");
cnt = cnt+1;
}
$("#rC").text(cnt);

});

$(".people").live("click",function (){

var cnt=$("#pC").text();
cnt=parseInt(cnt);
if($(this).hasClass("pselected"))
{
$(this).removeClass("pselected");
cnt = cnt - 1;
}
else if(cnt< maxpeople)
{
$(this).addClass("pselected");
cnt = cnt+1;
}
$("#pC").text(cnt);

});




$(".loadMore").click(function (){

$par=$(this).parent();
$div=$(this);

param=$(this).attr("param");
if(param =="people")
{
imparam="height='140px'";
}
else
{
imparam="width='200px'";
}
offset=$(this).attr("offset");
url="includes/goalMore.php";

$.post(url,
	{param: param,
	offset: offset
	}, function (data) {

if(data[0].more)
{

var str="";
for(i=1; i< data.length; i++)
{
var paramid=data[i].id;
title=data[i].title;
path=data[i].path;
imgpath=path+"?timestamp=" + new Date().getTime();
str +="<div class='reward-wrap'>";
str += "<div class='"+param+"'" + param +"id='"+ paramid +"'>";

str += "<div class='reward-img'>";

str +="<img src="+ imgpath +" "+imparam+" />";
str +="</div>";
str += "<div class='reward-title'>";
str += title ;
str +="</div>";
str += "</div>";
str += "</div>";
}

$(str).insertBefore($par);

numrow=data[0].numrow;
if(numrow < 20)
{
$par.css("display","none");
}
else
{
offset=parseInt(offset)+numrow;
$div.attr("offset",offset);
}


}
else
{
$par.css("display","none");


}



}, "json");



});



});

function getid() {

var id=0;
FB.getLoginStatus(function(response) {
  if (response.session) {
    id = FB.getSession().uid; // 1 as id
   
  } else {
	id=0;
      }
});

    return id; // 1 as id
}



function submitForm()
{

if ((userid = getid())) {
sendForm(userid);
}
else
{
FB.login(function(response) {
  if (response.session) {
// user successfully logged in
 userid = FB.getSession().uid;
sendForm(userid);

   } else {
       	}
       	});
   }

}

function sendForm(userid)
{
var title=$("#goaltitle").val();
title=$.trim(title);
if(title=="")
{
navigate("reset");
$("#goaltitle").addClass("blank");
$("#goaltitle").focus();
return false;

}

$("#title").val(title);
$("#userid").val(userid);

var rewards= new Array();

$(".rselected").each(function (index){
rewards[index]=$(this).attr("rewardid"); 
});

var rids= rewards.join(",");
$("#rids").val(rids);

var peoples= new Array();

$(".pselected").each(function (index){
peoples[index]=$(this).attr("peopleid"); 
});

var pids= peoples.join(",");
$("#pids").val(pids);


$("#addgoal").submit();

}



function checkkey(event)
{
if(event.keyCode==13)
{
navigate("next");
}
}

function navigate(dir)
{
if(dir=="next")
{
$("#boxContainer").animate({left:"-=600px"},'slow');
}
else if(dir=="prev")
{
$("#boxContainer").animate({left:"+=600px"},'slow');
}
else if(dir=="reset")
{
$("#boxContainer").animate({left:"0px"},'slow');
}
}
