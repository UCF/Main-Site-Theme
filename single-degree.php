<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php 
	$unmatched_meta = get_post_meta($post->ID);

	// Get only keys that start with degree_
	$meta = array_intersect_key($unmatched_meta, array_flip(preg_grep('/^degree_/', array_keys($unmatched_meta))));

	$terms = get_post_tax_term_array( $post->ID, array( 'program_types', 'colleges', 'departments' ) );
?>

<?php
	$css_key = get_theme_option('cloud_font_key');
	if ($css_key) {
		print '<link rel="stylesheet" href="'.$css_key.'" type="text/css" media="all" />';
	}
	$search_page = get_permalink( get_page_by_title( 'Degree Search' ) );
?>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="breadcrumbs" class="span12 clearfix">
			<!-- Display .breadcrumb-search only if the user came from the degree search (check for GET param) -->
			<a class="breadcrumb-search" href="javascript:window.history.back();">&laquo; Back to Search Results</a>

			<!-- Always display hierarchy-based breadcrumbs-it also helps designate tracks/subplans -->
			<ul class="breadcrumb-hierarchy breadcrumb">
				<li>
					<?php $programs_url = $search_page . '?' . http_build_query( array( 'program_type' => array( $terms['program_types'][0]->slug ) ) ); ?>
					<a href="<?php echo $programs_url; ?>"><?php echo $terms['program_types'][0]->name; ?> Programs</a> <span class="divider">&gt;</span>
				</li>
				<li>
					<?php $college_url = $search_page . '?' . http_build_query( array( 'program_type' => array( $terms['program_types'][0]->slug ), 'college' => array( $terms['colleges'][0]->slug ) ) ); ?>
					<a href="<?php echo $college_url; ?>"><?php echo $terms['colleges'][0]->name; ?></a> <span class="divider">&gt;</span>
				</li>
				<li class="active">
					<?php the_title(); ?>
				</li>
			</ul>
		</div>

		<div id="contentcol" class="span8 degree">
			<article role="main">
				<!-- Degree description -->
				<?php if ($post->degree_description) { ?>
					<?php echo apply_filters('the_content', $post->degree_description)?>
				<?php } else { ?>
					<p>You can find a full description of this degree in the <a href="<?php echo $post->degree_pdf; ?>" target="_blank">course catalog</a>.</p>
				<?php } ?>
				<!-- Degree meta details -->
				<div class="row degree-details">
					<div class="span3">
						<dl>
							<dt>Degree:</dt>
							<dd><?=$post->tax_program_type[0]?><br></dd>
							<dt>Total Credit Hours:</dt>
							<dd><?php echo $post->degree_hours; ?></dd>
						</dl>
					</div>
					<div class="span5">
						<dl>
							<dt>College:</dt>
							<dd>
								<!-- TODO: better way of forcing linebreak after inline <dd>'s that is IE friendly? -->
								<a href="#"><?=$post->tax_college[0]?></a><br>
							</dd>
							<dt>Department:</dt>
							<dd>
								<a href="#"><?=$post->tax_department[0]?></a><br>
							</dd>
						</dl>
					</div>
				</div>

				<div class="visible-phone">
					<a class="btn btn-large btn-block btn-success">View Catalog</a>
					<a class="btn btn-large btn-block">Visit Program Website</a>
				</div>
			</article>
		</div>
		<div id="sidebar_right" class="span4 notoppad" role="complementary">

			<!-- Sidebar content -->

			<div class="hidden-phone">
				<a href="<?=$post->degree_pdf?>" target="_blank" class="btn btn-large btn-block btn-success">View Catalog</a>
				<a href="<?=$post->degree_website?>" class="btn btn-large btn-block">Visit Program Website</a>
			</div>

			<h2>Contact</h2>
			<h3 class="contact-name">Steve Sutton Ph.D.</h3>
			<span class="contact-title">Professor</span>
			<dl class="contact-info-dl">
				<dt>Email:</dt>
				<dd>
					<span class="contact-email">
						<?php if ($post->degree_email !== 'n/a') { ?><a href="mailto:<?=$post->degree_email?>"><?php } ?>
							<?=$post->degree_email?>
						<?php if ($post->degree_email !== 'n/a') { ?></a><?php } ?>
					</span>
					<br>
				</dd>
				<dt>Phone:</dt>
				<dd>
					<span class="contact-phone">
						<?php if ($post->degree_phone !== 'n/a') { ?><a href="tel:<?=$post->degree_phone?>"><?php } ?>
							<?=$post->degree_phone?>
						<?php if ($post->degree_phone !== 'n/a') { ?></a><?php } ?>
					</span>
					<br>
				</dd>
				<dt>Office:</dt>
				<dd>
					<span class="contact-office">
						<?php if ($post->degree_website !== 'n/a') { ?><a target="_blank" href="<?=$post->degree_website?>"><?php } ?>
							<?=$post->tax_college[0]?>
						<?php if ($post->degree_website !== 'n/a') { ?></a><?php } ?>
					</span>
				</dd>
			</dl>

		</div>
	</div>

<?php get_footer();?>
