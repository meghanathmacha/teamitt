$(document).ready(function()
{
	$(".tabs li").live('click',contentLoad);
	function contentLoad()
	{
		event.preventDefault();
		var tab_name = $(this).attr('class');
		$('#tab_visited').attr('id','');
		$(".tabs ."+tab_name).attr('id','tab_visited');
		if(tab_name == 'home')
			$('.wall_post').slideDown();
		else
		{
			$('.wall_post').hide();
			$('.'+tab_name).fadeIn();
		}
	}
});

