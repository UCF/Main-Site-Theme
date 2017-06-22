<!DOCTYPE html>
<html lang="en-us">
	<head>
		<?php wp_head(); ?>
	</head>
	<body ontouchstart <?php body_class(); ?>>
		<?php echo google_tag_manager_noscript(); ?>
		<?php if ( class_exists( 'UCF_Alert_Common' ) ) { echo UCF_Alert_Common::display_alert( 'faicon' );  } ?>
		<header>
			<?php echo get_header_markup(); ?>
		</header>
