<!DOCTYPE html>
<html lang="en-US">
	<head>
		<?=header_()?>
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
		<link href="http://cdn.ucf.edu/webcom/-/css/blueprint-ie.css" rel="stylesheet" media="screen, projection">
		<![endif]-->
	</head>
	<body class="<?=body_classes()?>">
		<div id="blueprint-container" class="container">
			<div id="header" class="span-24 last">
				<h1 class="span-10"><a href="<?=bloginfo('url')?>"><?=bloginfo('name')?></a></h1>
				<?=wp_nav_menu(array('theme_location' => 'header-menu'))?>
			</div>