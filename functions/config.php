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
	add_theme_support( 'title-tag' );
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
define('THEME_JOBS_DIR', THEME_DIR.'/jobs');
define('THEME_STATIC_URL', THEME_URL.'/static');
define('THEME_IMG_URL', THEME_STATIC_URL.'/img');
define('THEME_JS_URL', THEME_STATIC_URL.'/js');
define('THEME_CSS_URL', THEME_STATIC_URL.'/css');
define('THEME_OPTIONS_GROUP', 'settings');
define('THEME_OPTIONS_NAME', 'theme');
define('THEME_OPTIONS_PAGE_TITLE', 'Theme Options');
define('ESI_INCLUDE_URL', THEME_STATIC_URL.'/esi.php');

# Timeout for data grabbed from feeds
define('FEED_FETCH_TIMEOUT', 10); // seconds

$theme_options = get_option(THEME_OPTIONS_NAME);


# Weather
define('WEATHER_URL', !empty($theme_options['weather_service_url']) ? $theme_options['weather_service_url'] : 'http://weather.smca.ucf.edu/');
define('WEATHER_CLICK_URL', 'http://www.weather.com/weather/today/Orlando+FL+32816');
define('WEATHER_CACHE_DURATION', 60 * 5); //seconds
define('WEATHER_FETCH_TIMEOUT', !empty($theme_options['weather_service_timeout']) ? (int)$theme_options['weather_service_timeout'] : 8); //seconds

define('CB_UID', $theme_options['cb_uid']);
define('CB_DOMAIN', $theme_options['cb_domain']);

define('SEARCH_SERVICE_URL', !empty($theme_options['search_service_url']) ? $theme_options['search_service_url'] : 'http://search.smca.ucf.edu/service.php');
define('SEARCH_SERVICE_HTTP_TIMEOUT', !empty($theme_options['search_service_timeout']) ? (int)$theme_options['search_service_timeout'] : 10); #seconds

define('UNDERGRADUATE_CATALOG_FEED_URL', !empty($theme_options['undergraduate_catalog_feed_url']) ? $theme_options['undergraduate_catalog_feed_url'] : 'http://catalog.ucf.edu/feed');
define('UNDERGRADUATE_CATALOG_FEED_HTTP_TIMEOUT', !empty($theme_options['undergraduate_catalog_feed_timeout']) ? (int)$theme_options['undergraduate_catalog_feed_timeout'] : 10); #seconds

# Estimated start/end months of semesters; used for announcements
define('CURRENT_MONTH', (int)date('n'));
define('SPRING_MONTH_START', 1); 	// Jan
define('SPRING_MONTH_END', 5);		// May
define('SUMMER_MONTH_START', 5); 	// May
define('SUMMER_MONTH_END', 7);		// Jul
define('FALL_MONTH_START', 8);		// Aug
define('FALL_MONTH_END', 12); 		// Dec

# Fallback undergraduate and graduate catalog urls
define('UNDERGRAD_CATALOG_URL', !empty( $theme_options['undergrad_catalog_url'] ) ? $theme_options['undergrad_catalog_url'] : 'http://catalog.ucf.edu');
define('GRAD_CATALOG_URL', !empty( $theme_options['grad_catalog_url'] ) ? $theme_options['grad_catalog_url'] : 'http://graduatecatalog.ucf.edu');

# Desired order of degree program types in degree lists, by program slug
define('DEGREE_PROGRAM_ORDER', serialize(array(
	'undergraduate-degree',
	'articulated-program',
	'accelerated-program',
	'minor',
	'graduate-degree',
	'certificate',
)));

/**
 * All valid degree search parameters.  Any GET params passed to the degree
 * search that aren't in this array are ignored.
 *
 * If a param must *always* have some fallback value (e.g. a param for radio
 * buttons), set it below.
 * Otherwise, each value below should be empty (e.g. an empty string '' or
 * array() ).
 **/
