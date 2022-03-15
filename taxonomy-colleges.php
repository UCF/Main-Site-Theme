<?php
get_header();
$term = get_queried_object();
// Lead
$lead_copy = get_field( 'college_page_lead_copy', $term );
$lead_image = get_field( 'college_page_lead_image', $term )['url'] ?? null;
$college_url = get_field( 'colleges_url', $term );
$lead_cta_text = get_field( 'lead_cta_text', $term ) ?: 'Visit ' . str_replace( array( 'http://', 'https://' ), '', $college_url );
$lead_cta_url = get_field( 'lead_cta_url', $term ) ?: $college_url;
// Stats
$stats = get_field( 'stat', $term );
$stats_background = get_field( 'stats_background_image', $term )['url'] ?? null;
// Degree
$degree_title = get_field( 'degree_search_title', $term ) ?: 'Search Degrees';
$degree_copy = get_field( 'degree_search_copy', $term );
$degree_search_url = "https://www.ucf.edu/degree-search/#!/college/" . $term->slug . "/";
$degree_types = get_field( 'degree_types_available', $term );
$degree_types = map_degree_types( $degree_types );
$top_degrees = display_top_degrees( $term );
$top_degrees_heading = get_field( 'top_degrees_heading', $term ) ?: 'Top College Degrees';
$custom_top_degrees_heading = get_field( 'top_degrees_custom_heading', $term );
$custom_top_degrees = display_custom_top_degrees( $term );
// CTA
$cta = get_field( 'college_page_cta_section', $term );
// News
$news_topic = get_field( 'news_topic', $term );
$spotlight = get_field( 'college_spotlight', $term );
?>
<article>
	<section class="section-lead" id="intro" aria-label="Introduction">
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
			<?php if ( $lead_cta_url ): ?>
			<div class="row">
				<div class="col-12 text-center mt-3">
					<a class="btn btn-primary" href="<?php echo $lead_cta_url; ?>" target="_blank"><?php echo $lead_cta_text; ?></a>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<section class="section-stats" id="stats" aria-label="Facts and figures">
		<div class="media-background-container">
			<img class="media-background object-fit-cover" srcset="<?php echo $stats_background; ?>" src="<?php echo $stats_background; ?>" alt="">
			<div class="container my-5 fact-grid-wrap">
				<div class="row fact-grid">
				<?php
					ob_start();
					if ( $stats ) :
						foreach ( $stats as $index => $stat ) :
							$details_id = "fact-details-$index";
				?>
							<div class="col-sm-6 col-lg-4 fact-block">
								<aside aria-labelledby="<?php echo $details_id; ?>">
									<img
										src="<?php echo $stat['icon']['url']; ?>"
										alt="<?php echo $stat['icon']['alt']; ?>"
										width="<?php echo $stat['icon']['width']; ?>"
										height="<?php echo $stat['icon']['height']; ?>"
										class="fact-header fact-header-lg fact-header-icon w-auto"
									>
									<div class="fact-details" id="<?php echo $details_id; ?>"><?php echo $stat["copy"]; ?></div>
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
	<section class="section-degrees" id="degrees" aria-labelledby="section-degrees-heading">
		<div class="jumbotron jumbotron-fluid bg-inverse mb-0">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<h2 id="section-degrees-heading" class="h1 mb-4 text-primary font-weight-black section-heading"><?php echo $degree_title; ?></h2>
						<div class="mb-5"><?php echo $degree_copy; ?></div>
						<div class="mb-5"><?php echo do_shortcode( '[ucf-degree-search placeholder="Search ' . $term->name . ' Degrees"]' ); ?></div>

						<?php if ( $degree_types ) : ?>
						<h3 class="browse-by-heading h6 heading-sans-serif text-uppercase">Or browse by:</h3>
						<ul class="browse-by-list list-chevrons">
							<?php foreach( $degree_types as $slug => $name ) : ?>
							<li><a href="<?php echo $degree_search_url . $slug . '/'; ?>" class="text-inverse"><?php echo $name . 's'; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>

					<?php if ( $top_degrees || $custom_top_degrees ): ?>
					<div class="col-lg-1 hidden-md-down">
						<hr class="hidden-xs hidden-sm hr-vertical mx-auto">
					</div>
					<div class="col-lg-3">
						<?php if ( $top_degrees || ( ! $top_degrees && $custom_top_degrees && ! $custom_top_degrees_heading ) ) : ?>
						<h3 class="h5 mb-3 hidden-md-down"><span class="badge badge-inverse"><?php echo $top_degrees_heading; ?></span></h3>
						<a class="hidden-lg-up btn btn-outline-inverse btn-block mb-3 collapsed" data-toggle="collapse" data-target="#top-degree-collapse" href="#top-degree-collapse">
							<?php echo $top_degrees_heading; ?> <span class="fa fa-chevron-circle-down" aria-hidden="true"></span>
						</a>
						<div id="top-degree-collapse" class="collapse d-lg-block">
							<ul class="top-majors-list nav flex-column align-items-start list-unstyled pl-3">
								<?php if ( $top_degrees ) : ?>
									<?php echo $top_degrees; ?>
								<?php endif; ?>

								<?php if ( $custom_top_degrees && ! $custom_top_degrees_heading ) : ?>
									<?php echo $custom_top_degrees; ?>
								<?php endif; ?>
							</ul>
						</div>
						<?php endif; ?>

						<?php if ( $custom_top_degrees && $custom_top_degrees_heading ) : ?>
						<h3 class="h5 mt-3 mt-lg-4 mb-3 hidden-md-down"><span class="badge badge-inverse"><?php echo $custom_top_degrees_heading; ?></span></h3>
						<a class="hidden-lg-up btn btn-outline-inverse btn-block mt-3 mt-lg-4 mb-3 collapsed" data-toggle="collapse" data-target="#custom-top-degree-collapse" href="#custom-top-degree-collapse">
							<?php echo $custom_top_degrees_heading; ?> <span class="fa fa-chevron-circle-down" aria-hidden="true"></span>
						</a>
						<div id="custom-top-degree-collapse" class="collapse d-lg-block">
							<ul class="top-majors-list nav flex-column align-items-start list-unstyled pl-3">
								<?php echo $custom_top_degrees; ?>
							</ul>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php if ( $cta ) : ?>
		<?php echo do_shortcode( '[ucf-section slug="' . $cta->post_name . '" title="Next steps and learn more"]' ); ?>
	<?php endif; ?>
	<section class="section-news" id="news" aria-labelledby="news-heading">
		<div class="container my-5">
			<div class="row justify-content-between align-items-end">
				<div class="col-auto">
					<h2 id="news-heading" class="mb-0"><?php echo ( $news_title = get_field( 'colleges_alias', 'colleges_' . $term->term_id ) ) ? $news_title . " News" : $term->name . " News"; ?></h2>
				</div>
				<div class="col-auto">
					<a href="https://www.ucf.edu/news/tag/<?php echo $news_topic; ?>" class="text-decoration-none h6 text-uppercase d-block mb-0 mt-2 text-default">Check out more stories <span class="fa fa-external-link text-primary" aria-hidden="true"></span></a>
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

	<?php echo get_colleges_grid( $term ); ?>
</article>
<?php get_footer();?>
