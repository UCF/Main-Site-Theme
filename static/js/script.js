var Generic = {};

Generic.resizeSearch = function($){
	var form          = $('.search-form');
	var height        = form.height();
	var search_field  = form.find('.search-field');
	var search_button = form.find('.search-submit');
	
	var loops = 0;
	
	while (form.height() == height){
		var width = search_field.width();
		search_field.width(++width);
		
		loops++;
		if (loops > 1024){break;}
	}
	search_field.width(search_field.width() + search_button.width() - 1);
};

Generic.homeDimensions = function($){
	var cls = this;
	cls.home_element = $('#home');
	
	cls.resizeToHeight = function(element, target_height){
		if(element.length < 1){return;}
		
		var loops = 0;
		
		var difference = function(){
			return Math.abs(element.height() - target_height);
		};
		
		// Adjust smaller if the text is too large
		while (element.height() > target_height){
			var current_font_size = parseInt(element.css('font-size'));
			element.css('font-size', --current_font_size + 'px');
			if (current_font_size < 10){
				break;
			}
			if (++loops > 1024){break;}
		}
		
		
		// Adjust larger if the text is too small
		while (element.height() < target_height && difference() > 8){
			var current_font_size = parseInt(element.css('font-size'));
			element.css('font-size', ++current_font_size + 'px');
			if (element.height() > target_height && difference() > 8){
				element.css('font-size', --current_font_size + 'px');
				break;
			}
			if (++loops > 1024){break;}
			console.log(element.height(), target_height, current_font_size);
		}
		
		element.height(target_height);
	};
	
	cls.uniformHeight = function(){
		var template = cls.home_element.data()['template'];
		
		if (template == "home-nodescription"){
			cls.resizeToHeight($('.content'), $('.site-image').height());
		}
		
		if (template == "home-description"){
			cls.resizeToHeight($('.right-column .description'), $('.site-image').height() - $('.search').height());
		}
		return;
	};
	
	if (cls.home_element.length < 1){return;}
	
	cls.uniformHeight();
};


Generic.defaultMenuSeparators = function($) {
	// Because IE sucks, we're removing the last stray separator
	// on default navigation menus for browsers that don't 
	// support the :last-child CSS property
	$('.menu.horizontal li:last-child').addClass('last');
};

Generic.removeExtraGformStyles = function($) {
	// Since we're re-registering the Gravity Form stylesheet
	// manually and we can't dequeue the stylesheet GF adds
	// by default, we're removing the reference to the script if
	// it exists on the page (if CSS hasn't been turned off in GF settings.)
	$('link#gforms_css-css').remove();
}

Generic.mobileNavBar = function($) {
	// Switch the navigation bar from standard horizontal nav to bootstrap mobile nav
	// when the browser is at mobile size:
	var mobile_wrap = function() {
		$('#header-menu').wrap('<div class="navbar"><div class="navbar-inner"><div class="container" id="mobile_dropdown_container"><div class="nav-collapse"></div></div></div></div>');
		$('<a class="btn btn-navbar" id="mobile_dropdown_toggle" data-target=".nav-collapse" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a class="brand" href="#">Navigation</a>').prependTo('#mobile_dropdown_container');
		$('.current-menu-item, .current_page_item').addClass('active');
	}
	var mobile_unwrap = function() {
		$('#mobile_dropdown_toggle .icon-bar').remove();
		$('#mobile_dropdown_toggle').remove();
		$('#mobile_dropdown_container a.brand').remove();
		$('#header-menu').unwrap();
		$('#header-menu').unwrap();
		$('#header-menu').unwrap();
		$('#header-menu').unwrap();
	}
	var adjust_mobile_nav = function() {
		if ($(window).width() < 480) {
			if ($('#mobile_dropdown_container').length < 1) {
				mobile_wrap();
			}
		}
		else {
			if ($('#mobile_dropdown_container').length > 0) {
				mobile_unwrap();
			}
		}
	}
	
	if ( !($.browser.msie && $.browser.version < 9) ) { /* Don't resize in IE8 or older */
		adjust_mobile_nav();
		$(window).resize(function() {
			adjust_mobile_nav();
		});
	}
}

Generic.mobileSidebar = function($) {
	var moveSidebar = function() {
		if ($(window).width() < 769) {
			$('#sidebar_left').remove().insertAfter('#contentcol');
		}
		else {
			$('#sidebar_left').remove().insertBefore('#contentcol');
		}
	}
	if ( !($.browser.msie && $.browser.version < 9) ) { /* Don't resize in IE8 or older */
		moveSidebar();
		$(window).resize(function() {
			moveSidebar();
		});
	}
};



/* Slider init */

