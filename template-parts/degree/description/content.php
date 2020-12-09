<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$description = trim( get_field( 'degree_description', $post ) );

	if ( $description ) :
?>
	<div class="col py-lg-3 my-4 my-sm-5">
		<div class="degree-catalog-description">
			<?php echo $description; ?>
		</div>

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
