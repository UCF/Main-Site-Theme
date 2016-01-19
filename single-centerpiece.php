<?php if( !is_user_logged_in() ) wp_redirect( home_url('/') ); ?>

<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="row page-content nodescription" id="home" data-template="home-nodescription" role="main">
		<div class="col-md-12 col-sm-12">
			<p>
				<?php $centerpiece_id = $wp_query->get_queried_object_id(); ?>
				<?php echo do_shortcode('[centerpiece id="' . $centerpiece_id . '"]'); ?>
			</p>
			<div style="clear:both;"></div>
			<p><?php edit_post_link('Edit', '', ''); ?></p>
		</div>

	</div>
</div>

<div class="container">
	<div class="row">

		<?php get_footer();?>
