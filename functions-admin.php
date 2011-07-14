<?php

define('THEME_OPTION_GROUP', 'settings');
define('THEME_OPTION_NAME', 'theme');
define('THEME_OPTION_PAGE_TITLE', 'Theme Options');

add_action('admin_menu', 'create_theme_options_page');
add_action('admin_init', 'init_theme_options');

function login_scripts(){
	ob_start();?>
	<link rel="stylesheet" href="<?=THEME_CSS_URL?>/admin.css" type="text/css" media="screen" charset="utf-8" />
	<?php 
	$out = ob_get_clean();
	print $out;
}


function init_theme_options(){
	register_setting(THEME_OPTION_GROUP, THEME_OPTION_NAME, 'theme_options_sanitize');
}


function create_theme_options_page() {
	add_utility_page(
		__(THEME_OPTION_PAGE_TITLE),
		__(THEME_OPTION_PAGE_TITLE),
		'edit_theme_options',
		'theme-options',
		'theme_options_page',
		THEME_IMG_URL.'/pegasus.png'
	);
}


function theme_options_page(){
	$theme_options    = get_option(THEME_OPTION_NAME);
	$checkbox_choices = $radio_choices = $select_choices = array(
		'(None)'   => '',
		'Choice 1' => 1,
		'Choice 2' => 2,
		'Choice 3' => 3,
	);
	$settings = array(
		new TextField('Google Analytics Account', THEME_OPTION_NAME.'[analytics]', 'Google Analytics Account. E.g., <em>UA-9876543-21</em>. Leave blank for development.', null, $theme_options['analytics']),
		new TextField('Text Test', THEME_OPTION_NAME.'[text]', 'Text input test field.', null, $theme_options['text']),
		new TextareaField('Textarea Test', THEME_OPTION_NAME.'[textarea]', null, null, $theme_options['textarea']),
		new SelectField('Select Test', THEME_OPTION_NAME.'[select]', $select_choices, 'Select description area.', null, $theme_options['select']),
		new RadioField('Radio Test', THEME_OPTION_NAME.'[radio]', $radio_choices, null, null, $theme_options['radio']),
		new CheckboxField('Checkbox Test', THEME_OPTION_NAME.'[checkbox]', $checkbox_choices, null, null, $theme_options['checkbox']),
	);
	
	# Check for settings updated or updated, varies between wp versions
	$updated = (bool)($_GET['settings-updated'] or $_GET['updated']);
	?>
	
	<form method="post" action="options.php">
		<div class="wrap">
			<h2><?=__(THEME_OPTION_PAGE_TITLE)?></h2>
			
			<?php if ($updated):?>
			<div class="updated fade"><p><strong><?=__( 'Options saved' ); ?></strong></p></div>
			<?php endif; ?>
			
			<?php settings_fields(THEME_OPTION_GROUP);?>
			<table class="form-table">
				<?php foreach($settings as $setting):?>
				<tr valign="top">
					<th scope="row"><label for="<?=htmlentities($setting->id)?>"><?=$setting->name?></label></th>
					<td class="field"><?=$setting->html()?></td>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" value="<?= __('Save Options')?>" />
			</div>
		</div>
	</form>
	
	<?php
}

function theme_options_sanitize($input){
	return $input;
}


abstract class Field{
	function __construct($name, $id, $description=null, $default=null, $value=null){
		$this->name        = $name;
		$this->id          = $id;
		$this->value       = $value;
		$this->description = $description;
		$this->default     = $default;
		if ($this->value === null){
			$this->value = $this->default;
		}
	}
}


abstract class ChoicesField extends Field{
	function __construct($name, $id, $choices, $description=null, $default=null, $value=null){
		$this->choices = $choices;
		parent::__construct($name, $id, $description, $default, $value);
	}
}

class TextField extends Field{
	function html(){
		ob_start();
		?>
		<label class="block" for="<?=htmlentities($this->id)?>"><?=__($this->name)?></label>
		<input type="text" id="<?=htmlentities($this->id)?>" name="<?=htmlentities($this->id)?>" value="<?=htmlentities($this->value)?>" />
		<?php if($this->description):?>
		<p class="description"><?=__($this->description)?></p>
		<?php endif;?>
		<?php
		return ob_get_clean();
	}
}

class TextareaField extends Field{
	function html(){
		ob_start();
		?>
		<label class="block" for="<?=htmlentities($this->id)?>"><?=__($this->name)?></label>
		<textarea id="<?=htmlentities($this->id)?>" name="<?=htmlentities($this->id)?>"><?=htmlentities($this->value)?></textarea>
		<?php if($this->description):?>
		<p class="description"><?=__($this->description)?></p>
		<?php endif;?>
		<?php
		return ob_get_clean();
	}
}

class SelectField extends ChoicesField{
	function html(){
		ob_start();
		?>
		<label class="block" for="<?=$this->id?>"><?=__($this->name)?></label>
		<select name="<?=htmlentities($this->id)?>" id="<?=htmlentities($this->id)?>">
			<?php foreach($this->choices as $key=>$value):?>
			<option<?php if($this->value == $value):?> selected="selected"<?php endif;?> value="<?=htmlentities($value)?>"><?=htmlentities($key)?></option>
			<?php endforeach;?>
		</select>
		<?php if($this->description):?>
		<p class="description"><?=__($this->description)?></p>
		<?php endif;?>
		<?php
		return ob_get_clean();
	}
}

class RadioField extends ChoicesField{
	function html(){
		ob_start();
		?>
		<label class="block"><?=__($this->name)?></label>
		<ul class="radio-list">
			<?php $i = 0; foreach($this->choices as $key=>$value): $id = htmlentities($this->id).'_'.$i++;?>
			<li>
				<input<?php if($this->value == $value):?> checked="checked"<?php endif;?> type="radio" name="<?=htmlentities($this->id)?>" id="<?=$id?>" value="<?=htmlentities($value)?>" />
				<label for="<?=$id?>"><?=htmlentities($key)?></label>
			</li>
			<?php endforeach;?>
		</ul>
		<?php if($this->description):?>
		<p class="description"><?=__($this->description)?></p>
		<?php endif;?>
		<?php
		return ob_get_clean();
	}
}

class CheckboxField extends ChoicesField{
	function html(){
		ob_start();
		?>
		<label class="block"><?=__($this->name)?></label>
		<ul class="checkbox-list">
			<?php $i = 0; foreach($this->choices as $key=>$value): $id = htmlentities($this->id).'_'.$i++;?>
			<li>
				<input<?php if(is_array($this->value) and in_array($value, $this->value)):?> checked="checked"<?php endif;?> type="checkbox" name="<?=htmlentities($this->id)?>[]" id="<?=$id?>" value="<?=htmlentities($value)?>" />
				<label for="<?=$id?>"><?=htmlentities($key)?></label>
			</li>
			<?php endforeach;?>
		</ul>
		<?php if($this->description):?>
		<p class="description"><?=__($this->description)?></p>
		<?php endif;?>
		<?php
		return ob_get_clean();
	}
}