<?php define(DEGREE_SECRET_KEY, get_theme_option('feedback_email_key')); ?>
<form method="post" id="theme-options" class="i-am-a-fancy-admin">
    <?php settings_fields(THEME_OPTIONS_GROUP);?>
	<div class="container">
		<h2>Import Degree Data</h2>
		
		<?php if ($_POST['submit-button']) {
			require_once(THEME_JOBS_DIR.'/degree-importer.php');
			print '<br/><br/><hr/><br/>';
		}
		?>
		
		<p>
			Click the button below to import degree data from the UCF Search Service.  Existing degree posts will be updated as necessary, 
			and any existing degrees that have been removed from the search service data since the last import will be deleted from WordPress.
		</p>
		<p>
			Degree post content and taxonomy terms (program types, colleges, and departments) are always replaced completely.
		</p>
		<p><strong>Don't navigate away from this page after clicking the Import button.</strong>  The import process may take a few minutes.</p>

		<div class="submit">
			<input type="submit" class="button-primary" name="submit-button" value="<?= __('Run Import')?>" />
		</div>
	</div>
</form>