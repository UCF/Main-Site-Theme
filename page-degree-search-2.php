<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	/*
	 * General Site Styles
	 */

	/* Reduce whitespace between page title and content */
	@media (max-width: 767px) {
		.subpage .page-content #page_title {
			margin-bottom: 15px;
			padding-bottom: 5px;
		}
	}


	/*
	 * General content/sidebar styles
	 */

	/* Reset this template's fonts to Helvetica */
	#sidebar_left,
	#contentcol,
	#contentcol input,
	#contentcol select,
	#contentcol option {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}


	/*
	 * Sidebar page-specific styles
	 */

	/* Sidebar headings */
	#sidebar_left.degree-search-filters .degree-filter-title {
		color: #888;
		font-size: 18px;
		font-weight: 500;
	}

	/* Sidebar filter lists */
	#sidebar_left.degree-search-filters .degree-filter-list {
		list-style-type: none;
		margin-bottom: 15px;
		margin-left: 0;
	}
	#sidebar_left.degree-search-filters .degree-filter-list li {
		padding-bottom: 6px;
	}
	#sidebar_left.degree-search-filters label {
		font-size: 14px;
	}

	#sidebar_left.degree-search-filters .degree-infobox-toggle {
		border-bottom: 0 solid transparent !important;
		display: block;
		float: right;
		margin-right: 15px;
		padding-left: 5px;
	}
	#sidebar_left.degree-search-filters .degree-infobox-toggle .icon {
		padding-bottom: 3px;
		border-bottom: 1px dotted #999;
	}
	#sidebar_left.degree-search-filters .popover-title {
		display: none; /* hide empty titles */
	}
	#sidebar_left.degree-search-filters .popover {
		font-size: 12px;
		line-height: 1.4;
		font-weight: normal;
	}
	@media (max-width: 767px) {
		#sidebar_left.degree-search-filters .popover-content {
			max-height: 250px;
			overflow-x: hidden;
			overflow-y: scroll;
			-webkit-overflow-scrolling: touch;
		}
	}

	@media (max-width: 767px) {

		/* Mobile sidebar filter "modal" */
		#sidebar_left.degree-search-filters {
			background-color: #fff;
			border-radius: 5px;
			box-sizing: border-box;
			box-shadow: 0 0 5px rgba(0, 0, 0, .4);
			margin-top: 0;
			max-height: 0; /* set via js when active */
			opacity: 0;
			overflow-y: scroll;
			padding: 0;
			pointer-events: none;
			position: absolute;
			top: 50px; /* is overridden via JS */
			-webkit-overflow-scrolling: touch;
			-webkit-transition: opacity .2s ease-in-out;
			transition: opacity .2s ease-in-out;
			left: 15px;
			width: calc(100% - 30px);
			z-index: 999;
		}
		#sidebar_left.degree-search-filters.active {
			opacity: 1;
			pointer-events: all;
		}

		/* Modal - General */
		#sidebar_left.degree-search-filters select {
			margin-bottom: 0;
			width: 55%;
		}
		#sidebar_left.degree-search-filters label {
			font-size: 12.5px;
			line-height: 1.2;
			margin: 0;
			padding: 5px 5px 5px 25px;
		}

		/* Modal head */
		#sidebar_left.degree-search-filters .degree-mobile-actions {
			background: #eee;
			border-radius: 5px 5px 0 0;
			padding: 8px;
			position: relative;
			position: -webkit-sticky; /* we can at least give ios users a fixed top bar */
			top: -1px; /* Hide un-styleable outline on #sidebar_left:target */
		}

		/* Modal sorting */
		#sidebar_left.degree-search-filters .degree-search-sort {
			border-bottom: 1px solid #eee;
			margin-bottom: 5px;
			padding: 10px;
		}
		#sidebar_left.degree-search-filters .degree-search-sort select {
			font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		}

		/* Modal filters */
		#sidebar_left.degree-search-filters .degree-filter-list,
		#sidebar_left.degree-search-filters .degree-filter-title {
			padding-left: 10px;
			padding-right: 10px;
		}
		#sidebar_left.degree-search-filters .degree-filter-list {
			margin-bottom: 10px;
		}
		#sidebar_left.degree-search-filters .degree-filter-list li {
			border-top: 1px solid #eee;
			box-sizing: border-box;
			margin: 0 4px;
			padding: 4px 0;
			text-align: left;
		}
		#sidebar_left.degree-search-filters .degree-filter-list li:first-child {
			border-top: 0 solid transparent;
		}

		#sidebar_left.degree-search-filters .degree-filter-title {
			font-size: 14px;
			line-height: 1.4;
			margin: 15px 0 5px;
		}
		#sidebar_left.degree-search-filters .degree-search-sort .degree-filter-title {
			margin-top: 6px;
			padding: 0;
		}

		#sidebar_left.degree-search-filters .checkbox input[type="checkbox"] {
			margin-right: 10px;
			margin-top: 0;
		}
	}


	/*
	 * Page content page-specific styles
	 */

	/* Search field wrapper */
	#contentcol .degree-search-form {
		margin-top: 10px;
	}

	/* Search Result Title + Sorting (desktop) */
	#contentcol .degree-search-sort {
		border-bottom: 1px solid #e5e5e5;
		margin-top: 20px;
		width: 100%;
	}
	#contentcol .degree-search-sort-inner {
		display: table-cell;
		padding-bottom: 10px;
		vertical-align: middle;
	}
	@media (max-width: 979px) {
		/* We assume that browsers that support media queries can support box-sizing */
		#contentcol .degree-search-sort-inner {
			box-sizing: border-box;
		}
	}
	@media (max-width: 767px) {
		#contentcol .degree-search-sort-inner {
			display: block;
		}
	}

	#contentcol .degree-result-count {
		border-right: 1px solid #eee;
		font-size: 16px;
		font-weight: bold;
		line-height: 20px;
		padding-right: 15px;
		padding-top: 5px;
		width: 45%;
	}
	#contentcol .degree-result-count .result {
		font-style: italic;
		font-weight: 400;
	}
	@media (max-width: 767px) {
		#contentcol .degree-result-count .for,
		#contentcol .degree-result-count .result {
			display: none;
		}
	}
	#contentcol .degree-search-sort-options {
		padding-left: 15px;
		width: 28%; /* widths don't add up to 100% here to avoid ie7-specific overrides (which doesn't support box-sizing) */
	}
	@media (max-width: 979px) {
		#contentcol .degree-result-count {
			width: 50%;
		}
		#contentcol .degree-search-sort-options {
			width: 45%;
		}
	}
	#contentcol #desktop-compare {
		margin-right: 15px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-result-count {
			border-right: 0 solid transparent;
			font-style: italic;
			font-weight: normal;
			float: left;
			padding-right: 0;
			width: auto;
		}
		#contentcol .degree-search-sort-options {
			border-left: 1px solid #eee;
			float: right;
			width: auto;
			padding-bottom: 5px;
		}
	}
	#contentcol .degree-search-sort-label {
		padding-left: 0;
	}

	/* Results wrapper */
	#contentcol .degree-search-results-container {
		position: relative;
	}

	/* Ajax load overlay (over results) */
	#ajax-loading {
		background-color: rgba(255, 255, 255, .75);
		background-image: url('<?php echo THEME_IMG_URL; ?>/ajax.gif');
		background-repeat: no-repeat;
		background-position: top center;
		box-sizing: border-box;
		display: block;
		padding: 10px;
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		text-align: center;
		transition: background-color .1s ease-in-out;
	}
	#ajax-loading.hidden {
		background-color: rgba(255, 255, 255, 0);
	}

	/* No results found */
	#contentcol .degree-search-results-container .no-results {
		margin-top: 20px;
	}

	/* Results list */
	#contentcol .degree-search-results {
		list-style-type: none;
		margin-left: 0;
		margin-top: 15px;
	}
	#contentcol .degree-search-result {
		box-sizing: border-box;
		display: table;
		width: 100%;
		margin-bottom: 0;
		padding: 12px 15px 8px;
		position: relative;
	}
	#contentcol .degree-search-result:hover,
	#contentcol .degree-search-result:active,
	#contentcol .degree-search-result:focus {
		background-color: #eee;
	}
	@media (max-width: 767px) {
		#contentcol .degree-search-result {
			margin-bottom: 20px;
			padding: 0;
		}
		#contentcol .degree-search-result:hover,
		#contentcol .degree-search-result:active,
		#contentcol .degree-search-result:focus {
			background-color: transparent;
		}
	}

	/* Single result elements */
	#contentcol .degree-title {
		display: table-cell;
		vertical-align: middle;
		/*width: 50%;*/
		font-size: 18px;
		margin-bottom: 8px;

		width: 62%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#contentcol .degree-title {
			width: 60%;
		}
	}
	@media (max-width: 767px) {
		#contentcol .degree-title {
			display: block;
			float: left;
			font-size: 15px;
			line-height: 1.1;
			margin-bottom: 4px;
			width: 100%;
		}
	}
	#contentcol .degree-title a {
		border: 0 solid transparent;
		color: #08c;
		font-weight: 500;
	}
	#contentcol .degree-credits-count {
		color: #888;
		font-size: 13px;
		font-weight: normal;
		display: block;
		line-height: 1.2;
		margin-top: 4px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-credits-count {
			font-size: 11.5px;
		}
	}

	#contentcol .degree-online {
		box-sizing: border-box;
		display: table-cell;
		font-size: 11.5px;
		font-weight: 500;
		padding: 0 10px;
		vertical-align: middle;
		width: 12%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#contentcol .degree-online {
			width: 16%;
		}
	}
	@media (max-width: 767px) {
		#contentcol .degree-online {
			clear: both;
			display: block;
			margin-top: 8px;
			padding: 0;
			width: 100%;
		}
	}

	#contentcol .degree-compare {
		display: table-cell;
		vertical-align: middle;
		width: 12%;
	}
	@media (max-width: 767px) {
		#contentcol .degree-compare {
			box-sizing: border-box;
			padding-left: 12px;
			width: 12%;
		}
	}
	#contentcol .degree-compare-label {
		padding: 3px 3px 3px 25px;
		background-color: #fff;
		border: 1px solid #ddd;
		border-radius: 4px;
		color: #555;
		font-size: 12px;
		font-weight: 500;
	}
	@media (max-width: 767px) {
		#contentcol .degree-compare-label {
			font-size: 11px;
			padding-right: 7px;
		}
	}
	#contentcol .degree-compare-label:hover,
	#contentcol .degree-compare-label:active,
	#contentcol .degree-compare-label:focus {
		color: #08c;
	}
	#contentcol .degree-search-result.compare-active {
		background-color: #d9edf7;
	}
	@media (max-width: 767px) {
		#contentcol .degree-search-result.compare-active {
			background-color: transparent;
		}
	}
	#contentcol .degree-search-result.compare-active .degree-compare-label {
		border-color: #08c;
		color: #08c;
	}

	</style>

	<?php
		$default_params = array(
			'program-type' => array('undergraduate-degree'),
			'college' => array(),
			'sort-by' => 'title',
			'search-query' => ''
		);

		$params = array_merge( $default_params, $_GET );

		// $params_pretty = array(
		// 	'program-type' => '',
		// 	'college' => ''
		// );

		// if( !empty( $params['program-type'] ) ) {
		// 	$array_size = count( $params['program-type'] );

		// 	foreach( $params['program-type'] as $key => $value ) {
		// 		$program_type = $program_type . $value;
		// 		if( $key > -1 && $key < $array_size - 1 ) {
		// 			$program_type = $program_type . ' and ';
		// 		}
		// 	}

		// 	$params_pretty['program-type'] = $program_type;
		// }

		// if( !empty( $params_pretty['college'] ) ) {
		// 	$array_size = count( $params_pretty['college'] );

		// 	foreach( $params_pretty['college'] as $key => $value ) {
		// 		$college = $college . $value;
		// 		if( $key > -1 && $key < $array_size - 1 ) {
		// 			$college = $college . ' and ';
		// 		}
		// 	}

		// 	$params_pretty['college'] = $college;
		// }


		$data = json_decode( file_get_contents( THEME_URL . '/page-degree-search-results-2.php?' . http_build_query($params) ), true );
		// var_dump($data);
	?>

	<div class="row page-content" id="academics_search">

		<form>

			<div class="span12" id="page_title">
				<h1 class="span9"><?php the_title();?></h1>
				<?php esi_include('output_weather_data','span3'); ?>
			</div>

			<!-- Sidebar (Desktop only) -->

			<div id="sidebar_left" class="span3 degree-search-filters">
				<div class="visible-phone clearfix degree-mobile-actions">
					<a class="btn btn-default pull-left" id="mobile-filter-reset">Reset All</a>
					<a class="btn btn-primary pull-right" id="mobile-filter-done" href="#">Done</a>
				</div>
				<div class="degree-search-sort visible-phone clearfix">
					<label for="sort-by" class="degree-search-sort-label degree-filter-title pull-left">Sort By</label>
					<select id="sort-by" class="pull-right">
						<option value="degree-name" <?php if ($sort_by == 'degree-name') echo 'selected';?>>Name</option>
						<option value="credit-hours" <?php if ($sort_by == 'credit-hours') echo 'selected';?>>Credit Hours</option>
					</select>
				</div>

				<h2 class="degree-filter-title">Program Types</h2>
				<ul class="degree-filter-list">
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="undergraduate-degree" type="checkbox" <?php if( empty( $params['program-type'] ) || in_array( 'undergraduate-degree', $params['program-type'] ) ) { echo 'checked'; } ?>> Bachelor
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="minor" type="checkbox" <?php if( in_array( 'minor', $params['program-type'] ) ) { echo 'checked'; } ?>> Minor
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="graduate-degree" type="checkbox" <?php if( in_array( 'graduate-degree', $params['program-type'] ) ) { echo 'checked'; } ?>> Master
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="graduate-degree" type="checkbox" <?php if( in_array( 'graduate-degree', $params['program-type'] ) ) { echo 'checked'; } ?>> Doctoral
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="certificate" type="checkbox" <?php if( in_array( 'certificate', $params['program-type'] ) ) { echo 'checked'; } ?>> Certificate
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="nondegree" type="checkbox" <?php if( in_array( 'nodegree', $params['program-type'] ) ) { echo 'checked'; } ?>> Nondegree
						</label>
					</li>
				</ul>

				<h2 class="degree-filter-title">Degree Options</h2>
				<ul class="degree-filter-list">
					<li class="checkbox">
						<label>
							<input name="online_all" class="online" value="online_all" type="checkbox"> Online Courses Available
						</label>
					</li>
				</ul>

				<h2 class="degree-filter-title">Colleges</h2>
				<ul class="degree-filter-list">
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-arts-and-humanities" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-arts-and-humanities", $_GET['college'])) echo "checked";?>> Arts &amp; Humanities
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-business-administration" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-business-administration", $_GET['college'])) echo "checked";?>> Business Administration
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-education-and-human-performance" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-education-and-human-performance", $_GET['college'])) echo "checked";?>> Education &amp; Human Performance
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-engineering-and-computer-science" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-engineering-and-computer-science", $_GET['college'])) echo "checked";?>> Engineering &amp; Computer Science
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-graduate-studies" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-graduate-studies", $_GET['college'])) echo "checked";?>> Graduate Studies
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-health-and-public-affairs" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-health-and-public-affairs", $_GET['college'])) echo "checked";?>> Health &amp; Public Affairs
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="rosen-college-of-hospitality-management" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("rosen-college-of-hospitality-management", $_GET['college'])) echo "checked";?>> Hospitality Management
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-medicine" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-medicine", $_GET['college'])) echo "checked";?>> Medicine
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-nursing" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-nursing", $_GET['college'])) echo "checked";?>> Nursing
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-optics-and-photonics" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-optics-and-photonics", $_GET['college'])) echo "checked";?>> Optics &amp; Photonics
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="college-of-sciences" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("college-of-sciences", $_GET['college'])) echo "checked";?>> Sciences
						</label>
					</li>
				</ul>
			</div>

			<div class="span9" id="contentcol">
				<article role="main">

					<!-- Search input -->

					<div class="degree-search-form form-search">
						<div class="input-append">
							<input type="text" autocomplete="off" data-provide="typeahead" name="search-query" class="span6 search-query" placeholder="Find programs by name or keyword..." value="<?php echo $_GET['search-query']; ?>">
							<button class="btn btn-primary" type="submit"><i class="icon-search icon-white"></i></button>
						</div>
					</div>

					<!-- Search Result Header -->

					<div class="degree-search-sort clearfix">
						<h2 class="degree-search-sort-inner degree-result-count">
							<span class="degree-result-count-num"><?php echo $data['count']; ?></span> results
							<?php if ( $params['search-query'] ): ?>
							<span class="for">for:</span> <span class="result"><?php echo htmlspecialchars( $params['search-query'] ); ?></span>
							<?php endif; ?>
						</h2>

						<div class="degree-search-sort-inner degree-search-sort-options hidden-phone">
							<!-- <a class="btn" id="desktop-compare" href="#">Compare Degrees</a> -->
							<strong class="degree-search-sort-label radio inline">Sort by:</strong>
							<label class="radio inline">
								<input type="radio" name="sort-by" class="sort-by" value="title" <?php if ( $params['sort-by'] == 'title') echo 'checked'; ?>> Name
							</label>
							<label class="radio inline">
								<input type="radio" name="sort-by" class="sort-by" value="degree_hours" <?php if ( $params['sort-by'] == 'degree_hours' ) echo 'checked'; ?>> Credit Hours
							</label>
						</div>

						<div class="degree-search-sort-inner degree-search-sort-options btn-group visible-phone">
							<!-- <a class="btn" id="mobile-compare" href="#">Compare</a> -->
							<a class="btn" id="mobile-filter" href="#">Filter <span class="caret"></span></a>
						</div>
					</div>

					<!-- Search Results -->

					<div class="degree-search-results-container">
						<?php echo $data['markup']; ?>
						<div id="ajax-loading" class="hidden"></div>
					</div>

					<!-- Page Bottom -->

					<hr>

					<?php the_content(); ?>

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

	<script>

		(function() {

			var $academicsSearch,
				$degreeSearchResultsContainer,
				$sidebarLeft;


			function initAutoComplete() {
				// Workaround for bug in mouse item selection
				$.fn.typeahead.Constructor.prototype.blur = function() {
					var that = this;
					setTimeout(function () { that.hide(); }, 250);
				};
				$academicsSearch.find('.search-query').typeahead({
					source: function(query, process) {
						return ["Arts & Humanities", "Business Administration", "Education & Human Performance", "Engineering & Computer Science", "Graduate Studies", "Health & Public Affairs", "Honors", "Hospitality Management", "Medicine", "Nursing", "Optics & Photonics", "Sciences"];
					},
					updater: function(item) {
						this.$element[0].value = item;
						this.$element[0].form.submit();
						return item;
					}
				});
			}

			function degreeSearchSuccessHandler( data ) {
				// console.log(data);
				$loaderScreen = $academicsSearch.find('#ajax-loading');

				// Make sure the spinner actually gets displayed
				// so the user knows the page changed
				window.setTimeout(function() {
					$loaderScreen.addClass('hidden');

					$degreeSearchResultsContainer
						.html(data.markup)
						.append($loaderScreen);

					$academicsSearch
						.find('.degree-result-count-num')
							.html(data.count);
				}, 200);
			}

			function degreeSearchFailureHandler( data ) {
				$loaderScreen = $academicsSearch.find('#ajax-loading');

				// Make sure the spinner actually gets displayed
				// so the user knows the page changed
				window.setTimeout(function() {
					$loaderScreen.addClass('hidden');

					$degreeSearchResultsContainer
						.html('Error loading degree data.')
						.append($loaderScreen);
				}, 200);
			}

			function loadDegreeSearchResults() {
				var programType = [];
				$academicsSearch.find('.program-type:checked').each(function() {
					programType.push($(this).val());
				});

				var college = [];
				$academicsSearch.find('.college:checked').each(function() {
					college.push($(this).val());
				});

				var jqxhr = $.ajax({
					url: '<?php echo get_stylesheet_directory_uri(); ?>/page-degree-search-results-2.php',
					type: 'GET',
					cache: false,
					data: {
						'search-query': encodeURIComponent($academicsSearch.find('.search-query').val()),
						'sort-by': $academicsSearch.find('.sort-by:checked').val(),
						'program-type': programType,
						'college': college
					},
					dataType: "json"
				});

				$academicsSearch.find('#ajax-loading').removeClass('hidden');
				jqxhr.done(degreeSearchSuccessHandler);
				jqxhr.fail(degreeSearchFailureHandler);

			}

			// Handler Methods
			function degreeSearchChangeHandler() {
				loadDegreeSearchResults();
			}

			var timer = null;
			function searchQueryKeyUpHandler(e) {
				if($(e.target).val().length > 2) {
					// prevent action until user is done typing
					if(timer) {
						clearTimeout(timer);
					}
					timer = setTimeout(loadDegreeSearchResults, 250);
				}
			}

			function initFilterClickHandler(e) {
				// Position sidebar
				$sidebarLeft.css({
					'top': $('#mobile-filter').offset().top + ( $('#mobile-filter').outerHeight() / 2 )
				});

				$(document).on('click', function(e) {
					// Allow a click anywhere within the document
					// to close the sidebar, except for in/on the sidebar itself
					// or on its toggle button
					if($sidebarLeft.hasClass('active') && !$(e.target).is('#sidebar_left') && !$sidebarLeft.find(e.target).length && !$(e.target).is('#mobile-filter')) {
						closeMenuHandler(e);
					}
				});
				$academicsSearch.on('click', '#mobile-filter-done', closeMenuHandler);
				$academicsSearch.on('click', '#mobile-filter-reset', resetFilterClickHandler);
			}

			function filterClickHandler(e) {
				e.preventDefault();
				// resize the panel to be full screen and align it
				$('html, body').animate({
					scrollTop: $(this).offset().top,
				}, 200);
				$sidebarLeft
					.css({
						'max-height': $(window).height() - 40
					})
					.add($(this))
					.toggleClass('active');
			}

			function resetFilterClickHandler(e) {
				e.preventDefault();
				$sidebarLeft
					.find('.checkbox input')
					.prop('checked', false);
			}

			function closeMenuHandler(e) {
				e.preventDefault();
				$sidebarLeft
					.add('#mobile-filter')
					.removeClass('active')
					.end()
					.css({
						'max-height': 0
					});
				loadDegreeSearchResults();
			}

			function highlightCompareableDegree($checkedDegreeInput) {
				$checkedDegreeInput.each(function() {
					$(this)
						.parents('.degree-search-result')
							.addClass('compare-active');
				});
			}

			function unhighlightCompareableDegrees() {
				$academicsSearch.find('.compare-active').removeClass('compare-active');
			}

			function performComparison() {
				var $checked = $academicsSearch.find('.degree-compare-input:checked');
				var compareables = [];

				$checked.each(function() {
					compareables.push($(this).val());
				});

				var compareParams = $.param({
					academicPlanIds: compareables,
				});

				// perform request, passing compareables as GET params...
				window.location = '<?php echo get_permalink(get_page_by_title("Compare Degrees")->ID); ?>?' + compareParams;

				// Uncheck selected degrees, in case the user hits the back btn in their browser.
				// Works due to back-forward cache magic. (TODO: test in IE)
				window.setTimeout(function() {
					unhighlightCompareableDegrees();
					$academicsSearch.find('.degree-compare-input:checked').removeProp('checked');
				}, 150);
			}

			function degreeCompareChangeHandler() {
				var $checked = $academicsSearch.find('.degree-compare-input:checked');

				// If no other Compare boxes are checked, activate 'compare mode'
				// (allow one other checkbox to be checked)
				if ($checked.length === 1) {
					highlightCompareableDegree($checked);
				}
				// If a first checkbox was unchecked, deactivate 'compare mode'
				else if ($checked.length === 0) {
					unhighlightCompareableDegrees();
				}
				// If two checkboxes are now checked, go to comparison page
				else {
					highlightCompareableDegree($checked);
					performComparison();
				}
			}

			function setupEventHandlers() {
				if($academicsSearch.find('#mobile-filter').is(':visible')) {
					// mobile
					$academicsSearch.one('click', '#mobile-filter', initFilterClickHandler);
					$academicsSearch.on('click', '#mobile-filter', filterClickHandler);
				} else {
					// desktop
					$academicsSearch.on('change', '.program-type, .college, .sort-by', degreeSearchChangeHandler);
				}
				$academicsSearch.on('keyup', '.search-query', searchQueryKeyUpHandler);
				$academicsSearch.on('change', '.degree-compare-input', degreeCompareChangeHandler);
			}

			function initPage() {
				$academicsSearch = $('#academics_search');
				$degreeSearchResultsContainer = $academicsSearch.find('.degree-search-results-container');
				$sidebarLeft = $academicsSearch.find('#sidebar_left');

				setupEventHandlers();
				initAutoComplete();
			}

			$(initPage);
		})();

	</script>

<?php get_footer(); ?>
