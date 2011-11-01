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



function loadItem(type,company)
{

		$("#eventCont").fadeIn(300);
		$("#eventWrap .etext").css("display","none");
		$(".eload").html("Loading...");
	goToByScroll("eventCont");
var totimer=type;
url="includes/newItem.php";
type="add"+type;
$.post(url, {
                type: type,
                company: company
                //userid: userid
            },  function (data) {
			
		$(".eload").html("");
		$("#eventWrap .etext").html(data);
if(totimer=="event")
{
$('#eventTime').datetimepicker({
	ampm: true,
	timeFormat: 'hh:mm TT',
	dateFormat: 'yy-mm-dd'
});
}


		$("#eventWrap .etext").css("display","block");
	
            }
	);

}







function newItem(type,company)
{
userid=getid();
if(!userid)
{

FB.login(function(response) {
  if (response.session) {
userid = FB.getSession().uid; // 1 as id
	loadItem(type,company);

  } else {
userid=0;
}
});
}
else
{
loadItem(type,company);
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
$("#newitemForm").live("submit",function (event)
{
$("#formLoad").removeClass().html("").addClass("formLoad");
$("#formsub").attr("disabled","true");
$(this).addClass("formSubmit");

userid=getid();
var formVals=$(this).serialize();
$.post("includes/newItem.php", 
{type:"postItem", userid:userid, values:formVals  }, function(data) {
	goToByScroll("eventCont");
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
