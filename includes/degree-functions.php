<?php
/**
 * General functions related to the display of degrees and their data
 */


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

	foreach ( $terms as $term ) {
		if ( $term->slug === 'graduate-program' ) {
			$is_graduate = true;
			break;
		}
	}
	return $is_graduate;
}


/**
 * Returns true/false if the given degree $post is
 * an undergraduate program.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param object $post  WP_Post object
 * @return boolean
 */
function is_undergraduate_degree( $post ) {
	$is_undergraduate = false;
	$terms = wp_get_post_terms( $post->ID, 'program_types' );

	foreach ( $terms as $term ) {
		if ( $term->slug === 'undergraduate-program' ) {
			$is_undergraduate = true;
			break;
		}
	}
	return $is_undergraduate;
}


/**
 * Returns true/false if the given degree $post represents
 * a program that cannot be completed on its own (must be
 * completed alongside a full program.)
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param object $post WP_Post object representing a degree post
 * @return boolean
 */
function is_supplementary_degree( $post ) {
	$is_supplementary = false;
	$terms = wp_get_post_terms( $post->ID, 'program_types' );

	foreach ( $terms as $term ) {
		if ( in_array( $term->slug, array( 'minor', 'undergraduate-certificate' ) ) ) {
			$is_supplementary = true;
			break;
		}
	}


	return $is_supplementary;
}


/**
 * Returns whether or not a given degree $post can and
 * should display a RFI modal and calls-to-action.
 *
 * If/when we start supporting undergraduate RFIs, this
 * function will have to be adjusted.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param object $post WP_Post object
 * @return boolean
 */
function degree_show_rfi( $post ) {
	$show_rfi = false;

	if (
		$post->post_type === 'degree'
		&& is_graduate_degree( $post )
		&& get_field( 'degree_custom_enable_rfi', $post ) === true
	) {
		$guid              = get_field( 'graduate_slate_id', $post );
		$rfi_form_src_base = get_degree_request_info_url_graduate();

		if ( $guid && $rfi_form_src_base ) {
			$show_rfi = true;
		}
	}

	return $show_rfi;
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
	if ( $post ) {
		$post_badge_1     = get_field( 'promo', $post );
		$post_badge_1_img = $post_badge_1['image'] ?? '';
		$post_badge_1_alt = $post_badge_1['image_alt'] ?? '';

		$post_badge_2     = get_field( 'promo_2', $post );
		$post_badge_2_img = $post_badge_2['image'] ?? '';
		$post_badge_2_alt = $post_badge_2['image_alt'] ?? '';

		if ( $post_badge_1 && $post_badge_1_alt ) {
			$badges[] = array(
				'img'        => $post_badge_1_img,
				'alt'        => $post_badge_1_alt,
				'link_url'   => $post_badge_1['link_url'] ?? '',
				'link_rel'   => $post_badge_1['link_rel'] ?? '',
				'new_window' => $post_badge_1['link_new_window'] ?? false
			);
		}
		if ( $post_badge_2 && $post_badge_2_alt ) {
			$badges[] = array(
				'img'        => $post_badge_2_img,
				'alt'        => $post_badge_2_alt,
				'link_url'   => $post_badge_2['link_url'] ?? '',
				'link_rel'   => $post_badge_2['link_rel'] ?? '',
				'new_window' => $post_badge_2['link_new_window'] ?? false
			);
		}
	}

	// Use fallback badge(s) if there were none available
	// for the provided $post
	if ( empty( $badges ) ) {
		$fallback_badge_1_img = get_theme_mod( 'degrees_badge_1' );
		$fallback_badge_1_alt = get_theme_mod( 'degrees_badge_1_alt' );
		$fallback_badge_2_img = get_theme_mod( 'degrees_badge_2' );
		$fallback_badge_2_alt = get_theme_mod( 'degrees_badge_2_alt' );

		if ( $fallback_badge_1_img && $fallback_badge_1_alt ) {
			$badges[] = array(
				'img'        => $fallback_badge_1_img,
				'alt'        => $fallback_badge_1_alt,
				'link_url'   => get_theme_mod( 'degrees_badge_1_link_url', '' ),
				'link_rel'   => get_theme_mod( 'degrees_badge_1_link_rel', '' ),
				'new_window' => get_theme_mod( 'degrees_badge_1_link_new_window', false ),
			);
		}
		if ( $fallback_badge_2_img && $fallback_badge_2_alt ) {
			$badges[] = array(
				'img'        => $fallback_badge_2_img,
				'alt'        => $fallback_badge_2_alt,
				'link_url'   => get_theme_mod( 'degrees_badge_2_link_url', '' ),
				'link_rel'   => get_theme_mod( 'degrees_badge_2_link_rel', '' ),
				'new_window' => get_theme_mod( 'degrees_badge_2_link_new_window', false ),
			);
		}
	}

	return $badges;
}


/**
 * Returns details for a promotional graphic to display
 * alongside degree catalog descriptions.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param object $post WP_Post object
 * @return array
 */
