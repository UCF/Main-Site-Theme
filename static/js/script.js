var Generic = {};

Generic.homeDimensions = function($){
	var cls = this;
	cls.home_element = $('#home');
	cls.left_column  = cls.home_element.children('.image');
	cls.right_column = cls.home_element.children('.right-column');
	
	cls.resizeRightColumn = function(){
		var height = cls.left_column.height();
		cls.right_column.height(height);
	};
	
	cls.resizeDescription = function(){
		var text_element  = cls.right_column.find('.description p');
		if (text_element.length < 1){return;}
		
		cls.right_column.css({
			'position' : 'relative',
			'overflow' : 'hidden'
		});
		cls.right_column.children('.search').css({
			'position' : 'absolute',
			'bottom'   : '0'
		});
		
		var target_height = cls.right_column.height() - cls.right_column.children('.search').height();
		var difference    = function(){
			return Math.abs(text_element.height() - target_height);
		};
		
		// Adjust smaller if the text is too large
		while (text_element.height() > target_height){
			var current_font_size = parseInt(text_element.css('font-size'));
			text_element.css('font-size', --current_font_size + 'px');
			if (current_font_size < 10){
				break;
			}
		}
		
		
		// Adjust larger if the text is too small
		while (text_element.height() < target_height && difference() > 10){
			var current_font_size = parseInt(text_element.css('font-size'));
			text_element.css('font-size', ++current_font_size + 'px');
			if (text_element.height() > target_height){
				text_element.css('font-size', --current_font_size + 'px');
				break;
			}
		}
	};
	
	if (cls.home_element.length < 1){return;}
	cls.resizeRightColumn();
	cls.resizeDescription();
	
	
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