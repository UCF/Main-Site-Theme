<!DOCTYPE html>
<html lang="en-us">
	<head>
		<?php wp_head(); ?>
	</head>
	<body ontouchstart <?php body_class(); ?>>
		<?php if ( class_exists( 'UCF_Alert_Common' ) ) { echo UCF_Alert_Common::display_alert();  } ?>
		<header>
			<?php echo get_header_markup(); ?>
		</header>
