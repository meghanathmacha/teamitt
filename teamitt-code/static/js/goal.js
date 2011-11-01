var mode="";
$("document").ready(function ()
{
$("#newitemForm").live("submit",function (event)
{
$("#formLoad").removeClass().html("").addClass("formLoad");
$("#formsub").attr("disabled","true");
$(this).addClass("formSubmit");
$('#visibility').val($('#visibility_select').val());
$('#progress').val($('#progress_select').val());
var formVals=$(this).serialize();
var goalid="";
if(mode=="edit"){
action="update";
goalid=GOAL_ID;
}
else if(mode=="new"){
action="submit";
}
$.post("includes/goalactions.php",
{param:"goal", action:action, values:formVals,goalid:goalid  }, function(data) {
if(!data["success"])
{
var err=" Failed: "+data["err"];
$("#formLoad").removeClass().html(err).addClass("err");
$("#formsub").removeAttr("disabled");
$("#newItemForm").removeClass("formSubmit");
$(this).removeClass();
}
else
{

$("#eventCont .etext").css("display","none");
$("#eventCont .eload").html(data["err"]).css("display","block");
setTimeout("closeEvent()",2000);
if(mode=="edit"){
window.location.href="goal.php?id="+GOAL_ID;
}
else
window.location.href="goal.php?id="+data['success'];
}


},
"json"
);



return false;

});

});







/*$("document").ready(function (){


$(".upload-text").click(function (){
$("input[name='goalpic']").trigger("click");

});


$(".rdelete").click(function (){


$par=$(this).parent();
$par.addClass("rfocus").removeClass("activeparam");
rname=$par.children(".basic-title").text();

$picdiv=$par.children(".basic-pic");
$picdiv.css("opacity","0.6");

$par.children(".basic-title").text("Removing...");
url="includes/goalactions.php";
action="remove";
id=$par.attr("paramid");
param=$par.attr("param");

$.post(url,{
	param: param,
	action: action,
	id: id,
	goalid: goalid
	}, function (data){
$par.removeClass("rfocus");
$picdiv.css("opacity","1");

$("#flash").text(data.msg);
$("#flash").slideDown(300);
setTimeout("hideflash()",4000);

if(data.status)
{

changePoint(-50);

$picdiv.html("");
$picdiv.addClass("addnew");
$par.addClass("inactiveparam");
$par.children(".basic-title").text("Add New");
$par.children(".reward-state").css("display","none");
}
else
{
$par.children(".basic-title").text(rname);
$par.addClass("activeparam");
}



	},"json");







});


$(".addnew").live("click",function (){
$par=$(this).parent();
param=$par.attr("param");
addnew(param);

});

$(".loadMore").live("click",function (){

$par=$(this).parent();
$div=$(this);

param=$(this).attr("param");
if(param =="people")
{
imparam="height='140px'";
}
else
{
imparam="width='190px'";
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
*/
function confirmRequest(user_id)
{
url="includes/goalactions.php";
$.post(url,{
	param:"user",
	action:"confirmRequest",
	goalid:GOAL_ID,
	userid:user_id
	},function(data){
		$('#confirmRequest'+user_id).removeClass("button").addClass("disableButton").attr('disabled','disabled');
	}
	);

}
function removeContributor(user_id)
{
url="includes/goalactions.php";
$.post(url,{
        param:"user",
        action:"removeContributor",
        goalid:GOAL_ID,
        userid:user_id
        },function(data){
                $('#removeContributor'+user_id).attr('value','Removed').removeClass("button").addClass("disableButton");
                $('#removeContributor'+user_id).attr('disabled','disabled');
        }
        );

}
function removeConnection(user_id)
{
url="includes/goalactions.php";
$.post(url,{
        param:"user",
        action:"removeConnection",
        userid:user_id
        },function(data){
                $('#removeConnection'+user_id).attr('value','Removed').removeClass("button").addClass("disableButton");
                $('#removeConnection'+user_id).attr('disabled','disabled');
        }
        );

}

function back()
{
/*$('#moreCont').hide();
$('#mainFeed').show();
$('#moreCont').html("");*/
window.location.href="goal.php?id="+GOAL_ID;
}
function backButtonClick()
{
$('#dynamicRegion').hide();
$('#staticRegion').show();
}
function pendingRequest()
{
$('#mainFeed').hide();
$('#moreCont').load('pendingRequest.php?goalId='+GOAL_ID);
$('#moreCont').show();
}
function goalContributor()
{
$('#staticRegion').hide();
$('#dynamicRegion').load('goalContributor.php?goalId='+GOAL_ID);
$('#dynamicRegion').show();

}
function userConnection(userId)
{
$('#staticRegion').hide();
$('#dynamicRegion').load('userConnection.php?userId='+userId);
$('#dynamicRegion').show();

}
function getCompanyConnection(companyId)
{
$('#staticRegion').hide();
$('#dynamicRegion').load('companyConnection.php?companyId='+companyId);
$('#dynamicRegion').show();

}

