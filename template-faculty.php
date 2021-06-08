<?php
/**
 * Template Name: Faculty Researcher Profile
 * Template Post Type: person
 */
?>

<?php get_header(); the_post(); ?>

<?php get_template_part( 'template-parts/person/at_a_glance' ); ?>
<?php get_template_part( 'template-parts/person/bio_education' ); ?>
<?php get_template_part( 'template-parts/person/research' ); ?>
<?php get_template_part( 'template-parts/person/news' ); ?>
<?php get_template_part( 'template-parts/person/faculty_promo' ); ?>

<?php get_footer(); ?>
