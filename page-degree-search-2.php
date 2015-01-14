<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	/* General Site Styles */
	@media (max-width: 767px) {
		.subpage .page-content #page_title {
			margin-bottom: 15px;
			padding-bottom: 5px;
		}
	}


	/* General content/sidebar styles */
	#sidebar_left,
	#contentcol,
	#contentcol input,
	#contentcol select,
	#contentcol option {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}


	/* Sidebar page-specific styles */
	#sidebar_left.degree-search-filters .degree-filter-title {
		color: #888;
		font-size: 18px;
		font-weight: 500;
	}

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

	@media (max-width: 767px) {
		#sidebar_left.degree-search-filters {
			background-color: #fff;
			border-radius: 5px;
			box-sizing: border-box;
			box-shadow: 0 0 5px rgba(0, 0, 0, .4);
			margin-top: 0;
			max-height: 0; /* TODO: pointer-events:none is not perfect; fix ios bugginess */
			opacity: 0;
			overflow-y: scroll;
			padding: 0;
			pointer-events: none;
			position: absolute;
			top: 50px; /* UCF Header height */
			-webkit-overflow-scrolling: touch;
			-webkit-transition: opacity .2s ease-in-out;
			transition: opacity .2s ease-in-out;
			left: 15px;
			width: calc(100% - 30px);
			z-index: 999;
		}

		#sidebar_left.active {
			opacity: 1;
			pointer-events: all;
		}

		#sidebar_left.degree-search-filters .degree-mobile-actions {
			background: #eee;
			border-radius: 5px 5px 0 0;
			padding: 8px;
			position: relative;
			position: -webkit-sticky; /* we can at least give ios users a fixed top bar */
			top: -1px; /* Hide un-styleable outline on #sidebar_left:target */
		}

		#sidebar_left.degree-search-filters .degree-search-sort {
			border-bottom: 1px solid #eee;
			margin-bottom: 5px;
			padding: 10px;
		}
		#sidebar_left.degree-search-filters .degree-search-sort select {
			font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		}

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

/*		#sidebar_left.degree-search-filters .checkbox {
			padding-left: 0;
		}*/
/*		#sidebar_left.degree-search-filters .checkbox label {
			border: 1px solid #eee;
			border-radius: 4px;
			display: block;
			font-size: 12.5px;
			line-height: 1.2;
			padding: 6px;
		}*/
		#sidebar_left.degree-search-filters .checkbox input[type="checkbox"] {
			margin-right: 10px;
			margin-top: 0;
		}
	}


	/* Page content page-specific styles */
	#contentcol .degree-search-form {
		margin-top: 10px;
	}


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
		width: 60%;
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
		width: 35%; /* widths don't add up to 100% here to avoid ie7-specific overrides (which doesn't support box-sizing) */
	}
	@media (max-width: 979px) {
		#contentcol .degree-result-count {
			width: 50%;
		}
		#contentcol .degree-search-sort-options {
			width: 45%;
		}
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


	#contentcol .degree-search-results {
		list-style-type: none;
		margin-left: 0;
		margin-top: 15px;
	}
	#contentcol .degree-search-result {
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

	#contentcol .degree-title {
		font-size: 18px;
		margin-bottom: 8px;
	}
	#contentcol .degree-title a {
		border: 0 solid transparent;
		color: #08c;
		font-weight: 500;
	}
	#contentcol .degree-credits-count {
		color: #888;
		font-size: 14px;
		font-weight: normal;
	}

	#contentcol .degree-college,
	#contentcol .degree-dept {
		display: block;
	}
	@media (max-width: 767px) {
		#contentcol .degree-college,
		#contentcol .degree-dept {
			font-size: 12px;
			line-height: 1.25;
			margin-bottom: 4px;
		}
	}
	#contentcol .degree-detail-label {
		font-weight: 500;
	}

	#contentcol .degree-desc {
		margin-top: 10px;
		margin-bottom: 5px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-desc {
			font-size: 13px;
		}
	}

	#contentcol .degree-search-result-link {
		border: 0 solid transparent !important;
		display: block;
		outline: 0;
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		text-indent: -9999px;
	}
	</style>

	<?php
		$program_type = "undergraduate";

		if(!empty($_GET['program-type'])){
			$arraySize = count($_GET['program-type']);

			foreach($_GET['program-type'] as $key=>$value){
				$program_type = $program_type . $value;
				if($key > -1 && $key < $arraySize-1) {
					$program_type = $program_type . ' and ';
				}
			}
		}

		$college = "";

		if(!empty($_GET['college'])){
			$arraySize = count($_GET['college']);

			foreach($_GET['college'] as $key=>$value){
				$college = $college . $value;
				if($key > -1 && $key < $arraySize-1) {
					$college = $college . ' and ';
				}
			}
		}
	?>

	<?php $degrees = get_degree_search_data(); ?>
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
							<input name="program-type[]" class="program-type" value="undergraduate" type="checkbox"
								<?php if (!isset($_GET['program-type']) || (isset($_GET['program-type']) && in_array("undergraduate", $_GET['program-type']))) echo "checked";?>> Undergraduate
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="graduate" type="checkbox"
								<?php if (isset($_GET['program-type']) && in_array("graduate", $_GET['program-type'])) echo "checked";?>> Graduate
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="minor" type="checkbox"
								<?php if (isset($_GET['program-type']) && in_array("minor", $_GET['program-type'])) echo "checked";?>> Minor
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="program-type[]" class="program-type" value="certificate" type="checkbox"
								<?php if (isset($_GET['program-type']) && in_array("certificate", $_GET['program-type'])) echo "checked";?>> Certificate
						</label>
					</li>
				</ul>

				<h2 class="degree-filter-title">Colleges</h2>
				<ul class="degree-filter-list">
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Arts_Humanities" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Arts_Humanities", $_GET['college'])) echo "checked";?>> Arts &amp; Humanities
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Business_Administration" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Business_Administration", $_GET['college'])) echo "checked";?>> Business Administration
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Education_Human_Performance" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Education_Human_Performance", $_GET['college'])) echo "checked";?>> Education &amp; Human Performance
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Engineering_Computer_Science" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Engineering_Computer_Science", $_GET['college'])) echo "checked";?>> Engineering &amp; Computer Science
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Graduate_Studies" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Graduate_Studies", $_GET['college'])) echo "checked";?>> Graduate Studies
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Health_Public_Affairs" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Health_Public_Affairs", $_GET['college'])) echo "checked";?>> Health &amp; Public Affairs
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Honors" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Honors", $_GET['college'])) echo "checked";?>> Honors
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Hospitality_Management" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Hospitality_Management", $_GET['college'])) echo "checked";?>> Hospitality Management
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Medicine" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Medicine", $_GET['college'])) echo "checked";?>> Medicine
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Nursing" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Nursing", $_GET['college'])) echo "checked";?>> Nursing
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Optics_Photonics" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Optics_Photonics", $_GET['college'])) echo "checked";?>> Optics &amp; Photonics
						</label>
					</li>
					<li class="checkbox">
						<label>
							<input name="college[]" class="college" value="Sciences" type="checkbox"
							<?php if (isset($_GET['college']) && in_array("Sciences", $_GET['college'])) echo "checked";?>> Sciences
						</label>
					</li>
				</ul>
			</div>

			<div class="span9" id="contentcol">
				<article role="main">

					<!-- Search input -->

					<div class="degree-search-form form-search">
						<div class="input-append">
							<input type="text" name="search-query" class="span6 search-query" placeholder="Find programs by name or keyword..." value="<?php echo $_GET['search-query']; ?>">
							<button class="btn btn-primary" type="button"><i class="icon-search icon-white"></i></button>
						</div>
					</div>

					<?php
						$sort_by = "degree-name";

						if (isset($_GET['sort-by']) && $_GET['sort-by'] == "credit-hours") {
							$sort_by = "credit-hours";
						}

						// var_dump($_GET['program-type']);
					?>

					<!-- Search Result Header -->

