<?php
/**
 * Responsible for college taxonomy related functionality
 **/

/**
 * Displays a list of top degrees
 * @author RJ Bruneel
 * @since 3.0.0
 * @param $term object | Object with top degrees
 * @return string | Top Degrees List.
 **/
function display_top_degrees( $term ) {
	$ret = "";
	$top_degrees = get_field( 'top_degrees', 'colleges_' . $term->term_id );
	if( $top_degrees ) :
		foreach( $top_degrees as $top_degree ) :
			$ret .= '<li><a href="' . $top_degree->post_name . '" class="text-inverse">' . $top_degree->post_title . '</a></li>';
		endforeach;
	endif;
	return $ret;
}

/**
 * Displays news title
 * @author RJ Bruneel
 * @since 3.0.0
 * @param $term object | Object with title content
 * @return string | News Title.
 **/
function display_news_title( $term ) {
	if( $news_title = get_field( 'news_title', 'colleges_' . $term->term_id ) ) {
		return $news_title . " News";
	} else {
		return str_replace( 'College of ', '', $term->name ) . " News";
	}
}

/**
 * Displays section content
 * @author RJ Bruneel
 * @since 3.0.0
 * @param $section_id int | ID of the section
 * @param $content string | Section content
 * @return string | Section content surrounded by jumbotron if wrapper option checked.
 **/
function display_section( $section_id, $content ) {
	$ret = "";
	// open section container
	if( get_field( 'section_add_content_container', $section_id ) ) :
		$class = "";
		$style = "";
		if( get_field( 'section_background_color', $section_id ) !== 'custom' ) {
			$class = get_field( 'section_background_color', $section_id );
		} else if ( get_field( 'section_background_color_custom', $section_id ) ) {
			$style = "background-color:" . get_field( 'section_background_color_custom', $section_id ) . ";";
		}
		if( get_field( 'section_text_color', $section_id ) !== 'custom' ) {
			$class .= ' ' . get_field( 'section_text_color', $section_id );
		} else if ( get_field( 'section_text_color_custom', $section_id ) ) {
			$style .= "color:" . get_field( 'section_text_color_custom', $section_id ) . ";";
		}
		$ret .= '<div class="jumbotron jumbotron-fluid ' . $class . ' py-4 my-0 text-center" style="' . $style . '">';
	endif;
	// display section content
	$ret .= $content;
	// close section container
	if ( get_field( 'section_add_content_container', $section_id ) ) {
		$ret .= '</div>';
	}
	return $ret;
}
?>
