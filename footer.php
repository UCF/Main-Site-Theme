			<div id="footer" class="span-24 last">
				
				<?=get_menu('footer-menu', 'menu horizontal', 'footer-menu')?>
				
				<div class="ucf span-18">
					<a class="ignore-external" href="http://www.ucf.edu"><img src="<?=THEME_IMG_URL?>/logo.png" alt="" title="" /></a>
				</div>
				<div class="info span-6 last">
					<?php $options = get_option(THEME_OPTIONS_NAME);?>
					<div class="maintained">
						Site maintained by the <br />
						<a href="mailto:<?=$options['site_contact']?>"><?=$options['organization_name']?></a>
					</div>
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