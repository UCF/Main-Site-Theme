<?php
/**
 * Template Name: Expert Profile
 * Template Post Type: person
 */

$profile_section = get_theme_mod( 'expert_profile_closing_section' );
?>

<?php get_header(); the_post(); ?>

<?php get_template_part( 'template-parts/expert/at_a_glance' ); ?>
<?php get_template_part( 'template-parts/expert/bio_meta' ); ?>
<?php get_template_part( 'template-parts/expert/news' ); ?>
<?php get_template_part( 'template-parts/expert/marketing' ); ?>
<?php
if ( $profile_section ) {
    echo do_shortcode( "[ucf-section id='$profile_section'][/ucf-section]" );
}
?>

<?php get_footer(); ?>
