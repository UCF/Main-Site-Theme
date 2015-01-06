<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	.degree-container .degree-header-img {
		margin: 20px 0;
	}
	.degree-container a {
		color: #08c;
	}
	.degree-container .overview-table {
		margin-top: 10px;
		width: 100%;
	}
	.degree-container .overview-table td {
		padding: 5px 0;
	}
	.degree-container .degree-sm-column .apply-button {
		font-size: 18px;
		font-weight: bold;
		margin-top: 20px;
		padding: 10px 15px;
		width: 100%;
	}
	.degree-container .degree-sm-column ul {
		padding-left: 0;
	}
	.degree-container .degree-sm-column ul li {
		list-style: none;
		margin-bottom: 5px;
	}
	.degree-container .degree-overview {
		margin-bottom: 30px;
		margin-top: 20px;
	}
	.degree-container h4.header {
		color: gray;
		margin-top: 30px;
	}
	.degree-container .deadline-comments {
		color: #999999;
	}
	.degree-container #contact h5 {
		margin-bottom: 7px;
		margin-top: 20px;
	}
	.degree-container .no-wrap {
		white-space: nowrap;
	}

	.degree-search .degree-sm-column .checkbox {
		margin: 10px 0;
	}
	.degree-search .degree-search-results {
		margin-top: 30px;
	}
	.degree-search .degree-search-result {
		border-bottom: 1px #ccc solid;
		margin-top: 20px;
	}
	.degree-search .degree-search-result:hover {
		background-color: #eee;
		cursor: pointer;
	}
	.degree-search .degree-search-result label {
		font-weight: normal;
		margin-bottom: 0;
	}
	.degree-search .degree-search-result p {
		margin-top: 8px;
	}
	.degree-search .degree-search-results-count {
		margin-top: 5px;
		text-align: right;
	}
	.degree-search .degree-search-credits-count {
		color: gray;
		font-size: 14px;
		font-weight: normal;
		margin-top: 10px;
		text-align: right;
	}
	.degree-search .degree-search-header {
		color: gray;
		margin: 0;
	}
	.degree-search .degree-img-container {
		margin: 40px 0;
	}
	.degree-search .degree-img-container a {
		color: #000;
		text-decoration: underline;
	}
	.degree-search .degree-img-container .unselected {
		opacity: .7;
	}
	.degree-search .degree-img-container .checkbox {
		margin: 0;
	}
	.degree-search .degree-heading {
		position: absolute;
		top: 80%;
		padding-left: 5%;
		background: white;
		width: 100%;
		opacity: 0.8;
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

				<div class="row">
					<div class="span9">
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
				</div>

				<!-- Search Results -->

				<h2 class="degree-search-header">234 Results for: <em>Undergraduate</em></h2>

				<div class="row degree-search-result">
					<div class="span9">
						<h3 class="degree-title">
							<a href="degree.html">Accounting</a>
							<span class="degree-credits-count">&mdash; 140 credit hours</span>
						</h3>
						<span class="degree-college">College of Business Administration</span>
						<span class="degree-dept">
							<strong>Department:</strong> Kenneth G. Dixon School of Accounting
						</span>
						<p class="degree-desc">
							The objective of the Accounting track in the Business Administration PhD program is to prepare students for academic careers in higher education and management careers within profit and nonprofit organizations. Success in the program is judged by the student’s understanding of the issues and methodologies essential to the advancement of knowledge.
						</p>
					</div>
				</div>

				<div class="row degree-search-result">
					<div class="span9">
						<h3 class="degree-title">
							<a href="degree.html">Finance</a>
							<span class="degree-credits-count">&mdash; 140 credit hours</span>
						</h3>
						<span class="degree-college">College of Business Administration</span>
						<span class="degree-dept">
							<strong>Department:</strong> Finance
						</span>
						<p class="degree-desc">
							The objective of the Finance track in the Business Administration PhD program is to prepare students for academic careers in higher education and management careers within profit and nonprofit organizations. Success in the program is judged by the student’s understanding of the issues and methodologies essential to the advancement of knowledge.
						</p>
					</div>
				</div>


				<hr>

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
