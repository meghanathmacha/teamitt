
$('#add_option').live('click',function()
{
var last_option_id = $('.option_input:last').attr('id');
var option_id_len = last_option_id.length;
last_option_id_int = parseInt(last_option_id.substring(6,option_id_len));
new_option_id = "option"+(last_option_id_int + 1);
var add_option_html = '';
add_option_html += '<li>'
		+ '<input id= "'+new_option_id+'"  value="" name= "'+new_option_id+'" class="text option_input" required="false" placeholder="Add option"/>'
		+ '</li>';

$('#option_div').append(add_option_html).fadeIn();
});
$('.remove_option').live('click',function()
{
var no_of_options = $('#option_div').children().length;
if(no_of_options > 2)
	$('#option_div').children(':last').remove();
else
	alert("Number of Minimum options should be 2  to create a poll .");
});
