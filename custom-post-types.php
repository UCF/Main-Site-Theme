<?php

/**
 * Abstract class for defining custom post types.  
 * 
 **/
abstract class CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,  # I dunno...leave it true
		$use_title      = True,  # Title field
		$use_editor     = True,  # WYSIWYG editor, post content field
		$use_revisions  = True,  # Revisions on post content and titles
		$use_thumbnails = False, # Featured images
		$use_order      = False, # Wordpress built-in order meta data
		$use_metabox    = False, # Enable if you have custom fields to display in admin
		$use_shortcode  = False, # Auto generate a shortcode for the post type
		                         # (see also objectsToHTML and toHTML methods)
		$taxonomies     = array('post_tag'),
		$built_in       = False;
	
	
	/**
	 * Wrapper for get_posts function, that predefines post_type for this
	 * custom post type.  Any options valid in get_posts can be passed as an
	 * option array.  Returns an array of objects.
	 **/
	public function get_objects($options=array()){

		$defaults = array(
			'numberposts'   => -1,
			'orderby'       => 'title',
			'order'         => 'ASC',
			'post_type'     => $this->options('name'),
		);
		$options = array_merge($defaults, $options);
		$objects = get_posts($options);
		return $objects;
	}
	
	
	/**
	 * Similar to get_objects, but returns array of key values mapping post
	 * title to id if available, otherwise it defaults to id=>id.
	 **/
	public function get_objects_as_options($options=array()){
		$objects = $this->get_objects($options);
		$opt     = array();
		foreach($objects as $o){
			switch(True){
				case $this->options('use_title'):
					$opt[$o->post_title] = $o->ID;
					break;
				default:
					$opt[$o->ID] = $o->ID;
					break;
			}
		}
		return $opt;
	}
	
	
	/**
	 * Return the instances values defined by $key.
	 **/
	public function options($key){
		$vars = get_object_vars($this);
		return $vars[$key];
	}
	
	
	/**
	 * Additional fields on a custom post type may be defined by overriding this
	 * method on an descendant object.
	 **/
	public function fields(){
		return array();
	}
	
	
	/**
	 * Using instance variables defined, returns an array defining what this
	 * custom post type supports.
	 **/
	public function supports(){
		#Default support array
		$supports = array();
		if ($this->options('use_title')){
			$supports[] = 'title';
		}
		if ($this->options('use_order')){
			$supports[] = 'page-attributes';
		}
		if ($this->options('use_thumbnails')){
			$supports[] = 'thumbnail';
		}
		if ($this->options('use_editor')){
			$supports[] = 'editor';
		}
		if ($this->options('use_revisions')){
			$supports[] = 'revisions';
		}
		return $supports;
	}
	
	
	/**
	 * Creates labels array, defining names for admin panel.
	 **/
	public function labels(){
		return array(
			'name'          => __($this->options('plural_name')),
			'singular_name' => __($this->options('singular_name')),
			'add_new_item'  => __($this->options('add_new_item')),
			'edit_item'     => __($this->options('edit_item')),
			'new_item'      => __($this->options('new_item')),
		);
	}
	
	
	/**
	 * Creates metabox array for custom post type. Override method in
	 * descendants to add or modify metaboxes.
	 **/
	public function metabox(){
		if ($this->options('use_metabox')){
			return array(
				'id'       => $this->options('name').'_metabox',
				'title'    => __($this->options('singular_name').' Fields'),
				'page'     => $this->options('name'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => $this->fields(),
			);
		}
		return null;
	}
	
	
	/**
	 * Registers metaboxes defined for custom post type.
	 **/
	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				'show_meta_boxes',
				$metabox['page'],
				$metabox['context'],
				$metabox['priority']
			);
		}
	}
	
	
	/**
	 * Registers the custom post type and any other ancillary actions that are
	 * required for the post to function properly.
	 **/
	public function register(){
		$registration = array(
			'labels'     => $this->labels(),
			'supports'   => $this->supports(),
			'public'     => $this->options('public'),
			'taxonomies' => $this->options('taxonomies'),
			'_builtin'   => $this->options('built_in')
		);
		
		if ($this->options('use_order')){
			$registration = array_merge($registration, array('hierarchical' => True,));
		}
		
		register_post_type($this->options('name'), $registration);
		
		if ($this->options('use_shortcode')){
			add_shortcode($this->options('name').'-list', array($this, 'shortcode'));
		}
	}
	
	
	/**
	 * Shortcode for this custom post type.  Can be overridden for descendants.
	 * Defaults to just outputting a list of objects outputted as defined by
	 * toHTML method.
	 **/
	public function shortcode($attr){
		$default = array(
			'type' => $this->options('name'),
		);
		if (is_array($attr)){
			$attr = array_merge($default, $attr);
		}else{
			$attr = $default;
		}
		return sc_object_list($attr);
	}
	
	
	/**
	 * Handles output for a list of objects, can be overridden for descendants.
	 * If you want to override how a list of objects are outputted, override
	 * this, if you just want to override how a single object is outputted, see
	 * the toHTML method.
	 **/
	public function objectsToHTML($objects, $css_classes){
		if (count($objects) < 1){ return '';}
		
		$class = get_custom_post_type($objects[0]->post_type);
		$class = new $class;
		
		ob_start();
		?>
		<ul class="<?php if($css_classes):?><?=$css_classes?><?php else:?><?=$class->options('name')?>-list<?php endif;?>">
			<?php foreach($objects as $o):?>
			<li>
				<?=$class->toHTML($o)?>
			</li>
			<?php endforeach;?>
		</ul>
		<?php
		$html = ob_get_clean();
		return $html;
	}
	
	
	/**
	 * Outputs this item in HTML.  Can be overridden for descendants.
	 **/
	public function toHTML($object){
		$html = '<a href="'.get_permalink($object->ID).'">'.$object->post_title.'</a>';
		return $html;
	}
}


