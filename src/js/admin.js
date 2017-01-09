// Adds filter method to array objects
// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/filter
/* jshint ignore:start */
if(!Array.prototype.filter){
	Array.prototype.filter=function(a){"use strict";if(this===void 0||this===null)throw new TypeError;var b=Object(this);var c=b.length>>>0;if(typeof a!=="function")throw new TypeError;var d=[];var e=arguments[1];for(var f=0;f<c;f++){if(f in b){var g=b[f];if(a.call(e,g,f,b))d.push(g)}}return d}
}
/* jshint ignore:end */

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
		var shortcodes = [];
		cls.select.children('.shortcode').each(function(){
			shortcodes.push($(this).val());
		});
		return shortcodes;
	})();

	cls.shortcodeAction = function(shortcode){
		var text = "[" + shortcode + "]";
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
	};

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


WebcomAdmin.centerpieceAdmin = function($) {

  var $slideCountWidget,
      $slideCountInput,
      clonePlaceholderIndex,
      clonePlaceholderRegex,
      $cloneTemplate,
      $slideWrapper;

  // Get inputs whose 'type_of_content' is checked (slides with these inputs
  // checked are considered "valid" and are the minimum requirement for saving
  // a slide.)
  function getValidContentTypeInputs() {
    return $(checkedContentTypeSelector + ':checked');
  }

  // Given an input name/CSS ID with format "ss_INPUT-NAME[INDEX]", returns the
  // index of the slide.
  function getIndex(attributeVal) {
    var index = 0,
        found = attributeVal.match(/^ss_[\w-]+\[(\d)\][\w-]*$/i);

    if (found && found[1] !== 'undefined') {
      index = found[1];
    }
    return parseInt(index, 10);
  }

  // Function that updates Slide Count meta value.  Based on if a Slide's
  // Content Type is selected.
  function updateSlideCount() {
    var $checkedContentTypeInputs = getValidContentTypeInputs();
    $slideCountInput.val($checkedContentTypeInputs.length);
  }

  // Update the Slide Sort Order:
  function updateSortOrder() {
    var sortOrder = [],
        $checkedContentTypeInputs = getValidContentTypeInputs();

    for (var i = 0; i < $checkedContentTypeInputs.length; i++) {
      var $input = $($checkedContentTypeInputs[i]),
          index = getIndex($input.attr('name'));

      sortOrder.push(index);
    }

    var orderString = sortOrder.join(',');
    $slideOrderInput.val(orderString);
  }

  // If only one slide is available on the page, hide any 'Remove slide' buttons
  function hideOnlyRemoveBtn() {
    var $slides = $slideWrapper.find('.custom_repeatable'),
        $removeBtns = $slides.find('.repeatable-remove');

    if ($slides.length < 2) {
      $removeBtns.hide();
    }
    else {
      $removeBtns.show();
    }
  }

  // Adds sorting/drag+drop functionality to individual slides.
  function initSortableSlides() {
    $slideWrapper
      .sortable({
        handle: '.meta-handle',
        placeholder: 'sortable-placeholder',
        sort: function( event, ui ) {
          $('.sortable-placeholder').height( $(this).find('.ui-sortable-helper').height() );
        },
        update: function( event, ui ) {
          updateSortOrder();
        },
        tolerance: 'pointer'
      });
  }

  function slideHandleToggle(e) {
    e.preventDefault();

    var $handle = $(e.target),
        $parent = $handle.parent('.custom_repeatable');

    $parent.toggleClass('closed');
  }

  function addSlide(e) {
    e.preventDefault();

    var $addBtn = $(e.target),
        $contentTypeInputs = $(checkedContentTypeSelector), // fetch ALL type_of_content inputs here, not just :checked
        $slide = $cloneTemplate.clone(),
        slideIndex,
        allIndexes = [],
        highestIndex;

    for (var i = 0; i < $contentTypeInputs.length; i++) {
      var $input = $($contentTypeInputs[i]),
          index = getIndex($input.attr('name'));

      allIndexes.push(index);
    }
    highestIndex = Math.max.apply(Math, allIndexes);
    slideIndex = highestIndex + 1;

    // Update slide's field attributes with new slideIndex value
    $slide
      .find('textarea, input')
        .attr('name', function(index, nameval) {
          if (nameval) {
            return nameval.replace(clonePlaceholderRegex, slideIndex);
          }
        })
        .end()
      .find('label')
        .attr('for', function(index, forval) {
          if (forval) {
            return forval.replace(clonePlaceholderRegex, slideIndex);
          }
        })
        .end()
      .find('textarea, input')
        .addBack()
        .attr('id', function(index, idval) {
          if (idval) {
            return idval.replace(clonePlaceholderRegex, slideIndex);
          }
        });

    // Insert the new slide
    $slide.insertAfter($addBtn.prev('.custom_repeatable'));

    slideChangeEvents();
  }

  function removeSlide(e) {
    e.preventDefault();

    var $removeBtn = $(e.target);
    $removeBtn.parent().remove();
    slideChangeEvents();
  }

  function slideChangeEvents() {
    updateSlideCount();
    updateSortOrder();
    hideOnlyRemoveBtn();
  }

  function onloadEvents() {
    initSortableSlides();
    $slideCountWidget.hide();
    slideChangeEvents();
  }

  function init() {
    $slideCountWidget = $('#slider-slides-settings-count');
    $slideCountInput = $('#ss_slider_slidecount');
    $slideOrderInput = $('#ss_slider_slideorder');
    clonePlaceholderIndex = '99999';
    clonePlaceholderRegex = new RegExp(clonePlaceholderIndex);
    $cloneTemplate = $('#custom_repeatable_ss_' + clonePlaceholderIndex).detach();
    $slideWrapper = $('#ss_slides_all');
    checkedContentTypeSelector = 'input[name^="ss_type_of_content["]';

    onloadEvents();
    $slideWrapper
      .on('click', '.custom_repeatable .meta-handle', slideHandleToggle)
      .on('change', checkedContentTypeSelector, slideChangeEvents)
      .on('click', '.repeatable-add', addSlide)
      .on('click', '.repeatable-remove', removeSlide);
  }

  init();

};


