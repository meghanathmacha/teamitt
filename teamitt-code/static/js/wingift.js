function isNum(s) {
    isWhole_re = /^\s*\d+\s*$/;
    vals = String(s).search(isWhole_re);
    if (vals == -1) {
        return 0;
    } else {
        return 1;
    }
}

function goToByScroll(id){
     $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
return false;
}





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
function resetbid(retext)
{
$thank = $(retext).parent();
$thank.css("display","none");
$thank.prev().css("display","block");

}


function postBid(userid, $form, $formContainer, $formMsg)
{
var bid_point = $form.children(".bid-point").val();
            var giftid = $form.children(".giftid").val();
            bid_point = $.trim(bid_point);
            if (!isNum(bid_point)) {
                alert("Please enter numbers only for points !");
                return false;
            }
            url = "includes/postBid.php";
            txt = "<div class='loading'>&nbsp;</div>";
          $formMsg.html(txt);
	    $formContainer.css("display", "none");
            $formMsg.css("display", "block");

$.post(url, {
                type: "bid-ajax",
                giftid: giftid,
                points: bid_point,
                userid: userid
            },  function (data) {
		if(data["status"]==1)
		{
		txt = "<h3 class='suc'>"+data["msg"]+"</h3>";
                $formMsg.html(txt);
		}
		else if(data["status"]==2)
		{
 		txt = "<h3 class='err'>"+data["msg"]+" !</h3><span onclick='resetbid(this);'  class='resetbid'>Try again ! </span>";
                $formMsg.html(txt);
		}
		else {  
 		txt = "<h3 class='err'>"+data["msg"]+" !</h3>";
                $formMsg.html(txt);
		}

            },"json"
	);
        


}



function showbidform($par, bidnow)
{

$(bidnow).fadeOut(200,function (){
$par.children(".bid-form-thank").css("display","none");
$par.children(".bid-form-container").fadeIn(200);
$par.find(".bid-point").focus();

});

}



$("document").ready(function (){


$(".bid-now").live("click",function (){

var $par= $(this).parent();
var btext = this;
        if ((userid = getid())) {
showbidform($par, btext);
}
else
{
FB.login(function(response) {
  if (response.session) {
    // user successfully logged in
showbidform($par, btext);

  } else {
    // user cancelled login
	}
});

}

});


$(".BidForm").submit(function () {
        var userid = 0;
var $par=$(this).parent();
var $thankdiv = $par.next();
$form= $(this);
        if ((userid = getid())) {
        postBid(userid, $form, $par, $thankdiv);    	
	}

else
{

FB.login(function(response) {
  if (response.session) {
    // user successfully logged in
    userid = FB.getSession().uid; // 1 as id
        postBid(userid, $form, $par, $thankdiv);    	

  } else {
    // user cancelled login
  id=0;
         txt = "<h3 class='err'>You are not logged in !</h3>";
            $thankdiv.html(txt);
            $par.css("display", "none");
            $thankdiv.css("display", "block");
	$par.parent().children(".bid-now").fadeIn(100);
	}
});

}

        return false;

});


$(".add-now").click(function (){
rewardid=$(this).attr("rewardid");
$("#gift"+rewardid).addClass("transact");
addgoal(rewardid);

});


$(".newGoal").live("click",function (){
if($(this).hasClass("gsel"))
{
$(this).removeClass("gsel");
}
else
{
$(".newGoal").removeClass("gsel");
$(this).addClass("gsel");
}


});


$(".addnewLabel").live("click",function (){

$(this).next().css("display","block");

});

});

function newGoal(form, event)
{
event.preventDefault();
$inp=$(form).children("input[name='goaltitle']");
$rew=$(form).children("input[name='rewardid']");
title=$inp.val();
rewardid=$rew.val();

if(title!="")
{
$("#eventFooter span").addClass("submitting").text("Adding new goal ..");
url="includes/rewards.php";
$.post(url,
	{rewardid: rewardid,
	title: title,
	action: "new"
	}, function (data) {

if(data.status)
{
$("#gift"+rewardid).removeClass("inactive").addClass("active");
$("#gift"+rewardid).find(".err-span").remove();
$("#btn"+rewardid).removeClass("add-now").addClass("bid-now").text("Bid Now");
$("#btn"+rewardid).trigger("click");
goToByScroll("gift"+rewardid);
//show the bid form

closeEvent();

}
else
{
$("#eventFooter span").removeClass("submitting").text("");
alert(data.msg);
}


}, "json" );



}

return false;
}


function addgoal(rewardid)
{


		$("#eventCont").fadeIn(300);
		$("#eventWrap .etext").css("display","none");
		$(".eload").html("Loading...");
url="includes/rewards.php";
$.post(url, {
                rewardid: rewardid,
                action: "show"
            },  function (data) {
			
		$(".eload").html("");
		$("#eventWrap .etext").html(data);
		$("#eventWrap .etext").css("display","block");
	
            }
	);

}


function submitGoal(rewardid)
{
$("#eventFooter input[type='button']").attr("disabled","true");

var goalid=$(".gsel").attr("goalid");

if(goalid)
{

$(".newGoals").css("opacity","0.6");
$("#eventFooter span").addClass("submitting").text("Adding . . .");
url="includes/rewards.php";
$.post(url,
	{goalid:goalid,
	rewardid:rewardid,
	action:"save"
	},function (data){

if(data.status)
{
$("#gift"+rewardid).removeClass("inactive").addClass("active");
$("#gift"+rewardid).find(".err-span").remove();
$("#btn"+rewardid).removeClass("add-now").addClass("bid-now").text("Bid Now");
$("#btn"+rewardid).trigger("click");
goToByScroll("gift"+rewardid);
//show the bid form

closeEvent();
//
}
else
{
$("#eventFooter span").removeClass("submitting").text("");
alert(data.msg);
}


},"json");
	

}
else
{
closeEvent();
}


}

function closeEvent()
{
$("#eventCont").fadeOut(300);
$("#gift"+rewardid).removeClass("transact");
}


function hideflash()
{
$("#flash").slideUp(400);
}
