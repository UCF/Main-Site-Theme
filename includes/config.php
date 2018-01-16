<?php
/**
 * Handle all theme configuration here
 **/

define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_STATIC_URL', THEME_URL . '/static' );
define( 'THEME_CSS_URL', THEME_STATIC_URL . '/css' );
define( 'THEME_JS_URL', THEME_STATIC_URL . '/js' );
define( 'THEME_CUSTOMIZER_PREFIX', 'ucf_main_site_' );
define( 'THEME_CUSTOMIZER_DEFAULTS', serialize( array(
	'degrees_undergraduate_application' => 'https://apply.ucf.edu/application/',
	'degrees_graduate_application'      => 'https://application.graduate.ucf.edu/#/',
	'degrees_visit_ucf_url'             => 'https://apply.ucf.edu/forms/campus-tour/',
	'cloud_typography_key'              => '//cloud.typography.com/730568/675644/css/fonts.css',
	'gw_verify'                         => '8hYa3fslnyoRE8vg6COo48-GCMdi5Kd-1qFpQTTXSIw',
	'gtm_id'                            => 'GTM-MBPLZH',
	'chartbeat_uid'                     => '2806',
	'chartbeat_domain'                  => 'ucf.edu',
	'search_service_url'                => 'https://search.smca.ucf.edu/service.php'
) ) );

function __init__() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'title-tag' );

	add_image_size( 'header-img', 575, 575, true );
	add_image_size( 'header-img-sm', 767, 500, true );
	add_image_size( 'header-img-md', 991, 500, true );
	add_image_size( 'header-img-lg', 1199, 500, true );
	add_image_size( 'header-img-xl', 1600, 500, true );
	add_image_size( 'bg-img', 575, 2000, true );
	add_image_size( 'bg-img-sm', 767, 2000, true );
	add_image_size( 'bg-img-md', 991, 2000, true );
	add_image_size( 'bg-img-lg', 1199, 2000, true );
	add_image_size( 'bg-img-xl', 1600, 2000, true );


	register_nav_menu( 'header-menu', __( 'Header Menu' ) );
	register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
}

add_action( 'after_setup_theme', '__init__' );


