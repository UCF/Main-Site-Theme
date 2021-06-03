<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$books                = get_field( 'person_books', $post );
	$articles             = get_field( 'person_articles', $post );
	$research_display_max = 5;
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
							<?php
							for ( $i = 0; $i < $research_display_max; $i++ ) :
								if ( isset( $books[$i]['book_citation'] ) ) :
							?>
							<p class="research-citation">
								<?php echo html_entity_decode( $books[$i]['book_citation'] ) ?>
							</p>
							<?php
								endif;
							endfor;
							?>

							<?php if ( count( $books ) > $research_display_max ) : ?>
							<div class="research-citations-more collapse" id="published-research-books-more">
								<?php for ( $i = $research_display_max; $i < count( $books ); $i++ ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $books[$i]['book_citation'] ) ?>
								</p>
								<?php endfor; ?>
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
							<?php
							for ( $i = 0; $i < $research_display_max; $i++ ) :
								if ( isset( $articles[$i]['article_citation'] ) ) :
							?>
							<p class="research-citation">
								<?php echo html_entity_decode( $articles[$i]['article_citation'] ) ?>
							</p>
							<?php
								endif;
							endfor;
							?>

							<?php if ( count( $articles ) > $research_display_max ) : ?>
							<div class="research-citations-more collapse" id="published-research-articles-more">
								<?php for ( $i = $research_display_max; $i < count( $articles ); $i++ ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $articles[$i]['article_citation'] ) ?>
								</p>
								<?php endfor; ?>
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