WebcomAdmin.subheaderAdmin = function($){
	// Subheader character count message:
	if ($('#spotlight_metabox').length > 0) {
		$('<tr><td colspan="2" style="padding: 2px 10px;"><strong>Note: Max character count for Spotlights is 200. Going over this character limit will cause the subheader content to be cut short.</strong></td></tr>').appendTo('#post-status-info tbody');
	}
};


/**
 * Adds file uploader functionality to File fields.
 * Mostly copied from https://codex.wordpress.org/Javascript_Reference/wp.media
 **/
WebcomAdmin.fileUploader = function($) {
  var $metaBody = $('#post-body');

  function addFile(e) {
    e.preventDefault();

    var $uploadBtn = $(e.target),
        $container = $uploadBtn.parents('.meta-file-wrap'),
        $field = $container.find('.meta-file-field'),
        $deleteBtn = $container.find('.meta-file-delete'),
        $previewContainer = $container.find('.meta-file-preview'),
        frame;

    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload a File',
      button: {
        text: 'Use this file'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected in the media frame...
    frame.on('select', function() {

      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment URL to our custom image input field.
      $previewContainer.html( '<img src="' + attachment.iconOrThumb + '"><br>' + attachment.filename );

      // Send the attachment id to our hidden input
      $field.val(attachment.id);

      // Hide the add image link
      $uploadBtn.addClass('hidden');

      // Unhide the remove image link
      $deleteBtn.removeClass('hidden');
    });

    // Finally, open the modal on click
    frame.open();
  }

  function removeFile(e) {
    e.preventDefault();

    var $deleteBtn = $(e.target),
        $container = $deleteBtn.parents('.meta-file-wrap'),
        $field = $container.find('.meta-file-field'),
        $uploadBtn = $container.find('.meta-file-upload'),
        $previewContainer = $container.find('.meta-file-preview');

    // Clear out the preview image
    $previewContainer.html('No file selected.');

    // Un-hide the add image link
    $uploadBtn.removeClass('hidden');

    // Hide the delete image link
    $deleteBtn.addClass('hidden');

    // Delete the image id from the hidden input
    $field.val('');
  }

  $metaBody
    .on('click', '.meta-file-upload', addFile)
    .on('click', '.meta-file-delete', removeFile);
};

WebcomAdmin.collegesUpload = function($) {
  var fileFrame,
      $btn = $('#colleges_header_image_upload'),
      $remove = $('#colleges_header_image_remove'),
      $field = $('#colleges_header_image'),
      $preview = $('#colleges_header_image_preview');

  var openModal = function() {

    if (fileFrame) {
      fileFrame.open();
      return;
    }

    fileFrame = wp.media.frames.file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        multiple: false // Set to true to allow multiple files to be selected
    });

    fileFrame.on('select', function() {
      var imageData = fileFrame.state().get('selection').first().toJSON();
      $field.val(imageData.url);
      $preview.attr('src', imageData.url);
    });

    fileFrame.open();
  };

  var removeImage = function() {
    $field.val(null);
    $preview.attr('src', '');
  };

  $btn.click(openModal);
  $remove.click(removeImage);
};

(function($){
	WebcomAdmin.__init__($);
	WebcomAdmin.themeOptions($);
	WebcomAdmin.shortcodeTool($);
	WebcomAdmin.centerpieceAdmin($);
	WebcomAdmin.subheaderAdmin($);
  WebcomAdmin.fileUploader($);
  WebcomAdmin.collegesUpload($);
})(jQuery);
