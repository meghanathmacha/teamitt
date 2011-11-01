var hrs
var mins
var secs;

function cd() {
url="includes/countDown.php";

$.get(url, function(data) {
tim=$.trim(data);
timarr=tim.split(":");
hrs=parseInt(timarr[0]);
mins=parseInt(timarr[1]);
secs=parseInt(timarr[2]);
 	redo();

});


}


function dis(hrs,mins,secs) {
 	var disp="";
 	if(hrs <= 9) {
  		disp = " 0";
 	} else {
  		disp = " ";
 	}

 	disp += hrs + ":";
 	if(mins <= 9) {
  		disp += "0"+ mins;
 	} else {
  		disp += mins;
 	}
	disp +=":";
 	if(secs <= 9) {
  		disp += "0" + secs;
 	} else {
  		disp += secs;
 	}
 	return(disp);
}

function redo() {
 	secs--;
 	if(secs == -1) {
  		secs = 59;
  		mins--;
		if(mins == -1)
		{
			hrs--;
			mins=59;
		}

 	}
	
 	 time_left = dis(hrs,mins,secs); 
	$(".timerfield").html(time_left);
 	if((hrs == 0) && (mins == 0) && (secs == 0)) {
 	//Need to take action here
	} else {
 		cd = setTimeout("redo()",1000);
 	}
}


function timerinit() {
  cd();
}

$("document").ready(function (){
$(".timercont").fadeIn(100)
cd();
});





