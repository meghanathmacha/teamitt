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





$("document").ready(function (){
$(".postTitle span").click(function (){
if($(this).hasClass("selected")){ return ;}

$(".postTitle .selected").removeClass("selected");
$(this).addClass("selected");
but_id= this.id;
pltext=plarray[but_id]
$("#postEditor").attr("placeholder", pltext);
if(but_id =="thank")
{
$(".badges").css("display", "block"); 
$(".postButton small").fadeOut();
}
else { 
$(".badges").css("display", "none");
$(".postButton small").fadeIn();
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



if($("div.badge:visible").length)
{
badgeid= $(".badge").attr("badgeid");
}

//Do the posting 

url="includes/user_post.php";
$("#postEditor").attr("disabled", "true");
this_but.attr("disabled", "true");
$.post(url, {
                type: posttype,
                post: post,
                badgeid: badgeid
            },  function (data) {

if(data==0){
alert("You Don't have sufficient points to give to these many users");
$("#postEditor").removeAttr("disabled");
this_but.removeAttr("disabled");

}
else {
$("div.feedArea").prepend(data);		
$("#postEditor").removeAttr("disabled");
this_but.removeAttr("disabled");
$("#postEditor").val("");
}

});
}

});



$(".delbadge").click(function (){
$(".badge").css("display","none");
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

$(".badges").children(":not(.delbadge)").click(function (){
showbadges();
});


});
