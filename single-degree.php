<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php $post = append_degree_profile_metadata($post); ?>

<?php
	$css_key = get_theme_option('cloud_font_key');
	if ($css_key) {
		print '<link rel="stylesheet" href="'.$css_key.'" type="text/css" media="all" />';
	}

?>

	<style>
	/**
	 * TODO: Move to style.css/style-responsive.css when design drafting is done
	 **/
	#breadcrumbs {
		border-bottom: 2px solid #eee;
		font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
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
		font-family: 'Gotham SSm 4r', 'Gotham SSm A', 'Gotham SSm B';
		font-size: 14px;
	}
	#sidebar_right {
		box-sizing: border-box;
		padding-left: 15px;
	}
	.ie7 #sidebar_right {
		padding-left: 0;
	}
	@media (max-width: 767px) {
		#sidebar_right {
			display: block; /* unset display: none; */
			margin-top: 30px;
			padding-left: 0;
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


	#contentcol p {
		margin: 0 0 10px;
	}
	#contentcol dt,
	#contentcol dd,
	#sidebar_right dt,
	#sidebar_right dd {
		display: inline;
	}
	#contentcol h2,
	#contentcol h3,
	#contentcol h4,
	#contentcol h5,
	#contentcol h6 {
		font-weight: 500;
		margin-bottom: 5px;
	}
	#contentcol h2 {
		font-size: 24px;
		line-height: 26px;
		margin-bottom: 8px;
		margin-top: 40px;
	}
	@media (max-width: 767px) {
		#contentcol h2 {
			font-size: 23px;
			line-height: 25px;
		}
	}
	#contentcol h3 {
		border-bottom: 1px solid #eee;
		font-size: 18.5px;
		line-height: 21px;
		margin-top: 30px;
	}
	#contentcol h4 {
		font-size: 15.5px;
		line-height: 18px;
		margin-top: 25px;
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


	#contentcol .degree-desc {
		margin-bottom: 30px;
	}


	#contentcol .degree-courses h3 {
		border-bottom: 1px solid #eee;
		padding-bottom: 5px;
	}


	#contentcol .degree-courses .degree-courses-credits {
		display: block;
		float: right;
		font-weight: 500;
	}
	@media (max-width: 767px) {
		#contentcol .degree-courses .degree-courses-credits {
			float: none;
			margin-top: 5px;
		}
	}
	#contentcol .degree-courses h3 .degree-courses-credits {
		font-size: 15px;
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
		font-weight: normal;
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

		<div id="contentcol" class="span8 degree">
			<article role="main">

				<!-- Degree description -->

				<p class="degree-desc">
					The objective of the Accounting track in the Business Administration PhD program is to prepare students
					for academic careers in higher education and management careers within profit and nonprofit
					organizations. Success in the program is judged by the student’s understanding of the issues and
					methodologies essential to the advancement of knowledge.
				</p>

				<!-- Degree meta details -->

				<div class="row degree-details">
					<div class="span3">
						<dl>
							<dt>Degree:</dt>
							<dd>Ph.D.<br></dd>
							<dt>Option:</dt>
							<dd>Dissertation<br></dd>
							<dt>Online Program:</dt>
							<dd>No</dd>
						</dl>
					</div>
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
				</div>

				<div class="visible-phone">
					<a class="btn btn-large btn-block btn-success">View Catalog</a>
					<a class="btn btn-large btn-block">Visit Program Website</a>
				</div>

				<!-- Application Info -->

				<div class="degree-application-info">
					<h2>Admission &amp; Application Requirements</h2>
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

				<div class="degree-courses">
					<h2 class="clearfix">Degree Requirements <small class="degree-courses-credits">84 Credit Hours total</small></h2>
					<p>
						The Accounting Ph.D. requires <strong>84</strong> Credit Hours Minimum beyond the Bachelor's Degree.
					</p>

					<h3>1. Prerequisites &mdash; Foundation Body of Knowledge <small class="degree-courses-credits">30 Credit Hours</small></h3>
					<p>
						In the Accounting track of the Business Administration PhD program, the foundation body of knowledge may be satisfied
						with a master’s degree in Accounting, Business Administration, Taxation or its equivalent from an Association to Advance
						Collegiate Schools of Business (AACSB) accredited school that includes certain accounting courses deemed essential by
						the Accounting PhD director. Alternatively, this requirement may be satisfied by courses approved by the School of
						Accounting’s doctoral advisory committee.
					</p>

					<h3 class="clearfix">2. Required Courses <small class="degree-courses-credits">30 Credit Hours</small></h3>

					<h4 class="clearfix">Accounting Core <small class="degree-courses-credits">18 Credit Hours</small></h4>
					<ul type="disc">
						<li><a rel="/Programs/Courses.aspx?Course=ACG 7157" class="CourseClassHover" title="">ACG 7157</a> Seminar in Archival Research in Accounting (3 credit hours)</li>
						<li><a rel="/Programs/Courses.aspx?Course=ACG 7399" class="CourseClassHover">ACG 7399</a> Seminar in Behavioral Accounting Research (3 credit hours)</li>
						<li><a rel="/Programs/Courses.aspx?Course=ACG 7826" class="CourseClassHover" title="">ACG 7826</a> Seminar in the Social and Organizational Context of Accounting (3 credit hours)</li>
						<li><a rel="/Programs/Courses.aspx?Course=ACG 7885" class="CourseClassHover" title="">ACG 7885</a> Research Foundations in Accounting (3 credit hours)</li>
						<li><a rel="/Programs/Courses.aspx?Course=ACG 7887" class="CourseClassHover" title="">ACG 7887</a> Accounting Research Forum (6 credit hours) (Workshop, 1 credit hour per semester)</li>
					</ul>

					<h4 class="clearfix">Research Methods/Tools <small class="degree-courses-credits">12 Credit Hours</small></h4>
					<p>
						The research tools requirement is intended to ensure a thorough exposure to research methods. All candidates are expected
						 to demonstrate knowledge of statistical methods as well as usage of statistical packages, including design, analysis,
						 and interpretation of results.
					</p>
					<ul>
						<li><a rel="/Programs/Courses.aspx?Course=ECO 7423" class="CourseClassHover">ECO 7423</a> Applied Models I (3 credit hours, required course)</li>
						<li>Additional 9 credit hours of research tools courses approved by the student’s advisory committee. Examples of courses that will satisfy this requirement include <a rel="/Programs/Courses.aspx?Course=ACG 7837" class="CourseClassHover">ACG 7837</a>, <a rel="/Programs/Courses.aspx?Course=GEB 7910" class="CourseClassHover">GEB 7910</a>, <a rel="/Programs/Courses.aspx?Course=STA 5205" class="CourseClassHover">STA 5205</a>, <a rel="/Programs/Courses.aspx?Course=PSY 6216C" class="CourseClassHover">PSY 6216C</a>, <a rel="/Programs/Courses.aspx?Course=PSY 6308C" class="CourseClassHover">PSY 6308C</a>, <a rel="/Programs/Courses.aspx?Course=PSY 7218C" class="CourseClassHover">PSY 7218C</a>, <a rel="/Programs/Courses.aspx?Course=ECO 6424" class="CourseClassHover">ECO 6424</a>, and <a rel="/Programs/Courses.aspx?Course=ISM 7029" class="CourseClassHover">ISM 7029</a>.</li>
					</ul>

					<h3 class="clearfix">3. Elective Courses <small class="degree-courses-credits">9 Credit Hours</small></h3>

					<h4 class="clearfix">Restricted <small class="degree-courses-credits">3 Credit Hours</small></h4>
					<p>
						Choose one of the following accounting courses:
					</p>
					<ul type="disc"><li><a rel="/Programs/Courses.aspx?Course=ACG 7888" class="CourseClassHover">ACG 7888</a> Seminar in Critical Accounting and AIS (3 credit hours)</li><li><a rel="/Programs/Courses.aspx?Course=ACG 7917" class="CourseClassHover">ACG 7917</a> Advanced Research Methods in Accounting and Accounting Information Systems Research (3 credit hours)</li><li>Other accounting electives as they are developed for the program</li></ul>

					<h4 class="clearfix">Unrestricted <small class="degree-courses-credits">6 Credit Hours</small></h4>
					<p>
						Students must take 6 credit hours in a minor/support area. Students must select a minimum of six credit hours in a unified area approved by the student’s doctoral study advisory committee. Each student’s program of study is individually tailored to accommodate interests whenever possible. This course work may be developed from offerings in the following areas with the advice and consent of the respective departments and the advisory committee:
					</p>
					<ul type="disc"><li>Marketing</li><li>Economics</li><li>Political Science</li><li>Psychology</li><li>Gender Studies</li><li>Management</li><li>Sociology</li><li>Environmental Studies</li><li>Communication</li><li>Philosophy</li><li>Public Affairs</li></ul>

					<h3 class="clearfix">4. Dissertation <small class="degree-courses-credits">15 Credit Hours</small></h3>
					<ul>
						<li>ACG 7980 Dissertation (15 credit hours minimum)</li>
					</ul>

					<h3>5. Admission to Candidacy</h3>
					<p>
						Students must complete a comprehensive candidacy examination that includes written and oral portions. Students must defend a written dissertation proposal in an oral examination conducted by the student’s advisory/dissertation committee. The final defense of the dissertation will also require an oral examination.
					</p>
					<p>
						Students officially enter candidacy when the following has been accomplished:
					</p>
					<ul type="disc">
						<li>Completion of all course work, except for dissertation hours. </li>
						<li>Successful completion of the&nbsp;comprehensive candidacy&nbsp;examination. </li>
						<li>Successful defense of the written dissertation proposal. </li>
						<li>The dissertation advisory committee is formed, consisting of approved graduate faculty and graduate faculty scholars.</li>
						<li>Submittal of an approved program of study.</li>
					</ul>

					<h3>6. Teaching Requirement</h3>
					<p>
						The requirements for the teaching component of the degree will be developed with the doctoral program director based
						on the student’s experience. Normally, this requirement will be satisfied through teaching a minimum of three credit
						hours of class instruction under the direct supervision of a faculty member. As appropriate, students will also be
						required to attend teaching development workshops and seminars.
					</p>

					<h3>7. Independent Learning</h3>
					<p>
						The dissertation serves as the independent learning experience.
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
