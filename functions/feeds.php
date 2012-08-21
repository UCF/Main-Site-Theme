<?php

/**
 * Using the user defined value for Flickr ID set in the admin, will return the 
 * photostream URL for that ID.  Will return null if no id is set.
 *
 * @return string
 * @author Jared Lang
 **/
function get_flickr_feed_url(){
	$rss_url = "http://api.flickr.com/services/feeds/photos_public.gne?id=%s&amp;lang=en-us&amp;format=rss_200";
	$options = get_option(THEME_OPTIONS_NAME);
	$id = $options['flickr_id'];
	
	if ($id){
		return sprintf($rss_url, $id);
	}else{
		return null;
	}
}


function get_flickr_stream_url(){
	$rss_url = "http://flickr.com/photos/%s";
	$options = get_option(THEME_OPTIONS_NAME);
	$id = $options['flickr_id'];
	
	if ($id){
		return sprintf($rss_url, $id);
	}else{
		return null;
	}
}

function get_article_image($article){
	$image = $article->get_enclosure();
	if ($image){
		return ($image->get_thumbnail()) ? $image->get_thumbnail() : $image->get_link();
	}else{
		$matches = array();
		$found   = preg_match('/<img[^>]+src=[\'\"]([^\'\"]+)[\'\"][^>]+>/i',  $article->get_content(), $matches);
		if($found){ 
			return $matches[1];
		}
	}
	return null;
}



/**
 * Handles fetching and processing of feeds.  Currently uses SimplePie to parse
 * retrieved feeds, and automatically handles caching of content fetches.
 * Multiple calls to the same feed url will not result in multiple parsings, per
 * request as they are stored in memory for later use.
 **/
class FeedManager{
	static private
		$feeds        = array(),
		$cache_length = 0xD2F0;
	
	/**
	 * Provided a URL, will return an array representing the feed item for that
	 * URL.  A feed item contains the content, url, simplepie object, and failure
	 * status for the URL passed.  Handles caching of content requests.
	 *
	 * @return array
	 * @author Jared Lang
	 **/
	static protected function __new_feed($url){
		$timer = Timer::start();
		require_once(THEME_DIR.'/third-party/simplepie.php');
		
		$simplepie = null;
		$failed    = False;
		$cache_key = 'feedmanager-'.md5($url);
		$content   = get_site_transient($cache_key);
		
		if ($content === False){
			$content = @file_get_contents($url);
			if ($content === False){
				$failed  = True;
				$content = null;
				error_log('FeedManager failed to fetch data using url of '.$url);
			}else{
				set_site_transient($cache_key, $content, self::$cache_length);
			}
		}
		
		if ($content){
			$simplepie = new SimplePie();
			$simplepie->set_raw_data($content);
			$simplepie->init();
			$simplepie->handle_content_type();
			
			if ($simplepie->error){
				error_log($simplepie->error);
				$simplepie = null;
				$failed    = True;
			}
		}else{
			$failed = True;
		}
		
		$elapsed = round($timer->elapsed() * 1000);
		debug("__new_feed: {$elapsed} milliseconds");
		return array(
			'content'   => $content,
			'url'       => $url,
			'simplepie' => $simplepie,
			'failed'    => $failed,
		);
	}
	
	
	/**
	 * Returns all the items for a given feed defined by URL
	 *
	 * @return array
	 * @author Jared Lang
	 **/
	static protected function __get_items($url){
		if (!array_key_exists($url, self::$feeds)){
			self::$feeds[$url] = self::__new_feed($url);
		}
		if (!self::$feeds[$url]['failed']){
			return self::$feeds[$url]['simplepie']->get_items();
		}else{
			return array();
		}
		
	}
	
	
	/**
	 * Retrieve the current cache expiration value.
	 *
	 * @return void
	 * @author Jared Lang
	 **/
	static public function get_cache_expiration(){
		return self::$cache_length;
	}
	
	
	/**
	 * Set the cache expiration length for all feeds from this manager.
	 *
	 * @return void
	 * @author Jared Lang
	 **/
	static public function set_cache_expiration($expire){
		if (is_number($expire)){
			self::$cache_length = (int)$expire;
		}
	}
	
	
	/**
	 * Returns all items from the feed defined by URL and limited by the start
	 * and limit arguments.
	 *
	 * @return array
	 * @author Jared Lang
	 **/
	static public function get_items($url, $start=null, $limit=null){
		if ($start === null){$start = 0;}
		
		$items = self::__get_items($url);
		$items = array_slice($items, $start, $limit);
		return $items;
	}
}


class FlickrManager extends FeedManager{
	static protected $sizes = array(
		'large'     => 'b',
		'medium'    => 'z',
		'small'     => 'm',
		'thumbnail' => 't',
		'square'    => 's',
	);
	
