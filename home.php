<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="row page-content nodescription" id="home" data-template="home-nodescription">
		
		<div class="span12">
			<p>Slideshow will go here</p>
		</div>
		<div class="span4">	
			<p>Spotlight column --  make this a widget?</p>
		</div>
		<div class="span4">
			<p>News column -- make this a widget?</p>
		</div>
		<div class="span4">
			<p>Events column -- make this a widget?</p>
		</div>
	
	</div>
	
	<div class="container" id="colleges_wrap">
		<div class="row">
			<?=wp_nav_menu(array(
				'theme_location' => 'ucf-colleges', 
				'container' => 'false',
				));
			?>
		</div>
	</div>

<?php get_footer();?>