class Document extends CustomPostType{
	public
		$name           = 'document',
		$plural_name    = 'Documents',
		$singular_name  = 'Document',
		$add_new_item   = 'Add New Document',
		$edit_item      = 'Edit Document',
		$new_item       = 'New Document',
		$use_title      = True,
		$use_editor     = False,
		$use_shortcode  = True,
		$use_metabox    = True;
	
	public function fields(){
		$fields   = parent::fields();
		$fields[] = array(
			'name' => __('URL'),
			'desc' => __('Associate this document with a URL.  This will take precedence over any uploaded file, so leave empty if you want to use a file instead.'),
			'id'   => $this->options('name').'_url',
			'type' => 'text',
		);
		$fields[] = array(
			'name'    => __('File'),
			'desc'    => __('Associate this document with an already existing file.'),
			'id'      => $this->options('name').'_file',
			'type'    => 'file',
		);
		return $fields;
	}
	
	
	static function get_document_application($form){
		return mimetype_to_application(self::get_mimetype($form));
	}
	
	
	static function get_mimetype($form){
		if (is_numeric($form)){
			$form = get_post($form);
		}
		
		$prefix   = post_type($form);
		$document = get_post(get_post_meta($form->ID, $prefix.'_file', True));
		
		$is_url = get_post_meta($form->ID, $prefix.'_url', True);
		
		return ($is_url) ? "text/html" : $document->post_mime_type;
	}
	
	
	static function get_title($form){
		if (is_numeric($form)){
			$form = get_post($form);
		}
		
		$prefix = post_type($form);
		
		return $form->post_title;
	}
	
	static function get_url($form){
		if (is_numeric($form)){
			$form = get_post($form);
		}
		
		$prefix = post_type($form);
		
		$x = get_post_meta($form->ID, $prefix.'_url', True);
		$y = wp_get_attachment_url(get_post_meta($form->ID, $prefix.'_file', True));
		
		if (!$x and !$y){
			return '#';
		}
		
		return ($x) ? $x : $y;
	}
	
	
	/**
	 * Handles output for a list of objects, can be overridden for descendants.
	 * If you want to override how a list of objects are outputted, override
	 * this, if you just want to override how a single object is outputted, see
	 * the toHTML method.
	 **/
	public function objectsToHTML($objects, $css_classes){
		if (count($objects) < 1){ return '';}
		
		$class_name = get_custom_post_type($objects[0]->post_type);
		$class      = new $class_name;
		
		ob_start();
		?>
		<ul class="nobullet <?php if($css_classes):?><?=$css_classes?><?php else:?><?=$class->options('name')?>-list<?php endif;?>">
			<?php foreach($objects as $o):?>
			<li class="document <?=$class_name::get_document_application($o)?>">
				<?=$class->toHTML($o)?>
			</li>
			<?php endforeach;?>
		</ul>
		<?php
		$html = ob_get_clean();
		return $html;
	}
	
	
	/**
	 * Outputs this item in HTML.  Can be overridden for descendants.
	 **/
	public function toHTML($object){
		$title = Document::get_title($object);
		$url   = Document::get_url($object);
		$html = "<a href='{$url}'>{$title}</a>";
		return $html;
	}
}


class Video extends CustomPostType{
	public 
		$name           = 'video',
		$plural_name    = 'Videos',
		$singular_name  = 'Video',
		$add_new_item   = 'Add New Video',
		$edit_item      = 'Edit Video',
		$new_item       = 'New Video',
		$public         = True,
		$use_editor     = False,
		$use_thumbnails = True,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True;
	
	public function get_player_html($video){
		return sc_video(array('video' => $video));
	}
	
	public function metabox(){
		$metabox = parent::metabox();
		
		$metabox['title']   = 'Videos on Media Page';
		$metabox['helptxt'] = 'Video icon will be resized to width 210px, height 118px.';
		return $metabox;
	}
	
	public function fields(){
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name' => 'URL',
				'desc' => 'YouTube URL pointing to video.<br>  Example: http://www.youtube.com/watch?v=IrSeMg7iPbM',
				'id'   => $prefix.'url',
				'type' => 'text',
				'std'  => ''
			),
			array(
				'name' => 'Video Description',
				'desc' => 'Short description of the video.',
				'id'   => $prefix.'description',
				'type' => 'textarea',
				'std'  => ''
			),
			array(
				'name' => 'Shortcode',
				'desc' => 'To include this video in other posts, use the following shortcode:',
				'id'   => 'video_shortcode',
				'type' => 'shortcode',
				'value' => '[video name="TITLE"]',
			),
		);
	}
}


class Publication extends CustomPostType{
	public 
		$name           = 'publication',
		$plural_name    = 'Publications',
		$singular_name  = 'Publication',
		$add_new_item   = 'Add New Publication',
		$edit_item      = 'Edit Publication',
		$new_item       = 'New Publication',
		$public         = True,
		$use_editor     = False,
		$use_thumbnails = True,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True;
	
	public function toHTML($pub){
		return sc_publication(array('pub' => $pub));
	}
	
