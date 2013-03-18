<?php

/**
 * Responsible for running code that needs to be executed as wordpress is
 * initializing.  Good place to register scripts, stylesheets, theme elements,
 * etc.
 * 
 * @return void
 * @author Jared Lang
 **/
function __init__(){
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_image_size('homepage', 620);
	add_image_size('homepage-secondary', 540);
	add_image_size('centerpiece-image', 940, 338, true); 	// Crops!
	add_image_size('home-thumb', 110, 110);	
	add_image_size('subpage-subimg', 160);
	add_image_size('subpage-studentimg', 115, 280);
	register_nav_menu('header-menu', __('Header Menu'));
	register_nav_menu('ucf-colleges', __('UCF Colleges'));
	register_nav_menu('footer-menu', __('Footer Menu'));
	register_nav_menu('social-links', __('Social Links'));
	register_sidebar(array(
		'name'          => __('Left Sidebar'),
		'id'            => 'sidebar-left',
		'description'   => 'Left-hand Sidebar found on subpages.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Right Sidebar'),
		'id'            => 'sidebar-right',
		'description'   => 'Right-hand Sidebar found on subpages.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
	foreach(Config::$styles as $style){Config::add_css($style);}
	foreach(Config::$scripts as $script){Config::add_script($script);}
	
	global $timer;
	$timer = Timer::start();
	
	wp_deregister_script('l10n');
	set_defaults_for_options();
}
add_action('after_setup_theme', '__init__');



# Set theme constants
#define('DEBUG', True);                  # Always on
#define('DEBUG', False);                 # Always off
define('DEBUG', isset($_GET['debug'])); # Enable via get parameter
define('THEME_URL', get_stylesheet_directory_uri());
define('THEME_ADMIN_URL', get_admin_url());
define('THEME_DIR', get_stylesheet_directory());
define('THEME_INCLUDES_DIR', THEME_DIR.'/includes');
define('THEME_STATIC_URL', THEME_URL.'/static');
define('THEME_IMG_URL', THEME_STATIC_URL.'/img');
define('THEME_JS_URL', THEME_STATIC_URL.'/js');
define('THEME_CSS_URL', THEME_STATIC_URL.'/css');
define('THEME_OPTIONS_GROUP', 'settings');
define('THEME_OPTIONS_NAME', 'theme');
define('THEME_OPTIONS_PAGE_TITLE', 'Theme Options');
define('ESI_INCLUDE_URL', THEME_STATIC_URL.'/esi.php');

# Timeout for data grabbed from feeds
define('FEED_FETCH_TIMEOUT', 8); // seconds

# Weather
define('WEATHER_URL', 'http://weather.smca.ucf.edu/');
define('WEATHER_CLICK_URL', 'http://www.weather.com/weather/today/Orlando+FL+32816');
define('WEATHER_CACHE_DURATION', 60 * 5); //seconds

$theme_options = get_option(THEME_OPTIONS_NAME);
define('GA_ACCOUNT', $theme_options['ga_account']);
define('CB_UID', $theme_options['cb_uid']);
define('CB_DOMAIN', $theme_options['cb_domain']);

define('SEARCH_SERVICE_URL', 'http://webcom.dev.smca.ucf.edu/search/webroot/service.php');
define('SEARCH_SERVICE_HTTP_TIMEOUT', 10); #seconds

# Estimated start/end months of semesters; used for announcements
define('CURRENT_MONTH', date('n'));
define('SPRING_MONTH_START', 1); 	// Jan
define('SPRING_MONTH_END', 5);		// May
define('SUMMER_MONTH_START', 5); 	// May
define('SUMMER_MONTH_END', 7);		// Jul
define('FALL_MONTH_START', 8);		// Aug
define('FALL_MONTH_END', 12); 		// Dec

# Domain/path of site (for cookies)
list($domain, $path) = explode('.edu', get_site_url()); 
$domain = preg_replace('/^(http|https):\/\//','',$domain).'.edu';
if (substr($path, strlen($path)-1) !== '/') { $path = $path.'/'; } // make sure path ends in /
define('WP_SITE_DOMAIN', $domain);
define('WP_SITE_PATH', $path);

define('LDAP_HOST', 'net.ucf.edu');

/**
 * Set config values including meta tags, registered custom post types, styles,
 * scripts, and any other statically defined assets that belong in the Config
 * object.
 **/
Config::$custom_post_types = array(
	'Video',
	'Document',
	'Publication',
	'Page',
	'Person',
	'Slider',
	'Spotlight',
	'Subheader',
	'AZIndexLink',
	'Announcement',
	'Post'
);

Config::$custom_taxonomies = array(
	'OrganizationalGroups',
	'Keywords',
	'AudienceRoles'
);

Config::$body_classes = array('default');
# Set some helper body classes for Android/iPhone overrides
$ua = $_SERVER['HTTP_USER_AGENT'];
if (stripos(strtolower($ua), 'android') !== false) {
	array_push(Config::$body_classes, 'android');
}
if ( (strstr($ua, 'iPod')) || (strstr($ua, 'iPhone')) ) {
	array_push(Config::$body_classes, 'iphone');
}
if (strstr($ua, 'iPad')) {
	array_push(Config::$body_classes, 'ipad');
}


/*
 * Edge Side Includes (ESI) are directives that tell Varnish to include some other
 * content in the page. The primary use for use to assign another cache duration
 * to the "other content". To add an ESI, first encapsulate your content in a PHP
 * function such as output_weather_data(). Then in place of where you would call
 * output_weather_data() in the content, call esi_include('output_weather_data();').
 * In other words, pass the PHP statement that outputs the content as an argument
 * to the esi_include function. 
 *
 * To avoid an arbitrary code execution exploit, every statement being called with
 * esi_include must be registered in the Config::$esi_whitelist array below. If
 * different function calls take different arguments, they must all be registered 
 * (e.g. output_weather_data() and output_weather_data('span3')).
 *
 */

Config::$esi_whitelist = array(
	'output_weather_data();',
	'output_weather_data(\'span3\');',
	'do_shortcode(\'[events-widget]\');',
	'display_news();',
	'page_specific_stylesheet();'
);

/**
 * Configure theme settings, see abstract class Field's descendants for
 * available fields. -- functions/base.php
 **/
Config::$theme_settings = array(
	'Analytics' => array(
		new TextField(array(
			'name'        => 'Google WebMaster Verification',
			'id'          => THEME_OPTIONS_NAME.'[gw_verify]',
			'description' => 'Example: <em>9Wsa3fspoaoRE8zx8COo48-GCMdi5Kd-1qFpQTTXSIw</em>',
			'default'     => null,
			'value'       => $theme_options['gw_verify'],
		)),
		new TextField(array(
			'name'        => 'Google Analytics Account',
			'id'          => THEME_OPTIONS_NAME.'[ga_account]',
			'description' => 'Example: <em>UA-9876543-21</em>. Leave blank for development.',
			'default'     => null,
			'value'       => $theme_options['ga_account'],
		)),
		new TextField(array(
			'name'        => 'Chartbeat UID',
			'id'          => THEME_OPTIONS_NAME.'[cb_uid]',
			'description' => 'Example: <em>1842</em>',
			'default'     => null,
			'value'       => $theme_options['cb_uid'],
		)),
		new TextField(array(
			'name'        => 'Chartbeat Domain',
			'id'          => THEME_OPTIONS_NAME.'[cb_domain]',
			'description' => 'Example: <em>some.domain.com</em>',
			'default'     => null,
			'value'       => $theme_options['cb_domain'],
		)),
	),
	'Events' => array(
		new SelectField(array(
			'name'        => 'Events Max Items',
			'id'          => THEME_OPTIONS_NAME.'[events_max_items]',
			'description' => 'Maximum number of events to display whenever outputting event information.',
			'value'       => $theme_options['events_max_items'],
			'default'     => 4,
			'choices'     => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
			),
		)),
		new TextField(array(
			'name'        => 'Events Calendar URL',
			'id'          => THEME_OPTIONS_NAME.'[events_url]',
			'description' => 'Base URL for the calendar you wish to use. Example: <em>http://events.ucf.edu/mycalendar</em>',
			'value'       => $theme_options['events_url'],
			'default'     => 'http://events.ucf.edu',
		)),
	),
	'News' => array(
		new SelectField(array(
			'name'        => 'News Max Items',
			'id'          => THEME_OPTIONS_NAME.'[news_max_items]',
			'description' => 'Maximum number of articles to display when outputting news information.',
			'value'       => $theme_options['news_max_items'],
			'default'     => 2,
			'choices'     => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
			),
		)),
		new TextField(array(
			'name'        => 'News Feed',
			'id'          => THEME_OPTIONS_NAME.'[news_url]',
			'description' => 'Use the following URL for the news RSS feed <br />Example: <em>http://today.ucf.edu/feed/</em>',
			'value'       => $theme_options['news_url'],
			'default'     => 'http://today.ucf.edu/feed/',
		)),
	),
	'Search' => array(
		new RadioField(array(
			'name'        => 'Enable Google Search',
			'id'          => THEME_OPTIONS_NAME.'[enable_google]',
			'description' => 'Enable to use the google search appliance to power the search functionality.',
			'default'     => 1,
			'choices'     => array(
				'On'  => 1,
				'Off' => 0,
			),
			'value'       => $theme_options['enable_google'],
	    )),
		new TextField(array(
			'name'        => 'Search Domain',
			'id'          => THEME_OPTIONS_NAME.'[search_domain]',
			'description' => 'Domain to use for the built-in google search.  Useful for development or if the site needs to search a domain other than the one it occupies. Example: <em>some.domain.com</em>',
			'default'     => null,
			'value'       => $theme_options['search_domain'],
		)),
		new TextField(array(
			'name'        => 'Search Results Per Page',
			'id'          => THEME_OPTIONS_NAME.'[search_per_page]',
			'description' => 'Number of search results to show per page of results',
			'default'     => 10,
			'value'       => $theme_options['search_per_page'],
		)),
	),
	'Site' => array(
		new TextField(array(
			'name'        => 'Contact Email',
			'id'          => THEME_OPTIONS_NAME.'[site_contact]',
			'description' => 'Contact email address that visitors to your site can use to contact you.',
			'value'       => $theme_options['site_contact'],
		)),
		new TextField(array(
			'name'        => 'Organization Name',
			'id'          => THEME_OPTIONS_NAME.'[organization_name]',
			'description' => 'Your organization\'s name',
			'value'       => $theme_options['organization_name'],
		)),
		new RadioField(array(
			'name'        => 'Enable Edge Side Includes (ESI)',
			'id'          => THEME_OPTIONS_NAME.'[enable_esi]',
			'description' => 'Replace specified content with Edge Side Includes (ESI) to be processed by Varnish.',
			'default'     => 0,
			'choices'     => array(
				'On'  => 1,
				'Off' => 0,
			),
			'value'       => $theme_options['enable_esi'],
	    )),
		new TextField(array(
			'name'        => 'Weekly Feedback Email Key',
			'id'          => THEME_OPTIONS_NAME.'[feedback_email_key]',
			'description' => 'Secret key that allows for weekly feedback emails to be sent via cron job.
							 The cron job\'s passed argument must be the same as this value; do not modify 
							 this value unless you can edit the server cron tab!',
			'default'     => '',
			'value'       => $theme_options['feedback_email_key'],
	    )),
		new TextareaField(array(
			'name'        => 'Weekly Feedback Email Recipients',
			'id'          => THEME_OPTIONS_NAME.'[feedback_email_recipients]',
			'description' => 'List of recipients for the weekly feedback email. Separate addresses with commas.',
			'default'     => '',
			'value'       => $theme_options['feedback_email_recipients'],
	    )),
	),
	'Social' => array(
		new RadioField(array(
			'name'        => 'Enable OpenGraph',
			'id'          => THEME_OPTIONS_NAME.'[enable_og]',
			'description' => 'Turn on the opengraph meta information used by Facebook.',
			'default'     => 1,
			'choices'     => array(
				'On'  => 1,
				'Off' => 0,
			),
			'value'       => $theme_options['enable_og'],
	    )),
		new TextField(array(
			'name'        => 'Facebook Admins',
			'id'          => THEME_OPTIONS_NAME.'[fb_admins]',
			'description' => 'Comma seperated facebook usernames or user ids of those responsible for administrating any facebook pages created from pages on this site. Example: <em>592952074, abe.lincoln</em>',
			'default'     => null,
			'value'       => $theme_options['fb_admins'],
		)),
		new TextField(array(
			'name'        => 'Facebook URL',
			'id'          => THEME_OPTIONS_NAME.'[facebook_url]',
			'description' => 'URL to the facebook page you would like to direct visitors to.  Example: <em>https://www.facebook.com/CSBrisketBus</em>',
			'default'     => null,
			'value'       => $theme_options['facebook_url'],
		)),
		new TextField(array(
			'name'        => 'Twitter URL',
			'id'          => THEME_OPTIONS_NAME.'[twitter_url]',
			'description' => 'URL to the twitter user account you would like to direct visitors to.  Example: <em>http://twitter.com/csbrisketbus</em>',
			'value'       => $theme_options['twitter_url'],
		)),
	),
	'Styles' => array(
		new RadioField(array(
			'name'        => 'Enable Responsiveness',
			'id'          => THEME_OPTIONS_NAME.'[bootstrap_enable_responsive]',
			'description' => 'Turn on responsive styles provided by the Twitter Bootstrap framework.  This setting should be decided upon before building out subpages, etc. to ensure content is designed to shrink down appropriately.  Turning this off will enable the single 940px-wide Bootstrap layout.  Note that turning this option off does NOT disable Javascript that performs actions based on the current browser width.',
			'default'     => 1,
			'choices'     => array(
				'On'  => 1,
				'Off' => 0,
			),
			'value'       => $theme_options['bootstrap_enable_responsive'],
	    )),
		new SelectField(array(
			'name'        => 'Header Menu Styles',
			'id'          => THEME_OPTIONS_NAME.'[bootstrap_menu_styles]',
			'description' => 'Adjust the styles that the header menu links will use.  Non-default options use Twitter Bootstrap navigation components for sub-navigation support.',
			'default'     => 'default',
			'choices'     => array(
				'Default (list of links with dropdowns)'  => 'default',
				'Tabs with dropdowns' => 'nav-tabs',
				'Pills with dropdowns' => 'nav-pills'
			),
			'value'       => $theme_options['bootstrap_menu_styles'],
	    )),
	),
	'Alerts' => array(
		new TextField(array(
			'name'        => 'Feed URL',
			'id'          => THEME_OPTIONS_NAME.'[alert_feed_url]',
			'description' => 'Alert theme alert post type RSS feed URL: http://www.ucf.edu/alert/feed/?post_type=alert',
			'value'       => $theme_options['alert_feed_url'],
		)),
		new TextField(array(
			'name'        => 'More Information URL',
			'id'          => THEME_OPTIONS_NAME.'[alert_more_information_url]',
			'description' => 'URL of the More Information link appended to each alert: http://www.ucf.edu/alert/',
			'value'       => $theme_options['alert_more_information_url'],
		)),
	)
);

