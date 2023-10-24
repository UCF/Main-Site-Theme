<?php
/**
 * Template Name: Expert Profile
 * Template Post Type: person
 */
?>

<?php get_header(); the_post(); ?>

<?php get_template_part( 'template-parts/expert/at_a_glance' ); ?>
<?php get_template_part( 'template-parts/expert/bio_meta' ); ?>
<?php get_template_part( 'template-parts/expert/news' ); ?>
<?php get_template_part( 'template-parts/expert/marketing' ); ?>
<?php get_footer(); ?>