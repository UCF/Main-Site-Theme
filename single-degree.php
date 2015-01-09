<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php $post = append_degree_profile_metadata($post); ?>

	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	#page_title .label {
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 13px;
		margin-left: 8px;
		padding: 6px;
		text-shadow: 0 0 0 transparent;
		vertical-align: middle;
	}
	#page_title .label a {
		color: #fff !important;
		text-decoration: underline;
	}


	#breadcrumbs {
		border-bottom: 2px solid #eee;
		font-family: "Helvetica Neue", "Helvetica-Neue", Helvetica, sans-serif;
		font-size: 12.5px;
		margin-bottom: 25px;
	}
	#breadcrumbs .breadcrumb-search {
		display: block;
		float: left;
		font-weight: 500;
		padding: 8px 0; /* match .breadcrumb top/bottom padding */
		width: 20%;
	}
	#breadcrumbs .breadcrumb-hierarchy {
		background: #fff;
		display: block;
		float: left;
		list-style-type: none;
		margin-bottom: 0;
	}
	#breadcrumbs .breadcrumb-search + .breadcrumb-hierarchy {
		padding-left: 0;
		padding-right: 0;
		width: 80%;
	}
	@media (min-width: 768px) and (max-width: 979px) {
		#breadcrumbs .breadcrumb-search {
			width: 24%;
		}
		#breadcrumbs .breadcrumb-search + .breadcrumb-hierarchy {
			width: 76%;
		}
	}
	@media (max-width: 767px) {
		/* Hiding breadcrumbs at mobile size seems to be a standard convention--not sure if I agree, but sticking with this for now */
		#breadcrumbs {
			display: none;
		}
	}


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
	#contentcol dd,
	#sidebar_right dt,
	#sidebar_right dd {
		display: inline;
	}
	#contentcol h2 {
		margin-top: 20px;
	}


	#contentcol .degree-details {
		margin-bottom: 30px;
	}
	@media (max-width: 767px) {
		#contentcol .degree-details {
			font-size: 12.5px;
			margin-bottom: 20px;
		}
	}
	#contentcol .degree-details dl {
		margin-bottom: 0;
		margin-top: 0;
	}


	@media (max-width: 767px) {
		#sidebar_right {
			border-top: 2px solid #eee;
			padding-top: 20px;
		}
	}
	#sidebar_right h2 {
		color: #888;
		font-size: 18px;
		font-weight: 500;
		line-height: 1.2;
		margin-bottom: 5px;
		margin-top: 20px;
	}
	#sidebar_right ul {
		list-style-type: none;
		margin-left: 0;
	}

	#sidebar_right .contact-name,
	#sidebar_right .contact-title/*,
	#sidebar_right .contact-email,
	#sidebar_right .contact-phone,
	#sidebar_right .contact-office */{
		display: block;
	}
	#sidebar_right .contact-name {
		font-weight: bold;
	}
	#sidebar_right .contact-title {
		font-style: italic;
	}
	#sidebar_right .contact-info-dl {
		margin-top: 5px;
	}
	</style>

	<div class="row page-content" id="degree-single">
		<div id="page_title" class="span12">
			<h1 class="span9">Accounting Ph.D.</h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>

		<div id="breadcrumbs" class="span12 clearfix">
			<!-- Display .breadcrumb-search only if the user came from the degree search (check for GET param) -->
			<a class="breadcrumb-search" href="#">&laquo; Back to Search Results</a>

			<!-- Always display hierarchy-based breadcrumbs-it also helps designate tracks/subplans -->
			<ul class="breadcrumb-hierarchy breadcrumb">
				<li>
					<a href="#">Graduate Programs</a> <span class="divider">></span>
				</li>
				<li>
					<a href="#">Business Administration Ph.D.</a> <span class="divider">></span>
				</li>
				<li class="active">
					Accounting Ph.D. track
				</li>
			</ul>
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
								<a href="#">Kenneth G. Dixon School of Accounting</a>
							</dd>
						</dl>
					</div>
					<div class="span3">
						<dl>
							<dt>Degree:</dt>
							<dd>Ph.D.<br></dd>
							<dt>Option:</dt>
							<dd>Dissertation</dd>
						</dl>
					</div>
				</div>

				<div class="visible-phone">
					<a class="btn btn-large btn-block btn-success">View Catalog</a>
					<a class="btn btn-large btn-block">Visit Program Website</a>
				</div>

				<!-- Degree description -->

				<div class="degree-desc">
					<h2>Program Description</h2>
					The objective of the Accounting track in the Business Administration PhD program is to prepare students
					for academic careers in higher education and management careers within profit and nonprofit
					organizations. Success in the program is judged by the student’s understanding of the issues and
					methodologies essential to the advancement of knowledge.
				</div>

				<!-- Application Info -->

				<div class="degree-application-info">
					<h2>Application Requirements</h2>
					<p>
						For information on general UCF graduate admissions requirements that apply to all prospective
						students, please visit the
						<a target="_blank" href="/content/Admissions.aspx" title="Admissions">Admissions</a> section of
						the Graduate Catalog. Applicants must
						<a target="_blank" href="https://www.students.graduate.ucf.edu/gradonlineapp/" title="apply online">apply online</a>.
						All requested materials must be submitted by the established deadline.
					</p>
					<p>
						In addition to the
						<a target="_blank" href="http://www.graduatecatalog.ucf.edu/content/Admissions.aspx" title="general UCF graduate admission requirements">general UCF graduate application requirements</a>,
						applicants to this program must provide:
					</p>
					<ul>
						<li>One official transcript (in a sealed envelope) from each college/university attended.</li>
						<li>Official, competitive GRE or GMAT score taken within the last five years.</li>
						<li>Three letters of recommendation.</li>
						<li>Goal statement.</li>
						<li>Résumé.</li>
						<li>Other: Previous publications and/or other relevant supporting documentation.</li>
						<li>A computer-based score of 233 (or 91 internet-based score) on the Test of English as a Foreign language (TOEFL) if an applicant is from a country where English is not the official language, or if an applicant's degree is not from an accredited U.S. institution, or if an applicant did not earn a degree in a country where English is the only official language or a university where English is the only official language of instruction. Although we prefer the TOEFL, we will accept IELTS scores of 7.0. </li>
						<li>Applicants to this program are strongly encouraged to complete the necessary information requested for the ETS PPI (Personal Potential Index) report that is available during the GRE examination.  All official PPI reports must be submitted directly to the UCF College of Graduate Studies (use UCF Institution Code: 5233).</li>
					</ul>
					<p>
						Admission decisions are made based on faculty recommendations from the appropriate department or
						school. Admissions will generally be made only for fall semester, every other year; however,
						exceptions may be made in some cases. All interested students should contact the program director
						for their track for information about applying to this program.  The college strongly encourages
						applications from minority and diverse populations. Race, national origin, and gender are not used
						in the evaluation of students for admission into graduate and professional programs.
					</p>
				</div>

				<!-- For root programs ONLY (programs that have a academicSubPlanList)

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
				-->

			</article>
		</div>
		<div id="sidebar_right" class="span4 notoppad" role="complementary">

			<!-- Sidebar content -->

			<div class="hidden-phone">
				<a class="btn btn-large btn-block btn-success">View Catalog</a>
				<a class="btn btn-large btn-block">Visit Program Website</a>
			</div>

			<h2>Contact</h2>
			<h3 class="contact-name">Steve Sutton Ph.D.</h3>
			<span class="contact-title">Professor</span>
			<dl class="contact-info-dl">
				<dt>Email:</dt>
				<dd>
					<span class="contact-email">
						<a href="mailto:steve.sutton@ucf.edu">steve.sutton@ucf.edu</a>
					</span>
					<br>
				</dd>
				<dt>Phone:</dt>
				<dd>
					<span class="contact-phone">
						<a href="#">407-823-5857</a>
					</span>
					<br>
				</dd>
				<dt>Office:</dt>
				<dd>
					<span class="contact-office">
						<a target="_blank" href="http://map.ucf.edu">Business Administration 436</a>
					</span>
				</dd>
			</dl>

			<h2>Resources</h2>
			<ul>
				<li>
					<a href="#">Accounting Handbook</a>
				</li>
			</ul>

			<h2>Related Programs</h2>
			<ul>
				<li>
					<a href="#">Accounting MSA</a>
				</li>
			</ul>

			<h2>More Business Administration PhD Tracks</h2>
			<ul>
				<li>
					<a href="#">Finance</a>
				</li>
				<li>
					<a href="#">Management</a>
				</li>
				<li>
					<a href="#">Marketing</a>
				</li>
			</ul>

<!--
Is this what will become "keyword" matches?
			<h2>Subplan Disciplines</h2>
			<p>This track belongs to the following disciplines:</p>
			<ul>
				<li>
					<a href="#">Business</a>
				</li>
				<li>
					<a href="#">Accounting</a>
				</li>
			</ul> -->

		</div>
	</div>

<?php get_footer();?>
