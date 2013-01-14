<?php

// Assign GET variables
if (isset($_GET['role']) && $_GET['role'] !== 'all') {
	$roleval = $_GET['role'];
}
if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
	$keywordval = $_GET['keyword'];
}
if (isset($_GET['time']) && $_GET['time'] !== 'thisweek') {
	$timeval = $_GET['time'];
}
 
$error = ''; 

// Set up get_announcements() args:
// default args: role='all', keyword=null, time='thisweek' 
if ($roleval) {
	if (preg_match('/^[a-z][\-]*/', $roleval)) { // should only be lowercase letters and dashes
		$announcements = get_announcements($roleval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Invalid Role parameter given.';
	}
}
elseif ($keywordval) {
	if (ctype_alnum($keywordval) == true) { // should only be letters or numbers
		$announcements = get_announcements('all', $keywordval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Keywords can only contain letters and numbers. Please remove any special characters from your search and try again.';
	}
}
elseif ($timeval) { 
	if (preg_match('/^[a-z]/', $timeval)) { // should only be lowercase letters
		$announcements = get_announcements('all', NULL, $timeval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Invalid Time parameter given.';
	}
}
else {
	$announcements = get_announcements();
}

// Set up feed output based on GET params:
if ( isset($_GET['output']) ) {
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
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data(\'span3\');'); ?>
		</div>
		
		<div class="span12" id="contentcol">
			<article role="main">
				<div class="row" id="filters">
					<form id="filter_form" action="">
					<div class="span4" id="filter_wrap">
						<label for="filter">Filter Results by...</label>
						<div class="btn-group" id="filter" data-toggle="buttons-radio">
							<button type="button" id="filter_audience" class="btn <?php if ($roleval || (!($roleval) && !($keywordval) && !($timeval))) { ?>active<?php } ?>">Audience</button>
							<button type="button" id="filter_keyword" class="btn <?php if ($keywordval) { ?>active<?php } ?>">Keyword</button>
							<button type="button" id="filter_time" class="btn <?php if ($timeval) { ?>active<?php } ?>">Time</button>
						</div>
					</div>
					
					<div class="span3 active_filter" id="filter_audience_wrap">	
						<label for="role">Select an Audience</label>
						<select name="role" class="span3">
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
					<div class="span3" id="filter_keyword_wrap">	
						<label for="keyword">Type a Keyword</label>
						<input type="text" name="keyword" class="span3" <?php if ($keywordval) { ?>placeholder="<?=$keywordval?>"<?php } ?> />
					</div>
					<div class="span3" id="filter_time_wrap">	
						<label for="time">Select a Time</label>
						<select name="time" class="span3">
							<option <?php if ($timeval == 'thisweek') { ?>selected=""<?php } ?>value="thisweek">This Week</option>
							<option <?php if ($timeval == 'nextweek') { ?>selected=""<?php } ?>value="nextweek">Next Week</option>
							<option <?php if ($timeval == 'thismonth') { ?>selected=""<?php } ?>value="thismonth">This Month</option>
							<option <?php if ($timeval == 'nextmonth') { ?>selected=""<?php } ?>value="nextmonth">Next Month</option>
							<option <?php if ($timeval == 'thissemester') { ?>selected=""<?php } ?>value="thissemester">This Semester</option>
							<option <?php if ($timeval == 'all') { ?>selected=""<?php } ?>value="all">All</option>
						</select>
					</div>
					
					<div class="span1">	
						<input type="submit" class="btn" value="View" id="filter_update">
					</div>
					</form>
					<div class="span3" id="addnew_wrap">
						<a class="btn btn-primary" id="addnew_announcement" href="post-an-announcement"><i class="icon-pencil icon-white"></i> Post an Announcement</a>
					</div>
				</div>
				
				<?php the_content();?>
				
				<?php if ($error !== '') { print '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; } ?>
				
				<?php 
					if ($announcements == NULL) { 
						print 'No announcements found.'; 
					} else { 
						$start_date_comparison 	= '';
						$end_date_comparison	= '';
						// We want to compare each announcement start date and end
						// date with some date in the past and some date in the future, 
						// respectively, to see if the announcement's time span
						// continues before and after those past and future dates.
						// If both of these requirements are met, the announcement
						// is deemed 'ongoing'.
						//
						// Determine what we need to compare each announcement start/
						// end date against:
						if ($timeval) {
							switch ($timeval) {
								case 'nextweek':
									// Compare to this Monday and next Sunday
									$start_date_comparison 	= date('Ymd', strtotime('next monday'));
									$end_date_comparison	= date('Ymd', strtotime('next sunday')); 
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
									// Compare to last Monday and this Sunday
									$start_date_comparison	= date('Ymd', strtotime('this monday'));
									$end_date_comparison	= date('Ymd', strtotime('this sunday'));
									break;
							}
						}
						else { // assume default 'thisweek'
							$start_date_comparison	= date('Ymd', strtotime('this monday'));
							$end_date_comparison	= date('Ymd', strtotime('this sunday'));						
						}
						
						$ongoing = array();	
						foreach ($announcements as $announcement) {
							// Make sure we need to compare start/end dates
							if ($start_date_comparison && $end_date_comparison) {
								// If the post start date is before the start date comparison AND continues 
								// through the end date comparison, add it to the ongoing array and remove
								// from the main array of announcement results (it is 'ongoing').
								// This allows an announcement to be 'upcoming' as it approaches its start
								// and end date.
								if ( 
									(date('Ymd', strtotime($announcement['startDate'])) < $start_date_comparison) && 
									(date('Ymd', strtotime($announcement['endDate'])) 	> $end_date_comparison)
								) {
									$ongoing[$announcement['id']] = $announcement;
									unset($announcements[$announcement['id']]);
								}
							}
						} // endforeach
						
						// Output upcoming and ongoing events separately
						if (!empty($announcements)) { 
							print_announcements($announcements);
						}
						if (!empty($ongoing)) { ?>
							<h2 id="ongoing-header">Ongoing Announcements</h2>
							<?php	
							print_announcements($ongoing);
						}
					} // endif ($announcements == NULL)
				?>
				
			</article>
		</div>
	</div>
<?php get_footer();
} 
?>