function moreGoals(user_id)
{
$('#dynamicRegion').show();
$('#dynamicRegion').load('moreGoal.php?id='+user_id);
$('#staticRegion').hide();
//$('#mainCont').load('moreGoal.php?id='+user_id);
}
function moreCompanyGoals(){
$('#dynamicRegion').show();
$('#staticRegion').hide();
$('#dynamicRegion').load('companyGoals.php');
}
function moreConnectionsAdd(user_id,profile_id,comp_id,have)
{
if(profile_id==-1)
{

$('#mainCompanyFeed').hide();
$('#moreCompanyCont').load('moreConnections.php?id='+user_id+'&compid='+comp_id+'&profileid='+profile_id+'&have='+have);
}
else
{
$('#moreCont').show();
$('#moreCont').load('moreConnections.php?id='+user_id+'&compid='+comp_id+'&profileid='+profile_id+'&have='+have);
$('#feedCont').hide();
}
}
function joinGoal()
{
url="includes/goalactions.php";
$.post(url, {
                param: "goal",
                action: "join",
                goalid: GOAL_ID
            },  function (data) {
			window.location.href="goal.php?id="+GOAL_ID;

            }
        );

}
function joinMoreGoal(goalId)
{
url="includes/goalactions.php";
$.post(url, {
                param: "goal",
                action: "join",
                goalid: goalId
            },  function (data) {
		$('#joinMoreGoal'+goalId).removeClass("button").addClass("disableButton").attr('disabled','disabled');
            }
        );

}
function saveoneconn(id)
{

		$('#saveoneconn'+id).attr('value','Adding..');
url="includes/users_connections.php";
$.post(url, {
                param: "people",
                action: "saveoneconn",
                profileid: id
            },  function (data) {
		$('#saveoneconn'+id).removeClass("btn_small").addClass("disableButton").attr('disabled','disabled');
		$('#saveoneconn'+id).attr('value','Added');
		
            }
        );
}

function saveoneconnprof(id)
{

url="includes/users_connections.php";
$.post(url, {
                param: "people",
                action: "saveoneconn",
                profileid: id
            },  function (data) {
		/*$('#saveoneconn'+id).removeClass("btn_small").addClass("disableButton").attr('disabled','disabled');
		$('#saveoneconn'+id).attr('value','Added');*/
	msg = PROFILEUSERNAME + " added to your connection";
	showFlash(msg);
	document.location = document.location;
		
            }
        );
}

function removeoneconn(id)
{

		$('#removeoneconn'+id).attr('value','Removing..');
url="includes/users_connections.php";
$.post(url, {
                param: "people",
                action: "removeoneconn",
                profileid: id
            },  function (data) {
		$('#removeoneconn'+id).removeClass("btn_small").addClass("disableButton").attr('disabled','disabled');
		$('#removeoneconn'+id).attr('value','Removed');
		
            }
        );
}
function removeoneconnprof(id)
{

url="includes/users_connections.php";
$.post(url, {
                param: "people",
                action: "removeoneconn",
                profileid: id
            },  function (data) {
		/*$('#saveoneconn'+id).removeClass("btn_small").addClass("disableButton").attr('disabled','disabled');
		$('#saveoneconn'+id).attr('value','Added');*/
	msg = PROFILEUSERNAME + " removed from your connection";
	showFlash(msg);
	document.location = document.location;
		
            }
        );
}
function SaveMBTIScore()
{
url="includes/mbti.php";
 $.post(url ,{score_type: $("#score_type").val()},function(data)
{

	//	alert("Data Loaded: " + data);

}
);
$("#MBTI_Test").hide();
$("#show_mbti").text($("#score_type").val());
}
function fillForm(goalName,Created_By,goalObjective,goalKeyResults,due_date,progress_id,visibility_id,image_src,contributors)
{
$('#goaldp').attr('src',image_src);
$('#newitemForm #fileUpload').val(image_src);
$('#name').val(goalName);
$('#created_by').val(Created_By);
$('#objective').val(goalObjective);
$('#key_result').val(goalKeyResults);
$('#due_date').val(due_date);
$('#contributors').val(contributors);

$('#progress_select option[value='+progress_id+']').attr('selected', 'selected');
$('#visibility_select option[value='+visibility_id+']').attr('selected', 'selected');

}
function changePoint(point)
{
var gp=$("#goal-point").text();
gp=parseInt(gp);
gp=gp+point;
$("#goal-point").text(gp);
}

