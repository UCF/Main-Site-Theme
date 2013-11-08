<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php
	$required_hours = get_post_meta($post->ID, 'degree_hours', TRUE);
	$phone = get_post_meta($post->ID, 'degree_phone', TRUE);
	$email = get_post_meta($post->ID, 'degree_email', TRUE);
	$website = get_post_meta($post->ID, 'degree_website', TRUE);
	$contact = get_post_meta($post->ID, 'degree_contacts', TRUE);

	$program_type = wp_get_post_terms($post->ID, 'program_types');
	$program_type = $program_type[0]->name;
	$college = wp_get_post_terms($post->ID, 'colleges');
	$college = $college[0]->name;
	$department = wp_get_post_terms($post->ID, 'departments');
	$department = $department[0]->name;
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
				
				<p class="program-type">Program Type: <?=$program_type?></p>
				
				<?php 
				if ($required_hours && intval($required_hours) > 0) { 
					if ($required_hours >= 100) {
				?>
					<span class="credits label label-info"><?=$required_hours?> credit hours</span>
					<?php } elseif ($required_hours > 1 && $required_hours < 100) { ?>
					<span class="credits label label-success"><?=$required_hours?> credit hours</span>
					
				<?php
					}
				} else {
				?>
					<span class="credits label">Credit hours n/a</span>
				<?php
				}
				?>

				<p class="program-college">College: <?=$college?></p>
				<p class="program-dept">Department: <?=$department?></p>
				<p class="program-phone">Phone: <?=$phone?></p>
				<p class="program-email">Email: <?=$email?></p>
				<p class="program-website">Website: <?=$website?></p>

				<?=the_content();?>

				<div class="well program-advisor-contact">
					<p>Advisor(s) contact information...</p>
					<p class="program-contact"><?=$contact?></p>
				</div>
			</article>
		</div>
		<div id="sidebar_right" class="span3 notoppad" role="complementary">		
			<?=get_sidebar('right');?>
			Right sidebar?
		</div>
	</div>

<?php get_footer();?>