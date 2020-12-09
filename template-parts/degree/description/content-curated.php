<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$description_heading = get_field( 'modern_description_heading', $post );
	$description         = trim( get_field( 'modern_description_copy', $post ) );
	$subplans            = array();
	$show_subplans       = get_field( 'show_subplan_list', $post );
	if ( $show_subplans ) {
		$subplans            = get_children( array(
			'post_parent' => $post->ID,
			'post_type'   => 'degree',
			'numberposts' => -1,
			'post_status' => 'publish'
		) );
	}

	if ( $description ) :
?>
	<div class="col py-lg-3 my-4 my-sm-5">
		<?php if ( $description_heading ) : ?>
		<h2 class="font-weight-light mb-4">
			<?php echo $description_heading; ?>
		</h2>
		<?php endif; ?>

		<?php echo $description; ?>

		<?php if ( $show_subplans && $subplans ) : ?>
		<ul class="list-unstyled mt-4">
			<?php
			foreach ( $subplans as $subplan ) :
				$subplan_name    = get_field( 'degree_name_short', $subplan ) ?: $subplan->post_title;
				$subplan_excerpt = trim( get_the_excerpt( $subplan ) );
			?>
			<li class="mb-3">
				<a class="font-weight-bold" href="<?php echo get_permalink( $subplan ); ?>">
					<?php echo $subplan_name; ?>
				</a>

				<?php if ( $subplan_excerpt ) : ?>
				<div class="mt-2">
					<?php echo $subplan_excerpt; ?>
				</div>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

		<?php
		echo get_degree_request_info_button(
			$post,
			'btn btn-complementary mt-3',
			'',
			'Request Information'
		);
		?>
	</div>
<?php
	endif;
endif;
