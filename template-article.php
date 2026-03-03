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
	$title = get_field( 'title', $post->ID );
	$subtitle = get_field( 'sub_title', $post->ID );
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
		<h1 class="text-uppercase"><?php echo $title; ?></h1>
		<p class="text-default"><?php echo $subtitle; ?></p>
		<?php echo $thumbnail; ?>
		<div class="abstract mb-4"><p><?php echo $abstract; ?></p></div>
		<?php the_content(); ?>
	</div>

	<?php
	/**
	 * This is the sidebar section
	 */
	$authors = get_field( 'author', $post->ID );
	$coauthors = get_field( 'co-authors', $post->ID );
	$references = get_field( 'references', $post->ID );

	?>
	<div class="col-md-4">
	<?php if ( $authors ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
			<h2 class="h3 heading-underline">Researchers in Focus</h2>
			<?php if ( $authors ) : ?>
			<h3 class="h4">Authors</h3>
			<?php foreach ($authors as $author) : ?>
				<div class="pl-2">
					<p class="h6"><?php echo $author['name']; ?></p>
					<p class="font-size-sm"><?php echo $author['bio']; ?></p>
				</div>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if ( $references ) : ?>
			<h3 class="h4">References</h3>
			<ol class="references pl-4">
			<?php foreach( $references as $idx => $reference ) : ?>
				<li class="list-item font-size-sm"><?php echo $reference['reference']; ?></li>
			<?php endforeach; ?>
			</ol>
			<?php endif; ?>
		</div>
	</aside>
	<?php endif; ?>

	<?php if ( $coauthors ) : ?>
	<aside class="card bg-faded mb-4">
		<div class="card-block">
			<h2 class="h3 heading-underline">Co-Authors</h2>
			<ul class="list-unstyled">
			<?php foreach ( $coauthors as $coauthor ) : ?>
				<li class="list-item mb-4"><?php echo $coauthor['co-author']; ?></li>
			<?php endforeach; ?>
			</ul>
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
</article>

<?php
/**
 * Related stories
 */

$categories = get_the_category( $post->ID );

$args = array(
	'post_type'    => 'page',
	'post__not_in' => array( $post->ID ),
	'category_in'  => $categories
);

$related_stories = get_posts( $args );

?>
<aside class="jumbotron py-5 bg-faded">
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
				<div class="card mb-4">
					<?php echo $story_thumbnail; ?>
					<div class="card-block">
						<h2 class="h5"><?php echo $story_title; ?></h2>
						<p class="text-default small">
							<a href="<?php echo $permalink; ?>" class="stretched-link">
								<?php echo $story_subtitle; ?>
							</a>
						</p>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</aside>

<?php get_footer(); ?>
