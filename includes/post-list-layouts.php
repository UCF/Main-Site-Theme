<?php
/**
 * Registers custom post list layouts for this theme
 */
function mainsite_get_post_list_layouts( $layouts ) {
	$layouts['location'] = 'Locations';
	$layouts['faculty_search'] = 'Faculty Search';

	if ( class_exists( 'UCF_People_PostType' ) ) {
		$layouts['people'] = 'People Layout';
	}

	return $layouts;
}

add_filter( 'ucf_post_list_get_layouts', 'mainsite_get_post_list_layouts', 10, 1 );


/**
 * Modifications to post list arguments per layout for this theme
 */

function mainsite_post_list_sc_atts( $sc_atts, $layout ) {
	if ( $layout === 'faculty_search' ) {
		// force get_posts() to return nothing (since this layout
		// returns REST endpoint results)
		$sc_atts['post_type']      = 'idontexist';
		$sc_atts['display_search'] = true; // this layout always returns a typeahead
	}

	return $sc_atts;
}

add_filter( 'ucf_post_list_get_sc_atts' , 'mainsite_post_list_sc_atts', 10, 2 );


/**
 * Modifies class names used in post list searches
 * per layout in this theme
 */
function mainsite_post_list_search_classnames( $classnames, $posts, $atts ) {
	if ( ! $atts['layout'] === 'location' ) return $classnames;

	ob_start();
?>
	{
		input: 'form-control mb-4 form-control-search'
	}
<?php
	$classnames = ob_get_clean();

	return $classnames;
}

add_filter( 'ucf_post_list_search_classnames', 'mainsite_post_list_search_classnames', 10, 3 );


/**
 * Modifies the post list search script printed per layout
 * in this theme.
 *
 * NOTE: The "faculty_search" layout does not utilize typeahead settings
 * passed in from UCF Post List SC filters, and overriding of settings
 * with the `ucf_post_list_search_localdata`, `ucf_post_list_search_classnames`
 * `ucf_post_list_search_limit` and `ucf_post_list_search_templates` hooks are
 * not supported.
 */
function mainsite_post_list_search_script( $content, $posts, $atts, $typeahead_settings ) {
	if ( $atts['layout'] === 'faculty_search' ) {
		// Generate inline script that initializes the search typeahead:
		ob_start();
	?>
		(function($) {
			$('.faculty-search[data-id="post-list-<?php echo $atts['list_id']; ?>"] .typeahead')
				.MainSiteFacultySearch({});
		}(jQuery));
	<?php
		$post_list_search_settings = trim( ob_get_clean() );

		// Enqueue inline init script:
		wp_add_inline_script( 'mainsite-faculty-search', $post_list_search_settings );

		// Enqueue post list JS:
		wp_enqueue_script( 'mainsite-faculty-search' );
	}

	return $content;
}

add_filter( 'ucf_post_list_search_script', 'mainsite_post_list_search_script', 10, 4 );


/**
 * Custom post list layout for displaying a
 * searchable list of locations
 */

