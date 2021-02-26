<?php
/**
 * Responsible for statement archive related functionality
 **/

/**
 * Class that manages listings of statements and their
 * filtering options
 */
class Statements_View {

	public $page_path;           // Relative path to the statements page
	public $page;                // WP_Post object for the statements page
	public $page_permalink;      // Permalink to the statements page
	public $query_vars;          // Formatted query vars set on the current view
	public $archive_data;        // JSON data from the statements-archive API endpoint
	public $endpoint_current;    // URL to the current page's API endpoint
	public $statements_response; // Response data from the API endpoint for the current view
	public $statements_data;     // JSON data from the API endpoint for the current view
	public $page_num_current;    // The current view's page number
	public $page_num_total;      // The total number of available pages for this view's set of results
	public $page_num_previous;   // The page number for the previous page's results
	public $page_num_next;       // The page number for the next page's results

	function __construct() {
		$this->page_path      = untrailingslashit( get_theme_mod_or_default( 'statements_page_path' ) );
		$this->page           = $this->page_path ? get_page_by_path( $this->page_path ) : null;
		$this->page_permalink = $this->page ? get_permalink( $this->page ) : '';
	}

	public function setup() {
		$this->query_vars = array(
			'by-year'   => intval( get_query_var( 'by-year' ) ),
			'tu_author' => get_query_var( 'tu_author' ),
			'paged'     => intval( get_query_var( 'paged' ) ) ?: 1
		);

		$this->archive_data        = $this->get_archive_data();
		$this->endpoint_current    = $this->get_queried_endpoint();
		$this->statements_response = $this->get_statements_response();
		$this->statements_data     = main_site_get_remote_response_json( $this->statements_response, null );

		$this->page_num_current  = $this->query_vars['paged'];
		$this->page_num_total    = intval( wp_remote_retrieve_header( $this->statements_response, 'x-wp-totalpages' ) );
		$this->page_num_previous = $this->page_num_current > 1 ? $this->page_num_current - 1 : 0;
		$this->page_num_next     = $this->page_num_current < $this->page_num_total ? $this->page_num_current + 1 : 0;
	}

