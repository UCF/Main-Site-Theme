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

(function($){
	analytics($);
})(jQuery);
