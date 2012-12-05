var Generic = {};

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
		$('#header-menu').wrap('<div class="navbar navbar-inverse"><div class="navbar-inner"><div class="container" id="mobile_dropdown_container"><div class="nav-collapse"></div></div></div></div>');
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
		if ($(window).width() <= 480) {
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
	
	if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
		adjust_mobile_nav();
		$(window).resize(function() {
			adjust_mobile_nav();
		});
	}
}

Generic.mobileSidebar = function($) {
	var moveSidebar = function() {
		if ($(window).width() < 768) {
			$('#sidebar_left').remove().insertAfter('#contentcol');
		}
		else {
			$('#sidebar_left').remove().insertBefore('#contentcol');
		}
	}
	if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
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
	if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
		addDimensions();
		$(window).resize(function() {
			addDimensions();
		});
	}
}


/* Set/Unset iframe source on video modal open/close */
videoModalSet = function($) {
	$('.video-modal').on('show', function() {
		var modalID = $(this).attr('id');
		var src = $(this).children('.modal-body').attr('data-src');
		
		if ($(this).find('iframe').length < 1) {
			$('#' + modalID + ' .modal-body').append('<iframe class="modal-video-player" type="text/html" width="640" height="390" src="'+ src +'" frameborder="0"/>');
		}
	});
	
	$('.video-modal').on('hide', function() {
		$(this).find('iframe').remove();
	});
}


/* Hide the centerpiece placeholder for single-slide centerpieces
 so that the slide displays properly */
centerpieceSingleSlide = function($) {
	if ( $('#centerpiece_slider > ul li').length < 2 ) {
		$('#centerpiece_slider > ul > img, #centerpiece_control').hide();
	}
}


/* Remove last dot separator between nav menu links: */
removeNavSeparator = function($) {
	//var navcount = $('ul#header-menu li').length - 1;
	$('ul#header-menu li.last').prev('li').addClass('no_nav_separator');
}


/* Add Bootstrap button styles for GravityForm submit buttons */
styleGformButtons = function($) {
	$('.gform_button').addClass('btn');
	$(document).bind('gform_post_render', function(){
		// Handle buttons generated with ajax
    	$('.gform_button').addClass('btn');
	});
}


/* Fix subheader height to contain blockquote if it exceeds past its container: */
fixSubheaderHeight = function($) {
	var doSubheaderHeight = function() {
		if ($(window).width() >= 768 && $('#subheader').length > 0) { /* Subhead images hide below this size */
			var subimgHeight = $('#subheader .subheader_subimg').height(),
				quoteHeight = $('#subheader .subhead_quote').height();
			if (quoteHeight > subimgHeight) {
				$('#subheader').height(quoteHeight);
			}
			else {
				$('#subheader').height(subimgHeight);
			}
		}
	}
	if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
		$(window).load(function() {
			doSubheaderHeight();
		});
		$(window).resize(function() {
			doSubheaderHeight();
		});
	}
}


/* Call A-Z Index Scrollspy, organize post type search */
azIndex = function($) {
	if ($('.page-content#azindex').length > 0) {
		
		if ($('body').hasClass('ie7') == false) {
			$('body').attr({'data-spy' : 'scroll', 'data-offset' : 80, 'data-target' : '#azIndexList'});
			$('#azIndexList').scrollspy();
		}
		else {
			$('#azIndexList').attr('data-offset-top', '').attr('data-spy', '');
		}
		
		$('.post-type-search-header').addClass('row').prepend($('#azIndexList'));
		$('form.post-type-search-form')
			.addClass('span7')
			.children('label')
				.text('Quick Search:')
				.show();
		$('form.post-type-search-form')
			.children('input')
				.removeClass('span3')
				.addClass('search-query');
		
		$('.post-type-search-alpha h3').each(function() {
			$(this)
				.parent('div').prepend('<div class="az-jumpto-anchor" id="az-' + $(this).text().toLowerCase() + '" />')
				.children('h3').after('<span class="backtotop"><i class="icon-arrow-up"></i> <a href="#top">Back to Top</a></span>');
		});
		
		// Force 'A' as the active starting letter, since it likes to
		// default to 'Z' for whatever reason
		$('#azIndexList .nav li.active').removeClass('active');
		$('#azIndexList .nav li:first-child').addClass('active');
		
		// Reset active letter link when 'Back to Top' is clicked
		$('.backtotop a').click(function() {
			$('#azIndexList .nav li.active').removeClass('active');
			$('#azIndexList .nav li:first-child').addClass('active');
		});
		
		// Set disabled letters for sections with no content
		$('.az-jumpto-anchor').each(function() {
			if ($(this).siblings('.row').children('div').length < 1) {
				var href = '#' + $(this).attr('id');
				$('#azIndexList .nav li a[href="'+ href +'"]').addClass('disabled');
			}
		});
		$('#azIndexList .nav li a.disabled').click(function(e) {
			e.preventDefault();
		});		
	}
}


