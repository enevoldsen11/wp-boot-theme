jQuery(document).ready(function(){
  
	controlNavbarPlacement();
  
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
		
}