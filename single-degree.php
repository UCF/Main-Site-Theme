<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php
	$required_hours = get_post_meta($post->ID, 'degree_hours', TRUE);
	$description = get_post_meta($post->ID, 'degree_description', TRUE);
	$phone = get_post_meta($post->ID, 'degree_phone', TRUE) ? get_post_meta($post->ID, 'degree_phone', TRUE) : 'n/a';
	$email = get_post_meta($post->ID, 'degree_email', TRUE) ? get_post_meta($post->ID, 'degree_email', TRUE) : 'n/a';
	$website = get_post_meta($post->ID, 'degree_website', TRUE) ? get_post_meta($post->ID, 'degree_website', TRUE) : 'n/a';

	$contact_info = get_post_meta($post->ID, 'degree_contacts', TRUE);

	$contact_array = array();

	// Split single contacts
	$contacts = explode('@@;@@', $contact_info);
	foreach ($contacts as $key=>$contact) {
		if ($contact) {
			// Split individual fields
			$contact = explode('@@,@@', $contact);

			$newcontact = array();

			foreach ($contact as $fieldset) {
				// Split out field key/values
				$fields = explode('@@:@@', $fieldset);
				$newcontact[$fields[0]] = $fields[1];
			}

			array_push($contact_array, $newcontact);
		}
	}

	$programs = wp_get_post_terms($post->ID, 'program_types');
	$program_type = $programs[0]->name;
	$college = wp_get_post_terms($post->ID, 'colleges');
	$college = $college[0]->name;
	$department = wp_get_post_terms($post->ID, 'departments');
	$department = $department[0]->name;

	// Update website for graduate programs
	if (get_term($programs[0]->parent, 'program_types')->name == 'Graduate Program') {
		$website = 'http://www.graduatecatalog.ucf.edu/programs/program.aspx'.$required_hours;
	}
?>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="contentcol" class="span9 program">
			<article role="main">
				<div class="row program-details">
					<div class="span6" id="program-title">
						<h2 class="program-type-alt"><?=$program_type?></h2>

						<?php
						if ($required_hours && intval($required_hours) > 0) {
							if ($required_hours >= 100) {
						?>
							<span class="credits label label-info"><?=$required_hours?> credit hours</span>
							<?php } elseif ($required_hours > 1 && $required_hours < 100) { ?>
							<span class="credits label label-success"><?=$required_hours?> credit hours</span>
						<?php
							}
						}
						else {
						?>
							<span class="credits label">Credit hours n/a</span>
						<?php
						}
						?>

						<p class="program-college"><?=$college?></p>
						<p class="program-dept"><?=$department?></p>
					</div>
					<div class="span3" id="program-meta">

						<p class="program-phone">
							<strong>Phone:</strong>
							<?php if ($phone !== 'n/a') { ?><a href="tel:<?=$phone?>"><?php } ?>
								<?=$phone?>
							<?php if ($phone !== 'n/a') { ?></a><?php } ?>
						</p>
						<p class="program-email">
							<strong>E-mail:</strong>
							<?php if ($email !== 'n/a') { ?><a href="mailto:<?=$email?>"><?php } ?>
								<?=$email?>
							<?php if ($email !== 'n/a') { ?></a><?php } ?>
						</p>
						<p class="program-website">
							<strong>Website:</strong>
							<?php if ($website !== 'n/a') { ?><a target="_blank" href="<?=$website?>"><?php } ?>
								<?=$website?>
							<?php if ($website !== 'n/a') { ?></a><?php } ?>
						</p>
					</div>
				</div>

				<h3>Program Information:</h3>
				<p class="catalog-link">
					<em>Find complete details and requirements in the <a href="http://catalog.ucf.edu/" target="_blank" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="Degree Profile: <?=addslashes($post->post_title)?> (<?=$program_type?>)">undergraduate catalog</a></em>.
				</p>
				<?=apply_filters('the_content', $description)?>

				<?php if ($post->post_content) { ?>
				<h3>About This Degree:</h3>
				<?php the_content(); ?>
				<?php } ?>

				<?php
				if (!empty($contact_array)) {
				?>
				<div class="well program-advisor-contact">
					<h3>Contact Information:</h3>
					<p class="program-contact">
					<?php
						foreach ($contact_array as $contact) {
					?>
						<?php if ($contact['contact_name']) { ?>
							<br/>
							<?=$contact['contact_name']?>
						<?php } ?>
						<?php if ($contact['contact_phone']) { ?>
							<br/>
							<a href="tel:<?=$contact['contact_phone']?>">
								<?=$contact['contact_phone']?>
							</a>
						<?php } ?>
						<?php if ($contact['contact_email']) { ?>
							<br/>
							<a href="mailto:<?=$contact['contact_email']?>">
								<?=$contact['contact_email']?>
							</a>
						<?php } ?>
						<br/>
					<?php
						}
					?>
					</p>
				</div>
				<?php
				}
				?>
				<p class="screen-only"><a href="<?=get_site_url()?>/degree-search/">&laquo; Back to Degree Search</a></p>
			</article>
		</div>
		<div id="sidebar_right" class="span3 notoppad" role="complementary">
			<?=get_sidebar('right');?>
		</div>
	</div>

<?php get_footer();?>
