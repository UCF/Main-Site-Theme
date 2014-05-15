<?php get_header(); the_post();?>
	<?php $degrees = get_degrees(); ?>
	<div class="row page-content" id="academics-search">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>
		
		<div id="sidebar_left" class="span2" role="navigation">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span10" id="contentcol">
			<article role="main">
				<?php the_content(); ?>
				<?=display_degrees($degrees);?>
				<br/>
				<p class="more-details">
					For more details and the complete undergraduate catalog, visit: <a href="http://www.catalog.sdes.ucf.edu/">www.catalog.sdes.ucf.edu/</a>.
				</p>
				<p class="more-details">
					For graduate programs and courses, visit: <a href="http://www.graduatecatalog.ucf.edu/">www.graduatecatalog.ucf.edu/</a>.
				</p>
			</article>
		</div>
	</div>
<?php get_footer(); ?>