function goToByScroll(id){
     $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
return false;
}


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

return id;
}



function loadevent(company)
{

		$("#eventCont").fadeIn(300);
		$("#eventWrap .etext").css("display","none");
		$(".eload").html("Loading...");
	goToByScroll("eventCont");
url="includes/addevent.php";
$.post(url, {
                type: "addevent",
                company: company
                //userid: userid
            },  function (data) {
			
		$(".eload").html("");
		$("#eventWrap .etext").html(data);
$('#eventTime').datetimepicker({
	ampm: true,
	timeFormat: 'hh:mm TT',
	dateFormat: 'yy-mm-dd'
});


		$("#eventWrap .etext").css("display","block");
	
            }
	);

}










function addevent(company)
{
userid=getid();
if(!userid)
{

FB.login(function(response) {
  if (response.session) {
userid = FB.getSession().uid; // 1 as id
	loadevent(company);

  } else {
userid=0;
}
});
}
else
{
loadevent(company);
}


}

function closeEvent()
{
$("#eventCont").fadeOut(300);
}


function showpop(type,id)
{
		$("#eventCont").fadeIn(300);
		$("#eventWrap .etext").css("display","none");
		$(".eload").html("Loading...");
	goToByScroll("eventCont");
url="includes/showpop.php";
$.post(url, {
                type: type,
                id: id
            },  function (data) {
			
		$(".eload").html("");
		$("#eventWrap .etext").html(data);
		$("#eventWrap .etext").css("display","block");
	
            }
);


}




$("document").ready(function ()
{
$("#addeventForm").live("submit",function (event)
{
$("#formLoad").removeClass().html("").addClass("formLoad");
$("#formsub").attr("disabled","true");
$(this).addClass("formSubmit");

userid=getid();
var formVals=$(this).serialize();
$.post("includes/addevent.php", {type:"post-event", userid:userid, values:formVals  }, function(data) {
if(!data["success"])
{
var err=" Failed: "+data["err"];
$("#formLoad").removeClass().html(err).addClass("err");
$("#formsub").removeAttr("disabled");
$("#addeventForm").removeClass("formSubmit");
}
else
{

$("#eventCont .etext").css("display","none");
$("#eventCont .eload").html("Event successfully added.").css("display","block");
setTimeout("closeEvent()",2000);

}


},
"json"
);





return false;

});



});
