<?php get_header(); the_post(); ?>
<?php
	$degree_search = get_permalink( get_page_by_title( 'Degree Search' ) );
	$post_meta = format_raw_postmeta( get_post_meta( $post->ID ) );
	$program_types = wp_get_post_terms( $post->ID, 'program_types' );
	$program_type = is_array( $program_types ) ? $program_types[0] : null;
	$colleges = wp_get_post_terms( $post->ID, 'colleges' );
	$college = is_array( $colleges ) ? $colleges[0] : null;
?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="bg-default p-4 my-4">
				<dl class="row">
					<?php if ( $program_type ) : ?>
					<dt class="col-sm-6">Program:</dt>
					<dd class="col-sm-6"><?php echo $program_type->name; ?></dd>
					<?php endif; ?>
					<?php if ( $college ) : ?>
					<dt class="col-sm-6">College:</dt>
					<dd class="col-sm-6">
						<a class="text-inverse" href="#">
							<?php echo $college->name; ?>
						</a>
					</dd>
					<?php endif; ?>
				</dl>
			</div>
			<div class="content">
				<?php if ( $post->post_content ) : ?>
				<?php the_content(); ?>
				<?php else : ?>
					<p> No degree description </p>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-4">
			
		</div>
	</div>
</div>
<?php get_footer(); ?>
