function showbadges(){
$(".eload").text("Loading..");
$(".etext").html("");
$("#eventCont").fadeIn();
url="includes/getbadges.php";
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
plarray["action"]="Post action for yourself or to your connections.";
plarray["thank"]="Post thanks to your connections.";
plarray["update"]="Post updates to your company feed.";

var smarray=new Array();
smarray["action"]="(leave it blank if action is for you)";
smarray["thank"]="(add people who you want to thank)";

$("document").ready(function (){
//alert(LOGGED_IN_USER_ID);
//alert("done");
$(".postTitle span").click(function (){
if($(this).hasClass("selected")){ return ;}

$(".postTitle .selected").removeClass("selected");
$(this).addClass("selected");
but_id= this.id;
pltext=plarray[but_id]
$("#postEditor").attr("placeholder", pltext);
if(but_id=="update")
{
$("#post_recv").css("display","none");
$(".badges").css("display", "none");
}
else
{
$("#post_recv").css("display","block");
smtxt=smarray[but_id];
$("#post_recv").find("small:first").text(smtxt);
$("#post_recv .recv").html("");
if(but_id =="action")
{
$(".badges").css("display", "none");
}
else { 
$(".badges").css("display", "block"); }
}


});


$(".rp").live("click",function (){
$par=$(this).parent();
$par.fadeOut(function (){ $(this).remove(); });

});


$(".postButton input[type='button']").click(function (){

var this_but = $(this);
var post = $("#postEditor").val();
post=$.trim(post);
if(post!="")
{
posttype=$(".postTitle .selected").attr("id");
var userids="";
var badgeid =0;
if(posttype != "update")
{
var uids=new Array();
$(".recv span").each(function (){
var uid=$(this).attr("uid");
uids.push(uid);
});
if(posttype =="thank"){

}
if(uids.length)
{
userids=uids.join(",");
}
else if(posttype=="thank")
{
alert("You have got to thank someone, so please add names");
return;
}

if($("div.badge:visible").length)
{
badgeid= $(".badge").attr("badgeid");
}

}
//Do the posting 
$("#postEditor").attr("disabled", "true");
this_but.attr("disabled", "true");
url="includes/user_post.php";
$.post(url, {
                type: posttype,
                post: post,
                userids: userids,
                badgeid: badgeid
            },  function (data) {
if(data==""){
alert("Error"); 
}
else if(data==0){
alert("You Don't have sufficient points to give to these many users");
$("#postEditor").removeAttr("disabled");
this_but.removeAttr("disabled");

}
else{
$(".feedArea").prepend(data);		
$("#postEditor").val("");
$(".recv").html('');

$("#postEditor").removeAttr("disabled");
this_but.removeAttr("disabled");
}
});




}



});



$(".delbadge").click(function (){
$(".badge").css("display","none");
$(".badge").attr("badgeid", "0");
$(".no-badge").css("display","block");
$(this).parent().removeClass("actbadge");
});


$(".select-badge").live("click", function (){
badgeid=$(this).attr("badgeid");
badgeurl=$(this).children("img").attr("src");
badgename=$(this).children(".badgename").text();
$(".badge").children("img").attr("src", badgeurl);
$(".badge").children(".badgename").text(badgename);
$(".badge").attr("badgeid", badgeid);
$(".badge").css("display","block");
$(".no-badge").css("display","none");
$(".badges").addClass("actbadge");
closeEvent();
});
 
$(".cant-select-badge").live("click",function (){
alert("You Dont Have Enough Points To Use This Badge");
});
$(".badges").children(":not(.delbadge)").click(function (){
showbadges();
});

});