/* Show/hide announcement filter dropdowns */
toggleAnnouncementFilters = function($) {
	audienceBtn = $('#filter_audience');
	keywordBtn = $('#filter_keyword');
	timeBtn = $('#filter_time');
	
	// reset field values to default any time a new filter is selected
	var resetVals = function() {
		if ($('#filter_audience_wrap').hasClass('active_filter') == false) {
			$('#filter_audience_wrap select option:selected').val("all");
		}
		if ($('#filter_keyword_wrap').hasClass('active_filter') == false) {
			$(this).children('input').val("");
		}
		if ($('#filter_time_wrap').hasClass('active_filter') == false) {
			$('#filter_time_wrap select option:selected').val("thisweek");
		}
	}
	
	// on load
	if (audienceBtn.hasClass('active')) {
		$('#filter_audience_wrap').show().addClass('active_filter');
	}
	else if (keywordBtn.hasClass('active')) {
		$('#filter_keyword_wrap').show().addClass('active_filter');
	}
	else if (timeBtn.hasClass('active')) {
		$('#filter_time_wrap').show().addClass('active_filter');
	}
	resetVals();
	
	// on click
	$(audienceBtn).click(function() {
		$('.active_filter').removeClass('active_filter').hide();
		$('#filter_audience_wrap').fadeIn().addClass('active_filter');
		resetVals();
	});
	
	$(keywordBtn).click(function() {
		$('.active_filter').removeClass('active_filter').hide();
		$('#filter_keyword_wrap').fadeIn().addClass('active_filter');
		resetVals();	
	});
	
	$(timeBtn).click(function() {
		$('.active_filter').removeClass('active_filter').hide();
		$('#filter_time_wrap').fadeIn().addClass('active_filter');
		resetVals();
	});
}


/* IE 7-8 fix for rounded corners on spotlight, news thumbnails */
ieRoundedCornerThumbs = function($) {
	if ( $('body').hasClass('ie7') || $('body').hasClass('ie8') ) {
		$('<div class="thumb_corner_tl"></div><div class="thumb_corner_tr"></div><div class="thumb_corner_bl"></div><div class="thumb_corner_br"></div>').appendTo('.spotlight_thumb, .news-thumb');
	}
}


/* IE 7-8 fix for Academics Search striped results */
ieStripedAcademicsResults = function($) {
	if ($('#academics-search').length > 0) {
		if ( $('body').hasClass('ie7') || $('body').hasClass('ie8') ) {
			$('.results-list .program:nth-child(2n+1)').css('background-color', '#eee');
		}
	}
}



