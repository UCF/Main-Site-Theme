<?php get_header(); the_post(); ?>

<?php
	$colleges = wp_get_post_terms( $post->ID, 'colleges' );
	$college  = is_array( $colleges ) ? $colleges[0] : null;

	get_template_part( 'template-parts/degree', 'program_at_a_glance' );
	get_template_part( 'template-parts/degree', 'description' );
	get_template_part( 'template-parts/degree', 'deadlines_apply' );
	get_template_part( 'template-parts/degree', 'start_application' );
	get_template_part( 'template-parts/degree', 'course_overview' );
	get_template_part( 'template-parts/degree', 'quotes' );
	get_template_part( 'template-parts/degree', 'skills_careers' );
	get_template_part( 'template-parts/degree', 'admission_requirements' );
	get_template_part( 'template-parts/degree', 'earn_online' );
	get_template_part( 'template-parts/degree', 'news' );
	get_template_part( 'template-parts/degree', 'breadcrumbs' );

	echo get_colleges_grid( $college );

	if ( is_graduate_degree( $post ) ) {
		echo get_degree_request_info_modal( $post );
	}
?>

<?php get_footer(); ?>
