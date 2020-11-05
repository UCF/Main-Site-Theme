<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$deadlines                 = get_degree_application_deadlines( $post );
	$alternate_section         = null;
	$degree_alternate_section  = get_field( 'alternate_deadlines_section', $post );
	$fallback_section          = is_graduate_degree( $post ) ? get_theme_mod( 'degree_deadlines_graduate_fallback' ) : get_theme_mod( 'degree_deadlines_undergraduate_fallback' );

	if ( $degree_alternate_section ) {
		$alternate_section = $degree_alternate_section;
	} else if ( ! $deadlines ) {
		$alternate_section = $fallback_section;
	}

	if ( $alternate_section ) :
		echo do_shortcode( "[ucf-section id='$alternate_section']" );
	elseif ( $deadlines ) :
		$deadline_group_names = array_filter( array_keys( $deadlines ) );

		// Modify heading text depending on the type of degree
		// and the number of deadline groups are available:
		$heading_text         = 'Application Deadlines';
		if ( ! is_graduate_degree( $post ) ) {
			$heading_text = 'Undergraduate ' . $heading_text;
		} else if ( count( $deadlines ) === 1 ) {
			$first_group_name = $deadline_group_names[0] ?? '';
			$heading_text = trim( $first_group_name . ' ' . $heading_text );
		}

		// Allow the heading for this section to display inline if
		// only one deadline group is available, and there are
		// fewer than 3 deadlines in that group:
		$deadline_heading_show_inline = false;
		if (
			count( $deadlines ) === 1
			&& count( $deadlines[array_key_first( $deadlines )] ) < 3
		) {
			$deadline_heading_show_inline = true;
		}
		$deadline_heading_col_class = $deadline_heading_show_inline ? 'col-lg-4 mb-4 mb-lg-0 mr-lg-5' : 'col-12 mb-4';
?>
	<section aria-labelledby="application-deadlines-heading">
		<div class="degree-deadline-wrap">
			<div class="degree-deadline-row">
				<!-- Left-hand surrounding pad, for desktop -->
				<div class="degree-deadline-pad bg-primary"></div>

				<!-- Inner content -->
				<div class="degree-deadline-content degree-deadline-content-deadlines">
					<div class="row no-gutters w-100 h-100 d-lg-flex align-items-lg-center">
						<div class="<?php echo $deadline_heading_col_class; ?>">
							<h2 id="application-deadlines-heading" class="h4 text-uppercase font-condensed mb-0">
								<?php echo $heading_text; ?>
							</h2>
						</div>
						<div class="col">
							<div class="row d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-nowrap">

								<?php if ( $deadline_group_names && count( $deadline_group_names ) > 1 ) : ?>
								<div class="col-lg-auto">
									<ul class="nav nav-pills degree-deadline-tab-nav flex-lg-column" id="degree-deadline-tabs" role="tablist">
										<?php
										foreach ( $deadline_group_names as $i => $group_name ) :
											$nav_link_class = 'nav-link';
											if ( $i === 0 ) $nav_link_class .= ' active';

											$nav_link_slug = ( $group_name ) ? 'degree-deadlines--' . sanitize_title( $group_name ) : 'degree-deadlines--all';
										?>
										<li class="nav-item">
											<a class="<?php echo $nav_link_class; ?>"
												id="tab-<?php echo $nav_link_slug; ?>"
												data-toggle="pill"
												href="#<?php echo $nav_link_slug; ?>"
												role="tab"
												aria-controls="<?php echo $nav_link_slug; ?>"
												aria-selected="true">
												<?php echo $group_name; ?>
											</a>
										</li>
										<?php endforeach; ?>
									</ul>
								</div>
								<?php endif; ?>

								<div class="col">
									<div class="tab-content" id="degree-deadlines">
									<?php
									$j = 0;
									foreach ( $deadlines as $group_name => $group ) :
									?>
										<?php
										// Only render a tab pane if more than one group
										// is available (and tab nav is available)
										$wrap_in_pane = ( $group_name && count( $deadline_group_names ) > 1 ) ? true : false;
										if ( $wrap_in_pane ) :
											$tab_pane_class = 'tab-pane fade';
											if ( $j === 0 ) $tab_pane_class .= ' show active';
											$j++;

											$tab_pane_slug = ( $group_name ) ? 'degree-deadlines--' . sanitize_title( $group_name ) : 'degree-deadlines--all';
										?>
										<div class="<?php echo $tab_pane_class; ?>"
											id="<?php echo $tab_pane_slug; ?>"
											role="tabpanel"
											aria-labelledby="tab-<?php echo $tab_pane_slug; ?>">
										<?php endif; ?>

											<dl class="row mb-0">
												<?php foreach ( $group as $deadline ) : ?>
												<div class="col-12 col-sm text-lg-center degree-deadline">
													<dt class="font-weight-normal"><?php echo $deadline['term']; ?></dt>
													<dd class="font-weight-bold"><?php echo $deadline['deadline']; ?></dd>
												</div>
												<?php endforeach; ?>
											</dl>

										<?php if ( $wrap_in_pane ) : ?>
										</div>
										<?php endif; ?>
									<?php endforeach; ?>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="degree-deadline-content degree-deadline-content-start <?php if ( ! $deadline_heading_show_inline ) { ?>degree-deadline-content-start-condensed<?php } ?> text-center text-lg-left bg-gray-darker">
					<div class="row no-gutters d-lg-flex justify-content-lg-center align-self-lg-center">
						<div class="col-12 col-lg-auto align-self-lg-center pr-xl-4">
								<h2 class="h5 text-uppercase font-condensed mb-4 mb-lg-3 <?php if ( $deadline_heading_show_inline ) { ?>mb-xl-0<?php } ?>">
								<span class="d-inline-block <?php if ( $deadline_heading_show_inline ) { ?>d-xl-block<?php } ?>">
									Ready to
								</span>
								<span class="d-inline-block">
									get started?
								</span>
							</h2>
						</div>
						<div class="col-12 col-lg-auto align-self-lg-center">
							<?php
							echo get_degree_apply_button(
								$post,
								'btn btn-lg btn-primary rounded',
								'',
								'Apply Today'
							);
							?>
						</div>
					</div>
				</div>

				<!-- Right-hand surrounding pad, for desktop -->
				<div class="degree-deadline-pad bg-gray-darker"></div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
