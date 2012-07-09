			<div id="footer">
				
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
				<div class="row" id="footer-widget-wrap">
					<div class="footer-widget-1 span3">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column One')):?>
							<a class="ignore-external" href="http://www.ucf.edu"><img src="<?=THEME_IMG_URL?>/logo.png" alt="" title="" /></a>
						<?php endif;?>
					</div>
					<div class="footer-widget-2 span3">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Two')):?>
						&nbsp;
						<?php endif;?>
					</div>
					<div class="footer-widget-3 span3">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Three')):?>
						&nbsp;
						<?php endif;?>
					</div>
					<div class="footer-widget-4 span3">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Four')):?>
							<?php $options = get_option(THEME_OPTIONS_NAME);?>
							<?php if($options['site_contact'] or $options['organization_name']):?>
								<div class="maintained">
									Site maintained by the <br />
									<?php if($options['site_contact'] and $options['organization_name']):?>
									<a href="mailto:<?=$options['site_contact']?>"><?=$options['organization_name']?></a>
									<?php elseif($options['site_contact']):?>
									<a href="mailto:<?=$options['site_contact']?>"><?=$options['site_contact']?></a>
									<?php elseif($options['organization_name']):?>
									<?=$options['organization_name']?>
									<?php endif;?>
								</div>
								<?php endif;?>
							<div class="copyright">&copy; University of Central Florida</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div><!-- #blueprint-container -->
	</body>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?="\n".footer_()."\n"?>
</html>