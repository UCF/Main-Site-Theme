<?php
include_once 'includes/utilities.php';
include_once 'includes/config.php';
include_once 'includes/meta.php';
include_once 'includes/navwalker.php';
include_once 'includes/header-functions.php';

include_once 'includes/degree-functions.php';
include_once 'includes/ucf-alert-functions.php';
include_once 'includes/phonebook-functions.php';


/**
* Displays a list of top degrees for the colleges taxonomy template
* @author RJ Bruneel
* @since 3.0.0
* @param $term object | Object with top degrees
* @return string | Top Degrees List.
**/
function display_top_degrees( $term ) {
	$ret = "";
	$top_degrees = get_field( 'top_degrees', 'colleges_' . $term->term_id );
	if( $top_degrees ) :
		foreach( $top_degrees as $top_degree ) :
			$ret .= '<li><a href="' . $top_degree->post_name . '" class="text-inverse">' . $top_degree->post_title . '</a></li>';
		endforeach;
	endif;
	return $ret;
}


/**
 * Returns an array of src's for a media background <picture>'s <source>s by
 * breakpoint.
 *
 * $img_size_prefix is expected to be a prefix for a set of registered image
 * sizes, which has dimensions defined for each of Athena's responsive
 * breakpoints.  For example, if given a prefix 'bg-img', it is expected that
 * bg-img, bg-img-sm, bg-img-md, bg-img-lg, and bg-img-xl are valid registered
 * image sizes.
 *
 * @param int $attachment_xs_id Attachment ID for the image to be used at the -xs breakpoint
 * @param int $attachment_sm_id Attachment ID for the image to be used at the -sm breakpoint and up
 * @param string $img_size_prefix Prefix for a set of image sizes
 * @return array
 **/
function get_media_background_picture_srcs( $attachment_xs_id, $attachment_sm_id, $img_size_prefix ) {
	$bg_images = array();

	if ( $attachment_sm_id ) {
		$bg_images = array_merge(
			$bg_images,
			array(
				'xl' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-xl' ),
				'lg' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-lg' ),
				'md' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-md' ),
				'sm' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-sm' )
			)
		);

		// Try to get a fallback -xs image if needed
		if ( !$attachment_xs_id ) {
			$bg_images = array_merge(
				$bg_images,
				array( 'xs' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix ) )
			);
		}

		// Remove duplicate image sizes, in case an old image isn't pre-cropped
		$bg_images = array_unique( $bg_images );

		// Use the largest-available image as the fallback <img>
		$bg_images['fallback'] = reset( $bg_images );
	}
	if ( $attachment_xs_id ) {
		$bg_images = array_merge(
			$bg_images,
			array( 'xs' => get_attachment_src_by_size( $attachment_xs_id, $img_size_prefix ) )
		);
	}

	// Strip out false-y values (in case an attachment failed to return somewhere)
	$bg_images = array_filter( $bg_images );

	return $bg_images;
}


/**
 * Returns an array of object-fit classes for a media background's sources by
 * breakpoint.
 *
 * @param string $xs_override Object-fit class to be used at the -xs breakpoint
 * @param string $sm_override Object-fit class to be used at the -sm breakpoint and up
 * @return array
 **/
function get_media_background_object_fits( $xs_override=null, $sm_override=null ) {
	$defaults = array_fill_keys( array( 'xl', 'lg', 'md', 'sm', 'xs', 'fallback' ), 'object-fit-cover' );
	$overrides = array();

	if ( $sm_override ) {
		$overrides['xl'] = $sm_override;
		$overrides['lg'] = $sm_override;
		$overrides['md'] = $sm_override;
		$overrides['sm'] = $sm_override;
		$overrides['fallback'] = $sm_override;
	}

	if ( $xs_override ) {
		$overrides['xs'] = $xs_override;
	}

	return array_merge( $defaults, $overrides );
}


/**
 * Returns an array of object-position values for a media background's sources
 * by breakpoint.
 *
 * @param string $xs_override Object-position value to be used at the -xs breakpoint
 * @param string $sm_override Object-position value to be used at the -sm breakpoint and up
 * @return array
 **/
