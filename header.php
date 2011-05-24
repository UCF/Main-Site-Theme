<?php disallow_direct_load('header.php');?>
<?php
	// Creating the doctype
	thematic_create_doctype();
	echo " ";
	language_attributes();
	echo ">\n";
	
	// Creating the head profile
	thematic_head_profile();
	// Creating the doc title
	thematic_doctitle();
	// Creating the content type
	thematic_create_contenttype();
	// Creating the description
	thematic_show_description();
	// Creating the robots tags
	thematic_show_robots();
	// Creating the canonical URL
	thematic_canonical_url();
	
	if (THEMATIC_COMPATIBLE_FEEDLINKS) {
		// Creating the internal RSS links
		thematic_show_rss();
		
		// Creating the comments RSS links
		thematic_show_commentsrss();
	}
	
	// Creating the pingback adress
	thematic_show_pingback();
	// Enables comment threading
	thematic_show_commentreply();
	// Calling WordPress' header action hook
	wp_head();
	// Loading the stylesheet
	thematic_create_stylesheet();

?>
</head>

<?php
	thematic_body();
?>
	<div id="wrap">
		<div id="header" class="span-24 last">
			<h1 class="span-10"><a href="<?php bloginfo('url')?>">Undergraduate Admissions</a></h1>
			<div class="span-14 last" id="menu">
				<?=preg_replace(
					'/<li[^>]*>([^<]*<[^>]+>[^<]+<[^>]+>)<\/li>[\s]*<\/ul>/',
					'<li class="last">$1</ul>',
					wp_nav_menu(
						array(
							'menu' => 'Navigation',
							'container_class' => 'menu',
							'echo' => False,
						)
					)
				)?>
				<div class="end"><!-- --></div>
			</div>
		</div>
		
		<div class="span-24 last">