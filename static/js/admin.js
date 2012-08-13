// Adds filter method to array objects
// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/filter
if(!Array.prototype.filter){
	Array.prototype.filter=function(a){"use strict";if(this===void 0||this===null)throw new TypeError;var b=Object(this);var c=b.length>>>0;if(typeof a!=="function")throw new TypeError;var d=[];var e=arguments[1];for(var f=0;f<c;f++){if(f in b){var g=b[f];if(a.call(e,g,f,b))d.push(g)}}return d}
}

var WebcomAdmin = {};


WebcomAdmin.__init__ = function($){
	// Allows forms with input fields of type file to upload files
	$('input[type="file"]').parents('form').attr('enctype','multipart/form-data');
	$('input[type="file"]').parents('form').attr('encoding','multipart/form-data');
};


WebcomAdmin.shortcodeTool = function($){
	cls         = this;
	cls.metabox = $('#shortcodes-metabox');
	if (cls.metabox.length < 1){console.log('no meta'); return;}
	
	cls.form     = cls.metabox.find('form');
	cls.search   = cls.metabox.find('#shortcode-search');
	cls.button   = cls.metabox.find('button');
	cls.results  = cls.metabox.find('#shortcode-results');
	cls.select   = cls.metabox.find('#shortcode-select');
	cls.form_url = cls.metabox.find("#shortcode-form").val();
	cls.text_url = cls.metabox.find("#shortcode-text").val();
	
	cls.shortcodes = (function(){
		var shortcodes = new Array();
		cls.select.children('.shortcode').each(function(){
			shortcodes.push($(this).val());
		});
		return shortcodes;
	})();
	
	cls.shortcodeAction = function(shortcode){
		var text = "[" + shortcode + "]"
		send_to_editor(text);
	};
	
	cls.searchAction = function(){
		cls.results.children().remove();
		
		var value = cls.search.val();
		
		if (value.length < 1){
			return;
		}
		
		var found = cls.shortcodes.filter(function(e, i, a){
			return e.match(value);
		});
		
		if (found.length > 1){
			cls.results.removeClass('empty');
		}
		
		$(found).each(function(){
			var item      = $("<li />");
			var link      = $("<a />");
			link.attr('href', '#');
			link.addClass('shortcode');
			link.text(this.valueOf());
			item.append(link);
			cls.results.append(item);
		});
		
		
		if (found.length > 1){
			cls.results.removeClass('empty');
		}else{
			cls.results.addClass('empty');
		}
		
	};
	
	cls.buttonAction = function(){
		cls.searchAction();
	};
	
	cls.itemAction = function(){
		var shortcode = $(this).text();
		cls.shortcodeAction(shortcode);
		return false;
	};
	
	cls.selectAction = function(){
		var selected = $(this).find(".shortcode:selected");
		if (selected.length < 1){return;}
		
		var value = selected.val();
		cls.shortcodeAction(value);
	};
	
	//Resize results list to match size of input
	cls.results.width(cls.search.outerWidth());
	
	// Disable enter key causing form submit on shortcode search field
	cls.search.keyup(function(e){
		cls.searchAction();
		
		if (e.keyCode == 13){
			return false;
		}
	});
	
	// Search button click action, cause search
	cls.button.click(cls.buttonAction);
	
	// Option change for select, cause action
	cls.select.change(cls.selectAction);
	
	// Results click actions
	cls.results.find('li a.shortcode').live('click', cls.itemAction);
};


