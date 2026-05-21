<?php
/**
 * Template Name: Article (Two Column)
 * Template Post Type: page
 */
get_header();
the_post();

$thumbnail = get_the_post_thumbnail(
	$post->ID,
	'large',
	array(
		'class' => 'article-thumbnail img-fluid mb-4'
	)
);

$abstract = get_field( 'abstract', $post->ID );
$sidebar_content = get_field( 'sidebar_content', $post->ID );
$related_degrees = get_field( 'related_degrees', $post->ID );
$related_degrees_heading = get_field( 'related_degrees_heading', $post->ID ) ?: 'Related Degrees';

$main_content_classes = 'col-md-8';

if ( ! $sidebar_content && ! $related_degrees ) {
	$main_content_classes .= ' offset-md-2';
}

?>
<article>
<div class="story-progress sticky-top my-4">
	<div class="progress bg-faded" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
		<div class="progress-bar bg-primary" style="width: 0%;"></div>
	</div>
</div>
<div class="container mb-4">
	<div class="row">
		<div class="<?php echo $main_content_classes; ?>"><!-- Main content column -->
			<?php echo $thumbnail; ?>
			<div class="abstract mb-4"><p><?php echo $abstract; ?></p></div>
			<div class="post-content">
				<?php the_content(); ?>
			</div>
		</div><!-- End main content column -->
		<?php if ( $sidebar_content || $related_degrees ) : ?>
		<div class="col-md-4"><!-- Sidebar column -->
			<?php echo $sidebar_content; ?>
			<?php if ( $related_degrees ) : ?>
			<aside class="card bg-faded mb-4">
				<div class="card-block">
					<h2 class="h4 heading-underline"><?php echo esc_html( $related_degrees_heading ); ?></h2>
					<ul class="list-unstyled">
					<?php foreach ( $related_degrees as $degree ) : ?>
						<li><a href="<?php echo esc_url( get_the_permalink( $degree->ID ) ); ?>"><?php echo esc_html( $degree->post_title ); ?></a></li>
					<?php endforeach; ?>
					</ul>
				</div>
			</aside>
			<?php endif; ?>
		</div><!-- End sidebar column -->
		<?php endif; ?>
	</div>
</div>

<?php $additional_content = get_field( 'additional_content', $post->ID ); ?>
<?php if ( $additional_content ) : ?>
<section class="additional-content">
	<?php echo $additional_content; ?>
</section>
<?php endif; ?>

</article>

<?php
/**
 * FAQs
 */
$faqs = get_field( 'faqs', $post->ID );
$faqs_heading = get_field( 'faqs_heading', $post->ID ) ?: 'Frequently Asked Questions';

if ( $faqs ) {
	add_action( 'wp_footer', function() use ( $faqs ) {
		$schema = array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => array(),
		);

		foreach ( $faqs as $faq ) {
			$schema['mainEntity'][] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $faq['question'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $faq['answer'] ),
				),
			);
		}

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	} );
}
?>

<?php if ( $faqs ) : ?>
<section class="container my-5">
	<h2 class="mb-4"><?php echo esc_html( $faqs_heading ); ?></h2>
	<div class="ucf-faq-list ucf-faq-list-classic">
	<?php foreach ( $faqs as $index => $faq ) :
		$faq_id = 'page-faq-' . $post->ID . '-' . $index;
	?>
	<div class="d-flex mb-4 flex-column">
		<a href="#<?php echo esc_attr( $faq_id ); ?>" class="ucf-faq-question-link collapsed d-flex" data-toggle="collapse" data-target="#<?php echo esc_attr( $faq_id ); ?>" role="button" aria-controls="<?php echo esc_attr( $faq_id ); ?>" aria-expanded="false">
			<div class="ucf-faq-collapse-icon-container mr-2 mr-md-3">
				<span class="ucf-faq-collapse-icon" aria-hidden="true"></span>
			</div>
			<strong class="ucf-faq-question align-self-center mb-0 h5"><?php echo esc_html( $faq['question'] ); ?></strong>
		</a>
		<div class="ucf-faq-topic-answer collapse ml-2 ml-md-3 mt-2" id="<?php echo esc_attr( $faq_id ); ?>">
			<div class="card text-secondary">
				<div class="card-block">
					<?php echo $faq['answer']; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php
/**
 * Related articles
 */
$categories = get_the_category( $post->ID );
$category_ids = wp_list_pluck( $categories, 'term_id' );

$related_args = array(
	'post_type'      => 'page',
	'post__not_in'   => array( $post->ID ),
	'posts_per_page' => 8,
	'orderby'        => 'rand',
	'meta_query'     => array(
		array(
			'key'     => '_wp_page_template',
			'value'   => array( 'template-article.php', 'template-article-two-col.php' ),
			'compare' => 'IN',
		),
	),
);

if ( ! empty( $category_ids ) ) {
	$related_args['category__in'] = $category_ids;
}

$related_stories = get_posts( $related_args );
$related_stories_heading = get_field( 'related_stories_heading', $post->ID ) ?: 'Related Stories';
?>

<?php if ( $related_stories ) : ?>
<aside class="jumbotron py-5 bg-faded mb-0">
	<div class="container">
		<h2 class="mb-4"><?php echo esc_html( $related_stories_heading ); ?></h2>
		<div class="row">
		<?php foreach ( $related_stories as $story ) :
			$story_thumbnail = get_the_post_thumbnail( $story->ID, 'post-thumbnail', array(
				'class' => 'card-img-top img-fluid'
			) );
			$story_title = get_field( 'page_header_title', $story->ID );
			$story_subtitle = get_field( 'page_header_subtitle', $story->ID ) ?? 'Read more...';
			$permalink = get_permalink( $story->ID );
		?>
			<div class="col-6 col-sm-4 col-md-3">
				<article class="card mb-4">
					<?php echo $story_thumbnail; ?>
					<div class="card-block">
						<a class="text-secondary stretched-link" href="<?php echo esc_url( $permalink ); ?>">
							<p class="h5 mb-2"><?php echo $story_title; ?></p>
						</a>
						<?php if ( ! empty( $story_subtitle ) ) : ?>
						<p class="text-muted font-size-sm"><?php echo $story_subtitle; ?></p>
						<?php endif; ?>
					</div>
				</article>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</aside>
<?php endif; ?>

<?php get_footer(); ?>
