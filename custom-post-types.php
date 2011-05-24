<?php
/*/ The base abstract CustomPostType covers a really simple post type,
one that does not require additional fields and metaboxes.  This means that
any object that inherits from this base class can safely ignore most of the
methods defined in it, and if it needs those additional methods it should
simply override and define it's own.

To install a new custom post type, add the class name to the array contained in 
installed_custom_post_types;
/*/


/*/----------------------------------
Custom post types
----------------------------------/*/
abstract class CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
	
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
	
	public function get_objects_as_options($options=array()){
		$objects = $this->get_objects($options);
		$opt     = array();
		foreach($objects as $o){
			switch(True){
				case $this->use_title:
					$opt[$o->post_title] = $o->ID;
					break;
				default:
					$opt[$o->ID] = $o->ID;
					break;
			}
		}
		return $opt;
	}
	
	public function options($key){
		$vars = get_object_vars($this);
		return $vars[$key];
	}
	
	public function fields(){
		return array();
	}
	
	public function supports(){
		#Default support array
		$supports = array();
		if ($this->options('use_title')){
			$supports = array_merge($supports, array('title'));
		}
		if ($this->options('use_order')){
			$supports = array_merge($supports, array('page-attributes'));
		}
		if ($this->options('use_thumbnails')){
			$supports = array_merge($supports, array('thumbnail'));
		}
		if ($this->options('use_editor')){
			$supports = array_merge($supports, array('editor'));
		}
		return $supports;
	}
	
	public function labels(){
		return array(
			'name'          => __($this->options('plural_name')),
			'singular_name' => __($this->options('singular_name')),
			'add_new_item'  => __($this->options('add_new_item')),
			'edit_item'     => __($this->options('edit_item')),
			'new_item'      => __($this->options('new_item')),
		);
	}
	
	public function metabox(){
		if ($this->options('use_metabox')){
			return array(
				'id'       => $this->options('name').'_metabox',
				'title'    => __($this->options('singular_name').' Attributes'),
				'page'     => $this->options('name'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => $this->fields(),
			);
		}
		return null;
	}
	
	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				'admissions_show_meta_boxes',
				$metabox['page'],
				$metabox['context'],
				$metabox['priority']
			);
		}
	}
	
	public function register(){
		$registration = array(
			'labels'   => $this->labels(),
			'supports' => $this->supports(),
			'public'   => $this->options('public'),
		);
		if ($this->options('use_order')){
			$regisration = array_merge($registration, array('hierarchical' => True,));
		}
		register_post_type($this->options('name'), $registration);
		if ($this->options('use_categories')){
			register_taxonomy_for_object_type('category', $this->options('name'));
		}
	}
}


class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}

class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}

class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}

class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}

class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}

class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}

class Video extends CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False,
		$use_metabox    = False;
}


/*/-------------------------------------
Register custom post types and functions for display
-------------------------------------/*/
function installed_custom_post_types(){
	$installed = array();
	
	return array_map(create_function('$class', '
		return new $class;
	'), $installed);
}


/**
 * Registers all installed custom post types
 *
 * @return void
 * @author Jared Lang
 **/
function admissions_post_types(){
	#Register custom post types
	foreach(installed_custom_post_types() as $custom_post_type){
		$custom_post_type->register();
	}
	
	#This ensures that the permalinks for custom posts work
	flush_rewrite_rules();
}
add_action('init', 'admissions_post_types');


/**
 * Registers all metaboxes for install custom post types
 *
 * @return void
 * @author Jared Lang
 **/
function admissions_meta_boxes(){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		$custom_post_type->register_metaboxes();
	}
}
add_action('do_meta_boxes', 'admissions_meta_boxes');


/**
 * Saves the data for a given post type
 *
 * @return void
 * @author Jared Lang
 **/
function admissions_save_meta_data($post){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		if (get_post_type($post) == $custom_post_type->options('name')){
			$meta_box = $custom_post_type->metabox();
			break;
		}
	}
	
	return _save_meta_data($post, $meta_box);
	
}
add_action('save_post', 'admissions_save_meta_data');


/**
 * Displays the metaboxes for a given post type
 *
 * @return void
 * @author Jared Lang
 **/
function admissions_show_meta_boxes($post){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		if (get_post_type($post) == $custom_post_type->options('name')){
			$meta_box = $custom_post_type->metabox();
			break;
		}
	}
	return _show_meta_boxes($post, $meta_box);
}

/**
 * Field type save functions.
 */
