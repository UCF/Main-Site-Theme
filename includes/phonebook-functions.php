<?php
/**
 * Responsible for phonebook related functionality
 **/

/**
 * Retrieves teledata results from the search service
 * @author Jim Barnes
 * @since 3.0.0
 * @param $query string | The provided search query
 * @return Array | An array of results
 **/
function get_phonebook_results( $query ) {
	if ( empty( $query ) ) {
		return false;
	}

	$url = get_theme_mod_or_default( 'search_service_url' );

	$params = array(
		'search' => $query,
		'active' => 'True'
	);

	$response = wp_remote_get( $url . '?' . http_build_query( $params ) );

	$results = array();

	if ( is_array( $response ) ) {
		$results = json_decode( wp_remote_retrieve_body( $response ) );

		// Force cast empty values to array;
		// the search service can sometimes return null here
		$results = $results->results ?: array();
	}

	if ( empty( $results ) ) {
		return $results;
	}

	// Filter out unwanted results
	$results = filter_phonebook_results( $results );

	// Group results by organizations and departments
	$organizations = array();
	$departments = array();

	group_phonebook_results( $results, $organizations, $departments );

	$results = phonebook_deduplicate_staff( $results );

	$results = array(
		'total_results' => count( $organizations ) + count( $departments ) + count( $results ),
		'organizations' => $organizations,
		'departments'   => $departments,
		'staff'         => $results
	);

	return $results;
}

/**
 * Filters out results we don't want
 * @author Jim Barnes
 * @since 1.0.0
 * @param $results Array | The array of results
 * @return Array | The filtered array of results
 **/
function filter_phonebook_results( $results ) {
	$results = array_filter( $results, 'phonebook_filter_tables' );

	foreach( $results as $result ) {
		$result->email = trim( $result->email );
	}

	$results = array_filter( $results, 'phonebook_filter_fax_in_name' );

	return $results;
}

/**
 * Groups the results by organization and department
 * @author Jim Barnes
 * @since 3.0.0
 * @param $results Array | Passed by ref, the results array.
 * @param $organizations Array | Passed by ref, the organizations array
 * @param $departments Array | Passed by ref, the departments array
 **/
function group_phonebook_results( &$results, &$organizations, &$departments ) {
	foreach( $results as $key => $result ) {
		$is_org = ( $result->from_table === 'organizations' );
		$is_dept = ( $result->from_table === 'departments' );

		if ( $is_org || $is_dept ) {
			$result->staff = array();
			$emails = array();

			foreach( $results as $_result ) {
				if ( ( $_result->from_table === 'staff' ) &&
					( ! in_array($_result->email, $emails ) ) &&
					( phonebook_result_is_in_group( $result, $_result, $is_org ) )
				) {
					$emails[] = $_result->email;
					$result->staff[$_result->last_name . '-' . $_result->first_name . '-' . $_result->id] = $_result;
				}
			}

			ksort( $result->staff );
		}

		if ( $is_org ) {
			$organizations[] = $result;
			unset( $results[$key] );
		}

		if ( $is_dept ) {
			$departments[] = $result;
			unset( $results[$key] );
		}
	}
}

/**
 * Deduplicate staff records with multiple emails
 * @author Jim Barnes
 * @since 3.0.0
 * @param $results Array | The object of results
 * @return Array | The deduplicated array of results
 **/
function phonebook_deduplicate_staff( $results ) {
	foreach( $results as $key => $result ) {
		if ( $result->from_table === 'staff' ) {
			foreach( $results as $_key => $_result ) {
				// Deduplicate on email
				if (
					( ! empty( $result->email ) ) &&
					( ! empty( $_result->email ) ) &&
					( $result !== $_result ) &&
					( $result->email === $_result->email )
				) {
					$_result->secondary[] = $result;
					unset( $results[$key] );
				}
			}
		}
	}

	return $results;
}

