<?php get_header(); the_post();?>

	<?php
		// Available filters + filter values
		$filters = array(
			'program-type' => array(
				'name' => 'Degrees',
				'has_default' => true,
				'options' => array(
					'undergraduate-degree' => array(
						'name' => 'Undergraduate Degrees',
						'count' => '135',
						'default' => true
					),
					'minor' => array(
						'name' => 'Minors',
						'count' => '128',
						'default' => false
					),
					'graduate-degree' => array(
						'name' => 'Graduate Degrees',
						'count' => '104',
						'default' => false
					),
					'certificate' => array(
						'name' => 'Certificate',
						'count' => '92',
						'default' => false
					)
				),
			),
			'college' => array(
				'name' => 'Colleges',
				'has_default' => false,
				'options' => array(
					'college-of-arts-and-humanities' => array(
						'name' => 'College of Arts and Humanities',
						'count' => '82',
						'default' => false
					),
					'college-of-business-administration' => array(
						'name' => 'College of Business Administration',
						'count' => '43',
						'default' => false
					),
					'college-of-education-and-human-performance' => array(
						'name' => 'College of Education and Human Performance',
						'count' => '100',
						'default' => false
					),
					'college-of-engineering-and-computer-science' => array(
						'name' => 'College of Engineering and Computer Science',
						'count' => '72',
						'default' => false
					),
					'college-of-graduate-studies' => array(
						'name' => 'College of Graduate Studies',
						'count' => '65',
						'default' => false
					),
					'college-of-health-and-public-affairs' => array(
						'name' => 'College of Health and Public Affairs',
						'count' => '65',
						'default' => false
					),
					'college-of-medicine' => array(
						'name' => 'College of Medicine',
						'count' => '15',
						'default' => false
					),
					'college-of-nursing' => array(
						'name' => 'College of Nursing',
						'count' => '11',
						'default' => false
					),
					'college-of-optics-and-photonics' => array(
						'name' => 'College of Optics and Photonics',
						'count' => '35',
						'default' => false
					),
					'college-of-sciences' => array(
						'name' => 'College of Sciences',
						'count' => '45',
						'default' => false
					),
					'office-of-undergraduate-studies' => array(
						'name' => 'Office of Undergraduate Studies',
						'count' => '10',
						'default' => false
					),
					'rosen-college-of-hospitality-management' => array(
						'name' => 'Rosen College of Hospitality Management',
						'count' => '13',
						'default' => false
					),
				),
			)
		);

		// Fetch data based on default params + anything set by the user
		$default_params = array(
			'program-type' => array('undergraduate-degree'),
			'location' => array('main-campus'),
			'college' => array(),
			'sort-by' => 'title',
			'search-query' => ''
		);

		$params = array_merge( $default_params, $_GET );

		$data = json_decode( file_get_contents( THEME_URL . '/page-degree-search-results-2.php?' . http_build_query( $params ) ), true );
	?>

	<div class="row page-content" id="academics-search" <?php if ( !empty( $_GET ) ) { echo 'data-params-onload="true"'; } ?>>

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
						<input type="text" autocomplete="off" data-provide="typeahead" name="search-query" class="span9 search-field" placeholder="Enter a program name or keywords, like 'Aerospace Engineering' or 'Psychology'" value="<?php echo $_GET['search-query']; ?>">
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

				<?php foreach ( $filters as $filter_value => $filter_details ): ?>
				<h2 class="degree-filter-title"><?php echo $filter_details['name']; ?></h2>
				<ul class="degree-filter-list">
					<?php foreach ( $filter_details['options'] as $option_value => $option_details ): ?>
					<li class="checkbox">
						<label>
							<input name="<?php echo $filter_value; ?>[]" class="<?php echo $filter_value; ?>" value="<?php echo $option_value; ?>" type="checkbox"
							<?php
							if (
								( $filter_details['has_default'] === true && empty( $params[$filter_value] ) ) ||
								( in_array( $option_value, $params[$filter_value] ) && $option_details['default'] === true )
							) {
								echo 'checked';
							} ?>>
							<span><?php echo $option_details['name']; ?></span>
							<small class="filter-result-count">(<?php echo $option_details['count']; ?>)</small>
						</label>
					</li>
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
