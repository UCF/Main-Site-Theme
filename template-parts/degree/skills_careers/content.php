<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$degree_careers_heading  = get_field( 'degree_careers_heading', $post ) ?: 'Career Opportunities';
	$fallback_career_content = wptexturize( trim( get_theme_mod_or_default( 'degree_careers_intro' ) ) );
	$careers                 = main_site_get_degree_careers( $post->ID );
?>
<div class="row">
	<div class="col-lg pr-lg-5 pr-xl-3">
		<h2 class="font-condensed text-primary text-uppercase mb-4">
			<?php echo $degree_careers_heading; ?>
		</h2>
		<div class="lead">
			<?php echo $fallback_career_content; ?>
		</div>
	</div>
	<div class="col-lg-6 offset-xl-1 mt-4 mt-lg-0">
		<ul class="degree-career-list pl-3">
			<?php foreach ( $careers as $career ) : ?>
			<li class="degree-career-list-item mb-3">
				<?php echo $career; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php
endif;