	/**
	 * Returns data for available statement archive endpoints.
	 * References transient data, if available.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return mixed Object, or null on failure
	 */
	private function get_archive_data() {
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
	 * Returns the URL to the endpoint that provides statement data
	 * for the query params passed to this request.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return string
	 */
	private function get_queried_endpoint() {
		$endpoint = '';
		$q_year   = $this->query_vars['by-year'];
		$q_author = $this->query_vars['tu_author'];
		$q_page   = $this->page_num_current;
		$per_page = intval( get_theme_mod_or_default( 'statements_per_page' ) );

		if ( $q_year ) {
			$year_data = $this->get_year_data( $q_year );
			if ( $year_data ) {
				$endpoint = $year_data->endpoint;
			}
		} else if ( $q_author ) {
			$author_data = $this->get_author_data( $q_author );
			if ( $author_data ) {
				$endpoint = $author_data->endpoint;
			}
		} else {
			$endpoint = $this->archive_data->all->endpoint ?? '';
		}

		// If we still don't have a valid endpoint by now,
		// back out:
		if ( ! $endpoint ) return null;

		// Add per_page param
		if ( $per_page ) {
			$endpoint = add_query_arg(
				'per_page',
				$per_page,
				$endpoint
			);
		}

		// Add page param
		if ( $q_page ) {
			$endpoint = add_query_arg(
				'page',
				$q_page,
				$endpoint
			);
		}

		return $endpoint;
	}

	/**
	 * Returns an array of request data for the statements endpoint on Today,
	 * filtered by year/author if query params are set.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return mixed Array of response data, or null on failure
	 */
	private function get_statements_response() {
		// Give this request a little extra time to return back
		return main_site_get_remote_response( $this->endpoint_current, 10 );
	}

	/**
	 * Returns whether or not query vars set on the current request
	 * result in valid pagination.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return bool
	 */
	public function queried_pagination_is_valid() {
		return $this->page_num_current <= $this->page_num_total;
	}

	/**
	 * Returns whether or not the queried year has
	 * statement data available.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return bool
	 */
	public function queried_year_is_valid() {
		$year = $this->query_vars['by-year'];
		if ( ! $year ) return true; // allow empty

		return $this->get_year_data( $year ) ? true : false;
	}

	/**
	 * Returns whether or not the queried author has
	 * statement data available.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return bool
	 */
	public function queried_author_is_valid() {
		$author = $this->query_vars['tu_author'];
		if ( ! $author ) return true; // allow empty

		return $this->get_author_data( $author ) ? true : false;
	}

	/**
	 * Returns data for the provided year in the statement archive data
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @param string|int $year Year
	 * @return mixed Object with year data, or null if data for $year isn't available
	 */
	public function get_year_data( $year ) {
		$archive_data = $this->archive_data;
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
	public function get_author_data( $author ) {
		$archive_data = $this->archive_data;
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
	 * Returns whether or not the current view has
	 * statement-specific query params set.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return bool
	 */
	function has_filters() {
		return $this->query_vars['by-year'] || $this->query_vars['tu_author'];
	}

	/**
	 * Registers custom rewrite rules to support filtering options
	 * on the statements page without straight query params.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return void
	 */
	public function register_rewrite_rules() {
		$statements_pg_path = $this->page_path;
		$statements_pg      = $this->page;

		if ( $statements_pg && $statements_pg_path ) {
			add_rewrite_rule(
				'^' . $statements_pg_path . '/year/([0-9]{4})(/page/(\d+))?[/]?$',
				'index.php?page_id=' . $statements_pg->ID . '&by-year=$matches[1]&paged=$matches[3]',
				'top'
			);
			add_rewrite_rule(
				'^' . $statements_pg_path . '/author/([a-z0-9_-]+)(/page/(\d+))?[/]?$',
				'index.php?page_id=' . $statements_pg->ID . '&tu_author=$matches[1]&paged=$matches[3]',
				'top'
			);
		}
	}

	/**
	 * Registers query vars for the statements page
	 * so that WP query var functions recognize them.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @param array $query_vars Existing public query vars
	 * @return array Modified query vars
	 */
	public function register_query_vars( $query_vars ) {
		$query_vars[] = 'by-year';
		$query_vars[] = 'tu_author';
		return $query_vars;
	}

	/**
	 * Handles various redirects for loading filtered statement content
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return void
	 */
	public function statement_redirects() {
		$statements_pg = $this->page;

		if ( $statements_pg && is_page( $statements_pg->ID ) ) {
			$should_redirect = false;

			// Redirect requests for /{statements_pg_path}/author/,
			// /{statements_pg_path}/year/, and .../page/X/
			// with bogus/invalid values
			if (
				! $this->queried_year_is_valid()
				|| ! $this->queried_author_is_valid()
				|| ! $this->queried_pagination_is_valid()
			) {
				$should_redirect = true;
			}

			if ( $should_redirect ) {
				// TODO this works for now, but would be nice
				// if these 404'd instead. This hook doesn't
				// appear to fire early enough, and the "Statements"
				// h1 gets printed above the 404 template content.
				wp_redirect( $this->page_permalink );
				exit();
				// global $wp_query;
				// $wp_query->set_404();
				// status_header( 404 );
				// get_template_part( 404 );
				// exit();
			}
		}
	}

	/**
 	 * Returns markup for a list of statements.
	 * TODO styling
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return string
	 */
	public function get_statements_list() {
		$statements = $this->statements_data;

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
	public function get_statement_filters() {
		$archive_data = $this->archive_data;
		if ( ! $archive_data ) return '';

		$years     = $archive_data->years ?? array();
		$authors   = $archive_data->authors ?? array();
		$q_year    = $this->query_vars['by-year'];
		$q_author  = $this->query_vars['tu_author'];
		$permalink = $this->page_permalink;

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

		<?php if ( $years && count( $years ) > 1 ) : ?>
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

		<?php if ( $authors && count( $authors ) > 1 ) : ?>
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
	public function get_statements_details( $unfiltered_fallback='' ) {
		if ( ! $this->has_filters() ) return $unfiltered_fallback;

		$details  = '';
		$q_year   = $this->query_vars['by-year'];
		$q_author = $this->query_vars['tu_author'];

		if ( $q_year ) {
			$details = '<h2 class="mb-4">' . $q_year . '</h2>';
		} else if ( $q_author ) {
			$author_data = $this->get_author_data( $q_author );
			if ( $author_data && property_exists( $author_data, 'name' ) ) {
				$details = '<h2 class="mb-4">' . $author_data->name . '</h2>';
			}
		}

		return $details;
	}


	/**
	 * Returns markup for statement pagination.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @return string
	 */
	public function get_statement_pagination() {
		$statements_response = $this->statements_response;
		global $wp;
		if ( ! $statements_response || ! $wp ) return '';

		$page_num_previous = $this->page_num_previous;
		$page_num_next     = $this->page_num_next;
		$has_previous      = $page_num_previous ? true : false;
		$has_next          = $page_num_next ? true : false;

		// TODO raw ?paged param gets used on the prev/next links;
		// find some elegant way of making pretty urls instead?
		$link_base = home_url( $wp->request );

		ob_start();
	?>
		<?php if ( $has_previous || $has_next ) : ?>
		<nav aria-label="Statements Pagination">
			<ul class="pagination justify-content-center">
				<?php if ( $has_previous ) : ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo add_query_arg( 'paged', $page_num_previous, $link_base ); ?>">
						<span class="fa fa-chevron-left mr-1" aria-hidden="true"></span>
						Newer<span class="sr-only"> Statements</span>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( $has_next ) : ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo add_query_arg( 'paged', $page_num_next, $link_base ); ?>">
						Older<span class="sr-only"> Statements</span>
						<span class="fa fa-chevron-right ml-1" aria-hidden="true"></span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</nav>
		<?php endif; ?>
	<?php
		return trim( ob_get_clean() );
	}

}


$statements_view = new Statements_View();

add_action( 'init', array( $statements_view, 'register_rewrite_rules' ) );
add_filter( 'query_vars', array( $statements_view, 'register_query_vars' ), 10, 1 );

// Only finish initializing view stuff if we're on the Statements page:
add_action( 'wp', function() use( $statements_view ) {
	if ( is_page( $statements_view->page->ID ) ) {
		$statements_view->setup();

		add_action( 'template_redirect', function() use( $statements_view ) {
			$statements_view->statement_redirects();
		}, 999 );

		// TODO there is probably a better way of doing this, but whatever
		add_filter( 'mainsite_statements_view', function() use( $statements_view ) {
			return $statements_view;
		} );
	}
} );