	public function metabox(){
		$metabox = parent::metabox();
		
		$metabox['title']   = 'Publications on Media Page';
		$metabox['helptxt'] = 'Publication cover icon will be resized to width 153px, height 198px.';
		return $metabox;
	}
	
	public function fields(){
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name'  => 'Publication URL',
				'desc' => 'Example: <span style="font-family:monospace;font-weight:bold;color:#21759B;">http://publications.smca.ucf.edu/admissions/viewbook.html</span>',
				'id'   => $prefix.'url',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => 'Shortcode',
				'desc' => 'To include this publication in other posts, use the following shortcode: <input disabled="disabled" type="text" value="[publication name=]" />',
				'id'   => 'publication_shortcode',
				'type' => 'help',
				'value' => '[publication name="TITLE"]',
			),
		);
	}
}

class Page extends CustomPostType {
	public
		$name           = 'page',
		$plural_name    = 'Pages',
		$singular_name  = 'Page',
		$add_new_item   = 'Add New Page',
		$edit_item      = 'Edit Page',
		$new_item       = 'New Page',
		$public         = True,
		$use_editor     = True,
		$use_thumbnails = False,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True,
		$built_in       = True;

	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name' => 'Hide Lower Section',
				'desc' => 'This section normally contains the Flickr, News and Events widgets. The footer will not be hidden',
				'id'   => $prefix.'hide_fold',
				'type' => 'checkbox',
			),
				array(
					'name' => 'Stylesheet',
					'desc' => '',
					'id' => $prefix.'stylesheet',
					'type' => 'file',
				),
		);
	}
}

/**
 * Describes a staff member
 *
 * @author Chris Conover
 **/
class Person extends CustomPostType
{
	/*
	The following query will pre-populate the person_orderby_name
	meta field with a guess of the last name extracted from the post title.
	
	>>>BE SURE TO REPLACE wp_<number>_... WITH THE APPROPRIATE SITE ID<<<
	
	INSERT INTO wp_29_postmeta(post_id, meta_key, meta_value) 
	(	SELECT	id AS post_id, 
						'person_orderby_name' AS meta_key, 
						REVERSE(SUBSTR(REVERSE(post_title), 1, LOCATE(' ', REVERSE(post_title)))) AS meta_value
		FROM		wp_29_posts AS posts
		WHERE		post_type = 'person' AND
						(	SELECT meta_id 
							FROM wp_29_postmeta 
							WHERE post_id = posts.id AND
										meta_key = 'person_orderby_name') IS NULL)
	*/

	public
		$name           = 'person',
		$plural_name    = 'People',
		$singular_name  = 'Person',
		$add_new_item   = 'Add Person',
		$edit_item      = 'Edit Person',
		$new_item       = 'New Person',
		$public         = True,
		$use_shortcode  = True,
		$use_metabox    = True,
		$use_thumbnails = True,
		$use_order      = True,
		$taxonomies     = array('org_groups', 'category');

		public function fields(){
			$fields = array(
				array(
					'name'    => __('Title Prefix'),
					'desc'    => '',
					'id'      => $this->options('name').'_title_prefix',
					'type'    => 'text',
				),
				array(
					'name'    => __('Title Suffix'),
					'desc'    => __('Be sure to include leading comma or space if neccessary.'),
					'id'      => $this->options('name').'_title_suffix',
					'type'    => 'text',
				),
				array(
					'name'    => __('Job Title'),
					'desc'    => __(''),
					'id'      => $this->options('name').'_jobtitle',
					'type'    => 'text',
				),
				array(
					'name'    => __('Phone'),
					'desc'    => __('Separate multiple entries with commas.'),
					'id'      => $this->options('name').'_phones',
					'type'    => 'text',
				),
				array(
					'name'    => __('Email'),
					'desc'    => __(''),
					'id'      => $this->options('name').'_email',
					'type'    => 'text',
				),
				array(
					'name'    => __('Order By Name'),
					'desc'    => __('Name used for sorting. Leaving this field blank may lead to an unexpected sort order.'),
					'id'      => $this->options('name').'_orderby_name',
					'type'    => 'text',
				),
			);
			return $fields;
		}

	public function get_objects($options=array()){
		$options['order']    = 'ASC';
		$options['orderby']  = 'person_orderby_name';
		$options['meta_key'] = 'person_orderby_name';
		return parent::get_objects($options);
	}

	public static function get_name($person) {
		$prefix = get_post_meta($person->ID, 'person_title_prefix', True);
		$suffix = get_post_meta($person->ID, 'person_title_suffix', True);
		$name = $person->post_title;
		return $prefix.' '.$name.' '.$suffix;
	}

	public static function get_phones($person) {
		$phones = get_post_meta($person->ID, 'person_phones', True);
		return ($phones != '') ? explode(',', $phones) : array();
	}

