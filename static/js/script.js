var analytics = function($){
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

var handleExternalLinks = function($){
	var func = function(){
		var url   = $(this).attr('href');
		var host  = window.location.host.toLowerCase();
		
		if (url.search(host) < 0 && url.search('http') > -1){
			$(this).attr('target', '_blank');
		}
		
		return true;
	};
	
	$('a').click(func);
};

var chartbeat = function($){
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

(function($){
	chartbeat($);
	analytics($);
	handleExternalLinks($);
})(jQuery);
