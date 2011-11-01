var g_param=0;
$("document").ready(function ()
{
$("#newitemForm").live("submit",function (event)
{
$("#formLoad").removeClass().html("").addClass("formLoad");
$("#formsub").attr("disabled","true");
$(this).addClass("formSubmit");

//erid=getid();
var formVals=$(this).serialize();
$.post("includes/goalactions.php",
{param:"goal", action:"submit", values:formVals  }, function(data) {
   //     goToByScroll("eventCont");
if(!data["success"])
{
var err=" Failed: "+data["err"];
$("#formLoad").removeClass().html(err).addClass("err");
$("#formsub").removeAttr("disabled");
$("#newItemForm").removeClass("formSubmit");
}
else
{

$("#eventCont .etext").css("display","none");
$("#eventCont .eload").html(data["err"]).css("display","block");
setTimeout("closeEvent()",2000);

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
function fillForm(goalName,Created_By,goalObjective,goalKeyResults,due_date,progress_id,visibility_id,image_src)
{
//alert('reach')
//alert(due_date);
//alert($('#due_date').attr('id'));
image_src="http://home.goalcat.com/teamitt/uploads/goalimg/goalimg-1.jpg";
$('#goaldp').attr('src',image_src);

$('#name').val(goalName);
$('#created_by').val(Created_By);
$('#objective').val(goalObjective);
$('#key_result').val(goalKeyResults);
$('#due_date').val(due_date);

//alert(image_src);
$('#visibilty_select option[value='+visibilty_id+']').attr('selected', 'selected');
$('#progress_select option[value='+progress_id+']').attr('selected', 'selected');

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
$("form[name='goalpicform']").submit();
}


function addnew(param,action)
{
		$("#eventCont").fadeIn(300);
		$("#eventWrap .etext").css("display","none");
		$(".eload").html("Loading...");
		g_param=param;
url="includes/goalactions_edit.php";
$.post(url, {
                param: param,
                action: action,
	//	goalid: goalid
                //userid: userid
            },  function (data) {
			
		$(".eload").html("");
		$("#eventWrap .etext").html(data);
		$("#eventWrap .etext").css("display","block");
	
            }
	);

}



function closeEvent()
{
$("#eventCont").fadeOut(300);
}





function picupload(msg, state, imgpath, picpoint)
{
if(picpoint==1)
{
msg +=" You have added 50 more points to this goal";
}
$("#flash").text(msg);
$("#flash").slideDown(400);

if(state==0)
{
imgpath=imgpath+"?timestamp=" + new Date().getTime();
$("#goaldp").attr("src",imgpath);
$(".upload-text span.txt").text("Change Goal Pic");
}
$("#upload-load").removeClass("upload-act").css("display","none");
setTimeout("hideflash()",4000);
}

function hideflash()
{
$("#flash").slideUp(400);
}