	public function objectsToHTML($people, $css_classes) {
		ob_start();?>
		<div class="row">
			<div class="span12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" class="name">Name</th>
							<th scope="col" class="job_title">Title</th>
							<th scope="col" class="phones">Phone</th>
							<th scope="col" class="email">Email</th>
						</tr>
					</thead>
					<tbody>
				<?
				foreach($people as $person) { 
					$email = get_post_meta($person->ID, 'person_email', True); 
					$link = ($person->post_content == '') ? False : True; ?>
						<tr>
							<td class="name">
								<?if($link) {?><a href="<?=get_permalink($person->ID)?>"><?}?>
									<?=$this->get_name($person)?>
								<?if($link) {?></a><?}?>
							</td>
							<td class="job_title">
								<?if($link) {?><a href="<?=get_permalink($person->ID)?>"><?}?>
								<?=get_post_meta($person->ID, 'person_jobtitle', True)?>
								<?if($link) {?></a><?}?>
							</td> 
							<td class="phones"><?php if(($link) && ($this->get_phones($person))) {?><a href="<?=get_permalink($person->ID)?>">
								<?php } if($this->get_phones($person)) {?>
									<ul class="unstyled"><?php foreach($this->get_phones($person) as $phone) { ?><li><?=$phone?></li><?php } ?></ul>
								<?php } if(($link) && ($this->get_phones($person))) {?></a><?php }?></td>
							<td class="email"><?=(($email != '') ? '<a href="mailto:'.$email.'">'.$email.'</a>' : '')?></td>
						</tr>
				<? } ?>
				</tbody>
			</table> 
		</div>
	</div><?
	return ob_get_clean();
	}
} // END class 



/**
 * Describes a set of centerpiece slides
 *
 * @author Jo Greybill
 * borrowed from SmartStart theme
 **/

class Slider extends CustomPostType {
	public 
		$name           = 'slider',
		$plural_name    = 'Sliders',
		$singular_name  = 'Slider',
		$add_new_item   = 'Add New Slider',
		$edit_item      = 'Edit Slider',
		$new_item       = 'New Slider',
		$public         = True,
		$use_editor     = False,
		$use_thumbnails = False,
		$use_order      = False,
		$use_title      = True,
		$use_metabox    = True,
		$taxonomies     = '';
	
	public function fields(){
	//
	}
	
