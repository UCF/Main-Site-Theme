<?php
/**
 * Template Name: Statements
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php
$statement_details = get_statement_details( get_the_content() );
$statements        = get_statements();
$filters           = get_statement_filters();
?>

<div class="container mt-4 mt-md-5 pb-4 pb-md-5">
	<div class="row">
		<?php if ( $filters ) : ?>
		<div class="col-lg-4 mb-4 mb-lg-0">
			<?php echo $filters; ?>
		</div>
		<div class="col-auto hidden-md-down pr-lg-4">
			<hr class="hr-vertical" role="presentation">
		</div>
		<?php endif; ?>

		<div class="col">
			<?php echo $statement_details; ?>
			<?php echo $statements; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
