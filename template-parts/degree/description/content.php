<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$description = trim( get_field( 'degree_description', $post ) );

	if ( $description ) :
?>
	<div class="col">
		<?php echo $description; ?>

		<?php
		// TODO conditionally display this only?
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
