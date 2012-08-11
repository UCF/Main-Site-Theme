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
		
		
		
		var slide_count_widget 	 = $('#slider-slides-settings-count'),
			slide_content_type_1 = $("input[name='ss_type_of_content-1']"),
			slide_content_type_2 = $("input[name='ss_type_of_content-2']"),
			slide_content_type_3 = $("input[name='ss_type_of_content-3']"),
			slide_content_type_4 = $("input[name='ss_type_of_content-4']"),
			slide_content_type_5 = $("input[name='ss_type_of_content-5']");
		
		// Hide slide count box:
		//slide_count_widget.hide();
		
		// Function that shows/hides Slide widget options based on the Content Type selected:
		// Todo: simplify function to dynamically generate variables/values based on slide count range
		var displaySlideOptions = function() {
			
			var image_field_tr_1 = 		$('label[for="ss_slide_image-1"]').closest('tr'),
				video_field_tr_1 = 		$('label[for="ss_slide_video-1"]').closest('tr'),
				links_to_field_tr_1 = 	$('label[for="ss_slide_links_to-1"]').closest('tr'),
				image_field_tr_2 = 		$('label[for="ss_slide_image-2"]').closest('tr'),
				video_field_tr_2 = 		$('label[for="ss_slide_video-2"]').closest('tr'),
				links_to_field_tr_2 = 	$('label[for="ss_slide_links_to-2"]').closest('tr'),
				image_field_tr_3 = 		$('label[for="ss_slide_image-3"]').closest('tr'),
				video_field_tr_3 = 		$('label[for="ss_slide_video-3"]').closest('tr'),
				links_to_field_tr_3 = 	$('label[for="ss_slide_links_to-3"]').closest('tr'),
				image_field_tr_4 = 		$('label[for="ss_slide_image-4"]').closest('tr'),
				video_field_tr_4 = 		$('label[for="ss_slide_video-4"]').closest('tr'),
				links_to_field_tr_4 = 	$('label[for="ss_slide_links_to-4"]').closest('tr'),
				image_field_tr_5 = 		$('label[for="ss_slide_image-5"]').closest('tr'),
				video_field_tr_5 = 		$('label[for="ss_slide_video-5"]').closest('tr'),
				links_to_field_tr_5 = 	$('label[for="ss_slide_links_to-5"]').closest('tr');
			
			// Slide 1:
			if (slide_content_type_1.filter(':checked').length == 0) {
				image_field_tr_1.hide();
				video_field_tr_1.hide();
			}
			else if (slide_content_type_1.filter(':checked').val() == 'image') {
				video_field_tr_1.hide();
				image_field_tr_1.fadeIn();
				links_to_field_tr_1.fadeIn();
			}
			else if (slide_content_type_1.filter(':checked').val() == 'video') {
				image_field_tr_1.hide();
				links_to_field_tr_1.hide();
				video_field_tr_1.fadeIn();
			}
			
			// Slide 2:
			if (slide_content_type_2.filter(':checked').length == 0) {
				image_field_tr_2.hide();
				video_field_tr_2.hide();
			}
			else if (slide_content_type_2.filter(':checked').val() == 'image') {
				video_field_tr_2.hide();
				image_field_tr_2.fadeIn();
				links_to_field_tr_2.fadeIn();
			}
			else if (slide_content_type_2.filter(':checked').val() == 'video') {
				image_field_tr_2.hide();
				links_to_field_tr_2.hide();
				video_field_tr_2.fadeIn();
			}
			
			// Slide 3:
			if (slide_content_type_3.filter(':checked').length == 0) {
				image_field_tr_3.hide();
				video_field_tr_3.hide();
			}
			else if (slide_content_type_3.filter(':checked').val() == 'image') {
				video_field_tr_3.hide();
				image_field_tr_3.fadeIn();
				links_to_field_tr_3.fadeIn();
			}
			else if (slide_content_type_3.filter(':checked').val() == 'video') {
				image_field_tr_3.hide();
				links_to_field_tr_3.hide();
				video_field_tr_3.fadeIn();
			}
			
			// Slide 4:
			if (slide_content_type_4.filter(':checked').length == 0) {
				image_field_tr_4.hide();
				video_field_tr_4.hide();
			}
			else if (slide_content_type_4.filter(':checked').val() == 'image') {
				video_field_tr_4.hide();
				image_field_tr_4.fadeIn();
				links_to_field_tr_4.fadeIn();
			}
			else if (slide_content_type_4.filter(':checked').val() == 'video') {
				image_field_tr_4.hide();
				links_to_field_tr_4.hide();
				video_field_tr_4.fadeIn();
			}
			
			// Slide 5:
			if (slide_content_type_5.filter(':checked').length == 0) {
				image_field_tr_5.hide();
				video_field_tr_5.hide();
			}
			else if (slide_content_type_5.filter(':checked').val() == 'image') {
				video_field_tr_5.hide();
				image_field_tr_5.fadeIn();
				links_to_field_tr_5.fadeIn();
			}
			else if (slide_content_type_5.filter(':checked').val() == 'video') {
				image_field_tr_5.hide();
				links_to_field_tr_5.hide();
				video_field_tr_5.fadeIn();
			}
			
		}
		
		// Hide any slides (except Slide 1) that don't have a Content Type assigned:
		
		// HOLD OFF ON USING THIS UNTIL AFTER DRAG+DROP SORTING IS DONE
		
		/*if (slide_content_type_2.filter(':checked').length == 0) {
			$('#slider-slide-content-2').hide();
		}
		if (slide_content_type_3.filter(':checked').length == 0) {
			$('#slider-slide-content-3').hide();
		}
		if (slide_content_type_4.filter(':checked').length == 0) {
			$('#slider-slide-content-4').hide();
		}
		if (slide_content_type_5.filter(':checked').length == 0) {
			$('#slider-slide-content-5').hide();
		}*/
		
		// Function that updates slide count value based on if a Slide's Content Type is selected:
		var checkSlideCount = function() {
			var slideCount = 0;
			if (slide_content_type_1.filter(':checked').length > 0) {
				slideCount = slideCount + 1;
			}
			if (slide_content_type_2.filter(':checked').length > 0) {
				slideCount = slideCount + 1;
			}
			if (slide_content_type_3.filter(':checked').length > 0) {
				slideCount = slideCount + 1;
			}
			if (slide_content_type_4.filter(':checked').length > 0) { 
				slideCount = slideCount + 1;
			}
			if (slide_content_type_5.filter(':checked').length > 0) {
				slideCount = slideCount + 1;
			}
			$("input#ss_slider_slidecount").val(slideCount);
		}
		
		
		// Admin onload:
		displaySlideOptions();
		
		// Content Type radio button onchange:
		$("input[name='ss_type_of_content-1'], input[name='ss_type_of_content-2'], input[name='ss_type_of_content-3'], input[name='ss_type_of_content-4'], input[name='ss_type_of_content-5']").change(function() {
			// Re-show and hide the count widget div so we can affect its children:
			slide_count_widget.show();
			checkSlideCount();
			slide_count_widget.hide();
			displaySlideOptions();
		});
		
	}
	
	
};

(function($){
	WebcomAdmin.__init__($);
	WebcomAdmin.themeOptions($);
	WebcomAdmin.shortcodeTool($);
})(jQuery);
