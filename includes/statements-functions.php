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

	$archive_data = get_statement_archive_data();
	if ( ! $archive_data || ! property_exists( $archive_data, 'years' ) ) return false;

	if ( in_array(
		$year,
		array_column( $archive_data->years, 'year' )
	) ) {
		return true;
	}
	return false;
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

	$archive_data = get_statement_archive_data();
	if ( ! $archive_data || ! property_exists( $archive_data, 'authors' ) ) return false;

	if ( in_array(
		$author,
		array_column( $archive_data->authors, 'slug' )
	) ) {
		return true;
	}
	return false;
}


/**
 * Returns data for available statement archive endpoints.
 * References transient data, if available.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @return array
 */
function get_statement_archive_data() {
	$endpoint = get_theme_mod( 'statements_archive_endpoint' );
	if ( ! $endpoint ) return array();

	$data = array();

	$transient = get_transient( 'statements_archive_data' );
	if ( $transient ) {
		$data = $transient;
	} else {
		$data = main_site_get_remote_response_json( $endpoint, array() );
		if ( $data ) {
			// Store transient data for 5 minutes (300 seconds)
			// TODO allow transient expiration to be configured
			set_transient( 'statements_archive_data', $data, 300 );
		}
	}

	return $data;
}


/**
 * Returns an array of statements, filtered by year/author
 * if query params are set.
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param array $archive_data Archive data from get_statement_archive_data()
 * @return array
 */
function get_statement_data( $archive_data ) {
	if ( ! $archive_data ) return array();

	$endpoint = $archive_data->all->endpoint ?? '';
	$q_year   = intval( get_query_var( 'by-year' ) );
	$q_author = get_query_var( 'tu_author' );

	if ( $q_year ) {
		foreach ( $archive_data->years as $year ) {
			if ( $q_year === $year->year ) {
				$endpoint = $year->endpoint;
				break;
			}
		}
	} else if ( $q_author ) {
		foreach ( $archive_data->authors as $author ) {
			if ( $q_author === $author->slug ) {
				$endpoint = $author->endpoint;
				break;
			}
		}
	}

	// If we still don't have a valid endpoint by now,
	// back out:
	if ( ! $endpoint ) return array();

	// TODO utilize transients
	return main_site_get_remote_response_json( $endpoint, array() );
}


/**
 * Returns markup for a list of statements. TODO
 *
 * @since 3.9.0
 * @author Jo Dickson
 * @param array $archive_data Archive data from get_statement_archive_data()
 * @return string
 */
function get_statements( $archive_data ) {
	if ( ! $archive_data ) return '';

	$statements = get_statement_data( $archive_data );
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
 * @param array $archive_data Archive data from get_statement_archive_data()
 * @return string
 */
function get_statement_filters( $archive_data ) {
	global $post;
	if ( ! $post ) return '';

	$years   = $archive_data->years ?? array();
	$authors = $archive_data->authors ?? array();

	ob_start();
?>
	<?php if ( $years ) : ?>
	<div class="mb-4 mb-sm-5">
		<h2 class="h6 text-uppercase letter-spacing-3 mb-4">By Year</h2>
		<ul class="nav nav-pills flex-column">
			<?php
			foreach ( $years as $year ) :
				$year_link = get_permalink( $post ) . 'year/' . $year->year . '/';
			?>
			<li class="nav-item">
				<a class="nav-link w-100" href="<?php echo $year_link; ?>">
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
				$author_link = get_permalink( $post ) . 'author/' . $author->slug . '/';
			?>
			<li class="nav-item">
				<a class="nav-link w-100" href="<?php echo $author_link; ?>">
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
