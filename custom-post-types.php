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
		$built_in       = False,

		# Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null;


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
		$use_editor     = True,
		$use_thumbnails = True,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True;

	public function get_player_html($video){
		return sc_video(array('video' => $video));
	}

	public function metabox(){
		$metabox = parent::metabox();

		$metabox['title']   = 'Video Information';
		$metabox['helptxt'] = '<strong>Note:</strong> this post type is designed to handle YouTube videos specifically. To embed videos from other services like Vimeo or Flickr, use their provided embed code within post/widget content instead of the [video] shortcode.';
		return $metabox;
	}

	public function fields(){
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name' => 'URL',
				'desc' => 'YouTube URL pointing to video.<br>Accepts "long links" (http://youtube.com/watch?v=...) or "short links" (http://youtu.be/...).<br>  Example: http://www.youtube.com/watch?v=IrSeMg7iPbM',
				'id'   => $prefix.'url',
				'type' => 'text',
				'std'  => ''
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
		$use_editor     = True,
		$use_thumbnails = True,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True;

	public function toHTML($pub){
		return sc_publication(array('pub' => $pub));
	}

	public function fields(){
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name'  => 'Publication URL',
				'desc' => 'Example: <span style="font-family:monospace;font-weight:bold;color:#21759B;">http://publications.ucf.edu/publications/admissions-viewbook/</span>',
				'id'   => $prefix.'url',
				'type' => 'text',
				'std'  => '',
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

	public static function get_subheaders() {
		$args = array (
			'numberposts' 	=> 20, // Arbitrary limit to prevent huge dropdowns
			'post_type'		=> 'subheader',
			'post_status'	=> 'publish'
		);
		$subheaders = get_posts($args);

		$subheader_array = array();
		foreach ($subheaders as $subheader) {
			$subheader_array[$subheader->post_title] = $subheader->ID;
		}
		return $subheader_array;
	}

	public static function get_menus() {
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		$menu_array = array();
		foreach ($menus as $menu) {
			$menu_array[$menu->name] = $menu->term_id;
		}
		return $menu_array;
	}

	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
				array(
					'name' => 'Stylesheet',
					'desc' => '',
					'id' => $prefix.'stylesheet',
					'type' => 'file',
				),
				array(
					'name' => 'JavaScript File',
					'desc' => '',
					'id' => $prefix.'javascript',
					'type' => 'file',
				),
				array(
					'name' => 'Use Webfonts On This Page',
					'desc' => '(Optional) Check this box to include webfonts from Cloud.Typography.  Requires a Cloud.Typography CSS key to be set in Theme Options.',
					'id' => $prefix.'use_webfonts',
					'type' => 'checkbox',
					'std' => 'off',
				),
				array(
					'name' => 'Subheader',
					'desc' => '(Optional) Display a Subheader above the page\'s content.',
					'id' => $prefix.'subheader',
					'type' => 'select',
					'options' => $this->get_subheaders(),
				),
				array(
					'name' => '<strong>Left Sidebar:</strong> More Information Widget',
					'desc' => '(Optional) Display a More Information widget in the <strong>left-hand sidebar</strong> that contains a given menu. Useful for adding links that are directly related to the page\'s content. Menus can be created in the <a href="'.get_admin_url().'nav-menus.php">menu editor</a>.',
					'id' => $prefix.'widget_l_moreinfo',
					'type' => 'select',
					'options' => $this->get_menus(),
				),
				array(
					'name' => '<strong>Left Sidebar:</strong> More Information Widget Title',
					'desc' => '(Optional) Title for the More Information widget designated above.  Default is "More Information".',
					'id' => $prefix.'widget_l_moreinfo_title',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Left Sidebar:</strong> Secondary Information Widget',
					'desc' => '(Optional) Display a Secondary Information widget in the <strong>left-hand sidebar</strong> that contains a given menu. Useful for adding extra relevant links, student-related services, etc. Menus can be created in the <a href="'.get_admin_url().'nav-menus.php">menu editor</a>.',
					'id' => $prefix.'widget_l_secinfo',
					'type' => 'select',
					'options' => $this->get_menus(),
				),
				array(
					'name' => '<strong>Left Sidebar:</strong> Secondary Information Widget Title',
					'desc' => '(Optional) Title for the Secondary Information widget designated above.  Default is "Useful Links".',
					'id' => $prefix.'widget_l_secinfo_title',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Left Sidebar:</strong> Show list of Colleges',
					'desc' => '(Optional) Check this box to display the UCF Colleges menu in the <strong>left-hand sidebar.</strong>',
					'id' => $prefix.'widget_l_showcolleges',
					'type' => 'checkbox',
					'std' => 'on',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Show UCF Today Stories',
					'desc' => '(Optional) Check this box to display the UCF Today feed in the <strong>right-hand sidebar.</strong>',
					'id' => $prefix.'widget_r_showtoday',
					'type' => 'checkbox',
					'std' => 'on',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> UCF Today Widget Title',
					'desc' => '(Optional) Designate the title of the UCF Today news feed for the widget; e.g. "College and Campus News". Default is just "UCF Today"',
					'id' => $prefix.'widget_r_today_title',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> UCF Today Feed Path',
					'desc' => '(Optional) Designate the specific UCF Today feed to use for the UCF Today widget; e.g. "http://today.ucf.edu/tag/alumni/feed/"',
					'id' => $prefix.'widget_r_today_feed',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Show Connect with UCF Facebook Link',
					'desc' => '(Optional) Check this box to display the UCF on Facebook information in the <strong>right-hand sidebar.</strong>',
					'id' => $prefix.'widget_r_showfacebook',
					'type' => 'checkbox',
					'std' => 'on',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Embed Widget 1 Title',
					'desc' => '(Optional) Title for the embed widget below. Can be left blank.',
					'id' => $prefix.'widget_r_embed1_title',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Embed Widget 1',
					'desc' => '(Optional) Add a custom widget in the <strong>right-hand sidebar</strong>; useful for video and publication embeds.',
					'id' => $prefix.'widget_r_embed1',
					'type' => 'textarea',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Embed Widget 2 Title',
					'desc' => '(Optional) Title for the embed widget below. Can be left blank.',
					'id' => $prefix.'widget_r_embed2_title',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Embed Widget 2',
					'desc' => '(Optional) Add a custom widget in the <strong>right-hand sidebar</strong>; useful for video and publication embeds.',
					'id' => $prefix.'widget_r_embed2',
					'type' => 'textarea',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Embed Widget 3 Title',
					'desc' => '(Optional) Title for the embed widget below. Can be left blank.',
					'id' => $prefix.'widget_r_embed3_title',
					'type' => 'text',
				),
				array(
					'name' => '<strong>Right Sidebar:</strong> Embed Widget 3',
					'desc' => '(Optional) Add a custom widget in the <strong>right-hand sidebar</strong>; useful for video and publication embeds.',
					'id' => $prefix.'widget_r_embed3',
					'type' => 'textarea',
				),
				array(
					'name' => '<strong>Media Template:</strong> Header Background Image',
					'desc' => '(Required) Image to use at the top of pages using the media template.  Used when no header videos are specified, or as a fallback for browsers that don\'t support video playback.',
					'id' => $prefix.'media_img',
					'type' => 'file',
				),
				array(
					'name' => '<strong>Media Template:</strong> Header Video - MP4',
					'desc' => 'Video to use at the top of pages using the media template.',
					'id' => $prefix.'media_mp4',
					'type' => 'file',
				),
				array(
					'name' => '<strong>Media Template:</strong> Header Video - WebM',
					'desc' => 'Video to use at the top of pages using the media template.',
					'id' => $prefix.'media_webm',
					'type' => 'file',
				),
				array(
					'name' => '<strong>Media Template:</strong> Header Video - OGG',
					'desc' => 'Video to use at the top of pages using the media template.',
					'id' => $prefix.'media_ogg',
					'type' => 'file',
				),
				array(
					'name' => '<strong>Media Template:</strong> Loop Video',
					'desc' => 'Determines if the video should loop.',
					'id'   => $prefix.'loop_video',
					'type' => 'checkbox',
					'std'  => 'off'
				),
				array(
					'name' => '<strong>Media Template:</strong> Header Contents',
					'desc' => '(Optional) Content displayed over the header section on pages using the media template.  Accepts HTML and shortcode content.',
					'id' => $prefix.'media_header_content',
					'type' => 'textarea',
				),
		);
	}

	public function metabox(){
		$metabox = parent::metabox();
		$metabox['helptxt'] = 'Note: Widgets designated above will only appear depending on the page template that is set. Setting a two-column layout will not show any right-hand sidebar options set above; setting a one-column layout will display no widgets.';
		return $metabox;
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
			<div class="col-md-12 col-sm-12">
				<div class="table-responsive">
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
										<ul class="list-unstyled"><?php foreach($this->get_phones($person) as $phone) { ?><li><?=$phone?></li><?php } ?></ul>
									<?php } if(($link) && ($this->get_phones($person))) {?></a><?php }?></td>
								<td class="email"><?=(($email != '') ? '<a href="mailto:'.$email.'">'.$email.'</a>' : '')?></td>
							</tr>
					<? } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div><?
	return ob_get_clean();
	}
} // END class



