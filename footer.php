			<div id="footer" class="span12">
				
				<?=get_menu('footer-menu', 'menu horizontal', 'footer-menu')?>
				
				<div class="ucf span9">
					<a class="ignore-external" href="http://www.ucf.edu"><img src="<?=THEME_IMG_URL?>/logo.png" alt="" title="" /></a>
				</div>
				<div class="info span3">
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
				</div>
			</div>
		</div><!-- #blueprint-container -->
	</body>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?="\n".footer_()."\n"?>
</html>