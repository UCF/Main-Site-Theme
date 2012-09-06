<?php

// Set up get_announcements() args:
// default args: role='all', keyword=null, time='thisweek'

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
	if (preg_match('/^[a-zA-Z0-9]/', $keywordval)) { // should only be letters & numbers
		$announcements = get_announcements('all', $keywordval);
	}
	else {
		$announcements = get_announcements();
		$error = '<strong>Error:</strong> Keywords can only contain letters and numbers.';
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

// Set up feed output:
if ( isset($_GET['output']) ) {
	switch ($_GET['output']) {
		case 'json':
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
			<?=output_weather_data('span3')?>
		</div>
		
		<div class="span12" id="contentcol">
			<article>
				<div class="row">
					<h2 class="span9 header_announcements">
					<?php
						switch ($timeval) {
							case 'thisweek':
								$headertext = 'Announcements for this week';
								break;
							case 'nextweek':
								$headertext = 'Announcements for next week';
								break;
							case 'thismonth':
								$headertext = 'Announcements for this month';
								break;
							case 'nextmonth':
								$headertext = 'Announcements for next month';
								break;
							case 'thissemester':
								$headertext = 'Announcements for this semester';
								break;
							case 'all':
								$headertext = 'All Announcements';
								break;
							default:
								$headertext = 'Announcements for this week';
								break;
						}
						print $headertext;
					?> 
						| <a href="http://events.ucf.edu/">Go to Events &raquo;</a></h2>
					<div class="span3">
						<p><a class="rssbtn" href="?output=rss">RSS</a></p>
					</div>
				</div>
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
							<option selected="" value="all">All Roles</option>
							<?php
								$args = array(
									'hide_empty' => 0
								);
								$roles = get_terms('audienceroles', $args);
								foreach ($roles as $role) {
									print '<option value="'.$role->slug.'">'.$role->name.'</option>';
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
							<option selected="" value="thisweek">This Week</option>
							<option value="nextweek">Next Week</option>
							<option value="thismonth">This Month</option>
							<option value="nextmonth">Next Month</option>
							<option value="thissemester">This Semester</option>
							<option value="all">All</option>
						</select>
					</div>
					
					<div class="span1">	
						<input type="submit" class="btn" value="View" id="filter_update">
					</div>
					</form>
					<div class="span3" id="addnew_wrap">
						<a class="btn btn-primary" id="addnew_announcement" href="post-an-announcement">Post an Announcement</a>
					</div>
				</div>
				
				<?php the_content();?>
				
				<?php if ($error !== '') { print '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$error.'</div>'; } ?>
				
				<?php 
					if ($announcements == NULL) { 
						print 'No announcements found.'; 
					} else { 
						print '<div class="row">';
						
						foreach ($announcements as $announcement) {
						?>
							<div class="span4" id="announcement_<?=$announcement['post_id']?>">
								<div class="announcement_wrap">
									<div class="thumbtack"></div>
									<h3><a href="<?=$announcement['post_permalink']?>"><?=$announcement['post_title']?></a></h3>
									<p><?=truncateHtml($announcement['post_content'], 200)?></p>
								</div>
							</div>	
						<?php
						}
						
						print '</div>';
					} 
				?>
				
				
			</article>
		</div>
	</div>
<?php get_footer();
} 
?>