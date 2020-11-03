<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$description_heading = get_field( 'modern_description_heading', $post );
	$description         = trim( get_field( 'modern_description_copy', $post ) );

	if ( $description ) :
?>
	<div class="col py-lg-3 my-4 my-sm-5">
		<?php if ( $description_heading ) : ?>
		<h2 class="font-weight-light mb-4">
			<?php echo $description_heading; ?>
		</h2>
		<?php endif; ?>

		<?php echo $description; ?>

		<?php
		echo get_degree_request_info_button(
			$post,
			'btn btn-complementary mt-3',
			'',
			'Request Information'
		);
		?>
	</div>
<?php
	endif;
endif;
