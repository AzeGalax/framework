$(document).ready(function(){
	//MENU
	$('.menu-element-1-caller').click(function(){
		var current = $(this);
		current.parent().find('.menu-element-1-container').slideToggle();
		current.find('.menu-caller').toggleClass('menu-called');
	});
	//$('#menu-pusher').click(function(){
	//	
	//});
});