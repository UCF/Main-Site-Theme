<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$limit   = have_rows( 'degree_skills_list', $post ) ? 10 : 20;
	$careers = main_site_get_degree_careers( $post, $limit );
?>
<div class="degree-careers" id="career-opportunities-list">
	<ul class="degree-career-list">
		<?php foreach ( $careers as $career ) : ?>
		<li class="degree-career-list-item">
			<?php echo $career; ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<a class="degree-careers-expand btn btn-outline-inverse" href="#career-opportunities-list">
		Show More
		<span class="sr-only">Career Opportunities</span>
	</a>
</div>
<?php
endif;
