<script>
$(document).ready(function(){
$('.no_due_date').live('click',function()
{
	$('.dp-applied').val("No due date");
	$('.dp-applied').attr('flag','0');
	
});
$('.complete_action').live('click',function()
{
	$('.dp-applied').val("Action completed");
	$('.dp-applied').attr('flag','1');
	
})
});
</script>
<script type="text/javascript" charset="utf-8">
Date.firstDayOfWeek = 0;
Date.format = 'yyyy-mm-dd';
$(function()
		{
		$('.edit_date_inp').datePicker({clickInput:false} );
		});
</script>
<?php
$date_val = $_GET['date_val'];
if($date_val == '1')
{
	$date_str = "Completed";
	$flag = 1;
}
else if($date_val == '0')
{
	$date_str = "No Due Date";
	$flag = 0;
}
else if($date_val != null)
{
	$date_str = $date_val;
	$flag = 2 ;
}

?>
<div id='eventHeader'><span onClick='closeBox();'></span>Edit Due Date</div>
<div class = "edit_date_div">
<span>
	<input type = "text" class = "edit_date_inp"  flag="<?php echo $flag; ?>" value="<?php echo $date_str; ?>" disabled="disabled"/>
</span>
<span class= "no_due_date button"> No Due Date </span>
<span class = "complete_action button" > Completed </span>
</div>
<input id="date_submit" type="image" src="/static/images/submit2.png" />
<span id="formLoad">&nbsp;</span>
<?php
?>
