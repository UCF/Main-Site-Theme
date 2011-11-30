<?php 
	# Check for settings updated or updated, varies between wp versions
	$updated = (bool)($_GET['settings-updated'] or $_GET['updated']);
?>

<form method="post" action="options.php" id="theme-options">
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
							<th scope="row"><?=$setting->label_html()?></th>
							<td class="field">
								<?=$setting->input_html()?>
								<?=$setting->description_html()?>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
				</td>
			</tr>
			<?php else:?>
			<tr valign="top">
				<th scope="row"><?=$setting->label_html()?></th>
				<td class="field">
					<?=$setting->input_html()?>
					<?=$setting->description_html()?>
				</td>
			</tr>
			<?php endif;?>
			<?php endforeach;?>
		</table>
		<div class="submit">
			<input type="submit" class="button-primary" value="<?= __('Save Options')?>" />
		</div>
	</div>
</form>