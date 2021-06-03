<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$books        = get_field( 'person_books', $post );
	$articles     = get_field( 'person_articles', $post );
	$has_research = $books || $articles;

	if ( $has_research ) :
		$img_id = get_theme_mod( 'published_research_image' );
		$img = $img_id ? wp_get_attachment_image(
			$img_id,
			null,
			false,
			array(
				'class' => 'img-fluid'
			)
		) : '';
?>
	<section id="published-research" aria-labelledby="published-research-heading">
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="font-condensed text-uppercase mb-5" id="published-research-heading">
							Published Research
						</h2>
					</div>
					<div class="col-12 col-lg-8 pr-lg-5">
						<?php if ( $books ) : ?>
						<h3 class="h5 text-uppercase mb-3">Books</h3>
						<ul class="research-citations-list mb-5">
							<?php foreach ( $books as $book ) : ?>
							<li>
								<?php echo html_entity_decode( $book['book_citation'] ) ?>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>

						<?php if ( $articles ) : ?>
						<h3 class="h5 text-uppercase mb-3">Articles</h3>
						<ul class="research-citations-list mb-5">
							<?php foreach ( $articles as $article ) : ?>
							<li>
								<?php echo html_entity_decode( $article['article_citation'] ); ?>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>

					<?php if ( $img ) : ?>
					<div class="col-4 col-sm-3 col-lg-4 flex-first flex-lg-last text-lg-center mb-4 mb-lg-0">
						<?php echo $img; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
