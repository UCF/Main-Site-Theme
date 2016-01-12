<?php
// Require DEGREE_SECRET_KEY const and admin level capabilities
if ( DEGREE_SECRET_KEY !== get_theme_option( 'feedback_email_key' ) || !current_user_can( 'manage_options' ) ) {
	die('You do not have access to this page.');
}
else {
	// Progressively show script progress. Increase max execution time.
	ob_implicit_flush(true);
	ob_end_flush();
	ini_set('max_execution_time', 240); // Allow up to 4 minutes for execution

	/**
	 * Grab the search service JSON feed for all programs and undergraduate
	 * catalog data
	 **/
	$results = query_search_service(array('use' => 'programSearch'));
	$ucatalog_data = query_undergraduate_catalog();

	if ($results) {
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
		 * Create base program types, if they don't already exist.
		 **/
		if (!term_exists('Undergraduate Program', 'program_types') || !term_exists('Graduate Program', 'program_types')) {
			$undergraduate_program_term = wp_insert_term('Undergraduate Program', 'program_types');
			$graduate_program_term = wp_insert_term('Graduate Program', 'program_types');

			$undergraduate_degree_term = wp_insert_term('Undergraduate Degree', 'program_types', array('parent' => $undergraduate_program_term['term_id']));
			wp_insert_term('Minor', 'program_types', array('parent' => $undergraduate_program_term['term_id']));
			wp_insert_term('Articulated Program', 'program_types', array('parent' => $undergraduate_degree_term['term_id']));
			wp_insert_term('Accelerated Program', 'program_types', array('parent' => $undergraduate_degree_term['term_id']));

			wp_insert_term('Graduate Degree', 'program_types', array('parent' => $graduate_program_term['term_id']));
			wp_insert_term('Certificate', 'program_types', array('parent' => $graduate_program_term['term_id']));

			// Force a purge of any cached hierarchy so that parent/child relationships are
			// properly saved: http://wordpress.stackexchange.com/a/8921
			delete_option('program_types_children');

			print 'New base program taxonomy terms created.<br><br>';
		}
		else {
			print 'Existing base program taxonomy terms found.<br><br>';
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
		 * Define a function that "cleans" strings (program/college names)
		 * for more accurate string comparisons.
		 **/
		function clean_name($str) {
			$blacklist = array('degree', 'program');
			$str = strtolower(html_entity_decode($str, ENT_NOQUOTES, 'UTF-8'));
			$str = str_replace($blacklist, '', $str);
			$str = preg_replace('/[^a-z0-9]/', '', $str);
			return $str;
		}

		/**
		 * Replaces a string with a given replacement in $replacement_list.
		 * $replacement_list is expected to be an associative array with simple
		 * string key/value pairs, e.g.:
		 *
		 * $replacement_list = array( 'Wrong name' => 'Correct name', ... );
		 **/
		function replace_name( $str, $replacement_list ) {
			$val = $str;
			if ( isset( $replacement_list[$str] ) ) {
				$val = $replacement_list[$str];
			}
			return $val;
		}


		/**
		 * Loop through each search service result.  Create a structured set of post data
		 * for each.
		 **/
		foreach ($results as $program) {
			// Update program type degree names. Assign $program->type_ucmatch for later use.
			$program->type_ucmatch = 'Degree Program';
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
				case 'accelerated':
					$program->type_ucmatch = $program->type;
					$program->type = ucwords($program->type).' Program';
					break;
				default:
					$program->type_ucmatch = $program->type;
					$program->type = ucwords($program->type);
					break;
			}

			// Fix known college name anomalies.
			$program->college_name = replace_name( $program->college_name, array(
				'College of Hospitality Management' => 'Rosen College of Hospitality Management',
				'Office of Undergraduate Studies' => 'College of Undergraduate Studies',
				'College of Nondegree' => ''
			) );

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

			// Assign catalog pdf links to undergraduate degrees.
			// Check against undergraduate catalog's provided degree name, type,
			// and college for a match.
			if ( $ucatalog_data ) {
				foreach ($ucatalog_data as $key=>$uc_program) {
					// Check if our program type string is a substring of the catalog's program type;
					// if both program names match, or the program is accelerated and the name is a substring of the catalog's program name or name + type;
					// and if the college name either matches or if one college name is a substring of the other
					if (
						stripos($uc_program->type, $program->type_ucmatch) !== false &&
						(
							clean_name($program->name) == clean_name($uc_program->name) ||
							(
								$program->type_ucmatch == 'accelerated' &&
								(
									stripos(clean_name($program->name), clean_name($uc_program->name)) !== false ||
									stripos(clean_name($uc_program->name.$uc_program->type), clean_name($program->name)) !== false
								)
							)
						) &&
						(
							clean_name($program->college_name) == clean_name($uc_program->college) ||
							stripos(clean_name($program->college_name), clean_name($uc_program->college)) !== false ||
							stripos(clean_name($uc_program->college), clean_name($program->college_name)) !== false
						)
					) {
						$program->catalog_url = $uc_program->pdf;
						break;
					}
				}
				if (!$program->catalog_url) { $program->catalog_url = ''; }
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
					'degree_id'			 => $program->degree_id,
					'degree_type_id'	 => $program->type_id,
					'degree_hours'		 => $program->required_hours,
					'degree_description' => html_entity_decode($program->description),
					'degree_website'	 => $program->website,
					'degree_phone'		 => $program->phone,
					'degree_email'		 => $program->email,
					'degree_contacts'	 => $program->contacts, // semicolon-separated contact lists; fields are comma-separated
					'degree_pdf'		 => $program->catalog_url,
					'degree_is_graduate' => $program->graduate, // Note: 'Certificates' can be undergraduate or graduate, even though our grouping logic puts them under Graduate Programs
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

				print 'Updated content of existing post '.$post_data['post_title'].' with ID '.$post_data['ID'].'.<br>';
				$count++;
			}
			else {
				$post_id = wp_insert_post($post['post_data']);

				print 'Saved new post '.$post_data['post_title'].'.<br>';
				$count++;
			}
			// Create/update meta field values.
			if (is_array($post_meta)) {
				foreach ($post_meta as $meta_key=>$meta_val) {
					$updated = update_post_meta($post_id, $meta_key, $meta_val);
					// update_post_meta will return false if $meta_val is the same as the db val
					if ($updated == true) {
						if ($meta_val) {
							print 'Updated post meta field '.$meta_key.' with value '.$meta_val.'.<br>';
						}
						else {
							print 'Post meta field '.$meta_key.' was set to an empty value.<br>';
						}
					}
					else if (is_numeric($updated) && $updated > 1) {
						print 'Meta with ID '.$updated.' does not exist.<br>';
					}
					else if ($updated == false) {
						if ($meta_val) {
							print 'Post meta field '.$meta_key.' with value '.$meta_val.' left unchanged.<br>';
						}
						else {
							print 'Post meta field '.$meta_key.' with empty value left unchanged.<br>';
						}
					}
				}
			}

			// Set/update taxonomy terms.
			// NOTE: These do NOT account for parent/child relationships! Terms not defined previously will be created at the root level.
			foreach ($post_terms as $tax=>$term) {
				if (!empty($term)) {
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
				}
				else {
					$term_id = NULL;
				}

				// Actually set the term for the post. Unset existing term if $term_id is null.
				if ($term_id) {
					wp_set_post_terms($post_id, $term_id, $tax); // replaces existing terms
					print 'Set post\'s taxonomy '.$tax.' to type '.$term.'.<br>';
				}
				else {
					wp_delete_object_term_relationships($post_id, $tax);
					print 'Unset existing post\'s taxonomy '.$tax.' terms (degree has no '.$tax.' value.)<br>';
				}
			}

			// Done.
			print 'Finished processing post '.$post_data['post_title'].'.<br><br>';
		}
		print '<br>Created/Updated '.$count.' posts.<br>';


		/**
		 * Delete any of the remaining posts in $existing_posts_array.  These posts were not
		 * updated and were not new posts, so we assume that they were deleted from the search
		 * service data, and should therefore be deleted from WordPress.
		 **/
		foreach ($existing_posts_array as $post_id) {
			$post_title = get_post($post_id)->post_title;
			wp_delete_post($post_id);
			print 'Post '.$post_title.' with ID '.$post_id.' was deleted.<br>';
		}
		print '<br>Deleted '.count($existing_posts_array).' existing posts.';

		print '<br><br><strong>Finished running degree import.</strong>  Make sure to check the newly imported degree data, including program type, college terms, and departments, look okay.';
	}
	else {
		print 'Query to the search service either failed, or no search results were found.  Is the Search Service URL set in Theme Options valid?';
	}
}
?>
