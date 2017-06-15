<?php get_header(); the_post(); ?>
<?php
	$degree_search = get_permalink( get_page_by_title( 'Degree Search' ) );
	$raw_postmeta = get_post_meta( $post->ID );
	$post_meta = format_raw_postmeta( $raw_postmeta );
	$program_types = wp_get_post_terms( $post->ID, 'program_types' );
	$program_type = is_array( $program_types ) ? $program_types[0] : null;
	$colleges = get_colleges_markup( $post->ID );
	$departments = get_departments_markup( $post->ID );
?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="bg-default p-4 my-4">
				<dl class="row">
					<?php if ( $program_type ) : ?>
					<dt class="col-sm-6">Program:</dt>
					<dd class="col-sm-6"><?php echo $program_type->name; ?></dd>
					<?php endif; ?>
					<?php if ( $colleges ) : ?>
					<dt class="col-sm-6">College(s):</dt>
					<dd class="col-sm-6">
						<?php echo $colleges; ?>
					</dd>
					<?php endif; ?>
					<?php if ( $departments ) : ?>
					<dt class="col-sm-6">Department(s): </dt>
					<dd class="col-sm-6">
						<?php echo $departments; ?>
					</dd>
					<?php endif; ?>
				</dl>
			</div>
			<div class="content mb-4">
				<?php the_content(); ?>
				<?php echo apply_filters( 'the_content', $post_meta['degree_description'] ); ?>
			</div>
			<div class="row">
			<?php if ( isset( $post_meta['degree_pdf'] ) ) : ?>
				<div class="col-sm-6">
					<a class="degree-promo mb-4 mb-sm-0" href="<?php echo $post_meta['degree_pdf']; ?>">
						<span class="degree-promo-icon fa fa-file-pdf-o w-20"></span>
						<span class="degree-promo-text">
							Download Catalog
						</span>
					</a>
				</div>
			<?php endif; ?>
			<?php if ( isset( $post_meta['degree_website'] ) ) : ?>
				<div class="col-sm-6">
					<a class="degree-promo" href="<?php echo $post_meta['degree_website']; ?>">
						<span class="degree-promo-icon fa fa-external-link-square w-20"></span>
						<span class="degree-promo-text">
							Visit Program Website
						</span>
					</a>
				</div>
			<?php endif; ?>
			</div>
		</div>
		<div class="col-md-4">
		<?php if ( isset( $post_meta['degree_hours'] ) ) : ?>
			<div class="degree-hours my-4">
				<p class="h4 text-center"><?php echo $post_meta['degree_hours']; ?> total credit hours</p>
			</div>
		<?php endif; ?>
		<?php echo get_degree_apply_button( $post_meta ); ?>
		<a class="btn btn-lg btn-block bg-primary mb-4">
			<span class="fa fa-map-marker"></span> Visit UCF
		</a>
		<?php echo get_degree_tuition_markup( $post_meta ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
