<?php get_header(); the_post();?>

	<?php
		// Available filters + filter values
		$filters = array();
		$filters['program-type']['name'] = 'Degrees';
		$filters['college']['name'] = 'Colleges';
		$filters['program-type']['terms'] = get_terms( 'program_types', array( 'orderby' => 'count', 'order' => 'desc' ) );
		$filters['college']['terms'] = get_terms( 'colleges', array( 'orderby' => 'count', 'order' => 'desc' ) );

		// Fetch data based on default params + anything set by the user
		$default_params = array(
			'program-type' => array('undergraduate-degree'),
			'college' => array(),
			'sort-by' => 'title',
			'search-query' => ''
		);

		$params = array_merge( $default_params, $_GET );

		$data = get_degree_search_markup(true, $params);
	?>

	<div class="row page-content" id="academics-search" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" <?php if ( !empty( $_GET ) ) { echo 'data-params-onload="true"'; } ?>>

		<form>

			<div class="span12" id="page_title">
				<h1 class="span9"><?php the_title();?></h1>
				<?php esi_include('output_weather_data','span3'); ?>
			</div>

			<div class="span12" id="degree-search-top">

				<?php the_content(); ?>

				<!-- Search input -->

				<div class="degree-search-form">
					<div class="degree-search-form-inner">
						<input id="search-query" type="text" autocomplete="off" data-provide="typeahead" name="search-query" class="span9 search-field" placeholder="Enter a program name or keywords, like 'Aerospace Engineering' or 'Psychology'" value="<?php echo $_GET['search-query']; ?>">
						<button class="btn btn-link" type="submit">Search</button>
					</div>
				</div>

				<!-- Search Result Header -->

				<div class="degree-search-sort clearfix">
					<h2 class="degree-search-sort-inner degree-result-count">
						<span class="degree-result-count-num"><?php echo $data['count']; ?></span> <span class="degree-result-phrase-desktop">degree programs found</span><span class="degree-result-phrase-phone">results</span>
						<?php if ( $params['search-query'] ): ?>
						<span class="for">for:</span> <span class="result"><?php echo htmlspecialchars( $params['search-query'] ); ?></span>
						<?php endif; ?>
					</h2>

					<div class="degree-search-sort-inner degree-search-sort-options hidden-phone">
						<strong class="degree-search-sort-label radio inline">Sort by:</strong>
						<label class="radio inline">
							<input type="radio" name="sort-by" class="sort-by" value="title" <?php if ( $params['sort-by'] == 'title') { echo 'checked'; } ?>> Name
						</label>
						<label class="radio inline">
							<input type="radio" name="sort-by" class="sort-by" value="degree_hours" <?php if ( $params['sort-by'] == 'degree_hours' ) { echo 'checked'; } ?>> Credit Hours
						</label>
					</div>

					<div class="degree-search-sort-inner degree-search-sort-options btn-group visible-phone">
						<a class="btn" id="mobile-filter" href="#">Filter <span class="caret"></span></a>
					</div>
				</div>
			</div>

			<!-- Sidebar (Desktop only) -->

			<div id="degree-search-sidebar" class="span3">
				<div class="visible-phone clearfix degree-mobile-actions">
					<a class="btn btn-default pull-left" id="mobile-filter-reset">Reset All</a>
					<a class="btn btn-primary pull-right" id="mobile-filter-done" href="#">Done</a>
				</div>
				<div class="degree-search-sort visible-phone clearfix">
					<label for="sort-by" class="degree-search-sort-label degree-filter-title pull-left">Sort By</label>
					<select id="sort-by" class="pull-right">
						<option value="degree-name" <?php if ( $sort_by == 'degree-name' ) { echo 'selected'; } ?>>Name</option>
						<option value="credit-hours" <?php if ( $sort_by == 'credit-hours' ) { echo 'selected'; } ?>>Credit Hours</option>
					</select>
				</div>

				<?php foreach ( $filters as $key=>$filter ): ?>
				<h2 class="degree-filter-title"><?php echo $filter['name']; ?></h2>
				<ul class="degree-filter-list">
					<?php foreach ( $filter['terms'] as $term ): ?>
						<?php if ( $term->count > 0 ): ?>
						<li class="checkbox">
							<label>
								<input name="<?php echo $key; ?>[]" class="<?php echo $key; ?>" value="<?php echo $term->slug; ?>" type="checkbox" <?php if ( in_array( $term->slug, $params[$key] ) ) { ?>checked<?php } ?>>
								<span><?php echo $term->name; ?></span>
								<small class="filter-result-count">(<?php echo $term->count; ?>)</small>
							</label>
						</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<?php endforeach; ?>
			</div>

			<!-- Main content col -->

			<div class="span9" id="degree-search-content">
				<article role="main">

					<!-- Search Results -->

					<div class="degree-search-results-container">
						<?php echo $data['markup']; ?>
						<div id="ajax-loading" class="hidden"></div>
					</div>

					<!-- Page Bottom -->

					<hr>

					<p class="more-details">
						For more details and the complete undergraduate catalog, visit: <a href="http://catalog.ucf.edu/" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="<?=addslashes(the_title())?> (footer)">catalog.ucf.edu</a>.
					</p>
					<p class="more-details">
						For graduate programs and courses, visit: <a href="http://www.graduatecatalog.ucf.edu/" class="ga-event" data-ga-action="Undergraduate Catalog link" data-ga-label="<?=addslashes(the_title())?> (footer)">www.graduatecatalog.ucf.edu</a>.
					</p>

				</article>
			</div>

		</form>

	</div>

<?php get_footer(); ?>
