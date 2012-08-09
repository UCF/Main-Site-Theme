<?php if( !is_user_logged_in() ) wp_redirect( home_url('/') ); ?>

<?php get_header(); ?>

	<div class="row page-content nodescription">

		<?php echo do_shortcode('[slider id="' . $post->post_name . '"]'); ?>
		<div style="clear:both;"></div>
		<p><?php edit_post_link(__('Edit', 'ss_framework'), '', ''); ?></p>
	</div>
</div>
<div class="container">
	<div class="row">

		<?php get_footer(); ?>