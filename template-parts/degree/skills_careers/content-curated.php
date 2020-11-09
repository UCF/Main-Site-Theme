<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$degree_skills_heading  = trim( get_field( 'degree_skills_heading', $post ) ) ?: 'Skills You&rsquo;ll Learn';
	$degree_careers_heading = trim( get_field( 'degree_careers_heading', $post ) ) ?: 'Career Opportunities';
?>
<h2 class="font-condensed text-primary text-uppercase mb-4">
	<?php echo $degree_skills_heading; ?>
</h2>
<div class="row">

	<?php if ( have_rows( 'degree_skills_list', $post ) ) : ?>
	<div class="col-lg-7 py-lg-3">
		<ul class="pl-4 mb-0">
		<?php while ( have_rows( 'degree_skills_list', $post ) ) : the_row(); ?>
			<?php if ( get_sub_field( 'degree_skills_list_item' ) ) : ?>
			<li class="degree-skill-list-item mb-3 mb-lg-4">
				<?php the_sub_field( 'degree_skills_list_item' ); ?>
			</li>
			<?php endif; ?>
		<?php endwhile; ?>
		</ul>
	</div>
	<?php endif; ?>

	<div class="col-lg-4 offset-lg-1 mt-4 mt-lg-0">
		<h2 class="font-condensed h5 text-uppercase mb-4 pt-3">
			<?php echo $degree_careers_heading; ?>
		</h2>

		<?php get_template_part( 'template-parts/degree/skills_careers/careers' ); ?>
	</div>

</div>
<?php
endif;
