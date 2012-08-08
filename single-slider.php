<?php if( !is_user_logged_in() ) wp_redirect( home_url('/') ); ?>

<?php get_header(); ?>

<section id="content" class="clearfix">

	<div class="container">

		<header class="page-header">

			<h1 class="page-title"><?php the_title(); ?></h1>

		</header><!-- end .page-header -->

		<?php echo do_shortcode('[slider id="' . $post->post_name . '"]'); ?>

		<div class="clear"></div>

		<p><?php edit_post_link(__('Edit', 'ss_framework'), '', ''); ?></p>
	
	</div><!-- end .container -->
	
</section><!-- end #content -->

<?php get_footer(); ?>