function get_degree_promo( $post ) {
	$promo               = array();
	$disable_promo       = get_field( 'degree_disable_sidebar_promo', $post ) ?: false;
	$theme_mod_name_base = '';
	$promo_img           = null;

	if ( ! $disable_promo ) {
		if ( is_graduate_degree( $post ) ) {
			$theme_mod_name_base = 'degrees_sidebar_promo_graduate';
		} else if ( is_undergraduate_degree( $post ) ) {
			$theme_mod_name_base = 'degrees_sidebar_promo_undergraduate';
		}
	}

	if ( $theme_mod_name_base ) {
		$promo_img = get_theme_mod( $theme_mod_name_base );
	}

	if ( $promo_img ) {
		$promo = array(
			'img'        => $promo_img,
			'alt'        => get_theme_mod( $theme_mod_name_base . '_alt', '' ),
			'link_url'   => get_theme_mod( $theme_mod_name_base . '_link_url', '' ),
			'link_rel'   => get_theme_mod( $theme_mod_name_base . '_link_rel', '' ),
			'new_window' => get_theme_mod( $theme_mod_name_base . '_link_new_window', false ),
		);
	}

	return $promo;
}


/**
 * Returns an array of deadlines, grouped by deadline type
 * (e.g. domestic/transfer/international).
 *
 * If custom application deadlines are defined, they are
 * returned instead in an unnamed group.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param object $post WP_Post object
 * @return array
 */
function get_degree_application_deadlines( $post ) {
	$deadlines = array();

	if ( have_rows( 'application_deadlines', $post ) ) {
		// Custom deadlines
		$custom_deadlines = get_field( 'application_deadlines', $post );
		foreach ( $custom_deadlines as $deadline ) {
			$deadlines[''][] = array(
				'term'     => $deadline['deadline_term'],
				'deadline' => $deadline['deadline']
			);
		}
	} else if ( have_rows( 'degree_application_deadlines', $post ) ) {
		// If a deadline group order is defined, use it:
		$group_order = array();
		if ( is_undergraduate_degree( $post ) ) {
			$group_order = array_filter( array_map( 'trim', explode( ',', get_theme_mod_or_default( 'degree_deadlines_undergraduate_deadline_order' ) ) ) );
		} else if ( is_graduate_degree( $post ) ) {
			$group_order = array_filter( array_map( 'trim', explode( ',', get_theme_mod_or_default( 'degree_deadlines_graduate_deadline_order' ) ) ) );
		}

		if ( $group_order ) {
			$deadlines = array_fill_keys( $group_order, array() );
		}

		// Assign imported deadlines to groups:
		$imported_deadlines = get_field( 'degree_application_deadlines', $post );
		foreach ( $imported_deadlines as $deadline ) {
			if (
				isset( $deadline['deadline_type'] )
				&& isset( $deadline['admission_term'] )
				&& isset( $deadline['deadline'] )
			) {
				$deadlines[$deadline['deadline_type']][] = array(
					'term'     => $deadline['admission_term'],
					'deadline' => $deadline['deadline']
				);
			}
		}

		// If $group_order contains an invalid group name, make sure
		// it doesn't generate an empty set of deadlines:
		$deadlines = array_filter( $deadlines );
	}

	return $deadlines;
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
function get_degree_apply_button( $degree, $btn_classes='btn btn-lg btn-block btn-primary', $icon_classes='fa fa-pencil pr-2', $btn_text='Apply Today' ) {
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
		<span class="<?php echo $icon_classes; ?>" aria-hidden="true"></span>
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
	$show_rfi = degree_show_rfi( $degree );

	ob_start();

	// Don't render button if RFIs can't be displayed for this degree:
	if ( $show_rfi ) :
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
 * Splits a provided tuition string into two parts:
 * the tuition value, and "per" string (e.g. per credit hour).
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param string $tuition_val
 * @return array
 */
function get_degree_tuition_parts( $tuition ) {
	if ( ! $tuition ) return array();

	$tuition       = str_replace( '.00', '', $tuition );
	$tuition_parts = array();

	preg_match( '/^(\$[\d,.]+)/', $tuition, $tuition_parts );

	$tuition_val = $tuition_parts[1] ?? '';
	$tuition_per = trim( str_replace( $tuition_val, '', $tuition ) );

	return array(
		'value' => $tuition_val,
		'per'   => $tuition_per
	);
}


/**
 * Returns an associative array of degree types available under
 * a college, using a slug=>name structure.
 *
 * @since 3.0.1
 * @author Jim Barnes
 * @param array $degree_types An array of available degree types
 *              for a college (via `degree_types_available` meta)
 * @return array Formatted list of degree types
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
 * Returns an array of career paths assigned to a degree.
 * Results are limited to a fixed amount and are randomized.
 *
 * @author Jim Barnes
 * @since 3.4.0
 * @param object $post WP_Post object
 * @return array
 */
function main_site_get_degree_careers( $post, $limit=20 ) {
	$careers = array();
	$terms   = array();

	if ( have_rows( 'degree_career_list', $post ) ) {
		while ( have_rows( 'degree_career_list', $post ) ) : the_row();
			$careers[] = trim( get_sub_field( 'degree_career_list_item' ) );
		endwhile;

		$careers = array_filter( $careers );
	}

	if ( ! $careers ) {
		$terms = wp_get_post_terms(
			$post->ID,
			'career_paths',
			array(
				'fields' => 'id=>name'
			)
		);

		if ( ! is_wp_error( $terms ) ) {
			shuffle( $terms );

			if ( $limit > 0 ) {
				$terms = array_slice( $terms, 0, $limit );
			}

			usort( $terms, function( $a, $b ) {
				return strcmp( $a, $b );
			} );

			$careers = $terms;
		}
	}

	return $careers;
}
