<?php get_header(); the_post();?>
	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	#contentcol {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}


	.prereqs {
		list-style-type: none;
		margin-left: 0;
	}
	.prereqs li {
		margin-bottom: 8px;
	}
	@media (max-width: 767px) {
		.prereqs li {
			font-size: 12px;
			line-height: 1.3;
		}
	}


	#comparison-chart-head-phone {
		background-color: #fff;
		margin-left: -20px; /* force push past body margin-left */
		width: 100%;
	}
	#comparison-chart-head-phone.affix {
		top: 0;
	}

	#comparison-chart-head-phone .table {
		border-bottom: 2px solid #e5e5e5;
		margin-bottom: 0;
		margin-left: 20px;
	}
	#comparison-chart-head-phone.affix .table {
		margin-left: 0;
	}
	#comparison-chart-head-phone .table th {
		text-align: center;
		width: 50%;
	}
	@media (max-width: 767px) {
		#comparison-chart-head-phone .table th {
			font-size: 18px;
			font-weight: 500;
			line-height: 1.1;
		}
	}

	#comparison-chart-head-phone thead th a,
	.comparison-chart thead th a {
		border-bottom: 0 solid transparent !important;
		color: #08c !important;
	}
	#comparison-chart-head-phone thead th a:hover,
	#comparison-chart-head-phone thead th a:active,
	#comparison-chart-head-phone thead th a:focus,
	.comparison-chart thead th a:hover,
	.comparison-chart thead th a:active,
	.comparison-chart thead th a:focus {
		text-decoration: underline !important;
	}

	.comparison-chart th,
	.comparison-chart td {
		border-top: 1px solid #eee;
		padding: 10px 15px;
	}
	.comparison-chart tbody tr:hover th,
	.comparison-chart tbody tr:hover td {
		background-color: #fcf8e3;
	}
	@media (max-width: 767px) {
		.comparison-chart tbody tr:hover th {
			background-color: #eee;
		}
		.comparison-chart tbody tr:hover td {
			background-color: #fff;
		}
	}
	.comparison-chart > thead > tr > th {
		font-size: 21px;
		font-weight: 500;
		line-height: 1.2;
		padding-bottom: 10px;
		text-align: center;
	}
	.comparison-chart > tbody > tr > th {
		background-color: #eee;
		width: 20%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		.comparison-chart > tbody > tr > th {
			width: 24%;
		}
	}
	.comparison-chart > tbody > tr > td {
		text-align: center;
		vertical-align: middle;
		width: 40%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		.comparison-chart > tbody > tr > td {
			width: 38%;
		}
	}
	.comparison-chart > tbody > tr > td.align-top {
		vertical-align: top;
	}
	.comparison-chart > tbody > tr > td ol,
	.comparison-chart > tbody > tr > td ul,
	.comparison-chart > tbody > tr > td dl {
		text-align: left;
	}

	@media (max-width: 767px) {
		.comparison-chart > thead > th {
			width: 50%;
		}
		.comparison-chart > tbody > tr > th,
		.comparison-chart > tbody > tr > td {
			box-sizing: border-box;
			padding: 6px 10px;
		}
		.comparison-chart > tbody > tr > th {
			background-color: #eee;
			border-top: 0;
			display: block !important;
			font-size: 13px;
			margin-top: 10px;
			width: 100%;
		}
		.comparison-chart > tbody > tr > td {
			border-top: 0;
			display: block !important;
			float: left;
			font-size: 12px;
			line-height: 1.4;
			width: 50%;
		}
	}


	.comparison-chart .degree-infobox-toggle {
		border-bottom: 0 solid transparent !important;
		display: block;
		float: right;
	}
	.comparison-chart .degree-infobox-toggle .icon {
		padding-bottom: 3px;
		border-bottom: 1px dotted #999;
	}
	.comparison-chart .popover-title {
		display: none; /* hide empty titles */
	}
	.comparison-chart .popover {
		font-size: 12px;
		line-height: 1.4;
		font-weight: normal;
	}
	@media (max-width: 767px) {
		.comparison-chart .popover-content {
			max-height: 250px;
			overflow-x: hidden;
			overflow-y: scroll;
			-webkit-overflow-scrolling: touch;
		}
	}
	</style>


	<?php $degrees = get_degree_search_data(); ?>
	<div class="row page-content" id="academics-search">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title(); ?>: Accounting &amp; Finance</h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div class="span12" id="contentcol">
			<article role="main">

				<div class="visible-phone" id="comparison-chart-head-phone">
					<table class="table">
						<thead>
							<tr>
								<th><a href="#">Accounting</a></th>
								<th><a href="#">Finance</a></th>
							</tr>
						</thead>
					</table>
				</div>
				<table class="table table-hover comparison-chart">
					<thead class="hidden-phone" colspan="3">
						<tr>
							<th></th>
							<th><a href="#">Accounting</a></th>
							<th><a href="#">Finance</a></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>College</th>
							<td>
								<a href="http://www.bus.ucf.edu/" target="_blank">Business Administration</a>
							</td>
							<td>
								<a href="http://www.bus.ucf.edu/" target="_blank">Business Administration</a>
							</td>
						</tr>
						<tr>
							<th>Department</th>
							<td>
								<a href="http://www.bus.ucf.edu/accounting/" target="_blank">Kenneth G. Dixon School of Accounting</a>
							</td>
							<td>
								<a href="http://www.bus.ucf.edu/finance/" target="_blank">Finance</a>
							</td>
						</tr>
