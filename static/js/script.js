var Generic = {};

Generic.homeDimensions = function($){
	var cls = this;
	cls.home_element = $('#home');
	
	cls.resizeSearch = function(){
		var div           = $('.search');
		var height        = div.height();
		var form          = div.find('form');
		var search_field  = form.find('.search-field');
		var search_button = form.find('.search-submit');
		var padding       = parseInt(div.css('padding-left')) + parseInt(div.css('padding-right'));
		
		var loops = 0;
		
		while (div.height() == height){
			var width = search_field.width();
			search_field.width(++width);
			
			loops++;
			if (loops > 1024){break;}
		}
		search_field.width(search_field.width() - 1);
	};
	
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
			if (current_font_size < 12){
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
		}
		
		element.height(target_height);
	};
	
	cls.uniformHeight = function(){
		var template = cls.home_element.data()['template'];
		
		if (template == "home-nodescription"){
			cls.resizeToHeight($('.content'), $('.site-image').height());
		}
		
		if (template == "home-description"){
			cls.resizeToHeight($('.description'), $('.site-image').height() - $('.search').height());
		}
		return;
	};
	
	if (cls.home_element.length < 1){return;}
	
	cls.uniformHeight();
	cls.resizeSearch();
	
	
};

if (typeof jQuery != 'undefined'){
	jQuery(document).ready(function($) {
		Webcom.slideshow($);
		Webcom.chartbeat($);
		Webcom.analytics($);
		Webcom.handleExternalLinks($);
		Webcom.loadMoreSearchResults($);
		
		/* Theme Specific Code Here */
		Generic.homeDimensions($);
	});
}else{console.log('jQuery dependancy failed to load');}