/******************************************************************************\
 Global Namespace
 the only variable exposed to the window should be Webcom
\******************************************************************************/
var Webcom = {};

if(!window.console ) { window.console = { log: function() { return; } }; }

// for jslint validation
/*global window, document, Image, google, $, jQuery */

Webcom.analytics = function($){
	if ((typeof GA_ACCOUNT !== 'undefined') && Boolean(GA_ACCOUNT)){
		// Google analytics code
		var _sf_startpt=(new Date()).getTime();
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', GA_ACCOUNT]);
		_gaq.push(['_setDomainName', 'none']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);
		(function(){
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	}
};

Webcom.handleExternalLinks = function($){
	$('a:not(.ignore-external)').each(function(){
		var url  = $(this).attr('href');
		var host = window.location.host.toLowerCase();
		
		if (url && url.search(host) < 0 && url.search('http') > -1){
			$(this).attr('target', '_blank');
			$(this).addClass('external');
		}
	});
};

Webcom.chartbeat = function($){
	if ((typeof CB_UID !== 'undefined') && Boolean(CB_UID)){
		var _sf_async_config={
			uid   : parseInt(CB_UID),
			domain: CB_DOMAIN
		};
		(function(){
			function loadChartbeat() {
				window._sf_endpt=(new Date()).getTime();
				var e = document.createElement('script');
				e.setAttribute('language', 'javascript');
				e.setAttribute('type', 'text/javascript');
				e.setAttribute('src',
					(
						("https:" == document.location.protocol) ?
						"https://s3.amazonaws.com/" : "http://"
					) + "static.chartbeat.com/js/chartbeat.js"
				);
				document.body.appendChild(e);
			}
			var oldonload = window.onload;
			window.onload = (typeof window.onload != 'function') ?
				loadChartbeat : function() {
					oldonload(); loadChartbeat();
				};
		})();
	}
};

Webcom.loadMoreSearchResults = function($){
	var more        = '#search-results .more';
	var items       = '#search-results .result-list .item';
	var list        = '#search-results .result-list';
	var start_class = 'new-start';
	
	var next = null;
	var sema = null;
	
	var load = (function(){
		if (sema){
			setTimeout(function(){load();}, 100);
			return;
		}
		
		if (next == null){return;}
		
		// Grab results content and append to current results
		var results = $(next).find(items);
		
		// Add navigation class for scroll
		$('.' + start_class).removeClass(start_class);
		$(results[0]).addClass(start_class);
		
		$(list).append(results);
		
		// Grab new more link and replace current with new
		var anchor = $(next).find(more);
		if (anchor.length < 1){
			$(more).remove();
		}
		$(more).attr('href', anchor.attr('href'));
		
		next = null;
	});
	
	var prefetch = (function(){
		sema = true;
		// Fetch url for href via ajax
		var url = $(more).attr('href');
		if (url){
			$.ajax({
				'url'     : url,
				'success' : function(data){
					next = data;
				},
				'complete' : function(){
					sema = false;
				}
			});
		}
	});
	
	var load_and_prefetch = (function(){
		load();
		prefetch();
	});
	
	if ($(more).length > 0){
		load_and_prefetch();
	
		$(more).click(function(){
			load_and_prefetch();
			var scroll_to = $('.' + start_class).offset().top - 10;
			
			var element = 'body';
			
			if($.browser.mozilla || $.browser.msie){
				element = 'html';
			}
			
			$(element).animate({'scrollTop' : scroll_to}, 1000);
			return false;
		});
	}
};

Webcom.slideshow = function($){
	/**
	 * Create slideshow of arbitrary objects.  Class each item to be a slide
	 * as 'slide', and recommend you set a static height and width on the 
	 * slideshow container.
	 * 
	 * Example:
	 * <div class="slides">
	 *   <img class="slide"...>
	 *   <div class="slide">...</div>
	 * </div>
	 * 
	 * $('.slides').slideShow({
	 *   'transition_length' : 2000,
	 *   'cycle_length': 4000
	 * });
	 *
	 * The options can be overridden by setting the data-tranlen and
	 * data-cyclelen attributes on the slideshow container.
	 **/
	$.fn.slideShow = function (args){
		var cycle = function(items, index){
			if (items.length < 1){ return;}
			
			var next_index = (index + 1) % items.length;
			
			// Initialize active and null elements
			var active = $(items[index]);
			var next   = $(items[next_index]);
			
			next.css({'left' : -width});
			next.show();
			
			active.animate({
				'left' : '+=' + width
			}, options.transition_length, function(){
				next.css({'left' : 0});
			});
			
			next.animate({
				'left' : 0
			}, options.transition_length, function(){
				next.css({'left' : 0});
				
				setTimeout(function(){
					cycle(items, next_index);
				}, options.cycle_length);
			});
			
			return;
		};
		
		var defaults = {
			'transition_length' : 1000,
			'cycle_length'      : 5000
		};
		var options   = $.extend({}, defaults, args);
		var container = $(this);
		if (container.attr('data-tranlen')){
			options.transition_length = parseInt(container.attr('data-tranlen'));
		}
		if (container.attr('data-cyclelen')){
			options.cycle_length = parseInt(container.attr('data-cyclelen'));
		}
		var width     = container.width();
		var animating = false;
		var items     = container.children('.slide');
		var first     = $(items[0]);
		
		container.css({
			'position' : 'relative',
			'overflow' : 'hidden'
		});
		items.css({
			'position' : 'absolute',
			'width'    : width + 'px'
		});
		items.hide();
		first.show();
		
		return setTimeout(function(){
			cycle(items, 0);
		}, options.cycle_length);
	};
	
	$('.slideshow').slideShow();
};