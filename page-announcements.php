<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?=output_weather_data('span3')?>
		</div>
		
		<div class="span12" id="contentcol">
			<article>
				<div class="row">
					<h2 class="span9 header_announcements">Announcements for this week | <a href="http://events.ucf.edu/">Go to Events &raquo;</a></h2>
					<div class="span3">
						<p><a class="rssbtn" href="?feed=rss">RSS</a></p>
					</div>
				</div>
				<div class="row" id="filters">
					<div class="span4" id="filter_wrap">
						<label for="filter">Filter Results by...</label>
						<div class="btn-group" id="filter" data-toggle="buttons-radio">
							<button type="button" id="filter_audience" class="btn active">Audience</button>
							<button type="button" id="filter_keyword" class="btn">Keyword</button>
							<button type="button" id="filter_time" class="btn">Time</button>
						</div>
					</div>
					
					<div class="span3">	
						<label for="f_role">Select an Audience</label>
						<select name="f_role" class="span3">
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
					<div class="span3">	
						<label for="f_keyword">Type a Keyword</label>
						<input type="text" name="f_keyword" class="span3" />
					</div>
					<div class="span3">	
						<label for="f_duration">Select a Time</label>
						<select name="f_duration" class="span3">
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
					<div class="span3" id="addnew_wrap">
						<a class="btn btn-primary" id="addnew_announcement" href="post-an-announcement">Post an Announcement</a>
					</div>
				</div>
				
				<?php the_content();?>
				
				<?php
					// default params: role='all', keyword=null, time='thisweek' 
					
					$announcements = get_announcements();
					
					foreach ($announcements as $announcement) {
						print "<strong>Modified Date:</strong> ".$announcement->post_modified."<br/>";
						print "<strong>Title:</strong> ".$announcement->post_title."<br/>";
						print "<strong>Start Date:</strong> ".get_post_meta($announcement->ID, 'announcement_start_date', TRUE)."<br/>";
						print "<strong>End Date:</strong> ".get_post_meta($announcement->ID, 'announcement_end_date', TRUE)."<br/>";
						print "<strong>Roles (Audience):</strong> ";
						foreach ( wp_get_post_terms($announcement->ID, 'audienceroles', array("fields" => "names")) as $term ) {
							print $term.", ";
						}
						print "<br/>";
						print "<strong>Keywords:</strong> ";
						foreach ( wp_get_post_terms($announcement->ID, 'keywords', array("fields" => "names")) as $term ) {
							print $term.", ";
						}
						print "<br/>";
						print "<hr />";
					}
				?>
				
				
			</article>
		</div>
	</div>
<?php get_footer();?>