if ( ! function_exists( 'ucf_post_list_display_location_before' ) ) {
	function mainsite_list_display_location_before( $content, $posts, $atts ) {
		ob_start();
	?>
		<div class="ucf-post-list card-layout locations-search" id="post-list-<?php echo $atts['list_id']; ?>">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_location_before', 'mainsite_list_display_location_before', 10, 3 );
}

if ( !function_exists( 'ucf_post_list_display_location_title' ) ) {
	function mainsite_list_display_location_title( $content, $posts, $atts ) {
		$formatted_title = '';

		if ( $list_title = $atts['list_title'] ) {
			$formatted_title = '<h2 class="ucf-post-list-title">' . $list_title . '</h2>';
		}

		return $formatted_title;
	}

	add_filter( 'ucf_post_list_display_location_title', 'mainsite_list_display_location_title', 10, 3 );
}

if ( ! function_exists( 'ucf_post_list_display_location' ) ) {
	function mainsite_list_display_location( $content, $posts, $atts ) {
		if ( $posts && ! is_array( $posts ) ) { $posts = array( $posts ); }
		ob_start();
?>
		<?php if ( $posts ): ?>
			<?php
			foreach( $posts as $index=>$item ) :
				$address = get_field( 'ucf_location_address', $item->ID );
			?>
				<div class="ucf-post-list-location-item">
					<div class="row">
						<div class="col-sm-4">
							<a class="ucf-post-list-card-link" href="<?php echo get_permalink( $item->ID ); ?>">
								<h3 class="ucf-post-list-location-title"><?php echo $item->post_title; ?></h3>
							</a>
						</div>
						<div class="col-md-8">
							<?php if ( $address ) : ?>
							<p class="ucf-post-list-location-text"><?php echo $address; ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<div class="ucf-post-list-error">No results found.</div>
		<?php endif;

		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_location', 'mainsite_list_display_location', 10, 3 );
}

if ( ! function_exists( 'ucf_post_list_display_location_after' ) ) {
	function mainsite_list_display_location_after( $content, $posts, $atts ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_location_after', 'mainsite_list_display_location_after', 10, 3 );
}


/**
 * Custom post list layout for displaying a faculty typeahead,
 * which directs search queries to our designated Faculty Search page
 */

if ( ! function_exists( 'ucf_post_list_display_faculty_search_before' ) ) {
	add_filter( 'ucf_post_list_display_faculty_search_before', '__return_empty_string', 10, 3 );
}

if ( ! function_exists( 'ucf_post_list_display_faculty_search_title' ) ) {
	add_filter( 'ucf_post_list_display_faculty_search_title', '__return_empty_string', 10, 3 );
}

if ( ! function_exists( 'ucf_post_list_display_faculty_search' ) ) {
	add_filter( 'ucf_post_list_display_faculty_search', '__return_empty_string', 10, 3 );
}

if ( ! function_exists( 'ucf_post_list_display_faculty_search_after' ) ) {
	add_filter( 'ucf_post_list_display_faculty_search_after', '__return_empty_string', 10, 3 );
}

function mainsite_post_list_search( $content, $posts, $atts ) {
	if ( $atts['layout'] !== 'faculty_search' ) return $content;

	$current_queried_obj = get_queried_object();
	$faculty_search_url  = get_faculty_search_page_url();
	// If we're on the Faculty Search pg, allow the current `query` param
	// to populate into the typeahead <input> by default:
	$query = (
		isset( $_GET['query'] )
		&& $current_queried_obj
		&& $faculty_search_url
		&& get_permalink( $current_queried_obj ) === $faculty_search_url
	) ? sanitize_text_field( $_GET['query'] ) : '';

	ob_start();
?>
	<form class="faculty-search" action="<?php echo $faculty_search_url; ?>" data-id="post-list-<?php echo $atts['list_id']; ?>">
		<div class="input-group">
			<input
				aria-label="Search faculty members"
				type="text"
				name="query"
				class="typeahead faculty-search-typeahead form-control"
				value="<?php echo stripslashes( htmlentities( $query ) ); ?>"
				placeholder="<?php echo $atts['search_placeholder']; ?>"
			>
			<button class="btn btn-primary d-md-flex" type="submit">
				<span class="fa fa-search mr-md-2" aria-hidden="true"></span>
				<span class="sr-only hidden-md-up">Search</span>
				<span class="hidden-sm-down">Search</span>
			</button>
		</div>
	</form>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_post_list_search', 'mainsite_post_list_search', 10, 3 );

/**
 * Add custom people list layout for UCF Post List shortcode
 *
 * @since 3.27.0
 **/
if ( class_exists( 'UCF_People_PostType' ) ) {
	function mainsite_post_list_display_people_before( $content, $items, $atts ) {
		ob_start();
	?>
	<div class="ucf-post-list ucfwp-post-list-people">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_people_before', 'mainsite_post_list_display_people_before', 10, 3 );

	function mainsite_post_list_display_people_title( $content, $items, $atts ) {
		$formatted_title = '';
		if ( $atts['list_title'] ) {
			$formatted_title = '<h2 class="ucf-post-list-title">' . $atts['list_title'] . '</h2>';
		}
		return $formatted_title;
	}

	add_filter( 'ucf_post_list_display_people_title', 'mainsite_post_list_display_people_title', 10, 3 );


	function ucfwp_post_list_display_people( $content, $items, $atts ) {
		if ( ! is_array( $items ) && $items !== false ) { $items = array( $items ); }

		$fa_version = get_theme_mod( 'font_awesome_version' );
		$fa_email_icon = '';
		$fa_phone_icon = '';
		switch ( $fa_version ) {
			case 'none':
				break;
			case '5':
				$fa_email_icon = 'fas fa-envelope fa-fw mr-1';
				$fa_phone_icon = 'fas fa-phone fa-fw mr-1';
				break;
			case '4':
			default:
				$fa_email_icon = 'fa fa-envelope fa-fw mr-1';
				$fa_phone_icon = 'fa fa-phone fa-fw mr-1';
				break;
		}

		ob_start();
	?>
		<?php if ( $items ): ?>
		<ul class="list-unstyled row ucf-post-list-items">
			<?php
			foreach ( $items as $item ):
				$is_content_empty = empty( $item->post_content );
			?>
			<li class="col-6 col-sm-4 col-md-3 col-xl-2 mt-3 mb-2 ucf-post-list-item">

				<?php if ( ! $is_content_empty ): ?>
				<a class="person-link" href="<?php echo get_permalink( $item->ID ); ?>">
				<?php endif; ?>

					<?php echo get_person_thumbnail( $item, 'thumbnail', array() ); ?>

					<strong class="my-2 d-block person-name">
						<?php echo mainsite_get_person_name( $item ); ?>
					</strong>

					<?php if ( $job_title = get_field( 'person_jobtitle', $item->ID ) ): ?>
					<div class="mb-2 font-italic person-job-title">
						<?php echo $job_title; ?>
					</div>
					<?php endif; ?>

				<?php if ( ! $is_content_empty ): ?>
				</a>
				<?php endif; ?>

				<?php
				if ( $email = get_field( 'person_email', $item->ID ) ):

				?>
				<div class="person-email">
					<a href="mailto:<?php echo $email; ?>">
						<?php if ( $fa_email_icon ): ?><span class="<?php echo $fa_email_icon; ?>" aria-hidden="true"></span><?php endif; ?>Email
						<span class="sr-only"> <?php echo $email; ?></span>
					</a>
				</div>
				<?php endif; ?>

				<?php if ( $phone = get_field( 'person_phone', $item->ID ) ): ?>
				<div class="person-phone">
					<?php if ( $fa_phone_icon ): ?><span class="<?php echo $fa_phone_icon; ?>" aria-hidden="true"></span><?php endif; ?><?php echo $phone; ?>
				</div>
				<?php endif; ?>

			</li>
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<div class="ucf-post-list-error mb-4">No results found.</div>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_people', 'ucfwp_post_list_display_people', 10, 3 );


	function ucfwp_post_list_display_people_after( $content, $items, $atts ) {
		ob_start();
	?>
	</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_people_after', 'ucfwp_post_list_display_people_after', 10, 3 );
}