function save_file($post_id, $field){
	$file_uploaded = @!empty($_FILES[$field['id']]);
	if ($file_uploaded){
		require_once(ABSPATH.'wp-admin/includes/file.php');
		$override['action'] = 'editpost';
		$file               = $_FILES[$field['id']];
		$uploaded_file      = wp_handle_upload($file, $override);
		
		# TODO: Pass reason for error back to frontend
		if ($uploaded_file['error']){return;}
		
		$attachment = array(
			'post_title'     => $file['name'],
			'post_content'   => '',
			'post_type'      => 'attachment',
			'post_parent'    => $post_id,
			'post_mime_type' => $file['type'],
			'guid'           => $uploaded_file['url'],
		);
		$id = wp_insert_attachment($attachment, $file['file'], $post_id);
		wp_update_attachment_metadata(
			$id,
			wp_generate_attachment_metadata($id, $file['file'])
		);
		update_post_meta($post_id, $field['id'], $id);
	}
}

function save_members($post_id, $field){
	$new_members = $_POST[$field['id']];
	$members     = array();
	if (count($new_members)){
		foreach($new_members as $id){
			if(isset($_POST[$field['id'].'_'.$id.'_role'])){
				$members[$id] =  $_POST[$field['id'].'_'.$id.'_role'];
			}else{
				$members[$id] = null;
			}
		}
		update_post_meta($post_id, $field['id'], $members);
	}
}

function save_simple_members($post_id, $field){
	$new_members = $_POST[$field['id']];
	$members     = array();
	if (count($new_members)){
		foreach($new_members as $id){
			$members[] = $id;
		}
	}
	update_post_meta($post_id, $field['id'], $members);
}

function save_default($post_id, $field){
	$old = get_post_meta($post_id, $field['id'], true);
	$new = $_POST[$field['id']];
	if ($new && $new != $old) {
		update_post_meta($post_id, $field['id'], $new);
	} elseif ('' == $new && $old) {
		delete_post_meta($post_id, $field['id'], $old);
	}
}

/**
 * Handles saving a custom post as well as it's custom fields and metadata.
 *
 * @return void
 * @author Jared Lang
 **/
function _save_meta_data($post_id, $meta_box){
	// verify nonce
	if (!wp_verify_nonce($_POST['admissions_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($meta_box['fields'] as $field) {
		switch ($field['type']){
			case 'file':
				save_file($post_id, $field);
				break;
			case 'members':
				save_members($post_id, $field);
				break;
			case 'simple-members':
				save_simple_members($post_id, $field);
				break;
			default:
				save_default($post_id, $field);
				break;
		}
	}
}

/**
 * Outputs the html for the fields defined for a given post and metabox.
 *
 * @return void
 * @author Jared Lang
 **/
function _show_meta_boxes($post, $meta_box){
	// Use nonce for verification
	echo '<input type="hidden" name="admissions_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
	
		echo '<tr>',
			'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
			'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? htmlentities($meta) : $field['std'], '" size="30" style="width:97%" />', "\n", $field['desc'];
				break;
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? htmlentities($meta) : $field['std'], '</textarea>', "\n", $field['desc'];
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $k=>$option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', ' value="', $option, '">', $k, '</option>';
				}
				echo '</select>';
				break;
			case 'selector':
					$help_url = get_post_meta($post->ID, 'admissions_help_url', true);
				?>
					<label for="<?=$field['id']?>"><?=$field['desc']?></label><br />
					<select class="filler" name="<?=$field['id']?>" id="<?=$field['id']?>">
						<option>Choose form...</option>
						<?php foreach($field['options'] as $k=>$v):?>
						<?php
						 	$this_url  = get_post_meta($v, 'admissions_form_url', true);
							$this_file = get_post_meta($v, 'admissions_form_file', true);
							if ($this_file){
								$this_url = wp_get_attachment_url(get_post($this_file)->ID);
							}
						?>
						<option value="<?=$this_url?>"><?=$k?></option>
						<?php endforeach;?>
					</select>
				<?php
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
			case 'file':
				$document_id = get_post_meta($post->ID, $field['id'], True);
				if ($document_id){
					$document = get_post($document_id);
					$url      = wp_get_attachment_url($document->ID);
				}else{
					$document = null;
				}
				?>
				<label for="file_<?=$post->ID?>"><?=$field['desc'];?></label><br />
				<?php if($document):?>
				Current file:
				<a href="<?=$url?>"><?=$document->post_title?></a><br /><br />
				<?php endif;?>
				<input type="file" id="file_<?=$post->ID?>" name="<?=$field['id']?>"><br />
				<?php break;
		}
		echo     '<td>',
		'</tr>';
	}
	
	echo '</table>';
	
	if($meta_box['helptxt']) echo '<p style="font-size:13px; padding:5px 0; color:#666;">' . $meta_box['helptxt'] . "</p>";
}
?>