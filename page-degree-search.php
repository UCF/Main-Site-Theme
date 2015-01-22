<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	 .input-append {
	 	width: 80%;
	 }

	 .form-search .input-append .search-query {
	 	width: 100%;
	 }

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

	#sidebar_left {
		background-color: #eee;
	}

	@media (max-width: 767px) {

		#sidebar_left {
			border-top: none;
			box-sizing: border-box;
			box-shadow: 0 6px 12px rgba(0,0,0,.3);
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
		padding-left: 10px;
	}

	.degree-search-filters ul {
		list-style-type: none;
		margin-bottom: 15px;
		margin-left: 0;
	}

	.degree-search-filters ul li {
		padding-top: 5px;
		padding-bottom: 1px;
		padding-left: 40px;
	}

	.degree-search-filters label {
		font-size: 14px;
	}

	#contentcol .degree-search-form {
		margin-top: 10px;
	}

	.filter-tab {
		background-color: #999;
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		line-height: 16px;
		right: 0;
		cursor: pointer;
		position: fixed;
		top: 205px;
		width: 9px;
		color: white;
		padding: 6px;
	}

	.filter-tab .icon-filter {
		position: absolute;
		left: 7px;
		top: 18px;
	}

	#contentcol .degree-search-results-header {
		border-bottom: 1px solid #e5e5e5;
		margin-top: 25px;
		margin-bottom: 10px;
		padding: 0 5px 5px;
	}


	#contentcol .degree-search-results-header label {
		padding-top: 0;
	}

	#contentcol .degree-search-header {
		color: #888;
		font-size: 14px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-search-header {
		}
	}
	#contentcol .degree-search-header em {
		font-weight: 500;
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
		display: block;
		margin-bottom: 20px;
		position: relative;
	}
	#contentcol .degree-search-result > div {
		padding: 12px 15px 8px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-search-result {
			border-bottom: solid 1px #e5e5e5;
			margin-bottom: 20px;
			padding: 0 0 20px;
		}
	}

	#contentcol .degree-search-result .compare {
		margin-left: 20px;
		margin-bottom: 20px;
	}

	:checked + span {
	  font-weight: bold;
	}

	#contentcol .degree-title {
		font-size: 18px;
		margin-bottom: 2px;
		color: #08c;
	}
	#contentcol a {
		color: #000;
		border: 0 solid transparent;
	}

	#contentcol a:hover {
		color: #666;
		border-bottom: none !important;
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

	.background-hover-fade-in {
        color:#000;

        -webkit-transition: background 0.5s linear;
        -moz-transition: background 0.5s linear;
        -ms-transition: background 0.5s linear;
        -o-transition: background 0.5s linear;
        transition: background 0.5s linear;
    }

	.background-hover-fade-in:hover,
	.background-hover-fade-in:active,
	.background-hover-fade-in:focus {
        background-color:#eee;
    }

	.fade {
		opacity: 0;

		-webkit-transition: opacity .5s ease-in-out;
		-moz-transition: opacity .5s ease-in-out;
		-ms-transition: opacity .5s ease-in-out;
		-o-transition: opacity .5s ease-in-out;
		transition: opacity .5s ease-in-out;
	}

	.fade-in {
		opacity: 1;
	}

	@media (max-width: 767px) {
		.background-hover-fade-in:hover,
		.background-hover-fade-in:active,
		.background-hover-fade-in:focus {
			background-color: transparent;
		}
	}

	</style>

	<?php
		$default_params = array(
			'program-type' => array('undergraduate-degree'),
			'main-campus' => array('main-campus'),
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


		$data = json_decode( file_get_contents( THEME_URL . '/page-degree-search-results.php?' . http_build_query($params) ), true );
		// var_dump($data);
	?>

	<div class="row page-content" id="academics_search">
		<div class="filter-tab visible-phone">F<br>I<br>L<br>T<br>E<br>R<br></div>

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
					<h2>Degree Type</h2>
					<ul>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="undergraduate-degree" type="checkbox"
									<?php if( empty( $params['program-type'] ) || in_array( 'undergraduate-degree', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Bachelor</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="graduate-degree" type="checkbox"
									<?php if( in_array( 'graduate-degree', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Master</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="minor" type="checkbox"
									<?php if( in_array( 'minor', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Doctorate</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="minor" type="checkbox"
									<?php if( in_array( 'minor', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Minor</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="certificate" type="checkbox"
									<?php if( in_array( 'certificate', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Certificate</span>
							</label>
						</li>
					</ul>

					<h2>Location</h2>
					<ul>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="main-campus" type="checkbox"
									<?php if( empty( $params['location'] ) || in_array( 'main-campus', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Main Campus</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="online" type="checkbox"
									<?php if( in_array( 'online', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Online Courses Available</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="altamonte-springs" type="checkbox"
									<?php if( in_array( 'certificate', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Altamonte Springs</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="cocoa" type="checkbox"
									<?php if( in_array( 'cocoa', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Cocoa</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="daytona-beach" type="checkbox"
									<?php if( in_array( 'daytona-beach', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Daytona Beach</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="leesburg" type="checkbox"
									<?php if( in_array( 'leesburg', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Leesburg</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="ocala" type="checkbox"
									<?php if( in_array( 'ocala', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Ocala</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="palm-bay" type="checkbox"
									<?php if( in_array( 'palm-bay', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Palm Bay</span>
							</label>
						</li>
					</ul>

					<h2>Colleges</h2>
					<ul>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Arts_Humanities" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Arts_Humanities", $_GET['college'])) echo "checked";?>>
								<span>Arts &amp; Humanities</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Business_Administration" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Business_Administration", $_GET['college'])) echo "checked";?>>
								<span>Business Administration</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Education_Human_Performance" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Education_Human_Performance", $_GET['college'])) echo "checked";?>>
								<span>Education &amp; Human Performance</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Engineering_Computer_Science" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Engineering_Computer_Science", $_GET['college'])) echo "checked";?>>
								<span>Engineering &amp; Computer Science</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Graduate_Studies" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Graduate_Studies", $_GET['college'])) echo "checked";?>>
								<span>Graduate Studies</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Health_Public_Affairs" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Health_Public_Affairs", $_GET['college'])) echo "checked";?>>
								<span>Health &amp; Public Affairs</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Honors" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Honors", $_GET['college'])) echo "checked";?>>
								<span>Honors</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Hospitality_Management" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Hospitality_Management", $_GET['college'])) echo "checked";?>>
								<span>Hospitality Management</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Medicine" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Medicine", $_GET['college'])) echo "checked";?>>
								<span>Medicine</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Nursing" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Nursing", $_GET['college'])) echo "checked";?>>
								<span>Nursing</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Optics_Photonics" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Optics_Photonics", $_GET['college'])) echo "checked";?>>
								<span>Optics &amp; Photonics</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Sciences" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Sciences", $_GET['college'])) echo "checked";?>>
								<span>Sciences</span>
							</label>
						</li>
					</ul>
				</div>
			</div>

			<div class="span9" id="contentcol">
				<article role="main">

					<?php the_content(); ?>

					<!-- Search input -->

					<div class="degree-search-form form-search">
						<div class="input-append">
							<input type="text" name="search-query" class="span6 search-query" autocomplete="off" data-provide="typeahead"
								placeholder="Find programs by name or keyword..." value="<?php echo htmlspecialchars($_GET['search-query']); ?>">
							<button class="btn btn-primary" type="button"><i class="icon-search icon-white"></i></button>
						</div>
					</div>

					<!-- Search Result Header -->
					<div class="degree-search-results-header">
						<div class="degree-search-header pull-right">234 Results</div>
						<div class="degree-search-sort">
							Sort by:
							<label class="radio inline">
								<input type="radio" name="sort-by" class="sort-by" value="title" <?php if ($sort_by == "title" || empty($sort_by)) echo "checked";?>> Name
							</label>
							<label class="radio inline">
								<input type="radio" name="sort-by" class="sort-by" value="credit-hours" <?php if ($sort_by == "credit-hours") echo "checked";?>> Credit Hours
							</label>
						</div>
					</div>

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

	<script>

		(function() {

			var $academicsSearch,
				$degreeSearchResultsContainer,
				$sidebarLeft;

			function degreeSearchSuccessHandler( data ) {
				$degreeSearchResultsContainer.find('li').removeClass('fade-in');
				$degreeSearchResultsContainer.html(data.markup);
				$academicsSearch.find('.degree-search-header').text(data.count + " Results for: " + $academicsSearch.find('.search-query').val());
				$degreeSearchResultsContainer.find('li').addClass('fade');
				setTimeout(function() {
					$degreeSearchResultsContainer.find('li').addClass('fade-in');
				},200);
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
						// 'sort-by': $academicsSearch.find('.sort-by:checked').val(),
						'program-type': programType,
						'college': college
					},
					dataType: "json"
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
					.find('a.close').on('click touchstart', closeButtonClickHandler);
				$(document).on('click touchstart', closeMenuHandler);
			}

			function filterClickHandler(e) {
				$(window).scrollTop(0);
				// resize the panel to be full screen and align it
				$sidebarLeft.addClass('open');
			}

			function closeMenuHandler(e) {
				if(!$(e.target).closest('.filter-tab').length &&
					!$(e.target).closest('#sidebar_left').length &&
					$sidebarLeft.hasClass('open')) {
					$sidebarLeft.removeClass('open');
					loadDegreeSearchResults();
				}
			}

			function setupEventHandlers() {
				if($academicsSearch.find('.filter-tab').is(':visible')) {
					// mobile
					$academicsSearch.one('click', '.filter-tab', initFilterClickHandler);
					$academicsSearch.on('click', '.filter-tab', filterClickHandler);
					$academicsSearch.on('change', '.sort-by', degreeSearchChangeHandler);
				} else {
					// desktop
					$academicsSearch.on('change', '.program-type, .location, .college, .sort-by', degreeSearchChangeHandler);
				}
				$academicsSearch.on('change', '.search-query', searchQueryKeyUpHandler);
			}

			function initPage() {
				$academicsSearch = $('#academics_search');
				$degreeSearchResultsContainer = $academicsSearch.find('.degree-search-results-container');
				$sidebarLeft = $academicsSearch.find("#sidebar_left");
				setupEventHandlers();
			}

			$(initPage);

			function compareChangeHandler(e) {
				if($(e.target).is(':checked') && $academicsSearch.find('.compareCheckbox:checked').length > 1) {
					$(e.target).next().html('<a href="/compare-degrees/">compare now</a>');
				} else {
					$academicsSearch.find('.compareCheckbox').each(function() {
						$(this).next().text('compare');
					});
				}
			}

			function initAutoComplete() {
				// Workaround for bug in mouse item selection
				$.fn.typeahead.Constructor.prototype.blur = function() {
				    var that = this;
				    setTimeout(function () { that.hide(); }, 250);
				};

				$academicsSearch.find('.search-query').typeahead({
				    source: function(query, process) {
				        return ["Arts & Humanities", "Business Administration", "Education & Human Performance", "Engineering & Computer Science", "Graduate Studies", "Health & Public Affairs", "Honors", "Hospitality Management", "Medicine", "Nursing", "Optics & Photonics", "Sciences"];
				    }
				});
			}

			$(initAutoComplete);

			function initCompare() {
				$academicsSearch.on('change', '.compareCheckbox', compareChangeHandler);
			}

			$(initCompare);

		})();
	</script>

<?php get_footer(); ?>
