jQuery(document).ready(function(){
  
	controlNavbarPlacement();
	
	scrollToTop();
  
});

jQuery(window).resize(function() {
	
	controlNavbarPlacement();
	
});

function controlNavbarPlacement(){
	
	var adminbarHeight = jQuery('#wpadminbar').outerHeight();
	jQuery('.admin-bar .navbar-fixed-top').css('top', adminbarHeight+'px');  
	
	var headerHeight = jQuery('#header').outerHeight();  
	jQuery('body').css('padding-top', headerHeight+'px');  
}

function scrollToTop(){
	
	jQuery( ".scroll-top" ).click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});	
}