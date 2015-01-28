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


	#contentcol {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}

	#contentcol .list-unstyled {
		list-style-type: none;
		margin-left: 0;
	}
	#contentcol .list-twocol {
		-moz-column-count: 2;
		-moz-column-gap: 20px;
		-webkit-column-count: 2;
		-webkit-column-gap: 20px;
		column-count: 2;
		column-gap: 20px;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#contentcol .list-twocol {
			-moz-column-count: 1;
			-moz-column-gap: 0;
			-webkit-column-count: 1;
			-webkit-column-gap: 0;
			column-count: 1;
			column-gap: 0;
		}
	}
	@media (max-width: 767px) {
		#contentcol .list-twocol {
			-moz-column-gap: 10px;
			-webkit-column-gap: 10px;
			column-gap: 10px;
		}
	}


	#contentcol .comparison-col {
		margin-top: 20px;
		text-align: center;
	}
	@media (max-width: 767px) {
		#contentcol .comparison-col {
			font-size: 13px;
		}
	}
	#contentcol .comparison-col a {
		border-bottom: 0 solid transparent;
		color: #000;
		text-decoration: underline;
	}

	#contentcol .comparison-header {
		background-color: #337AB7;
		/*border: 1px solid #f1f1f1;*/
		border-radius: 6px 6px 0 0;
		color: #fff;
		padding: 20px;
	}
	#contentcol .comparison-header h2 {
		font-size: 24px;
		font-weight: 500;
		line-height: 1.2;
		margin-top: 0;
	}
	#contentcol .comparison-header span {
		display: block;
		font-size: 13px;
		line-height: 1.1;
		margin-top: 10px;
	}
	#contentcol .comparison-header a {
		color: #fff;
		text-decoration: none;
	}
	#contentcol .comparison-header a:hover,
	#contentcol .comparison-header a:active,
	#contentcol .comparison-header a:focus {
		text-decoration: underline;
	}

	#contentcol .comparison-row {
		background-color: #f5f5f5;
		padding: 15px 20px;
	}
	#contentcol .comparison-row.alt {
		background-color: #e1e1e1;
	}

	#contentcol .comparison-row dl {
		margin: 0;
	}
	#contentcol .comparison-row dt,
	#contentcol .comparison-row dd {
		display: inline;
	}
	#contentcol .comparison-row dt:first-child,
	#contentcol .comparison-row dt:first-child + dd {
		margin-top: 0;
	}
	#contentcol .comparison-row dl.aligned dt,
	#contentcol .comparison-row dl.aligned dd {
		display: inline-block;
		margin-top: 5px;
		vertical-align: middle;
	}
	#contentcol .comparison-row dl.aligned dt {
		width: 25%;
		text-align: right;
	}
	#contentcol .comparison-row dl.aligned dd {
		width: 70%;
		text-align: left;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#contentcol .comparison-row dl.aligned dt {
			width: 34%;
		}
		#contentcol .comparison-row dl.aligned dd {
			width: 60%;
		}
	}
	@media (max-width: 767px) {
		#contentcol .comparison-header {
			border-radius: 0;
		}
		#contentcol .comparison-header h2 {
			font-size: 16px;
		}
		#contentcol .list-twocol {
			-webkit-column-count: 1;
			-moz-column-count: 1;
			-o-column-count: 1;
			column-count: 1;

			-webkit-column-gap: 0;
			-moz-column-gap: 0;
			-o-column-gap: 0;
			column-gap: 0;

			-webkit-column-count: 1;
			-moz-column-count: 1;
			-o-column-count: 1;
			column-count: 1;
		}

		#contentcol .comparison-salary li {
			display: block !important;
			width: 100% !important;
		}

		#contentcol .comparison-header, #contentcol .comparison-row {
			border-right: solid 1px #fff;
		}

		#contentcol .comparison-careers li {
			font-size: 14px !important;
			margin-bottom: 6px;
		}

		#contentcol .comparison-row dl.aligned dt,
		#contentcol .comparison-row dl.aligned dd {
			display: block;
			text-align: center;
			margin-left: 0;
			width: 100%;
		}
		#contentcol .comparison-row dl.aligned dt {
			margin-top: 10px;
		}
		#contentcol .comparison-row dl.aligned dt:first-child {
			margin-top: 0;
		}
		#contentcol .comparison-row dl.aligned dd {
			margin-top: 0;
		}
	}

	#contentcol .comparison-fineprint {
		color: #555;
		font-size: 11px;
		font-style: italic;
		line-height: 1.4;
		margin: 0;
		text-align: left;
	}

	#contentcol .degree-infobox-toggle {
		border-bottom: 0 solid transparent !important;
		padding-left: 6px;
	}
	#contentcol .degree-infobox-toggle .icon {
		padding-bottom: 3px;
		border-bottom: 1px dotted #999;
	}
	#contentcol .popover-title {
		display: none; /* hide empty titles */
	}
	#contentcol .popover {
		font-size: 12px;
		line-height: 1.4;
		font-weight: normal;
	}
	@media (max-width: 767px) {
		#contentcol .popover-content {
			max-height: 250px;
			overflow-x: hidden;
			overflow-y: scroll;
			-webkit-overflow-scrolling: touch;
		}
	}


	#contentcol .comparison-credit-hours {
		display: block;
		line-height: 1.2;
		font-size: 30px;
	}


	#contentcol .comparison-careers,
	#contentcol .comparison-prereqs {
		margin-bottom: 0;
		margin-top: 15px;
	}
	#contentcol .comparison-careers li {
		font-size: 16px;
		margin-bottom: 6px;
	}


	#contentcol .comparison-salary {
		display: table;
		margin-top: 10px;
		width: 100%;
	}
	#contentcol .comparison-salary li {
		display: table-cell;
		height: 100px;
		vertical-align: middle;
		width: 50%;
	}
	#contentcol .comparison-salary .locally {
		background: url('<?php echo THEME_IMG_URL; ?>/degree-compare-local.png') center center no-repeat;
		background-size: contain;
	}
	#contentcol .comparison-salary .nationally {
		background: url('<?php echo THEME_IMG_URL; ?>/degree-compare-national.png') center center no-repeat;
		background-size: contain;
	}
	#contentcol .comparison-salary span {
		border-left: 1px solid #999;
		display: block;
		padding: 0 10px;
	}
	#contentcol .comparison-salary li:first-child span {
		border-left: 1px solid transparent;
	}
	@media (max-width: 979px) {
		#contentcol .comparison-salary span {
			border-left: 1px solid transparent;
		}
	}
	#contentcol .comparison-salary .comparison-salary-value {
		font-size: 30px;
		line-height: 1.2;
	}
	@media (max-width: 979px) {
		#contentcol .comparison-salary .comparison-salary-value {
			font-size: 25px;
		}
	}
	#contentcol .comparison-salary .comparison-salary-label {
		font-size: 11px;
		line-height: 1.1;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#contentcol .comparison-salary .comparison-salary-label {
			padding: 2px 10px 0 10px;
		}
	}

	#contentcol .comparison-prereqs li {
		margin-bottom: 12px;
		line-height: 1.2;
		text-align: left;
	}

	@media all and (max-width: 767px) {
	    .half {
	        float: left !important;
	        width: 50% !important;
	    }
	}

	</style>


	<div class="row page-content" id="academics-search">
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

				<div class="row">
					<div class="span5 offset1 half">
						<div class="comparison-col">
							<div class="comparison-header">
								<h2><a href="#">Accounting Ph.D.</a></h2>
								<span>a <a href="#">Business Administration Ph.D.</a> track</span>
							</div>
							<div class="comparison-row" data-mh="compare-row-1">
								<span class="comparison-credit-hours">84</span>
								Total Credit Hours
							</div>
							<div class="college comparison-row alt compare-row-2">
								<dl class="aligned">
									<dt>College:</dt>
									<dd><a href="#">College of Business Administration</a></dd>
									<dt>Department:</dt>
									<dd><a href="#">Kenneth G. Dixon School of Accounting</a></dd>
								</dl>
							</div>
							<div class="comparison-row" data-mh="compare-row-3">
								<strong>Dissertation</strong> Option
								<a class="degree-infobox-toggle" href="#" data-content="info here..."><span class="icon icon-info-sign"></span></a>
							</div>
							<div class="comparison-row alt" data-mh="compare-row-4">
								<dl>
									<dt>Location:</dt>
									<dd><a href="#">UCF Main Campus</a></dd>
								</dl>
							</div>
							<div class="comparison-row">
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
							</div>
							<div class="comparison-row alt">
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
							</div>
							<div class="comparison-row">
								<strong>Prerequisites:</strong>
								<ul class="list-unstyled comparison-prereqs">
									<li><strong>ACG 7157</strong> Seminar in Archival Research in Accounting</li>
									<li><strong>ACG 7399</strong> Seminar in Behavioral Accounting Research</li>
									<li><strong>ACG 7826</strong> Seminar in the Social and Organizational Context of Accounting</li>
									<li><strong>ACG 7885</strong> Research Foundations in Accounting</li>
									<li><strong>ACG 7887</strong> Accounting Research Forum</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="span5 half">
						<div class="comparison-col">
							<div class="comparison-header">
								<h2><a href="#">Finance Ph.D.</a></h2>
								<span>a <a href="#">Business Administration Ph.D.</a> track</span>
							</div>
							<div class="comparison-row" data-mh="compare-row-1">
								<span class="comparison-credit-hours">84</span>
								Total Credit Hours
							</div>
							<div class="college comparison-row alt compare-row-2">
								<dl class="aligned">
									<dt>College:</dt>
									<dd><a href="#">College of Business Administration</a></dd>
									<dt>Department:</dt>
									<dd><a href="#">Finance</a></dd>
								</dl>
							</div>
							<div class="comparison-row" data-mh="compare-row-3">
								<strong>Dissertation</strong> Option
								<a class="degree-infobox-toggle" href="#" data-content="info here..."><span class="icon icon-info-sign"></span></a>
							</div>
							<div class="comparison-row alt" data-mh="compare-row-4">
								<dl>
									<dt>Location:</dt>
									<dd><a href="#">UCF Main Campus</a></dd>
								</dl>
							</div>
							<div class="comparison-row">
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
							</div>
							<div class="comparison-row alt">
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
							</div>
							<div class="comparison-row">
								<strong>Prerequisites:</strong>
								<ul class="list-unstyled comparison-prereqs">
									<li><strong>FIN 7935</strong> Finance Research Forum</li>
									<li><strong>FIN 7808</strong> Introduction to the Theory of Finance</li>
									<li><strong>FIN 7807</strong> Corporate Finance Theory</li>
									<li><strong>FIN 7816</strong> Investment Theory</li>
									<li><strong>FIN 7930</strong> Seminar in Market Microstructure</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

			</article>

		</div>
	</div>

	<script src="<?php bloginfo('template_url'); ?>/static/js/jquery.matchHeight.js"></script>

	<script>
		/**
		 * TODO: move to script.js when design drafting is finished!
		 **/
		$(document).ready(function() {
			// Popovers
			var $toggle = $('.degree-infobox-toggle');
			var triggerVal = 'click';
			var placementVal = 'left';

			if ($(window).width() > 767) {
				triggerVal = 'hover';
				placementVal = 'top';
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
			$('.comparison-header').matchHeight();

			// apply matchHeight to each item container's items
			$('.comparison-col:eq(0) .comparison-row').each(function(index) {
				var ei = index+2;
				$( '.comparison-col .comparison-row:nth-child(' + ei  + ')' ).matchHeight();
			});
		});
	</script>
<?php get_footer(); ?>
