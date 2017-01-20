<?php
if (isset($_GET['json'])) :
	$to_json = get_hiearchical_degree_search_data_json();
	header('Content-Type:application/json');
	echo json_encode($to_json);
else :
get_header(); the_post(); ?>

	<?php
		// Available filters + filter values
		$filters = get_degree_search_filters();
		$params = degree_search_params_or_fallback( null );

		$data = get_degree_search_contents( true, $params );
	?>

	<script>
		var searchSuggestions = <?php echo json_encode( get_degree_search_suggestions() ); ?>;
	</script>

	<div class="row page-content" id="academics-search">

		<form method="GET" id="academics-search-form" action="<?php echo get_permalink( $post->ID ); ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">

			<div class="col-md-12 col-sm-12">
				<div id="page-title">
					<div class="row">
						<div class="col-md-9 col-sm-9">
							<h1><?php the_title(); ?></h1>
						</div>
						<?php esi_include( 'output_weather_data', 'col-md-3 col-sm-3' ); ?>
					</div>
				</div>
			</div>

			<div class="col-md-12 col-sm-12" id="degree-search-top">

				<?php the_content(); ?>

				<noscript>
					<div class="alert alert-danger">
						<strong>Heads up:</strong> This page requires JavaScript to be enabled to work properly.  Please re-enable JavaScript in your browser and reload the page.
					</div>
				</noscript>

				<!-- Search input -->

				<fieldset class="degree-search-form" role="search">
					<legend class="sr-only">Search</legend>
					<div class="degree-search-form-inner col-md-9 col-sm-9">
						<label for="search-query" class="sr-only">Search for a degree program</label>
						<input id="search-query" type="text" autocomplete="off" data-provide="typeahead" name="search-query" class="search-field" placeholder="Enter a program name or keywords, like 'Aerospace Engineering' or 'Psychology'" value="<?php if ( isset( $params['search-query'] ) ) { echo format_search_query( $params['search-query'] ); } ?>">
						<input id="offset" type="hidden"  value="<?php if ( isset( $params['offset'] ) ) { echo $params['offset']; } ?>"
							data-offset-count="<?php echo DEGREE_SEARCH_PAGE_COUNT ?>">
						<input id="search-default" name="search-default" type="hidden" value="<?php if ( $params['default'] == 1 ) { ?>1<?php } else { ?>0<?php } ?>">
						<button class="btn btn-link" type="submit">Search</button>
					</div>
				</fieldset>

				<!-- Search Result Header -->

				<div class="degree-search-sort clearfix">
					<h2 class="degree-search-sort-inner degree-result-count">
						<?php echo get_degree_search_result_phrase( $data['count'], $params ); ?>
					</h2>

					<div class="degree-search-sort-inner degree-search-sort-options hidden-xs">
						<fieldset>
							<legend class="sr-only">Sort Results</legend>
							<strong class="degree-search-sort-label radio-inline">Sort by:</strong>
							<label class="radio-inline">
								<input type="radio" name="sort-by" class="sort-by" value="title" <?php if ( $params['sort-by'] == 'title') { echo 'checked'; } ?>> <span class="sr-only">Sort by </span>Name
							</label>
							<label class="radio-inline">
								<input type="radio" name="sort-by" class="sort-by" value="degree_hours" <?php if ( $params['sort-by'] == 'degree_hours' ) { echo 'checked'; } ?>> <span class="sr-only">Sort by </span>Credit Hours
							</label>
						</fieldset>
					</div>

					<div class="degree-search-sort-inner degree-search-sort-options btn-group visible-xs">
						<a class="btn btn-default" id="mobile-filter" href="#">Filter <span class="caret"></span></a>
					</div>
				</div>
			</div>

			<!-- Main content col -->

			<div class="col-md-9 col-sm-9 pull-right" id="degree-search-content">
				<article role="main">

					<!-- Search Results -->

					<div class="degree-search-results-container">
						<?php echo $data['markup']; ?>
						<div id="ajax-loading" class="hidden"></div>
					</div>

					<!-- Page Bottom -->

					<?php echo get_degree_search_search_again( $filters, $params ); ?>

					<p class="more-details">
						For more details and the complete undergraduate catalog, visit: <a href="<?php echo UNDERGRAD_CATALOG_URL; ?>" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="<?=addslashes(the_title())?> (footer)"><?php echo UNDERGRAD_CATALOG_URL; ?></a>.
					</p>
					<p class="more-details">
						For graduate programs and courses, visit: <a href="<?php echo GRAD_CATALOG_URL; ?>" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="<?=addslashes(the_title())?> (footer)"><?php echo GRAD_CATALOG_URL; ?></a>.
					</p>

				</article>
			</div>

			<!-- Sidebar (Desktop only) -->
			<div id="degree-search-sidebar" class="col-md-3 col-sm-3 pull-left">
				<fieldset>
					<legend class="sr-only">Filter Results</legend>

					<div class="visible-xs clearfix degree-mobile-actions">
						<a class="btn btn-default pull-left" id="mobile-filter-reset">Reset All</a>
						<a class="btn btn-primary pull-right" id="mobile-filter-done" href="#">Done</a>
					</div>
					<div class="degree-search-sort visible-xs clearfix">
						<label for="sort-by" class="degree-search-sort-label degree-filter-title pull-left">Sort By</label>
						<select id="sort-by" class="pull-right form-control">
							<option value="degree-name" <?php if ( $sort_by == 'degree-name' ) { echo 'selected'; } ?>>Name</option>
							<option value="credit-hours" <?php if ( $sort_by == 'credit-hours' ) { echo 'selected'; } ?>>Credit Hours</option>
						</select>
					</div>

					<?php foreach ( $filters as $key=>$filter ): ?>
					<h2 class="degree-filter-title"><?php echo $filter['name']; ?></h2>

					<?php
					$filter_clear_class = 'hidden';
					$params_copy = $params;
					if ( isset( $params_copy[$key] ) ) {
						unset( $params_copy[$key] );
						$filter_clear_class = '';
					}
					$params_copy['default'] = 0;
					$filter_clear_url = get_permalink() . '?' . http_build_query( $params_copy );
					?>
					<a class="degree-filter-clear <?php echo $filter_clear_class; ?>" data-filter-name="<?php echo $key; ?>" data-url-base="<?php echo get_permalink(); ?>" href="<?php echo $filter_clear_url; ?>">Clear All</a>


					<ul class="degree-filter-list">
						<?php foreach ( $filter['terms'] as $term ): ?>
							<?php if ( $term->count > 0 ): ?>
							<li class="<?php echo $term->field_type; ?>">
								<label>
									<input name="<?php echo $key; ?>[]" class="<?php echo $key; ?>" value="<?php echo $term->slug; ?>" type="<?php echo $term->field_type; ?>" <?php if ( isset( $params[$key] ) && in_array( $term->slug, $params[$key] ) ) { ?>checked<?php } ?>>
									<a href="<?php echo get_permalink(); ?>?<?php echo http_build_query( array( $key . '[]' => $term->slug ) ); ?>" class="seo-li" tabindex="-1">
										<span><?php if ( isset( $term->alias ) ) { echo $term->alias; } else { echo $term->name; } ?></span>
										<small class="filter-result-count <?php echo $term->slug; ?>">(<?php echo $term->count; ?><span class="sr-only"> total results</span>)</small>
									</a>
								</label>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php endforeach; ?>
				</fieldset>
			</div>

		</form>

	</div>

<?php get_footer(); endif; ?>
