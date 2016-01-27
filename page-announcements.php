<?php

// Assign GET variables
if (isset($_GET['role']) && $_GET['role'] !== 'all') {
	$roleval = filter_var($_GET['role'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
}
if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
	$keywordval = filter_var($_GET['keyword'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
}
if (isset($_GET['time']) && $_GET['time'] !== 'thisweek') {
	$timeval = filter_var($_GET['time'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
}

$include_ongoing = 1;
if (isset($_GET['include_ongoing'])) {
	$include_ongoing = (int)$_GET['include_ongoing'];
}

$error = '';

// Set up get_announcements() args:
// default args: role='all', keyword=null, time='thisweek'
//
// (Note: sanitization is handled via Wordpress's WP_Query,
// but we're checking values here first to generate errors if
// the user enters something stupid or malicious)
if ($roleval) {
	if (preg_match('/^[a-z][\-]*/', $roleval)) { // should only be lowercase letters and dashes
		$announcements = get_announcements($roleval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Invalid Role parameter given.';
		$roleval = NULL;
	}
}
elseif ($keywordval) {
	if (preg_match('/[^a-zA-Z0-9 ]*/', $keywordval)) { // should only be letters, numbers or spaces (case insensitive)
		$announcements = get_announcements('all', $keywordval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Keywords can only contain letters, numbers and spaces. Please remove any special characters from your search and try again.';
		$keywordval = NULL;
	}
}
elseif ($timeval) {
	if (preg_match('/^[a-z]/', $timeval)) { // should only be lowercase letters
		$announcements = get_announcements('all', NULL, $timeval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Invalid Time parameter given.';
		$timeval = NULL;
	}
}
else {
	$announcements = get_announcements();
}


// We want to compare each announcement start date and end
// date with some date in the past and some date in the future,
// respectively, to see if the announcement's time span
// continues before and after those past and future dates.
// If both of these requirements are met, the announcement
// is deemed 'ongoing'.
//
// Determine what we need to compare each announcement start/
// end date against:
$start_date_comparison 	= '';
$end_date_comparison	= '';
if ($timeval) {
	switch ($timeval) {
		case 'nextweek':
			// Compare to next Monday and next Sunday
			$start_date_comparison 	= date('Ymd', strtotime('monday next week'));
			$end_date_comparison	= date('Ymd', strtotime('sunday next week'));
			break;
		case 'thismonth':
			// Compare to last day of last month and first day
			// of next month
			$start_date_comparison 	= date('Ymd', strtotime('last day last month'));
			$end_date_comparison	= date('Ymd', strtotime('first day next month'));
			break;
		case 'nextmonth':
			// Compare to last day of this month and first day
			// of two months from now
			$start_date_comparison	= date('Ymd', strtotime('last day this month'));
			$end_date_comparison	= date('Ymd', strtotime('first day of +2 months'));
			break;
		case 'thissemester':
		case 'all':
			// Don't compare anything; assume all are 'upcoming'
			break;
		default: // 'thisweek'
			// Compare to this Monday and this Sunday
			$start_date_comparison	= date('Ymd', strtotime('monday this week'));
			$end_date_comparison	= date('Ymd', strtotime('sunday this week'));
			break;
	}
}
else { // assume default 'thisweek'
	$start_date_comparison	= date('Ymd', strtotime('monday this week'));
	$end_date_comparison	= date('Ymd', strtotime('sunday this week'));
}

$ongoing 		= array();
$upcoming	 	= array();
// Make sure we need to compare start/end dates
if ($start_date_comparison && $end_date_comparison) {
	if ($announcements) {
		foreach ($announcements as $announcement) {
			// If the post start date is before the start date comparison AND continues
			// through the end date comparison, add it to the ongoing array. Otherwise,
			// add it to the upcoming array.
			// This allows an announcement to be 'upcoming' as it approaches its start
			// and end date (when, theoretically, it would be most relevant.)
			if (
				(date('Ymd', strtotime($announcement->announcementStartDate)) < $start_date_comparison) &&
				(date('Ymd', strtotime($announcement->announcementEndDate))   > $end_date_comparison)
			) {
				$ongoing[$announcement->ID] = $announcement;
			}
			else {
				$upcoming[$announcement->ID] = $announcement;
			}
		}
	}
}
else {
	// Make sure that we have a fallback for queries with a $timeval that
	// doesn't separate ongoing/upcoming announcements (thissemester, all)
	// combined with a $include_ongoing val of 0
	$upcoming = $announcements;
}


// Set up a human-readable 'results for' line at the top of the page:
$resultsfor_timespan = 'this week';
$resultsfor_subject = '';
if ($roleval && $roleval !== 'all') {
	$resultsfor_subject = ucfirst($roleval).' ';
	$resultsfor_timespan = '(this week)';
}
elseif ($keywordval) {
	$resultsfor_subject = '&ldquo;'.$keywordval.'&rdquo; ';
	$resultsfor_timespan = '(this week)';
}
elseif ($timeval && $timeval !== 'thisweek') {
	switch ($timeval) {
		case 'nextweek':
			$resultsfor_timespan = 'next week';
			break;
		case 'thismonth':
			$resultsfor_timespan = 'this month';
			break;
		case 'nextmonth':
			$resultsfor_timespan = 'next month';
			break;
		case 'thissemester':
			$resultsfor_timespan = 'this semester';
			break;
		case 'all':
			$resultsfor_timespan = '(all results)';
			break;
	}
}
$resultsfor = 'Results for: <span class="upcoming-header-alt">'.$resultsfor_subject.$resultsfor_timespan.'</span>';



// Set up feed output based on GET params:
if ( isset($_GET['output']) ) {
	if ($include_ongoing == 1) {
		switch ($_GET['output']) {
			case 'json':
				header('Content-Type: application/json');
				print json_encode($announcements);
				break;
			case 'rss':
				announcements_to_rss($announcements);
				break;
			default:
				break;
		}
	}
	else {
		switch ($_GET['output']) {
			case 'json':
				header('Content-Type: application/json');
				print json_encode($upcoming);
				break;
			case 'rss':
				announcements_to_rss($upcoming);
				break;
			default:
				break;
		}
	}
}
else {
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="col-md-12 col-sm-12">
			<div id="page-title">
				<div class="row">
					<div class="col-md-9 col-sm-9">
						<h1><?php the_title(); ?></h1>
					</div>
					<?php esi_include( 'output_weather_data', 'col-md-3 col-sm-3' ); ?>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12" id="contentcol">
			<article role="main">
				<div class="row" id="filters">
					<form id="filter_form" action="">

						<div class="col-md-3 col-sm-4" id="filter_wrap">
							<label for="filter">Filter Results by...</label>
							<div class="btn-group" id="filter" data-toggle="buttons">
								<label class="btn btn-default <?php if ($roleval || (!($roleval) && !($keywordval) && !($timeval))) { ?>active<?php } ?>">
									<input type="radio" id="filter_audience" name="filter" <?php if ($roleval || (!($roleval) && !($keywordval) && !($timeval))) { ?>checked<?php } ?>>Audience</button>
								</label>
								<label class="btn btn-default  <?php if ($keywordval) { ?>active<?php } ?>">
									<input type="radio" id="filter_keyword" name="filter" <?php if ($keywordval) { ?>checked<?php } ?>>Keyword</button>
								</label>
								<label class="btn btn-default <?php if ($timeval) { ?>active<?php } ?>">
									<input type="radio" id="filter_time" name="filter" <?php if ($timeval) { ?>checked<?php } ?>>Time</button>
								</label>
							</div>
						</div>

						<div class="col-md-5 col-sm-4">

							<div class="row">

								<div class="col-md-8 col-xs-8 active_filter" id="filter_audience_wrap">
									<div class="form-group">
										<label for="role">Select an Audience</label>
										<select name="role" class="form-control">
											<option value="all">All Roles</option>
											<?php
												$args = array(
													'hide_empty' => 0
												);
												$roles = get_terms('audienceroles', $args);
												foreach ($roles as $role) {
													print '<option ';
													if ($role->slug == $roleval) {
														print 'selected="" ';
													}
													print 'value="'.$role->slug.'">'.$role->name.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-8 col-xs-8" id="filter_keyword_wrap">
									<div class="form-group">
										<label for="keyword">Type a Keyword</label>
										<input type="text" name="keyword" class="form-control" <?php if ($keywordval) { ?>placeholder="<?=$keywordval?>"<?php } ?> >
									</div>
								</div>
								<div class="col-md-8 col-xs-8" id="filter_time_wrap">
									<div class="form-group">
										<label for="time">Select a Time</label>
										<select name="time" class="form-control">
											<option <?php if ($timeval == 'thisweek') { ?>selected=""<?php } ?>value="thisweek">This Week</option>
											<option <?php if ($timeval == 'nextweek') { ?>selected=""<?php } ?>value="nextweek">Next Week</option>
											<option <?php if ($timeval == 'thismonth') { ?>selected=""<?php } ?>value="thismonth">This Month</option>
											<option <?php if ($timeval == 'nextmonth') { ?>selected=""<?php } ?>value="nextmonth">Next Month</option>
											<option <?php if ($timeval == 'thissemester') { ?>selected=""<?php } ?>value="thissemester">This Semester</option>
											<option <?php if ($timeval == 'all') { ?>selected=""<?php } ?>value="all">All</option>
										</select>
									</div>
								</div>

								<div class="col-md-4 col-xs-4">
									<input type="submit" class="btn btn-default" value="View" id="filter_update">
								</div>

							</div>

						</div>
						<div class="col-md-4 col-sm-4" id="addnew_wrap">
							<a class="btn btn-primary" id="addnew_announcement" href="post-an-announcement"><span class="glyphicon glyphicon-pencil glyphicon-white"></span> Post an Announcement</a>
						</div>

					</form>
				</div>

				<?php the_content();?>

				<?php if ($error !== '') { echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; } ?>

				<?php
					if ($announcements == NULL) {
						echo '<h2 id="upcoming-header">'.$resultsfor.'</h2>';
						echo 'No announcements found.';
					} else {
						// Output upcoming and ongoing events separately
						if (!empty($upcoming) && empty($ongoing)) {
					?>
						<div class="row">
							<div class="col-md-12 col-sm-12" id="upcoming-onecol">
								<h2 id="upcoming-header"><?=$resultsfor?></h2>
								<?php echo print_announcements( $upcoming, 'thumbtacks', 'col-md-6 col-sm-6', 2 );?>
						</div>
					<?php
						} else { ?>
						<div class="row">
							<div class="col-md-8 col-sm-8" id="upcoming-twocol">
								<h2 id="upcoming-header"><?=$resultsfor?></h2>
								<?php echo (!empty($upcoming)) ? print_announcements( $upcoming, 'thumbtacks', 'col-md-6 col-sm-6', 2 ) : '<p>No upcoming announcements found.</p>'; ?>
						</div>

						<div class="col-md-3 col-sm-3 col-md-offset-1 col-sm-offset-1" id="ongoing-twocol">
							<h2 id="ongoing-header">Ongoing Announcements</h2>
							<?php echo (!empty($ongoing)) ? print_announcements($ongoing, 'list') : '<p>No ongoing announcements found.</p>'; ?>
						</div>
					<?php
						}
					}
				?>

			</article>
		</div>
	</div>
<?php get_footer();
}
?>
