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
	<script>
		var FACULTY_SEARCH_SETTINGS = {
			faculty: {
				dataEndpoint: "<?php echo get_rest_url( null, 'wp/v2/person?meta_key=person_type&meta_value=faculty' ); ?>",
				selectedAction: function(event, obj) {
					window.location = obj.link;
				}
			},
			colleges: {
				dataEndpoint: "<?php echo get_rest_url( null, 'wp/v2/colleges' ) ?>",
				selectedAction: function(event, obj) {
					window.location = "<?php echo get_permalink( $post->ID ); ?>?colleges=" + obj.slug;
				}
			},
			departments: {
				dataEndpoint: "<?php echo get_rest_url( null, 'wp/v2/departments' ) ?>",
				selectedAction: function(event, obj) {
					window.location = "<?php echo get_permalink( $post->ID ); ?>?departments=" + obj.slug;
				}
			}
		};
	</script>
	<form class="faculty-search" action="<?php echo get_permalink( $post->ID ); ?>">
		<div class="input-group">
			<label for="faculty-search-query" class="sr-only">Faculty member name, college or department</label>
			<input
				type="text"
				name="query"
				class="faculty-search-typeahead form-control"
				value="<?php echo stripslashes( htmlentities( $query ) ); ?>"
				placeholder="Search by name, college or department"
			>
			<span class="input-group-btn">
				<button class="btn btn-primary" type="submit">
					<span class="fa fa-search" aria-hidden="true"></span>
					<span class="sr-only hidden-md-up">Search</span>
					<span class="hidden-sm-down">Search</span>
				</button>
			</span>
		</div>
	</form>

	<p>
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
		<?php while ( $faculty_wp_query->have_posts() ) : $faculty_wp_query->the_post(); ?>
			<?php echo get_the_title(); // TODO ?>
		<?php endwhile; ?>

		<?php
		// TODO port over pagination overrides from UCF WP Theme?
		echo paginate_links( array(
			'current' => $paged,
			'total'   => $faculty_wp_query->max_num_pages
		) );
		?>
	<?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
