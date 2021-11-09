<?php
/**
 * Template Name: Faculty Search/Directory
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php
$query       = isset( $_GET['query'] ) ? sanitize_text_field( $_GET['query'] ) : '';
$paged       = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$colleges    = isset( $_GET['colleges'] ) ? sanitize_text_field( $_GET['colleges'] ) : null;
$departments = isset( $_GET['departments'] ) ? sanitize_text_field( $_GET['departments'] ) : null;

$args = array(
	'post_type'  => 'person',
	'meta_key'   => 'person_type',
	'meta_value' => 'faculty',
	'orderby'    => 'post_title', // TODO use a meta field that stores last name/sort name instead
	'order'      => 'ASC',
	'paged'      => $paged
);

if ( $query ) {
	// TODO why on earth does this work in the REST endpoint,
	// but not via WP_Query directly???
	$args['s'] = $query;
}

if ( $colleges || $departments ) {
	$args['tax_query'] = array();
}

if ( $colleges && $departments ) {
	$args['tax_query']['relation'] = 'AND';
}

if ( $colleges ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'colleges',
		'field'    => 'slug',
		'terms'    => $colleges
	);
}

if ( $departments ) {
	$args['tax_query'][] = array(
		'taxonomy' => 'departments',
		'field'    => 'slug',
		'terms'    => $departments
	);
}

$faculty_wp_query = new WP_Query( $args );
?>

<div class="container mt-4 mt-md-5 pb-4 pb-md-5">
	<?php the_content(); ?>
</div>

<hr role="presentation" class="my-0">

<div class="jumbotron bg-faded mb-0 px-0">
	<div class="container">
		<p class="lead mb-5">
			<?php echo $faculty_wp_query->found_posts; ?>
			results found
			<?php if ( $query ) : ?>
				for <strong>&ldquo;<?php echo $query; ?>&rdquo;</strong>
			<?php elseif ( $colleges ) : ?>
				in <strong><?php echo $colleges; // TODO use college name(s) or alias(es) here ?></strong>
			<?php elseif ( $departments ) : ?>
				in <strong><?php echo $departments; // TODO use dept name(s) here ?></strong>
			<?php endif; ?>
		</p>

		<?php if ( $faculty_wp_query->have_posts() ) : ?>
			<?php
			while ( $faculty_wp_query->have_posts() ) : $faculty_wp_query->the_post();
				$job_title = get_post_meta( $post->ID, 'person_title', true );
			?>
			<div class="card mb-4 position-relative">
				<div class="card-block">
					<div class="row">
						<div class="col-3 col-lg-2">
							<?php
							echo get_person_thumbnail(
								$post,
								'medium',
								array(
									'class' => 'w-100 h-auto'
								)
							); ?>
						</div>
						<div class="col-9 col-lg-10 position-static">
							<h2 class="h5">
								<a class="stretched-link" href="<?php echo get_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>

							<?php if ( $job_title ) : ?>
							<p class="mb-0"><?php echo $job_title; ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endwhile; ?>

			<nav aria-label="Faculty result pagination">
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
