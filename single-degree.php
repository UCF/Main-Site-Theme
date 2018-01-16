<?php get_header(); the_post(); ?>
<?php
	$raw_postmeta  = get_post_meta( $post->ID );
	$post_meta     = format_raw_postmeta( $raw_postmeta );
	$program_types = wp_get_post_terms( $post->ID, 'program_types' );
	$program_type  = is_array( $program_types ) ? $program_types[0] : null;
	$colleges      = get_colleges_markup( $post->ID );
	$departments   = get_departments_markup( $post->ID );
	$breadcrumbs   = get_degree_breadcrumb_markup( $post->ID );
?>
<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
	<div class="row">
		<div class="col-lg-8 col-xl-7 pr-lg-5 pr-xl-0">
			<div class="bg-faded p-3 p-sm-4 mb-4">
				<dl class="row mb-0">
					<?php if ( $program_type ) : ?>
					<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">Program:</dt>
					<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9"><?php echo $program_type->name; ?></dd>
					<?php endif; ?>
					<?php if ( $colleges ) : ?>
					<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">College(s):</dt>
					<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9">
						<?php echo $colleges; ?>
					</dd>
					<?php endif; ?>
					<?php if ( $departments ) : ?>
					<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">Department(s): </dt>
					<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9">
						<?php echo $departments; ?>
					</dd>
					<?php endif; ?>
				</dl>
			</div>
			<div class="content mb-5">
				<?php the_content(); ?>
				<?php echo apply_filters( 'the_content', $post_meta['degree_description'] ); ?>
			</div>
			<div class="row">
			<?php if ( isset( $post_meta['degree_pdf'] ) && ! empty( $post_meta['degree_pdf'] ) ) : ?>
				<div class="col-md-6 col-lg-10 col-xl-6 mb-2 mb-md-0 mb-lg-2 mb-xl-0">
					<a class="btn btn-outline-complementary p-0 h-100 d-flex flex-row justify-content-between" href="<?php echo $post_meta['degree_pdf']; ?>">
						<div class="bg-complementary p-3 px-sm-4 d-flex align-items-center"><span class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></span></div>
						<div class="p-3 align-self-center mx-auto">Download Catalog</div>
					</a>
				</div>
			<?php endif; ?>
			<?php if ( isset( $post_meta['degree_website'] ) && ! empty ( $post_meta['degree_website'] ) ) : ?>
				<div class="col-md-6 col-lg-10 col-xl-6">
					<a class="btn btn-outline-complementary p-0 h-100 d-flex flex-row justify-content-between" href="<?php echo $post_meta['degree_website']; ?>">
						<div class="bg-complementary p-3 px-sm-4 d-flex align-items-center"><span class="fa fa-external-link-square fa-2x" aria-hidden="true"></span></div>
						<div class="p-3 align-self-center mx-auto">Visit Program Website</div>
					</a>
				</div>
			<?php endif; ?>
			</div>
		</div>
		<div class="col-lg-4 offset-xl-1 mt-5 mt-lg-0">
			<div class="mb-4 degree-cta-buttons">
				<?php echo get_degree_apply_button( $post_meta ); ?>
				<?php echo get_degree_visit_ucf_button(); ?>
			</div>

			<?php if ( isset( $post_meta['degree_hours'] ) ) : ?>
			<div class="degree-hours my-4 my-md-5">
				<hr>
				<p class="h4 text-center"><?php echo $post_meta['degree_hours']; ?> <span class="font-weight-normal">total credit hours</span></p>
				<hr>
			</div>
			<?php endif; ?>

			<?php echo get_degree_tuition_markup( $post_meta ); ?>
		</div>
	</div>

	<?php echo $breadcrumbs; ?>
</div>

<?php echo get_colleges_grid(); ?>

<?php get_footer(); ?>