define( 'DEGREE_SEARCH_PAGE_COUNT', !empty( $theme_options['degrees_per_page'] ) ? $theme_options['degrees_per_page'] : 100 );

define( 'DEGREE_SEARCH_PARAMS', serialize( array(
	'program-type' => array(),
	'college' => array(),
	'sort-by' => 'title',
	'search-query' => '',
	'default' => 0,
	'offset' => 0,
	'search-default' => 0
) ) );

# Params specifically for the default view.
define( 'DEGREE_SEARCH_DEFAULT_PARAMS', serialize( array(
	'program-type' => array(),
	'college' => array(),
	'sort-by' => 'title',
	'search-query' => '',
	'default' => 1,
	'offset' => 0,
	'search-default' => 0
) ) );

# Params specifically for the default search view (view that should used
# immediately following the default view, if a user performs a search without
# modifying any filters beforehand.  Added to force program type options from
# the default view off, and to search all program types instead.)
define( 'DEGREE_SEARCH_S_DEFAULT_PARAMS', serialize( array(
	'program-type' => array(),
	'college' => array(),
	'sort-by' => 'title',
	'search-query' => '',
	'default' => 0,
	'offset' => 0,
	'search-default' => 1
) ) );

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
	'Post',
	'Degree'
);

Config::$custom_taxonomies = array(
	'OrganizationalGroups',
	'Keywords',
	'AudienceRoles',
	'ProgramTypes',
	'Colleges',
	'Departments',
	'DegreeKeywords'
);


/*
 * Edge Side Includes (ESI) are directives that tell Varnish to include some other
 * content in the page. The primary use for use to assign another cache duration
 * to the "other content".
 * To add an ESI, first add some function and any safe-to-use arguments to the ESI
 * whitelist below, then call that function by referencing its key in the whitelist
 * and any arguments using esi_include($key, $args).
 * Functions that accept/require multiple arguments should be listed here with
 * serialized set(s) of arguments (so that they can be compared as a single string).
 * Example:
 * $key => array(
 * 		'name' => $functionname,
 * 		'safe_args' => array('somearg', 'anotherarg', serialize($arrayofargs),
 * )
 */

Config::$esi_whitelist = array(
	1 => array(
		'name' => 'output_weather_data',
		'safe_args' => array('col-md-3 col-sm-3'),
		),
	2 => array(
		'name' => 'do_shortcode',
		'safe_args' => array('[events-widget]'),
		),
	3 => array(
		'name' => 'display_news',
		'safe_args' => null,
		),
	4 => array(
		'name' => 'page_specific_stylesheet',
		'safe_args' => get_all_page_ids(),
		),
);

/**
 * Configure theme settings, see abstract class Field's descendants for
 * available fields. -- functions/base.php
 **/
