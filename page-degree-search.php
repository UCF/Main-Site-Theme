<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	#sidebar_left,
	#contentcol,
	#contentcol input {
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
		margin-left: 0;
	}
	#sidebar_left li {
		margin-bottom: 8px;
	}
	#sidebar_left label {
		font-size: 14px;
	}


	#contentcol .degree-img-container {
		margin-top: 30px;
		margin-bottom: 20px;
	}


	#contentcol .degree-search-header {
		color: #888;
		font-size: 24px;
		line-height: 1.4;
		margin-top: 30px;
		margin-bottom: 30px;
	}
	#contentcol .degree-search-header em {
		font-weight: 500;
	}


	#contentcol .degree-search-results {
		list-style-type: none;
		margin-left: -20px;
	}
	#contentcol .degree-search-result {
		border-bottom: 1px solid #e5e5e5;
		margin-bottom: 20px;
		padding: 10px 20px;
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

	#contentcol .degree-desc {
		margin-top: 10px;
		margin-bottom: 5px;
	}

	#contentcol .degree-search-result-link {
		border: 0 solid transparent !important;
		display: block;
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
			<h2>Filter by College</h2>
			<ul>
				<li class="checkbox">
				<label>
					<input type="checkbox"> Arts and Humanities
				</label>
				</li>
				<li class="checkbox">
				<label>
					<input type="checkbox" checked> Business Administration
				</label>
				</li>
				<li class="checkbox">
				<label>
					<input type="checkbox"> Education and Human Performance
				</label>
				</li>
				<li class="checkbox">
				<label>
					<input type="checkbox"> Engineering and Computer Science
				</label>
				</li>
			</ul>
		</div>

		<div class="span9" id="contentcol">
			<article role="main">
				<?php the_content(); ?>


				<!-- Degree image row -->

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

				<!-- Search input -->

				<div class="degree-search-form">
					<div class="input-append">

						<input type="text" class="span5" placeholder="Enter search term">

						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Sort: Name
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="#">Name</a>
								</li>
								<li>
									<a href="#">Hours</a>
								</li>
							</ul>
						</div>

						<button class="btn btn-primary" type="button"><i class="icon-white icon-search"></i></button>

					</div>
				</div>

				<!-- Search Results -->

				<h2 class="degree-search-header">234 Results for: <em>Undergraduate</em></h2>

				<ul class="degree-search-results">
					<li class="degree-search-result">
						<h3 class="degree-title">
							<a href="#">Accounting</a>
							<span class="degree-credits-count">&mdash; 140 credit hours</span>
						</h3>
						<span class="degree-college">College of Business Administration</span>
						<span class="degree-dept">
							<strong>Department:</strong> Kenneth G. Dixon School of Accounting
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
							<strong>Department:</strong> Finance
						</span>
						<p class="degree-desc">
							The objective of the Finance track in the Business Administration PhD program is to prepare students for academic careers in higher education and management careers within profit and nonprofit organizations. Success in the program is judged by the student’s understanding of the issues and methodologies essential to the advancement of knowledge.
						</p>
						<a class="degree-search-result-link" href="#">Read more about the Finance degree.</a>
					</li>
				</ul>

				<br>

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
		(function() {
		var $degreeImgContainer = $('.degree-img-container');

		function degreeImageClickHandler( e ) {

			var $target = $(this),
				$img = $target.find('img'),
				$checkbox = $target.find('input');

			if($target !== $checkbox) {
			e.preventDefault();
			}

			$img.toggleClass('unselected');

			$checkbox.prop( 'checked', !$img.hasClass('unselected') );

		}

		function initDegreePage() {
			$degreeImgContainer.on('click', 'a', degreeImageClickHandler);
		}

		$(initDegreePage);
		}());
	</script>
<?php get_footer(); ?>
