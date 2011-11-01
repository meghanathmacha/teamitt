function checkinc(uid)
{

if(uid == PROFILEUSERID || $(".recv").children("span[uid="+uid+"]").size())
{
return false;
}
return true;

}


$("document").ready(function (){




$(".search-li").live("click",function (){

var name=$(this).text();
var uid = $(this).attr("uid");
if(checkinc(uid))
{
str="<span uid="+uid+">"+name+"<b class='rp'>&nbsp;</b></span>";
$(".recv").append(str);
}
$("#postFor").val("");
hideSuggestion();


});


$('#postFor').focus(function (event){

var vals = $(this).val();
vals=$.trim(vals);
if(vals!="")
{
getPeople(event)
}

});


$('#postFor').blur(function (){

$(this).removeClass("act");
if($("#autouser").size())
{
setTimeout('hideSuggestion()',400);
}

});

});

function hideSuggestion()
{
$("#autouser").html("");
$("#autouser").slideUp(100);

}

function getGoal(event)
{


}

function getPeople(event)
{
ids="postFor";
$box=$('#'+ids);
vals=$box.val();
if(!vals)
{
vals="";
}
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
$("<div class='autouser' id='autouser' style='position:absolute;display:none;'></div>").insertAfter($box);
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


else if(event.keyCode==27)
{

$('#'+uid).slideUp(100);
$("#postFor").blur();
}

else if(event.keyCode==13)
{
name=$(".autouser").find(".selectedli").text();
var uid = $(".autouser").find(".selectedli").attr("uid");
if(name)
{

if(checkinc(uid))
{
str="<span uid="+uid+">"+name+"<b class='rp'>&nbsp;</b></span>";
$(".recv").append(str);
}
$("#postFor").val("");
}

hideSuggestion();

}

else
{
if(vals.length>0)
{
sindex=0;
url='includes/getPeople.php?name='+vals;
$("#postFor").addClass("act");
$.post(url,function (data){
$("#postFor").removeClass("act");
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



