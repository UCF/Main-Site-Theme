<?php
/**
 * Template Name: Faculty Search/Directory
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php
$query                 = isset( $_GET['query'] ) ? sanitize_text_field( $_GET['query'] ) : '';
$paged                 = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$college_filter        = isset( $_GET['college'] ) ? sanitize_text_field( $_GET['college'] ) : null;
$department_filter     = isset( $_GET['department'] ) ? sanitize_text_field( $_GET['department'] ) : null;
$college               = null;
$department            = null;

// If the user explicitly filtered by college or department,
// grab the term object:
if ( $college_filter ) {
	$college = get_term_by( 'slug', $college_filter, 'colleges' );
}

if ( $department_filter ) {
	$department = get_term_by( 'slug', $department_filter, 'departments' );
}

// Set up baseline WP_Query args
$args = array(
	'post_type'      => 'person',
	'meta_query'     => array(
		'person_type_clause' => array(
			'key'     => 'person_type',
			'value'   => 'faculty'
		),
		'orderby_clause' => array(
			'key'     => 'person_last_name',
			'compare' => 'EXISTS'
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

if ( $college || $department ) {
	$args['tax_query'] = array();
}

if ( $college && $department ) {
	$args['tax_query']['relation'] = 'AND';
}

if ( $college ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'colleges',
		'field'    => 'term_id',
		'terms'    => $college->term_id
	);
}

if ( $department ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'departments',
		'field'    => 'term_id',
		'terms'    => $department->term_id
	);
}

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

<div class="container mt-4 mt-md-5 pb-4 pb-md-5">
	<?php the_content(); ?>
</div>

<hr role="presentation" class="my-0">

<div class="jumbotron bg-faded mb-0 px-0">
	<div class="container">
		<p class="lead mb-5">
			<?php echo $faculty_wp_query->found_posts; ?>
			result<?php if ( $faculty_wp_query->found_posts !== 1 ) { ?>s<?php } ?> found

			<?php if ( $query ) : ?>
			for <strong>&ldquo;<?php echo $query; ?>&rdquo;</strong>
			<?php endif; ?>

			<?php if ( $department ) : ?>
			in <strong><?php echo $department->name; ?></strong>
			<?php endif; ?>

			<?php if ( $college ) : ?>
			in <strong>the <?php echo $college->name; ?></strong>
			<?php endif; ?>
		</p>

		<?php if ( $faculty_wp_query->have_posts() ) : ?>
		<ul class="list-group">
			<?php
			while ( $faculty_wp_query->have_posts() ) : $faculty_wp_query->the_post();
				$job_titles = get_field( 'person_titles', $post->ID );
			?>
			<li class="list-group-item">
				<div class="row position-relative w-100">
					<div class="col-2 col-lg-1 pr-0">
						<?php
						echo get_person_thumbnail(
							$post,
							'medium',
							array(
								'class' => 'w-100 h-auto'
							)
						);
						?>
					</div>
					<div class="col-10 col-lg-11 pl-3 pl-sm-4 align-self-center position-static">
						<h2 class="h5 mb-0">
							<a class="stretched-link" href="<?php echo get_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>

						<?php if ( $job_titles ) : ?>
						<p class="mt-1 mb-0">
							<?php echo implode( ', ', array_column( $job_titles, 'job_title' ) ); ?>
						</p>
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

<?php get_footer(); ?>