centerpieceSlider = function($) {
	var slider = $('#centerpiece_slider');
	if(slider.length) {
		
		// Get all duration values:
		var timeouts = new Array();
		$('#centerpiece_slider ul li').each(function() {
			duration = $(this).attr('data-duration');
			// Just in case it's not assigned through php somehow:
			if (duration == '') {
				duration = 6;
			}
			timeouts.push(duration);
		});
		
		// Initiate slider:		
		$(function() { 
			$('#centerpiece_slider ul').cycle({ 
				delay:  -2000, 
				fx:     'fade', 
				speed:  2000, 
				pager:  '#centerpiece_control',
				slideExpr: '.centerpiece_single',
				slideResize: 0,
				timeoutFn: calculateTimeout 
			}); 
		});
			 
		// timeouts per slide (in seconds) 
		function calculateTimeout(currElement, nextElement, opts, isForward) { 
			var index = opts.currSlide; 
			return timeouts[index] * 1000; 
		}
		
		// Pause slider on hover:
		/*
		$('#centerpiece_slider').hover(function() {
			$('#centerpiece_slider ul').cycle('pause'); 
		},
		function () {
			$('#centerpiece_slider ul').cycle('resume');
		});*/
		
		// Stop slider when a video thumbnail is clicked:
		$('.centerpiece_single_vid_thumb').click(function() { 
			$('#centerpiece_slider ul').cycle('pause');
			$(this).hide().next().fadeIn(500);
			// Also hide the centerpiece controls for mobile devices:
			if ($(window).width() <= 768) {
				$('#centerpiece_control').hide();
			}
		});
		
		// If a centerpiece control button is clicked, kill any videos and fix slide dimensions:
		$('#centerpiece_control').click(function() {
			$('#centerpiece_slider li iframe, #centerpiece_slider li object, #centerpiece_slider li embed').each(function() {
				var oldsrc = $(this).attr('src');
				$(this).attr('src', 'empty');
				$(this).attr('src', oldsrc);
				if ($(this).parent().prev('.centerpiece_single_vid_thumb')) {
					$(this).parent().hide().prev('.centerpiece_single_vid_thumb').show();
				}
			});
		});
		
	}
}


/* Adjust slider video/embed size on window resize (for less than 767px) */

centerpieceVidResize = function($) {
	var addDimensions = function() {
		var parentw = $('#centerpiece_slider').parent('.span12').width();
		if ($(window).width() <= 767) {
			$('li.centerpiece_single .centerpiece_single_vid_hidden, li.centerpiece_single object, li.centerpiece_single iframe, li.centerpiece_single embed')
				.css({'height' : parentw * 0.36 +'px'});
		}
		else if ($(window).width() > 767) {
			$('li.centerpiece_single .centerpiece_single_vid_hidden, li.centerpiece_single object, li.centerpiece_single iframe, li.centerpiece_single embed')
				.css({'height' : ''});
		}
	}
	if ( !($.browser.msie && $.browser.version < 9) ) { /* Don't resize in IE8 or older */
		addDimensions();
		$(window).resize(function() {
			addDimensions();
		});
	}
}


/* Remove last dot separator between nav menu links: */
removeNavSeparator = function($) {
	var navcount = $('ul#header-menu li').length - 1;
	$('ul#header-menu li:nth-child('+navcount+')').addClass('no_nav_separator');
}


/* Fix subheader height to contain blockquote if it exceeds past its container: */
fixSubheaderHeight = function($) {
	var doSubheaderHeight = function() {
		if ($(window).width() > 768) { /* Subhead images hide below this size */
			var subimgHeight = $('#subheader .subheader_subimg').height(),
				quoteHeight = $('#subheader .subhead_quote').height();
			console.log('subimg height is:' + subimgHeight);
			console.log('quoteHeight is:' + quoteHeight);
			if (quoteHeight > subimgHeight) {
				$('#subheader').height(quoteHeight);
			}
			else {
				$('#subheader').height(subimgHeight);
			}
		}
	}
	if ( !($.browser.msie && $.browser.version < 9) ) { /* Don't resize in IE8 or older */
		$(window).load(function() {
			doSubheaderHeight();
		});
		$(window).resize(function() {
			doSubheaderHeight();
		});
	}
}



/* IE 7-8 fix for News thumbnails-- requires jquery.backgroundSize.js */
ieFixNewsThumbs = function($) {
	$('#home_centercol .news .item .news-thumb').css( "background-size", "cover" );
}



if (typeof jQuery != 'undefined'){
	jQuery(document).ready(function($) {
		Webcom.slideshow($);
		Webcom.analytics($);
		Webcom.handleExternalLinks($);
		Webcom.loadMoreSearchResults($);
		
		/* Theme Specific Code Here */
		//Generic.homeDimensions($);
		//Generic.resizeSearch($);
		Generic.defaultMenuSeparators($);
		Generic.removeExtraGformStyles($);
		Generic.mobileNavBar($);
		
		Generic.mobileSidebar($);
		centerpieceSlider($);
		centerpieceVidResize($);
		removeNavSeparator($);
		fixSubheaderHeight($);
		ieFixNewsThumbs($);
		
	});
}else{console.log('jQuery dependancy failed to load');}