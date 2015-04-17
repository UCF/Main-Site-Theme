<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	/*
	 * General Site Styles
	 */

	@media (max-width: 767px) {
		/* Reduce whitespace between page title and content */
		.subpage .page-content #page_title {
			margin-bottom: 15px;
			padding-bottom: 5px;
		}

		#academics-search input[type="checkbox"] {
			/* Help mobile users and provide larger checkboxes when possible */
			transform: scale(1.25);
			-webkit-transform: scale(1.25);
		}
	}

	/* Make disabled buttons look more disabled */
	#academics-search a.btn.disabled,
	#academics-search a.btn.disabled:hover,
	#academics-search a.btn.disabled:active,
	#academics-search a.btn.disabled:focus {
		color: #888 !important;
	}


	/*
	 * General content/sidebar styles
	 */

	/* Reset this template's fonts to Helvetica */
	#degree-search-top,
	#degree-search-top input,
	#degree-search-top select,
	#degree-search-top option,
	#degree-search-sidebar,
	#degree-search-sidebar input,
	#degree-search-sidebar select,
	#degree-search-sidebar option,
	#degree-search-content,
	#degree-search-content input,
	#degree-search-content select,
	#degree-search-content option {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}


	/*
	 * Sidebar page-specific styles
	 */

	/* Sidebar headings */
	#degree-search-sidebar .degree-filter-title {
		color: #888;
		font-size: 18px;
		font-weight: 500;
	}

	/* Sidebar filter lists */
	#degree-search-sidebar .degree-filter-list {
		list-style-type: none;
		margin-bottom: 15px;
		margin-left: 0;
	}
	#degree-search-sidebar .degree-filter-list li {
		padding-bottom: 6px;
	}
	#degree-search-sidebar label {
		font-size: 14px;
	}
	#degree-search-sidebar input:checked + span,
	#degree-search-sidebar input:checked ~ .filter-result-count {
		font-weight: bold;
	}
	#degree-search-sidebar .filter-result-count {
		color: #888;
	}

	#degree-search-sidebar .degree-infobox-toggle {
		border-bottom: 0 solid transparent !important;
		display: block;
		float: right;
		margin-right: 15px;
		padding-left: 5px;
	}
	#degree-search-sidebar .degree-infobox-toggle .icon {
		padding-bottom: 3px;
		border-bottom: 1px dotted #999;
	}
	#degree-search-sidebar .popover-title {
		display: none; /* hide empty titles */
	}
	#degree-search-sidebar .popover {
		font-size: 12px;
		line-height: 1.4;
		font-weight: normal;
	}
	@media (max-width: 767px) {
		#degree-search-sidebar .popover-content {
			max-height: 250px;
			overflow-x: hidden;
			overflow-y: scroll;
			-webkit-overflow-scrolling: touch;
		}
	}

	@media (max-width: 767px) {

		/* Mobile sidebar filter "modal" */
		#degree-search-sidebar {
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
			width: 92%; /* pre android v4.4 :( */
			width: calc(100% - 30px);
			z-index: 999;
		}
		#degree-search-sidebar.active {
			opacity: 1;
			pointer-events: all;
		}

		/* Modal - General */
		#degree-search-sidebar select {
			margin-bottom: 0;
			width: 55%;
		}
		#degree-search-sidebar label {
			font-size: 12.5px;
			line-height: 1.2;
			margin: 0;
			padding: 5px 5px 5px 25px;
		}

		/* Modal head */
		#degree-search-sidebar .degree-mobile-actions {
			background: #eee;
			border-radius: 5px 5px 0 0;
			padding: 8px;
			position: relative;
			position: -webkit-sticky; /* we can at least give ios users a fixed top bar */
			top: -1px; /* Hide un-styleable outline on #degree-search-sidebar:target */
		}

		/* Modal sorting */
		#degree-search-sidebar .degree-search-sort {
			border-bottom: 1px solid #eee;
			margin-bottom: 5px;
			padding: 10px;
		}
		#degree-search-sidebar .degree-search-sort select {
			font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		}

		/* Modal filters */
		#degree-search-sidebar .degree-filter-list,
		#degree-search-sidebar .degree-filter-title {
			padding-left: 10px;
			padding-right: 10px;
		}
		#degree-search-sidebar .degree-filter-list {
			margin-bottom: 10px;
		}
		#degree-search-sidebar .degree-filter-list li {
			border-top: 1px solid #eee;
			box-sizing: border-box;
			margin: 0 4px;
			padding: 4px 0;
			text-align: left;
		}
		#degree-search-sidebar .degree-filter-list li:first-child {
			border-top: 0 solid transparent;
		}

		#degree-search-sidebar .degree-filter-title {
			font-size: 14px;
			line-height: 1.4;
			margin: 15px 0 5px;
		}
		#degree-search-sidebar .degree-search-sort .degree-filter-title {
			margin-top: 6px;
			padding: 0;
		}

		#degree-search-sidebar .checkbox input[type="checkbox"] {
			margin-right: 10px;
			margin-top: 0;
		}
	}


	/*
	 * Page content page-specific styles
	 */

	#degree-search-top {
		margin-bottom: 10px;
	}
	@media (max-width: 767px) {
		#degree-search-top {
			margin-bottom: 0;
		}
	}

	/* Search field wrapper */
	#degree-search-top .degree-search-form {
		margin-top: 20px;
	}
	@media (max-width: 767px) {
		#degree-search-top .degree-search-form .input-append {
			width: 100%;
		}
		#degree-search-top .degree-search-form .search-query {
			width: 80%;
			width: calc(100% - 40px);
		}
	}

	/* Search Result Title + Sorting (desktop) */
	#degree-search-top .degree-search-sort {
		border-bottom: 1px solid #e5e5e5;
		margin-top: 20px;
		width: 100%;
	}
	#degree-search-top .degree-search-sort-inner {
		display: table-cell;
		padding-bottom: 10px;
		vertical-align: middle;
	}
	@media (max-width: 979px) {
		/* We assume that browsers that support media queries can support box-sizing */
		#degree-search-top .degree-search-sort-inner {
			box-sizing: border-box;
		}
	}
	@media (max-width: 767px) {
		#degree-search-top .degree-search-sort-inner {
			display: block;
		}
	}

	#degree-search-top .degree-result-count {
		border-right: 1px solid #eee;
		font-size: 16px;
		font-weight: bold;
		line-height: 20px;
		padding-right: 15px;
		padding-top: 5px;
		width: 70%;
	}
	#degree-search-top .degree-result-count .result {
		font-style: italic;
		font-weight: 400;
	}
	@media (max-width: 767px) {
		#degree-search-top .degree-result-count .for,
		#degree-search-top .degree-result-count .result {
			display: none;
		}
	}
	#degree-search-top .degree-search-sort-options {
		padding-left: 15px;
		width: 26%; /* widths don't add up to 100% here to avoid ie7-specific overrides (which doesn't support box-sizing) */
	}
	@media (max-width: 979px) {
		#degree-search-top .degree-result-count {
			width: 62%;
		}
		#degree-search-top .degree-search-sort-options {
			width: 34%;
		}
	}
	@media (max-width: 767px) {
		#degree-search-top .degree-result-count {
			border-right: 0 solid transparent;
			font-style: italic;
			font-weight: normal;
			float: left;
			padding-right: 0;
			width: auto;
		}
		#degree-search-top .degree-search-sort-options {
			border-left: 1px solid #eee;
			float: right;
			width: auto;
			padding-bottom: 5px;
		}
	}
	#degree-search-top .degree-search-sort-label {
		padding-left: 0;
	}

	/* Results wrapper */
	#degree-search-content .degree-search-results-container {
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
	#degree-search-content .degree-search-results-container .no-results {
		margin-top: 20px;
	}

	/* Results list */
	#degree-search-content .degree-search-results {
		list-style-type: none;
		margin-left: 0;
		margin-top: 15px;
	}
	#degree-search-content .degree-search-result {
		box-sizing: border-box;
		display: table;
		width: 100%;
		margin-bottom: 0;
		padding: 12px 15px;
		position: relative;
	}
	#degree-search-content .degree-search-result:nth-child(2n) {
		background-color: #fafafa;
	}
	#degree-search-content .degree-search-result:hover,
	#degree-search-content .degree-search-result:active,
	#degree-search-content .degree-search-result:focus {
		background-color: #eee;
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-search-result {
			border-top: 1px solid #eee;
			margin-top: 10px;
			padding: 10px 0 0 0;
		}
		#degree-search-content .degree-search-result:hover,
		#degree-search-content .degree-search-result:active,
		#degree-search-content .degree-search-result:focus {
			background-color: transparent;
		}
		#degree-search-content .degree-search-result:first-child {
			border-top: 0 solid transparent;
		}
		#degree-search-content .degree-search-result:nth-child(2n) {
			background-color: transparent;
		}
	}

	/* Single result elements */
	#degree-search-content .degree-title {
		display: table-cell;
		vertical-align: middle;
		font-size: 18px;
		margin-bottom: 8px;
		width: 57%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#degree-search-content .degree-title {
			width: 60%;
		}
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-title {
			display: block;
			float: left;
			font-size: 15px;
			line-height: 1.1;
			margin-bottom: 4px;
			width: 100%;
		}
	}
	#degree-search-content .degree-title a {
		border: 0 solid transparent;
		color: #08c;
		font-weight: 500;
	}
	#degree-search-content .degree-credits-count {
		color: #888;
		font-size: 13px;
		font-weight: normal;
		display: block;
		line-height: 1.2;
		margin-top: 4px;
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-credits-count {
			font-size: 11.5px;
		}
	}

	#degree-search-content .degree-online {
		box-sizing: border-box;
		display: table-cell;
		font-size: 11.5px;
		font-weight: 500;
		padding: 0 10px;
		vertical-align: middle;
		width: 12%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#degree-search-content .degree-online {
			width: 16%;
		}
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-online {
			clear: both;
			display: block;
			margin-top: 8px;
			padding: 0;
			width: 100%;
		}
	}

	#degree-search-content .degree-compare {
		display: table-cell;
		vertical-align: middle;
		width: 14%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#degree-search-content .degree-compare {
			width: 20%;
		}
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-compare {
			box-sizing: border-box;
			padding-left: 12px;
			width: 17%;
		}
	}
	@media (max-width: 480px) {
		#degree-search-content .degree-compare {
			width: 22%;
		}
	}
	@media (max-width: 380px) {
		#degree-search-content .degree-compare {
			width: 28%;
		}
	}
	#degree-search-content .degree-compare-label {
		color: #888;
		display: inline-block;
		font-size: 11px;
		margin-bottom: 0;
		vertical-align: middle;
	}
	@media (max-width: 979px) {
		#degree-search-content .degree-compare-label {
			font-size: 10px;
		}
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-compare-label {
			line-height: 1.2;
			text-align: center;
		}
	}
	#degree-search-content .degree-compare-label:hover,
	#degree-search-content .degree-compare-label:active,
	#degree-search-content .degree-compare-label:focus {
		color: #08c;
	}
