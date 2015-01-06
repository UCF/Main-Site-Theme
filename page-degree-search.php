<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	.input-append .btn-group > .btn:first-child {
		border-bottom-left-radius: 0;
		border-top-left-radius: 0;
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
	#sidebar_left ul {
		list-style-type: none;
		margin-bottom: 15px;
		margin-left: 0;
	}
	#sidebar_left ul li {
		padding-bottom: 6px;
	}
	#sidebar_left label {
		font-size: 14px;
	}


/*	#contentcol .degree-img-container {
		margin-top: 30px;
		margin-bottom: 20px;
	}*/


	#contentcol .degree-search-form {
		margin-top: 10px;
	}


	#contentcol .degree-search-header {
		color: #888;
		font-size: 24px;
		line-height: 1.4;
		margin-top: 25px;
		margin-bottom: 10px;
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
	#contentcol .degree-detail-label {
		font-weight: 500;
	}

	#contentcol .degree-desc {
		margin-top: 10px;
		margin-bottom: 5px;
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

		<div id="sidebar_left" class="span3" role="navigation">
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


				<!-- Degree image row -->
<!--
				<div class="row degree-img-container">
					<div class="span2">
						<a href="#">
							<img src="img/undergraduate.jpg">
							<div class="degree-heading">
								<div class="checkbox">
									<label>
										<input type="checkbox" checked> Undergraduate
									</label>
								</div>
							</div>
						</a>
					</div>
					<div class="span2">
						<a href="#">
							<img src="img/graduate.jpg" class="unselected">
							<div class="degree-heading">
								<div class="checkbox">
									<label>
										<input type="checkbox"> Graduate
									</label>
								</div>
							</div>
						</a>
					</div>
					<div class="span2">
						<a href="#">
							<img src="img/minor.jpg" class="unselected">
							<div class="degree-heading">
								<div class="checkbox">
									<label>
										<input type="checkbox"> Minor
									</label>
								</div>
							</div>
						</a>
					</div>
					<div class="span2">
						<a href="#">
							<img src="img/certificate.jpg" class="unselected">
							<div class="degree-heading">
								<div class="checkbox">
									<label>
										<input type="checkbox"> Certificate
									</label>
								</div>
							</div>
						</a>
					</div>
				</div>
-->
				<!-- Search input -->

				<div class="degree-search-form form-search">
					<div class="input-append">
						<input type="text" class="span6 search-query" placeholder="Find programs by name or keyword...">
						<button class="btn btn-primary" type="button">Search</button>
					</div>
				</div>

				<!-- Search Results -->

				<h2 class="degree-search-header">234 Results for: <em>Undergraduate</em></h2>

				<div class="degree-search-sort">
					<strong class="degree-search-sort-label radio inline">Sort results by:</strong>
					<label class="radio inline">
						<input type="radio" name="sortby"> Name
					</label>
					<label class="radio inline">
						<input type="radio" name="sortby"> Credit Hours
					</label>
				</div>

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
						<p class="degree-desc">
							The objective of the Accounting track in the Business Administration PhD program is to prepare students for academic careers in higher education and management careers within profit and nonprofit organizations. Success in the program is judged by the student’s understanding of the issues and methodologies essential to the advancement of knowledge.
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
						<p class="degree-desc">
							The objective of the Finance track in the Business Administration PhD program is to prepare students for academic careers in higher education and management careers within profit and nonprofit organizations. Success in the program is judged by the student’s understanding of the issues and methodologies essential to the advancement of knowledge.
						</p>
						<a class="degree-search-result-link" href="#">Read more about the Finance degree.</a>
					</li>
				</ul>

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
		// (function() {
		// var $degreeImgContainer = $('.degree-img-container');

		// function degreeImageClickHandler( e ) {

		// 	var $target = $(this),
		// 		$img = $target.find('img'),
		// 		$checkbox = $target.find('input');

		// 	if($target !== $checkbox) {
		// 	e.preventDefault();
		// 	}

		// 	$img.toggleClass('unselected');

		// 	$checkbox.prop( 'checked', !$img.hasClass('unselected') );

		// }

		// function initDegreePage() {
		// 	$degreeImgContainer.on('click', 'a', degreeImageClickHandler);
		// }

		// $(initDegreePage);
		// }());
	</script>
<?php get_footer(); ?>
