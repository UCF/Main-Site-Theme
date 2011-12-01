var WebcomAdmin = {};


WebcomAdmin.__init__ = function($){
	// Allows forms with input fields of type file to upload files
	$('input[type="file"]').parents('form').attr('enctype','multipart/form-data');
	$('input[type="file"]').parents('form').attr('encoding','multipart/form-data');
};


WebcomAdmin.themeOptions = function($){
	cls          = this;
	cls.active   = null;
	cls.form     = $('#theme-options');
	cls.sections = $('#theme-options .fields .section');
	cls.buttons  = $('#theme-options .sections .section a');
	
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
		var http_referrer = cls.form.find('input[name="_wp_http_referer"]');
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
		
		// Fade update box after a 
		var fadeTimer = setInterval(function(){
			$('.updated').fadeOut(1000);
			clearInterval(fadeTimer);
		}, 2000);
	};
	
	if (cls.form.length > 0){
		cls.__init__();
	}
};


(function($){
	WebcomAdmin.__init__($);
	WebcomAdmin.themeOptions($);
})(jQuery);
