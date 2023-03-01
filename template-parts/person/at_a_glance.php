<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$colleges     = wp_get_post_terms( $post->ID, 'colleges' );
	$departments  = wp_get_post_terms( $post->ID, 'departments' );
	$tags         = wp_get_post_terms( $post->ID, 'post_tag' );
	$phone        = get_field( 'person_phone', $post );
	$email        = get_field( 'person_email', $post );

	$has_org_info     = $colleges || $departments;
	$has_contact_info = $phone || $email;
	$has_any_info     = $has_org_info || $has_contact_info;
	$col_class        = $has_org_info && $has_contact_info ? 'col-sm-6' : 'col' ;

	$page_permalink = get_permalink( get_page_by_path( 'faculty-search' ) );

	if ( $has_any_info ) :
?>
	<section id="at-a-glance" aria-label="Details and Contact Information">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0 pt-3 pt-lg-5 pb-4">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-4 mb-lg-2">
						<dl class="row mb-0">
							<?php if ( $has_org_info ) : ?>
							<div class="<?php echo $col_class; ?> pr-sm-4 pr-md-5">

								<?php if ( $colleges ) : ?>
								<dt class="h6 text-uppercase text-muted mb-2">College(s)</dt>
								<dd class="h5 mb-4">
									<?php
									foreach ( $colleges as $college ) :
										$college_url = get_term_link( $college->term_id );
										if ( $college_url ) :
									?>
										<a href="<?php echo $college_url; ?>" class="d-block mt-2 pt-1">
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
								<?php endif; ?>

								<?php if ( $departments ) : ?>
								<dt class="h6 text-uppercase text-muted mb-2">Department(s)</dt>
								<dd class="h5 mt-2 mb-4">
									<?php
									foreach ( $departments as $department ) :
									?>
										<span class="d-block mt-2 pt-1">
											<?php echo $department->name; ?>
										</span>
									<?php
									endforeach;
									?>
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


							<?php if ( $has_contact_info ) : ?>
							<div class="<?php echo $col_class; ?>">

								<dt class="h6 text-uppercase text-muted mb-3">Contact</dt>
								<dd>
									<dl>
										<?php if ( $phone ) : ?>
										<dt class="sr-only">Phone</dt>
										<dd>
											<span class="fa fa-fw fa-lg fa-phone mr-1" aria-hidden="true"></span>
											<?php
											// NOTE: borrowing logic from location templates here
											echo format_phone_link( array( $phone ), 0 );
											?>
										</dd>
										<?php endif; ?>

										<?php if ( $email ) : ?>
										<dt class="sr-only">Email</dt>
										<dd>
											<span class="fa fa-fw fa-lg fa-envelope mr-1" aria-hidden="true"></span>
											<a href="mailto:<?php echo $email; ?>">
												Email
												<span class="sr-only"> <?php echo $email; ?></span>
											</a>
										</dd>
										<?php endif; ?>
									</dl>
								</dd>

							</div>
							<?php endif; ?>
						</dl>
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
