function showContributors(){

$(".eload").text("Loading..");
$(".etext").html("");
$("#eventCont").fadeIn();
url="includes/getContributors.php";
$.get(url, function (data) {

$(".etext").html(data);
$(".eload").fadeOut();
});


}



function closeEvent()
{
$("#eventCont").fadeOut(300);
}


var plarray=new Array();
plarray["action"]="Post action for yourslef and project contributors.";
plarray["update"]="Post update for this project.";



$("document").ready(function (){
$(".postTitle span").click(function (){
if($(this).hasClass("selected")){ return ;}

$(".postTitle .selected").removeClass("selected");
$(this).addClass("selected");
but_id= this.id;
pltext=plarray[but_id]
$("#postEditor").attr("placeholder", pltext);
if(but_id=="update")
{
$("#project_post_recv").css("display","none");
$(".assignedto").fadeOut(200);
}
else
{
$("#project_post_recv").css("display","block");
$(".assignedto").fadeIn(200);
}


});






$(".rp").live("click",function (){
$par=$(this).parent();
$par.fadeOut(function (){ $(this).remove(); });

});


$("#project_post_cont").children("li").click(function () {
num = $(".assignedto span").text();
num = parseInt(num);
if($(this).hasClass("sel"))
{
$(this).removeClass("sel");
num = num-1;
}
else
{
$(this).addClass("sel");
num = num+1;
}
if(num >= 0)
{
$(".assignedto span").text(num);
}

});


$(".postButton input[type='button']").click(function (){

var this_but = $(this);
var post = $("#postEditor").val();
post=$.trim(post);
if(post!="")
{
posttype=$(".postTitle .selected").attr("id");

var userids="";
var uids=new Array();
$("#project_post_cont .sel").each(function (){
var uid=$(this).attr("userid");
uids.push(uid);
});

if(uids.length)
{
userids=uids.join(",");
}
else if(posttype=="action")
{
alert("please assign this action to someone");
return;
}

//Do the posting 

$("#postEditor").attr("disabled", "true");
this_but.attr("disabled", "true");
url="includes/project_post.php";
$.post(url, {
                type: posttype,
                post: post,
                userids: userids
            },  function (data) {
$("#ProjectFeedCont").prepend(data);		
$("#postEditor").val("");

$("#postEditor").removeAttr("disabled");
this_but.removeAttr("disabled");
});
}

});




$(".select-cont").live("click", function (){
userid=$(this).attr("userid");
username=$(this).children(".username").text();
closeEvent();
});

$(".project_cont ul").children(".more").click(function (){
showContributors();
});


});
