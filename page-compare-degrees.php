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
		/*padding-left: 15px;*/
		margin-left: 15px;
	}
	@media (max-width: 480px) {
		.prereqs {
			margin-left: 5px;
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


	.comparison-chart > tbody > tr > th {
		width: 20%;
	}
	.comparison-chart > tbody > tr > td {
		width: 40%;
	}

	@media (max-width: 767px) {
		.comparison-chart > thead > th {
			width: 50%;
		}
		.comparison-chart > tbody > tr > th,
		.comparison-chart > tbody > tr > td {
			box-sizing: border-box;
			padding: 8px 15px;
		}
		.comparison-chart > tbody > tr > th {
			background-color: #fafafa;
			border-top: 0;
			display: block !important;
			margin-top: 10px;
			width: 100%;
		}
		.comparison-chart > tbody > tr > td {
			border-top: 0;
			display: block !important;
			float: left;
			width: 50%;
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
									<th>Accounting</th>
									<th>Finance</th>
								</tr>
							</thead>
						</table>
					</div>
					<table class="table comparison-chart">
						<thead class="hidden-phone" colspan="3">
							<tr>
								<th></th>
								<th>Accounting</th>
								<th>Finance</th>
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
							<tr>
								<th>Phone</th>
								<td>
									<a href="tel:4078232184">407-823-2184</a>
								</td>
								<td>
									<a href="tel:4078232184">407-823-1127</a>
								</td>
							</tr>
							<tr>
								<th>Degree</th>
								<td>PHD</td>
								<td>PHD</td>
							</tr>
							<tr>
								<th>Option</th>
								<td>Dissertation</td>
								<td>Dissertation</td>
							</tr>
							<tr>
								<th>Total Credit Hours</th>
								<td>84</td>
								<td>84</td>
							</tr>
							<tr>
								<th>Required Courses Credit Hours</th>
								<td>30</td>
								<td>39</td>
							</tr>
							<tr>
								<th>Core Credit Hours</th>
								<td>18</td>
								<td>18</td>
							</tr>
							<tr>
								<th>Prerequisites</th>
								<td>
									<ul class="prereqs">
										<li>ACG 7157 Seminar in Archival Research in Accounting</li>
										<li>ACG 7399 Seminar in Behavioral Accounting Research</li>
										<li>ACG 7826 Seminar in the Social and Organizational Context of Accounting</li>
										<li>ACG 7885 Research Foundations in Accounting</li>
										<li>ACG 7887 Accounting Research Forum</li>
									</ul>
								</td>
								<td>
									<ul class="prereqs">
										<li>FIN 7935 Finance Research Forum</li>
										<li>FIN 7808 Introduction to the Theory of Finance</li>
										<li>FIN 7807 Corporate Finance Theory</li>
										<li>FIN 7816 Investment Theory</li>
										<li>FIN 7930 Seminar in Market Microstructure</li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

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
					top: $comparisonChart.offset().top + $comparisonChartHead.height()
				}
			});
		});
	</script>
<?php get_footer(); ?>
