<?php
if ( !defined( 'WP_USE_THEMES' ) ) {
	define( 'WP_USE_THEMES', false );
	require('../../../wp-load.php');
}

function get_first_result( $array_result ) {
	return $array_result[0];
}

function fetch_degree_data() {
	$args = array(
		'numberposts' => -1,
		'post_type' => 'degree',
		'orderby' => 'title', // default sort by title
		'order' => 'ASC',
		'tax_query' => array(),
		's' => ''
	);

	if ( $_GET['search-query'] ) {
		$args['s'] = $_GET['search-query'];
	}

	if ( $_GET['sort-by'] && $_GET['sort-by'] == 'degree_hours' ) {
		$args['meta_key'] = 'degree_hours';
		$args['orderby'] = 'meta_value_num title';
	}

	if ( $_GET['college'] ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'colleges',
			'field' => 'slug',
			'terms' => $_GET['college']
		);
	}
	if ( $_GET['program-type'] ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'program_types',
			'field' => 'slug',
			'terms' => $_GET['program-type']
		);
	}
	if ( count( $args['tax_query'] ) > 1 ) {
		$args['tax_query']['relation'] = 'AND';
	}

	$posts = get_posts( $args );

	// var_dump($_GET);
	// var_dump($args);
	// var_dump($posts);

	$data = array();
	if ( $posts ) {
		foreach ( $posts as $post ) {
			// Example of a format we might be working with
			$degree = array(
				'academicPlanId' => $post->ID,
				// 'academicSubPlan' => array(
				// 	'id' => '',
				// 	'type' => '',
				// 	'name' => '',
				// 	'description' => ''
				// ),
				'name' => $post->post_title,
				'abbreviation' => '',
				'degree' => get_first_result( wp_get_post_terms( $post->ID, 'program_types', array( 'fields' => 'names' ) ) ),
				'creditHours' => intval( get_post_meta( $post->ID, 'degree_hours', TRUE ) ),
				// 'thesis' => '',
				// 'nonThesis' => '',
				// 'dissertation' => '',
				'college' => array(
					'name' => get_first_result( wp_get_post_terms( $post->ID, 'colleges', array( 'fields' => 'names' ) ) ),
					'url' => '',
				),
				'department' => array(
					'name' => get_first_result( wp_get_post_terms( $post->ID, 'departments', array( 'fields' => 'names' ) ) ),
					'url' => '',
				),
				// 'online' => get_post_meta( $post->ID, 'degree_online', TRUE ),
				'description' => get_post_meta( $post->ID, 'degree_description', TRUE ),
				// 'prerequisite' => '',
				// 'applicationInfoDescription' => '',
				// 'applicationInfo' => array(
				// 	'deadline' => '',
				// 	'description' => ''
				// ),
				'contact' => array(
					'name' => '', // currently split into an array in WP; leave blank for now.
					'email' => get_post_meta( $post->ID, 'degree_email', TRUE ),
					'phoneNumber' => get_post_meta( $post->ID, 'degree_phone', TRUE )
				),
				'keywordList' => wp_get_post_terms( $post->ID, 'post_tag', array( 'fields', 'names' ) ),
				// 'relatedProgramList' => array(),
				// 'semesterOffered' => '',
				// 'dateLastModified' => ''
			);

			$data[] = $degree;
		}
	}

	return $data;
}

// Dummy data
$results = fetch_degree_data();

$markup = '<div class="no-results">No results found.</div>';

if ( $results ) {
	$markup = '<ul class="degree-search-results">';

	foreach ( $results as $result ) {
		$result_markup = '';
		ob_start();
		?>
		<li class="degree-search-result">
			<h3 class="degree-title">
				<a href="<?php echo get_permalink( $result['academicPlanId'] ); ?>">
					<?php echo $result['name']; ?> <?php echo $result['abbreviation']; ?>
				</a>
				<span class="degree-credits-count">
				<?php echo $result['degree']; ?> &mdash;
				<?php if ( $result['creditHours'] > 0 ): ?>
					<?php echo $result['creditHours']; ?> Credit Hours
				<?php else: ?>
					Credit Hours n/a
				<?php endif; ?>
				</span>
			</h3>
			<div class="degree-online">
				<?php if ( $result['online'] == 'on' ): ?>
				<span class="icon-globe"></span> Online
				<?php endif; ?>
			</div>
			<div class="degree-compare">
				<label class="checkbox degree-compare-label">
					<input type="checkbox" name="compare[]" class="degree-compare-input" value="<?php echo $result['academicPlanId']; ?>"> <span>Add To Compare</span>
				</label>
				<a class="degree-compare-submit btn btn-small disabled" href="#">
					<span class="hidden-phone">Compare</span>
					<span class="visible-phone">Go</span>
				</a>
				<span class="degree-compare-selected-count"></span>
			</div>
		</li>
		<?php
		$result_markup = ob_get_clean();
		$markup .= $result_markup;
	}

	$markup .= '</ul>';
}



// Print results
header('Content-Type: application/json');
echo json_encode( array(
	'count' => count( $results ),
	'markup' => $markup
) );

?>
