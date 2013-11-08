<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php
	$required_hours = get_post_meta($post->ID, 'degree_hours', TRUE);
	$program_type = wp_get_post_terms($post->ID, 'program_types');
	$program_type = $program_type[0]->name;
?>
	
	<div class="row page-content" id="academics-search">
		<div id="page_title" class="span12">
			<h1 class="span9">Degree Program</h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="contentcol" class="span9 program">
			<article role="main">
				<p class="screen-only"><a href="<?=get_site_url()?>/academics/">&laquo; Back to Academics Search</a></p>
				<h2><?php the_title(); ?></h2>
				
				<div class="credits_wrap">
					<span class="program-type-alt"><?=$program_type?></span>
				
					<?php if ($required_hours) { 
						if ($required_hours >= 100) { ?>
						<span class="credits label label-info"><?=$required_hours?> credit hours</span>
						<?php } elseif ($required_hours > 1 && $required_hours < 100) { ?>
						<span class="credits label label-success"><?=$required_hours?> credit hours</span>
						
					<?php }
					} else { ?>
						<span class="credits label">Credit hours n/a</span>
					<?php } ?>
				</div>

				<p class="program-college">College of Something</p>
				<p class="program-dept">Department of Other Things</p>
				<p class="program-contact">Contact information...</p>

				<?=the_content();?>

				<div class="well program-advisor-contact">
					<p>Advisor(s) contact information...</p>
				</div>
			</article>
		</div>
		<div id="sidebar_right" class="span3 notoppad" role="complementary">		
			<?=get_sidebar('right');?>
			Right sidebar?
		</div>
	</div>

<?php get_footer();?>