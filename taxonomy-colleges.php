<?php
	get_header();
	$term = get_queried_object();
	$custom_content = get_field( 'custom_content', 'colleges_' . $term->term_id );
?>
<article role="main">
	<section>
		<div class="container my-5">
			<div class="row">
				<div class="col-sm-12 col-md-8 lead">
					<?php echo get_field( 'lead_copy', 'colleges_' . $term->term_id ); ?>
				</div>
				<div class="col-sm-12 col-md-4">
					<img src="<?php echo get_field( 'lead_image', 'colleges_' . $term->term_id )['url']; ?>" alt="" class="img-fluid">
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-center mt-3">
					<?php $http = array("http://", "https://"); ?>
					<a class="btn btn-primary" href="<?php echo get_field( 'colleges_url', 'colleges_' . $term->term_id ); ?>" target="_blank">Visit <?php echo str_replace( $http, '', get_field( 'colleges_url', 'colleges_' . $term->term_id ) ) ; ?></a>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="jumbotron jumbotron-fluid bg-primary mb-0">
			<div class="container my-5">
				<div class="row">
					<div class="col-sm-12">
						Stats Section
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-degrees">
		<div class="jumbotron jumbotron-fluid bg-inverse mb-0">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<h2 class="h1 text-primary section-heading"><?php echo get_field( 'degree_search_title', 'colleges_' . $term->term_id ); ?></h2>
						<p class="mt-3"><?php echo get_field( 'degree_search_copy', 'colleges_' . $term->term_id ); ?></p>
						{ Insert Degree Search Shortcode }
						<h3 class="browse-by-heading h5 heading-sans-serif">Or browse by:</h3>
						<ul class="browse-by-list list-chevrons">
							<li><a href="https://www.ucf.edu/degree-search/?program-type[0]=undergraduate-degree&amp;college[0]=college-of-business-administration&amp;sort-by=title&amp;default=0&amp;offset=0&amp;search-default=0">Bachelor’s Degrees</a></li>
							<li><a href="https://www.ucf.edu/degree-search/?program-type%5B0%5D=graduate-degree&amp;college%5B0%5D=college-of-business-administration&amp;sort-by=title&amp;default=0&amp;offset=0&amp;search-default=0">Graduate Degrees</a></li>
							<li><a href="https://www.ucf.edu/degree-search/?program-type%5B0%5D=minor&amp;college%5B0%5D=college-of-business-administration&amp;sort-by=title&amp;default=0&amp;offset=0&amp;search-default=0">Minors</a></li>
							<li><a href="https://www.ucf.edu/degree-search/?program-type%5B0%5D=certificate&amp;college%5B0%5D=college-of-business-administration&amp;sort-by=title&amp;default=0&amp;offset=0&amp;search-default=0">Certificates</a></li>
						</ul>
					</div>
					<div class="col-md-4">
						<h3 class="h4 top-majors-heading btn text-upper btn-inverse btn-sm text-left">Top College<br>Degrees</h3>
						<ul class="top-majors-list list-unstyled">
						<li><a href="https://www.ucf.edu/academics/art-emerging-media-track/" class="text-inverse">Art - Emerging Media</a></li>
						<li><a href="https://www.ucf.edu/academics/philosophy/" class="text-inverse">Philosophy</a></li>
						<li><a href="https://www.ucf.edu/academics/music/" class="text-inverse">Music</a></li>
						<li><a href="https://www.ucf.edu/academics/photography/" class="text-inverse">Photography</a></li>
						<li><a href="https://www.ucf.edu/academics/humanities-and-cultural-studies/" class="text-inverse">Humanities and Cultural Studies</a></li>
						<li><a href="https://www.ucf.edu/academics/creative-writing-mfa/" class="text-inverse">Creative Writing MFA</a></li>
						<li><a href="https://www.ucf.edu/academics/history-ma-2/" class="text-inverse">Master's Degree in History</a></li>
						<li><a href="https://www.ucf.edu/academics/theatre-mfa-2/" class="text-inverse">Theater MFA</a></li>
						<li><a href="https://www.ucf.edu/academics/interactive-entertainment-ms-2/" class="text-inverse">Interactive Entertainment MS</a></li>
						<li><a href="https://www.ucf.edu/academics/texts-and-technology-phd-2/" class="text-inverse">Texts and Technology PhD</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<aside class="aside-ctas">
		<div class="jumbotron jumbotron-fluid bg-primary py-0 my-0">
			<div class="container icon-links">
				<div class="row">
					<div class="col-12 col-sm-4 icon-link icon-link-dark text-center">
						<a href="//www.ucf.edu/admissions/" class="icon-link-anchor">
							<div class="icon-wrapper">
								<span class="fa fa-sign-in"></span>
							</div>
							<h3 class="btn btn-secondary btn-sm w-100 py-2 icon-link-title">Admissions Info</h3>
							<p class="font-italic"><small class="font-weight-bold">Explore admissions requirements, deadlines, tuition and financial aid, and more.</small></p>
						</a>
					</div>
					<div class="col-12 col-sm-4 icon-link icon-link-dark text-center">
						<a href="//admissions.ucf.edu/visit/" class="icon-link-anchor">
							<div class="icon-wrapper">
								<span class="fa fa-map-marker"></span>
							</div>
							<h3 class="btn btn-secondary btn-sm w-100 py-2 icon-link-title">Visit UCF</h3>
							<p class="font-italic"><small class="font-weight-bold">Take a tour of the campus and see what makes UCF so amazing.</small></p>
						</a>
					</div>
					<div class="col-12 col-sm-4 icon-link icon-link-dark text-center">
						<a href="//www.ucf.edu/apply-to-ucf/" class="icon-link-anchor">
							<div class="icon-wrapper">
								<span class="fa fa-pencil-square-o"></span>
							</div>
							<h3 class="btn btn-secondary btn-sm w-100 py-2 icon-link-title">Apply Now</h3>
							<p class="font-italic"><small class="font-weight-bold">Seeking a bachelor's degree? Interested in graduate school? Get started today.</small></p>
						</a>
					</div>
				</div>
			</div>
		</div>
	</aside>
	<section class="section-news">
		<div class="container my-5">
			<div class="row">
				<div class="col-12">
					<a href="https://today.ucf.edu/topic/<?php echo get_field( 'news_topic', 'colleges_' . $term->term_id ); ?>" class="float-md-right text-uppercase">Check out more stories <span class="fa fa-external-link" aria-hidden="true"></span></a>
					<h2><?php echo str_replace( 'College of ', '', $term->name ); ?> News</h2>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-sm-12">
					<?php echo do_shortcode( '[ucf-news-feed title="" layout="modern" topics="' . get_field( 'news_topic', 'colleges_' . $term->term_id ) . '"]' ); ?>
				</div>
				<div class="col-md-4 col-sm-12">
					<?php  echo do_shortcode( '[ucf-spotlight slug="' . get_field( 'college_spotlight', 'colleges_' . $term->term_id )->post_name . '"]' ); ?>
				</div>
			</div>
		</div>
	</section>
	<?php if( $custom_content ) : ?>
	<section>
		<?php echo $custom_content; ?>
	</section>
	<?php endif; ?>
	<section class="section-colleges">
		<div class="jumbotron jumbotron-fluid bg-primary py-4 my-0 text-center">
			<div class="container">
			<h2 class="section-heading h3 m-0 text-uppercase font-weight-bold font-condensed">University of Central Florida Colleges</h2>
			</div>
		</div>
		<div class="college-blocks">
		<?php
			$colleges = get_terms( array(
				'taxonomy' => 'colleges',
				'hide_empty' => false
			) );
		?>
		<?php foreach($colleges as $college) :
			if($college->slug !== $term->slug) :
		?>
			<div class="college-block">
				<div class="college-block-img" style="background-image: url('<?php echo get_field( 'thumbnail_image', 'colleges_' . $college->term_id); ?>')"></div>
				<a class="college-block-link" href="../<?php echo $college->slug; ?>"><span class="college-block-text"><?php echo $college->name; ?></span></a>
			</div>
		<?php
			endif;
		endforeach;
		?>
		</div>
	</section>
</article>
<?php get_footer();?>
