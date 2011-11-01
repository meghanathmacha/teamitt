var mode="";
$("document").ready(function ()
{
$("#newProjectForm").live("submit",function (event)
{
$("#formLoad").removeClass().html("").addClass("formLoad");
$("#formsub").attr("disabled","true");
$(this).addClass("formSubmit");
var formVals=$(this).serialize();
var projectid="";
if(mode=="edit"){
action="update";
projectid=PROJECT_ID;
}
else if(mode=="new"){
action="submit";
}
$.post("includes/projectactions.php",
{param:"project", action:action, values:formVals,projectid:projectid  }, function(data) {
if(!data["success"])
{
var err=" Failed: "+data["err"];
$("#formLoad").removeClass().html(err).addClass("err");
$("#formsub").removeAttr("disabled");
$("#newProjectForm").removeClass("formSubmit");
$(this).removeClass();
}
else
{

$("#eventCont .etext").css("display","none");
$("#eventCont .eload").html(data["err"]).css("display","block");
setTimeout("closeEvent()",2000);
if(mode=="edit"){
window.location.href="project.php?id="+PROJECT_ID;
}
else
window.location.href="project.php?id="+data['success'];
}

},
"json"
);



return false;

});

});



function createProject(param,action)
{
                mode="new";
                $("#eventCont").fadeIn(300);
                $("#eventWrap .etext").css("display","none");
                $(".eload").html("Loading...");
url="includes/projectactions.php";
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
function editProject()
{
		mode="edit";
                $("#eventCont").fadeIn(300);
                $("#eventWrap .etext").css("display","none");
                $(".eload").html("Loading...");
url="includes/projectactions.php";
$.post(url, {
                param: "project",
                action: "edit",
                projectid: PROJECT_ID
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
function fillProjectForm(projectName,Created_By,projectObjective,due_date,progress_id)
{
$('#name').val(projectName);
$('#created_by').val(Created_By);
$('#objective').val(projectObjective);
$('#due_date').val(due_date);

$('#progress_select option[value='+progress_id+']').attr('selected', 'selected');

}
function projectContributor()
{
$('#mainFeed').hide();
$('#moreCont').load('projectContributor.php?projectId='+PROJECT_ID);
$('#moreCont').show();

}
function back()
{
window.location.href="project.php?id="+PROJECT_ID;
}
function removeProjectContributor(user_id)
{
url="includes/projectactions.php";
$.post(url,{
        param:"user",
        action:"removeContributor",
        projectid:PROJECT_ID,
        userid:user_id
        },function(data){
                $('#removeProjectContributor'+user_id).attr('value','Removed');
                $('#removeProjectContributor'+user_id).attr('disabled','disabled');
        }
        );

}
function closeProject()
{
url="includes/projectactions.php";
$.post(url, {
                param: "project",
                action: "close",
                projectid: PROJECT_ID
            },  function (data) {
                window.location.href="project.php?id="+PROJECT_ID;

            }
        );


}
function moreCompanyProjects(){
$('#mainCompanyFeed').hide();
$('#moreCompanyCont').load('moreCompanyProject.php');
}
function moreProjects(user_id)
{
$('#moreCont').show();
$('#moreCont').load('moreProject.php?id='+user_id);
$('#feedCont').hide();
//$('#mainCont').load('moreGoal.php?id='+user_id);
}
function projectimagetaken(){
        $("form[name='projectpicform']").submit();
}
function projectimageupload(msg, state, imgpath)
{
$("#flash").text(msg);
$("#flash").slideDown(400);

if(state==0)
{
$('#fileUpload').val(imgpath);
imgpath=imgpath+"?timestamp=" + new Date().getTime();
$("#projectdp").attr("src",imgpath);
$(".company-image-upload-text span.txt").text("Change Project Pic");

}
setTimeout("hideflash()",4000);
}
function joinProject()
{
url="includes/projectactions.php";
$.post(url, {
                param: "project",
                action: "join",
                projectid: PROJECT_ID
            },  function (data) {
                        window.location.href="project.php?id="+PROJECT_ID;

            }
        );

}

