<?php 
require('../../../../wp-blog-header.php');
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

// Grab the search service JSON feed for all programs
$results = query_search_service(array('use' => 'programSearch', 'search' => 'Digital Media'));


$program_postdata = array();
$count = 0;

foreach ($results as $program) {
	// Update program type degree names.
	switch ($program->type) {
		case 'major':
			if ($program->graduate == 0) {
				$program->type = 'Undergraduate Degree';
			}
			else {
				$program->type = 'Graduate Degree';
			}
			break;
		case 'articulated':
			$program->type = ucwords($program->type).' Program';
			break;
		case 'accelerated':
			$program->type = ucwords($program->type).' Program';
			break;
		default:
			$program->type = ucwords($program->type);
			break;
	}
	$program = array(
		'post_data' => array(
			'post_title' 	=> $program->name,
			'post_content' 	=> 'Hey look a new description',
			'post_status' 	=> 'publish',
			'post_date' 	=> date('Y-m-d H:i:s'),
			'post_author' 	=> 1,
			'post_type' 	=> 'degree',
		),
		'post_meta' => array(
			// Programs can have similar degree_id's, so we need
			// type_id to further distinguish unique programs
			'degree_id'				 => $program->degree_id,
			'degree_type_id'		 => $program->type_id,
			'degree_college_name' 	 => $program->college_name,
			'degree_department_name' => $program->department_name,
		),
		'post_terms' => array(
			'program_types' => $program->type,
			'colleges' => $program->college_name,
			'departments' => $program->department_name,
		),
	);

	$program_postdata[] = $program;
}

foreach ($program_postdata as $post) {
	$post_data = $post['post_data'];
	$post_meta = $post['post_meta'];
	$post_terms = $post['post_terms']; 
	$post_id = null;

	// Attempt to fetch an existing post to compare against.
	$existing_post = get_posts(
		array(
			'post_type' => $post_data['post_type'],
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key' => 'degree_id',
					'value' => $post_meta['degree_id'],
				),
				array(
					'key' => 'degree_type_id',
					'value' => $post_meta['degree_type_id'],
				),
			),
		)
	);
	$existing_post = empty($existing_post) ? false : $existing_post[0];
	$existing_post = $existing_post->post_title == $post_data['post_title'] ? $existing_post : false;

	// Check for existing content; if it exists, update it.
	// Otherwise, create a new post.
	if ($existing_post) {
		$post_id = $existing_post->ID;
		$post_data['ID'] = $post_id;
		wp_update_post($post_data);
		print 'Updated content of existing post '.$post_data['post_title'].' with ID '.$post_data['ID'].'<br/>';
	}
	else {
		$post_id = wp_insert_post($post['post_data']);
		print 'Saved new post '.$post_data['post_title'].'<br/>';
	}
	// Create/update meta field values.
	if (is_array($post_meta)) {
		foreach ($post_meta as $meta_key=>$meta_val) {
			update_post_meta($post_id, $meta_key, $meta_val);
			print 'Updated post meta field '.$meta_key.' with value '.$meta_val.'<br/>';
		}
	}

	// Set/update taxonomy terms.
	// NOTE: These do NOT account for parent/child relationships!
	foreach ($post_terms as $tax=>$term) {
		// Check for existing. Make a new term if necessary.
		// Return a term_id.
		$existing_term = term_exists($term, $tax);
		if (!empty($existing_term) && is_array($existing_term)) {
			$term_id = $existing_term['term_id'];
		}
		else {
			$new_term = wp_insert_term($term, $tax);
			if (gettype($new_term) == 'array') { // Make sure we don't get WP error object
				$term_id = $new_term['term_id'];
			}
		}
		// Actually set the term for the post.
		if ($term_id) {
			wp_set_post_terms($post_id, $term_id, $tax);
			print 'Set post\'s taxonomy '.$tax.' to type '.$term.'<br/>';
		}
		else {
			print 'Failed to set taxonomy '.$tax.' to type '.$term.' for this post.<br/>';
		}
	}

	// Done.
	print 'Finished processing post '.$post_data['post_title'].'<br/><br/>';

	$count++;
}
print '<br/>Processed '.$count.' posts.';
?>