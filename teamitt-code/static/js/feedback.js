$("document").ready(function ()
{
$("#giveFeedback").live("submit",function (event)
{
var formVals=$(this).serialize();
alert(formVals);
url="includes/feedbackactions.php";
$.post(url,{
	param:"submitFeedback",
	vals:formVals,
	},function(data){
$("#moreCont #eventCont .etext").css("display","none");
$("#moreCont #eventCont .eload").html("Feedback Submitted Successfully").css("display","block");
setTimeout("closePopupEvent()",2000);

	}
	);
});
});
function popupEvent(param,userProfileId)
{
 $("#moreCont #eventCont").fadeIn(300);
                $("#eventWrap .etext").css("display","none");
                $(".eload").html("Loading...");
url="includes/feedbackactions.php";
$.post(url, {
                param: param,
		userProfileId:userProfileId,
            },  function (data) {

                $(".eload").html("");
                $("#eventWrap .etext").html(data);
                $("#eventWrap .etext").css("display","block");
	}
        );

}
function closePopupEvent()
{
$("#moreCont #eventCont").fadeOut(300);
}
function submitFeedback(userProfileId)
{
/*alert('reac');
alert(userProfileId);
v=$('#e').val();
alert(v);
$("#giveFeedback").live("submit",function (event)
{
alert("f");
var formValss=$(this).serialize();
alert(formValss);

}
*/
}
