<?php disallow_direct_load('sidebar.php');?>

<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Right Sidebar')):?>
<?php endif;?>

<?php
	
	$show_today				= get_post_meta($post->ID, 'page_widget_r_showtoday', TRUE);
	$today_feed 			= (get_post_meta($post->ID, 'page_widget_r_today_feed', TRUE) !== '') ? get_post_meta($post->ID, 'page_widget_r_today_feed', TRUE) : 'http://today.ucf.edu/feed/';
	$today_feed_title 		= get_post_meta($post->ID, 'page_widget_r_today_title', TRUE);
	$show_facebook	 		= get_post_meta($post->ID, 'page_widget_r_showfacebook', TRUE);
	$embed1_title	 		= get_post_meta($post->ID, 'page_widget_r_embed1_title', TRUE);
	$embed1			 		= get_post_meta($post->ID, 'page_widget_r_embed1', TRUE);
	$embed2_title			= get_post_meta($post->ID, 'page_widget_r_embed2_title', TRUE);
	$embed2		 			= get_post_meta($post->ID, 'page_widget_r_embed2', TRUE);
	$embed3_title			= get_post_meta($post->ID, 'page_widget_r_embed3_title', TRUE);
	$embed3					= get_post_meta($post->ID, 'page_widget_r_embed3', TRUE);
	
	// Today Feed
	if ($show_today == 'on') {	
		print '<h3 id="sidebar_r_today" class="sidebar_title">';
			$today_feed_title = $today_feed_title !== '' ? 'UCF Today &raquo; '.$today_feed_title : 'UCF Today';
			print $today_feed_title;
		print '</h3>';
		
		print '<div id="sidebar_r_today_wrap" class="sidebar_r_wrap">';
		$news = get_sidebar_news($post, 0, 5);
		if(count($news)) { ?>
			<ul class="news">
				<?php 
				foreach($news as $item) { ?>
					<li class="item">
						<a href="<?=$item->get_link()?>" class="ignore-external title"><?=$item->get_title()?></a>
					</li>
				<?php 
				} ?>
			</ul>
		<?php
		} else {
			print '<p>Unable to fetch news.</p>';
		}		
		print '<a class="rssbtn" href="'.$today_feed.'">Full Feed</a>';
		print '</div>';
	}
	
	// Facebook Link
	if ($show_facebook == 'on') {	
		
		print '<h3 id="sidebar_r_facebook" class="sidebar_title">Connect With UCF</h3>';
		print '<div id="sidebar_r_facebook_wrap" class="sidebar_r_wrap">';
		print '<iframe scrolling="no" frameborder="0" src="http://www.facebook.com/connect/connect.php?id=35078114590&connections=0&stream=0&css=PATH_TO_STYLE_SHEET" allowtransparency="true" style="border: medium none; width: 225px; height: 100px;"></iframe>';
		print '</div>';
		
	}
	
	// Embed Widget 1
	if ($embed1) {	
		if ($embed1_title !== '') {
			print '<h3 id="sidebar_r_embed1" class="sidebar_title">'.$embed1_title.'</h3>';
		}
		print '<div id="sidebar_r_embed1_wrap" class="sidebar_r_wrap">';
		print apply_filters('the_content', $embed1);
		print '</div>';
	}
	
	// Embed Widget 2
	if ($embed2) {	
		if ($embed2_title !== '') {
			print '<h3 id="sidebar_r_embed2" class="sidebar_title">'.$embed2_title.'</h3>';
		}
		print '<div id="sidebar_r_embed2_wrap" class="sidebar_r_wrap">';
		print apply_filters('the_content', $embed2);
		print '</div>';
	}
	
	// Embed Widget 3
	if ($embed3) {	
		if ($embed3_title !== '') {
			print '<h3 id="sidebar_r_embed3" class="sidebar_title">'.$embed3_title.'</h3>';
		}
		print '<div id="sidebar_r_embed3_wrap" class="sidebar_r_wrap">';
		print apply_filters('the_content', $embed3);
		print '</div>';
	}

?>
