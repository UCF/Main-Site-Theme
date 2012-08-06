<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="row page-content nodescription" id="home" data-template="home-nodescription">
		
		<div class="span12">
			<p>Slideshow will go here</p>
		</div>
		<div class="span4" id="home_leftcol">	
			<p>Spotlight column --  make this a widget?</p>
		</div>
		<div class="span4" id="home_centercol">
			<p>News column -- make this a widget?</p>
		</div>
		<div class="span4" id="home_rightcol">
			<p>Events column -- make this a widget?</p>
		</div>
	
	</div>
	
	<div class="container" id="colleges_wrap">
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

<?php get_footer();?>