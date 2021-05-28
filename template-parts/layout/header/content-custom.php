<?php
/**
 * Markup for completely custom page header contents.
 */

$obj     = get_queried_object();
$content = get_field( 'page_header_content', $obj );
?>
<div class="header-content-inner">
	<?php
	if ( $content ) {
		echo $content;
	}
	?>
</div>
