var analytics = function($){
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
};


var slideshow = function($){
	$.fn.slideSwitch = (function(arguments){
		var defaults = {
			'fade_length'  : 2000,
			'image_length' : 6000
		};
		var options      = $.extend({}, defaults, arguments);
		var container    = $(this);
		var active       = container.children('img.active');
		var max_height   = 0;
		
		// Auto-detect height of container for slideshow
		container.children('img').each(function(){
			var height = $(this).height();
			if (height > max_height){
				max_height = height;
			}
		});
		
		container.height(max_height);
		
		if (active.length < 1){
			active = container.children('img:first');
			active.addClass('active');
			setTimeout(function(){container.slideSwitch(options);}, options.image_length);
			return;
		}
		
		var next = active.next();
		if (next.length < 1){
			next = container.children('img:first');
		}
		
		active.addClass('last-active');
		next.css({'opacity' : 0.0});
		next.addClass('active');
		next.animate({'opacity': 1.0}, options.fade_length, function(){
			active.removeClass('active last-active');
		});
		
		setTimeout(function(){container.slideSwitch(options);}, options.image_length);
	});
	
	$('.slideshow').slideSwitch();
};


var video = function($){
	$(".video a[rel]").overlay({
		mask: '#333',
		effect: 'apple',
		onBeforeLoad: function() {
			var wrap = this.getOverlay().find(".contentWrap");
			wrap.load(this.getTrigger().siblings().attr("href"));
		}
	});
	$(".vid-car").carousel({ dispItems: 3, pagination:true } );
	$(".pub-car").carousel({ dispItems: 4, pagination:true } );
};


var publications = function($){
	Shadowbox.loadSkin('classic', ADMISSIONS_JS_URL + '/shadowbox/skin');
	window.onload = function(){
		Shadowbox.init();
	};
};

(function($){
	slideshow($);
	analytics($);
	video($);
})(jQuery);
