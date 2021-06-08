<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$section = null; // TODO
	if ( $section ) :
?>
<?php
	endif;
endif;
