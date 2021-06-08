<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$section_id = get_field( 'person_promo_section', $post ) ?: get_theme_mod( 'faculty_fallback_promo' );

	if ( $section_id ) :
		echo do_shortcode( "[ucf-section id='$section_id']" );
	endif;
endif;
