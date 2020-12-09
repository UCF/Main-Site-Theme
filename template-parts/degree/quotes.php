<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	if ( have_rows( 'degree_quotes', $post ) ) :
?>
	<section id="quotes" aria-label="Quotes/Testimonials">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0">
			<div class="container">
				<?php while ( have_rows( 'degree_quotes', $post ) ) : the_row(); ?>
					<div class="row">
						<?php if( get_sub_field( 'degree_quote_image' ) ) : ?>
							<div class="col-lg-3 text-center text-lg-right align-self-center">
								<img src="<?php the_sub_field( 'degree_quote_image' ); ?>" class="img-fluid"
									alt="<?php the_sub_field( 'degree_quote_image_alt' ); ?>">
							</div>
						<?php endif; ?>
						<?php $quote_col_class = ( get_sub_field( 'degree_quote_image' ) ) ? "col-lg-9" : "col-12 col-xl-10 offset-xl-1"; ?>
						<div class="<?php echo $quote_col_class; ?>">
							<blockquote class="blockquote blockquote-quotation">
								<p class="mb-0"><?php the_sub_field( 'degree_quote' ); ?></p>
								<footer class="blockquote-footer"><?php the_sub_field( 'degree_quote_footer' ); ?></footer>
							</blockquote>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