Generic.PostTypeSearch = function($) {
	$('.post-type-search')
		.each(function(post_type_search_index, post_type_search) {
			var post_type_search = $(post_type_search),
				form             = post_type_search.find('.post-type-search-form'),
				field            = form.find('input[type="text"]'),
				working          = form.find('.working'),
				results          = post_type_search.find('.post-type-search-results'),
				by_term          = post_type_search.find('.post-type-search-term'),
				by_alpha         = post_type_search.find('.post-type-search-alpha'),
				sorting          = post_type_search.find('.post-type-search-sorting'),
				sorting_by_term  = sorting.find('button:eq(0)'),
				sorting_by_alpha = sorting.find('button:eq(1)'),

				post_type_search_data  = null,
				search_data_set        = null,
				column_count           = null,
				column_width           = null,

				typing_timer = null,
				typing_delay = 300, // milliseconds

				prev_post_id_sum = null, // Sum of result post IDs. Used to cache results 

				MINIMUM_SEARCH_MATCH_LENGTH = 2;

			// Get the post data for this search
			post_type_search_data = PostTypeSearchDataManager.searches[post_type_search_index];
			if(typeof post_type_search_data == 'undefined') { // Search data missing
				return false;
			}

			search_data_set = post_type_search_data.data;
			column_count    = post_type_search_data.column_count;
			column_width    = post_type_search_data.column_width;

			if(column_count == 0 || column_width == '') { // Invalid dimensions
				return false;
			}

			// Sorting toggle
			sorting_by_term.click(function() {
				by_alpha.fadeOut('fast', function() {
					by_term.fadeIn();
					sorting_by_alpha.removeClass('active');
					sorting_by_term.addClass('active');
				});
			});
			sorting_by_alpha.click(function() {
				by_term.fadeOut('fast', function() {
					by_alpha.fadeIn();
					sorting_by_term.removeClass('active');
					sorting_by_alpha.addClass('active');
				});
			});

			// Search form
			form
				.submit(function(event) {
					// Don't allow the form to be submitted
					event.preventDefault();
					perform_search(field.val());
				})
			field
				.keyup(function() {
					// Use a timer to determine when the user is done typing
					if(typing_timer != null)  clearTimeout(typing_timer);
					typing_timer = setTimeout(function() {form.trigger('submit');}, typing_delay);
				});

			function display_search_message(message) {
				results.empty();
				results.append($('<p class="post-type-search-message"><big>' + message + '</big></p>'));
				results.show();
			}

			function perform_search(search_term) {
				var matches             = [],
					elements            = [],
					elements_per_column = null,
					columns             = [],
					post_id_sum         = 0;

				if(search_term.length < MINIMUM_SEARCH_MATCH_LENGTH) {
					results.empty();
					results.hide();
					return;
				}
				// Find the search matches
				$.each(search_data_set, function(post_id, search_data) {
					$.each(search_data, function(search_data_index, term) {
						if(term.toLowerCase().indexOf(search_term.toLowerCase()) != -1) {
							matches.push(post_id);
							return false;
						}
					});
				});
				if(matches.length == 0) {
					display_search_message('No results were found.');
				} else {

					// Copy the associated elements
					$.each(matches, function(match_index, post_id) {

						var element     = by_term.find('li[data-post-id="' + post_id + '"]:eq(0)'),
							post_id_int = parseInt(post_id, 10);
						post_id_sum += post_id_int;
						if(element.length == 1) {
							elements.push(element.clone());
						}
					});

					if(elements.length == 0) {
						display_search_message('No results were found.');
					} else {

						// Are the results the same as last time?
						if(post_id_sum != prev_post_id_sum) {
							results.empty();
							prev_post_id_sum = post_id_sum;
							

							// Slice the elements into their respective columns
							elements_per_column = Math.ceil(elements.length / column_count);
							for(var i = 0; i < column_count; i++) {
								var start = i * elements_per_column,
									end   = start + elements_per_column;
								if(elements.length > start) {
									columns[i] = elements.slice(start, end);
								}
							}

							// Setup results HTML
							results.append($('<div class="row"></div>'));
							$.each(columns, function(column_index, column_elements) {
								var column_wrap = $('<div class="' + column_width + '"><ul></ul></div>'),
									column_list = column_wrap.find('ul');

								$.each(column_elements, function(element_index, element) {
									column_list.append($(element));
								});
								results.find('div[class="row"]').append(column_wrap);
							});
							results.show();
						}
					}
				}
			}
		});
}

var phonebookStaffToggle = function($) {
	$('#phonebook-search-results .show_staff')
		.each(function(index, staff) {
			var staff  = $(staff);

			(function() {
				var toggle = staff.find('.toggle'),
					lists  = staff.find('ul');
				toggle
					.click(function() {
						if(lists.is(':visible')) {
							lists.fadeOut();
							$(this).html('<i class="icon-plus"></i> Show Staff');
						} else {
							lists.fadeIn();
							$(this).html('<i class="icon-minus"></i> Hide Staff');
						}
					});
			})(staff)
		});		
}


/* Dev Bootstrap Element Testing-- this should not be running in prod!! */
var devBootstrap = function($) {
	$('#bootstrap-testing-tooltips').tooltip({
		selector: "a[rel=tooltip]"
	});
	$('#bootstrap-testing-popovers').popover({
		trigger: "hover",
		selector: "a[rel=popover]"
	}); 
}

/* Bootstrap Dropdown fixes for mobile devices */
// Fixes onclick event for mobile devices
$(document).on('touchstart.dropdown', '.dropdown-menu', function(e) { e.stopPropagation(); });
// Prevents page jump on click when activating hover-able elements (dropdowns, tooltips...)
// Note that this assumes popover activators (buttons) won't have a real href value on this site.
$('.dropdown-submenu a[href="#"], a[rel="popover"], a[rel="tooltip"]').click(function(e) { e.preventDefault(); });


if (typeof jQuery != 'undefined'){
	jQuery(document).ready(function($) {
		Webcom.slideshow($);
		Webcom.analytics($);
		Webcom.handleExternalLinks($);
		Webcom.loadMoreSearchResults($);
		
		/* Theme Specific Code Here */
		Generic.defaultMenuSeparators($);
		Generic.removeExtraGformStyles($);
		Generic.mobileNavBar($);
		Generic.mobileSidebar($);
		centerpieceSlider($);
		centerpieceVidResize($);
		videoModalSet($);
		centerpieceSingleSlide($);
		removeNavSeparator($);
		styleGformButtons($);
		fixSubheaderHeight($);
		azIndex($);
		toggleAnnouncementFilters($);
		ieRoundedCornerThumbs($);
		ieStripedAcademicsResults($);
		Generic.PostTypeSearch($);
		phonebookStaffToggle($);
		
		// Disable me in Prod!!
		devBootstrap($);
	});
}else{console.log('jQuery dependancy failed to load');}