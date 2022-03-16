<?php

/**
* Displays a list of top degrees for the colleges taxonomy template
* @author RJ Bruneel
* @since 3.0.0
* @param $term object | Object with top degrees
* @return string | Top Degrees List.
**/
function display_top_degrees( $term ) {
	$ret = '';

	$top_degrees = get_field( 'top_degrees', $term );
	if ( $top_degrees ) :
		foreach ( $top_degrees as $top_degree ) :
			// Ensure stale degrees are omitted from this list:
			if ( $top_degree->post_status === 'publish' ):
				$ret .= '<li><a href="' . get_permalink( $top_degree->ID ) . '" class="text-inverse nav-link">' . $top_degree->post_title . '</a></li>';
			endif;
		endforeach;
	endif;

	return $ret;
}


/**
 * Displays a list of custom links to display under
 * top college degrees for the colleges taxonomy template.
 *
 * @author Jo Dickson
 * @since v3.11.1
 * @param $term object WP_Term object for a college
 * @return string HTML string of <li>s
 */
function display_custom_top_degrees( $term ) {
	$retval = '';

	$top_degrees_custom = get_field( 'top_degrees_custom', $term );
	if ( $top_degrees_custom ) :
		foreach ( $top_degrees_custom as $top_degree_custom ) :
			$retval .= '<li><a href="' . $top_degree_custom["top_degree_custom_link"] . '" class="text-inverse nav-link">' . $top_degree_custom["top_degree_custom_text"] . '</a></li>';
		endforeach;
	endif;

	return $retval;
}


/**
 * Returns markup for the colleges grid (without intro text).
 *
 * @author Jo Dickson
 * @since v3.0.5
 * @param obj $exclude_term College term object to exclude from the grid
 * @return string Colleges grid HTML
 */
function get_colleges_grid( $exclude_term=null ) {
	$colleges = get_terms( array( 'taxonomy' => 'colleges', 'hide_empty' => false ) );
	ob_start();

	if ( $colleges ):
?>
<section class="section-colleges" aria-labelledby="colleges-grid-heading">
	<div class="jumbotron jumbotron-fluid bg-primary py-4 my-0 text-center">
		<div class="container">
			<h2 id="colleges-grid-heading" class="section-heading h3 m-0 text-uppercase font-weight-bold font-condensed">University of Central Florida Colleges</h2>
		</div>
	</div>
	<div class="colleges-grid">
		<?php foreach( $colleges as $index=>$college ) :
			if( !$exclude_term || ( $exclude_term && $college->slug !== $exclude_term->slug ) ) :
		?>
			<a class="colleges-block media-background-container text-inverse hover-text-inverse text-decoration-none justify-content-end" href="<?php echo get_term_link( $college ); ?>">
				<img class="media-background object-fit-cover filter-sepia hover-filter-none" src="<?php echo get_field( 'thumbnail_image', 'colleges_' . $college->term_id ); ?>" alt="">
				<span class="colleges-block-text pointer-events-none font-condensed text-uppercase"><?php echo get_field( 'colleges_alias', 'colleges_' . $college->term_id ); ?></span>
			</a>
		<?php
			endif;
		endforeach;
		?>
	</div>
</section>
<?php
	endif;

	return ob_get_clean();
}
