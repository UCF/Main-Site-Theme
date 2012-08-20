<?php disallow_direct_load('sidebar.php');?>

<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Right Sidebar')):?>
<?php endif;?>

<?php
	
	$show_today				= get_post_meta($post->ID, 'page_widget_r_showtoday', TRUE);
	$today_feed 			= get_post_meta($post->ID, 'page_widget_r_today_feed', TRUE);
	$today_feed_title 		= get_post_meta($post->ID, 'page_widget_r_today_title', TRUE);
	$show_facebook	 		= get_post_meta($post->ID, 'page_widget_r_showfacebook', TRUE);
	$embed1			 		= get_post_meta($post->ID, 'page_widget_r_embed1', TRUE);
	$embed2		 			= get_post_meta($post->ID, 'page_widget_r_embed2', TRUE);
	$embed3					= get_post_meta($post->ID, 'page_widget_r_embed3', TRUE);
	
	if ($show_today == 'on') {	
		print '<h3 id="sidebar_r_today" class="sidebar_title">';
		$today_feed_title = $today_feed_title !== '' ? 'UCF Today &raquo; '.$today_feed_title : 'UCF Today';
		print $today_feed_title;
		print '</h3>';
		
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
		
	}
	if ($show_facebook == 'on') {	
		
		print 'Facebook link will go here....';
		
	}
	if ($embed1) {	
		print apply_filters('the_content', $embed1);
	}
	if ($embed2) {	
		print apply_filters('the_content', $embed2);
	}
	if ($embed3) {	
		print apply_filters('the_content', $embed3);
	}

?>
