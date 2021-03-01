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
		$this->page_num_current = $this->query_vars['paged'];

		$this->archive_data        = $this->get_archive_data();
		$this->endpoint_current    = $this->get_queried_endpoint();
		$this->statements_response = $this->get_statements_response();
		$this->statements_data     = main_site_get_remote_response_json( $this->statements_response, null );

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

		$transient = null;
		$transient_expiration = intval( get_theme_mod_or_default( 'statements_archive_transient_expire' ) );
		if ( $transient_expiration ) {
			$transient = get_transient( 'statements_archive_data' );
		}

		if ( $transient ) {
			$data = $transient;
		} else {
			$data = main_site_get_remote_response_json( $endpoint, null );
			if ( $data && $transient_expiration ) {
				// Store successful data fetch if transients are in use
				set_transient( 'statements_archive_data', $data, $transient_expiration );
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
				global $wp_query;
				$wp_query->set_404();
				status_header( 404 );
				get_template_part( 404 );
				exit();
			}
		}
	}

	/**
 	 * Returns markup for a list of statements.
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
		<ul class="my-4 my-sm-5 list-unstyled">
			<?php
			foreach ( $statements as $statement ) :
				$link     = $statement->link;
				$title    = $statement->title->rendered;
				$author   = $statement->tu_author->fullname ?? '';
				$datetime = $statement->date;
				$date     = date( 'F j, Y', strtotime( $datetime ) );

			?>
			<li class="mb-4 pb-md-2">
				<a href="<?php echo $link; ?>">
					<span class="h5 d-block"><?php echo $title; ?></span>
				</a>

				<?php if ( $author ) : ?>
				<cite class="d-block font-italic">
					<?php echo $author; ?>
				</cite>
				<?php endif; ?>

				<time class="small text-default" datetime="<?php echo $datetime; ?>">
					<?php echo $date; ?>
				</time>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php else : ?>
		<p class="my-4 my-sm-5">No statements found.</p>
		<?php endif; ?>
	<?php
		return trim( ob_get_clean() );
	}


	/**
	 * Returns markup for filtering statements.
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
		<div class="mb-4 mb-lg-5">
			<a href="<?php echo $permalink; ?>">
				<span class="fa fa-chevron-left mr-1" aria-hidden="true"></span>
				All Statements
			</a>
		</div>
		<?php endif; ?>

		<?php if ( ( $years && count( $years ) > 1 ) || ( $authors && count( $authors ) > 1 ) ) : ?>
		<div class="row hidden-lg-up pb-3 align-items-center">
			<div class="col-auto">
				<span class="d-block mb-0 text-default">Filter by:</span>
			</div>
			<div class="col">
				<div class="btn-group" role="group" aria-label="Statement filters">
					<?php if ( $years && count( $years ) > 1 ) : ?>
					<button class="btn btn-default btn-sm" data-toggle="collapse" data-target="#statement-filters-year" aria-expanded="false" aria-controls="statement-filters-year">
						<span class="sr-only">Filter by </span>Year <span class="fa fa-chevron-down" aria-hidden="true"></span>
					</button>
					<?php endif; ?>

					<?php if ( $authors && count( $authors ) > 1 ) : ?>
					<button class="btn btn-default btn-sm" data-toggle="collapse" data-target="#statement-filters-author" aria-expanded="false" aria-controls="statement-filters-author">
						<span class="sr-only">Filter by </span>Author <span class="fa fa-chevron-down" aria-hidden="true"></span>
					</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $years && count( $years ) > 1 ) : ?>
		<div class="collapse d-lg-block mb-lg-5" id="statement-filters-year">
			<h2 class="h6 text-uppercase letter-spacing-3 pt-4 pt-lg-0 mb-4">By Year</h2>
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
		<div class="collapse d-lg-block mb-lg-5" id="statement-filters-author">
			<h2 class="h6 text-uppercase letter-spacing-3 pt-4 pt-lg-0 mb-4">Statements Issued By</h2>
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

		<?php if ( ( $years && count( $years ) > 1 ) || ( $authors && count( $authors ) > 1 ) ) : ?>
		<hr class="mt-4 mb-3 hidden-lg-up" role="presentation">
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
		if ( ! $statements_response ) return '';

		$page_num_previous = $this->page_num_previous;
		$page_num_next     = $this->page_num_next;
		$has_previous      = $page_num_previous ? true : false;
		$has_next          = $page_num_next ? true : false;

		ob_start();
	?>
		<?php if ( $has_previous || $has_next ) : ?>
		<nav aria-label="Statements Pagination">
			<ul class="pagination justify-content-center">
				<?php if ( $has_previous ) : ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo $this->get_statement_pagination_url( $page_num_previous ); ?>">
						<span class="fa fa-chevron-left mr-1" aria-hidden="true"></span>
						Newer<span class="sr-only"> Statements</span>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( $has_next ) : ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo $this->get_statement_pagination_url( $page_num_next ); ?>">
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

	/**
	 * Given a desired page number, returns the current view's
	 * URL with a /page/ path appended to the end.
	 *
	 * This function is necessary as WP doesn't provide this type
	 * of logic out-of-the-box for registered query params.
	 *
	 * @since 3.9.0
	 * @author Jo Dickson
	 * @param int $page Page number that a URL should be generated for
	 * @return string URL for the desired page
	 */
	public function get_statement_pagination_url( $page ) {
		global $wp;
		if ( ! $wp ) return '';

		$url_parts = explode( '/page/', home_url( $wp->request ) );
		$url_base  = isset( $url_parts[0] ) ? $url_parts[0] : '';
		$url       = $page > 1 ? $url_base . '/page/' . $page . '/' : $url_base;

		return $url;
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
		}, 99 );

		// TODO there is probably a better way of doing this, but whatever
		add_filter( 'mainsite_statements_view', function() use( $statements_view ) {
			return $statements_view;
		} );
	}
} );
