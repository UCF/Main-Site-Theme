<?php
/**
 * Responsible for statement archive related functionality
 **/

/**
 * Registers custom rewrite rules to support filtering options
 * on the statements page without straight query params.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return void
 */
function register_statement_rewrite_rules() {
	$statements_pg_path = untrailingslashit( get_theme_mod_or_default( 'statements_page_path' ) );
	if ( ! $statements_pg_path ) return;

	$statements_pg = get_page_by_path( $statements_pg_path );
	if ( $statements_pg ) {
		add_rewrite_rule( '^' . $statements_pg_path . '/year/([0-9]{4})[/]?$', 'index.php?page_id=' . $statements_pg->ID . '&by-year=$matches[1]', 'top' );
		add_rewrite_rule( '^' . $statements_pg_path . '/author/([a-z0-9_-]+)[/]?$', 'index.php?page_id=' . $statements_pg->ID . '&tu_author=$matches[1]', 'top' );
	}
}

add_action( 'init', 'register_statement_rewrite_rules' );


/**
 * Registers query vars for the statements page
 * so that WP query var functions recognize them.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param array $query_vars Existing public query vars
 * @return array Modified query vars
 */
function register_statement_query_vars( $query_vars ) {
	$query_vars[] = 'by-year';
	$query_vars[] = 'tu_author';
	return $query_vars;
}

add_filter( 'query_vars', 'register_statement_query_vars', 10, 1 );


/**
 * Handles various redirects for loading filtered statement content
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return void
 */
function statement_redirects() {
	$statements_pg_path = untrailingslashit( get_theme_mod_or_default( 'statements_page_path' ) );
	if ( ! $statements_pg_path ) return;

	$statements_pg = get_page_by_path( $statements_pg_path );
	if ( $statements_pg && is_page( $statements_pg->ID ) ) {
		$should_redirect = false;
		$year            = get_query_var( 'by-year' );
		$author          = get_query_var( 'tu_author' );

		// Redirect requests for /{statements_pg_path}/author/ and
		// /{statements_pg_path}/year/ with bogus/invalid values
		if (
			( $year && ! statement_year_is_valid( $year ) )
			|| ( $author && ! statement_author_is_valid( $author ) )
		) {
			$should_redirect = true;
		}

		if ( $should_redirect ) {
			// TODO this works for now, but would be nice
			// if these 404'd instead. This hook doesn't
			// appear to fire early enough, and the "Statements"
			// h1 gets printed above the 404 template content.
			wp_redirect( get_permalink( $statements_pg ) );
			exit();
			// global $wp_query;
			// $wp_query->set_404();
			// status_header( 404 );
			// get_template_part( 404 );
			// exit();
		}
	}
}

add_action( 'template_redirect', 'statement_redirects', 999 );


/**
 * Returns whether or not the provided year has
 * statement data available.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param int|string $year A year
 * @return bool
 */
function statement_year_is_valid( $year ) {
	if ( ! $year ) return false;
	$year = intval( $year );

	return get_statement_year_data( $year ) ? true : false;
}


/**
 * Returns whether or not the provided author has
 * statement data available.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param string $author An author slug
 * @return bool
 */
function statement_author_is_valid( $author ) {
	if ( ! $author ) return false;

	return get_statement_author_data( $author ) ? true : false;
}


/**
 * Returns data for available statement archive endpoints.
 * References transient data, if available.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return mixed Object, or null on failure
 */
function get_statement_archive_data() {
	$endpoint = get_theme_mod( 'statements_archive_endpoint' );
	if ( ! $endpoint ) return null;

	$data = null;

	$transient = get_transient( 'statements_archive_data' );
	if ( $transient ) {
		$data = $transient;
	} else {
		$data = main_site_get_remote_response_json( $endpoint, null );
		if ( $data ) {
			// Store transient data for 5 minutes (300 seconds)
			// TODO allow transient expiration to be configured
			set_transient( 'statements_archive_data', $data, 300 );
		}
	}

	return $data;
}


/**
 * Returns data for the provided year in the statement archive data
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param string|int $year Year
 * @return mixed Object with year data, or null if data for $year isn't available
 */
function get_statement_year_data( $year ) {
	$archive_data = get_statement_archive_data();
	if ( ! $year || ! $archive_data || ! property_exists( $archive_data, 'years' ) ) return false;

	$year = intval( $year );
	foreach ( $archive_data->years as $year_data ) {
		if ( $year === $year_data->year ) {
			return $year_data;
			break;
		}
	}
	return null;
}


/**
 * Returns data for the provided author slug in the statement archive data
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param string $author Author slug
 * @return mixed Object with author data, or null if data for $author isn't available
 */
function get_statement_author_data( $author ) {
	$archive_data = get_statement_archive_data();
	if ( ! $author || ! $archive_data || ! property_exists( $archive_data, 'authors' ) ) return false;

	foreach ( $archive_data->authors as $author_data ) {
		if ( $author === $author_data->slug ) {
			return $author_data;
			break;
		}
	}
	return null;
}