	public function metabox(){
		if ($this->options('use_metabox')){	
			$prefix = 'ss_';
			// Generate $single_slide_content_[1-5] using variable variables:
			/*
			for ($i = 1; $i < 6; $i++) {
				$suffix = '-'.$i;
				$varname = 'single_slide_content_'.$i;
				${$varname} =
					array(
						'id'       => 'slider-slide-content' . $suffix,
						'title'    => 'Slide' . $suffix,
						'page'     => 'slider',
						'context'  => 'normal',
						'priority' => 'high',
						'fields'   => array(
							array(
								'name' => 'Type of Slider Content',
								'desc' => 'Select what type of content will go in the slide.',
								'id' => $prefix . 'type_of_content' . $suffix,
								'type' => 'radio',
								'options' => array('Image' => 'image', 'Video' => 'video'),
							),
							array(
								'name' => 'Slide Image',
								'id' => $prefix . 'slide_image' . $suffix,
								'type' => 'file',
							),
							array(
								'name' => 'Slide Video',
								'desc' => 'Copy and paste your video embed code here.',
								'id' => $prefix . 'slide_video' . $suffix,
								'type' => 'textarea',
							),
							array(
								'name' => 'Button Type',
								'id' => $prefix . 'button_type' . $suffix,
								'type' => 'radio',
								'options' => array('Text' => 'text', 'Image' => 'image'),
							),
							array(
								'name' => 'Dropcap',
								'desc' => '(Optional)',
								'id' => $prefix . 'button_dropcap' . $suffix,
								'type' => 'text'
							),
							array(
								'name' => 'Title',
								'id' => $prefix . 'button_title' . $suffix,
								'type' => 'text'
							),
							array(
								'name' => 'Description',
								'desc' => '(Optional)',
								'id' => $prefix . 'button_desc' . $suffix,
								'type' => 'text'
							),
							array(
								'name' => 'Slide Content',
								'desc' => '(Optional) HTML tags and WordPress shortcodes are allowed.',
								'id' => $prefix . 'slide_content' . $suffix,
								'type' => 'textarea',
							),
							array(
								'name' => 'Slide Links To',
								'desc' => '(Optional) Link slide image to an external URL.  Opens in a new tab.',
								'id' => $prefix . 'slide_links_to' . $suffix,
								'type' => 'text',
							)
						),
					);
			}
			*/
			
			$all_slides = 
				array(
					'id'       => 'slider-slides',
					'title'    => 'All Slides',
					'page'    => 'slider',
					'context'  => 'normal',
					'priority' => 'default',
				);
			
			$single_slide_count = 	
				// Single Slide Count (and order):
				array(
					'id'       => 'slider-slides-settings-count',
					'title'    => 'Slides Count',
					'page'    => 'slider',
					'context'  => 'normal',
					'priority' => 'default',
					'fields'   => array(
						array(
							'name' => __('Total Slide Count'),
							'id'   => $prefix . 'slider_slidecount',
							'type' => 'text',
							'std'  => '0',
							'desc' => ''
						),
						array(
							'name' => __('Slide Order'),
							'id'   => $prefix . 'slider_slideorder',
							'type' => 'text',
							'std'  => '1,2,3,4,5,',
							'desc' => ''
						)
					), // fields
				);
			$basic_slide_options = 
				// Basic Slider Display Options:
				array(
					'id' => 'slider-slides-settings-basic',
					'title' => 'Basic Slider Display Options',
					'page' => 'slider',
					'context' => 'side',
					'priority' => 'default',
					'fields' => array(
						array(
							'name'    => __('Transition type for the animation'),
							'id'      => $prefix . 'slider_transition',
							'type'    => 'select',
							'std'     => 'random',
							'desc'    => '',
							'options' => array(
								'def'                 => 'def',
								'fade'                => 'fade',
								'seqFade'             => 'seqFade',
								'horizontalSlide'     => 'horizontalSlide',
								'seqHorizontalSlide'  => 'seqHorizontalSlide',
								'verticalSlide'       => 'verticalSlide',
								'seqVerticalSlide'    => 'seqVerticalSlide',
								'verticalSlideAlt'    => 'verticalSlideAlt',
								'seqVerticalSlideAlt' => 'seqVerticalSlideAlt',
								'random'              => 'random'
							)
						),	
						array(
							'name' => __('Speed of the animation transition'),
							'id'   => $prefix . 'slider_speed',
							'type' => 'text',
							'std'  => '400',
							'desc' => ''
						),
						array(
							'name' => __('Time between slide transitions'),
							'id'   => $prefix . 'slider_autoplay',
							'type' => 'text',
							'std'  => '3000',
							'desc' => __('0 to disable autoplay.')
						),
						array(
							'name' => __('Interval between each slide\'s animation'),
							'id'   => $prefix . 'slider_seq_factor',
							'type' => 'text',
							'std'  => '100',
							'desc' => __('Used for seqFade, seqHorizontalSlide, seqVerticalSlide &amp; seqVerticalSlideAlt.')
						),
						array(
							'name' => __('First slide to be displayed'),
							'id'   => $prefix . 'slider_first_slide',
							'type' => 'text',
							'std'  => '0',
							'desc' => __('Zero-based index.')
						),		
					), // fields
				);
			$advanced_slide_options = 	
				// Advanced Slider Display Options:
				array(
					'id' => 'slider-slides-settings-advanced',
					'title' => 'Advanced Slider Display Options',
					'page' => 'slider',
					'context' => 'side',
					'priority' => 'default',
					'fields' => array(
						array(
							'name'    => __('Easing type for the animation'),
							'id'      => $prefix . 'slider_easing',
							'type'    => 'select',
							'std'     => 'easeInOutExpo',
							'desc'    => '',
							'options' => array(
								'linear'           => 'linear',
								'swing'            => 'swing',
								'jswing'           => 'jswing',
								'easeInQuad'       => 'easeInQuad',
								'easeOutQuad'      => 'easeOutQuad',
								'easeInOutQuad'    => 'easeInOutQuad',
								'easeInCubic'      => 'easeInCubic',
								'easeOutCubic'     => 'easeOutCubic',
								'easeInOutCubic'   => 'easeInOutCubic',
								'easeInQuart'      => 'easeInQuart',
								'easeOutQuart'     => 'easeOutQuart',
								'easeInOutQuart'   => 'easeInOutQuart',
								'easeInQuint'      => 'easeInQuint',
								'easeOutQuint'     => 'easeOutQuint',
								'easeInOutQuint'   => 'easeInOutQuint',
								'easeInSine'       => 'easeInSine',
								'easeOutSine'      => 'easeOutSine',
								'easeInOutSine'    => 'easeInOutSine',
								'easeInExpo'       => 'easeInExpo',
								'easeOutExpo'      => 'easeOutExpo',
								'easeInOutExpo'    => 'easeInOutExpo',
								'easeInCirc'       => 'easeInCirc',
								'easeOutCirc'      => 'easeOutCirc',
								'easeInOutCirc'    => 'easeInOutCirc',
								'easeInElastic'    => 'easeInElastic',
								'easeOutElastic'   => 'easeOutElastic',
								'easeInOutElastic' => 'easeInOutElastic',
								'easeInBack'       => 'easeInBack',
								'easeOutBack'      => 'easeOutBack',
								'easeInOutBack'    => 'easeInOutBack',
								'easeInBounce'     => 'easeInBounce',
								'easeOutBounce'    => 'easeOutBounce',
								'easeInOutBounce'  => 'easeInOutBounce'
							)
						),
						array(
							'name' => __('Pause autoplay on mouseover'),
							'id'   => $prefix . 'slider_pause_on_hover',
							'type' => 'checkbox',
							'std'  => '1',
							'desc' => ''
						),
						array(
							'name' => __('Stop autoplay on click'),
							'id'   => $prefix . 'slider_stop_on_click',
							'type' => 'checkbox',
							'std'  => '0',
							'desc' => ''
						),
						array(
							'name'    => __('Content box position'),
							'id'      => $prefix . 'slider_content_position',
							'type'    => 'select',
							'std'     => 'def',
							'desc'    => '',
							'options' => array(
								''     => 'default',
								'center' => 'center',
								'bottom' => 'bottom'
							)
						),
						array(
							'name' => __('Speed of the content box transition'),
							'id'   => $prefix . 'slider_content_speed',
							'type' => 'text',
							'std'  => '450',
							'desc' => ''
						),
						array(
							'name' => __('Show content box only on mouseover'),
							'id'   => $prefix . 'slider_show_content_onhover',
							'type' => 'checkbox',
							'std'  => '1',
							'desc' => ''
						),
						array(
							'name' => __('Hide content box'),
							'id'   => $prefix . 'slider_hide_content',
							'type' => 'checkbox',
							'std'  => '0',
							'desc' => ''
						),
						array(
							'name' => __('Hide bottom navigation buttons'),
							'id'   => $prefix . 'slider_hide_bottom_buttons',
							'type' => 'checkbox',
							'std'  => '0',
							'desc' => ''
						),
						array(
							'name' => __('Slider container height'),
							'id'   => $prefix . 'slider_height',
							'type' => 'text',
							'std'  => '380',
							'desc' => ''
						),
						array(
							'name' => __('Slider container width'),
							'id'   => $prefix . 'slider_width',
							'type' => 'text',
							'std'  => '940',
							'desc' => ''
						)
					), // fields
				);
			$all_metaboxes = array(/*
				'slider-slide-content-1' => $single_slide_content_1, 
				'slider-slide-content-2' => $single_slide_content_2, 
				'slider-slide-content-3' => $single_slide_content_3, 
				'slider-slide-content-4' => $single_slide_content_4, 
				'slider-slide-content-5' => $single_slide_content_5, */
				'slider-all-slides' => $all_slides,
				'slider-slides-settings-count' => $single_slide_count, 
				'slider-slides-settings-basic' => $basic_slide_options, 
				'slider-slides-settings-advanced' => $advanced_slide_options
			);
			return $all_metaboxes;
		}
		return null;
	}	
	
	
	
