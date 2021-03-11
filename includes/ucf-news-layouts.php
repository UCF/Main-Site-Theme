<?php
/**
 * The default functions for the header card layout
 **/

if ( ! function_exists( 'ucf_news_display_header_card_before' ) ) {
	function ucf_news_display_header_card_before( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news header-card-layout">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_header_card_before', 'ucf_news_display_header_card_before', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_header_card_title' ) ) {
	function ucf_news_display_header_card_title( $content, $items, $args, $display_type ) {
		$formatted_title = $args['title'];

		switch( $display_type ) {
			case 'widget':
				break;
			case 'default':
			default:
				if ( $formatted_title ) {
					$formatted_title = '<h2 class="ucf-news-title">' . $formatted_title . '</h2>';
				}
				break;
		}

		return $formatted_title;
	}

	add_filter( 'ucf_news_display_header_card_title', 'ucf_news_display_header_card_title', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_header_card' ) ) {
	function ucf_news_display_header_card( $content, $items, $args, $display_type, $fallback_message='' ) {
		if ( $items === false ) {
			$items = array();
		}
		else if ( ! is_array( $items ) ) {
			$items = array( $items );
		}

		$per_row = intval( $args['per_row'] );
		$show_image = filter_var( $args['show_image'], FILTER_VALIDATE_BOOLEAN );
		$show_date = filter_var( $args['show_date'], FILTER_VALIDATE_BOOLEAN );

		ob_start();

		echo '<div class="ucf-news-header-card-deck">';

	if ( count( $items ) === 0 ) : echo $fallback_message; else :

		foreach ( $items as $index=>$item ) :
			$date = date( "M d", strtotime( $item->date ) );
			$item_img = UCF_News_Common::get_story_img_tag( $item );
	?>
		<?php
			if( $index !== 0 && ( $index % $per_row ) === 0 ) {
				echo '</div><div class="ucf-news-header-card-deck">';
			}
		?>
		<div class="ucf-news-header-card">
			<a class="ucf-news-header-card-link" href="<?php echo $item->link; ?>">
				<?php if ( $item_img && $show_image ): ?>
					<?php echo $item_img; ?>
				<?php endif; ?>

				<div class="ucf-news-header-card-block">
					<h3 class="ucf-news-header-card-title"><?php echo $item->title->rendered; ?></h3>
					<h3 class="ucf-news-header-card-subtitle"><?php echo $item->excerpt->rendered; ?></h3>
				<?php if ( $show_date ): ?>
					<p class="ucf-news-header-card-date"><?php echo $date; ?></p>
				<?php endif; ?>
				</div>
			</a>
		</div>
	<?php
		endforeach;

	endif; // End if item count

		echo '</div>';

		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_header_card', 'ucf_news_display_header_card', 10, 5 );
}

if ( ! function_exists( 'ucf_news_display_header_card_after' ) ) {
	function ucf_news_display_header_card_after( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_header_card_after', 'ucf_news_display_header_card_after', 10, 4 );
}

if ( ! function_exists( 'add_header_card_layout' ) ) {
	function add_header_card_layout( $layouts ) {
        var_dump( 'Adding Header Card layout.' );
		$layouts['header_card'] = 'Header Card Layout';
		return $layouts;
	}

	add_filter( 'ucf_news_get_layouts', 'add_header_card_layout', 10, 1 );
}