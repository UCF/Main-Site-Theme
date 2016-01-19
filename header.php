<!DOCTYPE html>
<html lang="en-US">
	<head>
		<?="\n".header_()."\n"?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if(GA_ACCOUNT or CB_UID):?>

		<script type="text/javascript">
			var _sf_startpt = (new Date()).getTime();
			<?php if(GA_ACCOUNT):?>
			var GA_ACCOUNT  = '<?=GA_ACCOUNT?>';
			<?php endif;?>
			<?php if(CB_UID):?>

			var CB_UID      = '<?=CB_UID?>';
			var CB_DOMAIN   = '<?=CB_DOMAIN?>';
			<?php endif?>

		</script>
		<?php endif;?>

		<!--[if IE]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<?php
		// Always load webfont css for Degree posts and the 404 template.
		if ( $post->post_type == 'degree' || is_404() ) {
			webfont_stylesheet();
		}

		// Load webfonts if enabled by page.
		if ( is_page() ) {
			page_specific_webfonts( $post->ID );
		}

		// Load page-specific css.
		if ( is_page() || ( is_404() && $post = get_page_by_title( '404' ) ) ) {
			esi_include( 'page_specific_stylesheet', $post->ID ); // Wrap in ESI to prevent caching of .css file
		}
		?>

		<?php
		if ( is_page( 'Degree Search' ) || $post->post_type == 'degree' ) {
			$styles = '<style>';
			$program_types = get_terms( 'program_types', array( 'fields' => 'id=>slug' ) );
			if ( $program_types ) {
				foreach ( $program_types as $id => $slug ) {
					$color = get_term_custom_meta( $id, 'program_types', 'program_type_color' );
						if ( $color ) {
							$styles .= '.' . $slug . '{ color: ' . $color . ' !important; }' . "\n";
					}
				}
			}
			$styles .= '</style>';

			if ( $styles !== '<style></style>' ) {
				echo $styles;
			}
		}
		?>

		<?php if (is_front_page() || get_post_type($post) == 'centerpiece') { ?>
			<script type="text/javascript" src="<?=THEME_JS_URL?>/cycle.min.js"></script>
		<?php } ?>

		<?php
		if ( is_page( 'Post An Announcement' ) ) {
			$keywords = json_encode( get_terms( 'keywords', array( 'fields' => 'names' ) ) );
		?>
		<link href="<?php echo THEME_CSS_URL; ?>/bootstrap-tagsinput.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="<?php echo THEME_JS_URL; ?>/bootstrap-tagsinput.min.js"></script>
		<script>
			var announcementKeywords = <?php echo $keywords; ?>;
		</script>
		<?php } ?>

		<script type="text/javascript">
			var PostTypeSearchDataManager = {
				'searches' : [],
				'register' : function(search) {
					this.searches.push(search);
				}
			}
			var PostTypeSearchData = function(column_count, column_width, data) {
				this.column_count = column_count;
				this.column_width = column_width;
				this.data         = data;
			}

			var ALERT_RSS_URL				= '<?php echo get_theme_option('alert_feed_url'); ?>';
			var SITE_DOMAIN					= '<?php echo WP_SITE_DOMAIN; ?>';
			var SITE_PATH					= '<?php echo WP_SITE_PATH; ?>';
			var PRINT_HEADER_IMG			= '<?php echo THEME_IMG_URL.'/ucflogo-print.png'; ?>';

		</script>

	</head>
	<body <?php echo body_class(); ?>>

		<div class="container">
			<div class="row status-alert" id="status-alert-template" data-alert-id="">
				<div class="col-md-2 alert-icon-wrap">
					<div class="alert-icon general"></div>
				</div>
				<div class="col-md-10 alert-wrap">
					<div class="alert alert-error alert-block">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<h2>
							<a href="<?php echo get_theme_option('alert_more_information_url'); ?>">
								<span class="title"></span>
							</a>
						</h2>
						<p class="alert-body">
							<a href="<?php echo get_theme_option('alert_more_information_url'); ?>">
								<span class="content"></span>
							</a>
						</p>
						<p class="alert-action">
							<a class="more-information" href="<?php echo get_theme_option('alert_more_information_url'); ?>"></a>
						</p>
					</div>
				</div>
			</div>
			<?php if (is_front_page()) { ?>
			<div class="row" id="header_wrap">
				<div id="header" class="row-border-bottom-top" role="banner">
					<h1><?=bloginfo('name')?></h1>
				</div>
			</div>
			<?php } ?>
			<div id="header-nav-wrap" role="navigation" class="screen-only">
				<?=wp_nav_menu(array(
					'theme_location' => 'header-menu',
					'container' => 'false',
					'menu_class' => 'menu '.get_header_styles(),
					'menu_id' => 'header-menu',
					'walker' => new Bootstrap_Walker_Nav_Menu(),
					'before' => '<strong>',
					'after' => '</strong>',
					));
				?>
			</div>