	/**
	  * Show meta box fields for Slider post type (generic field loop-through)
	  * Copied from _show_meta_boxes (functions/base.php)
	 **/
	public static function display_meta_fields($post, $field) { 
	$current_value = get_post_meta($post->ID, $field['id'], true);
	?>
		<tr>
			<th><label for="<?=$field['id']?>"><?=$field['name']?></label></th>
				<td>
				<?php if($field['desc']):?>
					<div class="description">
						<?=$field['desc']?>
					</div>
				<?php endif;?>
					
				<?php switch ($field['type']): 
					case 'text':?>
					<input type="text" name="<?=$field['id']?>" id="<?=$field['id']?>" value="<?=($current_value) ? htmlentities($current_value) : $field['std']?>" />
				
				<?php break; case 'textarea':?>
					<textarea name="<?=$field['id']?>" id="<?=$field['id']?>" cols="60" rows="4"><?=($current_value) ? htmlentities($current_value) : $field['std']?></textarea>
				
				<?php break; case 'select':?>
					<select name="<?=$field['id']?>" id="<?=$field['id']?>">
						<option value=""><?=($field['default']) ? $field['default'] : '--'?></option>
					<?php foreach ($field['options'] as $k=>$v):?>
						<option <?=($current_value == $v) ? ' selected="selected"' : ''?> value="<?=$v?>"><?=$k?></option>
					<?php endforeach;?>
					</select>
					
				<?php break; case 'radio':?>
					<?php foreach ($field['options'] as $k=>$v):?>
					<label for="<?=$field['id']?>_<?=slug($k, '_')?>"><?=$k?></label>
					<input type="radio" name="<?=$field['id']?>" id="<?=$field['id']?>_<?=slug($k, '_')?>" value="<?=$v?>"<?=($current_value == $v) ? ' checked="checked"' : ''?> />
					<?php endforeach;?>
					
				<?php break; case 'checkbox':?>
					<input type="checkbox" name="<?=$field['id']?>" id="<?=$field['id']?>"<?=($current_value) ? ' checked="checked"' : ''?> />
					
				<?php break; case 'file':?>
					<?php
						$document_id = get_post_meta($post->ID, $field['id'], True);
						if ($document_id){
							$document = get_post($document_id);
							$url      = wp_get_attachment_url($document->ID);
						}else{
							$document = null;
						}
					?>
					<?php if($document):?>
					<a href="<?=$url?>"><?=$document->post_title?></a><br /><br />
					<?php endif;?>
					<input type="file" id="file_<?=$post->ID?>" name="<?=$field['id']?>"><br />
				
				<?php break; case 'help':?><!-- Do nothing for help -->
				<?php break; default:?>
					<p class="error">Don't know how to handle field of type '<?=$field['type']?>'</p>
				<?php break; endswitch;?>
				<td>
			</tr>
	<?php			
	}
	
	
	/**
	 * Show fields for single slides:
	 *
	 **/
	public static function display_slide_meta_fields($post) { 
		
		// Get any already-existing values for these fields:
		$slide_content_type 		= get_post_meta($post->ID, 'ss_type_of_content', TRUE);
		$slide_image				= get_post_meta($post->ID, 'ss_slide_image', TRUE);
		$slide_video				= get_post_meta($post->ID, 'ss_slide_video', TRUE);
		$slide_button_type			= get_post_meta($post->ID, 'ss_button_type', TRUE);
		$slide_button_dropcap		= get_post_meta($post->ID, 'ss_button_dropcap', TRUE);
		$slide_button_title			= get_post_meta($post->ID, 'ss_button_title', TRUE);
		$slide_button_desc			= get_post_meta($post->ID, 'ss_button_desc', TRUE);
		$slide_content				= get_post_meta($post->ID, 'ss_slide_content', TRUE);
		$slide_links_to				= get_post_meta($post->ID, 'ss_slide_links_to', TRUE);
		
		?>
		<div id="ss_slides_wrapper">
			<ul id="ss_slides_all">
				<?php
					
					$i = 0;
					$slides_all = array();
					for ($i = 0; $i < 50; $i++) { // Arbitrary limit of 50
						if ($slide_content_type[$i] !== NULL) {
							$slides_all[] .= $i;
						}
					}
					if ($slide_content_type[0] == ('image' || 'video')) {
						//var_dump($slides_all);
						foreach ($slides_all as $s) { 
						
						print $s;
						
					?>
						<li class="custom_repeatable"><span class="sort hndle">Drag Me!</span>
							<table class="form-table">
							<input type="hidden" name="meta_box_nonce" value="<?=wp_create_nonce('nonce-content')?>"/>
								<tr>
									<th><label for="ss_type_of_content[<?=$s?>]">Type of Content</label></th>
									<td>
										<input type="radio" name="ss_type_of_content[<?=$s?>]" id="ss_type_of_content_image[<?=$s?>]" <?php ($slide_content_type[$s] == 'image') ? print 'checked="checked"' : ''; ?> value="image" />
											<label for="ss_type_of_content_image[<?=$s?>]">Image</label>
										<input type="radio" name="ss_type_of_content[<?=$s?>]" id="ss_type_of_content_video[<?=$s?>]" <?php ($slide_content_type[$s] == 'video') ? print 'checked="checked"' : ''; ?> value="video" />
											<label for="ss_type_of_content_video[<?=$s?>]">Video</label>
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_image[<?=$s?>]">Slide Image</label></th>
									<td>
										
									
										<input type="file" id="file_<?=$post->ID?>" name="ss_slide_image[<?=$s?>]"><br />
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_video[<?=$s?>]">Slide Video</label></th>
									<td>
										<span class="description">Copy and paste your video embed code here.</span><br/>
										<textarea name="ss_slide_video[<?=$s?>]" id="ss_slide_video[<?=$s?>]" cols="60" rows="4">
										<?php ($slide_video[$s] !== '') ? print $slide_video[$s] : ''; ?>
										</textarea>
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_type[<?=$s?>]">Button Type</label></th>
									<td>
										<input type="radio" name="ss_button_type[<?=$s?>]" id="ss_button_type_image[<?=$s?>]" <?php ($slide_button_type[$s] == 'image') ? print 'checked="checked"' : ''; ?> value="image" />
											<label for="ss_button_type_image[<?=$s?>]">Image</label>
										<input type="radio" name="ss_button_type[<?=$s?>]" id="ss_button_type_text[<?=$s?>]" <?php ($slide_button_type[$s] == 'text') ? print 'checked="checked"' : ''; ?> value="text" />
											<label for="ss_button_type_text[<?=$s?>]">Text</label>
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_dropcap[<?=$s?>]">Button Dropcap</label></th>
									<td>
										<input type="text" name="ss_button_dropcap[<?=$s?>]" id="ss_button_dropcap[<?=$s?>]" value="<?php ($slide_button_dropcap[$s] !== '') ? print $slide_button_dropcap[$s] : ''; ?>" /><span class="description"> (Optional)</span><br/>
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_title[<?=$s?>]">Button Title</label></th>
									<td>
										<input type="text" name="ss_button_title[<?=$s?>]" id="ss_button_title[<?=$s?>]" value="<?php ($slide_button_title[$s] !== '') ? print $slide_button_title[$s] : ''; ?>" />
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_desc[<?=$s?>]">Button Description</label></th>
									<td>
										<input type="text" name="ss_button_desc[<?=$s?>]" id="ss_button_desc[<?=$s?>]" value="<?php ($slide_button_desc[$s] !== '') ? print $slide_button_desc[$s] : ''; ?>" /><span class="description"> (Optional)</span><br/>
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_content[<?=$s?>]">Slide Content</label></th>
									<td>
										<span class="description">(Optional) HTML tags and WordPress shortcodes are allowed.</span><br/>
										<textarea name="ss_slide_content[<?=$s?>]" id="ss_slide_content[<?=$s?>]" cols="60" rows="4">
										<?php ($slide_content[$s] !== '') ? print $slide_content[$s] : ''; ?>
										</textarea>
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_links_to[<?=$s?>]">Slide Links To</label></th>
									<td>
										<input type="text" name="ss_slide_links_to[<?=$s?>]" id="ss_slide_links_to[<?=$s?>]" value="<?php ($slide_links_to[$s] !== '') ? print $slide_links_to[$s] : ''; ?>" /><span class="description"> (Optional)</span><br/>
									</td>
								</tr>
								
							</table>
							<a class="repeatable-remove button" href="#">- Remove Slide</a>
						</li>	
						
					<?php	
						}
					} else {
						$i = 0;
						?>
						<li class="custom_repeatable"><span class="sort hndle">Drag Me!</span>
							<table class="form-table">
							<input type="hidden" name="meta_box_nonce" value="<?=wp_create_nonce('nonce-content')?>"/>
								<tr>
									<th><label for="ss_type_of_content[<?=$i?>]">Type of Content</label></th>
									<td>
										<input type="radio" name="ss_type_of_content[<?=$i?>]" id="ss_type_of_content_image[<?=$i?>]" value="image" />
											<label for="ss_type_of_content_image[<?=$i?>]">Image</label>
										<input type="radio" name="ss_type_of_content[<?=$i?>]" id="ss_type_of_content_video[<?=$i?>]" value="video" />
											<label for="ss_type_of_content_video[<?=$i?>]">Video</label>
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_image[<?=$i?>]">Slide Image</label></th>
									<td>
										<input type="file" id="file_<?=$post->ID?>" name="ss_slide_image[<?=$i?>]"><br />
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_video[<?=$i?>]">Slide Video</label></th>
									<td>
										<span class="description">Copy and paste your video embed code here.</span><br/>
										<textarea name="ss_slide_video[<?=$i?>]" id="ss_slide_video[<?=$i?>]" cols="60" rows="4"></textarea>
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_type[<?=$i?>]">Button Type</label></th>
									<td>
										<input type="radio" name="ss_button_type[<?=$i?>]" id="ss_button_type_image[<?=$i?>]" value="image" />
											<label for="ss_button_type_image[<?=$i?>]">Image</label>
										<input type="radio" name="ss_button_type[<?=$i?>]" id="ss_button_type_text[<?=$i?>]" value="text" />
											<label for="ss_button_type_text[<?=$i?>]">Text</label>
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_dropcap[<?=$i?>]">Button Dropcap</label></th>
									<td>
										<input type="text" name="ss_button_dropcap[<?=$i?>]" id="ss_button_dropcap[<?=$i?>]" value="" /><span class="description"> (Optional)</span><br/>
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_title[<?=$i?>]">Button Title</label></th>
									<td>
										<input type="text" name="ss_button_title[<?=$i?>]" id="ss_button_title[<?=$i?>]" value="" />
									</td>
								</tr>
								<tr>
									<th><label for="ss_button_desc[<?=$i?>]">Button Description</label></th>
									<td>
										<input type="text" name="ss_button_desc[<?=$i?>]" id="ss_button_desc[<?=$i?>]" value="" /><span class="description"> (Optional)</span><br/>
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_content[<?=$i?>]">Slide Content</label></th>
									<td>
										<span class="description">(Optional) HTML tags and WordPress shortcodes are allowed.</span><br/>
										<textarea name="ss_slide_content[<?=$i?>]" id="ss_slide_content[<?=$i?>]" cols="60" rows="4"></textarea>
									</td>
								</tr>
								<tr>
									<th><label for="ss_slide_links_to[<?=$i?>]">Slide Links To</label></th>
									<td>
										<input type="text" name="ss_slide_links_to[<?=$i?>]" id="ss_slide_links_to[<?=$i?>]" value="" /><span class="description"> (Optional)</span><br/>
									</td>
								</tr>
								
							</table>
							<a class="repeatable-remove button" href="#">- Remove Slide</a>
						</li>
						<?php
						
					}
				?>
						<a class="repeatable-add button" href="#">+ Add New Slide</a><br/>
						
				
			</ul>
			
		</div>
		<?php
	}
 

