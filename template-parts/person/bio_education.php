<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$biography = 'TODO';
	$education = 'TODO';

	if ( $biography || $education ) :
		$aria_labelledby = '';
		if ( $biography ) $aria_labelledby .= 'biography-heading ';
		if ( $education ) $aria_labelledby .= 'education-heading ';
		$aria_labelledby = trim( $aria_labelledby );

		$left_col_class  = 'col-lg-4 pr-lg-5 pull-lg-8 mt-5 mt-lg-0';
		$right_col_class = 'col-lg-8 push-lg-4';
?>
	<section id="person-description" aria-labelledby="<?php echo $aria_labelledby; ?>">
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<div class="row">
					<?php if ( $biography ) : ?>
					<div class="<?php echo $right_col_class; ?>">
						<h2 id="biography-heading" class="sr-only">Biography</h2>
						<?php echo $biography; ?>
					</div>
					<?php endif; ?>

					<?php
					if ( $education ) :
						$education_col = $biography ? $left_col_class : $right_col_class;
					?>
					<div class="<?php echo $education_col; ?>">
						<h2 class="h6 text-uppercase text-default mb-4" id="education-heading">Education</h2>
						<?php echo $education; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
