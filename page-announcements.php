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
						print '<div class="row">';
						
						$count = 0;
						foreach ($announcements as $announcement) {
							if ($count % 3 == 0 && $count !== 0) { // 3 announcements per row
								print '</div><div class="row">';
							}
						?>
							<div class="span4" id="announcement_<?=$announcement['post_id']?>">
								<div class="announcement_wrap">
									<div class="thumbtack"></div>
									<?php if ( date('Ymd') - date('Ymd', strtotime($announcement['post_published']) ) <= 2 ) { ?><div class="new">New Announcement</div><?php } ?>
									<h3><a href="<?=$announcement['post_permalink']?>"><?=$announcement['post_title']?></a></h3>
									<p class="date"><?=date('M d', strtotime($announcement['start_date']))?> - <?=date('M d', strtotime($announcement['end_date']))?></p>
									<p><?=truncateHtml($announcement['post_content'], 200)?></p>
									<p class="audience"><strong>Audience:</strong> 
									<?php 
										if ($announcement['roles']) {
											$rolelist = '';
											foreach ($announcement['roles'] as $role) {
												switch ($role) {
													case 'Alumni':
														$link = '?role=alumni';
														break;
													case 'Faculty':
														$link = '?role=faculty';
														break;
													case 'Prospective Students':
														$link = '?role=prospective-students';
														break;
													case 'Public':
														$link = '?role=public';
														break;
													case 'Staff':
														$link = '?role=staff';
														break;
													case 'Students':
														$link = '?role=students';
														break;
													default:
														$link = '';
														break;
												}
												$rolelist .= '<a href="'.get_permalink().$link.'">'.$role.'</a>, ';
											}
											print substr($rolelist, 0, -2);
										}
										else { print 'n/a'; }
									?>
									</p>
									<p class="keywords"><strong>Keywords:</strong> 
									<?php 
										if ($announcement['keywords']) {
											$keywordlist = '';
											foreach ($announcement['keywords'] as $keyword) {
												$keywordlist .= '<a href="'.get_permalink().'?keyword='.$keyword.'">'.$keyword.'</a>, ';
											}
											print substr($keywordlist, 0, -2);
										}
										else { print 'n/a'; }
									?>
									</p>
									
									
									<p><?=$announcement['debug']?></p>
									
									
								</div>
							</div>	
						<?php
							$count++;
						} // endforeach
						
						print '</div>';
					} // endif ($announcements == NULL)
				?>
				
			</article>
		</div>
	</div>
<?php get_footer();
} 
?>