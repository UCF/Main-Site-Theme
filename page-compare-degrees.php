<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	#breadcrumbs {
		border-bottom: 2px solid #eee;
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 12.5px;
		margin-bottom: 10px;
	}
	#breadcrumbs .breadcrumb-search {
		display: block;
		float: left;
		font-weight: 500;
		padding: 8px 0; /* match .breadcrumb top/bottom padding */
		width: 20%;
	}
	@media (max-width: 767px) {
		/* Hiding breadcrumbs at mobile size seems to be a standard convention--not sure if I agree, but sticking with this for now */
		#breadcrumbs {
			display: none;
		}
	}


	#degree-comparison #contentcol {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}
	@media (max-width: 767px) {
		#degree-comparison #contentcol {
			font-size: 12px;
		}
	}

	#degree-comparison .list-unstyled {
		list-style-type: none;
		margin-left: 0;
	}
	#degree-comparison .list-twocol {
		-moz-column-count: 2;
		-moz-column-gap: 20px;
		-webkit-column-count: 2;
		-webkit-column-gap: 20px;
		column-count: 2;
		column-gap: 20px;
	}
	@media (max-width: 979px) {
		#degree-comparison .list-twocol {
			-moz-column-count: 1;
			-moz-column-gap: 0;
			-webkit-column-count: 1;
			-webkit-column-gap: 0;
			column-count: 1;
			column-gap: 0;
		}
	}


	#comparison-chart-head-phone {
		margin-left: -20px; /* force push past body margin-left */
		width: 100%;
	}
	#comparison-chart-head-phone.affix {
		top: 0;
	}

	#comparison-chart-head-phone .table {
		border-left: 1px solid #fff;
		border-right: 1px solid #fff;
		margin-bottom: 0;
		margin-left: 20px;
	}
	#comparison-chart-head-phone .table a {
		color: #fff;
		border: 0 solid transparent;
	}
	#comparison-chart-head-phone.affix .table {
		border-left: 0 solid transparent;
		border-right: 0 solid transparent;
		margin-left: 0;
	}
	#comparison-chart-head-phone .table th {
		background-color: #337ab7;
		border-left: 1px solid #fff;
		border-radius: 8px 8px 0 0;
		font-size: 16px;
		font-weight: 500;
		line-height: 1.1;
		padding: 12px 8px;
		text-align: center;
		vertical-align: middle;
		width: 50%;
	}
	#comparison-chart-head-phone .table th:first-child {
		border-left: 0 solid transparent;
	}
	#comparison-chart-head-phone.affix .table th {
		border-radius: 0;
	}
	#comparison-chart-head-phone.affix .table th:first-child {
		border-left: 1px solid #337ab7;
	}
	#comparison-chart-head-phone .table th p {
		color: #fff;
		font-size: 11px;
		line-height: 1.2;
		margin: 10px 0 0 0;
	}
	#comparison-chart-head-phone .table th p a {
		text-decoration: underline;
	}
	#comparison-chart-head-phone.affix .table th p {
		display: none;
	}


	#degree-comparison .comparison-chart {
		margin-top: 20px;
		width: 100%;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-chart {
			margin-top: 0;
		}
	}

	#degree-comparison .comparison-chart a {
		border-bottom: 0 solid transparent;
		color: #000;
		text-decoration: underline;
	}

	#degree-comparison .comparison-chart th.column-heading {
		border: 0 none;
		clip: rect(0px, 0px, 0px, 0px);
		height: 1px;
		margin: -1px;
		overflow: hidden;
		padding: 0;
		position: absolute;
		width: 1px;
	}

	#degree-comparison .comparison-chart thead th,
	#degree-comparison .comparison-chart tbody td {
		border-left: 30px solid #fff; /* simulate border-spacing */
		border-right: 30px solid #fff; /* simulate border-spacing */
		line-height: 1.4;
		padding: 15px 20px;
		text-align: center;
		vertical-align: top;
		width: 50%;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-chart thead th,
		#degree-comparison .comparison-chart tbody td {
			border-left: 1px solid #fff;
			border-right: 1px solid #fff;
			padding: 12px;
		}
	}

	#degree-comparison .comparison-chart thead th {
		color: #fff;
		padding: 0;
	}
	#degree-comparison .comparison-chart thead th .column-content {
		background-color: #337ab7;
		border-radius: 6px 6px 0 0;
		padding: 20px;
	}
	#degree-comparison .comparison-header h2 {
		font-size: 24px;
		font-weight: 500;
		line-height: 1.2;
		margin-top: 0;
	}
	#degree-comparison .comparison-header span {
		display: block;
		font-size: 13px;
		font-weight: normal;
		line-height: 1.1;
		margin-top: 10px;
	}
	#degree-comparison .comparison-header a {
		color: #fff;
		text-decoration: none;
	}
	#degree-comparison .comparison-header a:hover,
	#degree-comparison .comparison-header a:active,
	#degree-comparison .comparison-header a:focus {
		text-decoration: underline;
	}

	#degree-comparison .comparison-row {
		background-color: #f5f5f5;
	}
	#degree-comparison .comparison-row.alt {
		background-color: #e1e1e1;
	}


	#degree-comparison dl {
		margin: 0;
	}
	#degree-comparison dt,
	#degree-comparison dd {
		display: inline;
	}
	#degree-comparison dt:first-child,
	#degree-comparison dt:first-child + dd {
		margin-top: 0;
	}
	#degree-comparison dl.aligned dt,
	#degree-comparison dl.aligned dd {
		display: inline-block;
		margin-top: 5px;
		vertical-align: middle;
	}
	#degree-comparison dl.aligned dt {
		width: 25%;
		text-align: right;
	}
	#degree-comparison dl.aligned dd {
		width: 70%;
		text-align: left;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#degree-comparison dl.aligned dt {
			width: 34%;
		}
		#degree-comparison dl.aligned dd {
			width: 60%;
		}
	}
	@media (max-width: 767px) {
		#degree-comparison dl dt,
		#degree-comparison dl dd,
		#degree-comparison dl.aligned dt,
		#degree-comparison dl.aligned dd {
			display: block;
			line-height: 1.3;
			text-align: center;
			margin-left: 0;
			width: 100%;
		}
		#degree-comparison dl dt,
		#degree-comparison dl.aligned dt {
			margin-top: 12px;
		}
		#degree-comparison dl dt:first-child,
		#degree-comparison dl.aligned dt:first-child {
			margin-top: 0;
		}
		#degree-comparison dl dd,
		#degree-comparison dl.aligned dd,
		#degree-comparison dt:first-child + dd {
			margin-top: 6px;
		}
	}


	#degree-comparison .comparison-fineprint {
		color: #555;
		font-size: 11px;
		font-style: italic;
		line-height: 1.4;
		margin: 0;
		text-align: left;
	}


	#degree-comparison .degree-infobox-toggle {
		border-bottom: 0 solid transparent !important;
		padding-left: 6px;
	}
	#degree-comparison .degree-infobox-toggle .icon {
		padding-bottom: 3px;
		border-bottom: 1px dotted #999;
	}
	#degree-comparison .popover-title {
		display: none; /* hide empty titles */
	}
	#degree-comparison .popover {
		font-size: 12px;
		line-height: 1.4;
		font-weight: normal;
	}
	@media (max-width: 767px) {
		#degree-comparison .popover-content {
			max-height: 250px;
			overflow-x: hidden;
			overflow-y: scroll;
			-webkit-overflow-scrolling: touch;
		}
	}


	#degree-comparison .comparison-credit-hours {
		display: block;
		line-height: 1.2;
		font-size: 30px;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-credit-hours {
			font-size: 24px;
		}
	}


	#degree-comparison .comparison-careers,
	#degree-comparison .comparison-prereqs {
		margin-bottom: 0;
		margin-top: 15px;
	}
	#degree-comparison .comparison-careers li {
		font-size: 16px;
		margin-bottom: 6px;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-careers {
			margin-top: 10px;
		}
		#degree-comparison .comparison-careers li {
			font-size: 14px;
			line-height: 1.2;
			margin-bottom: 10px;
		}
	}


	#degree-comparison .comparison-salary {
		display: table;
		margin-top: 10px;
		width: 100%;
	}
	#degree-comparison .comparison-salary li {
		display: table-cell;
		height: 100px;
		vertical-align: middle;
		width: 50%;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-salary li {
			display: block;
			width: 100%;
		}
	}
	#degree-comparison .comparison-salary .locally {
		background: url('<?php echo THEME_IMG_URL; ?>/degree-compare-local.png') center center no-repeat;
		background-size: contain;
	}
	#degree-comparison .comparison-salary .nationally {
		background: url('<?php echo THEME_IMG_URL; ?>/degree-compare-national.png') center center no-repeat;
		background-size: contain;
	}
	#degree-comparison .comparison-salary span {
		border-left: 1px solid #999;
		display: block;
		padding: 0 10px;
	}
	#degree-comparison .comparison-salary li:first-child span {
		border-left: 1px solid transparent;
	}
	@media (max-width: 979px) {
		#degree-comparison .comparison-salary span {
			border-left: 1px solid transparent;
		}
	}
	#degree-comparison .comparison-salary .comparison-salary-value {
		font-size: 30px;
		line-height: 1.2;
	}
	@media (max-width: 979px) {
		#degree-comparison .comparison-salary .comparison-salary-value {
			font-size: 25px;
		}
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-salary .comparison-salary-value {
			padding-top: 20px;
		}
	}
	#degree-comparison .comparison-salary .comparison-salary-label {
		font-size: 11px;
		line-height: 1.1;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#degree-comparison .comparison-salary .comparison-salary-label {
			padding: 2px 10px 0 10px;
		}
	}

	#degree-comparison .comparison-prereqs li {
		margin-bottom: 12px;
		line-height: 1.2;
		text-align: left;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-prereqs strong {
			display: block;
		}
	}

	</style>


	<div class="row page-content" id="degree-comparison">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title(); ?>: Accounting vs. Finance</h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="breadcrumbs" class="span12 clearfix">
			<!-- Display .breadcrumb-search only if the user came from the degree search (check for GET param) -->
			<a class="breadcrumb-search" href="#">&laquo; Back to Search Results</a>
		</div>

		<div class="span12" id="contentcol">
			<article role="main">

				<div class="visible-phone" id="comparison-chart-head-phone">
					<table class="table">
						<thead>
							<tr>
								<th>
									<a href="#">Accounting Ph.D.</a>
									<p>a <a href="#">Business Administration Ph.D.</a> track</p>
								</th>
								<th>
									<a href="#">Finance Ph.D.</a>
									<p>a <a href="#">Business Administration Ph.D.</a> track</p>
								</th>
							</tr>
						</thead>
					</table>
				</div>

				<table class="comparison-chart">
					<thead class="hidden-phone" colspan="3">
						<tr>
							<th class="column-heading" tabindex="0">Program Name</th>
							<th class="comparison-header" tabindex="0">
								<div class="column-content">
									<h2><a href="#">Accounting Ph.D.</a></h2>
									<span>a <a href="#">Business Administration Ph.D.</a> track</span>
								</div>
							</th>
							<th class="comparison-header" tabindex="0">
								<div class="column-content">
									<h2><a href="#">Finance Ph.D.</a></h2>
									<span>a <a href="#">Business Administration Ph.D.</a> track</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr class="comparison-row">
							<th class="column-heading" tabindex="0">Total Credit Hours</th>
							<td tabindex="0">
								<span class="comparison-credit-hours">84</span>
								Total Credit Hours
							</td>
							<td tabindex="0">
								<span class="comparison-credit-hours">84</span>
								Total Credit Hours
							</td>
						</tr>
						<tr class="comparison-row alt">
							<th class="column-heading" tabindex="0">College and Department</th>
							<td tabindex="0">
								<dl class="aligned">
									<dt>College:</dt>
									<dd><a href="#">College of Business Administration</a></dd>
									<dt>Department:</dt>
									<dd><a href="#">Kenneth G. Dixon School of Accounting</a></dd>
								</dl>
							</td>
							<td tabindex="0">
								<dl class="aligned">
									<dt>College:</dt>
									<dd><a href="#">College of Business Administration</a></dd>
									<dt>Department:</dt>
									<dd><a href="#">Financing</a></dd>
								</dl>
							</td>
						</tr>
						<tr class="comparison-row">
							<th class="column-heading" tabindex="0">Option</th>
							<td tabindex="0">
								<strong>Dissertation</strong> Option
								<a class="degree-infobox-toggle" href="#" data-content="info here..."><span class="icon icon-info-sign"></span></a>
							</td>
							<td tabindex="0">
								<strong>Dissertation</strong> Option
								<a class="degree-infobox-toggle" href="#" data-content="info here..."><span class="icon icon-info-sign"></span></a>
							</td>
						</tr>
						<tr class="comparison-row alt">
							<th class="column-heading" tabindex="0">Location</th>
							<td tabindex="0">
								<dl>
									<dt>Location:</dt>
									<dd><a href="#">UCF Main Campus</a></dd>
								</dl>
							</td>
							<td tabindex="0">
								<dl>
									<dt>Location:</dt>
									<dd><a href="#">UCF Main Campus</a></dd>
								</dl>
							</td>
						</tr>
						<tr class="comparison-row">
							<th class="column-heading" tabindex="0">Potential Careers</th>
							<td tabindex="0">
								<strong>Potential careers include:</strong>
								<ul class="list-twocol list-unstyled comparison-careers">
									<li>Auditor</li>
									<li>Bookkeeper</li>
									<li>Tax Examiner</li>
									<li>Tax Preparer</li>
									<li>Forensic Accountant</li>
									<li>Public Accountant</li>
									<li>Nonprofit Accountant</li>
								</ul>
							</td>
							<td tabindex="0">
								<strong>Potential careers include:</strong>
								<ul class="list-twocol list-unstyled comparison-careers">
									<li>Actuary</li>
									<li>Financial Manager</li>
									<li>Financial Advisor</li>
									<li>Investment Banker</li>
									<li>Financial Analyst</li>
									<li>Controller</li>
									<li>Tax Manager</li>
								</ul>
							</td>
						</tr>
						<tr class="comparison-row alt">
							<th class="column-heading" tabindex="0">Average Starting Salaries</th>
							<td tabindex="0">
								<strong>Average starting salary:*</strong>
								<ul class="list-unstyled comparison-salary">
									<li class="locally">
										<span class="comparison-salary-value">$44,985</span>
										<span class="comparison-salary-label">Orlando area, annually</span>
									</li>
									<li class="nationally">
										<span class="comparison-salary-value">$47,164</span>
										<span class="comparison-salary-label">national average, annually</span>
									</li>
								</ul>
								<p class="comparison-fineprint">
									* Statistics credits and legal jargon or whatever goes here, because we can’t
									guarantee starting salaries and whatnot
								</p>
							</td>
							<td tabindex="0">
								<strong>Average starting salary:*</strong>
								<ul class="list-unstyled comparison-salary">
									<li class="locally">
										<span class="comparison-salary-value">$49,286</span>
										<span class="comparison-salary-label">Orlando area, annually</span>
									</li>
									<li class="nationally">
										<span class="comparison-salary-value">$51,673</span>
										<span class="comparison-salary-label">national average, annually</span>
									</li>
								</ul>
								<p class="comparison-fineprint">
									* Statistics credits and legal jargon or whatever goes here, because we can’t
									guarantee starting salaries and whatnot
								</p>
							</td>
						</tr>
						<tr class="comparison-row">
							<th class="column-heading" tabindex="0">Prerequisites</th>
							<td tabindex="0">
								<strong>Prerequisites:</strong>
								<ul class="list-unstyled comparison-prereqs">
									<li><strong>ACG 7157</strong> Seminar in Archival Research in Accounting</li>
									<li><strong>ACG 7399</strong> Seminar in Behavioral Accounting Research</li>
									<li><strong>ACG 7826</strong> Seminar in the Social and Organizational Context of Accounting</li>
									<li><strong>ACG 7885</strong> Research Foundations in Accounting</li>
									<li><strong>ACG 7887</strong> Accounting Research Forum</li>
								</ul>
							</td>
							<td tabindex="0">
								<strong>Prerequisites:</strong>
								<ul class="list-unstyled comparison-prereqs">
									<li><strong>FIN 7935</strong> Finance Research Forum</li>
									<li><strong>FIN 7808</strong> Introduction to the Theory of Finance</li>
									<li><strong>FIN 7807</strong> Corporate Finance Theory</li>
									<li><strong>FIN 7816</strong> Investment Theory</li>
									<li><strong>FIN 7930</strong> Seminar in Market Microstructure</li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>

			</article>

		</div>
	</div>

	<script>
		/**
		 * TODO: move to script.js when design drafting is finished!
		 **/
		$(document).ready(function() {
			// Affix .comparison-chart-head-phone
			$comparisonChartHead = $('#comparison-chart-head-phone');
			$comparisonChart = $comparisonChartHead.next('.comparison-chart');

			$comparisonChartHead.affix({
				offset: {
					top: $comparisonChart.offset().top
				}
			});

			// Popovers
			var $toggle = $('.degree-infobox-toggle');
			var triggerVal = 'click';
			var placementVal = 'top';

			if ($(window).width() > 767) {
				triggerVal = 'hover';
			}

			$toggle
				.popover({
					'placement': placementVal,
					'trigger': triggerVal
				})
				.on('click', function(e) {
					e.preventDefault();

					if (triggerVal == 'click') {
						$toggle.not(this).popover('hide');
					}
				});
		});
	</script>
<?php get_footer(); ?>
