			<div id="footer">
				
				<div id="footer-navwrap" role="navigation" class="screen-only">
					<?=wp_nav_menu(array(
						'theme_location' => 'footer-menu', 
						'container' => 'false', 
						'menu_class' => 'menu horizontal', 
						'menu_id' => 'footer-menu', 
						'fallback_cb' => false,
						'depth' => 1,
						'walker' => new Bootstrap_Walker_Nav_Menu()
						));
					?>
				</div>
				
				<?=wp_nav_menu(array(
					'theme_location' => 'social-links', 
					'container' => 'div',
					'container_id' => 'social-menu-wrap', 
					'menu_class' => 'menu screen-only', 
					'menu_id' => 'social-menu',
					'depth' => 1,
					));
				?>

				<p id="subfooter" role="contentinfo" class="vcard">
					<span class="adr">
						<span class="street-address">4000 Central Florida Blvd. </span>
						<span class="locality">Orlando</span>, 
						<span class="region">Florida</span>, 
						<span class="postal-code">32816</span> | 
						<span class="tel"><a href="tel:4078232000">407.823.2000</a></span>
					</span>
					<br/>
					<a href="<?=site_url()?>/feedback/">Comments and Feedback</a> | &copy; 
					<a href="<?=site_url()?>" class="print-noexpand fn org url">
						<span class="organization-name">University of Central Florida</span>
					</a>
				</p>
				
			</div>
		</div><!-- .container -->
	</body>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?="\n".footer_()."\n"?>
	<?php if (!is_page(get_page_by_title('Customize Links')->ID)) { ?>
		<script type="text/javascript" src="//universityheader.ucf.edu/bar/js/university-header.js?use-bootstrap-overrides=1"></script>
	<?php } else { ?>
		<script type="text/javascript" src="<?=THEME_JS_URL?>/lowpro.jquery.js"></script>
		<script type="text/javascript" src="<?=THEME_JS_URL?>/jquery.cookiejar.js"></script>
		<script type="text/javascript" src="<?=THEME_JS_URL?>/jquery.json.js"></script>
		<script type="text/javascript" src="<?=THEME_JS_URL?>/quick_links.js"></script>
		<script type="text/javascript" src="<?=THEME_JS_URL?>/quick_links_manager.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {	
			initQuickLinks();
			initQuickLinksManager();
			$('#quicklinks-actions a').click(function(e) { e.preventDefault() });
		});
		</script>
	<?php } ?>
</html>