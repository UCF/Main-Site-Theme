<?php

/**
 * The default functions for the card layout
 **/

if ( ! function_exists( 'ucf_post_list_display_location_before' ) ) {
	function mainsite_list_display_location_before( $content, $posts, $atts ) {
		ob_start();
	?>
		<div class="ucf-post-list card-layout locations-search" id="post-list-<?php echo $atts['list_id']; ?>">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_location_before', 'mainsite_list_display_location_before', 10, 3 );
}


if ( !function_exists( 'mainsite_list_display_location_title' ) ) {

	function mainsite_list_display_location_title( $content, $posts, $atts ) {
		$formatted_title = '';

		if ( $list_title = $atts['list_title'] ) {
			$formatted_title = '<h2 class="ucf-post-list-title">' . $list_title . '</h2>';
		}

		return $formatted_title;
	}

	add_filter( 'ucf_post_list_display_location_title', 'mainsite_list_display_location_title', 10, 3 );

}

if ( ! function_exists( 'mainsite_post_list_search_classnames' ) ) {
	function mainsite_post_list_search_classnames( $classnames, $posts, $atts ) {
		if ( ! $atts['layout'] === 'location' ) return $classnames;

		ob_start();
?>
		{
			input: 'form-control mb-4 form-control-search'
		}
<?php
		$classnames = ob_get_clean();

		return $classnames;
	}

	add_filter( 'ucf_post_list_search_classnames', 'mainsite_post_list_search_classnames', 10, 3 );
}

if ( ! function_exists( 'mainsite_list_display_location' ) ) {
	function mainsite_list_display_location( $content, $posts, $atts ) {
		if ( $posts && ! is_array( $posts ) ) { $posts = array( $posts ); }
		ob_start();
?>
		<?php if ( $posts ): ?>
			<?php
			foreach( $posts as $index=>$item ) :
				$address = get_field( 'ucf_location_address', $item->ID );
			?>
				<div class="ucf-post-list-location-item">
					<div class="row">
						<div class="col-sm-4">
							<a class="ucf-post-list-card-link" href="<?php echo get_permalink( $item->ID ); ?>">
								<h3 class="ucf-post-list-location-title"><?php echo $item->post_title; ?></h3>
							</a>
						</div>
						<div class="col-md-8">
							<?php if ( $address ) : ?>
							<p class="ucf-post-list-location-text"><?php echo $address; ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<div class="ucf-post-list-error">No results found.</div>
		<?php endif;

		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_location', 'mainsite_list_display_location', 10, 3 );
}

if ( ! function_exists( 'mainsite_list_display_location_after' ) ) {
	function mainsite_list_display_location_after( $content, $posts, $atts ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_location_after', 'mainsite_list_display_location_after', 10, 3 );
}
