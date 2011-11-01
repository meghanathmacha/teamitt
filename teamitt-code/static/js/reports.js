
$(document).ready(function(){
$('.report-back').live('click',reportBack);
//$('.badge-table').find('th').live('click',removeFeeds);
$('.badge-table').find('td').live('click',loadFeedTable);
//$('#filter-form').submit(filterReports);
$('#filter-form').find('.submit').live('click',filterReports);
$('.listings').find('a').live('click',loadReports);
$('#filter-form').find('select[name="report-options"]').live('click',loadOptions);
function reportBack()
{
$('#mainCont').html("<img class = 'bring-mid' src = 'static/images/loader.gif'/>");
/*var type = $(this).attr('id');
$('.selected').removeClass();
$(this).addClass('selected');*/
type= 'badge';
var data = {type:type};
	$.ajax({
	type: "POST",
	url: "reports-in.php",
	data:data,
	error :function() {},
	success:function(data){
	$('#mainCont').html(data);
	}
	});
$('#riteCont').load('reports-filter.php');

}

function loadFeedTable()
{
$('#mainCont').html("<img class = 'bring-mid' src = 'static/images/loader.gif'/>");
var user_id = $(this).parent('tr').attr('uid');
var td_class = $(this).attr('class');
if(td_class == 'name-td')
	report_flag = 1;	
else if(td_class == 'points-sent')
	report_flag = 2;	
else if(td_class == 'points-received')
	report_flag = 3;	
var thisItem = $(this);
var data = {user_id:user_id,report_flag:report_flag,type:'badge'};
	$.ajax({
	type: "POST",
	url: "reports-in.php",
	data:data,
	error :function() {},
	success:function(data){
	$('#mainCont').html(data);
	
	}
	});
$('#riteCont').load('reports-filter.php');

}
function loadFeeds()
{
var user_id = $(this).parent('tr').attr('uid');
prev_id = $('.feeds-tr').prev().attr('uid');
$('.feeds-tr').fadeOut('slow');
$('.feeds-tr').remove();
if($(this).hasClass('selected-td'))
{
	$(this).removeClass('selected-td');
}
else
//if(user_id != prev_id )
{
	$('.badge-table').find('td').removeClass('selected-td');
	str = '<tr class="feeds-tr"><td colspan="5" class="feedArea">';
	str += "<img class = 'bring-mid' src = 'static/images/loader.gif'/>";
	str += '</td></tr>';
	$(this).parent('tr').after(str);
var td_class = $(this).attr('class');
if(td_class == 'name-td')
	report_flag = 1;	
else if(td_class == 'points-sent')
	report_flag = 2;	
else if(td_class == 'points-received')
	report_flag = 3;	
$(this).addClass('selected-td '+ td_class);


var thisItem = $(this);
var data = {user_id:user_id,feed_type:2,report_flag:report_flag};
	$.ajax({
	type: "POST",
	url: "report_feeds.php",
	data:data,
	error :function() {},
	success:function(feeds){
//		str = '<tr class="feeds-tr"><td colspan="5" >' + feeds + '</td></tr>';
		$('.feeds-tr td').html(feeds);
	}
	});
}

}
function loadOptions()
{
var report_option = $('#filter-form').find('select[name="report-options"] option:selected').val();
$('.in-div').each(function()
{
var option_val = $(this).attr('option');
if(option_val == report_option)
	$(this).show();
else
	$(this).hide();
});

}
function loadReports(event)
{
event.preventDefault();
$('#mainCont').html("<img class = 'bring-mid' src = 'static/images/loader.gif'/>");
var type = $(this).attr('id');
$('.selected').removeClass();
$(this).addClass('selected');
var data = {type:type};
	$.ajax({
	type: "POST",
	url: "reports-in.php",
	data:data,
	error :function() {},
	success:function(data){
	$('#mainCont').html(data);
	}
	});
$('#riteCont').load('reports-filter.php');

}
function filterReports(event)
{
event.preventDefault();
$('#mainCont').html("<img class = 'bring-mid' src = 'static/images/loader.gif'/>");
var type = $('.listings').find('a.selected').attr('id');
var report_option = $('#filter-form').find('select[name="report-options"] option:selected').val();
if(report_option == '1')
{

var rfd = $('#rfd').val();
var rtd = $('#rtd').val();
var data = {from_date:rfd , end_date:rtd,type:type};
}
else if(report_option == '2')
{
var time_range = $('#filter-form').find('select[name="time-range"] option:selected').val();
var data = {time_range:time_range,type:type,report_flag:REPORT_FLAG,user_id:REPORT_USER_ID};

}
	$.ajax({
	type: "POST",
	url: "reports-in.php",
	data:data,
	error :function() {},
	success:function(data){
	$('#mainCont').html(data);
	}
	});

}
});