WebcomAdmin.themeOptions = function($){
	cls          = this;
	cls.active   = null;
	cls.parent   = $('.i-am-a-fancy-admin');
	cls.sections = $('.i-am-a-fancy-admin .fields .section');
	cls.buttons  = $('.i-am-a-fancy-admin .sections .section a');
	
	this.showSection = function(e){
		var button  = $(this);
		var href    = button.attr('href');
		var section = $(href);
		
		// Switch active styles
		cls.buttons.removeClass('active');
		button.addClass('active');
		
		cls.active.hide();
		cls.active = section;
		cls.active.show();
		
		history.pushState({}, "", button.attr('href'));
		var http_referrer = cls.parent.find('input[name="_wp_http_referer"]');
		http_referrer.val(window.location);
		return false;
	}
	
	this.__init__ = function(){
		cls.active = cls.sections.first();
		cls.sections.not(cls.active).hide();
		cls.buttons.first().addClass('active');
		cls.buttons.click(this.showSection);
		
		if (window.location.hash){
			cls.buttons.filter('[href="' + window.location.hash + '"]').click();
		}
		
		var fadeTimer = setInterval(function(){
			$('.updated').fadeOut(1000);
			clearInterval(fadeTimer);
		}, 2000);
	};
	
	if (cls.parent.length > 0){
		cls.__init__();
	}
	
	
	
	// Slider Meta Box Updates:
	// (only run this code if we're on a screen with #slider-slides-settings-basic;
	// i.e. if we're on a slider edit screen:
	if ($('#poststuff #slider-slides-settings-basic')) {
		
		var slide_count_widget 	 = $('#slider-slides-settings-count')/*,
			slide_content_type_1 = $("input[name='ss_type_of_content-1']"),
			slide_content_type_2 = $("input[name='ss_type_of_content-2']"),
			slide_content_type_3 = $("input[name='ss_type_of_content-3']"),
			slide_content_type_4 = $("input[name='ss_type_of_content-4']"),
			slide_content_type_5 = $("input[name='ss_type_of_content-5']")*/;
		
		// Function that shows/hides Slide widget options based on the Content Type selected:
		var displaySlideOptions = function() {
			
			var i = 0;
			$('#ss_slides_all .custom_repeatable').each(function() {
				// Create Content Type variable per generated widget:
				var slide_content_type 		= $('input[name="ss_type_of_content['+i+']"]');
				var slide_image_field_tr 	= $('label[for="ss_slide_image['+i+']"]').closest('tr'); 
				var slide_video_field_tr	= $('label[for="ss_slide_video['+i+']"]').closest('tr');
				var slide_links_to_field_tr = $('label[for="ss_slide_links_to['+i+']"]').closest('tr');
				
				if (slide_content_type.filter(':checked').length == 0) {
					//alert('nothing is checked');
					slide_image_field_tr.hide();
					slide_video_field_tr.hide();
				}
				else if (slide_content_type.filter(':checked').val() == 'image') {
					//alert('image is checked');
					slide_video_field_tr.hide();
					slide_image_field_tr.fadeIn();
					slide_links_to_field_tr.fadeIn();
				}
				else if (slide_content_type.filter(':checked').val() == 'video') {
					//alert('video is checked');
					slide_image_field_tr.hide();
					slide_links_to_field_tr.hide();
					slide_video_field_tr.fadeIn();
				}
				i++;
			});
			
			//alert(i);
		}
		
		// Function that updates slide count value based on if a Slide's Content Type is selected:
		var checkSlideCount = function() {
			var slideCount = 0;
			for (i = 0; i < 50; i++) {
				var slide_content_type = $('input[name="ss_type_of_content['+i+']"]');
				
				if (slide_content_type && slide_content_type.filter(':checked').length > 0) {
					slideCount = slideCount + 1;
				}
				$("input#ss_slider_slidecount").val(slideCount);
			}
		}
		
		
		// Update the slide sort order:
		var updateSliderSortOrder = function() {
			var sortOrder = [];
			i = 0;
			$('#ss_slides_all .custom_repeatable').each(function() {
				sortOrder[sortOrder.length] = i;
				i++;
			});
			slide_count_widget.show();
			var orderString = '';
			$.each(sortOrder, function(index, value) {
				//value = parseInt(value.substr(value.length-2, value.length-1));
				// make sure we only have number values (i.e. only slider widgets):
				if (!isNaN(value)) {
					orderString += value + ",";
				}
			});
			// add each value to Slide Order field value:
			$('#ss_slider_slideorder').attr('value', orderString);
			slide_count_widget.hide();
		}
		
		
		// Add/remove Slide button functionality:
		$('.repeatable-add').click(function() {
			field = $(this).prev('li').clone(true);
			fieldLocation = $(this).prev('li');
			// Update 'name' attributes
			$('input, textarea', field).val('').attr('name', function(index, name) {
				return name.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			});
			// Update 'for' attributes (in <label>)
			$('label', field).val('').attr('for', function(index, forval) {
				return forval.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			});
			// Update 'id' attributes
			$('textarea, input[type="text"], input[type="radio"], input[type="select"], input[type="checkbox"]', field).val('').attr('id', function(index, val) {
				return val.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			});
			
			field.insertAfter(fieldLocation, $(this).prev('li'));
			return false;
		});
		
		$('.repeatable-remove').click(function(){
			$(this).parent().remove();
			return false;
		});
		
		
		// Admin onload:
		slide_count_widget.hide();
		updateSliderSortOrder();
		displaySlideOptions();
		
		// Content Type radio button onchange:
		$('#ss_slides_all .custom_repeatable input[name^="ss_type_of_content["]').change(function() {
			//alert('change');
			// Re-show and hide the count widget div so we can affect its children:
			slide_count_widget.show();
			checkSlideCount();
			slide_count_widget.hide();
			displaySlideOptions();
		});
		
		// Slide widget drag/drop on stop:
		$('#slider-slide-content-1 .hndle, #slider-slide-content-2 .hndle, #slider-slide-content-3 .hndle, #slider-slide-content-4 .hndle, #slider-slide-content-5 .hndle')
		.mousedown(function() {
			$(window).mousemove(function() { // Not perfect but works:
				updateSliderSortOrder();
			});
		});
	}
	
	
};

(function($){
	WebcomAdmin.__init__($);
	WebcomAdmin.themeOptions($);
	WebcomAdmin.shortcodeTool($);
})(jQuery);
