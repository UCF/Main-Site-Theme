<?php
/**
 * Template Name: Expert Search/Directory
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php
$page_permalink        = get_permalink();
$query                 = isset( $_GET['query'] ) ? sanitize_text_field( $_GET['query'] ) : '';
$paged                 = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$college_filter        = isset( $_GET['college'] ) ? sanitize_text_field( $_GET['college'] ) : null;
$expertise_filter      = isset( $_GET['expertise'] ) ? sanitize_text_field( $_GET['expertise'] ) : null;
$tag_filter            = isset( $_GET['tag'] ) ? sanitize_text_field( $_GET['tag'] ) : null;
$college               = null;
$expertise             = null;
$tag_term              = null;

// If the user explicitly filtered by college or department,
// grab the term object:
if ( $college_filter ) {
	$college = get_term_by( 'slug', $college_filter, 'colleges' );
}

if ( $expertise_filter ) {
	$expertise = get_term_by( 'slug', $expertise_filter, 'expertise' );
}

if ( $tag_filter ) {
	$tag_term = get_term_by( 'slug', $tag_filter, 'post_tag' );
}

// Set up baseline WP_Query args
$args = array(
	'post_type'      => 'person',
	'tax_query'      => array(
		array(
			'taxonomy' => 'people_group',
			'field'    => 'slug',
			'terms'    => 'expert'
		)
	),
	'orderby'        => 'orderby_clause',
	'order'          => 'ASC',
	'paged'          => $paged, // NOTE: this value must be explicitly set for paginate_links() to work properly
	'posts_per_page' => 20 // NOTE: this value must be explicitly set for $faculty_wp_query->max_num_pages to be accurate when passed thru relevanssi
);

if ( $query ) {
	$args['s'] = $query;
}

if ( $college || $expertise || $tag ) {
	$args['tax_query']['relation'] = 'AND';
}

if ( $college ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'colleges',
		'field'    => 'term_id',
		'terms'    => $college->term_id
	);
}

if ( $expertise ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'expertise',
		'field'    => 'term_id',
		'terms'    => $expertise->term_id
	);
}

if ( $tag_term ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'post_tag',
		'field'    => 'term_id',
		'terms'    => $tag_term->term_id
	);
}

var_dump( $query );

// If we're performing a search for a faculty member
// by person name and Relevanssi is enabled, use
// Relevanssi to get better search results.
// Otherwise, just initialize a new WP_Query directly.
if ( $query && function_exists( 'relevanssi_do_query' ) ) {
	$faculty_wp_query = new WP_Query();
	$faculty_wp_query->parse_query( $args );
	relevanssi_do_query( $faculty_wp_query );
} else {
	$faculty_wp_query = new WP_Query( $args );
}
?>
<div class="jumbotron bg-faded clip-caret clip-caret-down mb-0 px-0">
	<div class="container">
		<p class="lead mb-5">
			<?php echo $faculty_wp_query->found_posts; ?>
			result<?php if ( $faculty_wp_query->found_posts !== 1 ) { ?>s<?php } ?> found

			<?php if ( $query ) : ?>
			for <strong>&ldquo;<?php echo stripslashes( htmlentities( $query ) ); ?>&rdquo;</strong>
			<?php endif; ?>

			<?php if ( $expertise ) : ?>
			with an area of expertise in <strong><?php echo $expertise->name; ?></strong>
			<?php endif; ?>

			<?php if ( $college ) : ?>
			in <strong>the <?php echo $college->name; ?></strong>
			<?php endif; ?>
		</p>

		<?php if ( $faculty_wp_query->have_posts() ) : ?>
		<ul class="list-group">
			<?php
			while ( $faculty_wp_query->have_posts() ) : $faculty_wp_query->the_post();
				$person_title       = get_field( 'expert_title', $post->ID );
				$person_expertise   = get_the_terms( $post, 'expertise' );
				$person_colleges    = get_the_terms( $post, 'colleges' );
				$person_departments = get_the_terms( $post, 'departments' );
				$person_tags        = get_the_tags();
			?>
			<li class="list-group-item expert-list-item mb-2 mb-sm-3 py-sm-3">
				<div class="row no-gutters w-100">
					<div class="col-lg-8 col-xl-7">
						<div class="row no-gutters position-relative w-100">
							<div class="col-2 pr-3 pr-sm-4">
								<div class="embed-responsive embed-responsive-1by1 media-background-container rounded-circle">
									<?php
									echo get_person_thumbnail(
										$post,
										'thumbnail',
										array(
											'class'                => 'media-background object-fit-cover',
											'alt'                  => '',
											'style'                => 'object-position: 50% 0%;',
											'data-object-position' => '50% 0%'
										)
									);
									?>
								</div>
							</div>
							<div class="col-10 col-lg-9 align-self-center position-static py-2 py-lg-3">
								<h2 class="h5 mb-0">
									<a class="stretched-link" href="<?php echo get_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h2>

								<?php if ( $person_title ) : ?>
								<p class="mt-1 mb-0">
									<?php echo $person_title; ?>
								</p>
								<?php endif; ?>
							</div>
						</div>
						<?php if ( $person_expertise ) : ?>
						<div class="offset-2 mb-2">
							<h3 class="small font-weight-normal text-default text-uppercase mb-1 mb-sm-2">Area(s) of Expertise</h3>
							<div class="font-size-sm line-height-2">
							<?php
							foreach( $person_expertise as $k => $expertise ) :
								$person_expertise_filter_url = add_query_arg(
									'expertise',
									$expertise->slug,
									$page_permalink
								);
							?>
								<a href="<?php echo $person_expertise_filter_url; ?>"><?php echo $expertise->name; ?></a>
								<?php if ( $k < count( $person_expertise ) - 1 ) echo ', '; ?>
							<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-sm-6 col-lg-4 col-xl-5 offset-2 offset-lg-0 pl-lg-5">
						<?php if ( $person_colleges ) : ?>
						<div class="mt-2 mt-lg-5 py-sm-1 py-lg-0 mb-4">
							<h3 class="small font-weight-normal text-default text-uppercase mb-1 mb-sm-2">College(s)</h3>
							<div class="font-size-sm line-height-2">
							<?php
							foreach ( $person_colleges as $k => $person_college ) :
								$person_college_name = get_field( 'colleges_alias', 'colleges_' . $person_college->term_id ) ?: $person_college->name;
								$person_college_filter_url = add_query_arg(
									'college',
									$person_college->slug,
									$page_permalink
								);
							?>
								<a href="<?php echo $person_college_filter_url; ?>"><?php echo $person_college_name; ?></a>
								<?php
								if ( $k < count( $person_colleges ) - 1 ) {
									echo ', ';
								}
								?>
							<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-10 col-lg offset-2 offset-lg-0 pl-lg-5 ml-lg-5">
						<?php if ( is_array( $person_tags ) ) : ?>
						<div class="row my-2 mt-lg-3 py-sm-1 py-lg-0">
							<div class="col-lg-auto mt-lg-1">
								<h3 class="small font-weight-normal text-default text-uppercase ml-lg-1 ml-xl-2 mb-0 pt-lg-2">Research Keywords</h3>
							</div>
							<div class="col-lg">
								<ul class="list-unstyled list-inline">
									<?php
									foreach ( $person_tags as $person_tag ) :
										$person_tag_filter_url = add_query_arg(
											'tag',
											$person_tag->slug,
											$page_permalink
										);
									?>
									<li class="list-inline-item my-1 mr-2">
										<a class="badge badge-pill badge-faded letter-spacing-0 text-transform-none font-weight-normal" href="<?php echo $person_tag_filter_url; ?>">
											<?php echo $person_tag->name; ?>
										</a>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</li>
			<?php endwhile; ?>
		</ul>

		<nav aria-label="Faculty result pagination" class="mt-5">
			<?php
			echo paginate_links( array(
				'current'   => $paged,
				'total'     => $faculty_wp_query->max_num_pages,
				'type'      => 'list',
				'prev_text' => '<span class="fa fa-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span>',
				'next_text' => '<span class="fa fa-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span>'
			) );
			?>
		</nav>
		<?php endif; ?>
	</div>
</div>

<?php wp_reset_postdata(); ?>

<?php the_content(); ?>

<?php get_footer(); ?>
