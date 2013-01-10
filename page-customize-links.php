<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta name="viewport" content="width=device-width">
		<?="\n".header_()."\n"?>
		<?php if(GA_ACCOUNT or CB_UID):?>
		
		<script type="text/javascript">
			var _sf_startpt = (new Date()).getTime();
			<?php if(GA_ACCOUNT):?>
			
			var GA_ACCOUNT  = '<?=GA_ACCOUNT?>';
			var _gaq        = _gaq || [];
			_gaq.push(['_setAccount', GA_ACCOUNT]);
			_gaq.push(['_setDomainName', 'none']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);
			<?php endif;?>
			<?php if(CB_UID):?>
			
			var CB_UID      = '<?=CB_UID?>';
			var CB_DOMAIN   = '<?=CB_DOMAIN?>';
			<?php endif?>
			
		</script>
		<?php endif;?>
		
		<?  $post_type = get_post_type($post->ID);
			if(($stylesheet_id = get_post_meta($post->ID, $post_type.'_stylesheet', True)) !== False
				&& ($stylesheet_url = wp_get_attachment_url($stylesheet_id)) !== False) { ?>
				<link rel='stylesheet' href="<?=$stylesheet_url?>" type='text/css' media='all' />
		<? } ?>

		<script type="text/javascript">
			var PostTypeSearchDataManager = {
				'searches' : [],
				'register' : function(search) {
					this.searches.push(search);
				}
			}
			var PostTypeSearchData = function(column_count, column_width, data) {
				this.column_count = column_count;
				this.column_width = column_width;
				this.data         = data;
			}
			
			var ALERT_RSS_URL              = '<?php echo get_theme_option('alert_feed_url'); ?>';
		</script>
		
	</head>
	<!--[if lt IE 7 ]>  <body class="ie ie6 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if IE 7 ]>     <body class="ie ie7 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if IE 8 ]>     <body class="ie ie8 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if IE 9 ]>     <body class="ie ie9 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <body class="<?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <!--<![endif]-->
		
		
		<!-- Begin UCF Header -->
		<div id="UCFHBHeader">
			<div class="UCFHBWrapper">
				<div id="UCFtitle">
					<a href="<?=get_site_url()?>">
						<span class="UCFHBText">University of Central Florida</span>
					</a>
				</div>
				<label for="UCFHeaderLinks">University Links</label>
				<label for="q">Search UCF</label>
				<div id="UCFHBSearch_and_links">
					<form id="UCFHBUni_links" action="" target="_top">
						<fieldset>
							<select name="UniversityLinks" id="UCFHBHeaderLinks" onchange="quickLinks.quickLinksChanged()">
								<option value="">Quicklinks:</option>
								<option value="">- - - - - - - - - -</option>
								<option value="http://library.ucf.edu">Libraries</option>
								<option value="http://www.ucf.edu/directories/">Directories (A-Z Index)</option>
								<option value="http://map.ucf.edu">Campus Map</option>
								<option value="http://ucffoundation.org/">Giving to UCF</option>
								<option value="http://ask.ucf.edu">Ask UCF</option>
								<option value="http://finaid.ucf.edu/">Financial Aid</option>
								<option value="http://today.ucf.edu/">UCF Today</option>
								<option value="https://www.secure.net.ucf.edu/knightsmail/">Knight's Email</option>
								<option value="http://events.ucf.edu/">Events at UCF</option>
								<option value="">- - - - - - - - - -</option>
								<option value="+">+ Add This Page</option>
								<option value="">- - - - - - - - - -</option>
								<option value="&gt;">&gt; Customize This List</option>
							</select>
						</fieldset>
					</form>
					<div>
						<a id="UCFHBMy_ucf" href="http://my.ucf.edu/">
							<span class="text">myUCF</span>
						</a>
					</div>
					<form id="UCFHBSearch_ucf" method="get" action="http://google.cc.ucf.edu/search" target="_top">
						<fieldset>
							<input type="hidden" name="output" value="xml_no_dtd">
							<input type="hidden" name="proxystylesheet" value="UCF_Main">
							<input type="hidden" name="client" value="UCF_Main">
							<input type="hidden" name="site" value="UCF_Main">
							<input class="text" type="text" name="q" id="q" value="Search UCF" title="Search UCF" onfocus="clearDefault(this);" onblur="clearDefault(this);">
							<input id="UCFHBsubmit" type="submit" value="">
						</fieldset>
					</form>
					<div id="UCFHBClearBoth"></div>			
				</div>		
			</div>
		</div>
		<!-- end UCF Header -->
		
		
		<div class="container">
			<div class="row status-alert" id="status-alert-template" data-alert-id="">
				<div class="span12">
					<div class="alert alert-error alert-block">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<div class="alert-icon general"></div>
						<h2>
							<a href="<?php echo get_theme_option('alert_more_information_url'); ?>">
								<span class="title"> </span>
							</a>
						</h2>
						<p class="alert-body">
							<a href="<?php echo get_theme_option('alert_more_information_url'); ?>">
								<span class="content"> </span>
							</a>
						</p>
						<p class="alert-action">
							<a class="more-information btn btn-danger" href="<?php echo get_theme_option('alert_more_information_url'); ?>">Click Here for More Information</a>
						</p>
					</div>
				</div>
			</div>
			<div class="row" id="header_wrap">
				<div id="header" class="row-border-bottom-top" role="banner">
					<h1><?=bloginfo('name')?></h1>
				</div>
			</div>
			<div id="header-nav-wrap" role="navigation">
				<?=wp_nav_menu(array(
					'theme_location' => 'header-menu', 
					'container' => 'false', 
					'menu_class' => 'menu '.get_header_styles(), 
					'menu_id' => 'header-menu', 
					'walker' => new Bootstrap_Walker_Nav_Menu()
					));
				?>
			</div>
			
			
	<?php the_post(); ?>		
			
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data(\'span3\');'); ?>
		</div>
		
		<?=get_page_subheader($post)?>
		
		<div id="sidebar_left" class="span2" role="navigation">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span10" id="contentcol">
			<article role="main">
				<?php if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') { ?><div class="rightcol_subheader_fix"></div><?php } ?>
				<?php the_content();?>
				
				<form role="form">
					<div id="quicklinks-panel" class="row">
						<div class="quicklinks-column span4">
							<h3>Available Links</h3>
							<select multiple id="sourceLinks" class="quicklinks-list">
								<option value="http://advising.sdes.ucf.edu/offices">Academic Advising</option>
								<option value="http://registrar.sdes.ucf.edu/calendar">Academic Calendar</option>
								<option value="http://www.aep.sdes.ucf.edu/">Academic Exploration Program (A.E.P.)</option>
								<option value="http://z.ucf.edu">Academic Integrity</option>
								<option value="http://www.ucf.edu/academics/">Academic Programs</option>
								<option value="http://www.academicservices.ucf.edu">Academic Services</option>
								<option value="http://assa.sdes.ucf.edu/">Academic Services For Student Athletes (A.S.S.A.)</option>
								<option value="http://web.bus.ucf.edu/accounting/">Accounting, Kenneth G. Dixon School of</option>
								<option value="http://www.iroffice.ucf.edu/degrees/index.html">Accreditations and Degrees</option>
								<option value="http://www.osi.sdes.ucf.edu">Activities for Students</option>
								<option value="http://www.asf.ucf.edu">Activity and Service Fee Business Office</option>
								<option value="http://campusmap.ucf.edu/address.php">Address, UCF</option>
								<option value="http://admfin.ucf.edu/">Administration &amp; Finance Division</option>
								<option value="http://admin.sdes.ucf.edu/">Administrative Services</option>
								<option value="http://www.admissions.ucf.edu/">Admissions Undergraduate</option>
								<option value="http://www.ampac.ucf.edu/">Advanced Materials Processing And Analysis Center (Ampac)</option>
								<option value="http://victimservices.ucf.edu">Advocate Services</option>
								<option value="http://aas.cah.ucf.edu">African American Studies</option>
								<option value="http://airforce.ucf.edu">Air Force R.O.T.C.</option>
								<option value="http://aod.sdes.ucf.edu/">Alcohol and Other Drug Prevention Programming</option>
								<option value="http://www.ucfalumni.com/">Alumni Association</option>
								<option value="https://www.ucfknightsnetwork.com/SSLPage.aspx?pid=290&bm=-1287142307">Alumni Directory</option>
								<option value="http://www.ucf.edu/pls/CDWS/W4_BBS_ANNOUNCEMENTS.main_disp_sel?p_role=all">Announcements</option>
								<option value="http://anthropology.cos.ucf.edu/">Anthropology Department</option>
								<option value="http://anxietyclinic.cos.ucf.edu/">Anxiety Disorders Clinic</option>
								<option value="http://www.admissions.graduate.ucf.edu/">Application Information, Graduate</option>
								<option value="https://admissions.ucf.edu/application/login.aspx?ReturnUrl=%2fapplication%2f">Application Information, Undergraduate</option>
								<option value="http://caat.engr.ucf.edu/">Applied Acoustoelectronic Technology, Consortium Of</option>
								<option value="http://www.arboretum.ucf.edu">Arboretum</option>
								<option value="http://www.ucfarena.com/index.php">Arena/Global Spectrum, UCF</option>
								<option value="http://www.ucfrotc.com/">Army R.O.T.C.</option>
								<option value="http://www.art.ucf.edu">Art Department</option>
								<option value="http://education.ucf.edu/arted/">Art Education Program</option>
								<option value="http://www.cah.ucf.edu/">Arts &amp; Humanities, College Of</option>
								<option value="http://graduate.cah.ucf.edu/index.php">Arts and Humanities, Graduate Student Web Site, College Of</option>
								<option value="http://library.ucf.edu/Ask/">Ask A Librarian</option>
								<option value="http://ucf.custhelp.com/cgi-bin/ucf.cfg/php/enduser/std_alp.php?p_sid=4Qf9nsfk">Ask UCF</option>
								<option value="http://ucfathletics.com/">Athletics</option>
								<option value="http://biology.cos.ucf.edu">Biology Department</option>
								<option value="http://www.biomed.ucf.edu">Biomedical Sciences, Burnett School of</option>
								<option value="http://www.biomed.ucf.edu">Biomolecular Science Center</option>
								<option value="http://www.biomed.ucf.edu">Biomolecular Sciences, Ph. D</option>
								<option value="http://www.bfsa-ucf.org">Black Faculty And Staff Association, U.C.F. (B.F.S.A.)</option>
								<option value="http://bot.ucf.edu/">Board Of Trustees, UCF</option>
								<option value="http://ucf.bncollege.com/webapp/wcs/stores/servlet/BNCBHomePage?storeId=16552&catalogId=10001">Bookstore, University</option>
								<option value="http://brand.ucf.edu">Brand and Identity Guidelines</option>
								<option value="http://www.fa.ucf.edu/">Budget Office</option>
								<option value="http://www.honors.ucf.edu/">Burnett Honors College</option>
								<option value="http://www.golynx.com/plan-trip/2011/12/4/UNIVERSITY-OF-CENTRAL-FLORIDA.stml">Bus Schedule, Lynx UCF Route</option>
								<option value="http://parking.ucf.edu/Shuttle.html">Bus, UCF Shuttle</option>
								<option value="http://web.bus.ucf.edu/">Business Administration, College Of</option>
								<option value="http://www.incubator.ucf.edu">Business Incubation Program</option>
								<option value="https://businessservices.ucf.edu/index.html">Business Services</option>
								<option value="http://events.ucf.edu">Calendar</option>
								<option value="http://cfm.sdes.ucf.edu/">Campus Faiths &amp; Ministries</option>
								<option value="http://map.ucf.edu/">Campus Map</option>
								<option value="https://apply.ucf.edu/forms/forms/open-house/">Campus Open House</option>
								<option value="http://police.ucf.edu/CrimeStats.html">Campus Security Report</option>
								<option value="http://admissions.ucf.edu/visit/">Campus Tours</option>
								<option value="http://www.ucfcard.ucf.edu/">Card Office, UCF</option>
								<option value="http://www.career.ucf.edu">Career Services</option>
								<option value="http://www.fa.ucf.edu/">Cashier, UCF Office of the</option>
								<option value="http://www.ccmknights.com/">Catholic Campus Ministry</option>
								<option value="http://www.cem.ucf.edu">Center For Emerging Media</option>
								<option value="http://ucf-card.org/">Center for Autism and Related Disabilities</option>
								<option value="http://www2.cohpa.ucf.edu/ccp/">Center for Community Partnerships</option>
								<option value="http://cdl.ucf.edu">Center for Distributed Learning</option>
								<option value="http://www.cei.ucf.edu">Center for Entrepreneurship &amp; Innovation</option>
								<option value="http://www2.cohpa.ucf.edu/cpnm/">Center for Public and Nonprofit Management</option>
								<option value="http://www.centralfloridafuture.com">Central Florida Future</option>
								<option value="https://my.ucf.edu/">Check Your Graduate Admissions Status</option>
								<option value="https://my.ucf.edu/index.html">Check Your Undergraduate Admissions Status</option>
								<option value="http://chemistry.cos.ucf.edu">Chemistry</option>
								<option value="http://education.ucf.edu/cfcs/">Child, Family, And Community Sciences</option>
								<option value="http://www.cece.ucf.edu">Civil &amp; Environmental Engineering</option>
								<option value="https://my.ucf.edu/schedulesearch.html">Class Schedule</option>
								<option value="http://education.ucf.edu/clinicalexp/">Clinical Experiences,College Of Education</option>
								<option value="http://www.ucf.edu/academics/">Colleges &amp; Schools</option>
								<option value="http://www.registrar.sdes.ucf.edu/commencement/">Commencement</option>
								<option value="http://www2.cohpa.ucf.edu/clinic/">Communication Disorders Clinic</option>
								<option value="http://www.cohpa.ucf.edu/comdis/">Communication Sciences and Disorders, Department of</option>
								<option value="http://communication.cos.ucf.edu/">Communication, Nicholson School Of</option>
								<option value="http://www.communityrelations.ucf.edu/">Community Relations, Division of</option>
								<option value="http://www.computerlabs.ucf.edu">Computer Labs</option>
								<option value="http://www.cst.ucf.edu">Computer Services &amp; Telecommunications</option>
								<option value="http://cstore.ucf.edu/index.htm">Computer Store &amp; PC Support Center</option>
								<option value="http://www.ucf.edu/contact/">Contact UCF</option>
								<option value="http://www.coop.ucf.edu/?go=aboutcoop">Cooperative Education</option>
								<option value="http://www.iroffice.ucf.edu/character/current_tuition.html">Cost Of Attendance</option>
								<option value="http://www.counseling.sdes.ucf.edu">Counseling Center</option>
								<option value="http://www.admissions.ucf.edu/apply/counselors/">Counselor Recommendation Form, Undergraduate</option>
								<option value="http://www.csc.sdes.ucf.edu/">Creative School For Children</option>
								<option value="http://www.ucffedcu.org/">Credit Union, U.C.F. Federal</option>
								<option value="http://www2.cohpa.ucf.edu/crim.jus/">Criminal Justice, Department of</option>
								<option value="http://library.ucf.edu/CMC/">Curriculum Materials Center</option>
								<option value="http://pegasus.cc.ucf.edu/~cypress/">Cypress Christian Life</option>
								<option value="http://pegasus.cc.ucf.edu/~cdome/">Cypress Dome</option>
								<option value="http://www.campusdish.com/en-US/CSS/UnivCentralFlorida">Dining Services</option>
								<option value="http://campusmap.ucf.edu/address.php">Directions to Campuses</option>
								<option value="http://www.drs.sdes.ucf.edu/">Dispute Resolution Services</option>
								<option value="http://distrib.ucf.edu/cdl/ ">Distributed Learning, Center For</option>
								<option value="http://diversity.ucf.edu">Diversity Initiatives, Office Of</option>
								<option value="http://www.ce.ucf.edu/">Division Of Continuing Education</option>
								<option value="http://www.communityrelations.ucf.edu/">Division of Community Relations</option>
								<option value="http://web.bus.ucf.edu/directory.aspx?d=sre">Dr. Phillips Institute For The Study Of American Business Activity, Business Administration, College Of</option>
								<option value="http://education.ucf.edu/ecde/">Early Childhood Education Program</option>
								<option value="http://web.bus.ucf.edu/economics/">Economics, Department Of, Business Administration, College Of</option>
								<option value="http://education.ucf.edu">Education, College Of</option>
								<option value="http://education.ucf.edu/ertl/">Educational Research, Technology And Leadership</option>
								<option value="http://www.eecs.ucf.edu/index.php?id=home">Electrical Engineering and Computer Science, School of</option>
								<option value="http://library.ucf.edu/Databases/">Electronic Resources Library</option>
								<option value="http://emergency.ucf.edu/">Emergency Management</option>
								<option value="https://www.jobswithucf.com/">Employment Opportunities</option>
								<option value="http://www.cecs.ucf.edu">Engineering &amp; Computer Science, College Of</option>
								<option value="http://www.ent.ucf.edu ">Engineering Technology</option>
								<option value="http://www.english.ucf.edu">English Department</option>
								<option value="http://www.ehs.ucf.edu">Environmental Health &amp; Safety</option>
								<option value="http://www.environment.ucf.edu/">Environmental Management, UCF</option>
								<option value="http://www.is.ucf.edu/undergraduate/environmental_studies.php">Environmental Studies</option>
								<option value="http://eeo.ucf.edu/">Equal Opportunity/Affirmative Action Programs</option>
								<option value="http://events.ucf.edu">Events</option>
								<option value="http://web.bus.ucf.edu/executive_education/">Executive Development Center, Business Administration, College Of</option>
								<option value="http://www.coop.ucf.edu">Experiential Learning</option>
								<option value="https://ecommunity.ucf.edu/ecommunity/">eCommunity</option>
								<option value="http://www.fo.ucf.edu/">Facilities Operations</option>
								<option value="http://www.fp.ucf.edu">Facilities Planning and Construction</option>
								<option value="http://www.fs.ucf.edu">Facilities and Safety</option>
								<option value="http://www.iroffice.ucf.edu/character/current.html">Facts About UCF</option>
								<option value="http://www.iroffice.ucf.edu/faculty/index.html">Faculty Activity Reporting</option>
								<option value="http://www.fctl.ucf.edu ">Faculty Center For Teaching And Learning</option>
								<option value="http://www.facultyrelations.ucf.edu">Faculty Relations</option>
								<option value="http://www.facultysenate.ucf.edu/index.asp">Faculty Senate, UCF</option>
								<option value="http://www.film.ucf.edu">Film Department</option>
								<option value="http://www.registrar.sdes.ucf.edu/calendar/exam/">Final Exam Schedule</option>
								<option value="http://www.fa.ucf.edu">Finance And Accounting</option>
								<option value="http://web.bus.ucf.edu/finance/">Finance, Department Of, Business Administration, College Of</option>
								<option value="http://finaid.ucf.edu/">Financial Aid</option>
								<option value="http://www.firstyear.sdes.ucf.edu/">First Year Advising &amp; Exploration</option>
								<option value="http://fye.sdes.ucf.edu/">First Year Experience</option>
								<option value="http://www.flbog.org/">Florida Board of Education</option>
								<option value="http://www.international.ucf.edu/fcli/index.php">Florida Canada Linkage Institute</option>
								<option value="http://www.flcenterfornursing.org/">Florida Center for Nursing</option>
								<option value="http://www.international.ucf.edu/eeli/index.php">Florida Eastern Europe Linkage Institute</option>
								<option value="http://www.floridassef.net/">Florida Foundation for Future Scientists</option>
								<option value="http://www.floridainclusionnetwork.com/page265.aspx">Florida Inclusion Network</option>
								<option value="http://www.iog.ucf.edu/">Florida Institute of Government at UCF</option>
								<option value="http://www.fiea.ucf.edu">Florida Interactive Entertainment Academy</option>
								<option value="http://www.fsec.ucf.edu/en/">Florida Solar Energy Center (F.S.E.C.)</option>
								<option value="http://fsi.ucf.edu/">Florida Space Institute</option>
								<option value="http://www.ncfs.org/">Forensic Science, National Center For</option>
								<option value="http://ucffoundation.org">Foundation, Inc., UCF</option>
								<option value="http://fsl.sdes.ucf.edu">Fraternity and Sorority Life</option>
								<option value="http://www.generalcounsel.ucf.edu/">General Counsel</option>
								<option value="http://www.ucfglobalperspectives.org">Global Perspectives, The Office of the Special Assistant to the President for </option>
								<option value="http://www.ucfathleticfund.com/">Golden Knights Club</option>
								<option value="http://goldenrule.sdes.ucf.edu/">Golden Rule (Student Conduct)</option>
								<option value="http://www.iog.ucf.edu">Government, The John Scott Dailey Florida Institute of</option>
								<option value="http://www.admissions.graduate.ucf.edu/">Graduate Admissions</option>
								<option value="http://web.bus.ucf.edu/students/graduate/">Graduate Business Programs</option>
								<option value="http://www.graduatecatalog.ucf.edu/">Graduate Catalog</option>
								<option value="http://www.graduatecouncil.ucf.edu">Graduate Council</option>
								<option value="http://www.graduatecatalog.ucf.edu/programs/">Graduate Degrees &amp; Programs</option>
								<option value="https://www.students.graduate.ucf.edu/gradonlineapp/">Graduate Online Application</option>
								<option value="http://www.graduate.ucf.edu/">Graduate Studies, College of</option>
								<option value="http://www.cohpa.ucf.edu/">Health &amp; Public Affairs, College Of</option>
								<option value="http://www.cohpa.ucf.edu/hmi/">Health Management and Informatics, Department in</option>
								<option value="http://www.cohpa.ucf.edu/health.pro/">Health Professions, Department of</option>
								<option value="http://www.hs.sdes.ucf.edu/">Health Services</option>
								<option value="http://heritagealliance.ucf.edu/homepage.php">Heritage Alliance</option>
								<option value="http://history.cah.ucf.edu/">History Department</option>
								<option value="http://www.hospitality.ucf.edu">Hospitality Management, Rosen College Of</option>
								<option value="http://www.housing.ucf.edu/">Housing &amp; Residence Life</option>
								<option value="http://www.hr.ucf.edu/web/index.shtml">Human Resources</option>
								<option value="http://chdr.cah.ucf.edu/">Humanities and Digital Research, Center For</option>
								<option value="http://www.ucf.edu/info/hurricane.php">Hurricane Resources and Information</option>
								<option value="http://www.iems.ucf.edu/">Industrial Engineering &amp; Management Systems</option>
								<option value="http://library.ucf.edu/InfoSource/default.php">InfoSource, Libraries</option>
								<option value="http://if.ucf.edu/">Information Fluency Initiative</option>
								<option value="https://www.students.graduate.ucf.edu/inquiry/">Information Request, Graduate Students</option>
								<option value="http://www.noc.ucf.edu">Information Security Office</option>
								<option value="http://itr.ucf.edu/">Information Technologies &amp; Resources</option>
								<option value="http://iaa.ucf.edu/">Information, Analysis, And Assessment, Division of</option>
								<option value="http://www.ist.ucf.edu">Institute For Simulation &amp; Training (I.S.T.)</option>
								<option value="http://www.iec.ucf.edu/">Institute for Economic Competitiveness</option>
								<option value="http://www.research.ucf.edu/Centers/">Institutes and Centers (Office of Research)</option>
								<option value="http://www.iroffice.ucf.edu">Institutional Research, Office Of</option>
								<option value="http://www.oir.ucf.edu/">Instructional Resources, Office of</option>
								<option value="http://pegasus.cc.ucf.edu/~instsys/">Instructional Systems Program</option>
								<option value="http://www.cmms.ucf.edu/iep.php">Intensive English  Program</option>
								<option value="http://www.ipl.ist.ucf.edu/">Interactive Performance Lab</option>
								<option value="http://www.is.ucf.edu/">Interdisciplinary Studies</option>
								<option value="http://www.is.ucf.edu/graduate/index.php">Interdisciplinary Studies Graduate Program</option>
								<option value="http://www.universityaudit.ucf.edu">Internal Audit</option>
								<option value="http://www.intl.ucf.edu">International Services Center</option>
								<option value="http://www.international.ucf.edu">International Studies, Office Of</option>
								<option value="http://www.rec.ucf.edu/IM/">Intramural Sports</option>
								<option value="https://www.jobswithucf.com/">Job Vacancies</option>
								<option value="http://judaicstudies.cah.ucf.edu/">Judaic Studies, Interdisciplinary Program In</option>
								<option value="https://www.secure.net.ucf.edu/knightsmail/">Knight&#039;s E-Mail</option>
								<option value="http://www.Knightcast.org">Knightcast</option>
								<option value="http://www.lead.sdes.ucf.edu/">L.E.A.D. Scholars Program</option>
								<option value="http://lgbtq.sdes.ucf.edu">LGBTQ Services</option>
								<option value="http://link.sdes.ucf.edu/">LINK First-Year Experience Program</option>
								<option value="http://www.green.ucf.edu">Landscape and Natural Resources</option>
								<option value="http://getinvolveducf.com/lateknights">Late Knights</option>
								<option value="http://lacls.cah.ucf.edu/">Latin American, Caribbean, &amp; Latino Studies</option>
								<option value="http://www.life.ucf.edu/">Learning Institute For Elders (LIFE) At UCF</option>
								<option value="http://learn.ucf.edu">Learning Online, UCF</option>
								<option value="http://www.stulegal.sdes.ucf.edu/">Legal Services, Student</option>
								<option value="http://www2.cohpa.ucf.edu/legalstudies/">Legal Studies, Department of</option>
								<option value="http://library.ucf.edu">Libraries, University</option>
								<option value="http://education.ucf.edu/lmacad/">Lockheed Martin/U.C.F Academy For Mathematics And Sciences</option>
								<option value="http://www.loufreyinstitute.org">Lou Frey Institute Of Politics And Government</option>
								<option value="http://www.pp.ucf.edu/operationalservices/maintenance/">Maintenance</option>
								<option value="http://web.bus.ucf.edu/management/">Management, Department Of, Business Administration, College Of</option>
								<option value="http://www.ucfmarchingknights.com/">Marching Band Department</option>
								<option value="http://web.bus.ucf.edu/marketing/">Marketing, Department Of, Business Administration, College Of</option>
								<option value="http://mfri.ucf.edu/index.cfm">Marriage &amp; Family Research Institute</option>
								<option value="http://education.ucf.edu/prog_page.cfm?ProgDeptID=32&ProgID=17">Masters Programs In Elementary Education</option>
								<option value="http://math.ucf.edu/~mathlab/ ">Math Lab</option>
								<option value="http://education.ucf.edu/mathed/">Mathematics Education</option>
								<option value="http://www.math.ucf.edu/">Mathematics, Department Of</option>
								<option value="http://www.campusdish.com/en-US/CSS/UnivCentralFlorida">Meal Plans</option>
								<option value="http://www.mmae.ucf.edu ">Mechanical, Materials &amp; Aerospace Engineering</option>
								<option value="http://www.biomed.ucf.edu/index.php?tg=articles&idx=More&topics=23&article=60">Medical Laboratory Sciences</option>
								<option value="http://www.med.ucf.edu">Medicine, College of</option>
								<option value="http://metrocenter.ucf.edu/">Metropolitan Center for Regional Studies</option>
								<option value="http://pegasus.cc.ucf.edu/~mpie/">Minority Programs In Education</option>
								<option value="http://www.ucf.edu/strategic_planning/elements.shtml">Mission &amp; Goals</option>
								<option value="http://mll.cah.ucf.edu/">Modern Languages and Literatures</option>
								<option value="http://www.biomed.ucf.edu/index.php?tg=articles&idx=More&topics=21&article=26">Molecular Biology &amp; Microbiology</option>
								<option value="http://mass.sdes.ucf.edu/">Multicultural  Academic &amp; Support Services (M.A.S.S.)</option>
								<option value="http://www.cmms.ucf.edu">Multilingual Multicultural Studies, Center for</option>
								<option value="http://music.cah.ucf.edu/">Music, Department of</option>
								<option value="http://www.ucf.edu/myorganization">My Organization</option>
								<option value="https://my.ucf.edu/index.html">myUCF</option>
								<option value="http://www.nanoscience.ucf.edu/">Nanotechnology Research</option>
								<option value="http://www.ncasports.org/">National Consortium For Academics And Sports (N. C. A. S.)</option>
								<option value="http://today.ucf.edu">News And Information, UCF Department Of</option>
								<option value="http://www.nursing.ucf.edu">Nursing, College Of</option>
								<option value="http://catalog.online.ucf.edu/">Off Campus College Credit Programs</option>
								<option value="http://offcampus.housing.ucf.edu/">Off-Campus Student Services</option>
								<option value="https://officeplus.ucf.edu">Office Plus, U.C.F.</option>
								<option value="http://www.oir.ucf.edu/">Office of Instructional Resources</option>
								<option value="http://www.ombuds.ucf.edu/">Ombuds Office</option>
								<option value="http://www.oeas.ucf.edu">Operational Excellence and Assessment Support</option>
								<option value="http://www.creol.ucf.edu/">Optics &amp; Photonics: CREOL &amp; FPCE, College of</option>
								<option value="http://fye.sdes.ucf.edu/index.php?p=fresh_o">Orientation</option>
								<option value="http://www.orlandorep.com">Orlando Repertory Theatre</option>
								<option value="http://orlandoshakes.org">Orlando Shakespeare Theater in Partnership with UCF</option>
								<option value="http://online.ucf.edu">online@ucf</option>
								<option value="http://parents.sdes.ucf.edu">Parent Resource Information</option>
								<option value="http://parking.ucf.edu/">Parking Services</option>
								<option value="http://www.catalog.sdes.ucf.edu/colleges/cah/community_arts_pave_program/Default.aspx">Partners In Art Education P.A.V.E.</option>
								<option value="http://pegasus.ucf.edu">Pegasus - The Magazine of the University of Central Florida</option>
								<option value="http://philosophy.cah.ucf.edu/">Philosophy, Department Of</option>
								<option value="http://www.ucf.edu/phonebook/">Phone &amp; Email Directory, Campus</option>
								<option value="http://photofile.ucf.edu">Photofile</option>
								<option value="http://physics.cos.ucf.edu">Physics</option>
								<option value="http://police.ucf.edu/">Police Department</option>
								<option value="http://policies.ucf.edu">Policies and Procedures Manual</option>
								<option value="http://politicalscience.cos.ucf.edu">Political Science</option>
								<option value="http://www.postalservices.ucf.edu/">Postal Services</option>
								<option value="http://www.phpao.med.ucf.edu/">Pre Health Professions Advisement Office</option>
								<option value="http://president.ucf.edu">President, Office Of</option>
								<option value="http://www.ucfplc.com/ucfplc/index.cfm">Presidents Leadership Council</option>
								<option value="https://printing.ucf.edu/">Printing Services</option>
								<option value="http://www.ucf.edu/academics/">Programs</option>
								<option value="http://www.provost.ucf.edu/">Provost and Executive Vice President, Office of</option>
								<option value="http://psychology.cos.ucf.edu">Psychology Department</option>
								<option value="http://www.cohpa.ucf.edu/pubadm/">Public Administration, Department of</option>
								<option value="http://www.purchasing.ucf.edu/">Purchasing, Division Of</option>
								<option value="http://sacs.ucf.edu/ccr/report/qep_summary.htm">Quality Enhancement Plan</option>
								<option value="http://www.rec.ucf.edu">Recreation and Wellness Center</option>
								<option value="http://www.regionalcampuses.ucf.edu/">Regional Campuses</option>
								<option value="http://registrar.sdes.ucf.edu">Registrar, University</option>
								<option value="http://regulations.ucf.edu">Regulations, UCF</option>
								<option value="http://www.research.ucf.edu">Research &amp; Commercialization, Office Of</option>
								<option value="http://dl.ucf.edu/research/rite/">Research Initiative For Teaching Effectiveness</option>
								<option value="http://ampac.ucf.edu/research/">Research, AMPAC</option>
								<option value="http://hr.ucf.edu/web/benefits/Retirement_Assoc.shtml">Retirement Association, UCF</option>
								<option value="http://planets.ucf.edu/observatory">Robinson Observatory</option>
								<option value="http://mcnair.ucf.edu/">Ronald E. McNair Post Baccalaureate Achievement Program</option>
								<option value="http://www.hospitality.ucf.edu/">Rosen College of Hospitality Management</option>
								<option value="http://www.cos.ucf.edu/">Sciences, College of</option>
								<option value="http://graduate.cos.ucf.edu/">Sciences, Graduate Student Web Site, College of</option>
								<option value="http://www.iroffice.ucf.edu/forms/requestedforms.html">Security Authorization Form, UCF</option>
								<option value="http://www.explearning.ucf.edu/?go=aboutservice">Serving -Learning</option>
								<option value="http://parking.ucf.edu/shuttles">Shuttle Bus, UCF</option>
								<option value="http://www.bus.ucf.edu/sbdc/">Small Business Development Center</option>
								<option value="http://www.cohpa.ucf.edu/social/ ">Social Work, School Of</option>
								<option value="http://sociology.cos.ucf.edu/">Sociology</option>
								<option value="http://www.sophomore.sdes.ucf.edu">Sophomore and Second Year Center</option>
								<option value="http://web.bus.ucf.edu/sportbusiness/">Sport Business Management , Business Administration, College Of</option>
								<option value="http://rwc.sdes.ucf.edu/programs/sport-clubs">Sports Clubs</option>
								<option value="http://ucfathletics.cstv.com/brighthouse/bio.html">Stadium, UCF</option>
								<option value="http://statistics.cos.ucf.edu/content/index.html">Statistics, Department of</option>
								<option value="http://www.spc.ucf.edu">Strategic Planning</option>
								<option value="http://www.smca.ucf.edu/">Strategy, Marketing, Communications and   Admissions (SMCA)</option>
								<option value="http://www.sarc.sdes.ucf.edu/">Student Academic Resource Center (SARC)</option>
								<option value="http://www.osc.sdes.ucf.edu/">Student Conduct</option>
								<option value="http://www.sdes.ucf.edu">Student Development &amp; Enrollment Services</option>
								<option value="http://www.sds.sdes.ucf.edu">Student Disability Services</option>
								<option value="http://finaid.ucf.edu/">Student Financial Assistance</option>
								<option value="http://www.ucfsga.com/">Student Government Association</option>
								<option value="http://www.getinvolveducf.com">Student Involvement, Office Of</option>
								<option value="http://sld.sdes.ucf.edu/">Student Leadership Development</option>
								<option value="http://www.outreach.ucf.edu/sop.htm">Student Outreach Programs</option>
								<option value="http://www.osrr.sdes.ucf.edu/">Student Rights And Responsibilities, Office Of</option>
								<option value="http://education.ucf.edu/studentservices/">Student Services, Office Of, College Of Education</option>
								<option value="http://www.ucfsu.com/">Student Union</option>
								<option value="http://www.sustainable.ucf.edu/">Sustainabilty and Energy Management</option>
								<option value="http://www.tats.ucf.edu">Technical Assistance and Training System</option>
								<option value="http://education.ucf.edu/teched/index.cfm">Technical Education &amp; Industry Training</option>
								<option value="http://www.education.ucf.edu/techfac/">Technology and Facilities-College of Education</option>
								<option value="http://www.telecom.ucf.edu">Telecommunications, UCF</option>
								<option value="http://www.ce.ucf.edu/Program-Search/1303/Ucf-Test-Prep/">Test Prep, UCF</option>
								<option value="http://www.bus.ucf.edu/testinglab/">Testing Lab, College of Business</option>
								<option value="http://theatre.ucf.edu/">Theatre U.C.F. / Department of Theatre</option>
								<option value="http://townandgown.ucf.edu/">Town &amp; Gown Council, UCF</option>
								<option value="http://www.hr.ucf.edu/web/training/calendar.shtml">Training &amp; Professional Development, Human Resources</option>
								<option value="http://training.ucf.edu">Training, Faculty and Staff</option>
								<option value="http://www.registrar.ucf.edu/forms/transcript_request/">Transcripts, Requesting</option>
								<option value="http://www.transfer.sdes.ucf.edu/">Transfer and Transition Services</option>
								<option value="http://www.fa.ucf.edu/">Travel</option>
								<option value="http://www.iroffice.ucf.edu/character/current_tuition.html">Tuition and Fees, UCF</option>
								<option value="http://ucffoundation.org/">UCF Foundation, Inc.</option>
								<option value="http://ucffoundation.org/about/mission-a-history">UCF History</option>
								<option value="http://library.ucf.edu/InfoSource/">UCF Information Source</option>
								<option value="http://www.ucftv.ucf.edu/">UCF TV</option>
								<option value="http://today.ucf.edu">UCF Today</option>
								<option value="http://www.venturelab.ucf.edu/">UCF Venture Lab</option>
								<option value="http://education.ucf.edu/holmes/">UCF/OSC Holmes Partnership</option>
								<option value="http://hr.ucf.edu/web/handbook/Handbook.shtml">USPS Handbook</option>
								<option value="http://www.catalog.sdes.ucf.edu/">Undergraduate Catalog</option>
								<option value="http://admissions.ucf.edu/apply/international/">Undergraduate International Admissions</option>
								<option value="http://catalog.sdes.ucf.edu/academic_programs/ucf_degree_programs/">Undergraduate Majors</option>
								<option value="http://www.catalog.sdes.ucf.edu/academic_programs/minors/Default.aspx">Undergraduate Minors &amp; Certificates</option>
								<option value="https://admissions.ucf.edu/application/">Undergraduate Online Application</option>
								<option value="http://research.honors.ucf.edu/">Undergraduate Research , Burnett Honors College</option>
								<option value="http://www.our.ucf.edu">Undergraduate Research, Office of</option>
								<option value="http://web.bus.ucf.edu/students/">Undergraduate Student Services (Business)</option>
								<option value="http://www.cohpa.ucf.edu/undergraduateadvising.shtml">Undergraduate Student Services (COHPA)</option>
								<option value="http://www.undergraduatestudies.ucf.edu/">Undergraduate Studies, Office of</option>
								<option value="http://admissions.ucf.edu/apply/transfer/">Undergraduate Transfer Admissions</option>
								<option value="http://www.uffucf.org">United Faculty Of Florida</option>
								<option value="http://uaps.ucf.edu ">University Analysis And Planning Support, Office Of</option>
								<option value="http://library.ucf.edu/SpecialCollections/Archives/">University Archives</option>
								<option value="http://www.universityaudit.ucf.edu">University Audit</option>
								<option value="http://www.fa.ucf.edu/">University Budget Operations</option>
								<option value="http://www.ucf.edu/economic_impact/">University Economic  Development</option>
								<option value="http://universitymarketing.ucf.edu/">University Marketing</option>
								<option value="http://www.testing.sdes.ucf.edu">University Testing Center</option>
								<option value="http://www.uwc.ucf.edu">University Writing Center (UWC)</option>
								<option value="http://helpdesk.ucf.edu ">User Services Help Desk</option>
								<option value="http://www.va.sdes.ucf.edu/">Veteran Services</option>
								<option value="http://president.ucf.edu/chiefofstaff/chiefofstaff.asp">Vice President and Chief of Staff</option>
								<option value="http://www.research.ucf.edu/">Vice President for Research</option>
								<option value="http://ucffoundation.org/foundation-staff">Vice President of Development and Alumni Relations and CEO UCF Foundation</option>
								<option value="http://admissions.ucf.edu/visit/">Visiting UCF</option>
								<option value="http://svad.cah.ucf.edu">Visual Arts and Design, School of</option>
								<option value="http://wucf.org/home/">W.U.C.F. - F.M. Radio</option>
								<option value="http://wnsc.ucf.edu/">WNSC Campus Radio</option>
								<option value="http://webcam.ucf.edu/">Web Cams, Campus</option>
								<option value="http://www.registrar.sdes.ucf.edu/weg/">Web Enrollment Guide</option>
								<option value="http://union.catalog.fcla.edu/ux.jsp">Web Luis - Library</option>
								<option value="https://ucfcard.ucf.edu/how-it-works.html">WebRevalue, ID Card</option>
								<option value="https://my.ucf.edu/index.html">Webcourses@UCF</option>
								<option value="http://pegasus.cc.ucf.edu/~wrcenter/">Wellness Research Center</option>
								<option value="http://womensstudies.cah.ucf.edu/">Women&#039;s Studies</option>
								<option value="http://womens.research.ucf.edu/">Womens Research Center</option>
								<option value="http://brand.ucf.edu/writing-style-guide/">Writing Style Guide</option>
								<option value="http://writingandrhetoric.cah.ucf.edu">Writing and Rhetoric</option>
		
							<!-- <OK /> --> 
							</select>
						</div>
						<div id="quicklinks-actions" class="span2">
							<a class="btn btn-block" href="#" id="addLinks"><i class="icon-forward"></i><span class="visible-phone"> Add Link</span></a>
							<a class="btn btn-block" href="#" id="removeLinks"><i class="icon-backward"></i>&nbsp;<span class="visible-phone"> Remove Link</span></a>
							<a class="btn btn-block btn-warning" href="#" id="clearLinks">Clear</a>
							<br/>
						</div>
						<div class="quicklinks-column span4">
							<h3>Your Links</h3>
							<select multiple class="quicklinks-list" id="destinationLinks">
							</select>
						</div>
					</div>
				</form>	
			</article>
		</div>
	</div>
	<?php get_footer(); ?>
</html>	