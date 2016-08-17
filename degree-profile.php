<?php disallow_direct_load('single-degree.php');?>
<?php get_header(); the_post();?>
<?php
	$post = append_degree_metadata( $post, true );
	$search_page_url = get_permalink( get_page_by_title( 'Degree Search' ) );
?>
I'm the updated degree template!

<?php get_footer();?>
