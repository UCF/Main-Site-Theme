<?php get_header(); the_post(); ?>
<?php
	$raw_postmeta      = get_post_meta( $post->ID );
	$post_meta         = format_raw_postmeta( $raw_postmeta );
	$program_type      = get_degree_program_type( $post );
	$colleges          = wp_get_post_terms( $post->ID, 'colleges' );
	$college           = is_array( $colleges ) ? $colleges[0] : null;
	$colleges_list     = get_colleges_markup( $post->ID );
	$departments_list  = get_departments_markup( $post->ID );
	$breadcrumbs       = get_degree_breadcrumb_markup( $post->ID );
	$online_bg_img     = get_theme_mod_or_default( 'online_banner_background_img' );
	$hide_catalog_desc = ( isset( $post_meta['degree_disable_catalog_desc'] ) && filter_var( $post_meta['degree_disable_catalog_desc'], FILTER_VALIDATE_BOOLEAN ) === true );
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
					<?php if ( $colleges_list ) : ?>
					<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">College(s):</dt>
					<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9">
						<?php echo $colleges_list; ?>
					</dd>
					<?php endif; ?>
					<?php if ( $departments_list ) : ?>
					<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">Department(s): </dt>
					<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9">
						<?php echo $departments_list; ?>
					</dd>
					<?php endif; ?>
				</dl>
			</div>
			<div class="hidden-lg-up row mb-3">
				<div class="col-sm mb-2">
					<?php echo get_degree_apply_button( $post ); ?>
				</div>
				<div class="col-sm mb-2">
					<?php echo get_degree_visit_ucf_button(); ?>
				</div>
			</div>
			<div class="mb-3">
				<?php the_content(); ?>
				<?php
				if ( ! $hide_catalog_desc ) {
					echo apply_filters( 'the_content', $post_meta['degree_description'] );
				}
				?>
			</div>
			<div class="row mb-4 mb-lg-5">
			<?php if ( isset( $post_meta['degree_pdf'] ) && ! empty( $post_meta['degree_pdf'] ) ) : ?>
				<div class="col-md-6 col-lg-10 col-xl-6 mb-2 mb-md-0 mb-lg-2 mb-xl-0">
					<a class="btn btn-outline-complementary p-0 h-100 d-flex flex-row justify-content-between" href="<?php echo $post_meta['degree_pdf']; ?>" rel="nofollow">
						<div class="bg-complementary p-3 px-sm-4 d-flex align-items-center"><span class="fa fa-book fa-2x" aria-hidden="true"></span></div>
						<div class="p-3 align-self-center mx-auto">View Catalog</div>
					</a>
				</div>
			<?php endif; ?>
			</div>
			<?php echo main_site_degree_display_subplans( $post->ID ); ?>
			<?php if ( isset( $post_meta['degree_online_url'] ) && ! empty( $post_meta['degree_online_url'] ) ) : ?>
			<aside class="online-callout" aria-label="Apply for this program online">
				<a class="media-background-container d-block py-3 px-3 px-lg-4 py-lg-4 hover-parent bg-inverse hover-text-black text-decoration-none" href="<?php echo $post_meta['degree_online_url']; ?>" target="_blank">
					<img src="<?php echo $online_bg_img; ?>" alt="" class=" media-background object-fit-cover hover-child" data-object-fit="cover">
					<div class="media-background object-fit-cover bg-inverse-t-2 hover-child hover-child-hide fade" data-object-fit="cover"></div>
					<div class="media-background object-fit-cover bg-primary-t-1 hover-child hover-child-show fade" data-object-fit="cover"></div>
					<div class="row py-3">
						<div class="col-auto">
							<span class="fa fa-info-circle fa-3x align-middle" aria-hidden="true"></span>
						</div>
						<div class="col">
							<p class="h5 mt-1 align-middle">Did you know this program is available online?</p>
							<p class="mb-0">Find out more about our fully online program option and connect with our online student specialist now.</p>
						</div>
					</div>
				</a>
			</aside>
			<?php endif; ?>
		</div>
		<div class="col-lg-4 offset-xl-1 mt-4 mt-lg-0">
			<div class="hidden-md-down mb-4">
				<?php echo get_degree_apply_button( $post ); ?>
				<?php echo get_degree_visit_ucf_button(); ?>
			</div>

			<?php if ( isset( $post_meta['degree_hours'] ) && ! empty( $post_meta['degree_hours'] ) ) : ?>
			<div class="degree-hours mb-5 mt-lg-5">
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

<?php
if ( isset( $post_meta['degree_full_width_content_bottom'] ) && ! empty( $post_meta['degree_full_width_content_bottom'] ) ) {
	echo apply_filters( 'the_content', $post_meta['degree_full_width_content_bottom'] );
}
?>

<?php echo get_colleges_grid( $college ); ?>

<?php get_footer(); ?>
