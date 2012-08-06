<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?="\n".header_()."\n"?>
		<!--[if IE]>
		<link href="http://cdn.ucf.edu/webcom/-/css/blueprint-ie.css" rel="stylesheet" media="screen, projection">
		<![endif]-->
		<?php if(GA_ACCOUNT or CB_UID):?>
		
		<script type="text/javascript">
			var _sf_startpt = (new Date()).getTime();
			<?php if(GA_ACCOUNT):?>
			
			var GA_ACCOUNT  = '<?=GA_ACCOUNT?>';
			var _gaq        = _gaq || [];
			_gaq.push(['_setAccount', GA_ACCOUNT]);
			_gaq.push(['_setDomainName', 'none']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);
			<?php endif;?>
			<?php if(CB_UID):?>
			
			var CB_UID      = '<?=CB_UID?>';
			var CB_DOMAIN   = '<?=CB_DOMAIN?>';
			<?php endif?>
			
		</script>
		<?php endif;?>
		
		<?  $post_type = get_post_type($post->ID);
			if(($stylesheet_id = get_post_meta($post->ID, $post_type.'_stylesheet', True)) !== False
				&& ($stylesheet_url = wp_get_attachment_url($stylesheet_id)) !== False) { ?>
				<link rel='stylesheet' href="<?=$stylesheet_url?>" type='text/css' media='all' />
		<? } ?>
		
	</head>
	<!--[if lt IE 7 ]>  <body class="ie ie6 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if IE 7 ]>     <body class="ie ie7 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if IE 8 ]>     <body class="ie ie8 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if IE 9 ]>     <body class="ie ie9 <?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <body class="<?=body_classes()?><?=!is_front_page() ? ' subpage': ''?>"> <!--<![endif]-->
	
		<div id="UCFHBHeader">
				<div class="UCFHBWrapper">
					<div id="UCFtitle">
						<a href="http://www.ucf.edu/">
							<span class="UCFHBText">University of Central Florida</span>
						</a>
					</div>
					<label for="UCFHeaderLinks">University Links</label>
					<label for="q">Search UCF</label>
					<div id="UCFHBSearch_and_links">
						<form id="UCFHBUni_links" action="" target="_top">
							<fieldset>
								<select name="UniversityLinks" id="UCFHBHeaderLinks" onchange="quickLinks.quickLinksChanged()">
									<option value="">Quicklinks:</option>
									<option value="">- - - - - - - - - -</option>
									<option value="http://library.ucf.edu">Libraries</option>
									<option value="http://www.ucf.edu/directories/">Directories (A-Z Index)</option>
									<option value="http://map.ucf.edu">Campus Map</option>
									<option value="http://ucffoundation.org/">Giving to UCF</option>
									<option value="http://ask.ucf.edu">Ask UCF</option>
									<option value="http://finaid.ucf.edu/">Financial Aid</option>
									<option value="http://today.ucf.edu/">UCF Today</option>
									<option value="https://www.secure.net.ucf.edu/knightsmail/">Knight's Email</option>
									<option value="http://events.ucf.edu/">Events at UCF</option>
									<option value="">- - - - - - - - - -</option>
									<option value="http://www.ucf.edu/academics">Academics</option>
									<option value="http://www.ucf.edu/admissions">Admissions</option>
									<option value="http://www.ucf.edu/research/">Research</option>
									<option value="http://www.ucf.edu/locations/">Locations</option>
									<option value="http://www.ucf.edu/campus_life/">Campus Life</option>
									<option value="http://www.ucf.edu/alumni_and_friends/">Alumni &amp; Friends</option>
									<option value="http://www.ucf.edu/athletics/">Athletics</option>
									<option value="">- - - - - - - - - -</option>
									<option value="+">+ Add This Page</option>
									<option value="">- - - - - - - - - -</option>
									<option value="&gt;">&gt; Customize This List</option>
								</select>
							</fieldset>
						</form>
					<div>
					<a id="UCFHBMy_ucf" href="http://my.ucf.edu/">
						<span class="text">myUCF</span>
					</a>
				</div>
				<form id="UCFHBSearch_ucf" method="get" action="http://google.cc.ucf.edu/search" target="_top">
					<fieldset>
						<input type="hidden" name="output" value="xml_no_dtd">
						<input type="hidden" name="proxystylesheet" value="UCF_Main">
						<input type="hidden" name="client" value="UCF_Main">
						<input type="hidden" name="site" value="UCF_Main">
						<input class="text" type="text" name="q" id="q" value="Search UCF" title="Search UCF" onfocus="clearDefault(this);" onblur="clearDefault(this);">
						<input id="UCFHBsubmit" type="submit" value="">
					</fieldset>
				</form>
				<div id="UCFHBClearBoth"></div>			

				</div>		
			</div>
		</div>
	
		<div class="container">
			<div class="row">
				<div id="header" class="row-border-bottom-top">
					<h1><a href="<?=bloginfo('url')?>"><?=bloginfo('name')?></a></h1>
					<?php $options = get_option(THEME_OPTIONS_NAME);?>
					<?php if($options['facebook_url'] or $options['twitter_url']):?>
					<ul class="social menu horizontal span3">
						<?php if($options['facebook_url']):?>
						<li><a class="ignore-external facebook" href="<?=$options['facebook_url']?>">Facebook</a></li>
						<?php endif;?>
						<?php if($options['twitter_url']):?>
						<li><a class="ignore-external twitter" href="<?=$options['twitter_url']?>">Twitter</a></li>
						<?php endif;?>
					</ul>
					<?php else:?>
					<div class="social span3">&nbsp;</div>
					<?php endif;?>
					<div class="end"><!-- --></div>
				</div>
			</div>
			<?=wp_nav_menu(array(
				'theme_location' => 'header-menu', 
				'container' => 'false', 
				'menu_class' => 'menu '.get_header_styles(), 
				'menu_id' => 'header-menu', 
				'walker' => new Bootstrap_Walker_Nav_Menu()
				));
			?>