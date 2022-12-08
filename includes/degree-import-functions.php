<?php
/**
 * Functions that specifically override or modify
 * the UCF Degree CPT import process.
 */


/**
 * Helper function that returns a catalog description for the given
 * UCF Search Service program object.
 *
 * @since 3.1.0
 * @author Jo Dickson
 * @param object $program A single program object from the UCF Search Service
 * @param string $description_type The name of the Program Description Type to retrieve
 * @return string The program's catalog description
 */
function get_api_catalog_description( $program, $description_type='Catalog Description' ) {
	$retval = '';

	if ( ! class_exists( 'UCF_Degree_Config' ) ) {
		return $retval;
	}

	// Determine the catalog description type's ID
	$description_types = UCF_Degree_Config::get_description_types();
	$catalog_desc_type_id = null;

	if ( $description_types ) {
		foreach ( $description_types as $desc_id => $desc_name ) {
			if ( strtolower( $desc_name ) === strtolower( $description_type ) ) {
				$catalog_desc_type_id = $desc_id;
				break;
			}
		}
	}

	// Find the program's description by the catalog description type ID
	$descriptions = $program->descriptions;

	if ( !empty( $descriptions ) && $catalog_desc_type_id ) {
		foreach ( $descriptions as $d ) {
			if ( $d->description_type->id === $catalog_desc_type_id ) {
				$retval = $d->description;
			}
		}
	}

	return $retval;
}


/**
 * Apply main site-specific meta data to degrees during the degree import
 * process.
 *
 * @since 3.0.5
 * @author Jo Dickson
 */
function mainsite_degree_format_post_data( $meta, $program ) {
	$meta['degree_hours']            = $program->credit_hours !== '' ? $program->credit_hours : null;
	$meta['page_header_height']      = 'header-media-default';
	$meta['degree_description']      = get_api_catalog_description( $program );
	$meta['degree_description_full'] = get_api_catalog_description( $program, 'Full Catalog Description' );
	$meta['graduate_slate_id']       = $program->graduate_slate_id ?? null;

	$outcomes      = main_site_get_remote_response_json( $program->outcomes );
	$projections   = main_site_get_remote_response_json( $program->projection_totals );
	$deadline_data = main_site_get_remote_response_json( $program->application_deadlines );

	$meta['degree_avg_annual_earnings'] = isset( $outcomes->latest->avg_annual_earnings ) ?
		$outcomes->latest->avg_annual_earnings :
		null;

	$meta['degree_employed_full_time'] = isset( $outcomes->latest->employed_full_time ) ?
		$outcomes->latest->employed_full_time :
		null;

	$meta['degree_continuing_education'] = isset( $outcomes->latest->continuing_education ) ?
		$outcomes->latest->continuing_education :
		null;

	$meta['degree_outcome_academic_year'] = isset( $outcomes->latest->academic_year_display ) ?
		$outcomes->latest->academic_year_display :
		null;

	$meta['degree_prj_begin_year'] = isset( $projections->begin_year ) ?
		$projections->begin_year :
		null;

	$meta['degree_prj_end_year'] = isset( $projections->end_year ) ?
		$projections->end_year :
		null;

	$meta['degree_prj_begin_employment'] = isset( $projections->begin_employment ) ?
		$projections->begin_employment :
		null;

	$meta['degree_prj_end_employment'] = isset( $projections->end_employment ) ?
		$projections->end_employment :
		null;

	$meta['degree_prj_change'] = isset( $projections->change ) ?
		$projections->change :
		null;

	$meta['degree_prj_change_percentage'] = isset( $projections->change_percentage ) ?
		$projections->change_percentage :
		null;

	$meta['degree_prj_openings'] = isset( $projections->openings ) ?
		$projections->openings :
		null;

	$meta['degree_application_deadlines'] = array();
	if ( isset( $deadline_data->application_deadlines ) ) {
		foreach ( $deadline_data->application_deadlines as $deadline ) {
			$meta['degree_application_deadlines'][] = array(
				'admission_term' => $deadline->admission_term,
				'deadline_type'  => $deadline->deadline_type,
				'deadline'       => $deadline->display
			);
		}
	}

	$meta['degree_application_requirements'] = array();
	if ( isset( $deadline_data->application_requirements ) ) {
		foreach ( $deadline_data->application_requirements as $requirement ) {
			$meta['degree_application_requirements'][] = array(
				'requirement' => $requirement
			);
		}
	}

	return $meta;
}

add_filter( 'ucf_degree_get_post_metadata', 'mainsite_degree_format_post_data', 10, 2 );


/**
 * Adds career paths from the career data within the program
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $terms The array of terms to return
 * @param object The program object from the search service
 * @return array
 */
function mainsite_degree_get_post_terms( $terms, $program ) {
	$careers = main_site_get_remote_response_json( "{$program->careers}ranked/", array() );
	$terms['career_paths'] = mainsite_filter_career_paths( $careers );

	return $terms;
}

add_filter( 'ucf_degree_get_post_terms', 'mainsite_degree_get_post_terms', 10, 2 );


/**
 * Filters the careers from the ranked endpoint
 * by weight and limiting to the max number of
 * career paths.
 *
 * @author Jim Barnes
 * @since 3.4.0
 * @param  array $careers The array of career objects from the search service
 * @return array[string] The array of career names
 */
function mainsite_filter_career_paths( $careers ) {
	$threshold = get_theme_mod( 'degrees_careers_weight_threshold' );
	$limit = get_theme_mod( 'degrees_careers_per_program_limit' );
	$retval = array();

	foreach ( $careers as $i => $career ) {
		if ( $career->weight < $threshold || $i === $limit - 1 ) {
			break;
		}

		$retval[] = $career->job;
	}

	return $retval;
}


/**
 * Handles writing the excerpt into the post_excerpt
 * field on the import of degrees.
 *
 * @author Jim Barnes
 * @since 3.11.6
 * @param  array $post_data The post data to be saved
 * @param  UCF_Degree_Import $program The UCF_Degree_Import object
 * @return array The modified post data
 */
function mainsite_degree_formatted_post_data( $post_data, $program ) {
	// Check to see if the excerpt is locked before continuing
	if ( $program->existing_post && get_field( 'degree_lock_excerpt', $program->existing_post->ID ) === true ) {
		return $post_data;
	}

	if ( $program->program->excerpt ) {
		$post_data['post_excerpt'] = $program->program->excerpt;
	}

	return $post_data;
}

add_filter( 'ucf_degree_formatted_post_data', 'mainsite_degree_formatted_post_data', 10, 2 );
