<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$has_desc          = true;
	$content_part_name = '';
	$sidebar_part_name = '';
	$catalog_desc      = trim( get_field( 'degree_description', $post ) );
	$curated_desc      = trim( get_field( 'modern_description_copy', $post ) );

	// Assume that if a custom curated program description is
	// available, the 'curated' sidebar should always be used:
	if ( $curated_desc ) {
		$content_part_name = 'curated';
		$sidebar_part_name = 'curated';
	} else if ( ! $catalog_desc ) {
		$has_desc = false;
	}

	if ( $has_desc ):
?>
	<section id="program-description" aria-label="Program description">
		<div class="container">
			<div class="row">
				<?php get_template_part( 'template-parts/degree/description/content', $content_part_name ); ?>
				<?php get_template_part( 'template-parts/degree/description/sidebar', $sidebar_part_name ); ?>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
