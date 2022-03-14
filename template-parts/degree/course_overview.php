<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$course_overview          = get_field( 'course_overview', $post );
	$catalog_desc_full        = trim( get_field( 'degree_description_full', $post ) );
	$course_catalog_link_text = get_field( 'course_catalog_link_text', $post ) ?: 'View all ' . get_header_title( $post ) . ' Courses';

	if ( ! empty ( $course_overview ) && have_rows( 'course_overview', $post ) ) :
?>
	<section id="course-overview" aria-labelledby="course-overview-heading">
		<div class="container py-lg-3 my-5">
			<div class="row my-lg-3">
				<div class="col-12">
					<h2 id="course-overview-heading" class="font-condensed text-uppercase mb-4">Course Overview</h2>
					<div class="accordion" role="tablist" id="courses">

						<?php while ( have_rows( 'course_overview', $post ) ) : the_row(); ?>
						<div class="accordion-courses mt-0 pt-0 pt-lg-3">
							<a class="accordion-course-title text-decoration-none <?php if ( get_row_index() !== 1 ) echo ' collapsed'; ?>"
								data-toggle="collapse" data-target="#course-<?php echo get_row_index(); ?>"
								aria-controls="course-<?php echo get_row_index(); ?>" role="tab" tabindex="0" aria-expanded="true">
								<h3 class="mb-0">
									<span class="font-condensed h6 letter-spacing-2 mb-3 text-uppercase">
										<?php the_sub_field( 'course_title' ); ?>
									</span>
									<span class="course-icon pull-right text-inverse-aw fa" aria-hidden="true"></span>
								</h3>
							</a>
							<div class="collapse<?php if ( get_row_index() === 1 ) echo " show"; ?>"
								id="course-<?php echo get_row_index(); ?>" data-parent="#courses" role="tabpanel">
								<p class="mt-3 mb-0">
									<?php the_sub_field( 'course_description' ); ?>
								</p>
							</div>
						</div>
						<?php endwhile; ?>

					</div>
				</div>
			</div>

			<?php if ( $catalog_desc_full ) : ?>
			<div class="row">
				<div class="col-12 text-right">
					<a class="text-decoration-none hover-text-underline" href="#catalogModal" data-toggle="modal">
						<?php echo $course_catalog_link_text; ?>
						<span class="fa fa-arrow-circle-right" aria-hidden="true"></span>
					</a>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</section>
<?php
	endif;
endif;