function filetaken(){
	$("#upload-load").addClass("upload-act").css("display","block");
	$("#goalpicformid").submit();
	//$("form[name='goalpicformsubmit']").submit();
}

function ShowConn(param,action)
{
	$("#eventCont").fadeIn(300);
	$("#eventWrap .etext").css("display","none");
	$(".eload").html("Loading...");
	url="includes/users_connections.php";
	if(param =="people"){
	goalId=0;
	projectId=0;
	}
	  if(param=="project"){
	projectId=PROJECT_ID;
	goalId=0;
	}
	 if(param=="goal"){
	goalId=GOAL_ID;
	projectId=0;
	}
	$.post(url, {
				param: param,
				action:action,
				goalid: goalId,
				projectid:projectId
				//userid: userid
				},  function (data) {
	
					$(".eload").html("");
					$("#eventWrap .etext").html(data);
					$("#eventWrap .etext").css("display","block");

					}
						);


}
function close()
{
alert("reache");
}
function addnew(param,action)
{
		mode=action;
		$("#eventCont").fadeIn(300);
		$("#eventWrap .etext").css("display","none");
		$(".eload").html("Loading...");
url="includes/goalactions.php";
$.post(url, {
                param: param,
                action: action,
		goalid: GOAL_ID
            },  function (data) {
		$(".eload").html("");
		$("#eventWrap .etext").html(data);
		$("#eventWrap .etext").css("display","block");
Date.firstDayOfWeek = 0;
			Date.format = 'yyyy-mm-dd';
            $(function()
            {
				$('.date-pick').datePicker({clickInput:true} )

            });
            }
	);

}
function createGoal(param,action)
{
                mode=action;
                $("#eventCont").fadeIn(300);
                $("#eventWrap .etext").css("display","none");
                $(".eload").html("Loading...");
url="includes/goalactions.php";
$.post(url, {
                param: param,
                action: action,
            },  function (data) {
                $(".eload").html("");
                $("#eventWrap .etext").html(data);
                $("#eventWrap .etext").css("display","block");
Date.firstDayOfWeek = 0;
                        Date.format = 'yyyy-mm-dd';
            $(function()
            {
                                $('.date-pick').datePicker({clickInput:true} )
            });
            }
        );

}



function closeEvent()
{
$("#eventCont").fadeOut(300);
}




function closeGoal()
{

	openBox("includes/confirm.php","completedGoal=1");	
	thisItem = this;
	$('#confirm_submit').live('click',function(){
		
url="includes/goalactions.php";
$('#try').load(url, {
                param: "goal",
                action: "close",
                goalid: GOAL_ID
            },  function (data) {
                window.location.href="goal.php?id="+GOAL_ID;

            }
        );

});

}
function picupload(msg, state, imgpath, picpoint)
{
//alert(imgpath);
/*if(picpoint==1)
{
msg +=" You have added 50 more points to this goal";
}*/
//$("#flash").text(msg);
//$("#flash").slideDown(400);

if(state==0)
{
$('#fileUpload').val(imgpath);
imgpath=imgpath+"?timestamp=" + new Date().getTime();
$("#goaldp").attr("src",imgpath);
$(".upload-text span.txt").text("Change Goal Pic");
}
$("#upload-load").removeClass("upload-act").css("display","none");
//setTimeout("hideflash()",4000);
}

function hideflash()
{
$("#flash").slideUp(400);
}
function goalimagetaken(){
        //$("#company-image-upload-load").addClass("upload-act").css("display","block");
        $("form[name='goalpicform']").submit();
}

function goalimageupload(msg, state, imgpath)
{
$("#flash").text(msg);
$("#flash").slideDown(400);
setTimeout(function () { $("#flash").slideUp(500); }, "3000");

if(state==0)
{
$('#fileUpload').val(imgpath);
imgpath=imgpath+"?timestamp=" + new Date().getTime();
$("#goaldp").attr("src",imgpath);
//$(".company-image-upload-text span.txt").text("Change Company Pic");

}
//$("#company-image-upload-load").removeClass("upload-act").css("display","none");
setTimeout("hideflash()",4000);
}

