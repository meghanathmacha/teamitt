function showMap(company)
{
 $("#eventCont").fadeIn(300);
                $("#eventWrap .etext").css("display","none");
                $(".eload").html("Loading...");
goToByScroll("eventCont");
//		document.getElementById("map_canvas").style.visibility='visible';
var str="<div id='eventHeader'><span onClick='closeEvent();'></span>Showing Map for "+company+"</div><div id='map_canvas'></div>";

  $(".etext").html(str);
		$.post("includes/fetch_map_loc.php",{location: company }, function(data){
  $(".eload").html("");
		showmapImg(data);
                $("#eventWrap .etext").css("display","block");
		},"json");



}

/*
function initialize(data){
	var map;
	var marker=new Array();
	var latlng=new Array();
	var lat=data[0].latitude;
	var lon=data[0].longitude;
	var myLatlng = new google.maps.LatLng(lat,lon);
	var myOptions = {
		zoom: 3,
      		center: myLatlng,
	        mapTypeId: google.maps.MapTypeId.HYBRID
	}
	map = new google.maps.Map(document.getElementById("eventData"), myOptions);
	alert(data.length);
/*	for(i=0;i<data.length;i++){
		var la=data[i].latitude;
		var lo=data[i].longitude;
		latlng[i]= new google.maps.LatLng(la,lo);
		var tit=data[i].address;
		marker[i] = new google.maps.Marker({
			position: latlng[i],
			title: tit,
			map: map
		});
	}
	for(i=0;i<data.length;i++){
		google.maps.event.addListener(marker[i], 'click', function() {
			zoomLevel=map.getZoom();
			if(zoomLevel<18){
				map.setZoom(18);
			}
			});
	}
*/
/*

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

});
*/
