			<div id="footer">
				
				<div id="footer-navwrap">
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
				
				<p id="subfooter">
					<a href="http://www.ucf.edu/feedback">Comments and Feedback</a> | <a href="<?=site_url()?>">&copy; University of Central Florida</a>
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
				
				<p id="footer-logo"><a href="<?=site_url()?>"><img src="<?=THEME_STATIC_URL?>/img/footer_logo.png" alt="University of Central Florida" title="University of Central Florida" /></a></p>
				
				
			</div>
		</div><!-- .container -->
	</body>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?="\n".footer_()."\n"?>
</html>