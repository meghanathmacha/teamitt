function shownearby(event, range)
{
$(".sTab").css("display","none");
event.preventDefault();
addr= $("#business_address_line").val();
city= $("#business_city").val();
state= $("#business_state").val();
zip= $("#business_zip").val();
if(!range)
{
range = 0.5;
}
$(".target_companies").html("<h3>  Loading...</h3>");
url = "geoencode.php";
$.post(url,
	{addr: addr,
	city: city,
	state: state,
	zip: zip,
	range: range
	},function (data){

if(data[0]["status"])
{
$(".sTab").css("display","block");
$("#sC").text("0");
var str="";
for(i=1;i<data.length;i++)
{
str += "<span class='nC' compid='"+data[i].id+"'>"+data[i].name+"</span>";
$(".target_companies").html(str);
}
}
else
{
str="No places found";
$(".target_companies").html(str);
}


}, "json");





return false;

}






$("document").ready(function (){


$(".nC").live("click",function (){

var cnt=$("#sC").text();
cnt=parseInt(cnt);

if($(this).hasClass("nearby"))
{
$(this).removeClass("nearby");
cnt = cnt - 1;
}
else
{

$(this).addClass("nearby");
cnt = cnt+1;
}
$("#sC").text(cnt);

});



$("#dealForm").submit(function (){

var companies= new Array();

$(".nearby").each(function (index){

companies[index]=$(this).attr("compid"); 

});

var compids= companies.join(",");

$("#compids").val(compids);

});



});
