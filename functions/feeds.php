<?php
/**
 * Return the URL of a feed item's thumbnail, or the first image in the item's content
 * if a thumbnail doesn't exist.
 **/
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
 * Fetches an external url's contents with a timeout applied to the request.
 **/
function fetch_with_timeout( $url ) {
	$retval = false;

	$args = array(
		'timeout' => FEED_FETCH_TIMEOUT
	);

	$response = wp_safe_remote_get( $url, $args );
	if ( is_array( $response ) ) {
		$retval = wp_remote_retrieve_body( $response );
	}

	return $retval;
}


/**
 * Check to see if an external image exists (via curl.)
 * Alternative to getimagesize() that allows us to specify a timeout.
 * via http://stackoverflow.com/questions/1363925/check-whether-image-exists-on-remote-url
 *
 * @return bool
 **/
function check_remote_file($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // specify URL
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, FEED_FETCH_TIMEOUT); // specify timeout
    curl_setopt($ch, CURLOPT_NOBODY, 1); // don't download content
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch) !== FALSE) {
        return true;
    }
    return false;
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
		$cache_length = 60; // 1 minute

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
			$content = fetch_with_timeout( $url );
			if ($content === False || empty($content)){
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
			$simplepie->set_timeout(FEED_FETCH_TIMEOUT); // seconds
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


/* Modified for main site theme (for JSON instead of RSS feed): */
function display_events($start=null, $limit=null){?>
	<?php
	$options = get_option(THEME_OPTIONS_NAME);
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
	if($events !== NULL && count($events)): ?>
		<table class="events table">
			<thead>
				<td>Date</td>
				<td>Description</td>
			</thead>
			<tbody class="vcalendar">
				<?php foreach($events as $item):
					$start 		= new DateTime($item['starts']);
					$day 		= $start->format('M d');
					$time 		= $start->format('h:i a');
					$link 		= $item['url'];
					$loc_link 	= $item['location_url'];
					$location	= $item['location'];
					$title		= $item['title'];
				?>
				<tr class="item vevent">
					<td class="date">
						<div class="day"><?=$day?></div>
						<div class="dtstart">
							<abbr class="dtstart" title="<?=$start->format('c')?>"><?=$time?></abbr>
						</div>
					</td>
					<td class="eventdata">
						<div class="summary"><a href="<?=$link?>" class="wrap url"><?=$title?></a></div>
						<div class="location">
							<?php if ($loc_link) { ?><a href="<?=$loc_link?>" class="wrap"><?php } ?><?=$location?><?php if ($loc_link) { ?></a><?php } ?>
						</div>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php else: ?>
		<?php echo $options['events_fallback_message']; ?>
	<?php endif;?>
<?php
}


function display_events_list_item( $item, $list_item_classes='', $show_description=false ) {
	$start        = new DateTime( $item['starts'] );
	$url          = $item['url'];
	$title        = $item['title'];
	$description  = $item['description'];
	$location     = $item['location'];

	ob_start();
?>
	<li class="events-list-item vevent <?php echo $list_item_classes; ?>">
		<a href="<?php echo $url; ?>" class="event-link url">
			<time class="event-start-datetime dtstart" datetime="<?php echo $start->format( 'c' ); ?>">
				<span class="event-start-date"><?php echo $start->format( 'F j' ); ?></span>
				<span class="event-start-year"><?php echo $start->format( 'Y' ); ?></span>
				<span class="event-start-time"><?php echo $start->format( 'h:i a' ); ?></span>
			</time>
			<span class="event-title summary"><?php echo $title; ?></span>
			<span class="event-location location"><?php echo $location; ?></span>
		</a>

		<?php if ( $show_description ): ?>
		<div class="event-description description"><?php echo truncateHtml( $description, 350 ); ?></div>
		<?php endif; ?>
	</li>
<?php
	return ob_get_clean();
}


function display_events_list( $start=null, $limit=null, $url='', $list_classes='', $list_item_classes='', $show_descriptions=false ) {
	$options = get_option( THEME_OPTIONS_NAME );
	$start = $start ? intval( $start ) : 0;

	// Check for a given limit, then a set Options value, then if none exist, set to 4
	if ( !$limit || $limit < 1 ) {
		if ( $options['events_max_items'] ) {
			$limit = $options['events_max_items'];
		}
		else {
			$limit = 4;
		}
	}

	$events = get_events( $start, $limit, $url );

	ob_start();
?>
	<?php if ( $events && count( $events ) ): ?>

	<ul class="events-list <?php echo $list_classes; ?>">
		<?php
		foreach ( $events as $event ) {
			echo display_events_list_item( $event, $list_item_classes, $show_descriptions );
		}
		?>
	</ul>

	<?php endif; ?>
<?php
	return ob_get_clean();
}


function display_news(){?>
	<?php
	$options = get_option(THEME_OPTIONS_NAME);
	$count   = $options['news_max_items'];
	$news    = get_news(0, ($count) ? $count : 3);
	if($news !== NULL && count($news)):?>
		<ul class="news">
			<?php foreach($news as $key=>$item):
				$image = get_article_image($item);
				if (!($image)) {
					$image = 'http://today.ucf.edu/widget/thumbnail.png';
				}
				else {
					if (preg_match('/\.jpeg$/i', $image)) {
						$end_of_str_length = 5;
					}
					else {
						// assume .jpeg is the only potential 5-character file extension being used
						$end_of_str_length = 4;
					}
					// Grab Today's 66x66px thumbnails if they're available
					$image_small = substr($image, 0, (strlen($image) - $end_of_str_length)).'-66x66'.substr($image, (strlen($image) - $end_of_str_length));
					$image = check_remote_file($image_small) !== false ? $image_small : $image;
				}
				$first = ($key == 0);
			?>
			<li class="item<?php if($first):?> first<?php else:?> not-first<?php endif;?>">
				<a class="image ignore-external" href="<?=$item->get_link()?>">
					<?php if($image):?>
					<img class="print-only news-thumb" src="<?=$image?>" />
					<div class="screen-only news-thumb" style="background-image:url('<?=$image?>'); filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=$image?>',sizingMethod='scale');">Feed image for <?=$item->get_title()?></div>
					<?php endif;?>
				</a>
				<h3 class="title"><a href="<?=$item->get_link()?>" class="ignore-external title"><?=$item->get_title()?></a></h3>
				<div class="clearfix"></div>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="clearfix"></div>
	<?php else:?>
		<p>News items could not be retrieved at this time.  Please try again later.</p>
	<?php endif;?>
<?php
}


function display_pegasus_issues_list_item( $issue, $list_item_classes='' ) {
	$issue_url               = $issue->link;
	$issue_title             = $issue->title->rendered;
	$cover_story             = $issue->_embedded->issue_cover_story[0];
	$cover_story_url         = $cover_story->link;
	$cover_story_title       = $cover_story->title->rendered;
	$cover_story_subtitle    = $cover_story->story_subtitle;
	$cover_story_description = $cover_story->story_description;
	$cover_story_blurb       = null;
	$thumbnail_id            = $issue->featured_image;
	$thumbnail               = null;
	$thumbnail_url           = null;

	if ( $thumbnail_id !== 0 ) {
		$thumbnail = $issue->_embedded->{"wp:featuredmedia"}[0];
		$thumbnail_url = $thumbnail->media_details->sizes->full->source_url;
	}

	if ( $cover_story_description ) {
		$cover_story_blurb = $cover_story_description;
	}
	elseif ( $cover_story_subtitle ) {
		$cover_story_blurb = $cover_story_subtitle;
	}

	ob_start();
?>
	<li class="pegasus-issues-list-item <?php echo $list_item_classes; ?>">
		<?php
		// Thumbnails should always be present for Issues, but just in case:
		if ( $thumbnail_url ):
		?>
		<a class="pegasus-issue-thumbnail-link" href="<?php echo $issue_url; ?>" target="_blank">
			<img class="pegasus-issue-thumbnail img-responsive" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $issue_title; ?>" title="<?php echo $issue_title; ?>">
		</a>
		<?php endif; ?>

		<div class="pegasus-issue-details">
			<a class="pegasus-issue-title" href="<?php echo $issue_url; ?>" target="_blank">
				<?php echo wptexturize( $issue_title ); ?>
			</a>

			<span class="pegasus-issue-featured-label">Featured Story</span>

			<a class="pegasus-issue-cover-title" href="<?php echo $cover_story_url; ?>">
				<?php echo wptexturize( $cover_story_title ); ?>
			</a>

			<?php if ( $cover_story_blurb ): ?>
			<div class="pegasus-issue-cover-description">
				<?php echo wptexturize( strip_tags( $cover_story_blurb, '<b><em><i><u><strong>' ) ); ?>
			</div>
			<?php endif; ?>

			<a class="pegasus-issue-read-link" href="<?php echo $issue_url; ?>" target="_blank">
				Read Now
			</a>
		</div>
	</li>
<?php
	return ob_get_clean();
}


function display_pegasus_issues_list( $start=null, $limit=null, $list_classes='', $list_item_classes='' ) {
	$issues = get_pegasus_issues( $start, $limit );

	if (
		!$issues
		|| !is_array( $issues )
		|| ( is_array( $issues ) && count( $issues ) < 1 )
	) {
		return;
	}

	ob_start();
?>
	<ul class="pegasus-issues-list <?php echo $list_classes; ?>">
		<?php
		foreach ( $issues as $issue ) {
			echo display_pegasus_issues_list_item( $issue, $list_item_classes );
		}
		?>
	</ul>
<?php
	return ob_get_clean();
}


/* Modified function for main site theme: */
function get_events( $start=0, $limit=4, $url='' ) {
	$options = get_option( THEME_OPTIONS_NAME );
	$url = $url ?: $options['events_url'];

	// Remove any query strings attached to the url provided.
	$qstring = ( bool )strpos( $url, '?' );
	if ( $qstring ) {
		$url_parts = explode( '?', $url );
		$url = $url_parts[0];
	}

	// Append trailing end slash to url.
	if ( substr( $url, -1 ) !== '/' ) {
		$url .= '/';
	}

	// Append /upcoming/ to the end of the url, if it's not already present.
	if ( substr( $url, -9 ) !== 'upcoming/' ) {
		$url .= 'upcoming/';
	}

	// Append /feed.json to the end of the url.
	$url .= 'feed.json';

	// Grab the feed
	$raw_events = fetch_with_timeout( $url );
	if ( $raw_events ) {
		$events = json_decode( $raw_events, TRUE );
		if ( is_array( $events ) ) {
			$events = array_slice( $events, $start, $limit );
		}
		return $events;
	}
	else { return null; }
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


function get_pegasus_issues( $start=0, $limit=5 ) {
	$options = get_option( THEME_OPTIONS_NAME );
	$pegasus_url = $options['pegasus_url'];

	if ( substr( $pegasus_url, -1 ) !== '/' ) {
		$pegasus_url .= '/';
	}

	$api_url = $pegasus_url . 'wp-json/wp/v2/';
	$issue_url = $api_url . 'issue?_embed&offset='. $start .'&per_page='. $limit;

	$issue_results = fetch_with_timeout( $issue_url );
	if ( $issue_results ) {
		$issue_json = json_decode( $issue_results );
		return $issue_json;
	}
	else {
		return false;
	}
}

?>
