<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$research = 'TODO';

	if ( $research ) :
?>
	<section id="published-research" aria-labelledby="published-research-heading">
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-8 pr-lg-5">
						<h2 class="font-condensed text-uppercase mb-4" id="pubhlished-research-heading">
							Published Research
						</h2>
						<?php echo $research; ?>
					</div>
					<div class="col-4 col-sm-3 col-lg-4 flex-first flex-lg-last text-lg-center mb-4 mb-lg-0">
						<img class="rounded-circle img-fluid" width="250" height="250" src="https://via.placeholder.com/250x250/" alt="">
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
