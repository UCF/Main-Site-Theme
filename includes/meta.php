<?php
/**
 * Includes functions that handle registration/enqueuing of meta tags, styles,
 * and scripts in the document head and footer.
 **/

/**
 * Enqueue front-end css and js.
 **/
function enqueue_frontend_assets() {
	global $post;
	$theme = wp_get_theme();
	$theme_version = $theme->get( 'Version' );

	wp_enqueue_style( 'style', THEME_CSS_URL . '/style.min.css', null, $theme_version );

	if ( $fontkey = get_theme_mod_or_default( 'cloud_typography_key' ) ) {
		wp_enqueue_style( 'webfont', $fontkey, null, null );
	}

	// Deregister jquery and re-register newer version in the document footer.
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', null, null, true );
	wp_enqueue_script( 'jquery' );

	// Conditionally include the UCF Header
	if ( !$post || $post && get_field( 'page_disable_ucf_header', $post->ID ) !== true ) {
		wp_enqueue_script( 'ucf-header', '//universityheader.ucf.edu/bar/js/university-header.js?use-1200-breakpoint=1', null, null, true );
	}

	// Enqueue Tether and our main theme script file
	wp_enqueue_script( 'tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.7/js/tether.min.js', null, null, true );
	wp_enqueue_script( 'script', THEME_JS_URL . '/script.min.js', array( 'jquery', 'tether' ), $theme_version, true );

	// Add localized script variables to the document
	$site_url = parse_url( get_site_url() );
	wp_localize_script( 'script', 'UCFEDU', array(
		'domain' => $site_url['host']
	) );

	// Register this theme's custom degree search typeahead logic.
	// Will be enqueued late via `enqueue_degree_search_typeahead`.
	wp_register_script( 'mainsite-degree-search-typeahead', THEME_JS_URL . '/degree-search-typeahead.min.js', array( 'jquery', 'ucf-degree-search-js' ), $theme_version, true );

	// Enqueue script specific to degree profiles
	if ( $post && $post->post_type === 'degree' ) {
		wp_enqueue_script( 'mainsite-degree-page', THEME_JS_URL . '/degree-page.min.js', array( 'jquery' ), $theme_version, true );
	}

	// Register scripts and settings specific to the faculty search typeahead
	wp_register_script(
		'mainsite-faculty-search',
		THEME_JS_URL . '/faculty-search-typeahead.min.js',
		array( 'jquery', 'typeahead-js', 'handlebars-js' ),
		$theme_version,
		true
	);

	$faculty_search_url = get_faculty_search_page_url();
	ob_start();
?>
	var FACULTY_SEARCH_SETTINGS = {
		faculty: {
			dataEndpoint: "<?php echo get_rest_url( null, 'wp/v2/person?_fields=id,title,link,thumbnails,person_titles&meta_key=person_type&meta_value=faculty' ); ?>",
			selectedAction: function(event, obj) {
				window.location = obj.link;
			}
		},
		colleges: {
			dataEndpoint: "<?php echo get_rest_url( null, 'wp/v2/colleges?_fields=id,name,slug,taxonomy&per_page=50&post_types=person' ) ?>",
			selectedAction: function(event, obj) {
				window.location = "<?php echo $faculty_search_url; ?>?college=" + obj.slug;
			}
		},
		departments: {
			dataEndpoint: "<?php echo get_rest_url( null, 'wp/v2/departments?_fields=id,name,slug,taxonomy&post_types=person' ) ?>",
			selectedAction: function(event, obj) {
				window.location = "<?php echo $faculty_search_url; ?>?department=" + obj.slug;
			}
		}
	};
<?php
	$faculty_search_settings = trim( ob_get_clean() );

	wp_add_inline_script( 'mainsite-faculty-search', $faculty_search_settings, 'before' );

	// De-queue Gutenberg block styles and scripts when the Classic Editor
	// plugin is active and users are not given the option to utilize the
	// block editor at all.
	$editor_choice = get_network_option( null, 'classic-editor-replace', get_option( 'classic-editor-replace' ) );
	$allow_user_editor_choice = get_option( 'classic-editor-allow-users' );
	if (
		class_exists( 'Classic_Editor' )
		&& $editor_choice !== 'block'
		&& $allow_user_editor_choice !== 'allow'
	) {
		wp_deregister_style( 'wp-block-library' );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_frontend_assets' );


/**
 * Registers an action that enqueues this theme's custom
 * degree search typeahead logic when the Degree Search Plugin's
 * late JS enqueueing takes effect.
 *
 * @since 3.8.6
 * @author Jo Dickson
 * @return void
 */
function enqueue_degree_search_typeahead() {
	wp_enqueue_script( 'mainsite-degree-search-typeahead' );
}

add_action( 'ucf_degree_search_enqueue_scripts_after', 'enqueue_degree_search_typeahead' );


/**
 * Meta tags to insert into the document head.
 **/
function add_meta_tags() {
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php wp_site_icon(); ?>
<?php
$gw_verify = get_theme_mod_or_default( 'gw_verify' );
if ( $gw_verify ):
?>
<meta name="google-site-verification" content="<?php echo htmlentities( $gw_verify ); ?>">
<?php endif; ?>

<?php
// Preload Cloud.Typography
$cloud_typography_key = get_theme_mod_or_default( 'cloud_typography_key' );
if ( $cloud_typography_key ) :
?>
<link rel="preload" href="<?php echo $cloud_typography_key; ?>" as="style">
<?php endif; ?>

<?php // Preload Font Awesome ?>
<link rel="preload" href="<?php echo THEME_FONT_URL; ?>/font-awesome/fontawesome-webfont.woff2?v=<?php echo THEME_FA_VERSION; ?>" as="font" type="font/woff2" crossorigin>

<?php
// Inline critical CSS
$critical_css = get_critical_css();
if ( $critical_css ) :
?>
<style id="critical-css"><?php echo $critical_css; ?></style>
<?php
endif;
}

add_action( 'wp_head', 'add_meta_tags', 1 );


/**
 * Removed unneeded meta tags generated by WordPress.
 * Some of these may already be handled by security plugins.
 **/
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );


/**
 * Adds ID attribute to UCF Header script.
 **/
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


/**
 * Prints Chartbeat tracking code in the footer if a UID and Domain are set in
 * the customizer.
 **/
function add_chartbeat() {
	$uid = get_theme_mod_or_default( 'chartbeat_uid' );
	$domain = get_theme_mod_or_default( 'chartbeat_domain' );

	if ( $uid && $domain ) {
?>
<script type="text/javascript">
    var _sf_async_config = _sf_async_config || {};
    /** CONFIGURATION START **/
    _sf_async_config.uid = '<?php echo $uid; ?>'
    _sf_async_config.domain = '<?php echo $domain; ?>';
    /** CONFIGURATION END **/
    (function() {
        function loadChartbeat() {
            var e = document.createElement('script');
            e.setAttribute('language', 'javascript');
            e.setAttribute('type', 'text/javascript');
            e.setAttribute('src', '//static.chartbeat.com/js/chartbeat.js');
            document.body.appendChild(e);
        }
        var oldonload = window.onload;
        window.onload = (typeof window.onload != 'function') ?
            loadChartbeat : function() {
                oldonload();
                loadChartbeat();
            };
    })();
</script>
<?php
	}
}

add_action( 'wp_footer', 'add_chartbeat' );


/**
 * Prints the Google Tag Manager data layer snippet in the document head if a
 * GTM ID is set in the customizer.
 **/
function google_tag_manager_dl() {
	$gtm_id = get_theme_mod_or_default( 'gtm_id' );
	if ( $gtm_id ) :
?>
<script>
	dataLayer = [];
</script>
<?php
	endif;
}

add_action( 'wp_head', 'google_tag_manager_dl', 2 );


/**
 * Prints the Google Tag Manager script tag in the document head if a GTM ID is
 * set in the customizer.
 **/
function google_tag_manager() {
	$gtm_id = get_theme_mod_or_default( 'gtm_id' );
	if ( $gtm_id ) :
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $gtm_id; ?>');</script>
<!-- End Google Tag Manager -->
<?php
	endif;
}

add_action( 'wp_head', 'google_tag_manager', 3 );


/**
 * Prints the Google Tag Manager noscript snippet using the GTM ID in Theme Options.
 **/
function google_tag_manager_noscript() {
	$gtm_id = get_theme_mod_or_default( 'gtm_id' );
	if ( $gtm_id ) :
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $gtm_id; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
	endif;
}

add_action( 'wp_body_open', 'google_tag_manager_noscript', 0 );


/**
 * Sets a default favicon if a site icon is not already set.
 */
function add_favicon_default() {
	if ( !has_site_icon() ):
?>
<link rel="shortcut icon" href="<?php echo THEME_URL . '/favicon.ico'; ?>" />
<?php
	endif;
}

add_filter( 'wp_head', 'add_favicon_default' );


/**
* Disables the UCF Footer if ACF page template field is set.
*/
function maybe_disable_ucf_footer() {
	global $post;
	if ( $post && ( get_field( 'page_disable_ucf_footer', $post->ID ) === true ) ) {
		remove_action( 'wp_enqueue_scripts', array( 'UCF_Footer_Common', 'enqueue_styles' ), 99 );
		add_filter( 'ucf_footer_display_footer', '__return_false' );
	}
}

add_action( 'wp_enqueue_scripts', 'maybe_disable_ucf_footer' );


/**
 * Appends additional URLs to WP's list of domains to generate
 * <link rel="dns-prefetch"> tags for.
 *
 * @since 3.8.6
 * @author Jo Dickson
 * @return array
 */
function add_dns_prefetch_domains( $urls, $relation_type ) {
	$new_urls = get_theme_mod( 'dns_prefetch_domains' );
	if ( $new_urls && $relation_type === 'dns-prefetch' ) {
		$new_urls = array_unique( array_filter( array_map( 'trim', explode( ',', $new_urls ) ) ) );
		$urls = array_merge( $urls, $new_urls );
	}
	return $urls;
}

add_filter( 'wp_resource_hints', 'add_dns_prefetch_domains', 10, 2 );


/**
 * Returns critical CSS to utilize for the provided object.
 *
 * @since 3.8.6
 * @author Jo Dickson
 * @param object $obj WordPress post or term object
 * @return string
 */
function get_critical_css( $obj=null ) {
	if ( ! $obj ) {
		$obj = get_queried_object();
	}
	if ( ! $obj ) return '';

	return get_field( 'critical_css', $obj );
}


/**
 * Updates enqueued stylesheets to load asynchronously.
 *
 * @since 3.8.6
 * @author Jo Dickson
 * @param string $html The link tag for the enqueued style.
 * @param string $handle The style's registered handle.
 * @param string $href The stylesheet's source URL.
 * @param string $media The stylesheet's media attribute.
 * @return string The modified link tag
 */
function async_enqueued_styles( $html, $handle, $href, $media ) {
	$critical_css = get_critical_css();
	if ( $critical_css ) {
		$exclude = array_filter( array_map( 'trim', explode( ',', get_theme_mod( 'async_css_exclude' ) ) ) );
		if ( ! in_array( $handle, $exclude ) && $media !== 'print' ) {
			$media_replaced = str_replace( 'media=\'' . $media . '\'', 'media=\'print\' onload=\'this.media="' . $media . '"\'', $html );
			$html = $media_replaced . '<noscript>' . $html . '</noscript>';
		}
	}

	return $html;
}

add_action( 'style_loader_tag', 'async_enqueued_styles', 99, 4 );