/**
 * Determines if the result is a member of an organization or department
 * @author Jim Barnes
 * @since 3.0.0
 * @param $group Object | The group result
 * @param $result Object | The staff result
 * @param $org boolean | True if organization, false if department
 **/
function phonebook_result_is_in_group( $group, $result, $org ) {
	if ( $org ) {
		return ( $group->id === $result->org_id );
	}

	// This is not an org, check department
	return ( $group->id === $result->dept_id );
}

/**
 * Determines of the result is something we understand
 * based on what table is comes from.
 * @author Jim Barnes
 * @since 3.0.0
 * @param $result Object | The phonebook result
 * @return boolean
 **/
function phonebook_filter_tables( $result ) {
	return in_array( $result->from_table, array(
		"organizations",
		"departments",
		"staff"
	) );
}

/**
 * Determines if the word 'fax' is in the result name
 * @author Jim Barnes
 * @since 3.0.0
 * @param $result Object | The phonebook result
 * @return boolean
 **/
function phonebook_filter_fax_in_name( $result ) {
	return (preg_match( "/^fax\s/i", $result->name ) ||
		   preg_match( "/\sfax\s/i", $result->name ) ||
		   preg_match( "/\sfax$/i", $result->name) ) ? false : true;
}

/**
 * Formats the result for output to the page.
 * @author Jim Barnes
 * @since 3.0.0
 * @param $result Array | The result from the search service
 * @return string | The html output
 **/
function format_phonebook_result( $result ) {
	$is_org = ( $result->from_table === 'organizations' );
	$is_dept = ( $result->from_table === 'departments' );
	$is_group = ( $is_org || $is_dept );

	$unique_slug = sanitize_title( str_replace( ' ', '-', $result->name ) . $result->id );

	$class = $is_group ? 'result group-result' : 'result';

	ob_start();
?>
	<li class="<?php echo $class; ?>">
		<div class="card-block pb-3 pt-sm-4 px-sm-4">
			<div class="row">
				<div class="col-lg-5 pr-lg-4 mb-3">
					<?php echo format_phonebook_result_primary( $result, $is_dept, $is_org, $is_group ); ?>
				</div>
				<div class="col-lg-3">
					<?php echo format_phonebook_result_contact( $result, $is_dept, $is_org, $is_group ); ?>
				</div>
				<div class="col-lg-4">
					<?php echo format_phonebook_result_location( $result, $is_dept, $is_org, $is_group ); ?>
				</div>
			</div>
		</div>

		<?php if ( ! $is_group && ( ! empty( $result->secondary ) ) ) : ?>
		<div class="card-block pt-0 px-sm-4">
			<a href="#<?php echo $unique_slug; ?>" class="toggle collapsed btn btn-sm btn-outline-secondary mb-2" data-toggle="collapse" data-target="#<?php echo $unique_slug; ?>">
				<span class="fa fa-plus" aria-hidden="true"></span>
				<span class="fa fa-minus" aria-hidden="true"></span> More Results
			</a>
			<div class="collapse w-100" id="<?php echo $unique_slug; ?>">
				<ul class="list-unstyled pt-3">
				<?php foreach( $result->secondary as $secondary ) : ?>
					<li>
						<div class="row mb-2">
							<div class="col-lg-5 pr-lg-4 mb-3">
								<?php echo format_phonebook_result_primary( $secondary, false, false, false ); ?>
							</div>
							<div class="col-lg-3">
								<?php echo format_phonebook_result_contact( $secondary, false, false, false ); ?>
							</div>
							<div class="col-lg-4">
								<?php echo format_phonebook_result_location( $secondary, false, false, false ); ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php elseif ( $is_group && ( count( $result->staff ) > 0 ) ) : ?>
		<div class="card-block pt-0 px-sm-4">
			<a href="#<?php echo $unique_slug; ?>" class="toggle collapsed btn btn-sm btn-outline-secondary mb-2" data-toggle="collapse" data-target="#<?php echo $unique_slug; ?>" >
				<span class="fa fa-plus" aria-hidden="true"></span>
				<span class="fa fa-minus" aria-hidden="true"></span> Show Staff
			</a>
		</div>
		<div class="collapse" id="<?php echo $unique_slug; ?>">
			<ul class="staff-list row no-gutters list-unstyled w-100">
				<?php foreach( $result->staff as $person ) : ?>
					<li class="col-sm-6 col-lg-4 p-3 p-sm-4">
						<?php if ( $person->email ) : ?>
							<span class="email d-block mb-2"><a href="?query=<?php echo urlencode( $person->email ); ?>"><?php echo $person->name; ?></a></span>
						<?php else : ?>
							<span class="name d-block mb-2"><?php echo $person->name; ?></span>
						<?php endif; ?>

						<?php if ( $person->job_position ) : ?>
							<span class="title text-muted d-block mb-2"><?php echo $person->job_position; ?></span>
						<?php endif; ?>

						<?php if ( $person->phone && $person->phone !== '000-000-0000' ) : ?>
							<span class="phone d-block mb-2"><a href="tel:<?php echo str_replace( '-', '', $person->phone ); ?>"><?php echo $person->phone; ?></a></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
	</li>
<?php
	return ob_get_clean();
}

