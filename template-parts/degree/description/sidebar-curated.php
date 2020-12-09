<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$description_image     = get_field( 'modern_description_image', $post );
	$description_image_alt = get_field( 'modern_description_image_alt', $post );

	if ( $description_image || have_rows( 'highlights', $post ) ) :
?>
	<div class="col-lg-6 pl-lg-5 py-lg-3 my-5">

		<?php if ( $description_image ) : ?>
		<div class="px-5 px-lg-0 text-center">
			<img src="<?php echo $description_image; ?>" class="img-fluid mb-5" alt="<?php echo $description_image_alt; ?>">
		</div>
		<?php endif; ?>

		<?php if ( have_rows( 'highlights', $post ) ) : ?>
		<h3 class="heading-underline mb-4 pb-2">Highlights</h3>
			<?php
			while ( have_rows( 'highlights', $post ) ) : the_row();
				$highlight_image_data = get_sub_field( 'highlight' );
				$highlight_image      = $highlight_image_data['image'] ?? '';
				$highlight_image_alt  = $highlight_image_data['image_alt_text'] ?? '';
				$highlight_copy       = get_sub_field( 'highlight_copy' );

				if ( $highlight_copy ) :
			?>
				<div class="row mb-4">

					<?php if ( $highlight_image ) : ?>
					<div class="col-3 text-center">
						<img src="<?php echo $highlight_image; ?>" class="img-fluid" alt="<?php echo $highlight_image_alt; ?>">
					</div>
					<?php endif; ?>

					<div class="col-9 align-self-center">
						<?php echo $highlight_copy; ?>
					</div>

				</div>
			<?php
				endif;
			endwhile;
			?>
		<?php endif; ?>

	</div>
<?php
	endif;
endif;
