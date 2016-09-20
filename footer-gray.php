		</div><!-- .container -->
		<footer class="site-footer">
			<div class="container">
				<p class="footer-title">University of Central Florida</p>
				<?php echo display_social_menu(); ?>
			</div>
			<div id="footer-navwrap" role="navigation" class="screen-only">
				<?=wp_nav_menu(array(
					'theme_location' => 'footer-menu',
					'container' => 'false',
					'menu_class' => 'menu list-unstyled list-inline text-center',
					'menu_id' => 'footer-menu',
					'fallback_cb' => false,
					'depth' => 1,
					'walker' => new Bootstrap_Walker_Nav_Menu()
					));
				?>
			</div>
		</footer>
	</body>
	<?php echo footer_(); ?>
</html>
