<?php
/**
 * Handle all theme configuration here
 **/

define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_STATIC_URL', THEME_URL . '/static' );
define( 'THEME_STATIC_DIR', THEME_DIR . '/static' );
define( 'THEME_CSS_URL', THEME_STATIC_URL . '/css' );
define( 'THEME_CSS_DIR', THEME_STATIC_DIR . '/css' );
define( 'THEME_JS_URL', THEME_STATIC_URL . '/js' );
define( 'THEME_JS_DIR', THEME_STATIC_DIR . '/js' );
define( 'THEME_FONT_URL', THEME_STATIC_URL . '/fonts' );
define( 'THEME_FA_VERSION', '4.7.0' );
define( 'THEME_CUSTOMIZER_PREFIX', 'ucf_main_site_' );
define( 'THEME_CUSTOMIZER_DEFAULTS', serialize( array(
	'degrees_undergraduate_application'   => 'https://apply.ucf.edu/application/',
	'degrees_graduate_application'        => 'https://application.graduate.ucf.edu/#/',
	'degrees_graduate_rfi_url_base'       => 'https://applynow.graduate.ucf.edu/register/',
	'degrees_graduate_rfi_form_id'        => 'bad6c39a-5c60-4895-9128-5785ce014085',
	'degrees_careers_weight_threshold'    => 0.5,
	'degrees_careers_per_program_limit'   => 10,
	'catalog_desc_cta_intro'              => '',
	'degree_deadlines_undergraduate_deadline_order' => 'Freshmen, Transfers, International',
	'degree_deadlines_graduate_deadline_order'      => 'Domestic, International',
	'degree_careers_intro'                => 'UCF prepares you for life beyond the classroom. Here, you&rsquo;ll experience '
										   . 'a wide range of opportunity, like learning diverse skills from world-renowned '
										   . 'faculty to networking with top employers across Central Florida to gaining '
										   . 'first-hand experience in internships nearby. Achieve your degree and more as a Knight.',
	'cloud_typography_key'                => '//cloud.typography.com/730568/675644/css/fonts.css',
	'gw_verify'                           => '8hYa3fslnyoRE8vg6COo48-GCMdi5Kd-1qFpQTTXSIw',
	'gtm_id'                              => 'GTM-MBPLZH',
	'google_map_key'                      => '',
	'location_fallback_image'             => '',
	'chartbeat_uid'                       => '2806',
	'chartbeat_domain'                    => 'ucf.edu',
	'faculty_search_page_path'            => 'faculty-search',
	'search_service_url'                  => 'https://search.smca.ucf.edu/service.php'
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


function define_customizer_panels( $wp_customize ) {
	$wp_customize->add_panel(
		THEME_CUSTOMIZER_PREFIX . 'degrees',
		array(
			'title' => 'Degrees'
		)
	);
}

add_action( 'customize_register', 'define_customizer_panels' );


function define_customizer_sections( $wp_customize ) {
	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees-ctas',
		array(
			'title' => 'Calls to Action (CTAs)',
			'panel' => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance',
		array(
			'title' => 'Program at a Glance',
			'panel' => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees-description',
		array(
			'title' => 'Description',
			'panel' => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees-deadlines_apply',
		array(
			'title' => 'Application Deadlines',
			'panel' => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'degrees-skills_careers',
		array(
			'title' => 'Skills and Career Opportunities',
			'panel' => THEME_CUSTOMIZER_PREFIX . 'degrees'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'faculty_search',
		array(
			'title' => 'Faculty Search'
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

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'performance',
		array(
			'title' => 'Performance'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'location',
		array(
			'title' => 'Locations'
		)
	);

	$wp_customize->add_section(
		THEME_CUSTOMIZER_PREFIX . 'person',
		array(
			'title' => 'People'
		)
	);
}

add_action( 'customize_register', 'define_customizer_sections' );


function define_customizer_fields( $wp_customize ) {
	$section_choices = array( '' => '---' );
	$sections        = get_posts( array(
		'post_type'   => 'ucf_section',
		'numberposts' => -1,
		'orderby'     => 'post_title',
		'order'       => 'ASC'
	) );

	if ( $sections ) {
		foreach ( $sections as $section ) {
			$section_choices[$section->ID] = $section->post_title;
		}
	}


	// Degrees - CTAs
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
			'description' => 'The URL of the online undergraduate application.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-ctas'
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
			'description' => 'The URL of the online graduate application.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-ctas'
		)
	);

	$wp_customize->add_setting(
		'degrees_graduate_rfi_url_base',
		array(
			'default' => get_theme_mod_default( 'degrees_graduate_rfi_url_base' )
		)
	);

	$wp_customize->add_control(
		'degrees_graduate_rfi_url_base',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Degree RFI URL base',
			'description' => 'Base URL for the request-for-information form for graduate degrees.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-ctas'
		)
	);

	$wp_customize->add_setting(
		'degrees_graduate_rfi_form_id',
		array(
			'default' => get_theme_mod_default( 'degrees_graduate_rfi_form_id' )
		)
	);

	$wp_customize->add_control(
		'degrees_graduate_rfi_form_id',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Degree RFI Form ID',
			'description' => 'ID of the request-for-information form for graduate degrees.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-ctas'
		)
	);

	// Degrees - Program at a Glance
	$wp_customize->add_setting(
		'tuition_disclaimer'
	);

	$wp_customize->add_control(
		'tuition_disclaimer',
		array(
			'type'        => 'textarea',
			'label'       => 'Tuition Disclaimer',
			'description' => 'A message displayed below the tuition per credit hour on degree pages.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_1'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'degrees_badge_1',
			array(
				'label'      => 'Fallback Promo/Badge 1',
				'description' => 'A badge or other promotional graphic to display on all degrees that don\'t have their own set.',
				'section'    => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
			)
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_1_alt'
	);

	$wp_customize->add_control(
		'degrees_badge_1_alt',
		array(
			'type'        => 'text',
			'label'       => 'Fallback Promo/Badge 1 Alt Text',
			'description' => 'Alt text for the Badge 1 graphic. <strong>Required</strong> for the graphic to be displayed on degree profiles.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_1_link_url'
	);

	$wp_customize->add_control(
		'degrees_badge_1_link_url',
		array(
			'type'        => 'text',
			'label'       => 'Fallback Promo/Badge 1 Link URL',
			'description' => 'An Optional URL for the Badge 1 graphic to link out to.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_1_link_rel'
	);

	$wp_customize->add_control(
		'degrees_badge_1_link_rel',
		array(
			'type'        => 'text',
			'label'       => 'Fallback Promo/Badge 1 Link Rel Attribute',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_1_link_new_window',
		array(
			'default' => 0
		)
	);

	$wp_customize->add_control(
		'degrees_badge_1_link_new_window',
		array(
			'type'        => 'checkbox',
			'label'       => 'Fallback Promo/Badge 1 Link - Open in New Window',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_2'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'degrees_badge_2',
			array(
				'label'      => 'Fallback Promo/Badge 2',
				'description' => 'A badge or other promotional graphic to display on all degrees that don\'t have their own set.',
				'section'    => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
			)
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_2_alt'
	);

	$wp_customize->add_control(
		'degrees_badge_2_alt',
		array(
			'type'        => 'text',
			'label'       => 'Fallback Promo/Badge 2 Alt Text',
			'description' => 'Alt text for the Badge 2 graphic. <strong>Required</strong> for the graphic to be displayed on degree profiles.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_2_link_url'
	);

	$wp_customize->add_control(
		'degrees_badge_2_link_url',
		array(
			'type'        => 'text',
			'label'       => 'Fallback Promo/Badge 2 Link URL',
			'description' => 'An Optional URL for the Badge 2 graphic to link out to.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_2_link_rel'
	);

	$wp_customize->add_control(
		'degrees_badge_2_link_rel',
		array(
			'type'        => 'text',
			'label'       => 'Fallback Promo/Badge 2 Link Rel Attribute',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	$wp_customize->add_setting(
		'degrees_badge_2_link_new_window',
		array(
			'default' => 0
		)
	);

	$wp_customize->add_control(
		'degrees_badge_2_link_new_window',
		array(
			'type'        => 'checkbox',
			'label'       => 'Fallback Promo/Badge 2 Link - Open in New Window',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-program_at_a_glance'
		)
	);

	// Degrees - Description
	$wp_customize->add_setting(
		'degrees_sidebar_promo_undergraduate'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'degrees_sidebar_promo_undergraduate',
			array(
				'label'       => 'Undergraduate Promo Graphic',
				'description' => 'An image or other promotional graphic to display alongside undergraduate catalog descriptions.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
			)
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_undergraduate_alt'
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_undergraduate_alt',
		array(
			'type'        => 'text',
			'label'       => 'Undergraduate Promo Graphic Alt Text',
			'description' => 'Alt text for the Undergraduate Promo graphic.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_undergraduate_link_url'
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_undergraduate_link_url',
		array(
			'type'        => 'text',
			'label'       => 'Undergraduate Promo Link URL',
			'description' => 'An optional URL for the Undergraduate Promo graphic to link out to.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_undergraduate_link_rel'
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_undergraduate_link_rel',
		array(
			'type'        => 'text',
			'label'       => 'Undergraduate Promo Link Rel Attribute',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_undergraduate_link_new_window',
		array(
			'default' => 0
		)
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_undergraduate_link_new_window',
		array(
			'type'        => 'checkbox',
			'label'       => 'Undergraduate Promo Link - Open in New Window',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_graduate'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'degrees_sidebar_promo_graduate',
			array(
				'label'       => 'Graduate Promo Graphic',
				'description' => 'An image or other promotional graphic to display alongside graduate catalog descriptions.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
			)
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_graduate_alt'
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_graduate_alt',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Promo Graphic Alt Text',
			'description' => 'Alt text for the Graduate Promo graphic.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_graduate_link_url'
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_graduate_link_url',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Promo Link URL',
			'description' => 'An optional URL for the Graduate Promo graphic to link out to.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_graduate_link_rel'
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_graduate_link_rel',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Promo Link Rel Attribute',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'degrees_sidebar_promo_graduate_link_new_window',
		array(
			'default' => 0
		)
	);

	$wp_customize->add_control(
		'degrees_sidebar_promo_graduate_link_new_window',
		array(
			'type'        => 'checkbox',
			'label'       => 'Graduate Promo Link - Open in New Window',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	$wp_customize->add_setting(
		'catalog_desc_cta_intro',
		array(
			'default' => get_theme_mod_default( 'catalog_desc_cta_intro' )
		)
	);

	$wp_customize->add_control(
		'catalog_desc_cta_intro',
		array(
			'type'        => 'textarea',
			'label'       => 'Catalog CTA Intro Text',
			'description' => 'Text to display above the "View in Catalog" button on programs that display a catalog description.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-description'
		)
	);

	// Degrees - Deadlines/Apply
	$wp_customize->add_setting(
		'degree_deadlines_undergraduate_deadline_order',
		array(
			'default' => get_theme_mod_default( 'degree_deadlines_undergraduate_deadline_order' )
		)
	);

	$wp_customize->add_control(
		'degree_deadlines_undergraduate_deadline_order',
		array(
			'type'        => 'text',
			'label'       => 'Undergraduate Deadline Type Order',
			'description' => 'A case-sensitive, comma-separated list designating the order by which deadlines should be grouped for undergraduate programs that display grouped deadlines.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-deadlines_apply'
		)
	);

	$wp_customize->add_setting(
		'degree_deadlines_graduate_deadline_order',
		array(
			'default' => get_theme_mod_default( 'degree_deadlines_graduate_deadline_order' )
		)
	);

	$wp_customize->add_control(
		'degree_deadlines_graduate_deadline_order',
		array(
			'type'        => 'text',
			'label'       => 'Graduate Deadline Type Order',
			'description' => 'A case-sensitive, comma-separated list designating the order by which deadlines should be grouped for graduate programs that display grouped deadlines.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-deadlines_apply'
		)
	);

	$wp_customize->add_setting(
		'degree_deadlines_undergraduate_fallback'
	);

	$wp_customize->add_control(
		'degree_deadlines_undergraduate_fallback',
		array(
			'type'        => 'select',
			'label'       => 'Undergraduate Degree Fallback Section',
			'description' => 'An alternate Section post to display instead of the Application Deadlines section for undergraduate programs without deadlines.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-deadlines_apply',
			'choices'     => $section_choices
		)
	);

	$wp_customize->add_setting(
		'degree_deadlines_graduate_fallback'
	);

	$wp_customize->add_control(
		'degree_deadlines_graduate_fallback',
		array(
			'type'        => 'select',
			'label'       => 'Graduate Degree Fallback Section',
			'description' => 'An alternate Section post to display instead of the Application Deadlines section for graduate programs without deadlines.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-deadlines_apply',
			'choices'     => $section_choices
		)
	);

	// Degrees - Skills and Career Opportunities
	$wp_customize->add_setting(
		'degree_careers_intro',
		array(
			'default' => get_theme_mod_default( 'degree_careers_intro' )
		)
	);

	$wp_customize->add_control(
		'degree_careers_intro',
		array(
			'type'        => 'textarea',
			'label'       => 'Degree Career Fallback Intro Text',
			'description' => 'Text to display next to a program\'s careers when a list of learnable skills is not set.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-skills_careers'
		)
	);

	$wp_customize->add_setting(
		'degrees_careers_weight_threshold',
		array(
			'default' => get_theme_mod_default( 'degrees_careers_weight_threshold' )
		)
	);

	$wp_customize->add_control(
		'degrees_careers_weight_threshold',
		array(
			'type'        => 'text',
			'label'       => 'Degree Career Weight Threshold',
			'description' => 'The weight threshold a weighted job position must meet in order to be imported.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-skills_careers'
		)
	);

	$wp_customize->add_setting(
		'degrees_careers_per_program_limit',
		array(
			'default' => get_theme_mod_default( 'degrees_careers_per_program_limit' )
		)
	);

	$wp_customize->add_control(
		'degrees_careers_per_program_limit',
		array(
			'type'        => 'text',
			'label'       => 'Degree Career Program Limit',
			'description' => 'The maximum number of job careers to import from the search service.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'degrees-skills_careers'
		)
	);

	// Faculty Search
	$wp_customize->add_setting(
		'faculty_search_page_path',
		array(
			'default' => get_theme_mod_default( 'faculty_search_page_path' )
		)
	);

	$wp_customize->add_control(
		'faculty_search_page_path',
		array(
			'type'        => 'text',
			'label'       => 'Faculty Search Page Path',
			'description' => 'Relative path from the main site root that the Faculty Search page lives at.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'faculty_search'
		)
	);

	// Phonebook
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

	// Performance Settings
	$wp_customize->add_setting(
		'dns_prefetch_domains'
	);

	$wp_customize->add_control(
		'dns_prefetch_domains',
		array(
			'type'        => 'textarea',
			'label'       => 'Additional Required Origins for DNS Prefetching',
			'description' => 'Specify a comma-separated list of domains to third-party origins that should be prefetched using <code>&lt;link rel="dns-prefetch"&gt;</code> that WordPress doesn\'t already handle out-of-the-box.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'performance'
		)
	);

	$wp_customize->add_setting(
		'async_css_exclude'
	);

	$wp_customize->add_control(
		'async_css_exclude',
		array(
			'type'        => 'textarea',
			'label'       => 'Exclude Stylesheets',
			'description' => 'Specify a comma-separated list of stylesheet handles that should not be loaded asynchronously when critical CSS is in use.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'performance'
		)
	);

	// Locations
	$wp_customize->add_setting(
		'google_map_key',
		array(
			'default' => get_theme_mod_default( 'google_map_key' )
		)
	);

	$wp_customize->add_control(
		'google_map_key',
		array(
			'type'        => 'text',
			'label'       => 'Google Map Key',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'location'
		)
	);

	$wp_customize->add_setting(
		'location_fallback_image',
		array(
			'default' => get_theme_mod_default( 'location_fallback_image' )
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'location_fallback_image',
			array(
				'label'      => __( 'Upload a Location Fallback Image', 'theme_name' ),
				'description' => 'The image displayed if not available in location data.',
				'section'    => THEME_CUSTOMIZER_PREFIX . 'location'
			)
		)
	);

	$wp_customize->add_setting(
		'fallback_location_header'
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'fallback_location_header',
			array(
				'label'       => __( 'Upload a default header image (large) for locations' ),
				'description' => 'The large background image displayed for location posts.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'location',
				'width'       => 1600,
				'height'      => 550,
				'flex_width'  => false,
				'flex_height' => false
			)
		)
	);

	$wp_customize->add_setting(
		'fallback_location_header_xs'
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'fallback_location_header_xs',
			array(
				'label'       => __( 'Upload a default header image (small) for locations' ),
				'description' => 'The small background image displayed for location posts.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'location',
				'width'       => 575,
				'height'      => 575,
				'flex_width'  => false,
				'flex_height' => false
			)
		)
	);

	$wp_customize->add_setting(
		'location_ankle_content'
	);

	$wp_customize->add_control(
		'location_ankle_content',
		array(
			'label'       => 'Location Ankle Content',
			'description' => 'The content that appears at the bottom of all location profiles.',
			'type'        => 'textarea',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'location'
		)
	);

	// People
	$wp_customize->add_setting(
		'fallback_person_thumbnail'
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'fallback_person_thumbnail',
			array(
				'label'       => __( 'Default thumbnail' ),
				'description' => 'The default thumbnail image for people when a featured image isn\'t set.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'person',
				'mime_type'   => 'image'
			)
		)
	);

	$wp_customize->add_setting(
		'fallback_person_header'
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'fallback_person_header',
			array(
				'label'       => __( 'Default header image (-sm+)' ),
				'description' => 'The default background image displayed in the header of person profiles at the -sm breakpoint and up.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'person',
				'width'       => 1600,
				'height'      => 330,
				'flex_width'  => false,
				'flex_height' => false
			)
		)
	);

	$wp_customize->add_setting(
		'fallback_person_header_xs'
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'fallback_person_header_xs',
			array(
				'label'       => __( 'Default header image (-xs)' ),
				'description' => 'The default background image displayed in the header of person profiles at the -xs breakpoint.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'person',
				'width'       => 575,
				'height'      => 440,
				'flex_width'  => false,
				'flex_height' => false
			)
		)
	);

	$wp_customize->add_setting(
		'person_heading_text_color',
		array (
			'default' => 'person-heading-text-secondary'
		)
	);

	$wp_customize->add_control(
		'person_heading_text_color',
		array(
			'label'       => __( 'Heading Text Color' ),
			'description' => 'Select the text color that meets 4.5:1 color contrast ratio against the selected background image for the -lg breakpoint and up. Heading text is not displayed on top of the image at the -md breakpoint and lower.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'person',
			'type'        => 'radio',
			'choices'     => array(
				'person-heading-text-secondary' => 'Black',
				'person-heading-text-inverse'   => 'White',
			)
		)
	);

	$wp_customize->add_setting(
		'published_research_image'
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'published_research_image',
			array(
				'label'       => __( 'Faculty - Published Research Graphic' ),
				'description' => 'An icon or photo to display next to a faculty member\'s published research.',
				'section'     => THEME_CUSTOMIZER_PREFIX . 'person',
				'mime_type'   => 'image'
			)
		)
	);

	$wp_customize->add_setting(
		'faculty_fallback_promo'
	);

	$wp_customize->add_control(
		'faculty_fallback_promo',
		array(
			'type'        => 'select',
			'label'       => 'Faculty Promo Default Section',
			'description' => 'An default Section post to display on faculty profiles when a person-specific Section isn\'t set.',
			'section'     => THEME_CUSTOMIZER_PREFIX . 'person',
			'choices'     => $section_choices
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
 * Ensure the UCF Post List's JS dependencies are always
 * registered if the plugin is active (the "faculty search" post
 * list layout requires them.)
 */
if ( class_exists( 'UCF_Post_List_Common' ) ) {
	add_filter( 'option_ucf_post_list_include_js_libs', '__return_true' );
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
 * Ensures that deleted/drafted degrees are 307 redirected
 * to the degree search instead of returning a 404.  Helps
 * avoid situations with broken links after running a
 * degree import.
 *
 * @since 3.4.3
 * @author Jo Dickson
 */
function stale_degree_redirect() {
	global $wp_query;

	// is_singular() doesn't return an accurate value
	// this early, so investigate $wp_query directly instead:
	if (
		is_404()
		&& isset( $wp_query->query['post_type'] )
		&& $wp_query->query['post_type'] === 'degree'
	) {
		wp_redirect( home_url( '/degree-search/' ), 307 );
		exit();
	}
}

add_filter( 'template_redirect', 'stale_degree_redirect' );


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


/**
 * Ensure that empty College terms appear in Yoast's generated
 * sitemap for Colleges.
 *
 * @since v3.2.4
 * @author Jo Dickson
 * @param bool $hide_empty Yoast default setting for (defaults to true)
 * @param array $taxonomy_names Array of names for the taxonomies being processed.
 * @return bool Whether or not the taxonomy should be queried with empty terms
 */
function yoast_sitemap_empty_terms( $hide_empty, $taxonomies ) {
	if ( $taxonomies === array( 'colleges' ) ) {
		$hide_empty = false;
	}
	return $hide_empty;
}

add_filter( 'wpseo_sitemap_exclude_empty_terms', 'yoast_sitemap_empty_terms', 10, 2 );


/**
 * Returns a degree's program type formatted to be used
 * as a custom variable in Yoast titles and descriptions.
 *
 * @since v3.8.2
 * @author Cadie Stockman
 * @return string program type title
 */
function get_yoast_title_degree_program_type() {
	global $post;
	if ( ! $post || $post->post_type !== 'degree' ) return;

	$program_type = get_degree_program_type( $post );

	switch ( $program_type->name ) {
		case 'Master':
			return 'Master\'s Degree';
			break;
		case 'Bachelor':
			return 'Bachelor\'s Degree';
			break;
		default:
			return $program_type->name;
			break;
	}
}


/**
 * Registers the Yoast variable additions.
 * NOTE: The snippet preview in the backend will show the custom variable markup
 * (i.e. '%%program_type%%') but the variable's output will be utilized on the front-end.
 *
 * @since v3.8.2
 * @author Cadie Stockman
 */
function yoast_register_variables() {
	wpseo_register_var_replacement( '%%program_type%%', 'get_yoast_title_degree_program_type', 'advanced', 'Provides a program_type string for usage in degree titles.' );
}

add_action( 'wpseo_register_extra_replacements', 'yoast_register_variables' );


/**
 * Ensures that only published degrees are available to
 * select from when picking existing degrees for Colleges'
 * "Top Degrees" lists.
 *
 * @since 3.4.2
 * @author Jo Dickson
 * @param array $args WP_Query args
 * @param array $field Array of ACF field settings
 * @param int $post_id Post ID
 * @return array Modified query args
 */
function college_top_degrees_options( $args, $field, $post_id ) {
	$args['post_status'] = array( 'publish' );
	return $args;
}

add_filter( 'acf/fields/post_object/query/name=top_degrees', 'college_top_degrees_options', 10, 3 );


/**
 * Prevent the Lazy Loader plugin from modifying contents of REST API feeds.
 *
 * @since v3.3.9
 * @author Jo Dickson
 */
function disable_lazyload_in_rest() {
	global $lazy_loader;

	if (
		isset( $lazy_loader )
		&& $lazy_loader instanceof FlorianBrinkmann\LazyLoadResponsiveImages\Plugin
	) {
		remove_filter( 'the_content', array( $lazy_loader, 'filter_markup' ), 10001 );
	}
}

add_action( 'rest_api_init', 'disable_lazyload_in_rest' );


/**
 * Disable the post content WYSIWYG editor for degrees
 * that use the 'modern' degree template
 *
 * @since 3.4.0
 * @author Jo Dickson
 */
function modern_degree_hide_editor() {
	$current_screen = get_current_screen();

	if (
		$current_screen
		&& $current_screen->id === 'degree'
		&& $current_screen->post_type === 'degree'
	) {
		$post_id = $_GET['post'];
		if ( ! $post_id ) return;

		if ( get_page_template_slug( $post_id ) !== 'template-degree-custom.php' ) {
			remove_post_type_support( 'degree', 'editor' );
		}
	}
}

add_action( 'admin_head', 'modern_degree_hide_editor' );


/**
 * Removes editability of repeater fields that have
 * the CSS class `repeater-field-readonly` applied to
 * them, ultimately resulting in read-only repeaters.
 *
 * @since 3.6.0
 * @author Jo Dickson
 */
function read_only_repeater_fields() {
	ob_start();
?>
	<script type="text/javascript">
	(function($) {

		acf.add_action('ready', function( $el ) {

			var $readonly_fields = $('.repeater-field-readonly');
			$readonly_fields.each(function() {
				var $field = $(this);

				$field
					.find('.acf-actions')
						.remove()
						.end()
					.find('.acf-row-handle')
						.remove()
			});

		});

	})(jQuery);
	</script>
<?php
	echo ob_get_clean();
}

add_action( 'acf/input/admin_footer', 'read_only_repeater_fields' );


/**
 * Hides the <thead> of repeater fields that have
 * the CSS class `repeater-field-hide-thead` applied to
 * them to improve readability.
 *
 * @since 3.10.0
 * @author Cadie Stockman
 */
function hidden_thead_repeater_fields() {
	ob_start();
?>
	<style type="text/css">
		.repeater-field-hide-thead thead {
			display: none;
		}
	</style>
<?php
	echo ob_get_clean();
}

add_action( 'acf/input/admin_head', 'hidden_thead_repeater_fields' );


/**
 * Adds new columns for displaying degree template names
 * and the types of available degree descriptions in the
 * degree list admin view.
 *
 * Removes the Tags and Areas of Interests columns.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param array $columns Existing column data
 * @return array Modified column data
 */
function degree_admin_define_columns( $columns ) {
	$columns['avail_desc'] = 'Available Description';
	$columns['template'] = 'Template';

	if ( isset( $columns['tags'] ) ) {
		unset( $columns['tags'] );
	}
	if ( isset( $columns['taxonomy-interests'] ) ) {
		unset( $columns['taxonomy-interests'] );
	}

	return $columns;
}

add_filter( 'manage_degree_posts_columns', 'degree_admin_define_columns' );


/**
 * Displays values for custom "Template" and "Available Description"
 * columns in the degree list admin view.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param string $column_name Column name
 * @param int $post_id Post ID for individual post obj's in the list
 * @return void
 */
function degree_admin_set_columns( $column_name, $post_id ) {
	switch ( $column_name ) {
		case 'avail_desc':
			$avail_desc = 'None';
			$catalog_desc = get_field( 'degree_description', $post_id );
			$custom_desc  = get_field( 'modern_description_copy', $post_id );

			if ( ! empty( $custom_desc ) ) {
				$avail_desc = 'Custom';
			} else if ( ! empty( $catalog_desc ) ) {
				$avail_desc = 'Catalog';
			}
			echo $avail_desc;
			break;
		case 'template':
			$template_name_slug_map = wp_get_theme()->get_page_templates( null, 'degree' );
			$template_slug = get_page_template_slug( $post_id );
			$template_name = array_key_exists( $template_slug, $template_name_slug_map ) ? $template_name_slug_map[$template_slug] : 'Default';
			echo $template_name;
			break;
	}
}

add_action( 'manage_degree_posts_custom_column' , 'degree_admin_set_columns', 10, 2 );


/**
 * Defines custom bulk actions for degrees.
 *
 * @since 3.8.5
 * @author Jo Dickson
 * @param array $bulk_actions Existing array of bulk action keys/names
 * @return array Modified $bulk_actions
 */
function degree_admin_define_bulk_actions( $bulk_actions ) {
	$bulk_actions['enable-rfi'] = 'Enable RFI Form';
	$bulk_actions['disable-rfi'] = 'Disable RFI Form';

	return $bulk_actions;
}

add_filter( 'bulk_actions-edit-degree', 'degree_admin_define_bulk_actions', 10, 1 );


/**
 * Defines behavior for custom degree bulk actions.
 *
 * @since 3.8.5
 * @author Jo Dickson
 * @param string $redirect_url The redirect URL when bulk action completes
 * @param string $action The action name being taken
 * @param array $post_ids Array of degree IDs to take the action on
 * @return string Redirect URL
 */
function degree_admin_set_bulk_actions( $redirect_url, $action, $post_ids ) {
	if ( in_array( $action, array( 'enable-rfi', 'disable-rfi' ) ) ) {
		$updated_value = ( $action === 'enable-rfi' );
		$query_arg     = ( $action === 'enable-rfi' ) ? 'rfi-enabled' : 'rfi-disabled';

		foreach ( $post_ids as $post_id ) {
			// `degree_custom_enable_rfi` field key
			update_field( 'field_5fad570953063', $updated_value, $post_id );
		}

		// Remove existing query args from previous requests
		$redirect_url = remove_query_arg( 'rfi-disabled', remove_query_arg( 'rfi-enabled', $redirect_url ) );

		$redirect_url = add_query_arg( $query_arg, count( $post_ids ), $redirect_url );
	}

	return $redirect_url;
}

add_filter( 'handle_bulk_actions-edit-degree', 'degree_admin_set_bulk_actions', 10, 3 );


/**
 * Defines admin notices for degree-related actions.
 *
 * @since 3.8.5
 * @author Jo Dickson
 * @return void
 */
function degree_admin_notices() {
	if ( ! empty( $_REQUEST['rfi-enabled'] ) ) {
		$num_changed = (int) $_REQUEST['rfi-enabled'];
		printf( '<div id="message" class="updated notice is-dismissable"><p>' . __( 'Enabled RFI forms on %d degrees.', 'txtdomain' ) . '</p></div>', $num_changed );
	} else if ( ! empty( $_REQUEST['rfi-disabled'] ) ) {
		$num_changed = (int) $_REQUEST['rfi-disabled'];
		printf( '<div id="message" class="updated notice is-dismissable"><p>' . __( 'Disabled RFI forms on %d degrees.', 'txtdomain' ) . '</p></div>', $num_changed );
	}
}

add_action( 'admin_notices', 'degree_admin_notices' );


/**
 * Adds new columns for displaying person template names
 * and each person's type
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param array $columns Existing column data
 * @return array Modified column data
 */
function person_admin_define_columns( $columns ) {
	$columns['type'] = 'Type';
	$columns['template'] = 'Template';

	return $columns;
}

add_filter( 'manage_person_posts_columns', 'person_admin_define_columns' );


/**
 * Displays values for custom "Template" and "Available Description"
 * columns in the degree list admin view.
 *
 * @since 3.8.0
 * @author Jo Dickson
 * @param string $column_name Column name
 * @param int $post_id Post ID for individual post obj's in the list
 * @return void
 */
function person_admin_set_columns( $column_name, $post_id ) {
	switch ( $column_name ) {
		case 'type':
			$type = ucwords( get_post_meta( $post_id, 'person_type', true ) ) ?: 'Default';
			echo $type;
			break;
		case 'template':
			$template_name_slug_map = wp_get_theme()->get_page_templates( null, 'person' );
			$template_slug = get_page_template_slug( $post_id );
			$template_name = array_key_exists( $template_slug, $template_name_slug_map ) ? $template_name_slug_map[$template_slug] : 'Default';
			echo $template_name;
			break;
	}
}

add_action( 'manage_person_posts_custom_column' , 'person_admin_set_columns', 10, 2 );
