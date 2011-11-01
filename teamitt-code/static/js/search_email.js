$("document").ready(function (){

$(".search-li").live("click",function (){
var name=$(this).text();
//var uid = $(this).attr("uid");
str="<span>"+name+"</span>";
//$("#contributors").append(name);
v=$('#contributors').val();
v=v+name+",";
$('#contributors').val(v);
//$("#contributors").append(",");
$("#get_contributors").val("");
$("#get_contributors").blur();
$('#autouser').hide();


});


$('#get_contributors').focus(function (event){

var vals = $(this).val();
vals=$.trim(vals);
if(vals!="")
{
getPeopleByEmail(event);
}

});


$('#get_contributors').blur(function (){

$(this).removeClass("act");
if($("#autouser").size())
{
setTimeout('hideSuggestion()',100);
}

});

});

function hideSuggestion()
{

$("#autouser").slideUp(100);

}

function getGoal(event)
{


}

function getPeopleByEmail(event)
{
ids="get_contributors";
$box=$('#'+ids);
vals=$box.val();
/*if(!vals)
{
vals="";
}
*/
/*lt=$box.offset();
lft=lt.left;
tp=lt.top-100;*/
uid="autouser";
if($('#'+uid).length)
{

}
else
{
wid=$box.width();
//$("<div class='autouser' id='autouser' style='position:absolute;display:none;left:"+lft+";top:"+tp+";width:"+wid+";'></div>").insertAfter($box);
$("<div class='autouser' id='autouser' style='display:none;z-index:0;top:60px;'></div>").insertAfter($box);
}
if(event.keyCode==40)
{
$inp=$('#'+uid).prev();
$div=$('#'+uid);
len=$div.children().length;
if(len>0)
{
sindex++;
if(sindex>len)
{
sindex=1;
}

$('#'+uid).children().each(function (index){
if(index+1==sindex)
{
txt=$(this).text();
$inp.val(txt);
$(this).addClass('selectedli');
}
else
{
$(this).removeClass('selectedli');
}



});



}




}
else if(event.keyCode==38)
{
$inp=$('#'+uid).prev();
len=$div.children().length;
if(len>0)
{
sindex--;
if(sindex<1)
{
sindex=len;
}

$('#'+uid).children().each(function (index){
if(index+1==sindex)
{
txt=$(this).text();
$inp.val(txt);
$(this).addClass('selectedli');
}
else
{
$(this).removeClass('selectedli');
}


});

}

}



else if(event.keyCode==27 || event.keyCode==13)
{
$('#'+uid).slideUp(100);
$("#get_contributors").blur();
}

else
{
if(vals.length>0)
{
sindex=0;
url='includes/getPeople_email.php?name='+vals;
$("#get_contributors").addClass("act");
$.post(url,function (data){
$("#get_contributors").removeClass("act");
data=$.trim(data);
if(data=='')
{
$('#'+uid).slideUp(100);
}
else
{
$('#'+uid).html(data).slideDown(100);
}

});

}
else
{
$('#'+uid).slideUp(100);
}

}

}



