			<div id="footer">
				
				<div id="footer-navwrap" role="navigation">
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
				
				<p id="subfooter" role="contentinfo">
					<a href="<?=site_url()?>/feedback">Comments and Feedback</a> | <a href="<?=site_url()?>">&copy; University of Central Florida</a>
					<br/>
					4000 Central Florida Blvd. Orlando, Florida, 32816 | 407.823.2000
				</p>
				
				<?=wp_nav_menu(array(
					'theme_location' => 'social-links', 
					'container' => 'div',
					'container_id' => 'social-menu-wrap', 
					'menu_class' => 'menu', 
					'menu_id' => 'social-menu',
					'depth' => 1,
					));
				?>
				
				<p id="footer-logo"><a target="_blank" href="http://www.ucf.edu/50/">University of Central Florida 50th Anniversary</a></p>
				
				
			</div>
		</div><!-- .container -->
	</body>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?="\n".footer_()."\n"?>
	<?php if (!is_page(get_page_by_title('Customize Links')->ID)) { ?>
		<script type="text/javascript" src="<?=THEME_JS_URL?>/university-header.js"></script>
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