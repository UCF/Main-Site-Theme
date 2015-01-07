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


/*	#contentcol .degree-mobile-controls {
		text-align: center;
	}*/

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


	<?php $degrees = get_degree_search_data(); ?>
	<div class="row page-content" id="academics-search">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<!-- Sidebar (Desktop only) -->

		<div id="sidebar_left" class="span3 degree-search-filters hidden-phone">
			<h2>Program Types</h2>
			<ul>
				<li class="checkbox">
					<label>
						<input type="checkbox" checked> Undergraduate
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Graduate
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Minor
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Certificate
					</label>
				</li>
			</ul>

			<h2>Colleges</h2>
			<ul>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Arts &amp; Humanities
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox" checked> Business Administration
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Education &amp; Human Performance
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Engineering &amp; Computer Science
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Graduate Studies
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Health &amp; Public Affairs
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Honors
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Hospitality Management
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Medicine
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Nursing
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Optics &amp; Photonics
					</label>
				</li>
				<li class="checkbox">
					<label>
						<input type="checkbox"> Sciences
					</label>
				</li>
			</ul>
		</div>

		<div class="span9" id="contentcol">
			<article role="main">

				<!-- Search input -->

				<div class="degree-search-form form-search">
					<div class="input-append">
						<input type="text" class="span6 search-query" placeholder="Find programs by name or keyword...">
						<button class="btn btn-primary" type="button">Search</button>
					</div>
				</div>

				<!-- Search Result Header: Desktop -->

				<h2 class="degree-search-header">234 Results for: <em>Undergraduate</em></h2>

				<div class="degree-search-sort hidden-phone">
					<strong class="degree-search-sort-label radio inline">Sort results by:</strong>
					<label class="radio inline">
						<input type="radio" name="sortby"> Name
					</label>
					<label class="radio inline">
						<input type="radio" name="sortby"> Credit Hours
					</label>
				</div>

				<!-- Search Result Header: Mobile -->

				<div class="degree-mobile-controls visible-phone">
					<div class="dropdown degree-search-sort degree-mobile-control">
						<a class="btn btn-link dropdown-toggle" data-toggle="dropdown" href="#">
							Sort By <span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-form pull-left">
							<label class="radio">
								<input type="radio" name="sortby"> Name
							</label>
							<label class="radio">
								<input type="radio" name="sortby"> Credit Hours
							</label>
						</div>
					</div>

					<div class="dropdown degree-search-filters degree-mobile-control">
						<a class="btn btn-link dropdown-toggle" data-toggle="dropdown" href="#">
							Filter Results <span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-form pull-right">
							<span class="dropdown-menu-heading">Program Types</span>
							<ul>
								<li class="checkbox">
									<label>
										<input type="checkbox" checked> Undergraduate
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Graduate
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Minor
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Certificate
									</label>
								</li>
							</ul>

							<span class="dropdown-menu-heading">Colleges</span>
							<ul>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Arts &amp; Humanities
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox" checked> Business Administration
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Education &amp; Human Performance
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Engineering &amp; Computer Science
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Graduate Studies
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Health &amp; Public Affairs
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Honors
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Hospitality Management
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Medicine
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Nursing
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Optics &amp; Photonics
									</label>
								</li>
								<li class="checkbox">
									<label>
										<input type="checkbox"> Sciences
									</label>
								</li>
							</ul>
						</div>
					</div>

				</div>

				<!-- Search Results -->

				<ul class="degree-search-results">
					<li class="degree-search-result">
						<h3 class="degree-title">
							<a href="#">Accounting</a>
							<span class="degree-credits-count">&mdash; 140 credit hours</span>
						</h3>
						<span class="degree-college">College of Business Administration</span>
						<span class="degree-dept">
							<span class="degree-detail-label">Department:</span> Kenneth G. Dixon School of Accounting
						</span>
						<p class="degree-desc hidden-phone">
							The objective of the Accounting track in the Business Administration PhD program is to prepare
							students for academic careers in higher education and management careers within profit and
							nonprofit organizations. Success in the program is judged by the student’s understanding of
							the issues and methodologies essential to the advancement of knowledge.
						</p>
						<p class="degree-desc visible-phone">
							The objective of the Accounting track in the Business Administration PhD program is to prepare
							students for academic careers in higher education and management careers within profit and
							nonprofit organizations.&hellip;
						</p>
						<a class="degree-search-result-link" href="#">Read more about the Accounting degree.</a>
					</li>

					<li class="degree-search-result">
						<h3 class="degree-title">
							<a href="#">Finance</a>
							<span class="degree-credits-count">&mdash; 140 credit hours</span>
						</h3>
						<span class="degree-college">College of Business Administration</span>
						<span class="degree-dept">
							<span class="degree-detail-label">Department:</span> Finance
						</span>
						<p class="degree-desc hidden-phone">
							The objective of the Finance track in the Business Administration PhD program is to prepare
							students for academic careers in higher education and management careers within profit and
							nonprofit organizations. Success in the program is judged by the student’s understanding of
							the issues and methodologies essential to the advancement of knowledge.
						</p>
						<p class="degree-desc visible-phone">
							The objective of the Finance track in the Business Administration PhD program is to prepare
							students for academic careers in higher education and management careers within profit and
							nonprofit organizations.&hellip;
						</p>
						<a class="degree-search-result-link" href="#">Read more about the Finance degree.</a>
					</li>
				</ul>

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
	</div>

	<script>
		/**
		 * TODO: move to script.js when design drafting is finished!
		 **/
		$(document).ready(function() {
			// Allow Bootstrap dropdown menus to have forms/checkboxes inside,
			// and when clicking on a dropdown item, the menu doesn't disappear.
			$(document).on('click', '.dropdown-menu-form', function(e) {
				e.stopPropagation();
			});

			// Make sure mobile users don't have to scroll down to view
			// .dropdown-menu-form contents (and subsequently close the dropdown)
			// TODO: fix clickable box area bugginess in iOS
			var $mobileControlBtn = $('.degree-mobile-control > .dropdown-toggle');
			$mobileControlBtn.on('click', function(e) {
				if ($(window).width() < 768) {
					$('html, body').animate({
						scrollTop: $(this).offset().top,
					}, 200);
				}
			});
		});
	</script>
<?php get_footer(); ?>