function define_customizer_sections( $wp_customize ) {
	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees',
		array(
			'title' => 'Degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'phonebook',
		array(
			'title' => 'Phonebook'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'webfonts',
		array(
			'title' => 'Web Fonts'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'analytics',
		array(
			'title' => 'Analytics'
		)
	);
}

add_action( 'customize_register', 'define_customizer_sections' );


function define_customizer_fields( $wp_customize ) {
	// Degrees
	$wp_customize->add_setting(
		'degrees_undergraduate_application',
		array(
			'default' => get_theme_mod_default( 'degrees_undergraduate_application' )
		)
	);

	$wp_customize->add_control(
		'degrees_undergraduate_application',
		array(
			'type'        => 'text',
			'label'       => 'Undergraduate Application URL',
			'description' => 'The url of the online undergraduate application.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_setting(
		'degrees_graduate_application',
		array(
			'default' => get_theme_mod_default( 'degrees_graduate_application' )
		)
	);

	$wp_customize->add_control(
		'degrees_graduate_application',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Application URL',
			'description' => 'The url of the online graudate application.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_setting(
		'degrees_visit_ucf_url',
		array(
			'default' => get_theme_mod_default( 'degrees_visit_ucf_url' )
		)
	);

	$wp_customize->add_control(
		'degrees_visit_ucf_url',
		array(
			'type'        => 'text',
			'label'       => 'Visit UCF URL',
			'description' =>'URL for the campus tour application.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_setting(
		'tuition_value_message'
	);

	$wp_customize->add_control(
		'tuition_value_message',
		array(
			'type'        => 'textarea',
			'label'       => 'Tuition Value Message',
			'description' => 'The message displayed above the tuition per credit hour on degree pages.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_setting(
		'tuition_disclaimer'
	);

	$wp_customize->add_control(
		'tuition_disclaimer',
		array(
			'type'        => 'textarea',
			'label'       => 'Tuition Disclaimer',
			'description' => 'The message displayed below the tuition per credit hour on degree pages.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	//Phonebook
	$wp_customize->add_setting(
		'search_service_url'
	);

	$wp_customize->add_control(
		'search_service_url',
		array(
			'type'        => 'text',
			'label'       => 'Search Service URL',
			'description' => 'The base url of the UCF Search service.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'phonebook'
		)
	);

	// Web Fonts
	$wp_customize->add_setting(
		'cloud_typography_key',
		array(
			'default' => get_theme_mod_default( 'cloud_typography_key' )
		)
	);

	$wp_customize->add_control(
		'cloud_typography_key',
		array(
			'type'        => 'text',
			'label'       => 'Cloud.Typography CSS Key URL',
			'description' => 'The CSS Key provided by Cloud.Typography for this project.  <strong>Only include the value in the "href" portion of the link
								tag provided; e.g. "//cloud.typography.com/000000/000000/css/fonts.css".</strong><br><br>NOTE: Make sure the Cloud.Typography
								project has been configured to deliver fonts to this site\'s domain.<br>
								See the <a target="_blank" href="http://www.typography.com/cloud/user-guide/managing-domains">Cloud.Typography docs on managing domains</a> for more info.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'webfonts'
		)
	);

	// Analytics
	$wp_customize->add_setting(
		'gw_verify',
		array(
			'default' => get_theme_mod_default( 'gw_verify' )
		)
	);

	$wp_customize->add_control(
		'gw_verify',
		array(
			'type'        => 'text',
			'label'       => 'Google WebMaster Verification',
			'description' => 'Example: <em>9Wsa3fspoaoRE8zx8COo48-GCMdi5Kd-1qFpQTTXSIw</em>',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'gtm_id',
		array(
			'default' => get_theme_mod_default( 'gtm_id' )
		)
	);

	$wp_customize->add_control(
		'gtm_id',
		array(
			'type'        => 'text',
			'label'       => 'Google Tag Manager Container ID',
			'description' => 'The ID for the container in Google Tag Manager that represents this site.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'chartbeat_uid',
		array(
			'default' => get_theme_mod_default( 'chartbeat_uid' )
		)
	);

	$wp_customize->add_control(
		'chartbeat_uid',
		array(
			'type'        => 'text',
			'label'       => 'Chartbeat UID',
			'description' => 'Example: <em>1842</em>',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'chartbeat_domain',
		array(
			'default' => get_theme_mod_default( 'chartbeat_domain' )
		)
	);

	$wp_customize->add_control(
		'chartbeat_domain',
		array(
			'type'        => 'text',
			'label'       => 'Chartbeat Domain',
			'description' => 'Example: <em>some.domain.com</em>',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);
}

add_action( 'customize_register', 'define_customizer_fields' );


/**
 * Allow extra file types to be uploaded to the media library.
 **/
function custom_mimes( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';

	return $mimes;
}

add_filter( 'upload_mimes', 'custom_mimes' );


/**
 * Enable TinyMCE formatting options in the Athena Shortcodes plugin.
 **/
if ( function_exists( 'athena_sc_tinymce_init' ) ) {
	add_filter( 'athena_sc_enable_tinymce_formatting', '__return_true' );
}


/**
 * Allow special tags in post bodies that would get stripped otherwise for most users.
 * Modifies $allowedposttags defined in wp-includes/kses.php
 *
 * http://wordpress.org/support/topic/div-ids-being-stripped-out
 * http://wpquicktips.wordpress.com/2010/03/12/how-to-change-the-allowed-html-tags-for-wordpress/
 **/
$allowedposttags['input'] = array(
	'type' => array(),
	'value' => array(),
	'id' => array(),
	'name' => array(),
	'class' => array()
);
$allowedposttags['select'] = array(
	'id' => array(),
	'name' => array()
);
$allowedposttags['option'] = array(
	'id' => array(),
	'name' => array(),
	'value' => array()
);
$allowedposttags['iframe'] = array(
	'type' => array(),
	'value' => array(),
	'id' => array(),
	'name' => array(),
	'class' => array(),
	'src' => array(),
	'height' => array(),
	'width' => array(),
	'allowfullscreen' => array(),
	'frameborder' => array()
);
$allowedposttags['object'] = array(
	'height' => array(),
	'width' => array()
);

$allowedposttags['param'] = array(
	'name' => array(),
	'value' => array()
);

$allowedposttags['embed'] = array(
	'src' => array(),
	'type' => array(),
	'allowfullscreen' => array(),
	'allowscriptaccess' => array(),
	'height' => array(),
	'width' => array()
);
// Most of these attributes aren't actually valid for some of
// the tags they're assigned to, but whatever:
$allowedposttags['div'] =
$allowedposttags['a'] =
$allowedposttags['button'] = array(
	'id' => array(),
	'class' => array(),
	'style' => array(),
	'width' => array(),
	'height' => array(),

	'align' => array(),
	'aria-hidden' => array(),
	'aria-labelledby' => array(),
	'autofocus' => array(),
	'dir' => array(),
	'disabled' => array(),
	'form' => array(),
	'formaction' => array(),
	'formenctype' => array(),
	'formmethod' => array(),
	'formonvalidate' => array(),
	'formtarget' => array(),
	'hidden' => array(),
	'href' => array(),
	'name' => array(),
	'rel' => array(),
	'rev' => array(),
	'role' => array(),
	'target' => array(),
	'type' => array(),
	'title' => array(),
	'value' => array(),

	// Bootstrap JS stuff:
	'data-dismiss' => array(),
	'data-toggle' => array(),
	'data-target' => array(),
	'data-backdrop' => array(),
	'data-spy' => array(),
	'data-offset' => array(),
	'data-animation' => array(),
	'data-html' => array(),
	'data-placement' => array(),
	'data-selector' => array(),
	'data-title' => array(),
	'data-trigger' => array(),
	'data-delay' => array(),
	'data-content' => array(),
	'data-offset' => array(),
	'data-offset-top' => array(),
	'data-loading-text' => array(),
	'data-complete-text' => array(),
	'autocomplete' => array(),
	'data-parent' => array(),
);


/**
 * Remove paragraph tag from excerpts
 **/
remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Hide unused admin tools
 **/
function hide_admin_links() {
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'hide_admin_links' );


/**
 * Prevent Wordpress from trying to redirect to a "loose match" post when
 * an invalid URL is requested.  WordPress will redirect to 404.php instead.
 *
 * See http://wordpress.stackexchange.com/questions/3326/301-redirect-instead-of-404-when-url-is-a-prefix-of-a-post-or-page-name
 **/
function no_redirect_on_404( $redirect_url ) {
	if ( is_404() ) {
		return false;
	}
	return $redirect_url;
}

add_filter( 'redirect_canonical', 'no_redirect_on_404' );


/**
 * Kill attachment pages, author pages, daily archive pages, search, and feeds.
 *
 * http://betterwp.net/wordpress-tips/disable-some-wordpress-pages/
 **/
function kill_unused_templates() {
	global $wp_query, $post;

	if ( is_author() || is_attachment() || is_day() || is_search() || is_feed() ) {
		wp_redirect( home_url() );
		exit();
	}
}

add_action( 'template_redirect', 'kill_unused_templates' );


/**
 * Disable the Yoast SEO meta box on post types that we don't need it on
 * (non-public-facing posts, i.e. Sections)
 **/
function remove_yoast_meta_boxes() {
	$post_types = array(
		'ucf_resource_link',
		'ucf_section'
	);
	foreach ( $post_types as $post_type ) {
		remove_meta_box( 'wpseo_meta', $post_type, 'normal' );
	}
}

add_action( 'add_meta_boxes', 'remove_yoast_meta_boxes' );

