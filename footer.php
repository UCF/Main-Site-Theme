			<div id="footer">

				<div id="footer-navwrap" role="navigation" class="screen-only">
					<?php echo wp_nav_menu(array(
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

				<?php echo display_social_menu(); ?>

				<p id="subfooter" role="contentinfo" class="vcard">
					<span class="adr">
						<span class="street-address">4000 Central Florida Blvd. </span>
						<span class="locality">Orlando</span>,
						<span class="region">Florida</span>
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
	<?="\n".footer_()."\n"?>
</html>