function get_media_background_object_positions( $xs_override=null, $sm_override=null ) {
	$defaults = array_fill_keys( array( 'xl', 'lg', 'md', 'sm', 'xs', 'fallback' ), '50% 50%' );
	$overrides = array();

	if ( $sm_override ) {
		$overrides['xl'] = $sm_override;
		$overrides['lg'] = $sm_override;
		$overrides['md'] = $sm_override;
		$overrides['sm'] = $sm_override;
		$overrides['fallback'] = $sm_override;
	}

	if ( $xs_override ) {
		$overrides['xs'] = $xs_override;
	}

	return array_merge( $defaults, $overrides );
}


/**
 * Returns markup for a media background <picture>.
 *
 * @param array $srcs Array of image urls that correspond to <source> src vals. Expects output from get_media_background_picture_srcs()
 * @param array $object_fits Array of object-fit classes per breakpoint. Expects output from get_media_background_object_fits()
 * @param array $object_positions Array of object-position per breakpoint. Expects output from get_media_background_object_positions()
 * @return string
 **/
function get_media_background_picture( $srcs, $object_fits, $object_positions ) {
	ob_start();

	if ( isset( $srcs['fallback'] ) ) :
?>
	<?php
	// Define classes for the <picture> element
	$picture_classes = 'media-background-picture ';
	if ( !isset( $srcs['xs'] ) ) {
		// Hide the <picture> element at -xs breakpoint when no mobile image
		// is available
		$picture_classes .= 'hidden-xs-down';
	}
	?>
	<picture class="<?php echo $picture_classes; ?>">
		<?php if ( isset( $srcs['xl'] ) ) : ?>
		<source srcset="<?php echo $srcs['xl']; ?>" media="(min-width: 1200px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['lg'] ) ) : ?>
		<source srcset="<?php echo $srcs['lg']; ?>" media="(min-width: 992px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['md'] ) ) : ?>
		<source srcset="<?php echo $srcs['md']; ?>" media="(min-width: 768px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['sm'] ) ) : ?>
		<source srcset="<?php echo $srcs['sm']; ?>" media="(min-width: 576px)">
		<?php endif; ?>

		<img class="media-background <?php echo $object_fits['fallback']; ?>" src="<?php echo $srcs['fallback']; ?>" style="object-position: <?php echo $object_positions['fallback']; ?>;" data-object-position="<?php echo $object_positions['fallback']; ?>" alt="">
	</picture>

	<?php if ( isset( $srcs['xs'] ) ) : ?>
	<img class="media-background hidden-sm-up <?php echo $object_fits['xs']; ?>" src="<?php echo $srcs['xs']; ?>" style="object-position: <?php echo $object_positions['xs']; ?>;" data-object-position="<?php echo $object_positions['xs']; ?>" alt="">
	<?php endif; ?>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Returns markup for a media background <video> element.
 *
 * $videos is expected to be an array whose keys correspond to supported
 * <source> filetypes; e.g. $videos = array( 'webm' => '...', 'mp4' => '...' ).
 * Values should be video urls.
 *
 * Note: we never display autoplay videos at the -xs breakpoint.
 *
 * @param array $videos Array of video urls that correspond to <source> src vals
 * @param string $object_fit Object-fit class for the video (sm+)
 * @param string $object_position Object-position value for the video (sm+)
 * @return string
 **/
function get_media_background_video( $videos, $loop=false, $object_fit, $object_position ) {
	ob_start();
?>
	<video class="hidden-xs-down media-background media-background-video <?php echo $object_fit; ?>" style="object-position: <?php echo $object_position; ?>;" data-object-position="<?php echo $object_position; ?>" autoplay muted <?php if ( $loop ) { ?>loop<?php } ?>>
		<?php if ( isset( $videos['webm'] ) ) : ?>
		<source src="<?php echo $videos['webm']; ?>" type="video/webm">
		<?php endif; ?>

		<?php if ( isset( $videos['mp4'] ) ) : ?>
		<source src="<?php echo $videos['mp4']; ?>" type="video/mp4">
		<?php endif; ?>
	</video>
	<button class="media-background-video-toggle btn play-enabled hidden-xs-up" type="button" data-toggle="button" aria-pressed="false" aria-label="Play or pause background videos">
		<span class="fa fa-pause media-background-video-pause"></span>
		<span class="fa fa-play media-background-video-play"></span>
	</button>
<?php
	return ob_get_clean();
}


/**
 * Section markup override
 **/
function add_section_markup_before( $content, $section, $class, $title, $section_id ) {
	// Retrieve background image sizes
	$bg_image_sm_id = get_field( 'section_background_image', $section->ID );    // -sm+
	$bg_image_xs_id = get_field( 'section_background_image_xs', $section->ID ); // -xs only
	$bg_images = get_media_background_picture_srcs( $bg_image_xs_id, $bg_image_sm_id, 'bg-img' );
	$bg_object_fits = get_media_background_object_fits();
	$bg_object_positions = get_media_background_object_positions();

	// Retrieve color classes/custom definitions
	$bg_color = get_field( 'section_background_color', $section->ID );
	$bg_color_custom = get_field( 'section_background_color_custom', $section->ID );

	$text_color = get_field( 'section_text_color', $section->ID );
	$text_color_custom = get_field( 'section_text_color_custom', $section->ID );

	// Define classes for the section
	$section_classes = '';
	if ( $class ) {
		$section_classes = $class;
	}

	if ( isset( $bg_images['fallback'] ) ) {
		$section_classes .= ' media-background-container';
	}
	if ( $bg_color && !empty( $bg_color ) && $bg_color !== 'custom' ) {
		$section_classes .= ' ' . $bg_color;
	}
	if ( $text_color && !empty( $text_color ) && $text_color !== 'custom' ) {
		$section_classes .= ' ' . $text_color;
	}

	// Define custom style attribute values for the section
	$style_attrs = '';
	if ( $bg_color === 'custom' && $bg_color_custom ) {
		$style_attrs .= 'background-color: '. $bg_color_custom .'; ';
	}
	if ( $text_color === 'custom' && $text_color_custom ) {
		$style_attrs .= 'color: '. $text_color_custom .'; ';
	}

	$title = ! empty( $title ) ? ' data-section-link-title="' . $title . '" role="region" aria-label="' . $title . '"' : '';

	$section_id = ! empty( $section_id ) ? ' id="' . $section_id . '"' : '';

	ob_start();
?>
	<section <?php echo $section_id; ?>class="<?php echo $section_classes; ?>" style="<?php echo $style_attrs; ?>"<?php echo $title; ?>>
	<?php echo get_media_background_picture( $bg_images, $bg_object_fits, $bg_object_positions ); ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display_before', 'add_section_markup_before', 10, 5 );


function add_section_markup( $output, $section ) {
	$container = get_field( 'section_add_content_container', $section->ID );

	ob_start();
?>
	<?php if ( $container ) : ?>
		<div class="container"><?php echo apply_filters( 'the_content', $section->post_content ); ?></div>
	<?php else : ?>
		<?php echo apply_filters( 'the_content', $section->post_content ); ?>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display', 'add_section_markup', 10, 2 );


/**
 * Events - classic layout overrides
 **/
function mainsite_events_display_classic( $content, $items, $args, $display_type ) {
	if ( $items && ! is_array( $items ) ) { $items = array( $items ); }
	ob_start();
?>
	<div class="ucf-events-list">

	<?php if ( $items ): ?>
		<?php
		foreach( $items as $event ) :
			$starts = new DateTime( $event->starts );
			$ends   = new DateTime( $event->ends );
		?>
		<div class="ucf-event ucf-event-row">
			<div class="ucf-event-col ucf-event-when">
				<time class="ucf-event-start-datetime" datetime="<?php echo $starts->format( 'c' ); ?>">
					<span class="ucf-event-start-month"><?php echo $starts->format( 'M' ); ?></span>
					<span class="ucf-event-start-date"><?php echo $starts->format( 'j' ); ?></span>
				</time>
			</div>
			<div class="ucf-event-col ucf-event-content">
				<a class="ucf-event-link" href="<?php echo $event->url; ?>">
					<span class="ucf-event-title"><?php echo $event->title; ?></span>
					<span class="ucf-event-time">
						<span class="ucf-event-start-time"><?php echo $starts->format( 'g:i a' ); ?></span>
						-
						<span class="ucf-event-end-time"><?php echo $ends->format( 'g:i a' ); ?></span>
					</span>
				</a>
			</div>
		</div>
		<?php endforeach; ?>

	<?php else: ?>
		<span class="ucf-events-error">No events found.</span>
	<?php endif; ?>

	</div>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_events_display_classic', 'mainsite_events_display_classic', 11, 4 );


/**
 * Academic Calendar Main-Site Layout
 **/
function main_site_academic_calendar_before( $content, $items, $args ) {
	return '<div class="academic-calendar-container">';
}

add_filter( 'ucf_acad_cal_display_main_site_before', 'main_site_academic_calendar_before', 10, 3 );

function main_site_academic_calendar_title( $content, $items, $args ) {
	$title = isset( $args['title'] ) ? $args['title'] : 'Academic Calendar';

	ob_start();
?>
	<h2 class="mt-2 mb-4 text-inverse"><span class="fa fa-calendar text-primary"></span> <?php echo $title; ?></h2>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_acad_cal_display_main_site_title', 'main_site_academic_calendar_title', 10, 3 );

function main_site_academic_calendar_content( $content, $items, $args ) {
	$first_item = array_shift( $items );

	ob_start();
?>
	<div class="row">
		<div class="col-md-4">
			<h3 class="h5 text-inverse text-uppercase">Up Next</h3>
			<div class="academic-calendar-item">
				<a href="<?php echo $first_item->directUrl; ?>" target="_blank">
					<span class="text-inverse title h4 mb-2 heading-underline"><?php echo $first_item->summary; ?></span>
					<?php echo main_site_academic_calendar_format_date( $first_item->dtstart, $first_item->dtend ); ?>
					<?php if ( ! empty( $first_item->description ) ) : ?>
						<p class="text-inverse"><?php echo $first_item->description; ?></p>
					<?php endif; ?>
				</a>
			</div>
		</div>
		<div class="col-md-8">
			<h3 class="h5 text-inverse text-uppercase">Looking Ahead</h3>
			<div class="academic-calendar-columns">
			<?php foreach( $items as $item ) : ?>
				<div class="academic-calendar-item">
					<a href="<?php echo $item->directUrl; ?>" target="_blank">
						<?php echo main_site_academic_calendar_format_date( $item->dtstart, $item->dtend ); ?>
						<span class="text-inverse title"><?php echo $item->summary; ?></span>
					</a>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}

function main_site_academic_calendar_format_date( $start_date, $end_date ) {
	$start_date = strtotime( $start_date );
	$end_date = strtotime( $end_date );

	ob_start();
?>
	<div class="time text-primary">
	<time datetime="<?php echo date( 'Y-m-d', $start_date ); ?>"><?php echo date( 'F j', $start_date ); ?></time>
<?php
	if ( $end_date ) :
		if ( date( 'F',  $start_date ) === date( 'F', $end_date ) ) :
	?>
		- <time datetime="<?php echo date( 'Y-m-d', $end_date ); ?>"><?php echo date( 'j', $end_date ); ?></time>
	<?php else: ?>
		- <time datetime="<?php echo date( 'Y-m-d', $end_date ); ?>"><?php echo date( 'F j', $end_date ); ?></time>
	<?php endif;
	endif;

	?>
	</div>
	<?php
	return ob_get_clean();
}

add_filter( 'ucf_acad_cal_display_main_site', 'main_site_academic_calendar_content', 10, 3 );

function main_site_academic_calendar_after( $content, $items, $args ) {
	return '</div>';
}

add_filter( 'ucf_acad_cal_display_main_site_after', 'main_site_academic_calendar_after', 10, 3 );

function main_site_academic_calendar_add_layout( $layouts ) {
	if ( ! isset( $layouts['main_site'] ) ) {
		$layouts['main_site'] = 'Main Site Layout';
	}

	return $layouts;
}

add_filter( 'ucf_acad_cal_get_layouts', 'main_site_academic_calendar_add_layout', 10, 1 );


/**
 * Main-Site Pegasus List Layout
 **/
function main_site_pegasus_list_before( $content, $items, $args ) {
	ob_start();
?>
	<div class="ucf-pegasus-list ucf-pegasus-list-main-site">
<?php
	return ob_get_clean();
}

add_filter( 'ucf_pegasus_list_display_main_site_before', 'main_site_pegasus_list_before', 10, 3 );

function main_site_pegasus_list_content( $content, $items, $args ) {
	$first       = array_shift( $items );
	$issue_url   = $first->link;
	$issue_title = $first->title->rendered;
	$cover_story = $first->_embedded->issue_cover_story[0];
	$cover_story_url = $cover_story->link;
	$cover_story_title = $cover_story->title->rendered;
	$cover_story_subtitle = $cover_story->story_subtitle;
	$cover_story_description = $cover_story->story_description;
	$cover_story_blurb = null;
	$thumbnail_id = $first->featured_media;
	$thumbnail = null;
	$thumbnail_url = null;

	if ( $thumbnail_id !== 0 ) {
		$thumbnail = $first->_embedded->{"wp:featuredmedia"}[0];
		$thumbnail_url = $thumbnail->media_details->sizes->full->source_url;
	}
	if ( $cover_story_description ) {
		$cover_story_blurb = $cover_story_description;
	} else if ( $cover_story_subtitle ) {
		$cover_story_blurb = $cover_story_subtitle;
	}

	ob_start();
?>
	<!-- Featured Issue -->
	<div class="row mb-4 mb-md-5">
		<div class="col-sm-4">
			<a class="h2 mb-2" href="<?php echo $issue_url; ?>" target="_blank">
				<img class="w-100" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $issue_title; ?>">
			</a>
		</div>
		<div class="col-sm-8 mt-3 mt-sm-0">
			<a class="h1 text-secondary" href="<?php echo $issue_url; ?>" target="_blank">
				<?php echo $issue_title; ?>
			</a>
			<p class="mt-2 mt-md-4 mb-2 text-muted text-uppercase">Featured Story</p>
			<a class="h3 font-slab-serif text-secondary" href="<?php echo $cover_story_url; ?>" target="_blank">
				<?php echo $cover_story_title; ?>
			</a>
			<p class="mt-3 mb-4"><?php echo $cover_story_blurb; ?></p>
			<a class="btn btn-primary" href="<?php echo $issue_url; ?>" target="_blank">
				Read More<span class="sr-only"> from <?php echo $issue_title; ?></span>
			</a>
		</div>
	</div>

	<hr class="hidden-lg-up my-4 my-md-5">

	<div class="row">
	<?php foreach( $items as $item ) :
		$issue_url   = $item->link;
		$issue_title = $item->title->rendered;
		$cover_story = $item->_embedded->issue_cover_story[0];
		$cover_story_url = $cover_story->link;
		$cover_story_title = $cover_story->title->rendered;
		$cover_story_subtitle = $cover_story->story_subtitle;
		$cover_story_description = $cover_story->story_description;
		$cover_story_blurb = null;
		$thumbnail_id = $item->featured_media;
		$thumbnail = null;
		$thumbnail_url = null;

		if ( $thumbnail_id !== 0 ) {
			$thumbnail = $item->_embedded->{"wp:featuredmedia"}[0];
			$thumbnail_url = $thumbnail->media_details->sizes->full->source_url;
		}
		if ( $cover_story_description ) {
			$cover_story_blurb = $cover_story_description;
		} else if ( $cover_story_subtitle ) {
			$cover_story_blurb = $cover_story_subtitle;
		}
	?>
		<div class="col-lg-3 mb-4">
			<div class="row">
				<div class="col-3 col-lg-12 pr-0 pr-sm-3">
					<a class="text-secondary" href="<?php echo $issue_url; ?>" target="_blank">
						<img class="w-100 mb-3" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $issue_title; ?>">
					</a>
				</div>
				<div class="col-9 col-lg-12">
					<a class="h3 text-secondary" href="<?php echo $issue_url; ?>" target="_blank">
						<?php echo $issue_title; ?>
					</a>
					<p class="mt-2 mt-md-3 mb-1 small text-muted text-uppercase">Featured Story</p>
					<a class="h5 font-slab-serif text-secondary mb-3" href="<?php echo $cover_story_url; ?>" target="_blank">
						<?php echo $cover_story_title; ?>
					</a>
					<p class="my-2"><?php echo $cover_story_blurb; ?></p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	</div>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_pegasus_list_display_main_site_content', 'main_site_pegasus_list_content', 10, 3 );

function main_site_pegasus_list_after( $content, $items, $args ) {
	ob_start();
?>
	</div>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_pegasus_list_display_main_site_after', 'main_site_pegasus_list_after', 10, 3 );

function main_site_pegasus_add_layout( $layouts ) {
	if ( ! isset( $layouts['main_site'] ) ) {
		$layouts['main_site'] = 'Main Site Layout';
	}

	return $layouts;
}

add_filter( 'ucf_pegasus_list_get_layouts', 'main_site_pegasus_add_layout', 10, 1 );
