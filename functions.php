<?php
include_once 'includes/config.php';

function get_header_images( $post ) {
    return array(
        'header_image'    => get_field( 'page_header_image', $post->ID ),
        'header_image_xs' => get_field( 'page_header_image_xs', $post->ID )
    );
}

?>
