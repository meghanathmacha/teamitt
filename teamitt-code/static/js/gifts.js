function isNum(s) {
    isWhole_re = /^\s*\d+\s*$/;
    vals = String(s).search(isWhole_re);
    if (vals == -1) {
        return 0;
    } else {
        return 1;
    }
}

function Position() {
    $("#bid-gift").css("top", $("#GiftTimer").offset().top);
    $("#bid-gift").css("left", $("#GiftTimer").offset().left - 130);
}
var ind = 0;
var giftno = 0;

function getid() {

var id=0;
FB.getLoginStatus(function(response) {
  if (response.session) {
    id = FB.getSession().uid; // 1 as id
   
	 // logged in and connected user, someone you know
  } else {
	id=0;
      }
});

// no user session available, someone you dont know
/*	FB.login(function(response) {
  if (response.session) {
    // user successfully logged in
    id = FB.getSession().uid; // 1 as id
  } else {
    // user cancelled login
  id=0;
	}
});

*/



    return id; // 1 as id
}


function startTransition() {
    var oldind = ind;
    ind = ind + 1;
    var currind = ind % 2;
    giftno = $("#giftno").val();
    url = "getgifts.php?giftno=" + giftno;
    $("#GiftDesc-Wrapper").animate({
        bottom: '-40px'
    }, 200);
    $.ajax({
        url: url,
        type: "GET",
        contentType: "application/json; charset=utf-8",
        // data:{some_string:"blabla"},
        dataType: "json",
        success: function (data) {
            $("#img" + currind).attr("src", data["imgpath"]);
            $("#giftno").val(data["giftno"]);
            $("#giftid").val(data["giftid"]);
            var desc = "<strong>" + data["title"] + "<strong> &raquo; Gift Id #" + data["giftid"] + "<br/>" + data["desc"];
            var bid = "bid";
            if (data["numbids"] > 1) {
                bid += "s";
            }
            var numbids = data["numbids"] + " " + bid + " so far.";
            $("#divimg" + oldind).removeClass("front").addClass("back");
            $("#divimg" + currind).removeClass("back").addClass("front");
            $("#bidcount").fadeOut(200, function () {
                $(this).html(numbids).fadeIn(200);
            });
            $("#divimg" + currind).animate({
                left: '0px'
            }, 600, function () {
                $("#divimg" + oldind).animate({
                    left: '300px'
                }, 0);
                $("#GiftDesc-Wrapper .gift-des").html(desc);
                $("#GiftDesc-Wrapper").animate({
                    bottom: '0px'
                }, 200);
            });
        }
    });
    ind = currind;
}

function showbidbox()
{

  $("#bid-cont  div").css("display", "none");
            $("#bid-area").css("display", "block");
        $(".bid-point").val('');
        $("#bid-gift").css("display", "block");
        $("#bid-gift").animate({
            left: '+=210px'
        }, 'slow');


}




function bid() {
    if ($("#bid-gift").is(":visible")) {
        $("#bid-gift").animate({
            left: '-=210px'
        }, 400, function () {
            $(this).css("display", "none");
        });
    } else {
        var userid = getid();
        if (!userid) {

	FB.login(function(response) {
  if (response.session) {
    // user successfully logged in
    id = FB.getSession().uid; // 1 as id
	showbidbox();

  } else {
    // user cancelled login
  id=0;
         /*   txt = "<h3 class='err'>You are not <br/>logged in !</h3>";
            $("#bid-thank").html(txt);
            $("#bid-cont  div").css("display", "none");
            $("#bid-thank").css("display", "block");*/
	}
		});

        } else {
    showbidbox();    
    }
 }
}

function resetbid()
{
$("#bid-cont  div").css("display", "none");
 $("#bid-area").css("display", "block");

}

function postBid(userid)
{
var bid_point = $(".bid-point").val();
            var giftid = $("#giftid").val();
            bid_point = $.trim(bid_point);
            if (!isNum(bid_point)) {
                alert("Please enter numbers only for points !");
                return false;
            }
            url = "postBid.php";
            txt = "<img src='gift-img/loading.gif'/>";
            $("#bid-thank").html(txt);
	    $("#bid-cont  div").css("display", "none");
            $("#bid-thank").css("display", "block");

$.post(url, {
                type: "bid-ajax",
                giftid: giftid,
                points: bid_point,
                userid: userid
            },  function (data) {
		
		if(data["status"]==1)
		{
		txt = "<h3 class='suc'>"+data["msg"]+"!</h3>";
                $("#bid-thank").html(txt);
                setTimeout("bid()", 2000);
		}
		
		else if(data["status"]==2)
		{
 		txt = "<h3 class='err'>"+data["msg"]+"!</h3><span onclick='resetbid();'id='resetbid'>Try again ! </span>";
                $("#bid-thank").html(txt);
		}
		else {  
 		txt = "<h3 class='err'>"+data["msg"]+"!</h3>";
                $("#bid-thank").html(txt);
			
		}

            },"json"
	);
        



}


$("document").ready(function () {
/* Call startup functions here  */
    Position(); /* To adjust position of bidding window */
    timerinit(); /* To start the timer in timer.js file. */

/* Initialize some variable  */
    giftno = 0;
    ind = 0;

    $("#BidForm").submit(function () {
        var userid = 0;
        if ((userid = getid())) {
        postBid(userid);    	
	}
	else
{

FB.login(function(response) {
  if (response.session) {
    // user successfully logged in
    userid = FB.getSession().uid; // 1 as id
        postBid(userid);    	

  } else {
    // user cancelled login
  id=0;
         txt = "<h3 class='err'>You are not <br/>logged in !</h3>";
            $("#bid-thank").html(txt);
            $("#bid-cont  div").css("display", "none");
            $("#bid-thank").css("display", "block");
	     setTimeout("bid()",1000);
	}
		});

}
        return false;
    });
});



