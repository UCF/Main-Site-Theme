<?php
/**
 * Provides functionality for the Modal Fields
 * on various templates.
 */

/**
 * Checks to see if the page or taxonomy object
 * has more than one modal assigned.
 * @author Jim Barnes
 * @since 3.16.0
 * 
 * @return array|false
 */
function obj_has_modals() {
    $obj = get_queried_object();
    $modals = null;

    if ( is_a( $obj, 'WP_Post' ) ) {
        $modals = get_field( 'page_modals', $obj->ID );
        return count( $modals ) > 0 ? $modals : false;
    } else if ( is_a( $obj, 'WP_Term' ) ) {
        $modals = get_field( 'page_modals', "colleges_" . $obj->term_id );
        return $modals !== null && count( $modals ) > 0 ? $modals : false;
    }

    return $modals !== null && count( $modals ) > 0 ? $modals : false;
}

/**
 * Returns the markup for the modal
 * @author Jim Barnes
 * @since 3.16.0
 * 
 * @param array The ACF field options
 * 
 * @return string
 */
function get_modal_markup( $modal, $idx = 0 ) {
    $modal_id = generate_modal_id( $modal, $idx );
    $classes = array( 'modal-dialog' );

    if ( $modal['modal_size'] !== 'default' ) {
        $classes[] = $modal['modal_size'];
    }

    $modal_classes = implode( ' ', $classes );

    $modal_contents = $modal['modal_contents'];

    if ( $modal['modal_type'] === 'slate' ) {
        $slate_div_id = 'form_bad6c39a-5c60-4895-9128-5785ce014085';
        $modal_contents .= "<div id=\"$slate_div_id\">Loading&hellip;</div>";
        $rfi_form_src = get_degree_request_info_url_graduate( array(
            'output' => 'embed',
            'div' => $slate_div_id
        ) );
    }

    ob_start();
?>
    <div id="<?php echo $modal_id; ?>" class="modal fade slate-modal"  tabindex="-1" role="dialog" aria-labelledby="<?php echo $modal_id ?>-label" aria-hidden="true">
        <div class="<?php echo $modal_classes; ?>" role="document">
            <div class="modal-content">
                <div class="modal-header px-4 pt-4">
                    <h2 id="<?php echo $modal_id; ?>-label" class="h5 modal-title d-flex align-items-center">
                        <?php echo do_shortcode( $modal['modal_heading'] ); ?>
                    </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <div class="modal-body mb-2 px-4 pb-4">
                    <?php echo $modal_contents; ?>
                    <?php if ( $modal['modal_type'] === 'slate' ) : ?>
                    <script>
                    /*<![CDATA[*/
                    var script = document.createElement('script');
                    script.async = 1;
                    script.src = '<?php echo $rfi_form_src; ?>' + ((location.search.length > 1) ? '&' + location.search.substring(1) : '');
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(script, s);
                    /*]]>*/
                    </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

/**
 * Simple function for handling modals
 * on the page or taxonomy.
 * @author Jim Barnes
 * @since 3.16.0
 * 
 * @return string
 */
function get_modals() {
    if ( $modals = obj_has_modals() ) {
        foreach( $modals as $idx => $modal ) {
            echo get_modal_markup( $modal, $idx );
        }
    }
}

/**
 * Generates a unique modal ID
 * @author Jim Barnes
 * @since 3.16.0
 * 
 * @param array The modal options in array form
 * @param int The index of the modal on the page
 * 
 * @return string
 */
function generate_modal_id( $modal, $idx = 0 ) {
    if ( $modal['modal_id'] ) return $modal['modal_id'];

    $modal_id = sanitize_title( $modal['modal_heading'] );
    $modal_id .= $idx > 0 ? "-{$idx}" : '';

    return $modal_id;
}

/**
 * Enqueues the slate javascript if any of the forms
 * include a slate ID
 * @author Jim Barnes
 * @since 3.16.0
 */
function enqueue_slate_js() {
    $theme = wp_get_theme();
	$theme_version = $theme->get( 'Version' );

    $args = array(
        'strategy'  => 'async',
        'in_footer' => true
    );

    if ( $modals = obj_has_modals() ) {
        foreach( $modals as $idx => $modal ) {
            if ( $modal['modal_type'] === 'slate' ) {
                wp_enqueue_script( 'mainsite-degree-page', THEME_JS_URL . '/degree-page.min.js', array( 'jquery' ), $theme_version, true );
            } else if ( $modal['modal_type'] === 'custom' ) {
                $modal_id = generate_modal_id( $modal, $idx );
                
                if ( $modal['modal_custom_css'] ) {
                    wp_enqueue_script( "$modal_id-css", $modal['modal_custom_css'], array( 'style' ) );
                }

                if ( $modal['modal_custom_js'] ) {
                    wp_enqueue_script( "$modal_id-js", $modal['modal_custom_js'], array( 'script' ), false, $args );
                }
            }
        }
    }
}

add_action( 'wp_enqueue_scripts', 'enqueue_slate_js', 10, 0 );

/**
 * Enqueues the admin script that allows for the 
 * modal toggle to be copied to a clipboard.
 * @author Jim Barnes
 * @since 3.16.0
 * @param string $hook The hook name of the screen being loaded
 *
 */
function enqueue_shortcode_copy_script( $hook ) {
    if ( ! in_array( $hook, array( 'post.php', 'term.php' ) ) ) return;

    $args = array(
        'strategy'  => 'async',
        'in_footer' => true
    );

    wp_enqueue_script( 'modal-shortcode-copy-script', THEME_JS_URL . '/modal-shortcode-copy.min.js', array('jquery'), false, $args );
}

add_action( 'admin_enqueue_scripts', 'enqueue_shortcode_copy_script', 10, 1 );