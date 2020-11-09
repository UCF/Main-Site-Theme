<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$admission_copy = get_field( 'admission_copy', $post );
	$admission_list = get_field( 'admission_list', $post );

	if ( ! empty( $admission_copy ) && ! empty( $admission_list ) ) :
?>
	<section id="admissions-requirements" aria-labelledby="admissions-requirements-heading">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0">
			<div class="container">
				<h2 id="admissions-requirements-heading" class="font-condensed text-uppercase mb-4 d-flex flex-column flex-md-row align-items-md-end">
					<div class="mb-4 mb-md-0 mr-md-3 text-center text-sm-left">
						<img src="<?php echo THEME_STATIC_URL . '/img/user-check-solid.svg'; ?>" alt="" style="width: 100px; height: auto;">
					</div>
					<span class="d-inline-block">Admission Requirements</span>
				</h2>

				<div class="row">
					<?php if( $admission_copy ) : ?>
					<div class="col-lg">
						<div class="mb-lg-5">
							<?php echo $admission_copy; ?>
						</div>
						<?php
						echo get_degree_request_info_button(
							$post,
							'btn btn-primary hidden-md-down',
							'',
							'Request Information'
						);
						?>
					</div>
					<?php endif; ?>
					<?php if( $admission_list ) : ?>
					<div class="col-lg-6 mt-4 mt-lg-0 pl-lg-5">
						<div class="p-4 bg-secondary" style="font-size: .9em;">
							<?php echo $admission_list; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>

				<div class="text-center hidden-lg-up mt-5">
					<?php echo get_degree_request_info_button( $post ); ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
