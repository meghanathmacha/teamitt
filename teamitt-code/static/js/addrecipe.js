var last_action_id = 0;
$(document).ready(function()
		{
		$('.submit').live('click',submit);
		$('.next').live('click',navigate);
		$('.prev').live('click',navigate);

		});

function checkkey(event)
{
	if(event.keyCode==13)
	{
		navigate("next");
	}
}
function submit()
{
	var action_id = $(this).parents('.action-item-box').attr('id');
	if(action_id == undefined)
		action_id = 0;
	else
		action_id = action_id.substring(7,action_id.length);
	var error = 0;
	if(parseInt(action_id))
	{
		$('#action_'+action_id).find(".text").each(function()
				{
				var content = $(this).val();
				if(content == '' && error == 0)
				{
				$(this).addClass("blank");
				$(this).focus();
				error = 1;
				}
				});
	}
	if(!error)
	{
		if(action_id == last_action_id)
		{
			$('#addrecipe').submit();
		}
		else
		{
		var current_task = "Task "+action_id ;
		var last_task = "Task "+last_action_id ;
		var message = "Your have written "+last_action_id+ " tasks but if you done here then only "+ action_id +" tasks will be submitted.Are you sure?";
		if (confirm(message)) {
				for(i = action_id+1 ; i <= last_action_id ;i++)
				{
					$('#action_'+i).remove();
				}
			$('#addrecipe').submit();
		}
				
		}
	}
}
function navigate(dir,type)
{
	var dir = $(this).attr('class');
	var action_id = $(this).parents('.action-item-box').attr('id');
	if(action_id == undefined)
		action_id = 0;
	else
		action_id = action_id.substring(7,action_id.length);
	var error = 0;
	if(parseInt(action_id))
	{
		$('#action_'+action_id).find(".text").each(function()
				{
				var content = $(this).val();
				if(content == '' && error == 0)
				{
				$(this).addClass("blank");
				$(this).focus();
				error = 1;
				}
				});
	}
	if(!error && dir=="next")
	{
		if(action_id == last_action_id)
		{
			/*var last_action_id = $('.action-item-box').last().attr('id');
			  action_id = last_action_id.substring(7,last_action_id.length);*/
			$('.action-item-box:first').clone(true).appendTo('#boxContainer').show();
			last_action_id = last_action_id + 1;
			$('#boxContainer').find('.action-item-box:last').attr('id','action_'+last_action_id);
			$('#action_'+last_action_id).find(".action-item-head").find('.task-num').text("Task - "+last_action_id);
			count = 0;
			$('#action_'+last_action_id).find(".text").each(function()
					{
					var current_name = $(this).attr('name');
					count++;
					new_name = "item-"+last_action_id+"-"+count;
					//		var attr_id = current_name.substring(current_name.length
					$(this).attr("name",new_name);
					});
	 }

	else
	{
							
							cur_action_id = parseInt(action_id) + 1;
							$('#action_'+cur_action_id).show();
	}

					$("#boxContainer").animate({left:"-=600px"},'slow');
	}
					else if(dir=="prev")
					{
					$("#boxContainer").animate({left:"+=600px"},'slow',function()
						{
							$('#action_'+action_id).hide();
						});
					}
					else if(dir=="reset")
					{
						$("#boxContainer").animate({left:"0px"},'slow');
					}
}


