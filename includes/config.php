<?php
/**
 * Handle all theme configuration here
 **/

define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_STATIC_URL', THEME_URL . '/static' );
define( 'THEME_CSS_URL', THEME_STATIC_URL . '/css' );
define( 'THEME_JS_URL', THEME_STATIC_URL . '/js' );
define( 'THEME_CUSTOMIZER_PREFIX', 'ucf_main_site_' );

function __init__() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'title-tag' );

	add_image_size( 'header-img', 575, 575, true );
	add_image_size( 'header-img-sm', 767, 400, true );
	add_image_size( 'header-img-md', 991, 400, true );
	add_image_size( 'header-img-lg', 1199, 400, true );
	add_image_size( 'header-img-xl', 1600, 400, true );
	add_image_size( 'bg-img', 575, 2000, true );
	add_image_size( 'bg-img-sm', 767, 2000, true );
	add_image_size( 'bg-img-md', 991, 2000, true );
	add_image_size( 'bg-img-lg', 1199, 2000, true );
	add_image_size( 'bg-img-xl', 1600, 2000, true );


	register_nav_menu( 'header-menu', __( 'Header Menu' ) );
	register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
}

add_action( 'after_setup_theme', '__init__' );


function enqueue_frontend_assets() {
	wp_enqueue_style( 'style', THEME_CSS_URL . '/style.min.css' );

	if ( $fontkey = get_theme_mod( 'cloud_typography_key' ) ) {
		wp_enqueue_style( 'webfont', $fontkey );
	}

	// Deregister jquery and re-register newer version in the document head.
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//code.jquery.com/jquery-3.2.1.min.js', null, null, false );
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js', null, null, true );
	wp_enqueue_script( 'ucf-header', '//universityheader.ucf.edu/bar/js/university-header.js?use-1200-breakpoint=1', null, null, true );
	wp_enqueue_script( 'script', THEME_JS_URL . '/script.min.js', array( 'jquery', 'tether' ), null, true );

	// Add localized script variables to the document
	$site_url = parse_url( get_site_url() );
	wp_localize_script( 'script', 'UCFEDU', array(
		'domain' => $site_url['host']
	) );
}

add_action( 'wp_enqueue_scripts', 'enqueue_frontend_assets' );


/**
 * Meta tags to insert into the document head.
 **/
function add_meta_tags() {
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
}

add_action( 'wp_head', 'add_meta_tags', 1 );


function add_id_to_ucfhb( $url ) {
	if (
		( false !== strpos($url, 'bar/js/university-header.js' ) )
		|| ( false !== strpos( $url, 'bar/js/university-header-full.js' ) )
	) {
      remove_filter( 'clean_url', 'add_id_to_ucfhb', 10, 3 );
      return "$url' id='ucfhb-script";
    }
    return $url;
}

add_filter( 'clean_url', 'add_id_to_ucfhb', 10, 1 );


function define_customizer_sections( $wp_customize ) {
	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees',
		array(
			'title' => 'Degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'webfonts',
		array(
			'title' => 'Web Fonts'
		)
	);
}

add_action( 'customize_register', 'define_customizer_sections' );


function define_customizer_fields( $wp_customize ) {
	// Degrees
	$wp_customize->add_setting(
		'degrees_undergraduate_application',
		array(
			'default' => 'https://apply.ucf.edu/application/'
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
			'default' => 'https://application.graduate.ucf.edu/#/'
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
			'default' => 'https://apply.ucf.edu/forms/campus-tour/'
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
			'label'       => 'Tuition Value Message',
			'description' => 'The message displayed below the tuition per credit hour on degree pages.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	// Web Fonts
	$wp_customize->add_setting(
		'cloud_typography_key',
		array(
			'default' => '//cloud.typography.com/730568/675644/css/fonts.css'
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
}

add_action( 'customize_register', 'define_customizer_fields' );


/**
 * Allow extra file types to be uploaded to the media library.
 **/
function custom_mimes( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'custom_mimes' );


/**
 * Enable TinyMCE formatting options in the Athena Shortcodes plugin.
 **/
if ( is_plugin_active( 'Athena-Shortcodes-Plugin/athena-shortcodes.php' ) ) {
	add_filter( 'athena_sc_enable_tinymce_formatting', '__return_true' );
}

?>
