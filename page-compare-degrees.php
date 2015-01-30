<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	#degree-comparison .text-left {
		text-align: left;
	}
	#degree-comparison .muted {
		font-style: italic;
	}


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


	#degree-comparison .comparison-bignumber {
		display: block;
		font-size: 30px;
		font-weight: 400;
		line-height: 1.2;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-bignumber {
			font-size: 24px;
		}
	}


	#degree-comparison .column-heading-inner {
		color: #666;
		font-size: 11.5px;
		text-transform: uppercase;
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
		border-radius: 0;
		font-size: 16px;
		font-weight: 500;
		line-height: 1.1;
		padding: 12px 8px;
		text-align: center;
		vertical-align: middle;
		width: 50%;
	}
	#comparison-chart-head-phone .table th:first-child {
		border-left: 1px solid #fff;
	}
	#comparison-chart-head-phone.affix .table th {
		border-radius: 0;
		border-left: 0 solid transparent;
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
		height: 100%; /* stupid but necessary for table heading .cell-content-outer height to calculate correctly */
		margin-top: 20px;
		width: 100%;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-chart {
			border-left: 1px solid #fff;
			border-right: 1px solid #fff;
			margin-top: 0;
		}
	}

	#degree-comparison .comparison-chart a {
		border-bottom: 0 solid transparent;
		color: #000;
		text-decoration: underline;
	}

	#degree-comparison .comparison-chart > thead > tr > th.column-heading,
	#degree-comparison .comparison-chart > tbody > tr > th.column-heading {
		border: 0 none;
		clip: rect(0px, 0px, 0px, 0px);
		height: 1px;
		margin: -1px;
		overflow: hidden;
		padding: 0;
		position: absolute;
		width: 1px;
	}

	#degree-comparison .comparison-chart > thead > tr > th,
	#degree-comparison .comparison-chart > tbody > tr > td {
		border-left: 30px solid #fff; /* simulate border-spacing */
		border-right: 30px solid #fff; /* simulate border-spacing */
		line-height: 1.4;
		padding: 15px 20px;
		text-align: center;
		vertical-align: top;
		width: 50%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#degree-comparison .comparison-chart > thead > tr > th,
		#degree-comparison .comparison-chart > tbody > tr > td {
			border-left: 14px solid #fff;
			border-right: 14px solid #fff;
		}
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-chart > thead > tr > th,
		#degree-comparison .comparison-chart > tbody > tr > td {
			border-left: 1px solid #fff;
			border-right: 1px solid #fff;
			padding: 12px;
		}
		#degree-comparison .comparison-chart > tbody > tr > th + td {
			border-left: 0 solid transparent;
		}
	}
	#degree-comparison .comparison-chart > tbody > tr > td.align-middle {
		vertical-align: middle;
	}

	#degree-comparison .comparison-chart > thead > tr > th {
		background-color: #337ab7;
		color: #fff;
		height: 100%;
		padding: 0;
		vertical-align: top; /* MUST be top because ie can't calculate 100% height for the child divs correctly :( */
	}
	#degree-comparison .comparison-chart > thead > tr > th .cell-content-outer {
		display: table;
		height: 100%;
		position: relative;
		width: 100%;
	}
	#degree-comparison .comparison-chart > thead > tr > th .cell-content-outer:before,
	#degree-comparison .comparison-chart > thead > tr > th .cell-content-outer:after {
		content: '';
		display: block;
		height: 15px;
		left: 0;
		position: absolute;
		right: 0;
		top: 0;
	}
	#degree-comparison .comparison-chart > thead > tr > th .cell-content-outer:before {
		background-color: #fff;
	}
	#degree-comparison .comparison-chart > thead > tr > th .cell-content-outer:after {
		background-color: #337ab7;
		border-radius: 15px 15px 0 0;
	}
	#degree-comparison .comparison-chart > thead > tr > th .cell-content-inner {
		display: table-cell;
		height: 100%;
		padding: 20px;
		vertical-align: middle;
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
		vertical-align: top;
	}
	#degree-comparison dl.aligned dt:first-child,
	#degree-comparison dl.aligned dt:first-child + dd {
		margin-top: 0;
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
			margin-top: 15px;
		}
		#degree-comparison dl dt:first-child,
		#degree-comparison dl.aligned dt:first-child {
			margin-top: 0;
		}
		#degree-comparison dl dd,
		#degree-comparison dl.aligned dd,
		#degree-comparison dt:first-child + dd,
		#degree-comparison dl.aligned dt:first-child + dd {
			margin-top: 6px;
		}
	}


	#degree-comparison .comparison-smalltext,
	#degree-comparison .comparison-fineprint {
		font-size: 11px;
		line-height: 1.4;
		margin-top: 20px;
		margin-bottom: 0;
		text-align: left;
	}
	#degree-comparison .comparison-fineprint {
		color: #555;
		font-style: italic;
		margin-top: 10px;
	}


	#degree-comparison .degree-infobox-toggle {
		border-bottom: 0 solid transparent !important;
		padding-left: 6px;
	}
	@media (max-width: 767px) {
		#degree-comparison .degree-infobox-toggle {
			display: none;
		}
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


	#degree-comparison .comparison-location {
		font-size: 20px;
		line-height: 1.3;
		margin-bottom: 0;
		margin-top: 10px;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-location {
			font-size: 16px;
		}
	}
	#degree-comparison .comparison-location a {
		text-decoration: none;
	}
	#degree-comparison .comparison-location .comparison-smalltext {
		display: block;
		margin-top: 10px;
		text-align: center;
		text-decoration: underline;
	}
	@media (max-width: 767px) {
		#degree-comparison .comparison-location .comparison-smalltext {
			margin-top: 6px;
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
							<th class="column-heading"></th>
							<th class="comparison-header" scope="col" tabindex="0">
								<div class="cell-content-outer">
									<div class="cell-content-inner">
										<h2><a href="#">Accounting Ph.D.</a></h2>
										<span>a <a href="#">Business Administration Ph.D.</a> track</span>
									</div>
								</div>
							</th>
							<th class="comparison-header" scope="col" tabindex="0">
								<div class="cell-content-outer">
									<div class="cell-content-inner">
										<h2><a href="#">Finance Ph.D.</a></h2>
										<span>a <a href="#">Business Administration Ph.D.</a> track</span>
									</div>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr class="comparison-row">
							<th class="column-heading" scope="row" tabindex="0">Total Credit Hours</th>
							<td tabindex="0">
								<span class="comparison-bignumber">84</span>
								Total Credit Hours
							</td>
							<td tabindex="0">
								<span class="comparison-bignumber">84</span>
								Total Credit Hours
							</td>
						</tr>
						<tr class="comparison-row alt">
							<th class="column-heading" scope="row" tabindex="0">College and Department</th>
							<td tabindex="0">
								<dl class="aligned">
									<dt class="column-heading-inner">College:</dt>
									<dd><a href="#">College of Business Administration</a></dd>
									<dt class="column-heading-inner">Department:</dt>
									<dd><a href="#">Kenneth G. Dixon School of Accounting</a></dd>
								</dl>
							</td>
							<td tabindex="0">
								<dl class="aligned">
									<dt class="column-heading-inner">College:</dt>
									<dd><a href="#">College of Business Administration</a></dd>
									<dt class="column-heading-inner">Department:</dt>
									<dd><a href="#">Financing</a></dd>
								</dl>
							</td>
						</tr>
						<tr class="comparison-row">
							<th class="column-heading" scope="row" tabindex="0">Option</th>
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
							<th class="column-heading" scope="row" tabindex="0">Location</th>
							<td tabindex="0">
								<strong class="column-heading-inner">Location:</strong>
								<p class="comparison-location">
									<a href="#">
										UCF Main Campus
										<span class="comparison-smalltext">
											<span class="icon icon-map-marker"></span>View on map
										</span>
									</a>
								</p>
							</td>
							<td tabindex="0">
								<strong class="column-heading-inner">Location:</strong>
								<p class="comparison-location">
									<a href="#">
										UCF Main Campus
										<span class="comparison-smalltext">
											<span class="icon icon-map-marker"></span>View on map
										</span>
									</a>
								</p>
							</td>
						</tr>
						<tr class="comparison-row">
							<th class="column-heading" scope="row" tabindex="0">Potential Careers</th>
							<td tabindex="0">
								<strong class="column-heading-inner">Potential careers include:</strong>
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
								<strong class="column-heading-inner">Potential careers include:</strong>
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
							<th class="column-heading" scope="row" tabindex="0">Average Starting Salaries</th>
							<td tabindex="0">
								<strong class="column-heading-inner">Average starting salary:*</strong>
								<ul class="list-unstyled comparison-salary">
									<li class="locally">
										<span class="comparison-salary-value comparison-bignumber">$44,985</span>
										<span class="comparison-salary-label">Orlando area, annually</span>
									</li>
									<li class="nationally">
										<span class="comparison-salary-value comparison-bignumber">$47,164</span>
										<span class="comparison-salary-label">national average, annually</span>
									</li>
								</ul>
								<p class="comparison-fineprint">
									* Statistics credits and legal jargon or whatever goes here, because we can’t
									guarantee starting salaries and whatnot
								</p>
							</td>
							<td tabindex="0">
								<strong class="column-heading-inner">Average starting salary:*</strong>
								<ul class="list-unstyled comparison-salary">
									<li class="locally">
										<span class="comparison-salary-value comparison-bignumber">$49,286</span>
										<span class="comparison-salary-label">Orlando area, annually</span>
									</li>
									<li class="nationally">
										<span class="comparison-salary-value comparison-bignumber">$51,673</span>
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
							<th class="column-heading" scope="row" tabindex="0">Program Admission Rate</th>
							<td class="align-middle" tabindex="0">
								<span class="comparison-bignumber">7.8%</span>
								Program Admission Rate
								<small>(Fall 2013 semester)</small>
							</td>
							<td class="align-middle" tabindex="0">
								<span class="muted">Program Admission Rate n/a</span>
							</td>
						</tr>
						<tr class="comparison-row alt">
							<th class="column-heading" scope="row" tabindex="0">Prerequisites</th>
							<td tabindex="0">
								<strong class="column-heading-inner">Prerequisites:</strong>
								<ul class="list-unstyled comparison-prereqs">
									<li><strong>ACG 7157</strong> Seminar in Archival Research in Accounting</li>
									<li><strong>ACG 7399</strong> Seminar in Behavioral Accounting Research</li>
									<li><strong>ACG 7826</strong> Seminar in the Social and Organizational Context of Accounting</li>
									<li><strong>ACG 7885</strong> Research Foundations in Accounting</li>
									<li><strong>ACG 7887</strong> Accounting Research Forum</li>
								</ul>
							</td>
							<td tabindex="0">
								<strong class="column-heading-inner">Prerequisites:</strong>
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
			var triggerVal = 'hover';
			var placementVal = 'top';

			$toggle
				.popover({
					'placement': placementVal,
					'trigger': triggerVal
				});
		});
	</script>
<?php get_footer(); ?>
