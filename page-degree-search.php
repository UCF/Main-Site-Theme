<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	.input-append .btn-group > .btn:first-child {
		border-bottom-left-radius: 0;
		border-top-left-radius: 0;
	}

	.dropdown-menu-form {
		max-height: 250px;
		min-width: 225px;
		overflow-x: hidden;
		overflow-y: scroll;
		-webkit-overflow-scrolling: touch;
	}
	.dropdown-menu-form .radio,
	.dropdown-menu-form .checkbox {
		padding-left: 30px;
		padding-right: 15px;
	}
	.dropdown-menu-heading {
		border-top: 1px solid #e5e5e5;
		display: block;
		font-size: 12px;
		font-weight: bold;
		color: #888;
		padding-bottom: 6px;
		padding-left: 10px;
		padding-top: 8px;
		text-transform: uppercase;
	}
	.dropdown-menu-heading:first-child {
		border-top: 0 solid transparent;
		padding-top: 0;
	}


	#sidebar_left,
	#contentcol,
	#contentcol input,
	#contentcol select,
	#contentcol option {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}

	@media (max-width: 767px) {

		#sidebar_left {
			border-top: none;
			box-sizing: border-box;
			box-shadow: 0 6px 12px rgba(0,0,0,.3);
			background: #fff;
			margin-top: 0;
			padding: 0;
			position: absolute;
			top: 0;
			right: 0;
			width: 300px;

			-webkit-transform: scaleX(0.00001);
			transform: scaleX(0.00001);

			-webkit-transform-origin: 100% 0%;
			transform-origin: 100% 0%;

			-webkit-transition-duration: 0.5s;
			transition-duration: 0.5s;

			z-index: 15000;
		}

		#sidebar_left.open {
			transform: scaleX(1);
			-webkit-transform: scaleX(1);
		}

		#sidebar_left .header {
			background-color: #888;
			color: #fff;
			margin: 0 0 25px;
			padding-left: 10px;
		}

		#sidebar_left a.close, #sidebar_left a.close:hover {
			color: #000;
			display: inline-block;
			font-weight: normal;
			padding: 10px;
		}

		#sidebar_left .content {
			margin: 10px;
		}
	}

	#sidebar_left h2 {
		color: #888;
		font-size: 18px;
		font-weight: 500;
	}

	.degree-search-filters ul {
		list-style-type: none;
		margin-bottom: 15px;
		margin-left: 0;
	}

	.degree-search-filters ul li {
		padding-bottom: 6px;
	}

	.degree-search-filters label {
		font-size: 14px;
	}

	#contentcol .degree-search-form {
		margin-top: 10px;
	}

	#contentcol .filter-button {
		-webkit-border-radius: 0;
		-moz-border-radius: 0;
		border-radius: 0;
	}

	#contentcol .degree-search-header {
		color: #888;
		font-size: 24px;
		line-height: 1.25;
		margin-top: 25px;
		margin-bottom: 10px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-search-header {
			font-size: 22px;
			line-height: 1.2;
			margin-top: 15px;
		}
	}
	#contentcol .degree-search-header em {
		font-weight: 500;
	}


	#contentcol .degree-search-sort {
		border-bottom: 1px solid #e5e5e5;
		padding-bottom: 15px;
	}

	#contentcol .degree-search-sort-label {
		padding-left: 0;
	}

	#contentcol .degree-mobile-controls {
		border-bottom: 1px solid #e5e5e5;
	}
	#contentcol .degree-mobile-control {
		border: 0;
		display: inline-block;
		padding: 0;
		text-align: left;
	}
	#contentcol .degree-mobile-control .btn {
		border: 0;
		font-size: 14px;
		padding: 5px 20px 10px;
	}
	#contentcol .degree-mobile-control.open .btn {
		color: #08c !important;
		outline: 0;
	}
	#contentcol .degree-mobile-control .btn .caret {
		margin-left: 3px;
	}
	#contentcol .degree-mobile-control.degree-search-filters .btn {
		border-left: 1px solid #e5e5e5;
	}
	#contentcol .degree-mobile-control.degree-search-filters ul {
		margin-bottom: 5px;
	}
	#contentcol .degree-mobile-control.degree-search-filters ul li {
		padding-bottom: 2px;
	}
	#contentcol .degree-mobile-control label {
		font-size: 13px;
	}


	#contentcol .degree-search-results {
		list-style-type: none;
		margin-left: 0;
		margin-top: 15px;
	}
	#contentcol .degree-search-result {
		/*border-bottom: 1px solid #e5e5e5;*/
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
				<h2 class="header visible-phone">
					Filter By <a href="#" class="close">X</a>
				</h2>
				<div class="content">
					<h2>Program Types</h2>
					<ul>
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

					<h2>Colleges</h2>
					<ul>
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
			</div>

			<div class="span9" id="contentcol">
				<article role="main">

					<!-- Search input -->

					<div class="degree-search-form form-search">
						<div class="input-append">
							<input type="text" name="search-query" class="span6 search-query" autocomplete="off" data-provide="typeahead"
								placeholder="Find programs by name or keyword..." value="<?php echo $_GET['search-query']; ?>">
							<button class="btn visible-phone filter-button" type="button"><i class="icon-filter"></i></button>
							<button class="btn btn-primary" type="button"><i class="icon-search icon-white"></i></button>
						</div>
					</div>

					<?php
						$sort_by = "degree-name";

						if (isset($_GET['sort-by']) && $_GET['sort-by'] == "credit-hours") {
							$sort_by = "credit-hours";
						}
					?>

					<!-- Search Result Header -->

					<h2 class="degree-search-header">234 Results for: <?php echo urldecode($_GET['search-query']); ?></em></h2>
					<div class="degree-search-sort">
						<strong class="degree-search-sort-label radio inline">Sort by:</strong>
						<label class="radio inline">
							<input type="radio" name="sort-by" class="sort-by" value="degree-name" <?php if ($sort_by == "degree-name") echo "checked";?>> Name
						</label>
						<label class="radio inline">
							<input type="radio" name="sort-by" class="sort-by" value="credit-hours" <?php if ($sort_by == "credit-hours") echo "checked";?>> Credit Hours
						</label>
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

			function initAutoComplete() {
				// Workaround for bug in mouse item selection
				$.fn.typeahead.Constructor.prototype.blur = function() {
				    var that = this;
				    setTimeout(function () { that.hide() }, 250);
				};

				$academicsSearch.find('.search-query').typeahead({
				    source: function(query, process) {
				        return ["Arts & Humanities", "Business Administration", "Education & Human Performance", "Engineering & Computer Science", "Graduate Studies", "Health & Public Affairs", "Honors", "Hospitality Management", "Medicine", "Nursing", "Optics & Photonics", "Sciences"];
				    }
				});
			}

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
					type: "GET",
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

			function closeButtonClickHandler(e) {
				e.preventDefault();
				$sidebarLeft.removeClass('open');
				degreeSearchChangeHandler();
			}

			function initFilterClickHandler(e) {
				e.preventDefault();
				// resize the panel to be full screen and align it, doesn't resize properly on page load
				$sidebarLeft
					.height($(document).height())
					.offset({ top: 0, right: 0 })
					// setting the click handler on page load fails
					.find('a.close').on('click', closeButtonClickHandler);
				$(document).on('click touchstart', closeMenuHandler);
			}

			function filterClickHandler(e) {
				e.preventDefault();
				// resize the panel to be full screen and align it
				$sidebarLeft.addClass('open');
			}

			function closeMenuHandler(e) {
				if(!$(e.target).closest('.filter-button').length && !$(e.target).closest('#sidebar_left').length) {
					$sidebarLeft.removeClass('open');
					loadDegreeSearchResults();
				}
			}

			function setupEventHandlers() {
				if($academicsSearch.find('.filter-button').is(':visible')) {
					// mobile
					$academicsSearch.one('click', '.filter-button', initFilterClickHandler);
					$academicsSearch.on('click', '.filter-button', filterClickHandler);
				} else {
					// desktop
					$academicsSearch.on('change', '.program-type, .college, .sort-by', degreeSearchChangeHandler);
				}
				$academicsSearch.on('keyup', '.search-query', searchQueryKeyUpHandler);
			}

			function initPage() {
				$academicsSearch = $('#academics_search');
				$degreeSearchResultsContainer = $academicsSearch.find('.degree-search-results-container');
				$sidebarLeft = $academicsSearch.find("#sidebar_left");
				setupEventHandlers();
				initAutoComplete();
			}

			$(initPage);

		})();
	</script>

<?php get_footer(); ?>
