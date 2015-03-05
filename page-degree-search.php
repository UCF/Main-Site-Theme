<?php 
if (isset($_GET['json'])) :

	$to_json = get_hiearchical_degree_search_data_json();

	header('Content-Type:application/json');

	echo json_encode($to_json);

else :


get_header(); the_post();?>
	<?php $degrees = get_degree_search_data(); ?>
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
				<?=display_degree_search($degrees);?>
				<br/>
				<p class="more-details">
					For more details and the complete undergraduate catalog, visit: <a href="http://catalog.ucf.edu/" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="<?=addslashes(the_title())?> (footer)">catalog.ucf.edu</a>.
				</p>
				<p class="more-details">
					For graduate programs and courses, visit: <a href="http://www.graduatecatalog.ucf.edu/" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="<?=addslashes(the_title())?> (footer)">www.graduatecatalog.ucf.edu</a>.
				</p>
			</article>
		</div>
	</div>
<?php get_footer(); endif; ?>
