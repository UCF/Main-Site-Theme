<?php
/**
 * Functions specific to degrees
 **/


/**
 * Filter that sets header contents for degrees.
 *
 * @author Jo Dickson
 * @since 3.4.0
 * @param string $markup The passed in markup
 * @param mixed $obj The post/term object, or null
 * @return string The header markup
 */
function get_header_content_degree( $markup, $obj ) {
	if ( isset( $obj->post_type ) && $obj->post_type === 'degree' ) {
		$title                        = get_header_title( $obj );
		$subtitle                     = get_header_subtitle( $obj );
		$h1                           = get_header_h1_option( $obj );
		$title_elem                   = ( $h1 === 'title' ) ? 'h1' : 'span';
		$subtitle_elem                = ( $h1 === 'subtitle' ) ? 'h1' : 'span';
		$degree_template              = get_page_template_slug( $obj );
		$show_degree_request_info_btn = false;
		$custom_template_show_rfi     = ( $degree_template === 'template-degree-custom.php' ) ? get_field( 'degree_custom_enable_rfi', $obj ) : false;
		$header_content_col_classes   = 'header-degree-content-col col-sm-auto d-sm-flex align-items-sm-center';

		if ( $degree_template === 'template-degree-modern.php' || $custom_template_show_rfi ) {
			$header_content_col_classes .= ' ml-sm-auto';
			$show_degree_request_info_btn = true;
		}

		ob_start();

		if ( $title ):
?>
		<div class="header-content-inner">
			<div class="container px-0 h-100">
				<div class="row no-gutters h-100">
					<div class="<?php echo $header_content_col_classes; ?>">
						<div class="header-degree-content-bg bg-primary-t-2 p-3 p-sm-4 mb-sm-5">
							<<?php echo $title_elem; ?> class="header-title header-title-degree"><?php echo $title; ?></<?php echo $title_elem; ?>>

							<?php if ( $subtitle ) : ?>
								<<?php echo $subtitle_elem; ?> class="header-subtitle header-subtitle-degree"><?php echo $subtitle; ?></<?php echo $subtitle_elem; ?>>
							<?php endif; ?>

							<?php
							if ( $show_degree_request_info_btn ) {
								echo get_degree_request_info_button(
									$obj,
									'header-degree-cta btn btn-secondary text-primary hover-text-white d-flex align-items-center my-2 mx-auto mx-sm-2 px-5 py-3',
									'mr-3 fa fa-info-circle fa-2x',
									'Request Info'
								);
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
		endif;

		$markup = ob_get_clean();

	}

	return $markup;
}

add_filter( 'get_header_content_title_subtitle', 'get_header_content_degree', 10, 2 );


/**
 * Returns the child program_type assigned to the given degree.
 *
 * @since 3.1.0
 * @author Jo Dickson
 * @param object $degree  WP_Post object
 * @return mixed  WP_Term object, or null on failure
 */
function get_degree_program_type( $degree ) {
	$retval = null;
	$args   = array( 'childless' => true );
	$terms  = wp_get_post_terms( $degree->ID, 'program_types', $args );

	if ( !empty( $terms ) && ! is_wp_error( $terms ) ) {
		$retval = $terms[0];
	}

	return $retval;
}


/**
 * Returns true|false if program_type is a graduate program.
 *
 * @since 3.3.8
 * @author RJ Bruneel
 * @param object $post  WP_Post object
 * @return boolean
 */
function is_graduate_degree( $post ) {
	$is_graduate = false;
	$terms = wp_get_post_terms( $post->ID, 'program_types' );

	foreach( $terms as $term ) {
		if( $term->slug === "graduate-program" ) {
			$is_graduate = true;
			break;
		}
	}
	return $is_graduate;
}


/**
 * Returns an array of image URLs and alt text for
 * badge graphics to display on degree profiles.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param object $post WP_Post object
 * @return array
 */
function get_degree_badges( $post=null ) {
	$badges = array();

	// Use post-specific badge, if available
	// TODO incorporate 2nd badge field/alt options
	if ( $post ) {
		$post_badge_1     = get_field( 'promo_image', $post );
		$post_badge_1_alt = get_field( 'promo_image_alt', $post );

		if ( $post_badge_1 && $post_badge_1_alt ) {
			$badges[] = array(
				'url' => $post_badge_1,
				'alt' => $post_badge_1_alt
			);
		}
	}

	// Use fallback badge(s) if there were none available
	// for the provided $post
	if ( empty( $badges ) ) {
		$fallback_badge_1     = get_theme_mod( 'degrees_badge_1' );
		$fallback_badge_1_alt = get_theme_mod( 'degrees_badge_1_alt' );
		$fallback_badge_2     = get_theme_mod( 'degrees_badge_2' );
		$fallback_badge_2_alt = get_theme_mod( 'degrees_badge_2_alt' );

		if ( $fallback_badge_1 && $fallback_badge_1_alt ) {
			$badges[] = array(
				'url' => $fallback_badge_1,
				'alt' => $fallback_badge_1_alt
			);
		}
		if ( $fallback_badge_2 && $fallback_badge_2_alt ) {
			$badges[] = array(
				'url' => $fallback_badge_2,
				'alt' => $fallback_badge_2_alt
			);
		}
	}

	return $badges;
}



/**
 * Gets the "Apply Now" button markup for degree.
 *
 * @author Jim Barnes
 * @since 3.0.0
 * @param object $degree | WP_Post object for the degree
 * @param string $btn_classes | CSS classes to apply to the button
 * @param string $icon_classes | CSS classes to apply to the inner icon in the button. Leave empty to omit icon
 * @param string $btn_text | Text to display within the button
 * @return string | The button markup.
 **/
function get_degree_apply_button( $degree, $btn_classes='btn btn-lg btn-block btn-primary', $icon_classes='fa fa-pencil pr-2', $btn_text='Apply Now' ) {
	$apply_url = '';

	$type = get_degree_program_type( $degree );
	if ( ! $type ) { return $apply_url; }
	$type_parent = get_term( $type->parent, 'program_types' );
	$type_parent = ( ! is_wp_error( $type_parent ) && !empty( $type_parent ) ) ? $type_parent : null;

	if ( $type->name === 'Graduate Program' || ( $type_parent && $type_parent->name === 'Graduate Program' ) ) {
		$apply_url = get_theme_mod_or_default( 'degrees_graduate_application' );
	}
	else if ( $type->name === 'Undergraduate Program' || ( $type_parent && $type_parent->name === 'Undergraduate Program' ) ) {
		$apply_url = get_theme_mod_or_default( 'degrees_undergraduate_application' );
	}

	ob_start();

	if ( ! empty( $apply_url ) ):
?>
	<a class="<?php echo $btn_classes; ?>" href="<?php echo $apply_url; ?>">
		<?php if ( $icon_classes ): ?>
		<span class="fa fa-pencil pr-2" aria-hidden="true"></span>
		<?php endif; ?>

		<?php echo $btn_text; ?>
	</a>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Gets the "Request Info" button markup for degrees.
 *
 * @author RJ Bruneel
 * @since 3.4.0
 * @param object $degree | WP_Post object representing a degree
 * @param string $btn_classes | CSS classes to apply to the button
 * @param string $icon_classes | CSS classes to apply to the inner icon in the button. Leave empty to omit icon
 * @param string $btn_text | Text to display within the button
 * @return string | The button markup.
 **/
function get_degree_request_info_button( $degree, $btn_classes='btn btn-primary', $icon_classes='', $btn_text='Request Information' ) {
	$modal = get_degree_request_info_modal( $degree );

	ob_start();

	// Don't render button if the corresponding Request Info
	// modal failed to render correctly:
	if ( $modal ) :
?>
	<button class="<?php echo $btn_classes; ?>" data-toggle="modal" data-target="#requestInfoModal">
		<?php if ( $icon_classes ): ?>
		<span class="<?php echo $icon_classes; ?>" aria-hidden="true"></span>
		<?php endif; ?>

		<?php echo $btn_text; ?>
	</button>
<?php
	endif;
	return trim( ob_get_clean() );
}


/**
 * Returns a complete URL for the graduate RFI form, with
 * optional params.
 *
 * @author Jo Dickson
 * @since 3.4.0
 * @param array $params Assoc. array of query params + values to append to the URL string
 * @return mixed URL string, or null if the URL base or form ID aren't set
 */
function get_degree_request_info_url_graduate( $params=array() ) {
	$base = get_theme_mod_or_default( 'degrees_graduate_rfi_url_base' );
	if ( ! $base ) return null;

	$form_id = get_theme_mod_or_default( 'degrees_graduate_rfi_form_id' );
	if ( ! $form_id ) return null;

	$params['id'] = $form_id;
	$separator = ( strpos( $base, '?' ) !== false ) ? '&' : '?';

	$url = $base . $separator . http_build_query( $params );
	return $url;
}


/**
 * Gets the "Request Info" modal markup for degrees.
 *
 * @author RJ Bruneel
 * @since 3.4.0
 * @param object $degree WP_Post object representing a degree
 * @return string | The modal markup.
 **/
function get_degree_request_info_modal( $degree ) {
	$markup = '';

	// If this isn't a graduate degree, return early.
	//
	// If/when we start supporting undergraduate RFIs, this
	// (and the rest of this function) will have to be adjusted:
	if ( ! is_graduate_degree( $degree ) ) return $markup;

	// Back out early if a GUID isn't assigned to the program.
	$guid = get_field( 'graduate_slate_id', $degree );
	if ( ! $guid ) return '';

	$form_div_id  = 'form_bad6c39a-5c60-4895-9128-5785ce014085';
	$rfi_form_src = get_degree_request_info_url_graduate( array(
		'sys:field:pros_program1' => $guid,
		'output' => 'embed',
		'div' => $form_div_id
	) );

	if ( $rfi_form_src ):
		ob_start();
?>
		<div class="modal fade" id="requestInfoModal" tabindex="-1" role="dialog" aria-labelledby="requestInfoModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header px-4 pt-4">
						<h2 class="h5 modal-title d-flex align-items-center" id="requestInfoModalLabel">
							<span class="fa fa-info-circle fa-2x mr-3" aria-hidden="true"></span>
							Request Information
						</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mb-2 px-4 pb-4">
						<p class="mb-4">
							Enter your information below to receive more information about the <strong><?php echo wptexturize( $degree->post_title ); ?></strong> program offered at UCF.
						</p>
						<div id="<?php echo $form_div_id; ?>">Loading...</div>
						<script>
						/*<![CDATA[*/
						var script = document.createElement('script');
						script.async = 1;
						script.src = '<?php echo $rfi_form_src; ?>' + ((location.search.length > 1) ? '&' + location.search.substring(1) : '');
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(script, s);
						/*]]>*/
						</script>
					</div>
				</div>
			</div>
		</div>
<?php
		$markup = trim( ob_get_clean() );
	endif;

	return $markup;
}


function get_colleges_markup( $post_id ) {
	$colleges = wp_get_post_terms( $post_id, 'colleges' );

	ob_start();
	foreach( $colleges as $college ) :
		$college_url = get_term_link( $college->term_id );
		if ( $college_url ) :
?>
		<a href="<?php echo $college_url; ?>" class="d-block">
		<?php echo $college->name; ?>
		</a>
<?php 	else : ?>
		<span class="d-block">
		<?php echo $college->name; ?>
		</span>
<?php
		endif;
	endforeach;

	return ob_get_clean();
}


function get_departments_markup( $post_id ) {
	$departments = wp_get_post_terms( $post_id, 'departments' );

	ob_start();
	foreach( $departments as $department ) :
		$department_url = get_term_meta( $department->term_id, 'departments_url', true );
		if ( $department_url ) :
?>
		<a href="<?php echo $department_url; ?>" class="d-block">
		<?php echo $department->name; ?>
		</a>
<?php 	else : ?>
		<span class="d-block">
		<?php echo $department->name; ?>
		</span>
<?php
		endif;
	endforeach;

	return ob_get_clean();
}


function get_degree_tuition_markup( $post_meta ) {
	$resident = isset( $post_meta['degree_resident_tuition'] ) ? $post_meta['degree_resident_tuition'] : null;
	$nonresident = isset( $post_meta['degree_nonresident_tuition'] ) ? $post_meta['degree_nonresident_tuition'] : null;
	$skip = ( isset( $post_meta['degree_tuition_skip'] ) && $post_meta['degree_tuition_skip'] === 'on' ) ? true : false;

	if ( $resident && $nonresident && ! $skip ) {
		return ucf_tuition_fees_degree_modern_layout( $resident, $nonresident );
	}

	return '';
}


function ucf_tuition_fees_degree_modern_layout( $resident, $nonresident ) {
	$disclaimer = get_theme_mod( 'tuition_disclaimer', null );

	$nonresident = str_replace( '.00', '', $nonresident );
	$resident    = str_replace( '.00', '', $resident );
	$nonresident_parts = array();
	$resident_parts    = array();

	preg_match( '/^(\$[\d,.]+)/', $nonresident, $nonresident_parts );
	$nonresident_val = $nonresident_parts[1];
	$nonresident_per = trim( str_replace( $nonresident_val, '', $nonresident ) );

	preg_match( '/^(\$[\d,.]+)/', $resident, $resident_parts );
	$resident_val = $resident_parts[1];
	$resident_per = trim( str_replace( $resident_val, '', $resident ) );

	ob_start();
?>
	<div class="card h-100 text-center">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs" id="tuition-tabs" role="tablist">
				<?php if ( $resident ): ?>
				<li class="nav-item text-nowrap">
					<a class="nav-link active" id="resident-tuition-tab" data-toggle="tab" href="#resident-tuition" role="tab" aria-controls="resident-tuition" aria-selected="true">
						In State<span class="sr-only"> Tuition</span>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( $nonresident ): ?>
				<li class="nav-item text-nowrap">
					<a class="nav-link" id="nonresident-tuition-tab" data-toggle="tab" href="#nonresident-tuition" role="tab" aria-controls="nonresident-tuition" aria-selected="false">
						Out of State<span class="sr-only"> Tuition</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="card-block d-flex flex-column justify-content-center px-sm-4 px-md-2 px-xl-3 pt-4 py-md-5 pt-lg-4 pb-lg-3 tab-content" id="tuition-panes">
			<?php if ( $resident ): ?>
			<div class="tab-pane fade show active" id="resident-tuition" role="tabpanel" aria-labelledby="resident-tuition-tab">
				<span class="d-block display-4">
					<?php echo $resident_val; ?>
				</span>
				<span class="d-block small text-uppercase font-weight-bold"> <?php echo $resident_per; ?></span>
			</div>
			<?php endif; ?>

			<?php if ( $nonresident ): ?>
			<div class="tab-pane fade <?php if ( ! $resident ) { ?>show active<?php } ?>" id="nonresident-tuition" role="tabpanel" aria-labelledby="nonresident-tuition-tab">
				<span class="d-block display-4">
					<?php echo $nonresident_val; ?>
				</span>
				<span class="d-block small text-uppercase font-weight-bold"> <?php echo $nonresident_per; ?></span>
			</div>
			<?php endif; ?>

			<?php if ( $disclaimer ) : ?>
			<p class="mt-4 mx-3 mb-0" style="line-height: 1.2;"><small><?php echo $disclaimer; ?></small></p>
			<?php endif; ?>
		</div>
	</div>
<?php
	return ob_get_clean();
}


/**
 * TODO
 *
 * @since TODO
 * @author TODO
 * @param TODO $degree_types TODO
 * @return TODO
 */
function map_degree_types( $degree_types ) {
	$retval = array();

	if ( ! empty( $degree_types ) ) {
		foreach( $degree_types as $degree_type ) {
			$term = get_term_by( 'slug', $degree_type, 'program_types' );

			if ( $term ) {
				$retval[$term->slug] = $term->name;
			}
		}
	}

	return $retval;
}


/**
 * Helper function that returns the catalog description for the given
 * UCF Search Service program object.
 *
 * @since 3.1.0
 * @author Jo Dickson
 * @param object $program  A single program object from the UCF Search Service
 * @return string  The program's catalog description
 */
function get_api_catalog_description( $program ) {
	$retval = '';

	if ( ! class_exists( 'UCF_Degree_Config' ) ) {
		return $retval;
	}

	// Determine the catalog description type's ID
	$description_types = UCF_Degree_Config::get_description_types();
	$catalog_desc_type_id = null;

	if ( $description_types ) {
		foreach ( $description_types as $desc_id => $desc_name ) {
			if ( stripos( $desc_name, 'Catalog Description' ) !== false ) {
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
	$meta['page_header_height'] = 'header-media-default';
	$meta['degree_description'] = get_api_catalog_description( $program );
	$meta['graduate_slate_id']  = $program->graduate_slate_id ?? null;

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
	$careers = main_site_get_remote_response_json( $program->careers, array() );

	$terms['career_paths'] = $careers;

	return $terms;
}

add_filter( 'ucf_degree_get_post_terms', 'mainsite_degree_get_post_terms', 10, 2 );


function main_site_degree_display_subplans( $post_id ) {
	$children = get_children( array(
		'post_parent' => $post_id,
		'post_type'   => 'degree',
		'numberposts' => -1,
		'post_status' => 'publish'
	) );

	if ( $children ) :
?>
	<h3>Related Programs</h3>
	<ul>
	<?php foreach( $children as $child ) : ?>
		<li><a href="<?php echo get_permalink( $child->ID ); ?>"><?php echo $child->post_title; ?></a></li>
	<?php endforeach; ?>
	</ul>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Formats degree meta
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The post_meta array
 * @return array
 */
function main_site_format_degree_data( $post_meta ) {
	setlocale(LC_MONETARY, 'en_US');

	if ( isset( $post_meta['degree_avg_annual_earnings'] ) && ! empty( $post_meta['degree_avg_annual_earnings'] ) ) {
		$post_meta['degree_avg_annual_earnings'] = money_format( '%n', floatval( $post_meta['degree_avg_annual_earnings'] ) );
	}

	if ( isset( $post_meta['degree_employed_full_time'] ) && ! empty( $post_meta['degree_employed_full_time'] ) ) {
		$post_meta['degree_employed_full_time'] = number_format( floatval( $post_meta['degree_employed_full_time'] ) ) . '%';
	}

	if ( isset( $post_meta['degree_continuing_education'] ) && ! empty( $post_meta['degree_continuing_education'] ) ) {
		$post_meta['degree_continuing_education'] = number_format( floatval( $post_meta['degree_continuing_education'] ) ) . '%';
	}

	if ( isset( $post_meta['degree_prj_begin_employment'] ) &&  ! empty( 'degree_prj_begin_employment' ) ) {
		$post_meta['degree_prj_begin_employment'] = number_format( floatval( $post_meta['degree_prj_begin_employment'] ) );
	}

	if ( isset( $post_meta['degree_prj_end_employment'] ) &&  ! empty( $post_meta['degree_prj_end_employment'] ) ) {
		$post_meta['degree_prj_end_employment'] = number_format( floatval( $post_meta['degree_prj_end_employment'] ) );
	}

	if ( isset( $post_meta['degree_prj_change'] ) &&  ! empty( $post_meta['degree_prj_change'] ) ) {
		$post_meta['degree_prj_change'] = number_format( floatval( $post_meta['degree_prj_change'] ) );
	}

	if ( isset( $post_meta['degree_prj_change_percentage'] ) &&  ! empty( $post_meta['degree_prj_change_percentage'] ) ) {
		$post_meta['degree_prj_change_percentage'] = number_format( floatval( $post_meta['degree_prj_change_percentage'] ), 2 ) . '%';
	}

	if ( isset( $post_meta['degree_prj_openings'] ) && ! empty( $post_meta['degree_prj_openings'] ) ) {
		$post_meta['degree_prj_openings'] = number_format( floatval( $post_meta['degree_prj_openings'] ) );
	}

	return $post_meta;
}


/**
 * Formats the outcome data
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The formatted post_meta array
 * @return string
 */
function main_site_outcome_data( $post_meta ) {
	ob_start();
	$keys = array(
		'degree_avg_annual_earnings',
		'degree_employed_full_time'
	);

	$display = isset( $post_meta['degree_display_outcomes'] ) ?
		filter_var( $post_meta['degree_display_outcomes'], FILTER_VALIDATE_BOOLEAN ) :
		false;

	if ( count( array_intersect( array_keys( $post_meta ), $keys ) ) > 0 && $display ) :

		$report_year = isset( $post_meta['degree_outcome_academic_year'] ) ?
			'(per ' . $post_meta['degree_outcome_academic_year'] . ' Data)' :
			'';
?>
	<?php if ( isset( $post_meta['degree_employed_full_time'] ) ) : ?>
	<p>UCF Alumni Working full-time: <?php echo $post_meta['degree_employed_full_time']; ?> <?php echo $report_year; ?></p>
	<?php endif; ?>
	<?php if ( isset( $post_meta['degree_avg_annual_earnings'] ) ) : ?>
	<p>UCF Alumni Average Annual Earnings: <?php echo $post_meta['degree_avg_annual_earnings']; ?> <?php echo $report_year; ?></p>
	<?php endif; ?>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Formats the projection data
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The formatted post_meta array
 * @return string
 */
function main_site_projection_data( $post_meta ) {
	ob_start();

	$keys = array(
		'degree_prj_openings',
		'degree_prj_change'
	);

	$display = isset( $post_meta['degree_display_projections'] ) ?
		filter_var( $post_meta['degree_display_projections'], FILTER_VALIDATE_BOOLEAN ) :
		false;

	if ( count( array_intersect( array_keys( $post_meta ), $keys ) ) > 0 && $display ) :
?>
	<?php if ( isset( $post_meta['degree_prj_begin_year'] ) && isset( $post_meta['degree_prj_end_year'] ) ) : ?>
	<p>Projected <?php echo $post_meta['degree_prj_begin_year']; ?>-<?php echo $post_meta['degree_prj_end_year']; ?>
	<?php endif; ?>
	<?php if ( isset( $post_meta['degree_prj_openings'] ) ) : ?>
	<p>Job Openings: <?php echo $post_meta['degree_prj_openings']; ?></p>
	<?php endif; ?>
	<?php if ( isset( $post_meta['degree_prj_change'] ) ) : ?>
	<p>New Jobs: <?php echo $post_meta['degree_prj_change']; ?>
	<?php endif; ?>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Returns the news shortcode for degrees
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The post meta array
 * @return string
 */
function main_site_degree_news_stories( $post_meta ) {
	ob_start();

	$display = isset( $post_meta['degree_display_news'] ) ?
		filter_var( $post_meta['degree_display_news'], FILTER_VALIDATE_BOOLEAN ) :
		false;

	$tag = isset( $post_meta['degree_news_tag'] ) ? $post_meta['degree_news_tag'] : null;

	if ( $display && ! empty( $tag ) ) :
?>
		[ucf-news-feed topics="<?php echo $tag; ?>"]
<?php
	endif;

	return do_shortcode( ob_get_clean() );
}


/**
 * Returns a list of careers for a degree
 * @author Jim Barnes
 * @since 3.4.0
 * @param int $post_id The post id
 * @return string
 */
function main_site_degree_careers( $post_id, $post_meta ) {
	$display = isset( $post_meta['degree_display_career_paths'] ) ?
		filter_var( $post_meta['degree_display_career_paths'], FILTER_VALIDATE_BOOLEAN )
		: false;

	$terms = wp_get_post_terms(
		$post_id,
		'career_paths'
	);

	shuffle( $terms );

	$terms = array_slice( $terms, 0, 10 );

	usort( $terms, function($a, $b) {
		return strcmp( $a->name, $b->name );
	} );

	ob_start();

	if ( count( $terms ) > 0 && $display ) :
?>
	<h3>Careers</h3>
	<ul>
<?php foreach( $terms as $term ) : ?>
		<li><?php echo $term->name; ?></li>
<?php endforeach; ?>
	</ul>
<?php
	endif;

	return ob_get_clean();
}
