<?php

if (is_login()){
	add_action('login_head', 'login_scripts', 0);
}

if (is_admin()){
	add_action('admin_menu', 'create_theme_options_page');
	add_action('admin_init', 'init_theme_options');
}

function login_scripts(){
	ob_start();?>
	<link rel="stylesheet" href="<?=THEME_CSS_URL?>/admin.css" type="text/css" media="screen" charset="utf-8" />
	<?php 
	$out = ob_get_clean();
	print $out;
}


function init_theme_options(){
	register_setting(THEME_OPTIONS_GROUP, THEME_OPTIONS_NAME, 'theme_options_sanitize');
}


function create_theme_options_page() {
	add_utility_page(
		__(THEME_OPTIONS_PAGE_TITLE),
		__(THEME_OPTIONS_PAGE_TITLE),
		'edit_theme_options',
		'theme-options',
		'theme_options_page',
		THEME_IMG_URL.'/pegasus.png'
	);
}


function theme_options_page(){
	# Check for settings updated or updated, varies between wp versions
	$updated = (bool)($_GET['settings-updated'] or $_GET['updated']);
	?>
	
	<form method="post" action="options.php">
		<div class="wrap">
			<h2><?=__(THEME_OPTIONS_PAGE_TITLE)?></h2>
			
			<?php if ($updated):?>
			<div class="updated fade"><p><strong><?=__( 'Options saved' ); ?></strong></p></div>
			<?php endif; ?>
			
			<?php settings_fields(THEME_OPTIONS_GROUP);?>
			<table class="form-table">
				<?php foreach(Config::$theme_settings as $key=>$setting):?>
				<?php if(is_array($setting)): $section = $setting;?>
				<tr class="section">
					<td colspan="2">
						<h3><?=$key?></h3>
						<table class="form-table">
							<?php foreach($section as $setting):?>
							<tr valign="top">
								<th scope="row"><label for="<?=htmlentities($setting->id)?>"><?=$setting->name?></label></th>
								<td class="field"><?=$setting->html()?></td>
							</tr>
							<?php endforeach;?>
						</table>
					</td>
				</tr>
				<?php else:?>
				<tr valign="top">
					<th scope="row"><label for="<?=htmlentities($setting->id)?>"><?=$setting->name?></label></th>
					<td class="field"><?=$setting->html()?></td>
				</tr>
				<?php endif;?>
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