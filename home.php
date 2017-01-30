<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="row page-content nodescription" id="home" data-template="home-nodescription" role="main">
		<div class="col-md-12 col-sm-12">
			<?php
				$args = array(
					'numberposts' => 1,
					'post_type' => 'centerpiece',
				);
				$latest_centerpiece = get_posts($args);
				echo do_shortcode('[centerpiece id="'.$latest_centerpiece[0]->ID.'"]');
				?>
		</div>
		<div class="col-md-4 col-sm-4 col-md-xpad col-sm-xpad" id="home_leftcol">
			<h2>Spotlight</h2>
			<?=frontpage_spotlights()?>
			<p class="screen-only"><a href="<?=get_permalink(get_page_by_title('Spotlight Archives', OBJECT, 'page')->ID);?>" class="home_col_morelink">Spotlight Archive</a></p>
		</div>
		<div class="col-md-4 col-sm-4 col-md-xpad col-sm-xpad" id="home_centercol">
			<?php esi_include('echo_shortcode', '[ucf-news-feed title="News" layout="classic" topics="main-site-stories"]'); ?>
			<p class="screen-only"><a href="http://today.ucf.edu/" class="home_col_morelink">More News</a></p>
		</div>
		<div class="col-md-4 col-sm-4 col-md-xpad col-sm-xpad" id="home_rightcol">
			<h2>Upcoming Events</h2>
			<?php esi_include('do_shortcode','[events-widget]'); ?>
			<?php esi_include('output_weather_data'); ?>
		</div>

	</div>
</div>

<div class="container-fullwidth screen-only" id="home-supplemental">
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-sm-5">
				<aside>
					<?=apply_filters('the_content', get_theme_option('home_desc'))?>
				</aside>
			</div>
			<div class="col-md-6 col-sm-6 col-md-offset-1 col-sm-offset-1" role="navigation">
				<h3>Colleges</h3>
				<?=wp_nav_menu(array(
					'theme_location' => 'ucf-colleges',
					'container' => 'false',
					'menu_class' => 'list-unstyled',
					));
				?>
			</div>
		</div>
	</div>
</div>

<div class="container" id="home-footerwrap">
	<div class="row">

		<?php get_footer();?>