	/**
	 * Individual functions for showing metabox content
	 *
	 **/
	
	// Slides 1-5: 
	/*
	public function show_meta_box_slide_1_content($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		
		$meta_box = $meta_box['slider-slide-content-1'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
		
	}
	public function show_meta_box_slide_2_content($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		
		$meta_box = $meta_box['slider-slide-content-2'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
		
	}
	public function show_meta_box_slide_3_content($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		
		$meta_box = $meta_box['slider-slide-content-3'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
		
	}
	public function show_meta_box_slide_4_content($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		
		$meta_box = $meta_box['slider-slide-content-4'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
		
	}
	public function show_meta_box_slide_5_content($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		
		$meta_box = $meta_box['slider-slide-content-5'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
		
	}
	*/
	
	
	//
	public function show_meta_box_slide_all($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		$meta_box = $meta_box['slider-all-slides'];
		$this->display_slide_meta_fields($post);
	}
	
	
	// Slide Count: 
	public function show_meta_box_slide_count($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		$meta_box = $meta_box['slider-slides-settings-count'];
		// Use one nonce for Slider post:
		?>
		<table class="form-table">
		<input type="hidden" name="meta_box_nonce" value="<?=wp_create_nonce('nonce-content')?>"/>
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
	}
	
	// Basic Slider Display Options:
	public function show_meta_box_slide_basic($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		$meta_box = $meta_box['slider-slides-settings-basic'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
	}
	
	// Advanced Slider Display Options:
	public function show_meta_box_slide_advanced($post) {
		if ($this->options('use_metabox')) {
			$meta_box = $this->metabox();
		}
		$meta_box = $meta_box['slider-slides-settings-advanced'];
		?>
		<table class="form-table">
		<?php
			foreach($meta_box['fields'] as $field):
				$this->display_meta_fields($post, $field);
			endforeach;
		print "</table>";
	}
	
	
	
	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			foreach ($metabox as $key => $single_metabox) {
				switch ($key) {/*
					case 'slider-slide-content-1':
						$metabox_view_function = 'show_meta_box_slide_1_content';
						break;
					case 'slider-slide-content-2':
						$metabox_view_function = 'show_meta_box_slide_2_content';
						break;
					case 'slider-slide-content-3':
						$metabox_view_function = 'show_meta_box_slide_3_content';
						break;
					case 'slider-slide-content-4':
						$metabox_view_function = 'show_meta_box_slide_4_content';
						break;
					case 'slider-slide-content-5':
						$metabox_view_function = 'show_meta_box_slide_5_content';
						break;			*/	
						
					case 'slider-all-slides':
						$metabox_view_function = 'show_meta_box_slide_all';
						break;	
						
					case 'slider-slides-settings-count':
						$metabox_view_function = 'show_meta_box_slide_count';
						break;
					case 'slider-slides-settings-basic':
						$metabox_view_function = 'show_meta_box_slide_basic';
						break;
					case 'slider-slides-settings-advanced':
						$metabox_view_function = 'show_meta_box_slide_advanced';
						break;
					default:
						break;
				}
				add_meta_box(
					$single_metabox['id'],
					$single_metabox['title'],
					array( &$this, $metabox_view_function ),
					$single_metabox['page'],
					$single_metabox['context'],
					$single_metabox['priority']
				);
			}			
		}
	}
	
	
}




?>