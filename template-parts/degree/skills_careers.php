<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' && ! is_supplementary_degree( $post ) ) :
	$fallback_career_content = trim( get_theme_mod_or_default( 'degree_careers_intro' ) );
	$has_careers             = empty( main_site_get_degree_careers( $post ) ) ? false : true;
	$has_skills              = have_rows( 'degree_skills_list', $post );
	$content_part_name       = $has_skills ? 'curated' : '';
	$aria_label              = $has_skills ? 'Skills and Career Opportunities' : 'Career Opportunities';

	$has_content = true;
	if (
		! ( $has_skills || $fallback_career_content )
		|| ! $has_careers
	) {
		$has_content = false;
	}

	if ( $has_content ) :
?>
	<section id="skills-careers" aria-label="<?php echo $aria_label; ?>">
		<div class="jumbotron jumbotron-fluid bg-inverse-t-1 mb-0">
			<div class="container">
				<?php get_template_part( 'template-parts/degree/skills_careers/content', $content_part_name ); ?>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
