function showFeedback(){
//$('#moreCont').load('feedback.php?userId='+PROFILEUSERID);
	post_data={
	offset:OFFSET,
	user_id:PROFILEUSERID,
	type_name:4,
	}
	$.ajax({
	type: "POST",
	url: "feeds.php",
	data:post_data,
	//timeout:10000,
	error :function() {},
	success:function(data){
$('#moreCont').show();
//$('#moreCont').load('feedback.php?userId='+PROFILEUSERID+'&userName='+PROFILEUSERNAME);
$('#moreCont').load('feedback.php?userId='+PROFILEUSERID,function(){
$('#moreCont').append(data);
});
$('#feedCont').hide();
$('#mbti-query').hide();
	}
	});
}
function showProfile(){
$('#moreCont').hide();
$('#mbti-query').hide();
$('#feedCont').show();
}

