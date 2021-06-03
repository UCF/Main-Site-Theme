<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$research_display_max = 5;
	$books                = get_field( 'person_books', $post );
	$books_featured       = is_array( $books ) && count( $books ) ? array_slice( $books, 0, $research_display_max ) : array();
	$books_more           = is_array( $books ) && count( $books ) ? array_slice( $books, $research_display_max + 1 ) : array();
	$articles             = get_field( 'person_articles', $post );
	$articles_featured    = is_array( $articles ) && count( $articles ) ? array_slice( $articles, 0, $research_display_max ) : array();
	$articles_more        = is_array( $articles ) && count( $articles ) ? array_slice( $articles, $research_display_max + 1 ) : array();
	$has_research         = $books || $articles;

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
						<div id="published-research-books" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Books</h3>
							<?php foreach ( $books_featured as $book_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $book_featured['book_citation'] ) ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $books_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-books-more">
								<?php foreach ( $books_more as $book_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $book_more['book_citation'] ) ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-books-more" aria-expanded="false" aria-controls="published-research-books-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Book Citations
							</button>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php if ( $articles ) : ?>
						<div id="published-research-articles" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Articles</h3>
							<?php foreach ( $articles_featured as $article_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $article_featured['article_citation'] ) ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $articles_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-articles-more">
								<?php foreach ( $articles_more as $article_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $article_more['article_citation'] ) ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-articles-more" aria-expanded="false" aria-controls="published-research-articles-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Article Citations
							</button>
							<?php endif; ?>
						</div>
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
