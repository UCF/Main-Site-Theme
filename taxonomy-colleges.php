<?php
	get_header();
	$term = get_queried_object();
?>
<article role="main">
	<section class="section-lead">
		<div class="container my-5">
			<div class="row">
				<div class="col-sm-12 col-md-8 lead">
					<?php echo get_field( 'college_page_lead_copy', 'colleges_' . $term->term_id ); ?>
				</div>
				<div class="col-sm-12 col-md-4">
					<img src="<?php echo get_field( 'college_page_lead_image', 'colleges_' . $term->term_id )['url']; ?>" alt="" class="img-fluid">
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-center mt-3">
					<?php $http = array( "http://", "https://" ); ?>
					<a class="btn btn-primary" href="<?php echo get_field( 'colleges_url', 'colleges_' . $term->term_id ); ?>" target="_blank">Visit <?php echo str_replace( $http, '', get_field( 'colleges_url', 'colleges_' . $term->term_id ) ) ; ?></a>
				</div>
			</div>
		</div>
	</section>
	<section class="section-stats">
		<div class="media-background-container">
			<img class="media-background object-fit-cover" srcset="<?php echo get_field( 'stats_background_image', 'colleges_' . $term->term_id )['url']; ?>" src="<?php echo get_field( 'stats_background_image', 'colleges_' . $term->term_id )['url']; ?>" alt="">
			<div class="container my-5">
				<div class="row">
				<?php
					$stats = get_field( 'stat', 'colleges_' . $term->term_id );
					ob_start();
					if( $stats ) :
						foreach( $stats as $index=>$stat ) :
							?>
							<div class="col-md-4 d-flex align-items-stretch">
								<aside class="fact-block text-center align-self-top p-3">
									<div class="fact-icon"><img src="<?php echo $stat["icon"]["url"]; ?>" alt="" class="img-fluid w-50"></div>
									<div class="fact-details"><?php echo $stat["copy"]; ?></div>
								</aside>
							</div>
						<?php if( $index !== 0 && ( ( $index+1 ) % 3 ) === 0 ) : ?>
							</div>
							<div class="row">
						<?php endif; ?>
							<?php
						endforeach;
					endif;
					echo ob_get_clean();
				?>
				</div>
			</div>
		</div>
	</section>
	<section class="section-degrees">
		<div class="jumbotron jumbotron-fluid bg-inverse mb-0">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<h2 class="h1 mb-4 text-primary font-weight-black section-heading"><?php echo get_field( 'degree_search_title', 'colleges_' . $term->term_id ); ?></h2>
						<div class="mb-5"><?php echo get_field( 'degree_search_copy', 'colleges_' . $term->term_id ); ?></div>
						<div class="mb-5"><?php echo do_shortcode( '[ucf-degree-search placeholder="Search ' . $term->name . ' Degrees"]' ); ?></div>
						<h3 class="browse-by-heading h6 heading-sans-serif text-uppercase">Or browse by:</h3>
						<ul class="browse-by-list list-chevrons">
						<?php
							$degree_types = get_field( 'degree_types_available', 'colleges_' . $term->term_id );
							ob_start();
							if( $degree_types ) :
								foreach( $degree_types as $degree_type ) : ?>
									<li><a href="https://www.ucf.edu/degree-search/?program-type[0]=undergraduate-degree&amp;college[0]=<?php echo get_field( 'degree_search_parameter', 'colleges_' . $term->term_id ); ?>&amp;sort-by=title&amp;default=0&amp;offset=0&amp;search-default=0" class="text-inverse"><?php echo $degree_type ?></a></li>
							<?php
								echo ob_get_clean();
								endforeach;
							endif;
						?>
						</ul>
					</div>
					<div class="col-lg-1 hidden-md-down" data-mh="section-degrees-col" style="height: 442px;">
						<hr class="hidden-xs hidden-sm hr-vertical hr-vertical-white center-block">
					</div>
					<div class="col-lg-3 hidden-lg-up">
						<div id="accordion" class="accordion">
							<h3 class="h4 top-majors-heading btn text-upper btn-sm text-left w-100 collapsed" data-toggle="collapse" data-parent="#accordion" href="#top-degree-collapse">Top College <br class="hidden-md-down">Degrees</h3>
							<div id="top-degree-collapse" class="collapse">
								<ul class="top-majors-list list-unstyled">
									<?php echo display_top_degrees( $term ); ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-3 hidden-md-down">
						<h3 class="h4 top-majors-heading btn text-upper btn-sm text-left w-100">Top College <br class="hidden-md-down">Degrees</h3>
						<ul class="top-majors-list list-unstyled">
							<?php echo display_top_degrees( $term ); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php if( $cta = get_field( 'college_page_cta_section', 'colleges_' . $term->term_id ) ) : ?>
	<aside class="aside-ctas">
		<?php echo display_section( $cta->ID, $cta->post_content ); ?>
	</aside>
	<?php endif; ?>
	<section class="section-news">
		<div class="container my-5">
			<div class="row">
				<div class="col-lg-8">
					<h2><?php echo display_news_title( $term ); ?></h2>
				</div>
				<div class="col-lg-4">
					<a href="https://today.ucf.edu/topic/<?php echo get_field( 'news_topic', 'colleges_' . $term->term_id ); ?>" class="more-stories float-lg-right text-uppercase text-default">Check out more stories <span class="fa fa-external-link text-primary" aria-hidden="true"></span></a>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<hr class="mt-0">
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-sm-12">
					<?php echo do_shortcode( '[ucf-news-feed title="" layout="modern" topics="' . get_field( 'news_topic', 'colleges_' . $term->term_id ) . '"]' ); ?>
				</div>
				<?php if( $spotlight = get_field( 'college_spotlight', 'colleges_' . $term->term_id ) ) : ?>
					<div class="col-md-4 col-sm-12">
						<?php  echo do_shortcode( '[ucf-spotlight slug="' . $spotlight->post_name . '"]' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php if( $sections = get_field( 'section_content', 'colleges_' . $term->term_id ) ) : ?>
	<section class="section-custom">
		<?php
		if( $sections ) :
			foreach( $sections as $section ) :
				echo display_section( $section['section']->ID, $section['section']->post_content );
			endforeach;
		endif;
		?>
	</section>
	<?php endif; ?>
	<section class="section-colleges">
		<div class="jumbotron jumbotron-fluid bg-primary py-4 my-0 text-center">
			<div class="container">
			<h2 class="section-heading h3 m-0 text-uppercase font-weight-bold font-condensed">University of Central Florida Colleges</h2>
			</div>
		</div>
		<div class="d-flex flex-wrap">
			<?php
				$colleges = get_terms( array(
					'taxonomy' => 'colleges',
					'hide_empty' => false
				) );
			?>
			<?php foreach( $colleges as $index=>$college ) :
				if( $college->slug !== $term->slug ) : ?>
					<a class="college-block" href="../<?php echo $college->slug; ?>">
						<img class="college-block-img img-fluid" src="<?php echo get_field( 'thumbnail_image', 'colleges_' . $college->term_id); ?>" alt="<?php echo $college->name; ?>">
						<span class="college-block-text"><?php echo $college->name; ?></span>
					</a>
			<?php
				endif;
			endforeach;
			?>
		</div>
	</section>
</article>
<?php get_footer();?>
