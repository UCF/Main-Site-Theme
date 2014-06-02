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
		
		<?php if (is_page()) { esi_include('page_specific_stylesheet', $post->ID); } ?>
		
		<?php if (is_front_page() || get_post_type($post) == 'centerpiece') { ?>
			<script type="text/javascript" src="<?=THEME_JS_URL?>/cycle.min.js"></script>
		<?php } ?>
		
		<script type="text/javascript">
			<?php if (is_page('Post An Announcement')) { 
				$keywords = '';
				foreach (get_terms(array('keywords')) as $term) {
					$keywords .= '"'.$term->name.'", ';
				}
				$keywords = substr($keywords, 0, -2);
			?>
			/* Todo: actually figure out why these vars don't print to the page with RGForms::parse_shortcode() */
				var gfcpt_tag_inputs = {"tag_inputs": [{input: "#input_4_9", taxonomy: "keywords"}]};
				var gfcpt_tag_taxonomies = [];
				gfcpt_tag_taxonomies["keywords"] = [<?=$keywords?>];
			<?php } ?>
		
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
	<body class="<?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>">
		
		<div class="container">
			<div class="row status-alert" id="status-alert-template" data-alert-id="">
				<div class="span2 alert-icon-wrap">
					<div class="alert-icon general"></div>
				</div>
				<div class="span10 alert-wrap">
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