<!-- 							<tr>
							<th>Phone</th>
							<td>
								<a href="tel:4078232184">407-823-2184</a>
							</td>
							<td>
								<a href="tel:4078232184">407-823-1127</a>
							</td>
						</tr> -->
						<tr>
							<th>Degree</th>
							<td>PHD</td>
							<td>PHD</td>
						</tr>
						<tr>
							<th>
								Option
								<a class="degree-infobox-toggle" data-content="More Information" href="#">
									<span class="icon icon-info-sign"></span>
								</a>
							</th>
							<td>Dissertation</td>
							<td>Dissertation</td>
						</tr>
						<tr>
							<th>
								Core Credit Hours
								<a class="degree-infobox-toggle" data-content="More Information" href="#">
									<span class="icon icon-info-sign"></span>
								</a>
							</th>
							<td>18</td>
							<td>18</td>
						</tr>
						<tr>
							<th>
								Required Courses Credit Hours
								<a class="degree-infobox-toggle" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis quis accumsan velit, vitae tempor lorem. Aenean libero tortor, auctor ac sem non, finibus condimentum leo. In nulla risus, sagittis consequat risus eu, maximus lobortis mauris. Sed turpis tellus, ultrices ut mi a, luctus laoreet justo. Vestibulum et sapien vel arcu vehicula vestibulum convallis id sapien. In hac habitasse platea dictumst. Etiam nec justo ante. Ut a feugiat ligula, vel volutpat diam." href="#">
									<span class="icon icon-info-sign"></span>
								</a>
							</th>
							<td>30</td>
							<td>39</td>
						</tr>
						<tr>
							<th>Total Credit Hours</th>
							<td>84</td>
							<td>84</td>
						</tr>
						<tr>
							<th>
								Prerequisites
								<a class="degree-infobox-toggle" data-content="More Information" href="#">
									<span class="icon icon-info-sign"></span>
								</a>
							</th>
							<td class="align-top">
								<ul class="prereqs">
									<li><strong>ACG 7157</strong> Seminar in Archival Research in Accounting</li>
									<li><strong>ACG 7399</strong> Seminar in Behavioral Accounting Research</li>
									<li><strong>ACG 7826</strong> Seminar in the Social and Organizational Context of Accounting</li>
									<li><strong>ACG 7885</strong> Research Foundations in Accounting</li>
									<li><strong>ACG 7887</strong> Accounting Research Forum</li>
								</ul>
							</td>
							<td class="align-top">
								<ul class="prereqs">
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
			var placementVal = 'left';

			if ($(window).width() > 767) {
				triggerVal = 'hover';
				placementVal = 'right';
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
