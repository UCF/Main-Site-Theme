<?php
get_header(); the_post();

$header_img = wp_get_attachment_url( get_post_meta( $post->ID, 'page_media_img', true ) );
$header_content = wptexturize( do_shortcode( get_post_meta( $post->ID, 'page_media_header_content', true ) ) );

$degrees = get_degrees_by_college();
?>

</div> <!-- close .container -->

	<script>
		var searchSuggestions = <?php echo json_encode( get_academics_search_suggestions() ); ?>;
	</script>
<div class="container-fullwidth page-media academics" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header" style="background-image: url('<?php echo $header_img; ?>');">
	</div>
	<div class="page-media-container">

		<div class="container">
<div class="pull-left"><span class="header-title pull-left">This is a Header Title</span><h1 class="header-subtitle pull-right">Header Subtitle</h1></div>
</div>

<!-- 		<div class="container-fluid top-search">
			<div class="title-header-container">
				<h1 class="site-title">
					<a href="http://www.ucf.edu/students">Academic Degrees <br />&amp; Colleges</a>
				</h1>
				<div class="weather">
					<span class="icon" title="Fair">
						<span class="wi wi-day-sunny"></span>
					</span>
					<span class="location">Orlando, FL</span>
					<span class="vertical-rule"></span>
					<span class="temp">83°F</span>
				</div>
			</div>
		</div> -->


		<div class="container-fluid top-search">
			<div class="col-md-12 academics-intro fade-in text-center">
				<p>Whatever your passion, we’ve got the program to get you going in the right direction.</p>
			</div>
			<div class="col-md-12 academics-box academics-search-box fade-in">
				<span class="title">Find the program that's right for you:</span>
				<span class="fa fa-search search-icon"></span>
				<input id="acedemics-degree-search" name="acedemics-degree-search" class="academics-search-icon" type="text" autocomplete="off"
					data-provide="typeahead" placeholder="Search for degree programs by name or area of interest" />
			</div>
		</div>

	</div>
