<?php
/**
 * Template Name: Area of Focus Article
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>
<article>
<div class="container mb-4">
	<div class="row">
	<?php
	/**
	 * This is the main content section
	 */
	$thumbnail = get_the_post_thumbnail(
		$post->ID,
		'large',
		array(
			'class' => 'article-thumbnail img-fluid mb-4'
		)
	);
	$abstract = get_field( 'abstract', $post->ID );
	?>
	<div class="col-md-8">
		<?php echo $thumbnail; ?>
		<div class="abstract mb-4"><p><?php echo $abstract; ?></p></div>
		<?php the_content(); ?>
	</div>

	<?php
	/**
	 * This is the sidebar section
	 */
	$authors = get_field( 'author', $post->ID );
	$interview = get_field( 'interview', $post->ID );
	$coauthors = get_field( 'co-authors', $post->ID );
	$references = get_field( 'references', $post->ID );

	$undergraduate_programs = get_field( 'related_undergraduate_programs', $post->ID );
	$graduate_programs = get_field( 'related_graduate_programs', $post->ID );

	?>
	<div class="col-md-4">
	<?php if ( $authors ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
			<h2 class="h4 heading-underline">Researchers in Focus</h2>
			<?php if ( $authors ) : ?>
			<h3 class="h6">Authors</h3>
			<?php foreach ($authors as $author) : ?>
				<div class="pl-2">
					<p class="h6"><?php echo $author['name']; ?></p>
					<p class="font-size-sm"><?php echo $author['bio']; ?></p>
				</div>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if ( $references ) : ?>
			<h3 class="h6">References</h3>
			<ol class="references pl-4">
			<?php foreach( $references as $idx => $reference ) : ?>
				<li class="list-item font-size-sm"><?php echo $reference['reference']; ?></li>
			<?php endforeach; ?>
			</ol>
			<?php endif; ?>
		</div>
	</aside>
	<?php endif; ?>

	<?php if ( $interview ) :

		$interviewees = array_filter( $interview, function( $person ) {
			return $person['interviewer'] === false;
		} );

		$interviewers = array_filter( $interview, function( $person ) {
			return $person['interviewer'] === true;
		} );
	?>
	<?php if ( $interviewees ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
		<?php foreach ( $interviewees as $person ) : ?>
		<div class="pl-2">
			<p class="h4"><?php echo $person['name']; ?></p>
			<p class="font-size-sm"><?php echo $person['bio']; ?></p>
		</div>
		<?php endforeach; ?>
		</div>
	</aside>
	<?php endif; ?>

	<?php if ( $interviewers ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
			<h2 class="h4 heading-underline">Interviewers</h2>
			<?php foreach ( $interviewers as $person ) : ?>
			<div class="pl-2">
				<p class="h6"><?php echo $person['name']; ?></p>
				<p class="font-size-sm"><?php echo $person['bio']; ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</aside>
	<?php endif; ?>
	<?php endif; ?>

	<?php if ( $coauthors ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
			<h2 class="h4 heading-underline">Co-Authors</h2>
			<ul class="list-unstyled">
			<?php foreach ( $coauthors as $coauthor ) : ?>
				<li class="list-item mb-4"><?php echo $coauthor['co-author']; ?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</aside>
	<?php endif; ?>

	<?php if ( $undergraduate_programs || $graduate_programs ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
			<h2 class="h4 heading-underline">Related Programs</h2>
		<?php if ( $undergraduate_programs ) : ?>
			<h3 class="h6 text-uppercase">Undergraduate Programs</h3>
			<ul class="list-unstyled pl-4">
			<?php foreach ( $undergraduate_programs as $program ) : ?>
				<li class="list-item">
					<a href="<?php echo get_the_permalink( $program ); ?>"><?php echo $program->post_title; ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ( $graduate_programs ) : ?>
			<h3 class="h6 text-uppercase">Graduate Programs</h3>
			<ul class="list-unstyled pl-4">
			<?php foreach ( $graduate_programs as $program ) : ?>
				<li class="list-item">
					<a href="<?php echo get_the_permalink( $program ); ?>"><?php echo $program->post_title; ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		</div>
	</aside>
	<?php endif; ?>
	</div>
	</div><!-- End .row -->
</div>
<?php
/**
 * Personal Response section
 */
$responses = get_field( 'personal_response', $post->ID );
?>
<?php if ( $responses ) : ?>
<aside>
	<div class="container mb-4">
		<div class="row">
		<?php foreach ( $responses as $response ) : ?>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-inverse">
					<div class="row align-content-center">
						<div class="col-1 col-sm-2 col-lg-1 align-content-center text-center"><i class="fa fa-question-circle fa-2x" aria-hidden="true"></i></div>
						<div class="col"><p class="mb-0"> <?php echo $response['question']; ?></p></div>
					</div>
				</div>
				<div class="card-block">
					<p><?php echo $response['answer']; ?></p>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		</div>
	</div>
</aside>
<?php endif; ?>
</article>

<?php
/**
 * Related stories
 */

$categories = get_the_category( $post->ID );

$args = array(
	'post_type'      => 'page',
	'post__not_in'   => array( $post->ID ),
	'posts_per_page' => 8,
	'orderby'        => 'rand',
	'category_in'    => $categories,
	'meta_key'       => '_wp_page_template',
	'meta_value'     => 'template-article.php'
);

$related_stories = get_posts( $args );

?>
<aside class="jumbotron py-5 bg-faded mb-0">
	<div class="container">
		<div class="row">
		<?php foreach ( $related_stories as $story ) :
			$story_thumbnail = get_the_post_thumbnail( $story->ID, 'post-thumbnail', array(
				'class' => 'card-img-top img-fluid'
			) );
			$story_title = get_field( 'title', $story->ID );
			$story_subtitle = get_field( 'sub_title', $story->ID );
			$excerpt = get_the_excerpt( $story );
			$permalink = get_permalink( $story->ID );
		?>
			<div class="col-6 col-sm-4 col-md-3">
				<article class="card mb-4">
					<?php echo $story_thumbnail; ?>
					<div class="card-block">
						<p class="h5 mb-2"><?php echo $story_title; ?></p>
						<p class="text-default small">
							<a href="<?php echo $permalink; ?>" class="stretched-link">
								<?php echo $story_subtitle; ?>
							</a>
						</p>
					</div>
				</article>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</aside>

<?php get_footer(); ?>
