$(document).ready(function(){
	$('.notification').hide();
	$('.wall_post:first').before($('.notification'));
	$('.notification').slideDown('slow');
});
