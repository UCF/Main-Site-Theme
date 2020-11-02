<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$app_image     = get_field( 'start_application_image', $post );
	$app_heading   = get_field( 'start_application_heading', $post );
	$app_lead_copy = get_field( 'start_application_lead_copy', $post );
	$app_steps     = get_field( 'start_application_steps', $post );

	// Set content column classes based on if an image for the section is set.
	$app_content_col_class = ( $app_image ) ? 'col-12 col-lg-7' : 'col-12 col-lg-10 offset-lg-1';

	// Display nothing if any of the Application Steps fields are empty.
	$display_section = true;
	if ( is_array( $app_steps ) ) {
		foreach ( $app_steps as $step_field ) {
			if ( empty( $step_field ) ) {
				$display_section = false;
				break;
			}
		}
	} else {
		$display_section = false;
	}

	if ( $display_section ):
?>
	<section id="start-your-application" aria-label="Start Your Application">
		<div class="media-background-container bg-inverse py-lg-5 py-4">
			<img class="media-background object-fit-cover hidden-md-down" src="<?php echo THEME_STATIC_URL . '/img/start-your-application-dark-bg.jpg'; ?>" alt="" aria-hidden="true">
			<div class="container py-lg-3">
				<div class="row">
					<?php if ( $app_image ) : ?>
					<div class="hidden-md-down col-lg-5 pr-lg-5 d-flex align-items-center justify-content-center">
						<img src="<?php echo $app_image; ?>" class="img-fluid rounded-circle" alt="" aria-hidden="true">
					</div>
					<?php endif; ?>
					<div class="<?php echo $app_content_col_class; ?>">
						<h2 class="heading-underline"><?php echo $app_heading; ?></h2>
						<p class="lead mb-lg-4"><?php echo $app_lead_copy; ?></p>
						<div class="row mb-4">
							<div class="col-12 col-lg-6">
								<div class="card start-application-card h-100 mt-3">
									<div class="start-application-card-number font-weight-bold d-inline-flex align-items-center justify-content-center">1</div>
									<div class="card-block text-default text-center">
									<p class="mb-0"><?php echo $app_steps['step_one_copy']; ?></p>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="card start-application-card h-100 mt-3">
									<div class="start-application-card-number font-weight-bold d-inline-flex align-items-center justify-content-center">2</div>
									<div class="card-block text-default text-center">
										<p class="mb-0"><?php echo $app_steps['step_two_copy']; ?></p>
									</div>
									<div class="mb-0">
										<a class="btn btn-primary btn-block" href="<?php echo $app_steps['step_two_button_link']; ?>" target="_blank" rel="noopener"><?php echo $app_steps['step_two_button_text']; ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