/**
 * Describes a spotlight feature
 *
 * @author Jo Greybill
 **/

class Spotlight extends CustomPostType {
	public
		$name           = 'spotlight',
		$plural_name    = 'Spotlights',
		$singular_name  = 'Spotlight',
		$add_new_item   = 'Add New Spotlight',
		$edit_item      = 'Edit Spotlight',
		$new_item       = 'New Spotlight',
		$public         = True,
		$use_editor     = True,
		$use_thumbnails = True,
		$use_title      = True,
		$use_metabox    = True,
		$use_shortcode	= True;

	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name' => 'Spotlight Position',
				'desc' => 'Specify whether the spotlight should be positioned in the top slot of the spotlights section or the bottom.',
				'id'   => $prefix.'position',
				'type' => 'radio',
				'options' => array('Top' => 'top', 'Bottom' => 'bottom'),
			),
		);
	}

	public function objectsToHTML($objects, $css_classes) {
		ob_start();?>
		<ul class="spotlight-list">
			<?php
			rsort($objects);
			foreach ($objects as $spotlight) { ?>
				<li><a href="<?=get_permalink($spotlight->ID)?>"><?=$spotlight->post_title?></a></li>
			<?php
			}
			?>
		</ul>
	<?php
	}

}

class Post extends CustomPostType {
	public
		$name           = 'post',
		$plural_name    = 'Posts',
		$singular_name  = 'Post',
		$add_new_item   = 'Add New Post',
		$edit_item      = 'Edit Post',
		$new_item       = 'New Post',
		$public         = True,
		$use_editor     = True,
		$use_thumbnails = False,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = False,
		$taxonomies     = array('post_tag', 'category'),
		$built_in       = True;
}

