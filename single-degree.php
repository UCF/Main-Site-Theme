<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php
	$unmatched_meta = get_post_meta( $post->ID );

	// Get only keys that start with degree_
	$meta = array_intersect_key( $unmatched_meta, array_flip( preg_grep( '/^degree_/', array_keys( $unmatched_meta ) ) ) );

	$terms = get_post_tax_term_array( $post->ID, array( 'program_types', 'colleges', 'departments' ) );

	$search_page = get_permalink( get_page_by_title( 'Degree Search' ) );
?>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include( 'output_weather_data','span3' ); ?>
		</div>

		<div id="breadcrumbs" class="span12 clearfix">
			<!-- Display .breadcrumb-search only if the user came from the degree search (js check) -->
			<a id="breadcrumb-search" href="<?php echo preg_replace( '/^http(s)?:/', '', get_permalink( get_page_by_title( 'Degree Search' ) ) ); ?>">&laquo; Back to Degree Search</a>

			<!-- Always display hierarchy-based breadcrumbs-it also helps designate tracks/subplans -->
			<ul class="breadcrumb-hierarchy breadcrumb">
				<li>
					<?php $programs_url = $search_page . '?' . http_build_query( array( 'program_type' => array( $terms['program_types'][0]->slug ) ) ); ?>
					<a href="<?php echo $programs_url; ?>"><?php echo $terms['program_types'][0]->name; ?> Programs</a> <span class="divider">&gt;</span>
				</li>
				<li>
					<?php $college_programs_url = $search_page . '?' . http_build_query( array( 'program_type' => array( $terms['program_types'][0]->slug ), 'college' => array( $terms['colleges'][0]->slug ) ) ); ?>
					<a href="<?php echo $college_programs_url; ?>"><?php echo $terms['colleges'][0]->name; ?></a> <span class="divider">&gt;</span>
				</li>
				<li class="active">
					<?php the_title(); ?>
				</li>
			</ul>
		</div>

		<div id="contentcol" class="span8 degree">
			<article role="main">
				<!-- Degree meta details -->
				<div class="row">
					<div class="span8">
						<dl class="degree-details clearfix">
							<dt>Degree:</dt>
							<dd><?php echo $terms['program_types'][0]->name; ?></dd>
							<dt>Total Credit Hours:</dt>
							<dd><?php echo $meta['degree_hours'][0]; ?></dd>
							<dt>College:</dt>
							<dd>
								<?php
								$college_url = get_term_custom_meta( $terms['colleges'][0]->term_id, 'colleges', 'college_url' );
								if ( $college_url ):
								?>
								<a target="_blank" href="<?php echo $college_url; ?>"><?php echo $terms['colleges'][0]->name; ?></a>
								<?php else: ?>
								<?php echo $terms['colleges'][0]->name; ?>
								<?php endif;?>
							</dd>
							<dt>Department:</dt>
							<dd>
								<?php if ( count( $meta['degree_website'] ) > 0 && $meta['degree_website'][0] !== 'n/a' ): ?>
									<a href="<?php echo $meta['degree_website'][0]; ?>">
										<?php echo $terms['departments'][0]->name; ?>
									</a>
								<?php else: ?>
									<?php echo $terms['departments'][0]->name ?>
								<?php endif; ?>
							</dd>
						</dl>
						<!-- Degree description -->
					</div>
				</div>

				<div class="mobile-degree-cta visible-phone">
					<a class="btn btn-large btn-block btn-success">View Catalog</a>
					<a class="btn btn-large btn-block">Visit Program Website</a>
				</div>

				<?php if ($post->degree_description) { ?>
					<p><?php echo apply_filters('the_content', $post->degree_description)?></p>
				<?php } else { ?>
					<p>You can find a full description of this degree in the <a href="<?php echo $post->degree_pdf; ?>" target="_blank">course catalog</a>.</p>
				<?php } ?>
			</article>
			<?php echo do_shortcode('[shareaholic app="share_buttons" id="' . $theme_options['shareaholic_below_post_id'] . '"]'); ?>
		</div>
		<div id="sidebar_right" class="span4 notoppad" role="complementary">

			<!-- Sidebar content -->

			<div class="hidden-phone">
				<a href="<?php echo $meta['degree_pdf'][0]; ?>" target="_blank" class="btn btn-large btn-block btn-success">View Catalog</a>
				<a href="<?php echo $meta['degree_website'][0]; ?>" class="btn btn-large btn-block">Visit Program Website</a>
			</div>

			<h2>Contact</h2>
			<h3 class="contact-name">Steve Sutton Ph.D.</h3>
			<span class="contact-title">Professor</span>
			<dl class="contact-info-dl">
				<dt>Email:</dt>
				<dd>
					<span class="contact-email">
						<?php if ( count( $meta['degree_email'] ) > 0 && ! empty( $meta['degree_email'][0] ) ) : ?>
							<a href="mailto:<?php echo $meta['degree_email'][0]; ?>">
								<?php echo $meta['degree_email'][0]; ?>
							</a>
						<?php else: ?>
							n/a
						<?php endif; ?>
					</span>
				</dd>
				<dt>Phone:</dt>
				<dd>
					<span class="contact-phone">
						<?php if ( count( $meta['degree_phone'] ) > 0 && ! empty( $meta['degree_phone'][0] ) ) : ?>
							<a href="tel:<?php $meta['degree_phone'][0]; ?>">
								<?php echo $meta['degree_phone'][0]; ?>
							</a>
						<?php else: ?>
							n/a
						<?php endif; ?>
					</span>
				</dd>
				<dt>Office:</dt>
				<dd>
					<span class="contact-office">
						<?php if ( count( $meta['degree_website'] ) > 0 && ! empty( $meta['degree_website'][0] ) ) : ?>
							<a target="_blank" href="<?php echo $meta['degree_website'][0]; ?>">
								<?php echo $terms['colleges'][0]->name; ?>
							</a>
						<?php else: ?>
							n/a
						<?php endif; ?>
					</span>
				</dd>
			</dl>

		</div>
	</div>

<?php get_footer();?>
