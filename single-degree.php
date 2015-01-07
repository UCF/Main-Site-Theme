<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php $post = append_degree_profile_metadata($post); ?>

	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/

	#contentcol,
	#sidebar_right {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 14px;
	}
	@media (max-width: 767px) {
		#sidebar_right {
			display: block;
		}
	}
/*	#contentcol a,
	#sidebar_right a {
		color: #08c;
	}
	#sidebar_right a:hover,
	#sidebar_right a:active,
	#sidebar_right a:focus {
		text-decoration: underline;
	}
	#sidebar_right a.btn:hover,
	#sidebar_right a.btn:active,
	#sidebar_right a.btn:focus {
		text-decoration: none;
	}*/


	#contentcol dt,
	#contentcol dd {
		display: inline;
	}


	#sidebar_right h2 {
		color: #888;
		font-size: 18px;
		font-weight: 500;
		margin-top: 20px;
	}
	#sidebar_right ul {
		list-style-type: none;
		margin-left: 0;
	}
	</style>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="contentcol" class="span8 program">
			<article role="main">

				<!-- Degree meta details -->

				<div class="row degree-details">
					<div class="span5">
						<dl>
							<dt>College:</dt>
							<dd>
								<!-- TODO: better way of forcing linebreak after inline <dd>'s that is IE friendly? -->
								<a href="#">Business Administration</a><br>
							</dd>
							<dt>Department:</dt>
							<dd>
								<a href="#">Kenneth G. Dixon School of Accounting</a><br>
							</dd>
							<dt>Website</dt>
							<dd>
								<a href="#">http://www.bus.ucf.edu/accounting/</a><br>
							</dd>
						</dl>
					</div>
					<div class="span3">
						<dl>
							<dt>Degree:</dt>
							<dd>PhD<br></dd>
							<dt>Option:</dt>
							<dd>Dissertation<br></dd>
							<dt>Phone:</dt>
							<dd><a href="#">407-823-2184</a></dd>
						</dl>
					</div>
				</div>

				<!-- Degree description -->

				<div class="degree-desc">
					<p>
						The objective of the Accounting track in the Business Administration PhD program is to prepare students
						for academic careers in higher education and management careers within profit and nonprofit
						organizations. Success in the program is judged by the student’s understanding of the issues and
						methodologies essential to the advancement of knowledge.
					</p>
					<p>
						Complete details and requirements available in the <a href="#">undergraduate catalog</a>.
					</p>
				</div>

			</article>
		</div>
		<div id="sidebar_right" class="span4 notoppad" role="complementary">

			<!-- Sidebar content -->

			<a class="btn btn-large btn-block btn-success">Apply Now</a>
			<a class="btn btn-large btn-block">View Catalog</a>

			<h2>Program Tracks</h2>
			<ul>
				<li>
					<a href="#">Accounting</a>
				</li>
				<li>
					<a href="#">Finance</a>
				</li>
				<li>
					<a href="#">Marketing</a>
				</li>
				<li>
					<a href="#">Management</a>
				</li>
			</ul>

			<h2>Graduate Handbook</h2>
			<a href="#">Accounting Handbook</a>

			<h2>Related Programs</h2>
			<ul>
				<li>
					<a href="#">Management</a>
				</li>
				<li>
					<a href="#">Marketing</a>
				</li>
			</ul>

			<h2>Subplan Disciplines</h2>
			<p>This track belongs to the following disciplines:</p>
			<ul>
				<li>
					<a href="#">Business</a>
				</li>
				<li>
					<a href="#">Accounting</a>
				</li>
			</ul>

		</div>
	</div>

<?php get_footer();?>
