<?php
$obj           = get_queried_object();
$exclude_nav   = get_field( 'page_header_exclude_nav', $obj );
$header_images = get_query_var( 'header_images' );

if ( ! $exclude_nav ) :
?>
<nav class="navbar navbar-toggleable-md navbar-custom py-2<?php echo $header_images ? ' py-sm-4 navbar-inverse header-gradient' : ' navbar-inverse bg-inverse-t-3 py-lg-4'; ?>" aria-label="Site navigation">
	<div class="container">
		<button class="navbar-toggler ml-auto mr-0 collapsed" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false">
			<span class="navbar-toggler-text">Navigation</span>
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
			wp_nav_menu( array(
				'theme_location'  => 'header-menu',
				'depth'           => 1,
				'container'       => 'div',
				'container_class' => 'collapse navbar-collapse',
				'container_id'    => 'header-menu',
				'menu_class'      => 'nav navbar-nav nav-fill',
				'fallback_cb'     => 'bs4Navwalker::fallback',
				'walker'          => new bs4Navwalker()
			) );
		?>
	</div>
</nav>
<?php endif; ?>
