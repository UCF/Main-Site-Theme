<?php
/**
 * Template Name: Area of Focus Article
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>
<div class="container">
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
	$references = get_field( 'references', $post->ID );

	?>
	<div class="col-md-4">
	<?php if ( $authors ) : ?>
	<aside class="card">
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
	</div>
	</div><!-- End .row -->
</div>

<?php get_footer(); ?>
