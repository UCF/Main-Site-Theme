<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$biography = trim( apply_filters( 'the_content', $post->post_content ) );
	$title = get_field( 'expert_title', $post->ID );
	$institute = get_field( 'expert_institute', $post->ID );
	$association = get_field( 'expert_association_fellow', $post->ID );
	$bilingual = get_field( 'expert_bilingual', $post->ID );
	$lang_array = get_field( 'expert_languages', $post->ID );
	$request_url = get_theme_mod_or_default( 'expert_request_form_url' );
	$request_text = get_theme_mod_or_default( 'expert_request_button_text' );
	$languages = array();
	array_walk_recursive( $lang_array, function( $l ) use ( &$languages ) {
		$languages[] = $l; 
	} );

	$media_availability = get_field( 'expert_media_availability', $post->ID );

	$meta = isset( $title ) ||
		isset( $institute ) ||
		isset( $association ) ||
		isset( $languages ) ||
		isset( $media_availability );

	if ( $biography || $meta ) :
		$aria_labelledby = '';
		if ( $biography ) $aria_labelledby .= 'biography-heading ';
		if ( $meta ) $aria_labelledby .= 'meta-heading ';
		$aria_labelledby = trim( $aria_labelledby );

		$left_col_class  = 'col-lg-4 pr-lg-5 pull-lg-8 mt-5 mt-lg-0';
		$right_col_class = 'col-lg-8 push-lg-4';
?>
	<section id="person-meta" aria-labelledby="<?php echo $aria_labelledby; ?>">
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<div class="row">
					<?php if ( $biography ) : ?>
					<div class="<?php echo $right_col_class; ?>">
						<h2 id="biography-heading" class="sr-only">Biography</h2>
						<?php
						// TODO add "view more" button for -xs-sm
						echo $biography;
						?>
					</div>
					<?php endif; ?>

					<?php
					if ( $meta ) :
						$meta_col = $meta ? $left_col_class : $right_col_class;
					?>
					<div class="<?php echo $meta_col; ?>">
						<h2 class="h6 text-uppercase text-default mb-4" id="meta-heading">Information about <?php the_title(); ?></h2>
						<dl>
						<?php if ( $title ) : ?>
							<dt>Title</dt>
							<dl><?php echo $title; ?></dl>
						<?php endif; ?>
						<?php if ( $institute ) : ?>
							<dt>Cluster, Center, or Institute</dt>
							<dl><?php echo $institute; ?></dl>
						<?php endif;?>
						<?php if ( $association ) : ?>
							<dt>Association Fellow</dt>
							<dd><?php echo $association; ?></dd>
						<?php endif;?>
						<?php if ( $bilingual ) : ?>
							<dt>Languages Spoken</dt>
							<dd><?php echo implode( ', ', $languages ); ?></dd>
						<?php endif; ?>
						</dl>
						<h3 class="h6">Media Availability</h3>
						<ul class="list-unstyled">
						<?php if ( in_array( 'tv', $media_availability ) ) : ?>
							<li class="list-item"><span class="fa fa-check-circle text-success mr-2"></span> Television</li>
						<?php endif; ?>
						<?php if ( in_array( 'radio', $media_availability ) ) : ?>
							<li class="list-item"><span class="fa fa-check-circle text-success mr-2"></span> Radio</li>
						<?php endif; ?>
						<?php if ( in_array( 'print', $media_availability ) ) : ?>
							<li class="list-item"><span class="fa fa-check-circle text-success mr-2"></span> Print</li>
						<?php endif; ?>
						</ul>
						<?php get_template_part( 'template-parts/expert/social' ); ?>
						<?php if ( $request_url ) : ?>
						<a class="btn btn-primary" href="<?php echo $request_url; ?>" rel="nofollow" target="_blank"><?php echo $request_text ; ?></a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
