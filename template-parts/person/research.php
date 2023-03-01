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
	$chapters             = get_field( 'person_chapters', $post );
	$chapters_featured    = is_array( $chapters ) && count( $chapters ) ? array_slice( $chapters, 0, $research_display_max ) : array();
	$chapters_more        = is_array( $chapters ) && count( $chapters ) ? array_slice( $chapters, $research_display_max + 1 ) : array();
	$proceedings          = get_field( 'person_proceedings', $post );
	$proceedings_featured = is_array( $proceedings ) && count( $proceedings ) ? array_slice( $proceedings, 0, $research_display_max ) : array();
	$proceedings_more     = is_array( $proceedings ) && count( $proceedings ) ? array_slice( $proceedings, $research_display_max + 1 ) : array();
	$grants               = get_field( 'person_grants', $post );
	$grants_featured      = is_array( $grants ) && count( $grants ) ? array_slice( $grants, 0, $research_display_max ) : array();
	$grants_more          = is_array( $grants ) && count( $grants ) ? array_slice( $grants, $research_display_max + 1 ) : array();
	$awards               = get_field( 'person_awards', $post );
	$awards_featured      = is_array( $awards ) && count( $awards ) ? array_slice( $awards, 0, $research_display_max ) : array();
	$awards_more          = is_array( $awards ) && count( $awards ) ? array_slice( $awards, $research_display_max + 1 ) : array();
	$patents              = get_field( 'person_patents', $post );
	$patents_featured     = is_array( $patents ) && count( $patents ) ? array_slice( $patents, 0, $research_display_max ) : array();
	$patents_more         = is_array( $patents ) && count( $patents ) ? array_slice( $patents, $research_display_max + 1 ) : array();
	$trials               = get_field( 'person_trials', $post );
	$trials_featured      = is_array( $trials ) && count( $trials ) ? array_slice( $trials, 0, $research_display_max ) : array();
	$trials_more          = is_array( $trials ) && count( $trials ) ? array_slice( $trials, $research_display_max + 1 ) : array();
	$has_research         = $books || $articles || $chapters || $proceedings || $grants || $awards || $patents || $trials;

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
								<?php echo html_entity_decode( $book_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $book_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $books_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-books-more">
								<?php foreach ( $books_more as $book_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $book_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $book_more ); ?>
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
								<?php echo html_entity_decode( $article_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $article_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $articles_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-articles-more">
								<?php foreach ( $articles_more as $article_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $article_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $article_more ); ?>
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

						<?php if ( $chapters ) : ?>
						<div id="published-research-book-chapters" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Book Chapters</h3>
							<?php foreach ( $chapters_featured as $chapter_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $chapter_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $chapter_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $chapters_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-chapters-more">
								<?php foreach ( $chapters_more as $chapter_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $chapter_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $chapter_more ); ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-chapters-more" aria-expanded="false" aria-controls="published-research-chapters-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Book Chapter Citations
							</button>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php if ( $proceedings ) : ?>
						<div id="published-research-proceedings" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Conference Proceedings</h3>
							<?php foreach ( $proceedings_featured as $proceeding_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $proceeding_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $proceeding_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $proceedings_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-proceedings-more">
								<?php foreach ( $proceedings_more as $proceeding_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $proceeding_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $proceeding_more ); ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-proceedings-more" aria-expanded="false" aria-controls="published-research-proceedings-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Conference Proceedings
							</button>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php if ( $grants ) : ?>
						<div id="published-research-grants" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Grants</h3>
							<?php foreach ( $grants_featured as $grant_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $grant_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $grant_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $grants_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-grants-more">
								<?php foreach ( $grants_more as $grant_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $grant_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $grant_more ); ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-grants-more" aria-expanded="false" aria-controls="published-research-grants-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Grants
							</button>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php if ( $awards ) : ?>
						<div id="published-research-awards" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Honorific Awards</h3>
							<?php foreach ( $awards_featured as $award_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $award_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $award_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $awards_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-awards-more">
								<?php foreach ( $awards_more as $award_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $award_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $award_more ); ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-awards-more" aria-expanded="false" aria-controls="published-research-awards-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Awards
							</button>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php if ( $patents ) : ?>
						<div id="published-research-patents" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Patents</h3>
							<?php foreach ( $patents_featured as $patent_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $patent_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $patent_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $patents_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-patents-more">
								<?php foreach ( $patents_more as $patent_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $patent_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $patent_more ); ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-patents-more" aria-expanded="false" aria-controls="published-research-patents-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Patents
							</button>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php if ( $trials ) : ?>
						<div id="published-research-trials" class="mb-5">
							<h3 class="h5 text-uppercase mb-3">Clinical Trials</h3>
							<?php foreach ( $trials_featured as $trial_featured ) : ?>
							<p class="research-citation">
								<?php echo html_entity_decode( $trial_featured['citation'] ) ?>
								<?php echo get_additional_contributors_markup( $trial_featured ); ?>
							</p>
							<?php endforeach; ?>

							<?php if ( $trials_more ) : ?>
							<div class="research-citations-more collapse" id="published-research-trials-more">
								<?php foreach ( $trials_more as $trial_more ) : ?>
								<p class="research-citation">
									<?php echo html_entity_decode( $trial_more['citation'] ) ?>
									<?php echo get_additional_contributors_markup( $trial_more ); ?>
								</p>
								<?php endforeach; ?>
							</div>

							<button class="research-citations-expand btn btn-outline-primary mt-3" data-toggle="collapse" data-target="#published-research-trials-more" aria-expanded="false" aria-controls="published-research-trials-more">
								<span class="research-citations-expand-text-show">
									<span class="fa fa-plus-circle fa-lg mr-2"></span>
									Show All
								</span>
								<span class="research-citations-expand-text-hide">
									<span class="fa fa-minus-circle fa-lg mr-2"></span>
									Collapse
								</span>
								Clinical Trials
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
