<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' && ! is_supplementary_degree( $post ) ) :
	// TODO utilize imported career paths
	// TODO alternate layout when no skills are set

	$degree_skills_heading  = get_field( 'degree_skills_heading', $post );
	$degree_careers_heading = get_field( 'degree_careers_heading', $post );

	if ( ! empty( $degree_skills_heading ) && ! empty( $degree_careers_heading ) ) :
?>
	<section aria-labelledby="skills">
		<div class="jumbotron jumbotron-fluid bg-inverse mb-0">
			<div class="container">
				<div class="row">
					<?php if( $degree_skills_heading ) : ?>
						<div class="col-12">
							<h2 id="skills" class="font-condensed text-primary text-uppercase mb-4"><?php echo $degree_skills_heading; ?></h2>
						</div>
					<?php endif; ?>

					<?php if( have_rows( 'degree_skills_list', $post ) ) : ?>
						<div class="col-lg-7 py-lg-3">
							<ul class="pl-4 mb-0">
								<?php while ( have_rows( 'degree_skills_list', $post ) ) : the_row(); ?>
									<?php if( get_sub_field( 'degree_skills_list_item' ) ) : ?>
										<li class="degree-skill-list-item mb-3 mb-lg-4"><?php the_sub_field( 'degree_skills_list_item' ); ?></li>
									<?php endif; ?>
								<?php endwhile; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php if( $degree_careers_heading ) : ?>
						<div class="col-lg-4 offset-lg-1">
							<?php if( $degree_careers_heading ) : ?>
								<h3 class="font-condensed h5 text-uppercase mb-3 pt-3"><?php echo $degree_careers_heading; ?></h3>
							<?php endif; ?>

							<?php if( have_rows( 'degree_career_list', $post ) ) : ?>
								<div class="col-lg-8 py-lg-3">
									<ul class="degree-career-list pl-2">
										<?php while ( have_rows( 'degree_career_list', $post ) ) : the_row(); ?>
											<?php if( get_sub_field( 'degree_career_list_item' ) ) : ?>
												<li class="degree-career-list-item mb-2"><?php the_sub_field( 'degree_career_list_item' ); ?></li>
											<?php endif; ?>
										<?php endwhile; ?>
									</ul>
								</div>
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