/**
 * Describes a sub header piece for secondary pages.
 *
 * @author Jo Greybill
 **/

class Subheader extends CustomPostType {
	public
		$name           = 'subheader',
		$plural_name    = 'Subheaders',
		$singular_name  = 'Subheader',
		$add_new_item   = 'Add New Subheader',
		$edit_item      = 'Edit Subheader',
		$new_item       = 'New Subheader',
		$public         = True,
		$use_editor     = True,
		$use_thumbnails = False,
		$use_title      = True,
		$use_metabox    = True,
		$use_shortcode	= False,
		$taxonomies		= array('');

	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
			array(
					'name' => 'Student Name/Major',
					'desc' => 'Name and discipline of the quoted student; e.g. "John Doe, Political Science".',
					'id' => $prefix.'student_name',
					'type' => 'text',
			),
			array(
					'name' => 'Sub Image',
					'desc' => 'Image to be displayed on the left-hand side of the subheader.  Image should ideally be square.',
					'id' => $prefix.'sub_image',
					'type' => 'file',
			),
			array(
					'name' => 'Student Image',
					'desc' => 'Image to be displayed on the right-hand side of the subheader.  Image should be a full body shot of the student.',
					'id' => $prefix.'student_image',
					'type' => 'file',
			),
		);
	}
}



/**
 * Describes a A-Z Index link.
 *
 * @author Jo Greybill
 **/

