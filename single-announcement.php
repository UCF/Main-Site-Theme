<?php disallow_direct_load('single-announcement.php');?>
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
		<div id="contentcol" class="col-md-12 col-sm-12">
			<article role="main">
				<p><a href="<?=get_permalink(get_page_by_title('Announcements', OBJECT, 'page')->ID)?>">&laquo; Back to Announcements</a></p>
				<div class="row" id="announcement_meta">
					<div class="col-md-7 col-sm-7">
						<p class="date">
						<?php
							$fromdate = get_post_meta($post->ID, 'announcement_start_date', TRUE) ? date('M d, Y', strtotime(get_post_meta($post->ID, 'announcement_start_date', TRUE))) : get_the_date('M d, Y', $post->ID);
							$todate = get_post_meta($post->ID, 'announcement_end_date', TRUE) ? date('M d, Y', strtotime(get_post_meta($post->ID, 'announcement_end_date', TRUE))) : date('M d, Y', strtotime(get_the_date('M d, Y', $post->ID).' + 1 day'));
						?>
						<?=$fromdate?> to <?=$todate?>
						</p>
					</div>
					<div class="col-md-5 col-sm-5">
						<p class="audience"><strong>Audience:</strong>
						<?php
							$roles = wp_get_post_terms($post->ID, 'audienceroles', array("fields" => "names"));
							if ($roles) {
								$rolelist = '';
								foreach ($roles as $role) {
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
									$rolelist .= '<a href="'.get_permalink(get_page_by_title('Announcements', OBJECT, 'page')->ID).$link.'">'.$role.'</a>, ';
								}
								print substr($rolelist, 0, -2);
							}
							else { print 'n/a'; }
						?>
						</p>
						<p class="keywords"><strong>Keywords:</strong>
						<?php
							$keywords = wp_get_post_terms($post->ID, 'keywords', array("fields" => "names"));
							if ($keywords) {
								$keywordlist = '';
								foreach ($keywords as $keyword) {
									$keywordlist .= '<a href="'.get_permalink(get_page_by_title('Announcements', OBJECT, 'page')->ID).'?keyword='.$keyword.'">'.$keyword.'</a>, ';
								}
								print substr($keywordlist, 0, -2);
							}
							else { print 'n/a'; }
						?>
						</p>
					</div>
				</div>

				<strong>Description: </strong>
				<?=the_content();?>

				<table class="table">
					<tbody>
						<tr>
							<td class="url_head"><strong>URL: </strong></td>
							<td class="url">
								<?php if (get_post_meta($post->ID, 'announcement_url', TRUE)) { ?>
								<a href="<?=get_post_meta($post->ID, 'announcement_url', TRUE)?>"><?=get_post_meta($post->ID, 'announcement_url', TRUE)?></a>
								<?php } else { ?>
								n/a
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="contact_person_head"><strong>Contact Person: </strong></td>
							<td class="contact_person">
								<?php print (get_post_meta($post->ID, 'announcement_contact', TRUE)) ? get_post_meta($post->ID, 'announcement_contact', TRUE) : 'n/a'; ?>
							</td>
						</tr>
						<tr>
							<td class="phone_head"><strong>Phone: </strong></td>
							<td class="phone">
								<?php print (get_post_meta($post->ID, 'announcement_phone', TRUE)) ? get_post_meta($post->ID, 'announcement_phone', TRUE) : 'n/a'; ?>
							</td>
						</tr>
						<tr>
							<td class="email_head"><strong>E-mail: </strong></td>
							<td class="email">
								<?php if (get_post_meta($post->ID, 'announcement_email', TRUE)) { ?>
								<a href="mailto:<?=get_post_meta($post->ID, 'announcement_email', TRUE)?>"><?=get_post_meta($post->ID, 'announcement_email', TRUE)?></a>
								<?php } else { ?>
								n/a
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="posted_by_head"><strong>Posted By: </strong></td>
							<td class="posted_by">
								<?php print (get_post_meta($post->ID, 'announcement_posted_by', TRUE)) ? get_post_meta($post->ID, 'announcement_posted_by', TRUE) : 'n/a'; ?>
							</td>
						</tr>
					</tbody>
				</table>

			</article>
		</div>
	</div>

<?php get_footer();?>
