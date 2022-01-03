<!DOCTYPE html>
<html lang="en-us">
	<head>
		<?php wp_head(); ?>
	</head>
	<body ontouchstart <?php body_class(); ?>>
		<a class="skip-navigation bg-complementary text-inverse box-shadow-soft" href="#content">Skip to main content</a>

		<?php
		global $post;
		if ( !$post || $post && get_field( 'page_disable_ucf_header', $post->ID ) !== true ) :
		?>
		<div id="ucfhb" style="min-height: 50px; background-color: #000;"></div>
		<?php endif; ?>

		<?php do_action( 'wp_body_open' ); ?>

		<header class="site-header">
			<?php get_header_markup(); ?>
		</header>

		<main class="site-main" id="content" tabindex="-1">
