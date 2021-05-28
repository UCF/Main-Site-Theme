<?php
/**
 * Default header to use when a header background is not set
 */

$obj                 = get_queried_object();
$header_content_type = get_query_var( 'header_content_type' );
?>

<?php get_template_part( 'template-parts/layout/header/nav' ); ?>
<?php get_template_part( 'template-parts/layout/header/content', $header_content_type ); ?>
