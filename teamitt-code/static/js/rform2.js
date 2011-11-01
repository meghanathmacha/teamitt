function isValidPassword(){
	var password=$("#password").val();
	if(password.length < 6){
		$("#e-pass").html("Password should be minimum of 6 characters").fadeIn();
		return false;
	}
	return true;
}

function isMatchingPassword(){
	var password=$("#password").val();
	var cpassword=$("#cpassword").val();
	if(password.length <6 || password == cpassword){
	return true;
	}
else { 
		$("#e-cpass").html("Passwords are not matching.").fadeIn();
		return false;
}

}

$("document").ready(function () {

$("#rform").submit(function () {

	var fname=$("#fname").val();
	var lname=$("#lname").val();
	var utitle=$("#title").val();
	fname = $.trim(fname);
	lname = $.trim(lname);
	utitle = $.trim(utitle);
	var flag=0;
	
	if(fname.length == 0){
		flag=1;
		$("#fname").val("").addClass("blank").focus();
	}
	if(lname.length == 0){
		flag=1;
		$("#lname").val("").addClass("blank").focus();
	}
	if(!isValidPassword()){
		flag=1;
		$("#password").addClass("blank").focus();
		$("#cpassword").val("");
	}
	else { $("#e-pass").fadeOut(); }
	if(!isMatchingPassword()){
		flag=1;
		$("#cpassword").addClass("blank").focus();
	}
	else { $("#e-cpass").fadeOut(); }
	if(utitle.length == 0){
		flag=1;
		$("#title").val("").addClass("blank").focus();
	}



if(flag) {
return false;
}

});

});