</div>
<div class="academics-content page-content" id="contentcol">
	<article role="main">
		<div class="container main-content-container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h2 class="heading-underline">Colleges at UCF</h2>
						<?php the_content(); ?>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="arts">Arts &amp; Humanities</h3>
					<ul class="college-info">
						<li>Visit <a href="http://art.ucf.edu">art.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-arts-and-humanities';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/03/ucf_seal_strip.jpg" class="img-responsive" alt="" />
					<p>From literature to philosophy to digital media, our faculty members hone their creative skills and enjoy an environment for artistic expression of every kind. We empower faculty to explore their creative interests in everything from music, performing arts, history, women’s studies and more. With 17 departments, as well as new facilities such as our Performing Arts Center, the college embodies forward-thinking teaching and research in arts and humanities.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="burnett">Burnett Honors College</h3>
					<ul class="college-info">
						<li>Visit <a href="http://honors.ucf.edu">honors.ucf.edu</a></li>
					</ul>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/03/burnett_logo_strip.jpg" class="img-responsive" alt="" />
					<p>Students enjoy the intimacy of a small liberal arts college along with the benefits of a large metropolitan research university. Here, faculty teach in interdisciplinary groups and smaller classes, allowing for more discussion and greater interaction. The college is open to students of all disciplines, and admission is competitive. Our Fall 2015 freshman class boasted an average SAT two-score of 1400 and an average high school grade point average of 4.4.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="business">Business Administration</h3>
					<ul class="college-info">
						<li>Visit <a href="http://business.ucf.edu/">business.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-business-administration';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/business_admin_building.png" class="img-responsive" alt="" />
					<p>With more than 8,000 students, the college offers undergraduate and graduate students innovative thinking in a high-tech atmosphere. We are the only accredited undergraduate and graduate college of business in Orlando.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="education">Education &amp; Human Performance</h3>
					<ul class="college-info">
						<li>Visit <a href="http://education.ucf.edu">education.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-education-and-human-performance';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/college-of-education.jpg" class="img-responsive" alt="" />
					<p>We produce more teachers than any other institution in the state. Our college brings together students, faculty, schools and community leaders to provide state-approved and nationally accredited certifications and degrees.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="engineering">Engineering and Computer Science</h3>
					<ul class="college-info">
						<li>Visit <a href="http://cecs.ucf.edu">cecs.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-engineering-and-computer-science';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/harris_engineering_building.jpg" class="img-responsive" alt="" />
					<p>Central Florida is home to some of the biggest names in technology, including NASA, Lockheed Martin, Boeing, Siemens and Walt Disney World. Our college strives to create new solutions to real-world problems.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="graduate">Graduate Studies</h3>
					<ul class="college-info">
						<li>Visit <a href="http://www.graduate.ucf.edu/">graduate.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-graduate-studies';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/millican_hall.jpg" class="img-responsive" alt="" />
					<p>The college offers programs and delivery methods that bring master’s and professional education programs to those who need advanced knowledge and skills to further their careers and enrich their lives.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="health">Health and Public Affairs</h3>
					<ul class="college-info">
						<li>Visit <a href="http://www.cohpa.ucf.edu">cohpa.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-health-and-public-affairs';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/health_and_public_affairs.jpg" class="img-responsive" alt="" />
					<p>Graduates of the college go wherever help is needed. Approaching health and public affairs with a service mentality, the college produces workers who are committed to serving their communities.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="medicine">Medicine</h3>
					<ul class="college-info">
						<li>Visit <a href="http://med.ucf.edu">med.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-medicine';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/college_of_medicine-1.jpg" class="img-responsive" alt="" />
					<p>The <a href="http://med.ucf.edu">College of Medicine</a> and the <a href="http://med.ucf.edu/biomed/" target="_blank" class="external">Burnett School of Biomedical Sciences</a> is located at the UCF Health Sciences Campus at Lake Nona. The medical school is an integral part of a new medical city where future doctors will train in close proximity to world-class partners.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="nursing">Nursing</h3>
					<ul class="college-info">
						<li>Visit <a href="http://nursing.ucf.edu/">nursing.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-nursing';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/nursing.jpg" class="img-responsive" alt="" />
					<p>State-of-the-art classrooms, teaching laboratories and top-notch faculty are just a few reasons the college consistently ranks among the top recipients of National Institutes of Health funding in Florida.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="optics">Optics and Photonics</h3>
					<ul class="college-info">
						<li>Visit <a href="http://www.creol.ucf.edu/">creol.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-optics-and-photonics';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/creol.jpg" class="img-responsive" alt="" />
					<p>Internationally recognized, the college is comprised of three major research centers: the Center for Research and Education in Optics and Lasers (CREOL), the Florida Photonics Center of Excellence and the newly-founded Townes Laser Institute.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="rosen">Rosen College of Hospitality Management</h3>
					<ul class="college-info">
						<li>Visit <a href="http://hospitality.ucf.edu/">hospitality.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'rosen-college-of-hospitality-management';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/rosen.jpg" class="img-responsive" alt="" />
					<p>There is no better place to learn hospitality than the #1 tourist destination in the world. Additionally, the college is located in the most modern and technologically advanced facility ever built for hospitality management education.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="science">Sciences</h3>
					<ul class="college-info">
						<li>Visit <a href="http://sciences.ucf.edu/">sciences.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'college-of-sciences';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/11/college-of-sciences.jpg" class="img-responsive" alt="" />
					<p>The largest at UCF, the college offers 15 undergraduate degree programs, spanning the natural, computational, social and behavioral sciences. Check out our programs and see how you can learn in and out of the classroom.</p>
				</div>
			</div>
			<div class="row college">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 id="undergrad">Undergraduate Studies</h3>
					<ul class="college-info">
						<li>Visit <a href="http://undergrad.ucf.edu/">undergrad.ucf.edu</a></li>
					</ul>
					<?php
						$college_name = 'office-of-undergraduate-studies';
						$college_degrees = $degrees[$college_name];
						$undergrad_count = count($college_degrees['undergraduate']);
						$grad_count = count($college_degrees['graduate']);
					?>
					<?php if ($college_degrees && ($undergrad_count > 0  || $grad_count > 0)): ?>
						<h4 class="buttons-heading">Degree Programs</h4>
						<ul class="program-info-list">
						<?php if ($undergrad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=undergraduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $undergrad_count; ?></span> Bachelor's Degrees</a></li>
						<?php endif; ?>
						<?php if ($grad_count > 0): ?>
							<li><a class="btn count-button external" target="_blank" href="/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=<?php echo $college_name; ?>" role="button"><span class="count"><?php echo $grad_count; ?></span> Graduate Programs</a></li>
						<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 description">
					<img src="http://wwwdev.smca.ucf.edu/wp-content/uploads/2016/03/burnett_logo_strip.jpg" class="img-responsive" alt="" />
					<p>UCF’s newest college, Undergraduate Studies, offers the ability to tailor your program of study to suit your academic and career goals. This academic flexibility allows students to choose a path in environmental studies, women’s studies or interdisciplinary studies — where you design your degree with 13 areas of study ranging from art to communications to education and physical sciences.</p>
				</div>
			</div>
		</div>
	</article>
</div>
</div>
<div class="container">
	<?php get_footer();?>
