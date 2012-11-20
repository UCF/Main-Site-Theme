<?php

//
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data(\'span3\');'); ?>
		</div>
		
		<div id="sidebar_left" class="span2" role="navigation">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span10" id="contentcol">
			<article role="main">
				<p><a href="<?=get_site_url()?>/academics/">&laquo; Back to Academics</a></p>
			
				<?php the_content();?>
				
				<?php if ($error !== '') { print '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; } ?>
			
				<div id="filters">
					<h3>Search:</h3>
					<div class="controls controls-row">
						<form id="course_search_form" action="" class="form-search">
							<select name="program_type" class="span4">
								<option value="thisweek">Undergraduate Programs Only</option>
								<option value="nextweek">Undergraduate and Graduate Programs</option>
								<option value="thismonth">Graduate Programs Only</option>
							</select>	
							<div class="input-append span3">
								<input type="text" class="search-query">
								<button type="submit" class="btn"><i class="icon-search"></i> Search</button>
							</div>
						</form>
					</div>
				</div>
				
				<div id="browse">
					<h3>Browse:</h3>
					<p style="text-align:center;">Majors | Minors | Graduate Programs | Certificates</p>
				</div>
				
				
				<?php 
					//
				?>
				
			</article>
		</div>
	</div>
<?php get_footer(); ?>