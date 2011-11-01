function saveBadgePoints(id){
textboxId='badgePoint'+id;
val=$('#'+textboxId).val();
$.post("includes/customBadgeAction.php",
{param:"saveBadgePoints",  badgeId:id,value:val  }, function(data) {
if(data==0){
alert("Enter the Numeric");
}
if(data==1){
alert("Points are Changed");
}
});
}
function saveUserBadgePoints(id){
textboxId='userBadgePoint'+id;
val=$('#'+textboxId).val();
$.post("includes/customBadgeAction.php",
{param:"saveUserBadgePoints",  userId:id,value:val  }, function(data) {
if(data==0){
alert("Enter the Numeric");
}
if(data==1){
alert("Points are Changed");
}
});
}
function saveCompanyFrequency(id){
val=$('#frequencyValue').val();
$.post("includes/customBadgeAction.php",
{param:"saveCompanyFrequency",  companyId:id,value:val  }, function(data) {
if(data==0){
alert("Enter the Numeric");
}
if(data==1){
alert("Frequency Changed");
}
});
}

function showBadgePoints(){
$('#badgePoint').show();
$('#badgeRule').hide();
}
function showBadgeRules(){
$('#badgePoint').hide();
$('#badgeRule').show();
}