	static protected function __items_to_photos($items){
		$photos = array();
		
		foreach($items as $item){
			$title = $item->get_title();
			$urls  = array();
			try{
				$url = $item->get_enclosure()->get_link();
			}catch (Exception $e){
				continue;
			}
			
			foreach(FlickrManager::$sizes as $key=>$size){
				$size             = "_{$size}.jpg";
				$urls[$key]       = str_replace('_b.jpg', $size, $url);
				$urls['original'] = $url;
				$urls['title']    = $title;
				$urls['page']     = $item->get_link();
			}
			$photos[] = $urls;
		}
		return $photos;
	}
	
	
	static public function get_photos($url, $start=null, $limit=null){
		if ($start === null){$start = 0;}
		
		$items  = self::__get_items($url);
		$photos = array_slice(self::__items_to_photos($items), $start, $limit);
		return $photos;
	}
}


function display_flickr($header='h2'){
	$options  = get_option(THEME_OPTIONS_NAME);
	$count    = $options['flickr_max_items'];
	$feed_url = get_flickr_feed_url();
	$photos   = FlickrManager::get_photos($feed_url, 0, $count);
	
	if(count($photos)):?>
		<<?=$header?>><a href="<?=get_flickr_stream_url()?>">Flickr Stream</a></<?=$header?>>
		<ul class="flickr-stream">
			<?php foreach($photos as $photo):?>
			<li><a class="ignore-external" href="<?=$photo['page']?>"><img height="75" width="75" src="<?=$photo['square']?>" title="<?=$photo['title']?>" /></a></li>
			<?php endforeach;?>
		</ul>
	<?php else:?>
		<p>Unable to fetch flickr feed.</p>
	<?php endif;?>
<?php
}

/* Modified for main site theme (for JSON instead of RSS feed): */
function display_events($start=null, $limit=null){?>
	<?php 
	$options = get_option(THEME_OPTIONS_NAME);
	$qstring = (bool)strpos($options['events_url'], '?');
	$url     = $options['events_url'];
	if (!$qstring){
		$url .= '?';
	}else{
		$url .= '&';
	}
	$start	 = ($start) ? $start : 0;
	// Check for a given limit, then a set Options value, then if none exist, set to 4
	if ($limit) {
		$limit = intval($limit);
	}
	elseif ($options['events_max_items']) {
		$limit = $options['events_max_items'];
	}
	else {
		$limit = 4;
	}
	$events  = get_events($start, $limit);
	if(count($events)): ?>
		<table class="events">
			<?php foreach($events as $item):
				$day  		= date('M d', strtotime($item['starts']));
				$time 		= date('h:i a', strtotime($item['starts']));
				$link 		= $url.'eventdatetime_id='.$item['id'];
				$loc_link 	= $item['location_url'];
				$location	= $item['location'];
				$title		= $item['title'];				
			?>
			<tr class="item">
				<td class="date">
					<div class="day"><?=$day?></div>
					<div class="time"><?=$time?></div>
				</td>
				<td class="title">
					<a href="<?=$link?>" class="wrap ignore-external"><?=$title?></a>
					<a href="<?=$loc_link?>" class="wrap ignore-external"><?=$location?></a>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
	<?php else:?>
		<p>Unable to fetch events</p>
	<?php endif;?>
<?php
}


function display_news(){?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $count   = $options['news_max_items'];?>
	<?php $news    = get_news(0, ($count) ? $count : 3);?>
	<?php if(count($news)):?>
		<ul class="news">
			<?php foreach($news as $key=>$item): $image = get_article_image($item); $first = ($key == 0);?>
			<li class="item<?php if($first):?> first<?php else:?> not-first<?php endif;?>">
				<p>
					<a class="image ignore-external" href="<?=$item->get_link()?>">
						<?php if($image):?>
						<img src="<?=$image?>" alt="Feed image for <?=$item->get_title()?>" />
						<?php endif;?>
					</a>
				</p>
				<h3 class="title"><a href="<?=$item->get_link()?>" class="ignore-external title"><?=$item->get_title()?></a></h3>
				<div class="end"><!-- --></div>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="end"><!-- --></div>
	<?php else:?>
		<p>Unable to fetch news.</p>
	<?php endif;?>
<?php
}


/* Modified function for main site theme: */
function get_events($start, $limit){
	$options = get_option(THEME_OPTIONS_NAME);
	$qstring = (bool)strpos($options['events_url'], '?');
	$url     = $options['events_url'];
	if (!$qstring){
		$url .= '?';
	}else{
		$url .= '&';
	}
	$url    .= 'upcoming=upcoming&format=json';
	//$events  = array_reverse(FeedManager::get_items($url));
	//$events  = array_slice($events, $start, $limit);
	$events = json_decode(file_get_contents($url), TRUE);
	$events = array_slice($events, $start, $limit);
	return $events;
}


function get_news($start=null, $limit=null){
	$options = get_option(THEME_OPTIONS_NAME);
	$url     = $options['news_url'];
	$news    = FeedManager::get_items($url, $start, $limit);
	return $news;
}


/* Added function for main site theme: */
function get_sidebar_news($post, $start=null, $limit=null){
	$options	 = get_option(THEME_OPTIONS_NAME);
	$url      	 = get_post_meta($post->ID, 'page_widget_r_today_feed', TRUE) !== '' ? get_post_meta($post->ID, 'page_widget_r_today_feed', TRUE) : $options['news_url'];
	$news     	 = FeedManager::get_items($url, $start, $limit);
	return $news;
}


?>