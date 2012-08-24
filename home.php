<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="row page-content nodescription" id="home" data-template="home-nodescription">		
		<div class="span12">
			<?php
				$args = array(
					'numberposts' => 1,
					'post_type' => 'centerpiece',
				);
				$latest_centerpiece = get_posts($args);
				echo do_shortcode('[centerpiece id="'.$latest_centerpiece[0]->ID.'"]'); 
				?>
		</div>
		<div class="span4" id="home_leftcol">	
			<h2>Spotlight</h2>
			<p><?php echo do_shortcode('[spotlights]'); ?></p>
			<p><a href="<?=get_permalink(get_page_by_title('Spotlight Archives', OBJECT, 'page')->ID);?>" class="home_col_morelink">Spotlight Archive</a></p>
		</div>
		<div class="span4" id="home_centercol">
			<div class="col_padwrap">
				<h2>News</h2>
				<?=display_news()?>
				<p><a href="http://today.ucf.edu/" class="home_col_morelink">More News</a></p>
			</div>
		</div>
		<div class="span4" id="home_rightcol">
			<h2>Upcoming Events</h2>
			<?=do_shortcode('[events-widget]')?>
			<?=output_weather_data()?>
		</div>
	
	</div>
</div>
	
<div class="container-fullwidth" id="colleges_wrap">	
	<div class="container">
		<div class="row">
			<div class="span2">
				<h3>UCF Colleges</h3>
			</div>
			<div class="span10">
				<?=wp_nav_menu(array(
					'theme_location' => 'ucf-colleges', 
					'container' => 'false',
					));
				?>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">

		<?php get_footer();?>