<!-- 					<h2 class="degree-search-header">234 results for: <?php echo urldecode($_GET['search-query']); ?></em></h2> -->

					<div class="degree-search-sort clearfix">
						<h2 class="degree-search-sort-inner degree-result-count">
							234 results <span class="for">for:</span> <span class="result"><?php echo urldecode($_GET['search-query']); ?></span>
						</h2>

						<div class="degree-search-sort-inner degree-search-sort-options hidden-phone">
							<strong class="degree-search-sort-label radio inline">Sort by:</strong>
							<label class="radio inline">
								<input type="radio" name="sort-by" class="sort-by" value="degree-name" <?php if ($sort_by == "degree-name") echo "checked";?>> Name
							</label>
							<label class="radio inline">
								<input type="radio" name="sort-by" class="sort-by" value="credit-hours" <?php if ($sort_by == "credit-hours") echo "checked";?>> Credit Hours
							</label>
						</div>

						<div class="degree-search-sort-inner degree-search-sort-options visible-phone">
							<a class="btn" id="mobile-filter" href="#">Filter Results</a>
						</div>
					</div>

					<!-- Search Results -->

					<div class="degree-search-results-container">
						<?php include 'page-degree-search-results.php'; ?>
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

			function degreeSearchSuccessHandler( data ) {
				$degreeSearchResultsContainer.html(data);
			}

			function degreeSearchFailureHandler( data ) {
				$degreeSearchResultsContainer.html('Error loading degree data.');
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
					url: '<?php echo get_stylesheet_directory_uri(); ?>/page-degree-search-results.php',
					type: 'GET',
					cache: false,
					data: {
						'search-query': encodeURIComponent($academicsSearch.find('.search-query').val()),
						'sort-by': $academicsSearch.find('.sort-by:checked').val(),
						'program-type': programType,
						'college': college
					},
					dataType: "html"
				});

				$degreeSearchResultsContainer.html('<img src="//universityheader.ucf.edu/bar/img/ajax-loader.gif" width="16" height="16" /> Loading search results...');
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
				// Resize, position sidebar
				$sidebarLeft.css({
					'top': $('#mobile-filter').offset().top + ( $('#mobile-filter').outerHeight() / 2 ),
					'max-height': $(window).height() - 40
				});

				$(document).on('click touchstart', function(e) {
					if(!$(e.target).closest('#mobile-filter').length && !$(e.target).closest('#sidebar_left').length) {
						closeMenuHandler(e);
					}
				});
				$('body').on('click', '#mobile-filter-done', closeMenuHandler);
				$('body').on('click', '#mobile-filter-reset', resetFilterClickHandler);
			}

			function filterClickHandler(e) {
				e.preventDefault();
				// resize the panel to be full screen and align it
				$('html, body').animate({
					scrollTop: $(this).offset().top,
				}, 200);
				$sidebarLeft
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
					.removeClass('active');
				loadDegreeSearchResults();
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
			}

			function initPage() {
				$academicsSearch = $('#academics_search');
				$degreeSearchResultsContainer = $academicsSearch.find('.degree-search-results-container');
				$sidebarLeft = $academicsSearch.find('#sidebar_left');
				setupEventHandlers();
			}

			$(initPage);

		})();
	</script>

<?php get_footer(); ?>
