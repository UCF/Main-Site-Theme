<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$biography = trim( apply_filters( 'the_content', $post->post_content ) );

	$association = get_field( 'expert_association_fellow', $post->ID );
	$colleges     = wp_get_post_terms( $post->ID, 'colleges' );
	$departments  = wp_get_post_terms( $post->ID, 'departments' );
	$has_org_info     = $colleges || $departments;
	$bilingual = get_field( 'expert_bilingual', $post->ID );
	$lang_array = get_field( 'expert_languages', $post->ID );

	$languages = array();

	if ( $bilingual && is_array( $lang_array ) ) {
		array_walk_recursive( $lang_array, function( $l ) use ( &$languages ) {
			$languages[] = $l;
		} );
	}

	$meta = isset( $title ) ||
		isset( $association ) ||
		isset( $languages ) ||
		! empty( $colleges ) ||
		! empty( $departments );

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
						<?php if ( $association ) : ?>
						<dl>
							<dt>Association Fellow</dt>
							<dd><?php echo $association; ?></dd>
						</dl>
						<?php endif;?>
						<?php if ( $bilingual ) : ?>
						<dl>
							<dt>Languages Spoken</dt>
							<dd><?php echo implode( ', ', $languages ); ?></dd>
						</dl>
						<?php endif; ?>
						<?php if ( $has_org_info ) : ?>
								<?php if ( $colleges ) : ?>
								<dl>
									<dt>College(s)</dt>
									<dd>
										<?php
										foreach ( $colleges as $college ) :
											$college_url = get_term_link( $college->term_id );
											if ( $college_url ) :
										?>
											<a href="<?php echo $college_url; ?>" class="mb-2">
												<?php echo $college->name; ?>
											</a>
										<?php else : ?>
											<span class="d-block">
												<?php echo $college->name; ?>
											</span>
										<?php
											endif;
										endforeach;
										?>
									</dd>
								</dl>
								<?php endif; ?>

								<?php if ( $departments ) : ?>
								<dl>
									<dt>Department(s)</dt>
									<dd>
										<?php
										foreach ( $departments as $department ) :
										?>
											<span class="d-block mb-2">
												<?php echo $department->name; ?>
											</span>
										<?php
										endforeach;
										?>
									</dd>
								</dl>
								<?php endif; ?>
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