/*	#degree-search-content .degree-search-result.compare-active {
		background-color: #d9edf7;
	}
	@media (max-width: 767px) {
		#degree-search-content .degree-search-result.compare-active {
			background-color: transparent;
		}
	}*/
	#degree-search-content .degree-search-result.compare-active .degree-compare-label span {
		display: none;
	}
	#degree-search-content .degree-compare-input:disabled + span,
	#degree-search-content .degree-compare-input:disabled + span:hover,
	#degree-search-content .degree-compare-input:disabled + span:active,
	#degree-search-content .degree-compare-input:disabled + span:focus {
		color: #ccc;
		cursor: not-allowed;
	}

	#degree-search-content .degree-compare-submit {
		display: none;
		margin-left: 5px;
		vertical-align: middle;
	}
	#degree-search-content .degree-search-result.compare-active .degree-compare-submit {
		display: inline-block;
	}

	#degree-search-content .degree-compare-selected-count {
		color: #888;
		display: none;
		font-size: 10px;
		font-style: italic;
		text-align: center;
	}
	#degree-search-content .degree-search-result.compare-active .degree-compare-selected-count {
		display: block;
	}

	</style>

	<?php

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

				<div class="degree-search-form form-search">
					<div class="input-append">
						<input id="search-query" type="text" autocomplete="off" data-provide="typeahead" name="search-query" class="span7 search-query" placeholder="Find programs by name or keyword..." value="<?php echo $_GET['search-query']; ?>">
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