/**
 * Returns an array of statements, filtered by year/author
 * if query params are set.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return array
 */
function get_statements() {
	$endpoint = '';
	$q_year   = intval( get_query_var( 'by-year' ) );
	$q_author = get_query_var( 'tu_author' );

	if ( $q_year ) {
		$year_data = get_statement_year_data( $q_year );
		if ( $year_data ) {
			$endpoint = $year_data->endpoint;
		}
	} else if ( $q_author ) {
		$author_data = get_statement_author_data( $q_author );
		if ( $author_data ) {
			$endpoint = $author_data->endpoint;
		}
	} else {
		$archive_data = get_statement_archive_data();
		$endpoint = $archive_data->all->endpoint ?? '';
	}

	// If we still don't have a valid endpoint by now,
	// back out:
	if ( ! $endpoint ) return null;

	// TODO pagination

	return main_site_get_remote_response_json( $endpoint, null );
}


/**
 * Returns markup for a list of statements.
 * TODO styling
 * TODO pagination
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return string
 */
function get_statements_list() {
	$statements = get_statements();
	ob_start();
?>
	<?php if ( $statements ) : ?>
	<ul>
		<?php foreach ( $statements as $statement ) : ?>
		<li>
			<a href="<?php echo $statement->link; ?>">
				<?php echo $statement->title->rendered; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else : ?>
	<p>No statements found.</p>
	<?php endif; ?>
<?php
	return trim( ob_get_clean() );
}


/**
 * Returns markup for filtering statements.
 * TODO add expand/collapse at -xs-md
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return string
 */
function get_statement_filters() {
	global $post;
	$archive_data = get_statement_archive_data();
	if ( ! $archive_data || ! $post ) return '';

	$years     = $archive_data->years ?? array();
	$authors   = $archive_data->authors ?? array();
	$q_year    = intval( get_query_var( 'by-year' ) );
	$q_author  = get_query_var( 'tu_author' );
	$permalink = get_permalink( $post );

	ob_start();
?>
	<?php if ( $q_year || $q_author ) : ?>
	<div class="mb-4 mb-sm-5">
		<a href="<?php echo $permalink; ?>">
			<span class="fa fa-chevron-left mr-1" aria-hidden="true"></span>
			All Statements
		</a>
	</div>
	<?php endif; ?>

	<?php if ( $years ) : ?>
	<div class="mb-4 mb-sm-5">
		<h2 class="h6 text-uppercase letter-spacing-3 mb-4">By Year</h2>
		<ul class="nav nav-pills flex-column">
			<?php
			foreach ( $years as $year ) :
				$year_link = $permalink. 'year/' . $year->year . '/';
				$year_link_class = 'nav-link w-100';
				if ( $q_year === $year->year ) {
					$year_link_class .= ' active';
				}
			?>
			<li class="nav-item">
				<a class="<?php echo $year_link_class; ?>" href="<?php echo $year_link; ?>">
					<?php echo $year->year; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ( $authors ) : ?>
	<div class="mb-4 mb-sm-5">
		<h2 class="h6 text-uppercase letter-spacing-3 mb-4">Statements Issued By</h2>
		<ul class="nav nav-pills flex-column">
			<?php
			foreach ( $authors as $author ) :
				$author_link = $permalink . 'author/' . $author->slug . '/';
				$author_link_class = 'nav-link w-100';
				if ( $q_author === $author->slug ) {
					$author_link_class .= ' active';
				}
			?>
			<li class="nav-item">
				<a class="<?php echo $author_link_class; ?>" href="<?php echo $author_link; ?>">
					<?php echo $author->name; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
<?php
	return trim( ob_get_clean() );
}


/**
 * Returns a subhead with extra details about the statement
 * data being displayed.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param string $unfiltered_fallback Fallback content to return if no filters are present
 * @return string
 */
function get_statement_details( $unfiltered_fallback='' ) {
	if ( ! has_statement_filters() ) return $unfiltered_fallback;

	$details  = '';
	$q_year   = intval( get_query_var( 'by-year' ) );
	$q_author = get_query_var( 'tu_author' );

	if ( $q_year ) {
		$details = '<h2 class="mb-4">' . $q_year . '</h2>';
	} else if ( $q_author ) {
		$author_data = get_statement_author_data( $q_author );
		if ( $author_data && property_exists( $author_data, 'name' ) ) {
			$details = '<h2 class="mb-4">' . $author_data->name . '</h2>';
		}
	}

	return $details;
}


/**
 * Returns whether or not the current view has
 * statement-specific query params set.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return bool
 */
function has_statement_filters() {
	$q_year   = get_query_var( 'by-year' );
	$q_author = get_query_var( 'tu_author' );
	return $q_year || $q_author;
}
