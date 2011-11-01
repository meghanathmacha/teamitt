$("document").ready(function ()
{


$("#inviteForm").submit(function () {

emailBox = $(this).find("textarea");
emails = $.trim(emailBox.val());

if(emails != "")
{
emailBox.attr("disabled", "true");
loadingDiv = $(".inviteLoading");
$("#inviteResult").text("");
loadingDiv.fadeIn();

url="includes/postinvites.php";

$.post(url, {emails: emails}, function (data) {

emailBox.removeAttr("disabled");
loadingDiv.fadeOut();
if(data.success > 0)
{
emailBox.val("");
}

$("#inviteResult").text(data.message);


}, "json");

}
else {
emailBox.val("");
}

return false;
});




});