class AZIndexLink extends CustomPostType {
	public
		$name           = 'azindexlink',
		$plural_name    = 'A-Z Index Links',
		$singular_name  = 'A-Z Index Link',
		$add_new_item   = 'Add New A-Z Index Link',
		$edit_item      = 'Edit A-Z Index Link',
		$new_item       = 'New A-Z Index Link',
		$public         = True,
		$use_editor     = False,
		$use_thumbnails = False,
		$use_title      = True,
		$use_metabox    = True,
		$use_shortcode	= False,
		$taxonomies		= array('category', 'post_tag');
	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
			array(
					'name' => 'URL',
					'id' => $prefix.'url',
					'type' => 'text',
			),
			array(
				'name' => 'Web Administrators',
				'desc' => 'Add web administrator information here.  Accepts HTML content.',
				'id' => $prefix.'webadmins',
				'type' => 'textarea',
			),
		);
	}

	public function toHTML($object){
		$html = '<a href="'.get_post_meta($object->ID, 'azindexlink_url', TRUE).'">'.$object->post_title.'</a>';
		return $html;
	}

}


/**
 * Describes an announcement.
 *
 * @author Jo Greybill
 **/
class Announcement extends CustomPostType{
	public
		$name           = 'announcement',
		$plural_name    = 'Announcements',
		$singular_name  = 'Announcement',
		$add_new_item   = 'Add New Announcement',
		$edit_item      = 'Edit Announcement',
		$new_item       = 'New Announcement',
		$public         = True,
		$use_editor     = True,
		$use_thumbnails = False,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True,
		$taxonomies		= array('audienceroles', 'keywords');

	public function fields(){
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name'  => 'Start Date',
				'desc' => 'Date that the announcement should become active. Use format yyyy-mm-dd.<br /><strong>Note that announcements with no start date or end date will not appear in any announcement feeds.</strong>',
				'id'   => $prefix.'start_date',
				'type' => 'text',
			),
			array(
				'name'  => 'End Date',
				'desc' => 'Date that the announcement should become inactive. Use format yyyy-mm-dd.<br /><strong>Note that announcements with no start date or end date will not appear in any announcement feeds.</strong>',
				'id'   => $prefix.'end_date',
				'type' => 'text',
			),
			array(
				'name'  => 'URL',
				'desc' => 'Link to a relevant website pertaining to the announcement or the posting organization.',
				'id'   => $prefix.'url',
				'type' => 'text',
			),
			array(
				'name'  => 'Contact Person',
				'id'   => $prefix.'contact',
				'type' => 'text',
			),
			array(
				'name'  => 'Phone',
				'id'   => $prefix.'phone',
				'type' => 'text',
			),
			array(
				'name'  => 'E-mail',
				'id'   => $prefix.'email',
				'type' => 'text',
			),
			array(
				'name'  => 'Posted By',
				'desc' => 'Name of the person/organization posting the announcement.',
				'id'   => $prefix.'posted_by',
				'type' => 'text',
			),
		);
	}
}


/**
 * Describes a set of centerpiece slides
 *
 * @author Jo Greybill
 * pieces borrowed from SmartStart theme
 **/

class Slider extends CustomPostType {
	public
		$name           = 'centerpiece',
		$plural_name    = 'Centerpieces',
		$singular_name  = 'Centerpiece',
		$add_new_item   = 'Add New Centerpiece',
		$edit_item      = 'Edit Centerpiece',
		$new_item       = 'New Centerpiece',
		$public         = True,
		$use_editor     = False,
		$use_thumbnails = False,
		$use_order      = False,
		$use_title      = True,
		$use_metabox    = True,
		$use_revisions	= False,
		$taxonomies     = array('');

	public function fields(){
		// define fields in metabox() method instead
		return;
	}

