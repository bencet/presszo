jQuery.fn.ticker = function( options ) {
	var handler = jQuery(this);
    var defaults = {
        delay: 10
    };
 
    var settings = jQuery.extend( {}, defaults, options );
	var true_width = 0;
	var number_li = handler.find('li').length;
	handler.find('li').each(function(){
		true_width += jQuery(this).width();
	});
	var parent_width = handler.parent().width();
	var left_point = true_width + 20;
	var delay = settings.delay * number_li * 1000;
	

	
	
	
	
	function scrollnews(the_left, app_delay){
		handler.animate({left: '-'+ the_left + 'px'} , app_delay, "linear", function(){
			parent_width = handler.parent().width();
			left_point = true_width + 20;
			handler.css("left", parent_width +'px'); 
			scrollnews(left_point, delay);});
	}
	scrollnews(left_point, delay);
	handler.hover(function(){
		handler.stop();
	},
	function(){
		var offset = handler.offset();
		var tripped = parent_width - offset.left;
		var total_trip = left_point + parent_width;
		var remain_trip = total_trip - tripped;
		var remain_delay = Math.ceil((remain_trip / total_trip) * delay);
		scrollnews(left_point, remain_delay);
	});		
	
};
jQuery(document).ready(function(){
	jQuery('.news-box.break ul').ticker({delay:TICKER_DELAY});
});
