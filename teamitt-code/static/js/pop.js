
function openBox(url,param)
{

	$("#eventCont").fadeIn(300);
	$("#eventWrap .etext").css("display","none");
	$(".eload").html("Loading...");
	$.ajax({
type: "GET",
url: url,
//dataType: "json",
data:param,
timeout:10000,
error :function() {

},
success:function(data){

$(".eload").html("");
$("#eventWrap .etext").html(data);
$("#eventWrap .etext").css("display","block");

}
});

}



function closeBox()
{
$("#eventCont").fadeOut(300);
}