	public function metabox(){
		if ($this->options('use_metabox')){
			$prefix = 'ss_';

			$all_slides =
				// Container for individual slides:
				array(
					'id'       => 'slider-slides',
					'title'    => 'All Slides',
					'page'    => 'centerpiece',
					'context'  => 'normal',
					'priority' => 'default',
					'fields' => array(
						array(
							'name' => __('Slide Title'),
							'id'   => $prefix . 'slide_title',
							'type' => 'text',
							'desc' => '',
						),
						array(
							'name' => __('Type of Content'),
							'id'   => $prefix . 'type_of_content',
							'type' => 'radio',
							'desc' => '',
							'choices' => array(
								'Image' => 'image',
								'Video' => 'video'
							),
						),
						array(
							'name' => __('Slide Image'),
							'id' => $prefix . 'slide_image',
							'desc' => 'Recommended image size is 940x338px. Larger images may be cropped.',
							'type' => 'file'
						),
						array(
							'name' => __('Slide Video'),
							'id'   => $prefix . 'slide_video',
							'type' => 'textarea',
							'desc' => 'Copy and paste your video embed code here. [video] shortcodes are also allowed, but require the parameter display="embed" in order to not use a modal window; e.g. [video name="My Video" display="embed"]',
						),
						array(
							'name' => __('Slide Video Thumbnail'),
							'id' => $prefix . 'slide_video_thumb',
							'desc' => 'If you\'re using a video embed, add a "click to play" thumbnail here. Recommended image size is 940x338px. Larger images may be cropped.',
							'type' => 'file'
						),
						array(
							'name' => __('Slide Content'),
							'id'   => $prefix . 'slide_content',
							'type' => 'textarea',
							'desc' => '(Optional) HTML tags and WordPress shortcodes are allowed.',
						),
						array(
							'name' => __('Slide Links To'),
							'id'   => $prefix . 'slide_links_to',
							'type' => 'text',
							'desc' => '(Optional)',
						),
						array(
							'name' => __('Open Link in a New Window'),
							'id'   => $prefix . 'slide_link_newtab',
							'type' => 'checkbox',
							'desc' => 'Check this box if you want the slide link to open in a new window or tab. To open the link within the same window, leave this unchecked.',
						),
						array(
							'name' => __('Slide Duration'),
							'id'   => $prefix . 'slide_duration',
							'type' => 'text',
							'desc' => '(Optional) Specify how long, in seconds, the slide should appear before transitioning. Default is 6 seconds.',
						),
					)
				);
			$single_slide_count =
				// Single Slide Count (and order):
				array(
					'id'       => 'slider-slides-settings-count',
					'title'    => 'Slides Count',
					'page'    => 'centerpiece',
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
							'desc' => ''
						)
					), // fields
				);
			$basic_slide_options =
				// Basic Slider Display Options:
				array(
					'id' => 'slider-slides-settings-basic',
					'title' => 'Centerpiece Display Options',
					'page' => 'centerpiece',
					'context' => 'side',
					'priority' => 'default',
					'fields' => array(
						array(
							'name' => __('Apply Rounded Corners'),
							'id'   => $prefix . 'slider_rounded_corners',
							'type' => 'checkbox',
							'std'  => 'on',
							'desc' => ''
						),
					), // fields
				);
			$all_metaboxes = array(
				'slider-all-slides' => $all_slides,
				'slider-slides-settings-count' => $single_slide_count,
				'slider-slides-settings-basic' => $basic_slide_options
			);
			return $all_metaboxes;
		}
		return null;
	}


	/**
	 * Display fields for single slides:
	 **/
	public function display_slide_meta_fields( $post, $s ) {
		$all_fields = $this->metabox();
		$fields = $all_fields['slider-all-slides']['fields'];

		ob_start();
	?>

	<li class="custom_repeatable postbox" id="custom_repeatable_ss_<?php echo $s; ?>">
		<h3 class="meta-handle ui-sortable-handle">
			<span>Slide</span>
			<span class="toggle-indicator"></span>
		</h3>

		<table class="form-table">
			<input type="hidden" name="meta_box_nonce" value="<?php echo wp_create_nonce('nonce-content'); ?>">
			<?php
			foreach ( $fields as $field ) {
				// Massage serialized data: Add post_id for 'file' fields
				if ( $field['type'] == 'file' ) {
					$field['post_id'] = $post->ID;
				}

				// Massage serialized data: Update 'value' to reference value at index
				$meta = get_post_meta( $post->ID, $field['id'], true );
				$field['value'] = $meta[$s];

				// Massage serialized data: Update 'id' to reference data by index
				$field['id'] = $field['id'] . '['. $s .']';

				// Finally, display the field
				display_meta_box_field( $post->ID, $field );
			}
			?>

		</table>
		<a class="repeatable-remove button" href="#">Remove Slide</a>
	</li>

	<?php
		return ob_get_clean();
	}


	/**
	 * Display all slides:
	**/
	public function display_slides( $post ) {
		$slide_order = get_post_meta( $post->ID, 'ss_slider_slideorder', TRUE );
		$slide_array = array();

		ob_start();
	?>
		<div id="ss_slides_wrapper">
			<ul id="ss_slides_all">
				<?php
				// Loop through slides_array for existing slides. Else, display
				// a single empty slide 'widget'.
				if ( $slide_order ) {
					$slide_array = explode( ',', $slide_order );
					foreach ( $slide_array as $key => $s ) {
						if ( $s !== '' ) {
							echo $this->display_slide_meta_fields( $post, $s );
						}
					}
				} else {
					$i = 0;
					echo $this->display_slide_meta_fields( $post, $i );
				}

				// Create a cloning template
				echo $this->display_slide_meta_fields( $post, 99999 );
				?>
				<a class="repeatable-add button-primary" href="#">Add New Slide</a><br>
			</ul>
		</div>
	<?php
		return ob_get_clean();
	}

	// Individual slide container:
	public function show_meta_box_slide_all( $post ) {
		echo $this->display_slides( $post );
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
		<input type="hidden" name="meta_box_nonce" value="<?php echo wp_create_nonce('nonce-content'); ?>">
		<?php
			foreach( $meta_box['fields'] as $field ) {
				display_meta_box_field( $post->ID, $field );
			}
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
			foreach( $meta_box['fields'] as $field ) {
				display_meta_box_field( $post->ID, $field );
			}
		print "</table>";
	}


	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			foreach ($metabox as $key => $single_metabox) {
				switch ($key) {
					case 'slider-all-slides':
						$metabox_view_function = 'show_meta_box_slide_all';
						break;
					case 'slider-slides-settings-count':
						$metabox_view_function = 'show_meta_box_slide_count';
						break;
					case 'slider-slides-settings-basic':
						$metabox_view_function = 'show_meta_box_slide_basic';
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


/**
 * Describes an undergraduate/graduate program.
 *
 * @author Jo Dickson
 **/
class Degree extends CustomPostType{
	public
		$name           = 'degree',
		$plural_name    = 'Degree Programs',
		$singular_name  = 'Degree Program',
		$add_new_item   = 'Add New Degree Program',
		$edit_item      = 'Edit Degree Program',
		$new_item       = 'New Degree Program',
		$public         = True,
		$use_editor     = True,
		$use_thumbnails = False,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True,
		$use_shortcode  = True,
		$taxonomies     = array( 'program_types', 'colleges', 'departments', 'degree_keywords' );

	public function fields(){
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name'  => 'Required Hours',
				'id'   => $prefix.'hours',
				'type' => 'text',
			),
			array(
				'name'  => 'Description',
				'desc' => 'Description provided for the degree.  This value should not be modified as it can be overridden upon degree import from the
							search service.  Modify the post content instead to add additional degree information.',
				'id'   => $prefix.'description',
				'type' => 'textarea',
			),
			array(
				'name'  => 'Website',
				'id'   => $prefix.'website',
				'type' => 'text',
			),
			array(
				'name'  => 'Catalog PDF',
				'id'   => $prefix.'pdf',
				'type' => 'text',
			),
			array(
				'name'  => 'Profile URL',
				'id'   => $prefix.'profile_url',
				'type' => 'text',
			),
			array(
				'name'  => 'Phone Number',
				'id'   => $prefix.'phone',
				'type' => 'text',
			),
			array(
				'name'  => 'Email',
				'id'   => $prefix.'email',
				'type' => 'text',
			),
			array(
				'name'  => 'Contacts',
				'desc' => 'Individual contacts are stored delimited by "@@;@@". Individual fields for each contact are delimited by "@@,@@".',
				'id'   => $prefix.'contacts',
				'type' => 'textarea',
			),
			array(
				'name'  => 'Hide Tuition Information',
				'desc' => 'If checked tuition information will be hidden for this degree',
				'id'   => $prefix.'hide_tuition',
				'type' => 'checkbox'
			),
			array(
				'name'  => 'Degree ID',
				'desc' => 'degree_id in database. Do not modify this value.',
				'id'   => $prefix.'id',
				'type' => 'text',
			),
			array(
				'name'  => 'Degree Type ID',
				'desc' => 'type_id in database. Do not modify this value.',
				'id'   => $prefix.'type_id',
				'type' => 'text',
			),
			array(
				'name'  => 'Is Graduate Program',
				'desc' => 'graduate value in database. Do not modify this value.',
				'id'   => $prefix.'is_graduate',
				'type' => 'text',
			),
			array(
				'name'  => 'Use Updated Template',
				"desc"  => 'If checked, will used an updated template with an image header.',
				'id'    => $prefix.'use_updated_template',
				'type'  => 'checkbox'
			),
			array(
				'name'  => 'Header Image',
				'desc'  => 'Sets the header image of the degree (only if "Use Updated Template" is checked)',
				'id'    => $prefix.'header_image',
				'type'  => 'file'
			)
		);
	}

	public static function is_graduate_program($degree) {
		$is_graduate = get_post_meta( $degree->ID, 'degree_is_graduate', true );
		if ( $is_graduate && intval( $is_graduate ) === 1 ) {
			return true;
		}
		return false;
	}

	/**
	 * Returns a degree's contacts and their phone/email info
	 * in an array of arrays.
	 **/
	public static function get_degree_contacts( $degree ) {
		$contact_info = get_post_meta( $degree->ID, 'degree_contacts', true );
		$contact_array = array();

		// Split single contacts
		$contacts = explode( '@@;@@', $contact_info );
		foreach ( $contacts as $key=>$contact ) {
			if ( $contact ) {
				// Split individual fields
				$contact = explode( '@@,@@', $contact );

				$newcontact = array();

				foreach ( $contact as $fieldset ) {
					// Split out field key/values
					$fields = explode( '@@:@@', $fieldset );
					// Only get fields we need. Don't include fields that can result in
					// duplicate contacts after sorting uniques (e.g. contact_id).
					if ( $fields[0] == 'contact_name' || $fields[0] == 'contact_phone' || $fields[0] == 'contact_email' ) {
						$newcontact[$fields[0]] = str_replace( '@@,@', '', $fields[1] );
					}
				}

				// Only add the contact to the list if there are at least 2 pieces of info available
				// e.g. don't add just a person's name to the list
				if ( count( $newcontact ) > 1 ) {
					array_push( $contact_array, $newcontact );
				}
			}
		}

		return array_map( 'array_filter', array_unique( $contact_array, SORT_REGULAR ) );
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
			'_builtin'   => $this->options('built_in'),
			'rewrite' => array(
				'slug' => 'academics'
			),
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
	 * Handles output for a list of objects, can be overridden for descendants.
	 * If you want to override how a list of objects are outputted, override
	 * this, if you just want to override how a single object is outputted, see
	 * the toHTML method.
	 **/
	public function objectsToHTML($degrees, $css_classes){
		if (count($degrees) < 1){ return '';}

		// Group the degrees by program type (undergraduate/minor/graduate/cert).
		$degrees = sort_grouped_degree_programs(group_posts_by_tax_terms('program_types', $degrees));
		ob_start();
		foreach ($degrees as $group=>$posts) {
			$term = get_term($group, 'program_types')->name.'s';
			$term_slug = get_term($group, 'program_types')->slug.'s';
		?>
		<h3 class="degree-list-heading" id="<?=$term_slug?>"><?=$term?></h3>
		<?php if ($posts) { ?>
		<ul class="degree-list">
			<?php foreach ( $posts as $post ): ?>
			<li class="program">
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<?php echo $post->post_title; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php } ?>
		<hr />
		<?php
		}
		$html = ob_get_clean();
		return $html;
	}
}
?>
