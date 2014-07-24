<?php 
// Require DEGREE_SECRET_KEY const
if (DEGREE_SECRET_KEY !== get_theme_option('feedback_email_key')) {
	die('You do not have access to this page.');
}
else {
	/**
	 * Grab the search service JSON feed for all programs
	 **/
	$results = query_search_service(array('use' => 'programSearch'));

	/**
	 * Grab all existing Degree Program posts.  Store IDs in an array ($existing_posts_array).
	 *
	 * We use the IDs in this array later to determine what posts should be deleted
	 * once the import has finished.
	 **/
	$existing_posts_array = get_posts(array(
		'post_type' => 'degree',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'fields' => 'ids'
	));
	foreach ($existing_posts_array as $key=>$val) {
		// Give us data that is easier to work with.
		$existing_posts_array[intval($val)] = intval($val);
		unset($existing_posts_array[$key]);
	}


	/**
	 * Set up an empty array that will contain sets of structured post data
	 * for each new and updated Degree Program post.
	 *
	 * Start a counter (used for convenience to track # of created/updated posts.)
	 **/
	$program_postdata = array();
	$count = 0;


	/**
	 * Loop through each search service result.  Create a structured set of post data 
	 * for each.
	 **/
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

		// Prepare contacts data for insertion as a delimited string:
		if ($program->contacts) {
			$string = '';
			foreach ($program->contacts as $contact) {
				foreach ($contact as $field=>$val) {
					if ($val) {
						$string .= $field.'@@:@@'.$val.'@@,@@';
					}
				}
				$string = substr($string, 0, -1).'@@;@@';
			}
			$program->contacts = $string;
		}

		// Massage website URLs for graduate programs because they're stored in the
		// search service db strangely:
		if ($program->graduate == 1) {
			// Old data previously returned a query param as the 'required_hours' val.
			if ($program->required_hours[0] == '?') {
				$program->website = 'http://www.graduatecatalog.ucf.edu/programs/program.aspx'.$program->required_hours;
			}
			else {
				$program->website = $program->required_hours;
			}
		}


		$program = array(
			'post_data' => array(
				'post_title' 	=> $program->name,
				'post_status' 	=> 'publish',
				'post_date' 	=> date('Y-m-d H:i:s'),
				'post_author' 	=> 1,
				'post_type' 	=> 'degree',
			),
			'post_meta' => array(
				// Programs can have similar degree_id's, so we need
				// type_id to further distinguish unique programs
				'degree_id'			=> $program->degree_id,
				'degree_type_id'	=> $program->type_id,
				'degree_hours'		=> $program->required_hours,
				'degree_description'=> html_entity_decode($program->description),
				'degree_website'	=> $program->website,
				'degree_phone'		=> $program->phone,
				'degree_email'		=> $program->email,
				'degree_contacts'	=> $program->contacts, // semicolon-separated contact lists; fields are comma-separated
			),
			'post_terms' => array(
				'program_types' => $program->type,
				'colleges' => $program->college_name,
				'departments' => $program->department_name,
			),
		);

		$program_postdata[] = $program;
	}


	/**
	 * Loop through our results, which are now structured for insertion into WordPress.
	 * Try to update existing posts.  If no existing post is found, create a new one.
	 **/
	foreach ($program_postdata as $post) {
		$post_data = $post['post_data'];
		$post_meta = $post['post_meta'];
		$post_terms = $post['post_terms']; 
		$post_id = null;

		// Attempt to fetch an existing post to compare against.
		// Check against post type, degree_id, type_id, and program_type.
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
				'tax_query' => array(
					array(
						'taxonomy' => 'program_types',
						'field' => 'slug',
						'terms' => sanitize_title($post_terms['program_types']),
					),
				),
			)
		);
		$existing_post = empty($existing_post) ? false : $existing_post[0]; // Get 1st array value
		

		// Check for existing content; if it exists, update the post and remove the post ID
		// from $existing_posts_array.
		// Otherwise, create a new post.
		if ($existing_post !== false) {
			$post_id = $existing_post->ID;
			$post_data['ID'] = $post_id;
			wp_update_post($post_data);
			unset($existing_posts_array[$post_data['ID']]);

			print 'Updated content of existing post '.$post_data['post_title'].' with ID '.$post_data['ID'].'<br/>';
			$count++;
		}
		else {
			$post_id = wp_insert_post($post['post_data']);

			print 'Saved new post '.$post_data['post_title'].'<br/>';
			$count++;
		}
		// Create/update meta field values.
		if (is_array($post_meta)) {
			foreach ($post_meta as $meta_key=>$meta_val) {
				update_post_meta($post_id, $meta_key, $meta_val);
				if ($meta_val) {
					print 'Updated post meta field '.$meta_key.' with value '.$meta_val.'<br/>';
				}
				else {
					print 'Post meta field '.$meta_key.' was set to an empty value<br/>';
				}
			}
		}

		// Create base program types, if they don't already exist.
		if (!term_exists('Undergraduate Program', 'program_types') || !term_exists('Graduate Program', 'program_types')) {
			$undergraduate_program_term = wp_insert_term('Undergraduate Program', 'program_types');
			$graduate_program_term = wp_insert_term('Graduate Program', 'program_types');

			wp_insert_term('Undergraduate Degree', 'program_types', array('parent' => $undergraduate_program_term['term_id']));
			wp_insert_term('Minor', 'program_types', array('parent' => $undergraduate_program_term['term_id']));
			wp_insert_term('Articulated Program', 'program_types', array('parent' => $undergraduate_program_term['term_id']));
			wp_insert_term('Accelerated Program', 'program_types', array('parent' => $undergraduate_program_term['term_id']));

			wp_insert_term('Graduate Degree', 'program_types', array('parent' => $graduate_program_term['term_id']));
			wp_insert_term('Certificate', 'program_types', array('parent' => $graduate_program_term['term_id']));

			// Force a purge of any cached hierarchy so that parent/child relationships are
			// properly saved: http://wordpress.stackexchange.com/a/8921
			delete_option('program_types_children');
		}
		// Set/update taxonomy terms.
		// NOTE: These do NOT account for parent/child relationships! Terms not defined above will be created at the root level.
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
	}
	print '<br/>Created/Updated '.$count.' posts.<br/>';


	/**
	 * Delete any of the remaining posts in $existing_posts_array.  These posts were not 
	 * updated and were not new posts, so we assume that they were deleted from the search 
	 * service data, and should therefore be deleted from WordPress.
	 **/
	foreach ($existing_posts_array as $post_id) {
		$post_title = get_post($post_id)->post_title;
		wp_delete_post($post_id);
		print 'Post '.$post_title.' with ID '.$post_id.' was deleted.<br/>';
	}
	print '<br/>Deleted '.count($existing_posts_array).' existing posts.';
}
?>