/**
 * Outputs the primary info for the result
 * @author Jim Barnes
 * @since 3.0.0
 * @param $result Object | The phonebook result
 * @param $is_dept boolean | True, if the result is a department
 * @param $is_org boolean | True, if the result is an organization
 * @param $is_group boolean | True, if the result is a department or organization
 * @return string | The html markup
 **/
function format_phonebook_result_primary( $result, $is_dept, $is_org, $is_group ) {
	ob_start();
?>
	<div class="mb-3">
		<span class="name d-block"><?php echo $result->name; ?></span>
		<?php if ( $result->job_position ) : ?>
			<span class="job-title d-block text-muted mt-2"><?php echo $result->job_position; ?></span>
		<?php endif; ?>
	</div>

	<?php if ( $is_dept && $result->organization ) : ?>
	<span class="division d-block mb-3">
		A division of: <a href="?query=<?php echo urlencode( $result->organization ); ?>#phonebook-organizations"><?php echo phonebook_fix_name_case( $result->organization ); ?></a>
	</span>
	<?php endif; ?>

	<?php if ( ! $is_group && $result->email ): ?>
	<span class="email d-block mb-3">
		<a href="mailto:<?php echo $result->email; ?>">
			<span class="fa fa-envelope mr-1" aria-hidden="true"></span>Email
			<span class="sr-only"> <?php echo $result->email; ?></span>
		</a>
	</span>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

/**
 * Outputs the location info for the result
 * @author Jim Barnes
 * @since 3.0.0
 * @param $result Object | The phonebook result
 * @param $is_dept boolean | True, if the result is a department
 * @param $is_org boolean | True, if the result is an organization
 * @param $is_group boolean | True, if the result is a department or organization
 * @return string | The html markup
 **/
function format_phonebook_result_location( $result, $is_dept, $is_org, $is_group ) {
	ob_start();
?>
	<?php if ( $result->building ) : ?>
		<div class="row">
			<div class="col-3 col-md-12 mb-2">
				<span class="result-label text-default-aw text-uppercase">Location</span>
			</div>
			<div class="col-9 col-md-12 mb-3">
				<span class="location">
					<a href="https://map.ucf.edu/?show=<?php echo $result->bldg_id; ?>" aria-label="Location">
						<?php echo phonebook_fix_name_case( $result->building ); ?>
						<?php if ( $result->room ) : ?>
							<?php echo ' - ' . $result->room; ?>
						<?php endif; ?>
					</a>
				</span>
			</div>
		</div>
	<?php endif; ?>
	<?php if ( $result->postal ) : ?>
	<div class="row">
		<div class="col-3 col-md-12 mb-2">
			<span class="result-label text-default-aw text-uppercase">Postal Code</span>
		</div>
		<div class="col-9 col-md-12 mb-3">
			<span class="postal" aria-label="Postal Code">
				<?php echo $result->postal; ?>
			</span>
		</div>
	</div>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

/**
 * Outputs the contact info for the result
 * @author Jim Barnes
 * @since 3.0.0
 * @param $result Object | The phonebook result
 * @param $is_dept boolean | True, if the result is a department
 * @param $is_org boolean | True, if the result is an organization
 * @param $is_group boolean | True, if the result is a department or organization
 * @return string | The html markup
 **/
function format_phonebook_result_contact( $result, $is_dept, $is_org, $is_group ) {
	ob_start();
?>
	<?php if ( ! $is_group && $result->department ): ?>
		<div class="row">
			<div class="col-3 col-md-12 mb-2">
				<span class="result-label text-default-aw text-uppercase">Department</span>
			</div>
			<div class="col-9 col-md-12 mb-3">
				<span class="department">
					<a href="?query=<?php echo urlencode( $result->department ); ?>#phonebook-departments"><?php echo phonebook_fix_name_case( $result->department ); ?></a>
				</span>
			</div>
		</div>
	<?php endif; ?>
		<div class="row">
			<div class="col-3 col-md-12 mb-2">
				<span class="result-label text-default-aw text-uppercase">Phone</span>
			</div>
			<div class="col-9 col-md-12 mb-3">
				<span class="phone">
				<?php if ( $result->phone === '000-000-0000' || empty( $result->phone ) ) : ?>
					N/A
				<?php elseif ( $result->phone ) : ?>
					<a href="tel:<?php echo str_replace( '-', '', $result->phone ); ?>" aria-label="Phone"><?php echo $result->phone; ?></a>
				<?php endif; ?>
				</span>
			</div>
		</div>
	<?php if ( $is_group && $result->fax ) : ?>
		<div class="row">
			<div class="col-3 col-md-12 mb-2">
				<span class="result-label text-default-aw text-uppercase">Fax</span>
			</div>
			<div class="col-9 col-md-12 mb-3">
				<span class="fax" aria-label="Fax">
					<?php echo $result->fax; ?>
				</span>
			</div>
		</div>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

/**
 * Helper function for naming consistencies
 * @author Jim Barnes
 * @since 3.0.0
 * @param $name string | The name to normalize
 * @return string | The normalized name
 **/
function phonebook_fix_name_case( $name ) {
	$str_replace = array(
		'Ucf' => 'UCF',
		'dr.' => 'Dr.',
		'alumni' => 'Alumni',
		' And ' => ' and ',
		'Cosas' => 'COSAS',
		'Creol' => 'CREOL',
		'Lead Scholars' => 'LEAD Scholars',
		'Rotc' => 'ROTC',
		' Of ' => ' of ',
		' For ' => ' for ',
		'&public' => '&amp; Public',
		'Student-athletes' => 'Student Athletes',
		'Wucf' => 'WUCF',
		'WUCF Tv' => 'WUCF TV',
		'WUCF-fm' => 'WUCF-FM',
		'It' => 'IT'
	);

	$regex = array(
		'/\bSdes\b/' => 'SDES',
		'/\sOf$/' => ' of',
		'/\sFor$/' => ' for'
	);

	$name = ucwords( strtolower( $name ), " \t\r\n\f\v/" );

	foreach( $str_replace as $key => $val ) {
		$name = str_replace( $key, $val, $name );
	}

	foreach( $regex as $key => $val ) {
		$name = preg_replace( $key, $val, $name );
	}

	$name = preg_replace_callback( '/\([a-z]+\)/', function( $m ) { return strtoupper($m[0]); }, $name );
	$name = preg_replace_callback( '/\([a-z]{1}/', function( $m ) { return strtoupper($m[0]); }, $name );

	return $name;
}
