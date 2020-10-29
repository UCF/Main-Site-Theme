<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$online_heading = get_field( 'degree_online_heading', $post );
	$online_copy    = get_field( 'degree_online_copy', $post );
	$online_button  = get_field( 'degree_online_button', $post );
	$online_image   = get_field( 'degree_online_image', $post );

	// Set content column classes based on if an image for the section is set.
	$online_content_col_class = ( $online_image ) ? 'col-12 col-lg-8' : 'col-12';

	// Display nothing if some of the UCF Online fields are empty.
	$display_section = true;
	if ( empty( $online_heading ) || empty( $online_copy ) ) {
		$display_section = false;
	}
	if ( is_array( $online_button ) ) {
		foreach ( $online_button as $button_fields ) {
			if ( empty( $button_fields ) ) {
				$display_section = false;
				break;
			}
		}
	}

	if ( $display_section ) :
?>
	<section id="earn-your-degree-online" aria-label="Earn Your Degree Online">
		<div class="jumbotron jumbotron-fluid bg-primary mb-0 py-lg-5">
			<div class="container">
				<div class="row">
					<div class="<?php echo $online_content_col_class; ?> d-flex flex-column justify-content-center align-items-start">
						<h2 class="mb-3 mb-lg-4"><?php echo $online_heading; ?></h2>
						<p class="degree-online-copy mb-4 pb-lg-2"><?php echo $online_copy; ?></p>
						<a class="btn btn-secondary" href="<?php echo $online_button['button_link']; ?>"><?php echo $online_button['button_text']; ?></a>
					</div>
					<?php if ( $online_image ) : ?>
					<div class="col-lg-4 hidden-md-down d-flex align-items-center justify-content-end">
						<img src="<?php echo $online_image; ?>" class="img-fluid rounded-circle" alt="" aria-hidden="true">
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