/**
 * Favicon, RSS url for header
 **/
Config::$links = array(
	array('rel' => 'shortcut icon', 'href' => THEME_IMG_URL.'/favicon.ico',),
	array('rel' => 'alternate', 'type' => 'application/rss+xml', 'href' => get_bloginfo('rss_url'),),
);

/**
 * Add css files to the list of stylesheet references in the header
 **/
Config::$styles = array(
	array('admin' => True, 'src' => THEME_CSS_URL.'/admin.css',),
	THEME_STATIC_URL.'/bootstrap/bootstrap/css/bootstrap.min.css',
	THEME_STATIC_URL.'/css/university-header.css',
);

// Default bootstrap responsive styles
if ($theme_options['bootstrap_enable_responsive'] == 1) {
	array_push(Config::$styles, 
		THEME_STATIC_URL.'/bootstrap/bootstrap/css/bootstrap-responsive.min.css'
	);		
}

array_push(Config::$styles,	
	// Force GravityForms styles here so we can override them
	plugins_url( 'gravityforms/css/forms.css' ),
	THEME_CSS_URL.'/webcom-base.css', 
	get_bloginfo('stylesheet_url')
);

// Custom responsive styles
if ($theme_options['bootstrap_enable_responsive'] == 1) {
	array_push(Config::$styles, 
		THEME_URL.'/style-responsive.css'
	);	
}

array_push(Config::$styles,	
	array('src' => THEME_CSS_URL.'/print.css', 'media' => 'print')
);


/**
 * Add javascript to the list of javascript references in the header + footer
 **/
Config::$scripts = array(
	array('admin' => True, 'src' => THEME_JS_URL.'/admin.js',),
	THEME_STATIC_URL.'/bootstrap/bootstrap/js/bootstrap.min.js',
	THEME_JS_URL.'/jFeed.js',
	THEME_JS_URL.'/jquery.cookie.js',
	array('name' => 'base-script',  'src' => THEME_JS_URL.'/webcom-base.js',),
	array('name' => 'theme-script', 'src' => THEME_JS_URL.'/script.js',),
);

function jquery_in_header() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.7.1.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action('wp_enqueue_scripts', 'jquery_in_header');

/**
 * Meta content for header
 **/
Config::$metas = array(
	array('charset' => 'utf-8',),
);
if ($theme_options['gw_verify']){
	Config::$metas[] = array(
		'name'    => 'google-site-verification',
		'content' => htmlentities($theme_options['gw_verify']),
	);
}
