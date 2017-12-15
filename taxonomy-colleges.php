<?php
get_header();
$term = get_queried_object();
// Lead
$lead_copy = get_field( 'college_page_lead_copy', 'colleges_' . $term->term_id );
$lead_image = get_field( 'college_page_lead_image', 'colleges_' . $term->term_id )['url'];
$college_url = get_field( 'colleges_url', 'colleges_' . $term->term_id );
// Stats
$stats = get_field( 'stat', 'colleges_' . $term->term_id );
$stats_background = get_field( 'stats_background_image', 'colleges_' . $term->term_id )['url'];
// Degree
$degree_title = get_field( 'degree_search_title', 'colleges_' . $term->term_id );
$degree_copy = get_field( 'degree_search_copy', 'colleges_' . $term->term_id );
$degree_search_url = "https://www.ucf.edu/degree-search/#!/college/" . $term->slug . "/";
$degree_types = get_field( 'degree_types_available', 'colleges_' . $term->term_id );
$degree_types = map_degree_types( $degree_types );
// CTA
$cta = get_field( 'college_page_cta_section', 'colleges_' . $term->term_id );
// News
$news_topic = get_field( 'news_topic', 'colleges_' . $term->term_id );
$spotlight = get_field( 'college_spotlight', 'colleges_' . $term->term_id );
// Colleges Grid
$colleges = get_terms( array( 'taxonomy' => 'colleges', 'hide_empty' => false ) );
?>
<article role="main">
	<section class="section-lead">
		<div class="container my-5">
			<div class="row">
				<div class="col-sm-12 col-md-8 lead">
					<?php echo $lead_copy; ?>
				</div>
				<div class="col-sm-12 col-md-4">
					<?php if( $lead_image ) : ?>
						<img src="<?php echo $lead_image; ?>" alt="" class="img-fluid">
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-center mt-3">
					<?php $http = array( "http://", "https://" ); ?>
					<a class="btn btn-primary" href="<?php echo $college_url; ?>" target="_blank">Visit <?php echo str_replace( $http, '', $college_url ) ; ?></a>
				</div>
			</div>
		</div>
	</section>
	<section class="section-stats">
		<div class="media-background-container">
			<img class="media-background object-fit-cover" srcset="<?php echo $stats_background; ?>" src="<?php echo $stats_background; ?>" alt="">
			<div class="container my-5 fact-grid-wrap">
				<div class="row fact-grid">
				<?php
					ob_start();
					if ( $stats ) :
						foreach ( $stats as $index => $stat ) :
				?>
							<div class="col-sm-6 col-lg-4 fact-block">
								<aside>
									<img src="<?php echo $stat["icon"]["url"]; ?>" alt="<?php echo $stat["icon"]["alt"]; ?>" title="<?php echo $stat["icon"]["title"]; ?>" class="fact-header fact-header-lg fact-header-icon img-fluid">
									<div class="fact-details"><?php echo $stat["copy"]; ?></div>
								</aside>
							</div>
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
						<h2 class="h1 mb-4 text-primary font-weight-black section-heading"><?php echo $degree_title; ?></h2>
						<div class="mb-5"><?php echo $degree_copy; ?></div>
						<div class="mb-5"><?php echo do_shortcode( '[ucf-degree-search placeholder="Search ' . $term->name . ' Degrees"]' ); ?></div>
						<h3 class="browse-by-heading h6 heading-sans-serif text-uppercase">Or browse by:</h3>
						<ul class="browse-by-list list-chevrons">
						<?php
							ob_start();
							if( $degree_types ) :
								foreach( $degree_types as $slug => $name ) : ?>
									<li><a href="<?php echo $degree_search_url . $slug . '/'; ?>" class="text-inverse"><?php echo $name . 's'; ?></a></li>
							<?php
								echo ob_get_clean();
								endforeach;
							endif;
						?>
						</ul>
					</div>
					<div class="col-lg-1 hidden-md-down">
						<hr class="hidden-xs hidden-sm hr-vertical hr-vertical-white center-block">
					</div>
					<div class="col-lg-3">
						<h3 class="h5 mb-3 hidden-md-down"><span class="badge badge-inverse">Top College Degrees</span></h3>
						<a class="hidden-lg-up btn btn-outline-inverse btn-block mb-3 collapsed" data-toggle="collapse" data-target="#top-degree-collapse" href="#top-degree-collapse">
							Top College Degrees <span class="fa fa-chevron-circle-down" aria-hidden="true"></span>
						</a>
						<div id="top-degree-collapse" class="collapse d-lg-block">
							<ul class="top-majors-list nav flex-column align-items-start list-unstyled pl-3">
								<?php echo display_top_degrees( $term ); // located in functions.php ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php if( $cta ) : ?>
	<aside class="aside-ctas">
		<?php echo do_shortcode( '[ucf-section slug="' . $cta->post_name . '"]' ); ?>
	</aside>
	<?php endif; ?>
	<section class="section-news">
		<div class="container my-5">
			<div class="row justify-content-between align-items-end">
				<div class="col-auto">
					<h2 class="mb-0"><?php echo ( $news_title = get_field( 'colleges_alias', 'colleges_' . $term->term_id ) ) ? $news_title . " News" : $term->name . " News"; ?></h2>
				</div>
				<div class="col-auto">
					<a href="https://today.ucf.edu/topic/<?php echo $news_topic; ?>" class="h6 text-uppercase d-block mb-0 mt-2 text-default">Check out more stories <span class="fa fa-external-link text-primary" aria-hidden="true"></span></a>
				</div>
			</div>
			<hr class="mt-2">
			<div class="row">
				<div class="col-md-8 col-sm-12">
					<?php echo do_shortcode( '[ucf-news-feed title="" layout="modern" topics="' . $news_topic . '"]' ); ?>
				</div>
				<?php if( $spotlight ) : ?>
					<div class="col-md-4 col-sm-12">
						<?php echo do_shortcode( '[ucf-spotlight slug="' . $spotlight->post_name . '"]' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php if( $sections = get_field( 'section_content', 'colleges_' . $term->term_id ) ) : ?>
	<?php
	if( $sections ) :
		foreach( $sections as $section ) :
			echo do_shortcode( '[ucf-section slug="' . $section['section']->post_name . '"]' );
		endforeach;
	endif;
	?>
	<?php endif; ?>
	<section class="section-colleges">
		<div class="jumbotron jumbotron-fluid bg-primary py-4 my-0 text-center">
			<div class="container">
			<h2 class="section-heading h3 m-0 text-uppercase font-weight-bold font-condensed">University of Central Florida Colleges</h2>
			</div>
		</div>
		<div class="colleges-grid">
			<?php foreach( $colleges as $index=>$college ) :
				if( $college->slug !== $term->slug ) : ?>
					<a class="colleges-block media-background-container text-inverse hover-text-inverse text-decoration-none justify-content-end" href="../<?php echo $college->slug; ?>">
						<img class="media-background object-fit-cover filter-sepia hover-filter-none" src="<?php echo get_field( 'thumbnail_image', 'colleges_' . $college->term_id); ?>" alt="">
						<span class="colleges-block-text pointer-events-none font-condensed text-uppercase"><?php echo get_field( 'colleges_alias', 'colleges_' . $college->term_id ); ?></span>
					</a>
			<?php
				endif;
			endforeach;
			?>
		</div>
	</section>
</article>
<?php get_footer();?>
