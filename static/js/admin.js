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
};


(function($){
	WebcomAdmin.__init__($);
	WebcomAdmin.themeOptions($);
	WebcomAdmin.shortcodeTool($);
})(jQuery);
