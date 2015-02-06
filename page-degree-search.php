<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/


	 body {
	 	margin-left:0 !important;
	 }

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
	#contentcol option,
	.page-content {
		font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
		font-size: 14px;
	}

	.page-content .intro h2 {
		font-weight: 400;
	}

	.page-content .intro p {
		font-size: 16px;
		line-height: 24px;
		font-weight: 400;
	}

	.page-content .intro blockquote {
		font-size: 16px;
		color: #888;
		line-height: 30px;
	}

	#sidebar_left {
		background-color: #eee;
	}

	@media (max-width: 767px) {

		#sidebar_left {
			font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
			display: none;
			width: 300px;
			background-color: #eee;
			-webkit-box-shadow: 5px 0px 20px -5px rgba(0,0,0,0.30);
			-moz-box-shadow: 5px 0px 20px -5px rgba(0,0,0,0.30);
			box-shadow: 5px 0px 20px -5px rgba(0,0,0,0.30);
			border-right: 1px solid #ccc;
			border-top: none;
			margin-top: 0;
			padding-top: 0;
		}

		#sidebar_left.open {
			transform: scaleX(1);
			-webkit-transform: scaleX(1);
		}

		#sidebar_left .header {
			background-color: #888;
			color: #fff;
			font-weight: normal;
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
		font-weight: normal;
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
		font-size: 12px;
	}

	.degree-search-filters .degree-count {
		color: #888;
		font-size: 12px;
	}

	#contentcol .degree-search-form {
		margin-top: 10px;
	}

	.filter-tab {
		background-color: #666;
		font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
		line-height: 16px;
		right: 0;
		cursor: pointer;
		position: fixed;
		top: 205px;
		width: 9px;
		color: white;
		padding: 6px;
	}

	.filter-tab:hover {
		color: white;
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

        -webkit-transition: background 0.3s linear;
        -moz-transition: background 0.3s linear;
        -ms-transition: background 0.3s linear;
        -o-transition: background 0.3s linear;
        transition: background 0.3s linear;
    }

	.background-hover-fade-in:hover,
	.background-hover-fade-in:active,
	.background-hover-fade-in:focus {
        background-color:#ddd;
    }

	.fade {
		opacity: 0;

		-webkit-transition: opacity .3s ease-in-out;
		-moz-transition: opacity .3s ease-in-out;
		-ms-transition: opacity .3s ease-in-out;
		-o-transition: opacity .3s ease-in-out;
		transition: opacity .3s ease-in-out;
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

		$data = json_decode( file_get_contents( THEME_URL . '/page-degree-search-results.php?' . http_build_query($params) ), true );
		// var_dump($data);
	?>

	<div class="row page-content" id="academics_search">
		<a class="filter-tab visible-phone" href="#sidebar_left">F<br>I<br>L<br>T<br>E<br>R<br></a>

		<form>

			<div class="span12" id="page_title">
				<h1 class="span8"><?php the_title();?></h1>
				<?php esi_include('output_weather_data','span4'); ?>
			</div>

			<div class="span12 intro">
				<?php the_content(); ?>
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
									<span>Bachelor</span> <span class="degree-count">(181)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="graduate-degree" type="checkbox"
									<?php if( in_array( 'graduate-degree', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Master</span> <span class="degree-count">(85)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="minor" type="checkbox"
									<?php if( in_array( 'minor', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Doctorate</span> <span class="degree-count">(53)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="minor" type="checkbox"
									<?php if( in_array( 'minor', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Minor</span> <span class="degree-count">(125)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="program-type[]" class="program-type" value="certificate" type="checkbox"
									<?php if( in_array( 'certificate', $params['program-type'] ) ) { echo 'checked'; } ?>>
									<span>Certificate</span> <span class="degree-count">(45)</span>
							</label>
						</li>
					</ul>

					<h2>Location</h2>
					<ul>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="main-campus" type="checkbox"
									<?php if( empty( $params['location'] ) || in_array( 'main-campus', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Main Campus</span> <span class="degree-count">(143)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="online" type="checkbox"
									<?php if( in_array( 'online', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Online Courses Available</span> <span class="degree-count">(120)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="altamonte-springs" type="checkbox"
									<?php if( in_array( 'certificate', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Altamonte Springs</span> <span class="degree-count">(45)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="cocoa" type="checkbox"
									<?php if( in_array( 'cocoa', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Cocoa</span> <span class="degree-count">(34)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="daytona-beach" type="checkbox"
									<?php if( in_array( 'daytona-beach', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Daytona Beach</span> <span class="degree-count">(15)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="leesburg" type="checkbox"
									<?php if( in_array( 'leesburg', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Leesburg</span> <span class="degree-count">(12)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="ocala" type="checkbox"
									<?php if( in_array( 'ocala', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Ocala</span> <span class="degree-count">(56)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="location[]" class="location" value="palm-bay" type="checkbox"
									<?php if( in_array( 'palm-bay', $params['location'] ) ) { echo 'checked'; } ?>>
									<span>Palm Bay</span> <span class="degree-count">(23)</span>
							</label>
						</li>
					</ul>

					<h2>Colleges</h2>
					<ul>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Arts_Humanities" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Arts_Humanities", $_GET['college'])) echo "checked";?>>
								<span>Arts &amp; Humanities</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Business_Administration" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Business_Administration", $_GET['college'])) echo "checked";?>>
								<span>Business Administration</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Education_Human_Performance" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Education_Human_Performance", $_GET['college'])) echo "checked";?>>
								<span>Education &amp; Human Performance</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Engineering_Computer_Science" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Engineering_Computer_Science", $_GET['college'])) echo "checked";?>>
								<span>Engineering &amp; Computer Science</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Graduate_Studies" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Graduate_Studies", $_GET['college'])) echo "checked";?>>
								<span>Graduate Studies</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Health_Public_Affairs" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Health_Public_Affairs", $_GET['college'])) echo "checked";?>>
								<span>Health &amp; Public Affairs</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Honors" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Honors", $_GET['college'])) echo "checked";?>>
								<span>Honors</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Hospitality_Management" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Hospitality_Management", $_GET['college'])) echo "checked";?>>
								<span>Hospitality Management</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Medicine" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Medicine", $_GET['college'])) echo "checked";?>>
								<span>Medicine</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Nursing" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Nursing", $_GET['college'])) echo "checked";?>>
								<span>Nursing</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Optics_Photonics" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Optics_Photonics", $_GET['college'])) echo "checked";?>>
								<span>Optics &amp; Photonics</span> <span class="degree-count">(23)</span>
							</label>
						</li>
						<li class="checkbox background-hover-fade-in">
							<label>
								<input name="college[]" class="college" value="Sciences" type="checkbox"
								<?php if (isset($_GET['college']) && in_array("Sciences", $_GET['college'])) echo "checked";?>>
								<span>Sciences</span> <span class="degree-count">(23)</span>
							</label>
						</li>
					</ul>
				</div>
			</div>

			<div class="span8" id="contentcol">
				<article role="main">

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
						<div class="degree-search-header pull-right">181 results</div>
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

	<script src="<?php bloginfo('template_url'); ?>/static/js/jquery.panelslider.js"></script>

	<script>

		(function() {

			var $academicsSearch,
				$degreeSearchResultsContainer,
				$sidebarLeft;

			function degreeSearchSuccessHandler( data ) {
				$degreeSearchResultsContainer.find('li').removeClass('fade-in');
				$degreeSearchResultsContainer.html(data.markup);
				$academicsSearch.find('.degree-search-header').text(data.count + " results");
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
					// prevent action until user is done typing (debounce)
					if(timer) {
						clearTimeout(timer);
					}
					timer = setTimeout(loadDegreeSearchResults, 250);
				}
			}

			function onPanelOpen() {
				// resize the panel to be full screen and align it, doesn't resize properly on page load
				$sidebarLeft
					.height($(document).height())
					// setting the click handler on page load fails
					.one('click', '.close', closePanel);
				$(window).scrollTop(0);
			}

			function onPanelClose() {
				loadDegreeSearchResults();
			}

			function closePanel() {
				$.panelslider.close();
			}

			function setupEventHandlers() {
				if($academicsSearch.find('.filter-tab').is(':visible')) {
					// mobile
					$academicsSearch.find('.filter-tab').panelslider({
						'slideType': 'push',
						'side': 'right',
						onOpen: onPanelOpen,
						onClose: onPanelClose
					});
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

			function compareChangeHandler(e) {
				if($(e.target).is(':checked') && $academicsSearch.find('.compareCheckbox:checked').length > 1) {
					$(e.target).next().html('<a href="/compare-degrees/">compare now</a>');
				} else {
					$academicsSearch.find('.compareCheckbox').each(function() {
						$(this).next().text('compare');
					});
				}
			}

			$(initCompare);

		})();
	</script>

<?php get_footer(); ?>
