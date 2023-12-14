<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$title     = get_field( 'expert_title', $post->ID );
	$institute = get_field( 'expert_institute', $post->ID );
	$has_title_info = $title || $institute;

	$expertise = wp_get_post_terms( $post->ID, 'expertise' );
	$tags      = wp_get_post_terms( $post->ID, 'post_tag' );
	$has_meta_info    = $expertise || $tags;

	$request_url = get_theme_mod_or_default( 'expert_request_form_url' );
	$request_text = get_theme_mod_or_default( 'expert_request_button_text' );

	$has_any_info     = $has_title_info || $has_meta_info;
	$col_class        = $has_title_info && $has_meta_info ? 'col-sm-6' : 'col' ;

	$page_permalink = get_permalink( get_page_by_path( 'experts' ) );

	if ( $has_any_info ) :
?>
	<section id="at-a-glance" aria-label="Details and Contact Information">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0 pt-3 pt-lg-5 pb-4">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-4 mb-lg-2">
						<dl class="row mb-0">
							<?php if ( $has_meta_info ) : ?>
							<div class="<?php echo $col_class; ?>">
								<?php if ( $expertise ) : ?>
								<dt class="h6 text-uppercase text-muted mb-2">Area(s) of Expertise</dt>
								<dd class="h5 mt-2 mb-4">
									<ul class="list-unstyled list-inline">
									<?php foreach( $expertise as $exp ) : ?>
										<li class="list-inline-item my-1 mr-2">
											<?php echo $exp->name; ?>
										</li>
									<?php endforeach; ?>
									</ul>
								</dd>
								<?php endif; ?>
								<?php if ( $tags ) : ?>
								<dt class="h6 text-uppercase text-muted mb-2">Research Area(s)</dt>
								<dd class="mt-2 mb-4">
									<ul class="list-unstyled list-inline">
										<?php
										foreach ( $tags as $tag ) :
											$tag_filter_url = add_query_arg(
												'query',
												$tag->name,
												$page_permalink
											);
										?>
										<li class="list-inline-item my-1 mr-2">
											<a class="badge badge-pill badge-faded letter-spacing-0 text-transform-none font-weight-normal" href="<?php echo $tag_filter_url; ?>">
												<?php echo $tag->name; ?>
											</a>
										</li>
										<?php endforeach; ?>
									</ul>
								</dd>
								<?php endif; ?>
							</div>
							<?php endif; ?>
							<div class="<?php echo $col_class; ?>">
								<?php if ( $media_availability ) : ?>
										<dt class="h6 text-uppercase text-muted mb-2">Media Availability</dt>
										<dd class="mt-2 mb-4">
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
										</dd>
								<?php endif; ?>
								<!-- I want to add social media component here usually it works out of wordpress env -->
								<?php include('./social.php') ?>
							</div>
						</dl>
						<?php if ( $request_url ) : ?>
						<div>
							<a class="btn d-block d-md-inline-block btn-primary text-center mb-4" href="<?php echo $request_url; ?>" rel="nofollow" target="_blank"><?php echo $request_text ; ?></a>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// We should pretty much always have at least some content to display,
	// but if not, add a bumper div to prevent the person's thumbnail from
	// overlapping other content:
	else :
	?>

	<div class="my-lg-5 pt-lg-3"></div>
<?php
	endif;
endif;
