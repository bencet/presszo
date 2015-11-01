jQuery(document).ready(function($){
	$(".mapToogle").on("click", function(){
		$(".eventMap").slideToggle();
		$(this).toggleClass("active");
}); 
});