Config::$theme_settings = array(
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
	),
	'Analytics' => array(
		new TextField(array(
			'name'        => 'Google WebMaster Verification',
			'id'          => THEME_OPTIONS_NAME.'[gw_verify]',
			'description' => 'Example: <em>9Wsa3fspoaoRE8zx8COo48-GCMdi5Kd-1qFpQTTXSIw</em>',
			'default'     => null,
			'value'       => $theme_options['gw_verify'],
		)),
		new TextField(array(
			'name'        => 'Google Tag Manager Container ID',
			'id'          => THEME_OPTIONS_NAME.'[gtm_id]',
			'description' => 'The ID for the container in Google Tag Manager that represents this site.',
			'default'     => null,
			'value'       => $theme_options['gtm_id'],
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
	'Degrees' => array(
		new TextField(array(
			'name'        => 'Degree Fallback Header Image',
			'id'          => THEME_OPTIONS_NAME.'[fallback_degree_image]',
			'description' => 'URL for the fallback degree header image.',
			'value'       => $theme_options['fallback_degree_image'],
		)),
		new TextField(array(
			'name'        => 'Undergraduate catalog URL',
			'id'          => THEME_OPTIONS_NAME.'[undergrad_catalog_url]',
			'description' => 'URL for the undergraduate degree catalog website.',
			'default'     => 'http://catalog.ucf.edu',
			'value'       => $theme_options['undergrad_catalog_url'],
		)),
		new TextField(array(
			'name'        => 'Graduate catalog URL',
			'id'          => THEME_OPTIONS_NAME.'[grad_catalog_url]',
			'description' => 'URL for the graduate degree catalog website.',
			'default'     => 'http://graduatecatalog.ucf.edu',
			'value'       => $theme_options['grad_catalog_url'],
		)),
		new TextField(array(
			'name'        => 'Graduate Request Degree Info Button Copy',
			'id'          => THEME_OPTIONS_NAME.'[grad_degree_info_copy]',
			'description' => 'Copy for the graduate request degree info button.',
			'default'     => 'Request Degree Info',
			'value'       => $theme_options['grad_degree_info_copy'],
		)),
		new TextField(array(
			'name'        => 'Graduate Request Degree Info Button URL',
			'id'          => THEME_OPTIONS_NAME.'[grad_degree_info_url]',
			'description' => 'URL for the graduate request degree info website.',
			'default'     => 'https://ww2.graduate.ucf.edu/inquiry/',
			'value'       => $theme_options['grad_degree_info_url'],
		)),
		new TextField(array(
			'name'        => 'National Undergraduate Tuition Average (In State)',
			'id'          => THEME_OPTIONS_NAME.'[national_undergraduate_in_state_average]',
			'description' => 'The average cost per credit hours nationally for undergraduate courses',
			'value'       => $theme_options['national_undergraduate_in_state_average'],
		)),
		new TextField(array(
			'name'        => 'National Undergraduate Tuition Average (Out of State)',
			'id'          => THEME_OPTIONS_NAME.'[national_undergraduate_out_of_state_average]',
			'description' => 'The average cost per credit hours nationally for undergraduate courses',
			'value'       => $theme_options['national_undergraduate_out_of_state_average'],
		)),
		new TextField(array(
			'name'        => 'National Graduate Tuition Average (In State)',
			'id'          => THEME_OPTIONS_NAME.'[national_graduate_in_state_average]',
			'description' => 'The average cost per credit hours nationally for graduate courses',
			'value'       => $theme_options['national_graduate_in_state_average'],
		)),
		new TextField(array(
			'name'        => 'National Graduate Tuition Average (Out of State)',
			'id'          => THEME_OPTIONS_NAME.'[national_graduate_out_of_state_average]',
			'description' => 'The average cost per credit hours nationally for graduate courses',
			'value'       => $theme_options['national_graduate_out_of_state_average'],
		)),
		new TextField(array(
			'name'        => 'Degrees per page',
			'id'          => THEME_OPTIONS_NAME.'[degrees_per_page]',
			'description' => 'The number of degrees to display per page on the degee search page',
			'value'       => $theme_options['degrees_per_page'],
		)),
		new TextField(array(
			'name'        => 'Undergraduate Application URL',
			'id'          => THEME_OPTIONS_NAME.'[undergraduate_app_url]',
			'description' => 'The url of the undergraduate application for admission.',
			'value'       => $theme_options['undergraduate_app_url']
		)),
		new TextField(array(
			'name'        => 'Graduate Application URL',
			'id'          => THEME_OPTIONS_NAME.'[graduate_app_url]',
			'description' => 'The url of the graduate application for admission.',
			'value'       => $theme_options['graduate_app_url']
		))
	),
	'Tuition and Fees' => array(
		new TextField(array(
			'name'        => 'Tuition and Fees Feed URL',
			'id'          => THEME_OPTIONS_NAME.'[tuition_fee_url]',
			'description' => 'URL for the tuition and fee feed.',
			'default'     => 'http://tuitionfees.ikm.ucf.edu/feed',
			'value'       => $theme_options['tuition_fee_url'],
		)),
		new TextareaField(array(
			'name'        => 'Tuition Value Message',
			'id'          => THEME_OPTIONS_NAME.'[tuition_value_message]',
			'description' => 'HTML formatted message that will appear below the Tuition and Fees header on the degree profile page',
			'default'     => '',
			'value'       => $theme_options['tuition_value_message'],
		)),
		new TextareaField(array(
			'name'        => 'Financial Aid Message',
			'id'          => THEME_OPTIONS_NAME.'[financial_aid_message]',
			'description' => 'HTML formatted message that will appear below the Tuition and Fees content on the degree profile page',
			'default'     => '',
			'value'       => $theme_options['financial_aid_message'],
		)),
		new TextField(array(
			'name'        => 'Undergraduate Full-time Credit Hours',
			'id'          => THEME_OPTIONS_NAME.'[tuition_undergrad_hours]',
			'description' => 'The number of credit hours to calculate a full-time tuition amount for Undergraduate Degrees',
			'default'     => '30',
			'value'       => $theme_options['tuition_undergrad_hours']
		)),
		new TextField(array(
			'name'        => 'Graduate Full-time Credit Hours',
			'id'          => THEME_OPTIONS_NAME.'[tuition_grad_hours]',
			'description' => 'The number of credit hours to calculate a full-time tuition amount for Graduate Degrees',
			'default'     => '24',
			'value'       => $theme_options['tuition_grad_hours']
		))
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
		new TextareaField(array(
			'name'        => 'Events Fallback Message',
			'id'          => THEME_OPTIONS_NAME.'[events_fallback_message]',
			'description' => 'Fallback message to display when events either fail to load, or when no events are found.',
			'value'       => $theme_options['events_fallback_message'],
			'default'     => '<p>Events could not be retrieved at this time.  Please try again later.</p>',
		)),
	),
	'Home Page' => array(
		new TextareaField(array(
			'name'        => 'Home Page Description',
			'id'          => THEME_OPTIONS_NAME.'[home_desc]',
			'description' => 'Descriptive text that appears below the primary home page features (spotlights, news, events.) Allows for HTML and shortcode markup.',
			'value'       => $theme_options['home_desc'],
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
			'default'     => 'On',
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
		new RadioField(array(
			'name'        => 'Enable Edge Side Includes (ESI)',
			'id'          => THEME_OPTIONS_NAME.'[enable_esi]',
			'description' => 'Replace specified content with Edge Side Includes (ESI) to be processed by Varnish.',
			'default'     => 'Off',
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
    	new TextField(array(
    		'name'        => 'Weather Service URL',
    		'id'          => THEME_OPTIONS_NAME.'[weather_service_url]',
    		'description' => 'URL to the SMCA weather service used to grab weather data.  Useful for development when testing the weather service on different environments.',
    		'default'     => 'http://weather.smca.ucf.edu/',
    		'value'       => $theme_options['weather_service_url'],
        )),
    	new TextField(array(
    		'name'        => 'Weather Service Timeout',
    		'id'          => THEME_OPTIONS_NAME.'[weather_service_timeout]',
    		'description' => 'Number of seconds to wait before timing out a weather service request.  Default is 8 seconds.',
    		'default'     => 8,
    		'value'       => $theme_options['weather_service_timeout'],
        )),
    	new TextField(array(
    		'name'        => 'Search Service URL',
    		'id'          => THEME_OPTIONS_NAME.'[search_service_url]',
    		'description' => 'URL to the SMCA search service used to grab Academics and Phonebook Search data.  Useful for development when testing the search service on different environments.',
    		'default'     => 'http://search.smca.ucf.edu/service.php',
    		'value'       => $theme_options['search_service_url'],
        )),
    	new TextField(array(
    		'name'        => 'Search Service Timeout',
    		'id'          => THEME_OPTIONS_NAME.'[search_service_timeout]',
    		'description' => 'Number of seconds to wait before timing out a search service request.  Default is 10 seconds.',
    		'default'     => 10,
    		'value'       => $theme_options['search_service_timeout'],
        )),
    	new TextField(array(
    		'name'        => 'Undergraduate Catalog Feed URL',
    		'id'          => THEME_OPTIONS_NAME.'[undergraduate_catalog_feed_url]',
    		'description' => 'URL to the Undergraduate Catalog data feed.',
    		'default'     => 'http://catalog.ucf.edu/feed',
    		'value'       => $theme_options['undergraduate_catalog_feed_url'],
        )),
    	new TextField(array(
    		'name'        => 'Undergraduate Catalog Feed Timeout',
    		'id'          => THEME_OPTIONS_NAME.'[undergraduate_catalog_feed_timeout]',
    		'description' => 'Number of seconds to wait before timing out a catalog feed request.  Default is 10 seconds.',
    		'default'     => 10,
    		'value'       => $theme_options['undergraduate_catalog_feed_timeout'],
        )),
    	new TextField(array(
    		'name'        => 'Pegasus Magazine URL',
    		'id'          => THEME_OPTIONS_NAME.'[pegasus_url]',
    		'description' => 'URL to the Pegasus Magazine website.  Can be changed for development when testing Pegasus issue feeds on different environments.',
    		'default'     => 'https://www.ucf.edu/pegasus/',
    		'value'       => $theme_options['pegasus_url'],
        ))
	),
	'Social' => array(
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
			'default'     => 'On',
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
	'Web Fonts' => array(
		/* This theme uses the webfonts published to ucf.edu/partnerships. The hosted font files are within that theme. */
		new TextField(array(
			'name'        => 'Cloud.Typography CSS Key URL',
			'id'          => THEME_OPTIONS_NAME.'[cloud_font_key]',
			'description' => 'The CSS Key provided by Cloud.Typography for this project. <strong>Only include the value in the "href" portion of the link
								tag provided; e.g. "//cloud.typography.com/000000/000000/css/fonts.css".</strong><br/><br/>NOTE: Make sure the Cloud.Typography
								project has been configured to deliver fonts to this site\'s domain.<br/>
								See the <a target="_blank" href="http://www.typography.com/cloud/user-guide/managing-domains">Cloud.Typography docs on managing domains</a> for more info.',
			'default'     => '//cloud.typography.com/730568/675644/css/fonts.css', /* CSS Key relative to PROD project */
			'value'       => $theme_options['cloud_font_key'],
		)),
	),
);

/**
 * If Yoast SEO is activated, assume we're handling ALL SEO/meta-related
 * modifications with it.  Don't add Facebook Opengraph theme options.
 **/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
	array_unshift( Config::$theme_settings['Social'],
		new RadioField(array(
			'name'        => 'Enable OpenGraph',
			'id'          => THEME_OPTIONS_NAME.'[enable_og]',
			'description' => 'Turn on the opengraph meta information used by Facebook.',
			'default'     => 'On',
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
		))
	);
}


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
	array( 'admin' => True, 'src' => THEME_CSS_URL.'/admin.min.css' ),
	THEME_CSS_URL . '/style.min.css',
);


/**
 * Add javascript to the list of javascript references in the header + footer
 **/
Config::$scripts = array(
	array( 'admin' => True, 'src' => THEME_JS_URL.'/admin.min.js' ),
	array( 'name' => 'ucfhb-script', 'src' => '//universityheader.ucf.edu/bar/js/university-header.js' ),
	array( 'name' => 'theme-script', 'src' => THEME_JS_URL . '/script.min.js' ),
);


function enqueue_wpa11y() {
	wp_enqueue_script( 'wp-a11y' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_wpa11y' );

function jquery_in_header() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//code.jquery.com/jquery-1.11.0.min.js' );
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'jquery_in_header' );


/**
 * Meta content for header
 **/
Config::$metas = array(
	array('charset' => 'utf-8',),
);

if ( $theme_options['gw_verify'] ) {
	Config::$metas[] = array(
		'name'    => 'google-site-verification',
		'content' => htmlentities( $theme_options['gw_verify'] ),
	);
}
