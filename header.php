<!DOCTYPE html>
<html lang="en-US">
	<head>
		<?="\n".header_()."\n"?>
		<!--[if IE]>
		<link href="http://cdn.ucf.edu/webcom/-/css/blueprint-ie.css" rel="stylesheet" media="screen, projection">
		<![endif]-->
		<?php if(GA_ACCOUNT or CB_UID):?>
		
		<script type="text/javascript">
			<?php if(GA_ACCOUNT):?>
			
			var _gaq        = _gaq || [];
			var GA_ACCOUNT  = '<?=GA_ACCOUNT?>';
			<?php endif;?>
			<?php if(CB_UID):?>
			
			var _sf_startpt = (new Date()).getTime();
			var CB_UID      = '<?=CB_UID?>';
			var CB_DOMAIN   = '<?=CB_DOMAIN?>';
			<?php endif?>
			
		</script>
		<?php endif;?>
		
	</head>
	<body class="<?=body_classes()?>">
		<div id="blueprint-container" class="container">
			<div id="header" class="span-24 last">
				<h1 class="span-10 sans"><a href="<?=bloginfo('url')?>"><?=bloginfo('name')?></a></h1>
				<div class="span-14 last">
				<?=get_menu('header-menu', 'menu horizontal', 'header-menu')?>
				</div>
			</div>