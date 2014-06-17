<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php $post = append_degree_profile_metadata($post); ?>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="contentcol" class="span9 program">
			<article role="main">
				<div class="row program-details">
					<div class="span6" id="program-title">
						<h2 class="program-type-alt"><?=$post->tax_program_type[0]?></h2>

						<?php
						if ($post->degree_hours && intval($post->degree_hours) > 0) {
							if ($post->degree_hours >= 100) {
						?>
							<span class="credits label label-info"><?=$post->degree_hours?> credit hours</span>
							<?php } elseif ($post->degree_hours > 1 && $post->degree_hours < 100) { ?>
							<span class="credits label label-success"><?=$post->degree_hours?> credit hours</span>
						<?php
							}
						}
						else {
						?>
							<span class="credits label">Credit hours n/a</span>
						<?php
						}
						?>

						<p class="program-college"><?=$post->tax_college[0]?></p>
						<p class="program-dept"><?=$post->tax_department[0]?></p>
					</div>
					<div class="span3" id="program-meta">

						<p class="program-phone">
							<strong>Phone:</strong>
							<?php if ($post->degree_phone !== 'n/a') { ?><a href="tel:<?=$post->degree_phone?>"><?php } ?>
								<?=$post->degree_phone?>
							<?php if ($post->degree_phone !== 'n/a') { ?></a><?php } ?>
						</p>
						<p class="program-email">
							<strong>E-mail:</strong>
							<?php if ($post->degree_email !== 'n/a') { ?><a href="mailto:<?=$post->degree_email?>"><?php } ?>
								<?=$post->degree_email?>
							<?php if ($post->degree_email !== 'n/a') { ?></a><?php } ?>
						</p>
						<p class="program-website">
							<strong>Website:</strong>
							<?php if ($post->degree_website !== 'n/a') { ?><a target="_blank" href="<?=$post->degree_website?>"><?php } ?>
								<?=$post->degree_website?>
							<?php if ($post->degree_website !== 'n/a') { ?></a><?php } ?>
						</p>
					</div>
				</div>

				<h3>Program Information:</h3>
				<p class="catalog-link">
					<em>Find complete details and requirements in the <a href="http://catalog.ucf.edu/" target="_blank" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="Degree Profile: <?=addslashes($post->post_title)?> (<?=$post->tax_program_type[0]?>)">undergraduate catalog</a></em>.
				</p>
				<?=apply_filters('the_content', $post->degree_description)?>

				<?php if ($post->post_content) { ?>
				<h3>About This Degree:</h3>
				<?php the_content(); ?>
				<?php } ?>

				<?php
				if (!empty($post->degree_contacts)) {
				?>
				<div class="well program-advisor-contact">
					<h3>Contact Information:</h3>
					<p class="program-contact">
					<?php
						foreach ($post->degree_contacts as $contact) {
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
