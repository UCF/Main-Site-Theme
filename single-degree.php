<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php $post = append_degree_profile_metadata($post); ?>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title(); ?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="contentcol" class="span8 program">
			<article role="main">

				<!-- Degree meta details -->

				<div class="row degree-details">
					<div class="span4">
						<dl>
							<dt>College:</dt>
							<dd>
								<a href="#">Business Administration</a>
							</dd>
							<dt>Department:</dt>
							<dd>
								<a href="#">Kenneth G. Dixon School of Accounting</a>
							</dd>
							<dt>Website</dt>
							<dd>
								<a href="#">http://www.bus.ucf.edu/accounting/</a>
							</dd>
						</dl>
					</div>
					<div class="span4">
						<dl>
							<dt>Degree:</dt>
							<dd>PhD</dd>
							<dt>Option:</dt>
							<dd>Dissertation</dd>
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

			<a class="btn btn-large btn-success">Apply Now</a>
			<a class="btn btn-large">View Catalog</a>

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
			<span>This track belongs to the following disciplines:</span>
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
