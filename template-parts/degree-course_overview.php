<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$raw_postmeta             = get_post_meta( $post->ID );
	$post_meta                = format_raw_postmeta( $raw_postmeta );

	$course_overview          = get_field( 'course_overview', $post );
	$course_catalog_link_text = get_field( 'course_catalog_link_text', $post );

	if ( ! empty ( $course_overview ) && have_rows( 'course_overview', $post ) ) :
?>
	<section aria-label="Course Overview">
		<div class="container py-lg-3 my-5">
			<div class="row my-lg-3">
				<div class="col-12">
					<h2 class="font-condensed text-uppercase mb-4">Course Overview</h2>
					<div class="accordion" role="tablist" id="courses">
						<?php while ( have_rows( 'course_overview', $post ) ) : the_row(); ?>
							<div class="accordion-courses mt-0 pt-0 pt-lg-3">
								<a <?php if ( get_row_index() !== 1 ) echo 'class="collapsed"' ?>
									data-toggle="collapse" data-target="#course-<?php echo get_row_index(); ?>"
									aria-controls="course-<?php echo get_row_index(); ?>" role="button" tabindex="0" aria-expanded="true">
									<h3 class="mb-0">
										<span class="font-condensed h6 letter-spacing-2 mb-3 text-uppercase">
											<?php the_sub_field( 'course_title' ); ?>
										</span>
										<span class="course-icon pull-right text-inverse-aw fa" aria-hidden="true"></span>
									</h3>
								</a>
								<div class="collapse<?php if ( get_row_index() === 1 ) echo " show" ?>"
									id="course-<?php echo get_row_index(); ?>" data-parent="#courses" role="tabpanel" aria-expanded="true">
									<p class="mt-3 mb-0"><?php the_sub_field( 'course_description' ); ?></p>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
			<?php if( ! empty( $post_meta['degree_pdf'] ) ) : ?>
				<div class="row">
					<div class="col-12 text-right">

					<a href="<?php echo $post_meta['degree_pdf']; ?>" rel="nofollow">
						<?php
						if( $course_catalog_link_text ) :
							echo $course_catalog_link_text;
							?>
							<span class="fa fa-arrow-circle-right" aria-hidden="true"></span>
							<?php
						else :
						?>
							View all <?php echo get_header_title( $post ); ?> Courses
							<span class="fa fa-arrow-circle-right" aria-hidden="true"></span>
						<?php endif; ?>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php
	endif;
endif;
